<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM components WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="lv">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Komponente - <?php echo htmlspecialchars($row['name']); ?></title>
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
                .image {
                    text-align: center;
                }
                .image img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 8px;
                }
                .details {
                    margin-top: 20px;
                }
                .details h1 {
                    text-align: center;
                    margin: 0 0 10px;
                    font-size: 24px;
                }
                .details p {
                    margin: 5px 0;
                }
                .back-button {
                    display: block;
                    text-align: center;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                .back-button a {
                    display: inline-block;
                    padding: 10px;
                    font-size: 20px;
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
            <div class="image">
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            </div>
            <div class="details">
                <h1><?php echo htmlspecialchars($row['name']); ?></h1>
                <p><strong>Tips:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
                <p><strong>Ražotājs:</strong> <?php echo htmlspecialchars($row['brand']); ?></p>
                <p><strong>Cena:</strong> <?php echo htmlspecialchars($row['price']); ?> €</p>
                <p><strong>Apraksts:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
            </div>
        </div>
        <div class = "back-button">
                <a href = "katalogs.php" style ="color: black;">Atgriezties uz katalogu</a>
        </div>    
        </body>
        </html>
        <?php
    } else {
        echo "<p>Šāda komponente netika atrasta.</p>";
    }
} else {
    echo "<p>Komponentes ID nav norādīts.</p>";
}
mysqli_close($connection);
?>