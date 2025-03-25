<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Model/pdo.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $resultat = $dbPDO->prepare("SELECT * FROM etudiants WHERE id = :id");
    $resultat->bindParam(':id', $id, PDO::PARAM_INT);
    $resultat->execute();
    $etudiant = $resultat->fetch(PDO::FETCH_ASSOC);

    if ($etudiant) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier un étudiant</title>
        </head>
        <body>
            <h1>Modifier un étudiant</h1>
            <form action="modif_etudiant.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($etudiant['id']); ?>">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($etudiant['nom']); ?>" required>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($etudiant['prenom']); ?>" required>
                <button type="submit">Valider</button>
            </form>
            <a href="../projet.php">Retour à l'accueil</a>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Étudiant introuvable.</p>";
        echo "<a href='../projet.php'>Retour à l'accueil</a>";
    }
} elseif (isset($_POST['id'], $_POST['nom'], $_POST['prenom']) && !empty($_POST['id']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {

    $id = intval($_POST['id']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);

    $update = $dbPDO->prepare("UPDATE etudiants SET nom = :nom, prenom = :prenom WHERE id = :id");
    $update->bindParam(':nom', $nom, PDO::PARAM_STR);
    $update->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $update->bindParam(':id', $id, PDO::PARAM_INT);
    $update->execute();

    echo "<p>Les informations de l'étudiant ont été mises à jour avec succès.</p>";
    echo "<a href='../projet.php'>Retour à l'accueil</a>";
} else {
    echo "<p>Une erreur est survenue.</p>";
    echo "<a href='../projet.php'>Retour à l'accueil</a>";
}
?>