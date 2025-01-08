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

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $password_confirm = $_POST['pass_confirm'];

    if (!$_POST['name'] || !$_POST['email'] || !$_POST['pass'] || !$_POST['pass_confirm']) {
        $error_msg = 'Lūdzu, aizpildiet visus laukus!';
    }

    if ($password !== $password_confirm) {
        $error_msg = 'Paroles nesakrīt!';
    }

    if (!preg_match("/^[0-9a-z_]+@[0-9a-z_]+\.[a-z]{2,3}$/i", $email)) {
        $error_msg = 'Nepareizs e-pasta formāts';
    }

    if (strlen($password) < 8) {
        $error_msg = 'Parolei jābūt vismaz 8 rakstzīmēm garai!';
    }

    if (empty($error_msg)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT * FROM users WHERE email = '$email' OR name = '$name'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $existing_user = mysqli_fetch_assoc($result);
            if ($existing_user['email'] === $email) {
                $error_msg = 'Lietotājs ar šo e-pastu jau pastāv!';
            } elseif ($existing_user['name'] === $name) {
                $error_msg = 'Lietotājs ar šo vārdu jau pastāv!';
            }
        } else {
            $insert_query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            if (mysqli_query($connection, $insert_query)) {
                setcookie("ID_my_site", $email, time() + 30 * 24 * 60 * 60, "/");
                setcookie("Key_my_site", $hashed_password, time() + 30 * 24 * 60 * 60, "/");
                $_SESSION['email'] = $email;
                header("Location: sakumlapa.php");
                exit();
            } else {
                $error_msg = 'Neizdevās reģistrēt lietotāju: ' . mysqli_error($connection);
            }
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
    <title>Reģistrēties</title>
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
        <h1 style="font-size: 30px;">Reģistrēties</h1>
        <?php if (!empty($error_msg)): ?>
            <div class="error-message">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>
        <form class="form-container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="name">Vārds:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($error_msg) ? '' : $_POST['name']; ?>" required>
            
            <label for="email">E-pasts:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($error_msg) ? '' : $_POST['email']; ?>" required>
            
            <label for="pass">Parole (Parolei ir jābūt vismaz 8 rakstzīmēm garai!):</label>
            <input type="password" id="pass" name="pass" required>
            
            <label for="pass_confirm">Atkārtot paroli:</label>
            <input type="password" id="pass_confirm" name="pass_confirm" required>
            
            <input type="submit" name="submit" value="Reģistrēties">
        </form>
        <div class="link-container">
            <p>Konts jau ir izveidots? <a href="login.php">Pieslēgties</a></p>
        </div>
    </div>
</body>
</html>