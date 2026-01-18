<?php
// Set timezone for all date/time functions
date_default_timezone_set('Asia/Manila'); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sia01";

// Create connection with error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Log the database connection error
    error_log("DATABASE_CONNECTION_ERROR: " . $e->getMessage() . " | Timestamp: " . date('Y-m-d H:i:s'));
    
    // User Friendly Error Message
    die("Unable to connect to the database. Please contact the administrator for assistance.");
}
?>