<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Gestion des Quizz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php
    require_once 'auth-check.php';
    include '../header.php';
    ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <header class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-bold">Tableau de Bord Administrateur</h1>
        </header>

        <?php include 'nav.php'; ?>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl md:text-2xl font-semibold">Quizz Existants</h2>
            <a href="/admin/edit-quiz.php" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                Créer un quiz
            </a>
        </div>

        <section class="bg-white rounded-2xl shadow p-5 md:p-6">
            <h2 class="text-xl md:text-2xl font-semibold mb-4">Quizz Existants</h2>
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="p-2">Titre</th>
                        <th class="p-2">Niveau</th>
                        <th class="p-2">Statut</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $quizzes_dir = __DIR__ . '/../quizzes';
                    $quiz_files = glob($quizzes_dir . '/*.json');

                    if (empty($quiz_files)) {
                        echo '<tr><td colspan="4" class="p-2 text-center">Aucun quiz trouvé.</td></tr>';
                    } else {
                        foreach ($quiz_files as $file) {
                            $content = file_get_contents($file);
                            $data = json_decode($content, true);

                            if (!$data || !isset($data['id'])) continue;

                            $quiz_id = $data['id'];
                            $title = htmlspecialchars($data['main_title'] ?? 'Titre non défini');
                            $level = htmlspecialchars($data['level'] ?? 'Niveau non défini');
                            $status = htmlspecialchars($data['status'] ?? 'draft');

                            $status_color = $status === 'published' ? 'text-green-600' : 'text-yellow-600';
                            $action_text = $status === 'published' ? 'Dépublier' : 'Publier';
                            $action_link = "toggle-status.php?quiz_id={$quiz_id}";

                            echo <<<HTML
                            <tr class="border-b">
                                <td class="p-2">{$title}</td>
                                <td class="p-2">{$level}</td>
                                <td class="p-2 {$status_color}">{$status}</td>
                                <td class="p-2">
                                    <a href="/admin/edit-quiz.php?quiz_id={$quiz_id}" class="text-indigo-600 hover:underline">Modifier</a>
                                    <a href="/admin/{$action_link}" class="text-blue-600 hover:underline ml-4">{$action_text}</a>
                                    <a href="/admin/delete-quiz.php?quiz_id={$quiz_id}" class="text-red-600 hover:underline ml-4">Supprimer</a>
                                </td>
                            </tr>
HTML;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
