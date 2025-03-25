<?php
session_start();
// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Afficher les erreurs et les avertissements
error_reporting(E_ALL);
header("Location: register.php");

if (isset($_SESSION['userId'])) {
    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
exit();

?>