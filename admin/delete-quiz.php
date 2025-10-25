<?php
require_once 'auth-check.php';

$quiz_id = $_GET['quiz_id'] ?? null;

if ($quiz_id) {
    $filename = 'quiz_' . $quiz_id . '.json';
    $filepath = __DIR__ . '/../quizzes/' . $filename;

    if (file_exists($filepath)) {
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
