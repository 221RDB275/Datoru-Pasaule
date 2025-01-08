<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $config_id = (int)$_GET['id'];
    $email = $_SESSION['email'];
    $config_query = "SELECT * 
                     FROM user_configurations uc
                     JOIN users u ON uc.user_id = u.id
                     WHERE uc.id = $config_id AND u.email = '$email'";
                     
    $config_result = mysqli_query($connection, $config_query);

    if (mysqli_num_rows($config_result) === 0) {
        echo "<p>Kļūda: Jūs nevarat dzēst šo konfigurāciju.</p>";
        echo '<a href="profils.php">Atgriezties uz profilu</a>';
        exit();
    }

    $delete_query = "DELETE FROM user_configurations WHERE id = $config_id";
    if (mysqli_query($connection, $delete_query)) {
        echo "<p>Konfigurācija ir veiksmīgi izdzēsta.</p>";
        header("Location: profils.php");
        exit();
    } else {
        echo "<p>Kļūda dzēšot konfigurāciju: " . mysqli_error($connection) . "</p>";
        echo '<a href="profils.php">Atgriezties uz profilu</a>';
        exit();
    }
} else {
    echo "<p>Kļūda: Konfigurācijas ID nav norādīts.</p>";
    echo '<a href="profils.php">Atgriezties uz profilu</a>'; 
}

mysqli_close($connection);
?>

<form action="delete_config.php" method="POST" style="display: inline;">
    <input type="hidden" name="config_id" value="<?php echo $config_id; ?>">
    <button type="submit" class="delete">Dzēst</button>
</form>