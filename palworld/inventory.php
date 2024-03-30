<?php
session_start();

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=login', 'root', 'Lak8541692?');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare the SQL query to fetch the row for the current user
$stmt = $db->prepare("SELECT * FROM inventory WHERE username = :username");
$stmt->execute([':username' => $_SESSION['username']]);

// Fetch the row for the current user
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Initialize an array to hold the column names
$columnNames = [];

// Loop through each cell in the row
foreach ($row as $columnName => $value) {
    // If the column name is 'username', skip this iteration
    if ($columnName == 'username') {
        continue;
    }

    // If the value is greater than 0
    if ($value > 0) {
        // Add the column name to the array as many times as the value
        for ($i = 0; $i < $value; $i++) {
            $columnNames[] = $columnName;
        }
    }
}

// Encode the array as JSON and print it out
echo json_encode($columnNames);