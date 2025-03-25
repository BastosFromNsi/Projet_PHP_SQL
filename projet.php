<?php

require_once 'Model/pdo.php';

// tp 10 - Partie 2
try {
    $resultat = $dbPDO->query("SELECT * FROM `user`");
    $users = $resultat->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet - Liste des utilisateurs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdn.tailwindcss.com"></script>
    <script defer src="tailwind.config.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des utilisateurs</h1>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Mot de passe (crypté)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['password']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>