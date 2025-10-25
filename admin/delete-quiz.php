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

    foreach ($quiz_files as $file) {
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        if (isset($data['id']) && $data['id'] === $quiz_id) {
            $filepath = $file;
            break;
        }
    }

    if ($filepath) {
        if (unlink($filepath)) {
            header('Location: index.php?status=deleted');
        } else {
            header('Location: index.php?status=error_deleting');
        }
        exit;
    }
}

header('Location: index.php?status=not_found');
exit;
