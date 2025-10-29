<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="mb-8">
    <ul class="flex border-b">
        <li class="-mb-px mr-1">
            <a class="<?php echo ($current_page === 'index.php') ? 'bg-white text-indigo-700 border-l border-t border-r rounded-t' : 'bg-gray-200 text-gray-500 hover:text-indigo-800'; ?> inline-block py-2 px-4 font-semibold" href="admin/index.php">Gestion des Quizz</a>
        </li>
        <li class="mr-1">
            <a class="<?php echo ($current_page === 'users.php') ? 'bg-white text-indigo-700 border-l border-t border-r rounded-t' : 'bg-gray-200 text-gray-500 hover:text-indigo-800'; ?> inline-block py-2 px-4 font-semibold" href="admin/users.php">Gestion des Utilisateurs</a>
        </li>
    </ul>
</nav>
