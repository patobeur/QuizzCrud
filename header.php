<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$ref = '234212850';
?><header id="header" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="/" class="flex items-center space-x-2">
                <svg alt="QF-Library Logo" class="h-8 w-8 rounded-sm" fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>barcode</title>
                        <path d="M29 6.031h-26c-1.104 0-2 0.896-2 2v16.938c0 1.104 0.896 2 2 2h26c1.104 0 2-0.896 2-2v-16.938c0-1.104-0.896-2-2-2zM6 23.969h-2v-14.938h2v14.938zM8 22.031h-1v-13h1v13zM11 22.031h-1v-13h1v13zM14 22.031h-2v-13h2v13zM16 22.031h-1v-13h1v13zM20 22.031h-2v-13h2v13zM22 22.031h-1v-13h1v13zM25 22.031h-1v-13h1v13zM28 23.969h-2v-14.938h2v14.938z"></path>
                    </g>
                </svg>
                <span class="text-xl font-bold">QF-Library</span>
            </a>
        </div>
        <div id="nav-links" class="hidden lg:flex items-center space-x-6">
            <a href="les-quizz.php" class="text-gray-700 hover:text-indigo-600 transition">Les Quizz</a>
            <a href="progression.php" class="text-gray-700 hover:text-indigo-600 transition">Ma progression</a>
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
                            <a href="progression.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Ma progression</a>
                            <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Admin</a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Déconnexion</a>
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
