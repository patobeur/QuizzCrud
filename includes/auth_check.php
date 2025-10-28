<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php?redirect_url=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}
