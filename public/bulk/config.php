<?php

// Database connection settings
$host = 'localhost';
$dbname = 'your_database';
$username = 'your_database_user';
$password = 'your_database_password';

// TMDb API key use your personal
$api_key = '1bfdbff05c2698dc917dd28c08d41096';
// update with your license key
$license_key = 'N6O7P8Q9R0';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>
