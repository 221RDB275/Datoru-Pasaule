<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $get_user_id_query = "SELECT id FROM users WHERE email = '$email'";
    $user_result = mysqli_query($connection, $get_user_id_query);
    $message = '';

    if (mysqli_num_rows($user_result) == 0) {
        die("Kļūda: Lietotājs nav atrasts.");
    }

    $user = mysqli_fetch_assoc($user_result);
    $user_id = $user['id'];
} else {
    $user_id = null;
}

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'guest';
}

if (!isset($_GET['id'])) {
    die("Kļūda: Konfigurācijas ID nav norādīts.");
}

$config_id = (int)$_GET['id'];

function getComponent($connection, $component_id) {
    if ($component_id === NULL) return null;

    $query = "SELECT name, type, price FROM components WHERE id = $component_id";
    $result = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($result);
}

$config_query = "SELECT * FROM user_configurations WHERE id = $config_id";
$config_result = mysqli_query($connection, $config_query);

if (mysqli_num_rows($config_result) === 0) {
    $message = "<p style='color: red;'>Kļūda: Konfigurācija nav atrasta!</p>";
    echo '<a href="profils.php">Atgriezties uz profilu</a>';
    exit();
}

$config = mysqli_fetch_assoc($config_result);

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

$image_url = $config['image_url_id'];

$vote_count_query = "SELECT COUNT(*) AS vote_count FROM votes WHERE configuration_id = $config_id";
$vote_count_result = mysqli_query($connection, $vote_count_query);
$vote_count = mysqli_fetch_assoc($vote_count_result)['vote_count'];

if (isset($_POST['vote']) && $user_id) {
    $check_vote_query = "SELECT * FROM votes WHERE configuration_id = $config_id AND user_id = $user_id";
    $check_vote_result = mysqli_query($connection, $check_vote_query);
    
    if (mysqli_num_rows($check_vote_result) > 0) {
        $delete_vote_query = "DELETE FROM votes WHERE configuration_id = $config_id AND user_id = $user_id";
        mysqli_query($connection, $delete_vote_query);
        $message = "<p style='color: red;'>Jūsu balss ir noņemta.</p>";
    } else {
        $insert_vote_query = "INSERT INTO votes (configuration_id, user_id, vote_amount) VALUES ($config_id, $user_id, 1)";
        mysqli_query($connection, $insert_vote_query);
        $message = "<p style='color: green;'>Paldies par balsi!</p>";
    }
    header("Location: citu_datori_info.php?id=$config_id");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && $user_id) {
    $user_comment = mysqli_real_escape_string($connection, $_POST['comment']);
    $config_id = (int)$_GET['id'];

    $check_config_query = "SELECT id FROM user_configurations WHERE id = $config_id";
    $config_check_result = mysqli_query($connection, $check_config_query);

    if (mysqli_num_rows($config_check_result) == 0) {
        die("Kļūda: Konfigurācija ar ID $config_id neeksistē.");
    }

    $insert_comment_query = "INSERT INTO comments (user_id, configuration_id, user_comment, created_at)
                             VALUES ($user_id, $config_id, '$user_comment', NOW())";

    if (!mysqli_query($connection, $insert_comment_query)) {
        die("Komentāru nevar pievienot: " . mysqli_error($connection));
    }

    $message = "<p style='color: green; text-align: center;'>Komentārs pievienots!</p>";
}

if (isset($_POST['delete_comment']) && ($user_id || $_SESSION['role'] === 'admin')) {
    $comment_id = (int)$_POST['comment_id'];
    $delete_comment_query = "DELETE FROM comments WHERE id = $comment_id";
    mysqli_query($connection, $delete_comment_query);
    header("Location: citu_datori_info.php?id=$config_id");
    $message = "<p style='color: red; text-align: center;'>Komentārs izdzēsts!</p>";
    exit();
}

$comments_query = "SELECT comments.id, comments.user_comment, comments.created_at, users.name, users.email 
                   FROM comments 
                   JOIN users ON comments.user_id = users.id 
                   WHERE configuration_id = $config_id
                   ORDER BY created_at DESC";
$comments_result = mysqli_query($connection, $comments_query);
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
        h3, h4 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .vote-container {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .vote-count {
            margin: 0;
            font-size: 16px;
        }
        .vote-button {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .vote-button:hover {
            background-color: darkgreen;
        }
        .comment-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
            word-wrap: break-word;
            max-width: 100%;
            box-sizing: border-box;
        }
        .comment-section {
            margin-top: 20px;
        }
        .comment-section form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
        }
        .comment-section textarea {
            width: 100%;
            max-width: 600px;
            min-height: 80px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            resize: vertical;
        }
        .comment-section .post-button, .delete-button {
            padding: 8px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button {
            background-color: red;
        }
        .comment-section .post-button:hover {
            background-color: darkgreen;
        }
        .comment-section .delete-button:hover {
            background-color: darkred;
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
        <h3 style="font-size: 30px">Konfigurācijas detaļas</h3>
        <ul>
            <?php foreach ($components as $type => $component) { ?>
                <li>
                    <strong><?php echo htmlspecialchars($type); ?>:</strong>
                    <?php if ($component) { ?>
                        <?php echo htmlspecialchars($component['name']); ?> 
                        (<?php echo htmlspecialchars($component['price']); ?> €)
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>

        <div>
            <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Datora korpuss" style="max-width: 200px; display: block; margin: 0 auto;">
        </div>

        <h4>Kopējā cena: <?php echo htmlspecialchars($config['total_price']); ?> €</h4>

        
        <div class="vote-container">
            <p class="vote-count">Balsu skaits: <?php echo $vote_count; ?></p>
            <?php if ($user_id): ?>
                <form method="POST" action="">
                    <button type="submit" name="vote" class="vote-button">
                        <?php 
                        $check_vote_result = mysqli_query($connection, "SELECT * FROM votes WHERE configuration_id = $config_id AND user_id = $user_id");
                        if (mysqli_num_rows($check_vote_result) > 0) {
                            echo "Noņemt balsi";
                        } else {
                            echo "Nobalsot";
                        }
                        ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>

    <div class="comment-section">
    <h4 style="font-size: 30px">Komentāri</h4>
    <?php while ($comment = mysqli_fetch_assoc($comments_result)) { ?>
        <div class="comment-container">
            <p><strong><?php echo htmlspecialchars($comment['name']); ?>:</strong></p>
            <p><?php echo htmlspecialchars($comment['user_comment']); ?></p>
            <small><?php echo  "Komentēts: " . htmlspecialchars($comment['created_at']); ?></small>
            <?php if (isset($_SESSION['email']) && $comment['email'] === $_SESSION['email'] || $_SESSION['role'] === 'admin') { ?>
                <form method="POST">
                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                    <button type="submit" name="delete_comment" class="delete-button">Dzēst</button>
                </form>
            <?php } ?>
        </div>
    <?php }
    if ($user_id) {
        echo $message;
    }
    mysqli_close($connection); ?>

    <form method="POST">
        <?php if ($user_id): ?>
            <textarea name="comment" placeholder="Ievadiet komentāru..." required></textarea>
            <button type="submit" name="add_comment" class="post-button">Pievienot komentāru</button>
        <?php endif; ?>
    </form>
    
    </div>
    <div class = "back-button">
        <a href = "citu_datori.php">Atgriezties</a>
    </div>    
</div>
</body>
</html>