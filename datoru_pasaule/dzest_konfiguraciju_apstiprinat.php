<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<p>Kļūda: Konfigurācijas ID nav norādīts.</p>";
    exit();
}

$config_id = (int)$_GET['id'];

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

$config_query = "
    SELECT * 
    FROM user_configurations uc
    JOIN users u ON uc.user_id = u.id
    WHERE uc.id = $config_id AND u.email = '" . $_SESSION['email'] . "'
";
$config_result = mysqli_query($connection, $config_query);

if (mysqli_num_rows($config_result) === 0) {
    echo "<p>Kļūda: Konfigurācija nav atrasta.</p>";
    exit();
}

$config = mysqli_fetch_assoc($config_result);
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apstiprināt dzēšanu</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            text-align: center;
        }
        .button {
            display: block;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .button a {
            display: inline-block;
            padding: 10px;
            font-size: 14px;
            text-decoration: none;
            color: #333;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php izvelne(); ?>

    <div class="container">
        <h3>Vai tiešām vēlaties dzēst šo konfigurāciju?</h3>
        
        <div class="button">
            <a href="dzest_konfiguraciju.php?id=<?php echo $config_id; ?>">Dzēst</a>
            <a href="liet_konfiguracija.php?id=<?php echo $config_id; ?>">Atcelt</a>
        </div>
    </div>
</body>
</html>