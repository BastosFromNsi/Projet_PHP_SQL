<?php
require_once 'Model/pdo.php';

if (isset($_POST['nom'], $_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $classeId = 1; 

    $ajoutEtudiant = $dbPDO->prepare("INSERT INTO etudiants (nom, prenom, classe_id) VALUES (:nom, :prenom, :classe_id)");
    $ajoutEtudiant->bindParam(':nom', $nom, PDO::PARAM_STR);
    $ajoutEtudiant->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $ajoutEtudiant->bindParam(':classe_id', $classeId, PDO::PARAM_INT);
    $ajoutEtudiant->execute();

    echo "<p>L'étudiant '" . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . "' a été ajouté avec succès.</p>";
} else {
    echo "<p>Veuillez remplir tous les champs.</p>";
}
?>
<a href="../projet.php">Retour à l'accueil</a>