<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$name = 'Quizz Crud';
?><header id="header" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a title="<?= $name; ?>" href="/" class="flex items-center space-x-2">
                <svg alt="<?= $name; ?> Logo" class="h-8 w-8 rounded-sm" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M512 64l100.266667 76.8 123.733333-17.066667 46.933333 117.333334 117.333334 46.933333-17.066667 123.733333L960 512l-76.8 100.266667 17.066667 123.733333-117.333334 46.933333-46.933333 117.333334-123.733333-17.066667L512 960l-100.266667-76.8-123.733333 17.066667-46.933333-117.333334-117.333334-46.933333 17.066667-123.733333L64 512l76.8-100.266667-17.066667-123.733333 117.333334-46.933333 46.933333-117.333334 123.733333 17.066667z" fill="#8BC34A"></path>
                        <path d="M738.133333 311.466667L448 601.6l-119.466667-119.466667-59.733333 59.733334 179.2 179.2 349.866667-349.866667z" fill="#CCFF90"></path>
                    </g>
                </svg>
                <span class="text-xl font-bold"><?= $name; ?></span>
            </a>
        </div>
        <div id="nav-links" class="hidden lg:flex items-center space-x-6">
            <a href="/les-quizz.php" class="text-gray-700 hover:text-indigo-600 transition">Les Quizz</a>
            <a href="/progression.php" class="text-gray-700 hover:text-indigo-600 transition">Ma progression</a>
            <div class="relative">
                <button id="tests-menu-button" class="text-gray-700 hover:text-indigo-600 transition flex items-center">
                    <span>Tests</span>
                    <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="tests-menu-dropdown" class="absolute hidden mt-2 w-48 z-10">
                    <div class="bg-white shadow-lg rounded-md">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Test 1</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Test 2</a>
                    </div>
                </div>
            </div>
            <a href="#" class="text-gray-700 hover:text-indigo-600 transition">À propos</a>
        </div>
        <div class="flex items-center space-x-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="relative">
                    <button id="profile-menu-button" class="flex items-center text-gray-700 hover:text-indigo-600 transition">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </button>
                    <div id="profile-menu-dropdown" class="absolute hidden mt-2 right-0 w-48 z-10">
                        <div class="bg-white shadow-lg rounded-md">
                            <a href="/progression.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Ma progression</a>
                            <?php
                            // Check if the user is an admin
                            if (isset($_SESSION['user_id'])) {
                                require_once 'includes/db_setup.php';
                                $db = get_db_connection();
                                $stmt = $db->prepare("SELECT role FROM users WHERE id = ?");
                                $stmt->execute([$_SESSION['user_id']]);
                                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                                if ($user && $user['role'] === 'admin') {
                                    echo '<a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Gestion Quizz</a>';
                                    echo '<a href="/admin/users.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Gestion Utilisateurs</a>';
                                }
                            }
                            ?>
                            <a href="/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Déconnexion</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="text-gray-700 hover:text-indigo-600 transition">Connexion</a>
                <a href="register.php" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Inscription</a>
            <?php endif; ?>
            <button id="burger-menu" class="lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </nav>
</header>
<main id="main-content" class="flex-grow">