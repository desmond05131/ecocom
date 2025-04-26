<?php
// Include database connection
include 'db_connect.php';

// Get the submitted form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$birthdate = $_POST['birthdate'];

// Validate input (basic)
if (empty($username) || empty($email) || empty($password) || empty($birthdate)) {
    echo "All fields are required!";
    exit;
}

// Hash the password (security 🔒)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO users (username, email, password, birthdate) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $hashed_password, $birthdate);

if ($stmt->execute()) {
    echo "Signup successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
