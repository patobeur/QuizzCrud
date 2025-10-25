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
            password TEXT NOT NULL
        )";
        $db->exec($sql_users);

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
