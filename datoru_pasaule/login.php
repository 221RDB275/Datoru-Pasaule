<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

$error_msg = '';

if (isset($_COOKIE['ID_my_site']) && isset($_COOKIE['Key_my_site'])) {
    $name = $_COOKIE['ID_my_site'];
    $pass = $_COOKIE['Key_my_site'];

    $query = "SELECT password, role FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        if ($user && $pass === $user['password']) {
            $_SESSION['email'] = $name;
            $_SESSION['role'] = $user['role'];
            header("Location: sakumlapa.php");
            exit();
        }
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['pass'];

    if (empty($email) || empty($password)) {
        $error_msg = 'Lūdzu, aizpildiet visus laukus!';
    } else {
        $query = "SELECT password, role FROM users WHERE email = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            $error_msg = 'Datubāzes pieprasījuma kļūda: ' . mysqli_error($connection);
        }

        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            if (isset($_POST['remember'])) {
                setcookie("ID_my_site", $email, time() + 30 * 24 * 60 * 60, "/");
                setcookie("Key_my_site", $user['password'], time() + 30 * 24 * 60 * 60, "/");
            }

            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];
            header("Location: sakumlapa.php");
            exit();
        } else {
            $error_msg = 'Nepareiza parole vai e-pasts. Lūdzu, mēģiniet vēlreiz!';
        }
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pieslēgties</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
       .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .form-container label {
            font-weight: bold;
        }
        .form-container input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-container input[type="checkbox"] {
            width: auto;
            margin-left: 0;
        }
        .form-container input[type="submit"] {
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: darkgreen;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
        .link-container {
            text-align: center;
            margin-top: 10px;
        }
        .link-container a {
            color: blue;
            text-decoration: none;
        }
        .link-container a:hover {
            text-decoration: underline;
        } 
    </style>
</head>
<body>
    <?php izvelne(); ?>
    <div class="container">
        <h1 style="font-size: 30px;">Pieslēgties</h1>
        <?php if (!empty($error_msg)): ?>
            <div class="error-message">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>
        <form class="form-container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="email">E-pasts:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($error_msg) ? '' : $_POST['email']; ?>" required>
            
            <label for="pass">Parole:</label>
            <input type="password" id="pass" name="pass" required>
            
            <label>
                <input type="checkbox" name="remember"> Atcerēties mani
            </label>
            
            <input type="submit" name="submit" value="Ienākt">
        </form>
        <div class="link-container">
            <p>Vēl neesat reģistrējies? <a href="register.php">Reģistrēties</a></p>
        </div>
    </div>
</body>
</html>