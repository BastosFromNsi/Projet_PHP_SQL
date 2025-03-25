<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Model/pdo.php';

//affiche nom et prenom des etudiants - Partie 2

$resultat = $dbPDO->prepare("SELECT id, nom, prenom FROM etudiants");
$resultat->execute();
$etudiants = $resultat->fetchAll(PDO::FETCH_ASSOC);

echo "<ul>";
foreach ($etudiants as $etudiant) {
    echo "<li>" . htmlspecialchars($etudiant['nom']) . " " . htmlspecialchars($etudiant['prenom']) .
        " <a href='Views/modif_etudiant.php?id=" . urlencode($etudiant['id']) . "'>Modifier</a>" .   // lien pour modifier l'étudiant
        " <a href='Views/suppression_etudiant.php?id=" . urlencode($etudiant['id']) . "' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');\">Supprimer</a></li>";  // lien pour supprimer l'étudiant
}
echo "</ul>";

//affiche les classes
$resultatClasses = $dbPDO->prepare("SELECT libelle FROM classes");
$resultatClasses->execute();

$classes = $resultatClasses->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Liste des classes :</h2>";
echo "<ul>";
foreach ($classes as $classe) {
    echo "<li>" . htmlspecialchars($classe['libelle']) . "</li>";
}
echo "</ul>";

//afficher la liste de tout les profs

$resultatProfs = $dbPDO->prepare("SELECT prenom, nom FROM professeurs");
$resultatProfs->execute();

$professeurs = $resultatProfs->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Liste des professeurs :</h2>";
echo "<ul>";
foreach ($professeurs as $professeur) {
    echo "<li>" . htmlspecialchars($professeur['prenom']) . " " . htmlspecialchars($professeur['nom']) . "</li>";
}
echo "</ul>";

// ajout de la nouvelle matière

$ajoutMatiere = $dbPDO->prepare("INSERT INTO matiere (id, lib) VALUES (NULL, :lib)");
$libMatiere = 'Mathématiques';
$ajoutMatiere->bindParam(':lib', $libMatiere, PDO::PARAM_STR);
$ajoutMatiere->execute();
?>

<!-- Partie 3 -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une matière</title>
</head>

<body>
    <h1>Ajouter une nouvelle matière</h1>
    <form action="Views/nouvelle_matiere.php" method="POST">
        <label for="libelle">Libellé :</label>
        <input type="text" id="libelle" name="libelle" required>
        <button type="submit">Valider</button>
    </form>

    <h2>Ajouter un nouvel élève</h2>
    <form action="Views/nouvel_etudiant.php" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
        <button type="submit">Valider</button>
    </form>
</body>

</html>