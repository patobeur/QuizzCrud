<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Gestion des Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php
    require_once 'auth-check.php';
    include '../header.php';
    require_once '../includes/db_setup.php';

    $db = get_db_connection();
    $stmt = $db->query("SELECT id, username, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <header class="mb-8 md:mb-10 flex justify-between items-center">
            <h1 class="text-2xl md:text-4xl font-bold">Gestion des Utilisateurs</h1>
            <a href="edit-user.php" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                Ajouter un utilisateur
            </a>
        </header>

        <section class="bg-white rounded-2xl shadow p-5 md:p-6">
            <h2 class="text-xl md:text-2xl font-semibold mb-4">Utilisateurs Enregistrés</h2>
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="p-2">Nom d'utilisateur</th>
                        <th class="p-2">Rôle</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="3" class="p-2 text-center">Aucun utilisateur trouvé.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b">
                                <td class="p-2"><?php echo htmlspecialchars($user['username']); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($user['role'] ?? 'user'); ?></td>
                                <td class="p-2">
                                    <a href="edit-user.php?user_id=<?php echo $user['id']; ?>" class="text-indigo-600 hover:underline">Modifier</a>
                                    <a href="delete-user.php?user_id=<?php echo $user['id']; ?>" class="text-red-600 hover:underline ml-4" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
