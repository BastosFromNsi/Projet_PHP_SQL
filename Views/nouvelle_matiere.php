<?php
require_once 'Model/pdo.php';

if (isset($_POST['libelle']) && !empty($_POST['libelle'])) {
    $libelle = htmlspecialchars($_POST['libelle']);

    $ajoutMatiere = $dbPDO->prepare("INSERT INTO matiere (id, lib) VALUES (NULL, :lib)");
    $ajoutMatiere->bindParam(':lib', $libelle, PDO::PARAM_STR);
    $ajoutMatiere->execute();

    echo "<p>La matière '" . htmlspecialchars($libelle) . "' a été ajoutée avec succès.</p>";
} else {
    echo "<p>Veuillez remplir le champ Libellé.</p>";
}
?>
<a href="../projet.php">Retour à l'accueil</a>