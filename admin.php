<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
    exit();
}

require_once 'Model/pdo.php';

// Gestion des actions (ajout, modification, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            if ($_POST['action'] === 'add') {
                $stmt = $dbPDO->prepare("INSERT INTO `user` (`email`, `password`) VALUES (:email, :password)");
                $stmt->execute([
                    'email' => $_POST['email'],
                    'password' => sha1($_POST['password']),
                ]);
            } elseif ($_POST['action'] === 'edit') {
                $stmt = $dbPDO->prepare("UPDATE `user` SET `email` = :email, `password` = :password WHERE `id` = :id");
                $stmt->execute([
                    'id' => $_POST['id'],
                    'email' => $_POST['email'],
                    'password' => sha1($_POST['password']),
                ]);
            } elseif ($_POST['action'] === 'delete') {
                $stmt = $dbPDO->prepare("DELETE FROM `user` WHERE `id` = :id");
                $stmt->execute(['id' => $_POST['id']]);
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}

// Récupération des utilisateurs
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
    <title>Admin - Gestion des utilisateurs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdn.tailwindcss.com"></script>
    <script defer src="tailwind.config.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Admin - Gestion des utilisateurs</h1>

        <!-- Tableau des utilisateurs -->
        <div class="relative overflow-x-auto mb-6">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Mot de passe (crypté)</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['password']); ?></td>
                            <td class="px-6 py-4">
                                <!-- Formulaire de modification -->
                                <form method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="border rounded px-2 py-1" required>
                                    <input type="password" name="password" placeholder="Nouveau mot de passe" class="border rounded px-2 py-1" required>
                                    <button type="submit" class="text-blue-600 hover:underline">Modifier</button>
                                </form>
                                <!-- Formulaire de suppression -->
                                <form method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulaire d'ajout -->
        <h2 class="text-xl font-bold mb-4">Ajouter un utilisateur</h2>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="add">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Ajouter</button>
        </form>
    </div>
</body>

</html>