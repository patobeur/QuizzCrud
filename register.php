<?php
// register.php
session_start();
require_once 'includes/db_setup.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - QCM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'header.php'; ?>
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Inscription</h1>
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
                        <input type="text" name="username" id="username" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Mot de passe</label>
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">S'inscrire</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
