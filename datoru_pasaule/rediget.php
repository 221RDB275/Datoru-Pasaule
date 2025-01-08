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

$user_query = "SELECT id FROM users WHERE email = '$email'";
$user_result = mysqli_query($connection, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['id'];

$message = "";

if (!isset($_GET['id'])) {
    echo "<p>Kļūda: Konfigurācijas ID nav norādīts.</p>";
    echo '<a href="profils.php">Atgriezties uz profilu</a>';
    exit();
}

$config_id = (int)$_GET['id'];

$config_query = "SELECT * FROM user_configurations WHERE id = $config_id AND user_id = $user_id";
$config_result = mysqli_query($connection, $config_query);

if (mysqli_num_rows($config_result) === 0) {
    echo "<p>Kļūda: Konfigurācija nav atrasta.</p>";
    echo '<a href="profils.php">Atgriezties uz profilu</a>';
    exit();
}

$config = mysqli_fetch_assoc($config_result);

if (isset($_POST['update_configuration_name'])) {
    $new_configuration_name = mysqli_real_escape_string($connection, $_POST['configuration_name']);
    $update_query = "UPDATE user_configurations SET configuration_name = '$new_configuration_name' WHERE id = $config_id";
    if (mysqli_query($connection, $update_query)) {
        $final_configuration_name = $new_configuration_name;
        header("Location: rediget.php?id=$config_id");
    } else {
        echo "<p style='color: red;'>Kļūda, atjauninot vārdu: " . mysqli_error($connection) . "</p>";
    }
}

function getComponent($connection, $component_id) {
    if ($component_id === NULL) return null;

    $query = "SELECT id, name, type, price FROM components WHERE id = $component_id";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
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

$total_price = 0;
foreach ($components as $component) {
    if ($component) {
        $total_price += $component['price'];
    }
}

$config_update_query = "UPDATE user_configurations SET total_price = $total_price WHERE id = $config_id AND user_id = $user_id";
mysqli_query($connection, $config_update_query);

if (isset($_GET['replace'])) {
    $component_id = (int)$_GET['replace'];
    $component_type = $_GET['type'];

    switch ($component_type) {
        case 'Procesors':
            $field_name = 'cpu_id';
            break;
        case 'Video karte':
            $field_name = 'gpu_id';
            break;
        case 'Operatīvā atmiņa':
            $field_name = 'ram_id';
            break;
        case 'Barošanas bloks':
            $field_name = 'psu_id';
            break;
        case 'Cietais disks':
            $field_name = 'disc_id';
            break;
        case 'Pamatplate':
            $field_name = 'motherboard_id';
            break;
        case 'Datora korpuss':
            $field_name = 'case_id';
            break;
        default:
            $field_name = null;
            break;
    }

    if ($field_name) {
        $config_update_query = "UPDATE user_configurations SET $field_name = $component_id WHERE id = $config_id AND user_id = $user_id";

        if (mysqli_query($connection, $config_update_query)) {
            $total_price = 0;
            foreach ($components as $component) {
                if ($component) {
                    $total_price += $component['price'];
                }
            }
            $config_update_price_query = "UPDATE user_configurations SET total_price = $total_price WHERE id = $config_id AND user_id = $user_id";
            mysqli_query($connection, $config_update_price_query);

            if (!isset($_GET['redirected'])){
                header("Location: katalogs.php?replace=$component_id&type=$component_type&id=$config_id&from=rediget");
                exit();
            }
            header("Location: rediget.php?id=$config_id");
            exit();

        } else {
            echo "<p>Kļūda, mēģinot atjaunināt konfigurāciju.</p>";
        }
    } else {
        echo "<p>Kļūda: Nepareizs komponentes veids.</p>";
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rediģēt konfigurāciju</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        h2, h3, p {
            text-align: center;
        }
        .filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .komponentes {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .komponente {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            width: 23%;
            box-sizing: border-box;
        }
        .configuration {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ccc;
            width: 80%;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        .configuration ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }
        .configuration li {
            margin-bottom: 10px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 18px;
            width: 80%;
            max-width: 500px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php izvelne(); ?>

    <div class="configuration">
        <h2 style="font-size: 30px;">Rediģēt konfigurāciju</h2>
        <h3 style="font-size: 25px">Izvēlētās komponentes:</h3>
        <ul>
            <?php foreach ($components as $type => $component) { ?>
                <li>
                    <strong><?php echo htmlspecialchars($type); ?>:</strong>
                    <?php if ($component) { ?>
                        <?php echo htmlspecialchars($component['name']); ?> 
                        (<?php echo htmlspecialchars($component['price']); ?> €)
                        <a href="rediget.php?replace=<?php echo $component['id']; ?>&type=<?php echo $type; ?>&id=<?php echo $config_id; ?>">
                            <button>Aizstāt</button>
                        </a>
                    <?php } else { ?>
                        Nav pievienots
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>

        <h3>Kopējā cena: <?php echo $total_price; ?> €</h3>
        
        <form method="POST">
                <label for="name">Konfigurācijas nosaukums:</label>
                <input type="text" name="configuration_name" placeholder="Ievadiet konfigurācijas nosaukumu" value="<?php echo htmlspecialchars($config['configuration_name']); ?>" required>
                <button type="submit" name="update_configuration_name">Saglabāt nosaukumu</button>
        </form>
        <form action="profils.php" method="get">
            <button type="submit" class="back-button">Atgriezties uz profilu</button>
        </form>

    </div>
</body>
</html>