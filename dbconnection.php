<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = ""; // Typically empty in XAMPP
$dbName = "login_register";

// Create the database connection using MySQLi
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

// Check if the connection is successful
if (!$conn) {
    // Use more detailed error messages for debugging
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set character set to UTF-8 for better compatibility with different languages and special characters
mysqli_set_charset($conn, "utf8");

?>
