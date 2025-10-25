<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ma progression</title>
    <meta name="description" content="Suivez votre progression sur les tests de positionnement." />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php
    require_once 'includes/db_setup.php';
    include 'header.php';
    ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <header class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-bold">Ma progression</h1>
            <p class="text-sm md:text-base text-gray-700 mt-2">
                Retrouvez ici un résumé de vos résultats aux différents tests.
            </p>
        </header>

        <section id="progression-container" class="space-y-4">
            <?php
            if (!isset($_SESSION['user_id'])) {
                echo '<p class="text-gray-600">Vous devez être <a href="login.php" class="text-blue-500">connecté</a> pour voir votre progression.</p>';
            } else {
                $db = get_db_connection();
                $stmt = $db->prepare("SELECT q.main_title, up.quiz_id, up.progress, up.score
                                      FROM user_progress up
                                      JOIN (SELECT id, main_title FROM quizzes) q ON up.quiz_id = q.id
                                      WHERE up.user_id = ?");

                // We need to load quizzes data to get total scores and titles.
                // Let's assume a function to get all quizzes data.
                function get_all_quizzes() {
                    $quizzes = [];
                    $quiz_files = glob('quizzes/*.json');
                    foreach ($quiz_files as $file) {
                        $quiz_data = json_decode(file_get_contents($file), true);
                        if ($quiz_data && isset($quiz_data['id'])) {
                            $quizzes[$quiz_data['id']] = $quiz_data;
                        }
                    }
                    return $quizzes;
                }

                $all_quizzes = get_all_quizzes();

                $stmt = $db->prepare("SELECT quiz_id, progress, score FROM user_progress WHERE user_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $progress_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($progress_data)) {
                    echo '<p class="text-gray-600">Vous n\'avez pas encore commencé de test.</p>';
                } else {
                    foreach ($progress_data as $progress) {
                        $quiz_id = $progress['quiz_id'];
                        $quiz_info = $all_quizzes[$quiz_id] ?? null;
                        $title = $quiz_info['main_title'] ?? $quiz_id;
                        $total_score = 0; // In a real scenario, this should be calculated from the quiz file.
                        if($quiz_info) {
                            foreach($quiz_info['questions'] as $q) {
                                // This is a simplified calculation. A more robust one would be needed.
                                if(isset($q['options'])) {
                                    foreach($q['options'] as $opt) {
                                        if(isset($opt['points']) && $opt['points'] > 0) {
                                            $total_score += $opt['points'];
                                        }
                                    }
                                }
                            }
                        }


                        $completed = $progress['progress'] == 100;
                        echo '
                        <div class="bg-white rounded-2xl shadow p-5 md:p-6">
                            <div class="flex justify-between items-start">
                                <h2 class="text-lg md:text-xl font-semibold">' . htmlspecialchars($title) . '</h2>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full ' . ($completed ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') . '">
                                    ' . ($completed ? 'Terminé' : 'En cours') . '
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mt-2">
                                Score : ' . $progress['score'] . ($total_score > 0 ? ' / ' . $total_score : '') . ' (' . $progress['progress'] . '%)
                            </p>
                            <div class="w-full bg-gray-200 h-2 rounded mt-2">
                                <div class="h-2 rounded ' . ($completed && $progress['progress'] == 100 ? 'bg-green-500' : 'bg-indigo-500') . '" style="width: ' . $progress['progress'] . '%"></div>
                            </div>
                        </div>';
                    }
                }
            }
            ?>
        </section>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
