<?php
    session_start(); // Start the session

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the items parameter is set
        if (isset($_POST['items'])) {
            // Decode the JSON string into a PHP array
    $items = json_decode($_POST['items'], true);

    // Print out the entire items array
    echo "Items array: ";
    var_dump($items);

            // Database connection
            $db = new mysqli('localhost', 'root', 'Lak8541692?', 'login');

            // Check connection
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            // Get the username from the session
            $username = $_SESSION['username'];

           // Loop through each item
foreach ($items as $item) {
    // Print out the current item
    echo "Current item: ";
    var_dump($item);

    // Prepare an SQL statement
$stmt = $db->prepare("UPDATE inventory SET `".$item['skin']."` = `".$item['skin']."` - 1 WHERE username = ? AND `".$item['skin']."` > 0");

    // Bind the username parameter
    $stmt->bind_param('s', $username);

    // Execute the statement
    $stmt->execute();
}

            // Close the database connection
            $db->close();
        } else {
            echo "No items received.";
        }
    } else {
        echo "Invalid request method.";
    }
?>