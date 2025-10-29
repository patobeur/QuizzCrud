<?php
// register.php
session_start();
require_once __DIR__ . '/../../private_quizzcrud/includes/db_setup.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Le nom d'utilisateur et le mot de passe sont requis.";
    } else {
        $db = get_db_connection();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed_password])) {
                $success = "Inscription réussie ! Vous pouvez maintenant vous <a href='login.php'>connecter</a>.";
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/quizzcrud/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>Inscription - QCM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    <div class="max-w-md mx-auto p-4 md:p-8 w-full">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold mb-4 text-center">Inscription</h1>
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $success; ?></span>
                </div>
            <?php else: ?>
                <form action="register.php" method="post">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">Nom d'utilisateur</label>
                        <input type="text" name="username" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Mot de passe</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">S'inscrire</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
