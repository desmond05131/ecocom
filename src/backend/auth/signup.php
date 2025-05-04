<?php
// src/backend/auth/signup.php

// Include your database connection
require_once '../config/db_connect.php'; // adjust path if needed

// Create the 'users' table if it doesn't exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL
)";
$conn->exec($sqlCreateTable);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Collect and sanitize form data
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];

    // Validate input (basic example, you can improve it)
    if (empty($email) || empty($username) || empty($password) || empty($birthdate)) {
        die("Please fill in all fields.");
    }

    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an INSERT statement
    $sql = "INSERT INTO users (email, username, password, birthdate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($stmt->execute([$email, $username, $hashedPassword, $birthdate])) {
            $lastId = $conn->lastInsertId();
            $sql_read = "SELECT * FROM users WHERE id = ?";
            $readStmt = $conn->prepare(query: $sql_read);
            if ($readStmt && $readStmt->execute([$lastId])) {
                $user = $readStmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    echo "User found: " . print_r($user, true);
                } else {
                    echo "User not found in the database.";
                }
            } else {
                echo "Error reading user from database.";
            }
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error during signup: {$errorInfo[2]}";
        }
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Failed to prepare SQL statement: {$errorInfo[2]}";
    }
} else {
    // If not a POST request, block access
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed.";
}
