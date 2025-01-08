<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

$query = "SELECT DISTINCT type FROM components";
$category_result = mysqli_query($connection, $query);

$user_query = "SELECT id FROM users WHERE email = '$email'";
$user_result = mysqli_query($connection, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['id'];

$message = "";

if (isset($_GET['add'])) {
    $component_id = (int)$_GET['add'];

    $check_query = "SELECT * FROM components WHERE id = $component_id";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $component_to_add = mysqli_fetch_assoc($check_result);

        $is_category_added = false;
        if (isset($_SESSION['configuration'])) {
            foreach ($_SESSION['configuration'] as $component) {
                if ($component['type'] == $component_to_add['type']) {
                    $is_category_added = true;
                    break;
                }
            }
        }
        if (!$is_category_added) {
            $_SESSION['configuration'][] = $component_to_add;
        
        }
    }
}

if (isset($_GET['remove'])) {
    $component_id = (int)$_GET['remove'];
    if (isset($_SESSION['configuration'])) {
        foreach ($_SESSION['configuration'] as $key => $component) {
            if ($component['id'] == $component_id) {
                unset($_SESSION['configuration'][$key]);
                break;
            }
        }
    }
}

if (isset($_POST['save_configuration'])) {
    $config_name = mysqli_real_escape_string($connection, $_POST['config_name']);
    $total_price = 0;
    $components_ids = array();

    $cpu_id = $gpu_id = $motherboard_id = $ram_id = $disc_id = $psu_id = $case_id = NULL;

    if (isset($_SESSION['configuration'])) {
        foreach ($_SESSION['configuration'] as $component) {
            $total_price += $component['price'];
            $components_ids[] = $component['id'];

            switch ($component['type']) {
                case 'Procesors':
                    $cpu_id = $component['id'];
                    break;
                case 'Video karte':
                    $gpu_id = $component['id'];
                    break;
                case 'Pamatplate':
                    $motherboard_id = $component['id'];
                    break;
                case 'Operatīvā atmiņa':
                    $ram_id = $component['id'];
                    break;
                case 'Cietais disks':
                    $disc_id = $component['id'];
                    break;
                case 'Barošanas bloks':
                    $psu_id = $component['id'];
                    break;
                case 'Datora korpuss':
                    $case_id = $component['id'];
                    $case_url = $component['image_url'];
                    break;
                default:
                    break;
            }
        }

        if (count($components_ids) < 7) {
            $message = "<p style='color: red;'>Ne visi komponenti ir izvēlēti. Lūdzu, pievienojiet visus nepieciešamos komponentus.</p>";
        } else {
            $save_query = "INSERT INTO user_configurations 
                           (user_id, cpu_id, gpu_id, motherboard_id, ram_id, disc_id, psu_id, case_id, total_price, image_url_id, configuration_name) 
                           VALUES 
                           ('$user_id', 
                            '$cpu_id', '$gpu_id', '$motherboard_id', '$ram_id', 
                            '$disc_id', '$psu_id', '$case_id', 
                            '$total_price', '$case_url', '$config_name')";
            if (mysqli_query($connection, $save_query)) {
                $message = "<p style='color: green;'>Konfigurācija saglabāta veiksmīgi!</p>";
            } else {
                $message = "<p style='color: red;'>Kļūda, saglabājot konfigurāciju: " . mysqli_error($connection) . "</p>";
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
    <title>Datora konfigurators</title>
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
    <div class="filter-container">
        <?php while ($row = mysqli_fetch_assoc($category_result)) { ?>
            <a href="katalogs.php?category=<?php echo $row['type']; ?>&from=konfigurators">
                <button>Pievienot <?php echo ucfirst($row['type']); ?></button>
            </a>
        <?php } ?>
    </div>

    <div class="configuration">
        <?php echo $message; ?>
        <h2 style="font-size: 30px">Izvēlētās komponentes</h2>
        <?php
if (isset($_SESSION['configuration']) && count($_SESSION['configuration']) > 0) {
    echo '<ul>';
    $total_price = 0;
    
    foreach ($_SESSION['configuration'] as $component) {
        echo '<li>';
        echo '<strong>' . htmlspecialchars($component['type']) . ':</strong> ';
        echo htmlspecialchars($component['name']) . ' (' . htmlspecialchars($component['price']) . ' €) ';
        echo '<a href="konfigurators.php?remove=' . $component['id'] . '">';
        echo '<button>Noņemt</button>';
        echo '</a>'; 
        echo '</li>';
        $total_price += $component['price'];
    }
    
    echo '</ul>';
    echo '<h3>Kopējā cena: ' . $total_price . ' €</h3>';
} else {
    echo '<p>Nav pievienotas komponentes.</p>';
}
?>

        <form method="POST">
            <input type="text" name="config_name" placeholder="Ievadiet konfigurācijas nosaukumu" required>
            <button type="submit" name="save_configuration">Saglabāt konfigurāciju</button>
        </form>
    </div>
</body>
</html>