<?php
// 1. Valider le paramètre 'quiz'
$quiz_id = $_GET['quiz'] ?? null;
if (!$quiz_id) {
    die('Erreur : nom du quiz non spécifié.');
}

// 2. Sécuriser le nom du fichier pour éviter les attaques (path traversal)
$basename = basename($quiz_id);
$quiz_file = __DIR__ . '/quizzes/' . $basename . '.json';

if (!file_exists($quiz_file)) {
    http_response_code(404);
    die('Erreur : le quiz demandé n\'existe pas.');
}

// 3. Lire et décoder le fichier JSON
$json_content = file_get_contents($quiz_file);
$quiz_data = json_decode($json_content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Erreur : impossible de lire les données du quiz.');
}

$title = htmlspecialchars($quiz_data['title'] ?? 'Test de positionnement');
$description = $quiz_data['description'] ?? 'Répondez aux questions ci-dessous.';
$questions_json = json_encode($quiz_data['questions'] ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php echo $title; ?></title>
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="bg-gray-100 text-gray-900">
		<div class="max-w-3xl mx-auto p-4 md:p-6">
			<header class="mb-6">
				<h1 class="text-2xl md:text-3xl font-bold"><?php echo $title; ?></h1>
				<p class="text-sm text-gray-700 mt-1"><?php echo $description; ?></p>
			</header>

			<!-- Carte principale -->
			<div class="bg-white rounded-2xl shadow p-5 md:p-6">
				<!-- Progression -->
				<div class="mb-4">
					<div class="flex items-center justify-between text-sm text-gray-600">
						<span id="progress-label">Question 1 / X</span>
						<span id="score-label">Score : 0</span>
					</div>
					<div class="w-full bg-gray-200 h-2 rounded mt-2">
						<div id="progress-bar" class="bg-emerald-500 h-2 rounded" style="width: 5%"></div>
					</div>
				</div>

				<!-- Contenu dynamique du quiz -->
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

				<!-- Contrôles -->
				<div class="mt-6 flex flex-wrap gap-2">
					<button id="prev-btn" class="px-4 py-2 rounded-xl border text-sm disabled:opacity-40" type="button">Précédent</button>
					<button id="validate-btn" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm" type="button">Valider</button>
					<button id="next-btn" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm disabled:opacity-40" type="button" disabled>Suivant</button>
					<button id="finish-btn" class="ml-auto px-4 py-2 rounded-xl bg-gray-900 text-white text-sm hidden" type="button">Voir l’avis final</button>
				</div>
			</div>

			<!-- Résultat final -->
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

		<script>
			const QUESTIONS = <?php echo $questions_json; ?>;
		</script>
		<script src="qcm.js"></script>
	</body>
</html>
