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
$sqlFilePath = __DIR__ . '/../sql/ecocom_db.sql';

// Connect to MySQL server without selecting a database
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Database setup failed: Connection failed: {$conn->connect_error}");
}

// echo "Connected to MySQL server successfully.<br>";

// Check if SQL file exists
if (!file_exists($sqlFilePath)) {
    die("SQL file not found at: $sqlFilePath");
}

// Read SQL file
$sql = file_get_contents($sqlFilePath);
if ($sql === false) {
    die("Failed to read SQL file: $sqlFilePath");
}

// echo "SQL file loaded successfully.<br>";

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
    // Check if the statement is trying to create a database
    if (preg_match('/CREATE\s+DATABASE/i', $statement)) {
        // Check if the database already exists
        $dbName = preg_replace('/CREATE\s+DATABASE\s+IF\s+NOT\s+EXISTS\s+/i', '', $statement);
        $dbName = trim($dbName, '`');
        $result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'");
        if ($result->num_rows > 0) {
            // echo "Database '$dbName' already exists. Skipping creation.<br>";
            return;
        }
    }

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

// Create admin user
$adminUsername = 'admin';
$adminPassword = password_hash('admin', PASSWORD_DEFAULT);
$adminEmail = 'admin@admin.com';
$adminBirthdate = '1990-01-01';

$stmt = $conn->prepare("INSERT INTO users (email, username, password, birthdate) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $adminEmail, $adminUsername, $adminPassword, $adminBirthdate);
$stmt->execute();
echo "Admin user created successfully.<br>";

// Create 4 random gardens
$gardenNames = ['Eco Garden', 'Green Oasis', 'Urban Jungle', 'Harmony Park'];
$gardenDescriptions = [
    'A sustainable garden focused on eco-friendly practices.',
    'An oasis of greenery in the heart of the city.',
    'A wild and diverse urban garden ecosystem.',
    'A harmonious blend of native plants and community spaces.'
];
$gardenAddress = [
    '23 Jalan Bukit Bintang, 50200 Kuala Lumpur, Selangor, Malaysia',
    '17 Jalan Sultan Ismail, 11600 George Town, Penang, Malaysia',
    '4 Jalan Tebrau, 80100 Johor Bahru, Johor, Malaysia',
    '55 Jalan Gopeng, 31400 Ipoh, Perak, Malaysia'
];
$gardenStartDates = [
    '2025-01-01 09:00:00',
    '2025-02-15 10:00:00',
    '2025-03-01 08:30:00',
    '2025-04-15 11:00:00'
];
$gardenEndDates = [
    '2026-04-30 18:00:00',
    '2026-05-15 17:00:00',
    '2026-06-30 16:30:00',
    '2026-07-15 19:00:00'
];
$gardenRecurringDays = ['Monday', 'Wednesday', 'Friday', 'Saturday'];
$gardenRecurringStartTimes = ['09:00:00', '10:00:00', '08:30:00', '11:00:00'];
$gardenRecurringEndTimes = ['12:00:00', '13:00:00', '11:30:00', '14:00:00'];

for ($i = 0; $i < 4; $i++) {
    $stmt = $conn->prepare("INSERT INTO gardens (title, description, address, user_id, start_date, end_date, recurring_day, recurring_start_time, recurring_end_time) VALUES (?,?,?,1,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $gardenNames[$i], $gardenDescriptions[$i], $gardenAddress[$i], $gardenStartDates[$i], $gardenEndDates[$i], $gardenRecurringDays[$i], $gardenRecurringStartTimes[$i], $gardenRecurringEndTimes[$i]);
    $stmt->execute();
    echo "Garden '{$gardenNames[$i]}' created successfully.<br>";
}


// Close connection
$conn->close();
