<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$message = "";

$user_query = "SELECT id, name FROM users WHERE email = '$email'";
$user_result = mysqli_query($connection, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['id'];
$user_name = $user_data['name'];

if (isset($_POST['update_name'])) {
    $new_name = mysqli_real_escape_string($connection, $_POST['name']);
    $check_query = "SELECT id FROM users WHERE name = '$new_name' AND id != $user_id";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "<p style='color: red;'>Šāds lietotāja vārds jau eksistē. Lūdzu, izvēlieties citu vārdu!</p>";
    } else {
        $update_query = "UPDATE users SET name = '$new_name' WHERE id = $user_id";
        if (mysqli_query($connection, $update_query)) {
            $user_name = $new_name;
            $message = "<p style='color: green;'>Vārds veiksmīgi nomainīts!</p>";
        } else {
            $message = "<p style='color: red;'>Kļūda, atjauninot vārdu: " . mysqli_error($connection) . "</p>";
        }
    }
}

$config_query = "SELECT * FROM user_configurations WHERE user_id = $user_id";
$config_result = mysqli_query($connection, $config_query);
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profils</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        .profile-container {
            width: 80%;
            margin: auto;
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .configurations {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .configuration {
            width: calc(25% - 20px);
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .configuration img {
            width: 100%;        
            height: 200px;      
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .profile-actions {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php izvelne(); ?>

    <div class="profile-container">
        <div class="profile-header">
            <h2 style="font-size: 30px;">Mans profils</h2>
            <form method="POST">
                <label for="name">Lietotāja vārds:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user_name); ?>" required>
                <button type="submit" name="update_name">Saglabāt</button>
            </form>
        </div>

        <?php echo $message; ?>

        <h3 style="font-size: 30px;">Manas konfigurācijas</h3>
        <div class="configurations">
            <?php while ($config = mysqli_fetch_assoc($config_result)) { ?>
                <div class="configuration">
                    <a href="liet_konfiguracija.php?id=<?php echo $config['id']; ?>">
                        <img src="<?php echo htmlspecialchars($config['image_url_id']); ?>" alt="Konfigurācijas attēls">
                        <p><?php echo htmlspecialchars($config['configuration_name']); ?></p>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>