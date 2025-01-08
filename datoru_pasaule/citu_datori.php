<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'guest';
}

if (isset($_POST['action']) && isset($_POST['configuration_id']) && $_SESSION['role'] === 'admin') {
    $configuration_id = (int)$_POST['configuration_id'];
    
    if ($_POST['action'] == 'make_hidden') {
        $update_query = "UPDATE user_configurations SET is_public = 0 WHERE id = $configuration_id";
        mysqli_query($connection, $update_query);
    }
}

$config_query = "SELECT uc.id, uc.configuration_name, uc.image_url_id, u.name AS user_name 
                 FROM user_configurations uc 
                 JOIN users u ON uc.user_id = u.id 
                 WHERE uc.is_public = 1";
$config_result = mysqli_query($connection, $config_query);


?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citu konfigurācijas</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        .configurations-container {
            width: 55%;
            margin: auto;
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            text-align: center;
        }
        .configurations-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .configurations {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }
        .configuration {
            width: calc(25% - 5px);
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 5px;
        }
        .configuration img {
            width: 100%;                
            height: 200px;              
            object-fit: contain;        
            border-radius: 10px;        
            margin-bottom: 10px;        
        }
        .configuration p {
            margin: 0;
        }
        .configuration .user-name {
            font-size: 14px;
            color: #555;
        }
        .remove-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            text-align: center;

        }
        .remove-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <?php izvelne(); ?>

    <div class="configurations-container">
        <div class="configurations-header">
            <h1 style = "font-size: 30px">Citu lietotāju konfigurācijas</h1>
        </div>

        <div class="configurations">
            <?php while ($config = mysqli_fetch_assoc($config_result)) { ?>
                <div class="configuration">
                    <a href="citu_datori_info.php?id=<?php echo $config['id']; ?>">
                        <img src="<?php echo htmlspecialchars($config['image_url_id']); ?>" alt="Konfigurācijas attēls">
                        <p><?php echo htmlspecialchars($config['configuration_name']); ?></p>
                    </a>
                    <p class="user-name">Publicējis: <?php echo htmlspecialchars($config['user_name']); ?></p>
                    <?php if ($_SESSION['role'] === 'admin') { ?>
                        <form method="POST" action="citu_datori.php">
                            <input type="hidden" name="configuration_id" value="<?php echo $config['id']; ?>">
                            <button type="submit" name="action" value="make_hidden" class="remove-btn">Noņemt</button>
                        </form>
                    <?php } ?>
                </div>                
            <?php } ?>
        </div>
    </div>
</body>
</html>