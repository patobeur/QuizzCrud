<?php
// 1. Charger la configuration
$config_content = file_get_contents(__DIR__ . '/config.json');
$config = json_decode($config_content, true);

// 2. Valider le paramètre 'quiz'
$quiz_id = $_GET['quiz'] ?? null;
if (!$quiz_id) {
    die('Erreur : nom du quiz non spécifié.');
}

// 3. Trouver le fichier JSON basé sur l'ID
$quizzes_dir = __DIR__ . '/quizzes';
$quiz_files = glob($quizzes_dir . '/*.json');
$quiz_file = null;
$quiz_data = null;

foreach ($quiz_files as $file) {
    $content = file_get_contents($file);
    $data = json_decode($content, true);
    if (isset($data['id']) && $data['id'] === $quiz_id) {
        $quiz_file = $file;
        $quiz_data = $data;
        break;
    }
}

if (!$quiz_file) {
    http_response_code(404);
    die('Erreur : le quiz demandé n\'existe pas.');
}

// 4. Lire et décoder le fichier JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Erreur : impossible de lire les données du quiz.');
}

$title = htmlspecialchars($quiz_data['title'] ?? 'Test de positionnement');
$description = $quiz_data['description'] ?? 'Répondez aux questions ci-dessous.';
$level = $quiz_data['level'] ?? 'Niveau non défini';
$questions_json = json_encode($quiz_data['questions'] ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

// 5. Déterminer les couleurs
$level_color_name = $config['levels'][$level]['color'] ?? 'gray';
$color_styles = [
    'emerald' => ['progress' => 'bg-emerald-500', 'validate' => 'bg-emerald-600', 'reco' => 'bg-emerald-50 text-emerald-900 border-emerald-200'],
    'indigo' => ['progress' => 'bg-indigo-500', 'validate' => 'bg-indigo-600', 'reco' => 'bg-indigo-50 text-indigo-900 border-indigo-200'],
    'gray' => ['progress' => 'bg-gray-500', 'validate' => 'bg-gray-600', 'reco' => 'bg-gray-50 text-gray-900 border-gray-200'],
    'fuchsia' => ['progress' => 'bg-fuchsia-500', 'validate' => 'bg-fuchsia-600', 'reco' => 'bg-fuchsia-50 text-fuchsia-900 border-fuchsia-200'],
    'pink' => ['progress' => 'bg-pink-500', 'validate' => 'bg-pink-600', 'reco' => 'bg-pink-50 text-pink-900 border-pink-200'],
    'violet' => ['progress' => 'bg-violet-500', 'validate' => 'bg-violet-600', 'reco' => 'bg-violet-50 text-violet-900 border-violet-200'],
    'purple' => ['progress' => 'bg-purple-500', 'validate' => 'bg-purple-600', 'reco' => 'bg-purple-50 text-purple-900 border-purple-200'],
];
$colors = $color_styles[$level_color_name] ?? $color_styles['gray'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo $title; ?></title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
	<div class="max-w-3xl mx-auto p-4 md:p-6 w-full">
		<div class="bg-white rounded-2xl shadow p-5 md:p-6">
			<div class="mb-4">
				<div class="flex items-center justify-between text-sm text-gray-600">
					<span id="progress-label">Question 1 / X</span>
					<span id="score-label">Score : 0</span>
				</div>
				<div class="w-full bg-gray-200 h-2 rounded mt-2">
					<div id="progress-bar" class="<?php echo $colors['progress']; ?> h-2 rounded" style="width: 5%"></div>
				</div>
			</div>
			<div id="theme" class="text-xs uppercase tracking-wide text-gray-500 mb-2"></div>
			<h2 id="question" class="text-lg md:text-xl font-semibold mb-2"></h2>
			<div id="multi-help" class="hidden mb-3 text-xs text-gray-600">
				Plusieurs réponses peuvent être correctes. Sélectionnez toutes les bonnes réponses.
			</div>
			<form id="options" class="space-y-2 mb-4"></form>
			<div id="feedback" class="hidden p-3 rounded-lg text-sm"></div>
			<details id="relevance" class="hidden mt-2">
				<summary class="cursor-pointer text-sm text-gray-700 font-medium">Pourquoi cette question est pertinente ?</summary>
				<div class="mt-1 text-sm text-gray-600" id="relevance-text"></div>
			</details>
			<div class="mt-6 flex flex-wrap gap-2">
				<button id="prev-btn" class="px-4 py-2 rounded-xl border text-sm disabled:opacity-40" type="button">Précédent</button>
				<button id="validate-btn" class="px-4 py-2 rounded-xl <?php echo $colors['validate']; ?> text-white text-sm" type="button">Valider</button>
				<button id="next-btn" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm disabled:opacity-40" type="button" disabled>Suivant</button>
				<button id="finish-btn" class="ml-auto px-4 py-2 rounded-xl bg-gray-900 text-white text-sm hidden" type="button">Voir l’avis final</button>
			</div>
		</div>
		<div id="final" class="hidden bg-white rounded-2xl shadow p-5 md:p-6 mt-6">
			<h3 class="text-xl font-semibold mb-2">Avis final</h3>
			<p id="final-summary" class="mb-4 text-gray-800"></p>
			<ul id="final-flags" class="list-disc pl-6 text-sm text-gray-700 mb-4"></ul>
			<div id="recos" class="p-4 rounded-xl"></div>
			<details class="mt-6">
				<summary class="cursor-pointer text-sm text-gray-700 font-medium">Voir le récap par question</summary>
				<div id="recap" class="mt-3 space-y-3"></div>
			</details>
			<div class="mt-6 flex gap-2">
				<button id="restart-btn" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm" type="button">Recommencer</button>
				<button id="export-btn" class="px-4 py-2 rounded-xl border text-sm" type="button">Exporter mes réponses (JSON)</button>
			</div>
		</div>
	</div>
    <?php include 'footer.php'; ?>
	<script>
		const QUESTIONS = <?php echo $questions_json; ?>;
	</script>
	<script src="js/qcm.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
