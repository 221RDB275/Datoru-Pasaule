<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
function izvelne() {
    $current_page = basename($_SERVER['PHP_SELF']);

    echo '
    <div style="display: flex; justify-content: center; background-color: rgb(24, 27, 35); padding: 10px;">
        <a href="sakumlapa.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px; ' . ($current_page === 'sakumlapa.php' ? 'background-color:rgb(255, 7, 99);' : '') . '">Sākumlapa</a>
        <a href="katalogs.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px;' . ($current_page === 'katalogs.php' || $current_page === 'komponente.php' ? 'background-color:rgb(255, 7, 99);' : '') . '">Katalogs</a>
        <a href="citu_datori.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px;' . ($current_page === 'citu_datori.php' || $current_page === 'citu_datori_info.php' ? 'background-color:rgb(255, 7, 99);' : '') . '">Citu lietotāju datori</a>
        ';
    if  (isset($_SESSION['email'])) {
        echo  '
        <a href="konfigurators.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px;' . ($current_page === 'konfigurators.php'  ? 'background-color:rgb(255, 7, 99);' : '') . '">Izveidot savu datoru</a>
        <a href="profils.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px;' . ($current_page === 'profils.php' || $current_page === 'dzest_konfiguraciju_apstiprinat.php' || $current_page === 'liet_konfiguracija.php' || $current_page === 'rediget.php' ? 'background-color:rgb(255, 7, 99);' : '') . '">Profils</a>
        <a href="logout.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px;">Iziet</a>';
    } else {
        echo '<a href="login.php" style="flex: 1; text-align: center; padding: 10px; color: white; text-decoration: none; border-radius: 10px;' . ($current_page === 'login.php' ? 'background-color:rgb(255, 7, 99);' : '') . '">Ienākt</a>';
    }
    echo '</div>';
}
?>