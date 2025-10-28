<?php
require_once __DIR__ . '/../../private_quizzcrud/includes/auth_check.php';

// --- Data Loading ---
$tutoriel_id = $_GET['id'] ?? null;
if (!$tutoriel_id) {
    header("Location: les-tutoriels.php");
    exit;
}

$tutoriels_data = json_decode(file_get_contents(__DIR__ . '/../../private_quizzcrud/tutoriels.json'), true);
$tutoriel_details = null;
$categorie_nom = null;

foreach ($tutoriels_data['categories'] as $categorie) {
    foreach ($categorie['tutoriels'] as $tuto) {
        if ($tuto['id'] === $tutoriel_id) {
            $tutoriel_details = $tuto;
            $categorie_nom = $categorie['nom'];
            break 2;
        }
    }
}

if (!$tutoriel_details) {
    http_response_code(404);
    die("Tutoriel non trouvé.");
}

$pageTitle = htmlspecialchars($tutoriel_details['titre']);
// We need to buffer the output to set headers
ob_start();
?>
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <base href="/quizzcrud/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Tutoriel'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
<?php
// Now that the head is defined, we can include the header
require_once 'header.php';

// --- Content ---
?>
<div class="container mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="les-tutoriels.php" class="text-indigo-600 hover:text-indigo-800">Tutoriels</a>
            </li>
            <li class="flex items-center mx-2">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500"><?php echo htmlspecialchars($categorie_nom); ?></span>
            </li>
            <li class="flex items-center mx-2">
                 <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500"><?php echo htmlspecialchars($tutoriel_details['sous_categorie']); ?></span>
            </li>
        </ol>
    </nav>

    <article>
        <?php
        $tutoriel_file_path = __DIR__ . '/tutoriels/' . $tutoriel_details['fichier'];
        if (file_exists($tutoriel_file_path)) {
            include $tutoriel_file_path;
        } else {
            echo "<p class='text-red-500'>Le contenu du tutoriel est actuellement indisponible.</p>";
        }
        ?>
    </article>
</div>

<?php
require_once 'footer.php';
ob_end_flush();
?>
