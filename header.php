<header id="header" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button id="burger-menu" class="lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            <a href="/" class="flex items-center space-x-2">
                <img src="https://avatars.githubusercontent.com/u/129993345?s=200&v=4" alt="QF-Library Logo" class="h-8 w-8 rounded-full">
                <span class="text-xl font-bold">QF-Library</span>
            </a>
        </div>
        <div id="nav-links" class="hidden lg:flex items-center space-x-6">
            <a href="#" class="text-gray-700 hover:text-indigo-600 transition">Accueil</a>
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
            <div class="relative">
                <button id="profile-menu-button" class="flex items-center text-gray-700 hover:text-indigo-600 transition">
                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Profil</span>
                </button>
                <div id="profile-menu-dropdown" class="absolute hidden mt-2 right-0 w-48 z-10">
                    <div class="bg-white shadow-lg rounded-md">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Mon compte</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Paramètres</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<main id="main-content" class="flex-grow">