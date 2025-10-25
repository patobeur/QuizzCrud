<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Accès non autorisé.');
}

$quiz_id = $_GET['quiz_id'] ?? null;

if ($quiz_id) {
    $quizzes_dir = __DIR__ . '/../quizzes';
    $quiz_files = glob($quizzes_dir . '/*.json');
    $filepath = null;
    $quiz_data = null;

    foreach ($quiz_files as $file) {
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        if (isset($data['id']) && $data['id'] === $quiz_id) {
            $filepath = $file;
            $quiz_data = $data;
            break;
        }
    }

    if ($quiz_data && $filepath) {
        $current_status = $quiz_data['status'] ?? 'draft';
        $new_status = $current_status === 'published' ? 'draft' : 'published';
        $quiz_data['status'] = $new_status;

        if (file_put_contents($filepath, json_encode($quiz_data, JSON_PRETTY_PRINT))) {
            header('Location: index.php?status=status_changed');
        } else {
            header('Location: index.php?status=error');
        }
        exit;
    }
}

header('Location: index.php?status=not_found');
exit;
