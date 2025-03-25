<?php

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
            echo "<pre>L'utilisateur a bien été trouvé</pre>";

            $user = $resultat->fetch();

            if ($user['password'] === sha1($post['password'])) {
                echo "<pre>Le password est ok !</pre>";
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
