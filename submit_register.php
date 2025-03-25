<?php

session_start();

$post = $_POST;
var_dump($post);

if (isset($post['email']) && isset($post['password']) && isset($post['confirm-password']) && $post['password'] === $post['confirm-password']) {
    echo "ok";

    require_once 'Model/pdo.php'; 

    try {
        $resultat = $dbPDO->prepare("INSERT INTO `user` (`id`, `email`, `password`) VALUES (NULL, :email, SHA1(:password));");
        $req = $resultat->execute([
            'email' => $post['email'],
            'password' => $post['password']
        ]);

        if ($req) {
            echo "Utilisateur ajouté avec succès.";
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Erreur lors de l'ajout de l'utilisateur.";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "ko";
    header('Location: register.php');
    exit();
}
?>
