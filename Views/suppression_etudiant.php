<?php
require_once 'Model/pdo.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $verifEtudiant = $dbPDO->prepare("SELECT * FROM etudiants WHERE id = :id");
    $verifEtudiant->bindParam(':id', $id, PDO::PARAM_INT);
    $verifEtudiant->execute();
    $etudiant = $verifEtudiant->fetch(PDO::FETCH_ASSOC);

    if ($etudiant) {
        $suppression = $dbPDO->prepare("DELETE FROM etudiants WHERE id = :id");
        $suppression->bindParam(':id', $id, PDO::PARAM_INT);
        $suppression->execute();

        echo "<p>Suppression de l'étudiant réussie.</p>";
    } else {
        echo "<p>Étudiant introuvable.</p>";
    }
} else {
    echo "<p>Aucun ID fourni.</p>";
}
?>
<a href="../projet.php">Retour à l'accueil</a>