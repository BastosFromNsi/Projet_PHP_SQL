<?php
session_start();

// Vérifier les données POST
$post = $_POST;

if (isset($post['email']) && isset($post['password'])) {
    require_once 'Model/pdo.php';

    try {
        $resultat = $dbPDO->prepare("SELECT * FROM `user` WHERE `email` = :email");
        $resultat->execute([
            'email' => $post['email']
        ]);

        $rows = $resultat->rowCount();
        if ($rows > 0) {
            $user = $resultat->fetch();


            if ($user['password'] === sha1($post['password'])) {
                $_SESSION['userId'] = $user['id'];  // changement : on initialise la session avec l'id de l'utilisateur
                header('Location: dashboard.php'); 
                exit();
            } else {
                echo "<pre>Mot de passe incorrect.</pre>";
            }
        } else {
            echo "<pre>Aucun user trouvé.</pre>";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Données manquantes.";
    header('Location: login.php'); 
    exit();
}
?>

