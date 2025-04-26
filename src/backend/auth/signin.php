<?php
// Start session
session_start();

// Include database connection
include 'db_connect.php';

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Validate input (basic)
if (empty($email) || empty($password)) {
    echo "Email and password are required!";
    exit;
}

// Fetch user from database
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo "Signin successful!";
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with this email.";
}

// Close connection
$stmt->close();
$conn->close();
?>
