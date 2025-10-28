<?php
// api/progress.php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    http_response_code(401);
    exit;
}

require_once __DIR__ . '/../../../private_quizzcrud/includes/db_setup.php';

$user_id = $_SESSION['user_id'];
$db = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get user progress for a specific quiz
    $quiz_id = $_GET['quiz_id'] ?? null;

    if (!$quiz_id) {
        // If no quiz_id, get all progress for the user
        $stmt = $db->prepare("SELECT quiz_id, progress, score, quiz_state FROM user_progress WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $progress = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($progress);
    } else {
        // Get progress for a specific quiz
        $stmt = $db->prepare("SELECT progress, score, quiz_state FROM user_progress WHERE user_id = ? AND quiz_id = ?");
        $stmt->execute([$user_id, $quiz_id]);
        $progress = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($progress) {
            // Decode the state from JSON
            $progress['quiz_state'] = $progress['quiz_state'] ? json_decode($progress['quiz_state'], true) : null;
            echo json_encode($progress);
        } else {
            echo json_encode(null); // Return null if no progress found
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save or update user progress
    $data = json_decode(file_get_contents('php://input'), true);
    $quiz_id = $data['quiz_id'] ?? null;
    $progress = $data['progress'] ?? 0;
    $score = $data['score'] ?? 0;
    $quiz_state = isset($data['quiz_state']) ? json_encode($data['quiz_state']) : null;


    if (!$quiz_id) {
        echo json_encode(['error' => 'Quiz ID is required']);
        http_response_code(400);
        exit;
    }

    // Check if progress already exists
    $stmt = $db->prepare("SELECT id FROM user_progress WHERE user_id = ? AND quiz_id = ?");
    $stmt->execute([$user_id, $quiz_id]);

    if ($stmt->fetch()) {
        // Update existing progress
        $stmt = $db->prepare("UPDATE user_progress SET progress = ?, score = ?, quiz_state = ? WHERE user_id = ? AND quiz_id = ?");
        $success = $stmt->execute([$progress, $score, $quiz_state, $user_id, $quiz_id]);
    } else {
        // Insert new progress
        $stmt = $db->prepare("INSERT INTO user_progress (user_id, quiz_id, progress, score, quiz_state) VALUES (?, ?, ?, ?, ?)");
        $success = $stmt->execute([$user_id, $quiz_id, $progress, $score, $quiz_state]);
    }

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to save progress']);
        http_response_code(500);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
    http_response_code(405);
}
