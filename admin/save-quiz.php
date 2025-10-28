<?php
require_once 'auth-check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_quiz_id = $_POST['quiz_id'] ?? null;
    $quiz_id = $original_quiz_id ?: uniqid('quiz_');

    // If we are editing an existing quiz, find and delete the old file
    if ($original_quiz_id) {
        $quizzes_dir = __DIR__ . '/../quizzes';
        $quiz_files = glob($quizzes_dir . '/*.json');

        foreach ($quiz_files as $filepath) {
            $content = file_get_contents($filepath);
            $data = json_decode($content, true);

            if (isset($data['id']) && $data['id'] === $original_quiz_id) {
                unlink($filepath);
                break;
            }
        }
    }

    $main_title = $_POST['main_title'] ?? 'Nouveau Quiz';
    $level = $_POST['level'] ?? 'Débutant';
    $card_description = $_POST['card_description'] ?? '';
    $themes = $_POST['themes'] ?? [];
    $status = $_POST['status'] ?? 'draft';
    $questions = json_decode($_POST['questions_json'] ?? '[]', true);

    $quiz_data = [
        'id' => $quiz_id,
        'main_title' => $main_title,
        'level' => $level,
        'card_description' => $card_description,
        'themes' => $themes,
        'questions' => $questions,
        'status' => $status
    ];

    // Other metadata that might be in the original files - you might want to preserve them
    // For a new quiz, you can set defaults
    if (!isset($quiz_data['time'])) {
        $quiz_data['time'] = 'N/A';
    }
    if (!isset($quiz_data['features'])) {
        $quiz_data['features'] = [];
    }
    if (!isset($quiz_data['title'])) {
        $quiz_data['title'] = $main_title;
    }
     if (!isset($quiz_data['description'])) {
        $quiz_data['description'] = $card_description;
    }


    $filename = 'quiz_' . $quiz_id . '.json';
    $filepath = __DIR__ . '/../quizzes/' . $filename;


    if (file_put_contents($filepath, json_encode($quiz_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        header('Location: index.php?status=success');
    } else {
        header('Location: edit-quiz.php?quiz_id=' . $quiz_id . '&status=error');
    }
    exit;
}
