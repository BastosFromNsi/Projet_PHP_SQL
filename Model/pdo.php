<?php

$servername = "localhost"; // Nom du serveur
$username = "root"; // Nom d'utilisateur de la base de données
$password = "root"; // Mot de passe de la base de données
$dbname = "ecole"; // Nom de la base de données

try {
    $dbPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $dbPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données";
} catch (PDOException $e) {
    echo "La connexion a échouée : " . $e->getMessage();
}


