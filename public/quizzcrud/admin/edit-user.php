<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/quizzcrud/">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Édition d'Utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php
    require_once __DIR__ . '/auth-check.php';
    include __DIR__ . '/../header.php';
    require_once __DIR__ . '/../../../private_quizzcrud/includes/db_setup.php';

    $user_data = [];
    $user_id = $_GET['user_id'] ?? null;
    $is_editing = false;

    if ($user_id) {
        $is_editing = true;
        $db = get_db_connection();
        $stmt = $db->prepare("SELECT id, username, role FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <header class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-bold"><?php echo $is_editing ? 'Modifier l\'Utilisateur' : 'Créer un Utilisateur'; ?></h1>
        </header>

        <section class="bg-white rounded-2xl shadow p-5 md:p-6">
            <form id="user-form" action="save-user.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id ?? ''); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                        <select id="role" name="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="user" <?php echo (isset($user_data['role']) && $user_data['role'] === 'user') ? 'selected' : ''; ?>>Utilisateur</option>
                            <option value="admin" <?php echo (isset($user_data['role']) && $user_data['role'] === 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="password" name="password" <?php echo $is_editing ? '' : 'required'; ?> class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <?php if ($is_editing): ?>
                        <p class="mt-2 text-sm text-gray-500">Laissez vide pour ne pas changer le mot de passe.</p>
                    <?php endif; ?>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </section>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
