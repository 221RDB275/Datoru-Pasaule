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

if (!isset($_GET['id'])) {
    $message = "<p style='color: red;'>Kļūda: Konfigurācijas ID nav norādīts.</p>";
    echo '<a href="profils.php">Atgriezties uz profilu</a>';
    exit();
}

$config_id = (int)$_GET['id'];
$email = $_SESSION['email'];
$message = "";

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

function getComponent($connection, $component_id) {
    if ($component_id === NULL) return null;

    $query = "SELECT name, type, price FROM components WHERE id = $component_id";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

$config_query = "SELECT * FROM user_configurations WHERE id = $config_id";
$config_result = mysqli_query($connection, $config_query);

if (mysqli_num_rows($config_result) === 0) {
    $message = "<p style='color: red;'>Kļūda: Konfigurācija nav atrasta.</p>";
    echo '<a href="profils.php">Atgriezties uz profilu</a>';
    exit();
}

$config = mysqli_fetch_assoc($config_result);

if (isset($_POST['publish_configuration'])) {
    if ($config['is_public'] == 1) {
        $update_query = "UPDATE user_configurations SET is_public = 0 WHERE id = $config_id";
        mysqli_query($connection, $update_query);
        $message = "<p>Konfigurācija ir noņemta no publiskā skatījuma!</p>";
    } else {
        $update_query = "UPDATE user_configurations SET is_public = 1 WHERE id = $config_id";
        mysqli_query($connection, $update_query);
        $message = "<p>Konfigurācija ir publicēta!</p>";
    }
    header ("Location: liet_konfiguracija.php?id=$config_id");
}

$cpu = getComponent($connection, $config['cpu_id']);
$gpu = getComponent($connection, $config['gpu_id']);
$ram = getComponent($connection, $config['ram_id']);
$psu = getComponent($connection, $config['psu_id']);
$storage = getComponent($connection, $config['disc_id']);
$motherboard = getComponent($connection, $config['motherboard_id']);
$case = getComponent($connection, $config['case_id']);

$components = [
    'Procesors' => $cpu,
    'Video karte' => $gpu,
    'Pamatplate' => $motherboard,
    'Operatīvā atmiņa' => $ram,
    'Cietais disks' => $storage,
    'Barošanas bloks' => $psu,
    'Datora korpuss' => $case,
];

mysqli_close($connection);

$image_url = $config['image_url_id'];
$total_price = $config['total_price'];
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfigurācijas detaļas</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        h3 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
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
        <h3 style="font-size: 30px;">Konfigurācijas detaļas</h3>
        <ul>
            <?php foreach ($components as $type => $component) { ?>
                <li>
                    <strong><?php echo htmlspecialchars($type); ?>:</strong>
                    <?php if ($component) { ?>
                        <?php echo htmlspecialchars($component['name']); ?> 
                        (<?php echo htmlspecialchars($component['price']); ?> €)
                    <?php } else { ?>
                        Nav pievienots
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>

        <div>
            <img src="<?php echo htmlspecialchars($config['image_url_id']); ?>" alt="Datora korpuss" style="max-width: 200px; display: block; margin: 0 auto;">
        </div>

        <div>
            <h4 style="text-align: center;">Kopējā cena: <?php echo htmlspecialchars($config['total_price']); ?> €</h4>
        </div>

        <div class="button">
            <form action="dzest_konfiguraciju_apstiprinat.php" method="GET" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $config_id; ?>" />
                <button type="submit" class="button-action";>Dzēst</button>
            </form>

            <form action="rediget.php" method="GET" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $config_id; ?>" />
                <button type="submit" class="button-action">Rediģēt</button>
            </form>

            <form method="POST" style="display:inline;">
                <?php if ($config['is_public'] == 1) { ?>
                    <button type="submit" name="publish_configuration">Noņemt no publiskošanas</button>
                <?php } else { ?>
                    <button type="submit" name="publish_configuration">Publiskot</button>
                <?php }?>
            </form>

            <form action="profils.php" method="GET" style="display:inline;">
                <button type="submit" class="button-action">Atgriezties uz profilu</button>
            </form>
        </div>
        <?php echo $message; ?>
    </div>
</body>
</html>