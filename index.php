<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Liste des tests de positionnement</title>
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="bg-gray-100 text-gray-900">
		<div class="max-w-3xl mx-auto p-4 md:p-6">
			<header class="mb-6">
				<h1 class="text-2xl md:text-3xl font-bold">Tests de positionnement disponibles</h1>
				<p class="text-sm text-gray-700 mt-1">Cliquez sur un test pour le commencer.</p>
			</header>

			<div class="space-y-4">
				<?php
                $quizzes_dir = __DIR__ . '/quizzes';
                $quiz_files = glob($quizzes_dir . '/*.json');

                if (empty($quiz_files)) {
                    echo '<p class="text-red-500">Aucun quiz trouvé.</p>';
                } else {
                    foreach ($quiz_files as $file) {
                        $content = file_get_contents($file);
                        $data = json_decode($content, true);

                        if ($data && isset($data['title'])) {
                            $quiz_id = basename($file, '.json');
                            $title = htmlspecialchars($data['title']);
                            $description = htmlspecialchars($data['description'] ?? 'Pas de description.');

                            echo <<<HTML
                <a href="qcm.php?quiz={$quiz_id}" class="block bg-white rounded-2xl shadow p-5 hover:shadow-lg transition-shadow">
                    <h2 class="text-xl font-semibold text-indigo-600">{$title}</h2>
                    <p class="text-gray-600 mt-1 text-sm">{$description}</p>
                </a>
HTML;
                        }
                    }
                }
                ?>
			</div>
		</div>
	</body>
</html>
