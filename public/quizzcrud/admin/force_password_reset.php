<?php
session_start();
require_once __DIR__ . '/../../../private_quizzcrud/includes/db_setup.php';

$error = '';

if (!isset($_SESSION['user_id'])) {
    header('Location: /quizzcrud/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $db = get_db_connection();
        $stmt = $db->prepare("UPDATE users SET password = ?, password_reset_required = 0 WHERE id = ?");
        $stmt->execute([$hashed_password, $_SESSION['user_id']]);
        header('Location: /quizzcrud/admin/index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/quizzcrud/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de mot de passe requis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <div class="max-w-md mx-auto p-4 md:p-8 w-full">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold mb-4 text-center">Changement de mot de passe requis</h1>
            <p class="text-center text-sm text-gray-600 mb-4">
                Pour des raisons de sécurité, vous devez changer le mot de passe par défaut.
            </p>
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            <form action="force_password_reset.php" method="post">
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Mettre à jour le mot de passe</button>
            </form>
        </div>
    </div>
</body>
</html>
