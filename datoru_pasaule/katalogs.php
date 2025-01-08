<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

session_start();
include 'izvelne.php';

$connection = mysqli_connect("localhost", "root", "", "projekts_db");
if (!$connection) {
    die("Datubāzes savienojuma kļūda: " . mysqli_connect_error());
}

$category_filter = isset($_GET['category']) ? $_GET['category'] : (isset($_GET['type']) ? $_GET['type'] : '');
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : '';

$komponentes_per_row = 3;
$komponentes_per_page = $komponentes_per_row * 6;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $komponentes_per_page;

$query = "SELECT * FROM components WHERE 1";

$config_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($category_filter != '') {
    $query .= " AND type = '" . mysqli_real_escape_string($connection, $category_filter) . "'";
}

if ($search_query != '') {
    $query .= " AND name LIKE '%" . mysqli_real_escape_string($connection, $search_query) . "%'";
}

if ($sort_order == 'desc') {
    $query .= " ORDER BY price DESC";
} elseif ($sort_order == 'asc') {
    $query .= " ORDER BY price ASC";
}

$query .= " LIMIT $komponentes_per_page OFFSET $offset";
$result = mysqli_query($connection, $query);

$category_query = "SELECT DISTINCT type FROM components";
$category_result = mysqli_query($connection, $category_query);

$is_configurator = isset($_GET['from']) && $_GET['from'] == 'konfigurators';
$is_editing = isset($_GET['from']) && $_GET['from'] == 'rediget';

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (isset($_POST['action']) && isset($_POST['component_id'])) {
    $component_id = (int)$_POST['component_id'];
    $action = $_POST['action'];

    if ($action == 'make_hidden') {
        $query = "UPDATE components SET is_public = 0 WHERE id = $component_id";
        echo "Komponentes statuss veiksmīgi slep";
    } elseif ($action == 'make_public') {
        $query = "UPDATE components SET is_public = 1 WHERE id = $component_id";
        echo "Komponentes statuss veiksmīgi pub";
    }

    if (mysqli_query($connection, $query)) {
        echo "Komponentes statuss veiksmīgi atjaunināts.";
    } else {
        echo "Kļūda, mēģinot atjaunināt komponentes statusu: " . mysqli_error($connection);
    }
    header ("Location: katalogs.php");
}

?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komponenšu katalogs</title>
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif;
            background-color: rgb(47, 50, 67);
        }
        .filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }
        .filter-container select, .filter-container input, .filter-container button {
            padding: 10px;
            margin-top: 20px;
        }
        .catalog-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
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
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            border-radius: 10px;
            margin-bottom: 5px;
        }
        .pievienot-btn, .aizstat-btn, .publicet-btn, .paslept-btn {
            display: <?php echo $is_configurator || $is_editing || $is_admin ? 'inline-block' : 'none'; ?>;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        .aizstat-btn {
            background-color: orange; 
        }
        .publicet-btn {
            background-color: blue;
        }
        .paslept-btn {
            background-color: red;
        }
        .pievienot-btn:hover {
            background-color: darkgreen;
        }
        .aizstat-btn:hover {
            background-color: darkorange;
        }
        .publicet-btn:hover {
            background-color: darkblue;
        }
        .paslept-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <?php izvelne(); ?>
    <form method="GET" action="katalogs.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($config_id); ?>">
        <div class="filter-container">
            <select name="category">
                <option value="">Visas kategorijas</option>
                <?php
                while ($category_row = mysqli_fetch_assoc($category_result)) {
                    $selected = ($category_filter == $category_row['type']) ? 'selected' : '';
                    echo '<option value="' . $category_row['type'] . '" ' . $selected . '>' . $category_row['type'] . '</option>';
                }
                ?>
            </select>
            <input type="text" name="search" placeholder="Meklēt pēc nosaukuma" value="<?php echo htmlspecialchars($search_query); ?>">
            <select name="sort">
                <option value="">Kārtot pēc</option>
                <option value="asc" <?php echo ($sort_order == 'asc') ? 'selected' : ''; ?>>Cena no lētākās</option>
                <option value="desc" <?php echo ($sort_order == 'desc') ? 'selected' : ''; ?>>Cena no dārgākās</option>
            </select>

            <button type="submit">Meklēt</button>
        </div>
    </form>

    <?php
    echo '<div style="width: 55%; margin: auto; margin-top: 20px; padding: 20px; background: #fff; border-radius: 10px; text-align: center;">';

    if (mysqli_num_rows($result) > 0) {
        echo '<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">';

        $i = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['is_public'] == 1 || $is_admin) {
                if ($i % $komponentes_per_row == 0 && $i != 0) {
                    echo '</div><div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 10px;">';
                }
                echo '<div class="komponente">';
                echo '<a href="komponente.php?id=' . $row['id'] . '">';
                echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '" style="width: 100%; height: 200px; object-fit: contain; margin-bottom: 10px;">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['type'] . '</p>';
                echo '<p>' . $row['price'] . ' €</p>';
                echo '</a>';

                if ($is_configurator) {
                    echo '<form method="GET" action="konfigurators.php">';
                    echo '<input type="hidden" name="add" value="' . $row['id'] . '">';
                    echo '<button type="submit" class="pievienot-btn">Pievienot konfigurācijai</button>';
                    echo '</form>';
                }

                if ($is_editing) {
                    echo '<form method="GET" action="rediget.php">';
                    echo '<input type="hidden" name="replace" value="' . $row['id'] . '">';
                    echo '<input type="hidden" name="type" value="' . $row['type'] . '">';
                    echo '<input type="hidden" name="id" value="' . $config_id . '">';
                    echo '<input type="hidden" name="from" value="rediget">';
                    echo '<input type="hidden" name="redirected" value="true">';
                    echo '<button type="submit" class="aizstat-btn">Aizstāt</button>';
                    echo '</form>';
                }

                if ($is_admin) {
                    echo '<form method="POST" action="katalogs.php">';
                    echo '<input type="hidden" name="component_id" value="' . $row['id'] . '">';
                    
                    if ($row['is_public'] == 1) {
                        echo '<button type="submit" name="action" value="make_hidden" class="paslept-btn">Slēpt</button>';
                    } else {
                        echo '<button type="submit" name="action" value="make_public" class="publicet-btn">Publicēt</button>';
                    }
                    echo '</form>';
                }

                echo '</div>';

                $i++;
            }
        }
        echo '</div>';
    } else {
        echo '<p>Nav atrastas nevienas komponentes.</p>';
    }

    $total_pages_query = "SELECT COUNT(id) AS total FROM components WHERE 1";

    if ($category_filter != '') {
        $total_pages_query .= " AND type = '" . mysqli_real_escape_string($connection, $category_filter) . "'";
    }
    if ($search_query != '') {
        $total_pages_query .= " AND name LIKE '%" . mysqli_real_escape_string($connection, $search_query) . "%'";
    }

    $total_pages_result = mysqli_query($connection, $total_pages_query);
    $total_pages_row = mysqli_fetch_assoc($total_pages_result);
    $total_komponentes = $total_pages_row['total'];
    $total_pages = ceil($total_komponentes / $komponentes_per_page);

    echo '<div style="text-align: center; margin-top: 20px;">';

    $base_url = "katalogs.php?category=" . urlencode($category_filter) . "&search=" . urlencode($search_query) . "&sort=" . urlencode($sort_order) . "&id=" . urlencode($config_id);

    if ($page > 1) {
        echo '<a href="' . $base_url . '&page=' . ($page - 1) . '" style="margin-right: 10px;">Iepriekšējā lapa</a>';
    }
    if ($page < $total_pages) {
        echo '<a href="' . $base_url . '&page=' . ($page + 1) . '" style="margin-left: 10px;">Nākamā lapa</a>';
    }
    echo '</div>';

    mysqli_close($connection);
?>
</body>
</html>