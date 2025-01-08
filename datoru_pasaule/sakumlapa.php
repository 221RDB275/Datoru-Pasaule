<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

$query = "SELECT apraksts FROM lapas_info WHERE id = 1";
$result = mysqli_query($connection, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $apraksts = $row['apraksts'];
} else {
    $apraksts = "Nav pieejama informācija par mājaslapu.";
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    if (isset($_POST['save'])) {
        $new_apraksts = mysqli_real_escape_string($connection, $_POST['apraksts']);
        $update_query = "UPDATE lapas_info SET apraksts = '$new_apraksts' WHERE id = 1";
        if (mysqli_query($connection, $update_query)) {
            $message = "Apraksts ir veiksmīgi atjaunināts!";
        } else {
            $message = "Kļūda atjauninot aprakstu: " . mysqli_error($connection);
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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        .container {
            margin-top: 80px;
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        p {
            font-size: 20px;
            text-align: justify;
        }
        h1 {
            font-size: 30px;
            font: bold;
            text-align: center;
        }
        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            font-size: 18px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .message {
            color: green;
            font-size: 18px;
        }
        .logo-container {
            text-align: center;
        }
        .logo {
            max-width: 500px;
            height: auto;
            border-radius: 10px; 
        }
    </style>
</head>
<body>
    <?php izvelne(); ?>

    <div class="container">
        <h1>Datoru Pasaule</h1>

        <?php if (isset($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>

        <p><?php echo htmlspecialchars($apraksts); ?></p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
            <form method="POST" action="">
                <h2 style="text-align: center;">Rediģēt aprakstu</h2>
                <textarea name="apraksts"><?php echo htmlspecialchars($apraksts); ?></textarea>
                <button type="submit" name="save">Saglabāt izmaiņas</button>
            </form>
        <?php } ?>
    </div>
    <div class="logo-container">
            <img src="images/logo.jpg" alt="Mājaslapas logo" class="logo">
    </div>
</body>
</html>