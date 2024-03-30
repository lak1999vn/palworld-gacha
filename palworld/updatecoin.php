<?php
// updatecoin.php

// Start the session
session_start();

// Database configuration
$db_host = 'localhost'; // Replace with your database host
$db_name = 'login'; // Replace with your database name
$db_user = 'root'; // Replace with your database username
$db_pass = 'Lak8541692?'; // Replace with your database password

try {
    // Connect to the database
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    // Handle any connection errors
    die("Connection failed: " . $e->getMessage());
}

// Prepare an SQL query to fetch the user's agi coins
$stmt = $db->prepare("SELECT `agi coins` FROM users WHERE username = :username");

// Bind the parameters
$stmt->bindParam(':username', $_SESSION['username']);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Return the agi coins value
echo $result['agi coins'];
?>