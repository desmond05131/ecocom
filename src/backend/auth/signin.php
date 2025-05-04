<?php
session_start();

require_once '../config/db_connect.php';

$sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL
)";
$conn->exec($sqlCreateTable);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input (basic example, you can improve it)
    if (empty($email) || empty($password)) {
        die("Please fill in all fields.");
    }

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "No user found with this email.";
        exit;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
    } else {
        echo "Invalid password.";
    }
}


// // Get form data
// $email = $_POST['email'];
// $password = $_POST['password'];

// // Validate input (basic)
// if (empty($email) || empty($password)) {
// echo "Email and password are required!";
// exit;
// }

// // Fetch user from database
// $sql = "SELECT * FROM users WHERE email = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $email);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows === 1) {
// $user = $result->fetch_assoc();

// // Verify password
// if (password_verify($password, $user['password'])) {
//     $_SESSION['user_id'] = $user['id'];
//     $_SESSION['username'] = $user['username'];

//     echo "Signin successful!";
// } else {
//     echo "Invalid password.";
// }
// } else {
// echo "No user found with this email.";
// }

// // Close connection
// $stmt->close();
// $conn->close();
// ?>
