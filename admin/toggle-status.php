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
            $current_status = $quiz_data['status'] ?? 'draft';
            $new_status = $current_status === 'published' ? 'draft' : 'published';
            $quiz_data['status'] = $new_status;

            if (file_put_contents($filepath, json_encode($quiz_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                header('Location: index.php?status=status_changed');
            } else {
                header('Location: index.php?status=error');
            }
            exit;
        }
    }
}

header('Location: index.php?status=not_found');
exit;
