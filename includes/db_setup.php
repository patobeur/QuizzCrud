<?php
// includes/db_setup.php

// Define the path to the SQLite database file
define('DB_PATH', __DIR__ . '/../quiz.db');

// Function to initialize the database
function initialize_database() {
    try {
        $db = new PDO('sqlite:' . DB_PATH);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL to create the 'users' table
        $sql_users = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'user',
            password_reset_required INTEGER NOT NULL DEFAULT 0
        )";
        $db->exec($sql_users);

        // Check if role column exists and add it if not
        $stmt = $db->query("PRAGMA table_info(users)");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
        if (!in_array('role', $columns)) {
            $db->exec("ALTER TABLE users ADD COLUMN role TEXT NOT NULL DEFAULT 'user'");
        }
        if (!in_array('password_reset_required', $columns)) {
            $db->exec("ALTER TABLE users ADD COLUMN password_reset_required INTEGER NOT NULL DEFAULT 0");
        }

        // Create a default admin user if no admin exists
        $stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
        if ($stmt->fetchColumn() == 0) {
            $username = 'admin';
            $password = 'password';
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'admin';
            $password_reset_required = 1;

            $insert_stmt = $db->prepare("INSERT INTO users (username, password, role, password_reset_required) VALUES (?, ?, ?, ?)");
            $insert_stmt->execute([$username, $hashed_password, $role, $password_reset_required]);
        }

        // SQL to create the 'user_progress' table
        $sql_user_progress = "
        CREATE TABLE IF NOT EXISTS user_progress (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            quiz_id TEXT NOT NULL,
            progress INTEGER DEFAULT 0,
            score INTEGER DEFAULT 0,
            quiz_state TEXT,
            FOREIGN KEY (user_id) REFERENCES users(id),
            UNIQUE(user_id, quiz_id)
        )";
        $db->exec($sql_user_progress);

        // Check if quiz_state column exists and add it if not
        $stmt = $db->query("PRAGMA table_info(user_progress)");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
        if (!in_array('quiz_state', $columns)) {
            $db->exec("ALTER TABLE user_progress ADD COLUMN quiz_state TEXT");
        }


        // Close the database connection
        $db = null;

    } catch (PDOException $e) {
        // Handle any potential errors
        echo "Database connection failed: " . $e->getMessage();
        exit;
    }
}

// Automatically initialize the database when this file is included
initialize_database();

// Function to get a database connection
function get_db_connection() {
    try {
        $db = new PDO('sqlite:' . DB_PATH);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        // In a real application, you might want to log this error
        // instead of displaying it to the user.
        die("Database connection failed: " . $e->getMessage());
    }
}
