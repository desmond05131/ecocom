<?php
/**
 * Database Setup Script for EcoCom Project
 *
 * This script creates the database and all required tables for the EcoCom project.
 * It uses the SQL file located at src/database/ecocom_db.sql to set up the database structure.
 * Run this script once to set up your database structure.
 */

// Database connection parameters
$host = 'localhost';
$user = 'root';
$pass = 'root'; // Update with your MySQL password if needed
$charset = 'utf8mb4';
$sqlFilePath = __DIR__ . '/../../frontend/sql/ecocom_db.sql';

// Connect to MySQL server without selecting a database
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Database setup failed: Connection failed: {$conn->connect_error}");
}

echo "Connected to MySQL server successfully.<br>";

// Check if SQL file exists
if (!file_exists($sqlFilePath)) {
    die("SQL file not found at: $sqlFilePath");
}

// Read SQL file
$sql = file_get_contents($sqlFilePath);
if ($sql === false) {
    die("Failed to read SQL file: $sqlFilePath");
}

echo "SQL file loaded successfully.<br>";

// Split SQL file into individual statements
$statements = array_filter(
    array_map(
        'trim',
        explode(';', $sql)
    ),
    fn($statement) => !empty($statement)
);

// Execute each statement
foreach ($statements as $statement) {
    if ($conn->query($statement) === TRUE) {
        // Extract table name for logging (simple regex to get table name after CREATE TABLE IF NOT EXISTS)
        if (preg_match('/CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+(\w+)/i', $statement, $matches)) {
            echo "Table '{$matches[1]}' created or already exists.<br>";
        } elseif (preg_match('/CREATE\s+DATABASE/i', $statement)) {
            echo "Database created or already exists.<br>";
        } elseif (preg_match('/USE\s+(\w+)/i', $statement, $matches)) {
            echo "Using database '{$matches[1]}'.<br>";
        } elseif (preg_match('/CREATE\s+INDEX/i', $statement)) {
            echo "Index created successfully.<br>";
        }
    } else {
        echo "Error executing statement: {$conn->error}<br>";
        echo "Statement: {$statement}<br>";
    }
}

echo "<br><strong>Database setup completed successfully!</strong>";

// Close connection
$conn->close();
