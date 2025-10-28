<?php
require_once 'auth-check.php';

$quiz_id = $_GET['quiz_id'] ?? null;

if ($quiz_id) {
    $quizzes_dir = __DIR__ . '/../quizzes';
    $quiz_files = glob($quizzes_dir . '/*.json');

    foreach ($quiz_files as $filepath) {
        $content = file_get_contents($filepath);
        $quiz_data = json_decode($content, true);

        if (isset($quiz_data['id']) && $quiz_data['id'] === $quiz_id) {
            if (isset($quiz_data['status']) && $quiz_data['status'] === 'published') {
                header('Location: index.php?status=error_published');
                exit;
            }

            if (unlink($filepath)) {
                header('Location: index.php?status=deleted');
            } else {
                header('Location: index.php?status=error_deleting');
            }
            exit;
        }
    }
}

header('Location: index.php?status=not_found');
exit;
