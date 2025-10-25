<?php
session_start();

// Basic security check - ensure the user is logged in, and in a real app, you'd check for admin role
if (!isset($_SESSION['user_id'])) {
    die('Accès non autorisé.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = $_POST['quiz_id'] ?: uniqid('quiz_');
    $main_title = $_POST['main_title'] ?? 'Nouveau Quiz';
    $level = $_POST['level'] ?? 'Débutant';
    $card_description = $_POST['card_description'] ?? '';
    $themes = $_POST['themes'] ?? [];
    $questions = json_decode($_POST['questions_json'] ?? '[]', true);

    $quiz_data = [
        'id' => $quiz_id,
        'main_title' => $main_title,
        'level' => $level,
        'card_description' => $card_description,
        'themes' => $themes,
        'questions' => $questions,
        'status' => 'draft' // Always save as draft initially
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


    if (file_put_contents($filepath, json_encode($quiz_data, JSON_PRETTY_PRINT))) {
        header('Location: index.php?status=success');
    } else {
        header('Location: edit-quiz.php?quiz_id=' . $quiz_id . '&status=error');
    }
    exit;
}
