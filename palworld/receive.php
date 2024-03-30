<?php
// Start the session
session_start();

// Database configuration
$db_host = 'localhost'; // Replace with your database host
$db_name = 'login'; // Replace with your database
$db_user = 'root'; // Replace with your database username
$db_pass = 'Lak8541692?'; // Replace with your database password

try {
    // Connect to the database
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    // Handle any connection errors
    die("Connection failed: " . $e->getMessage());
}

// Prepare an SQL query to fetch the user's name
$stmt = $db->prepare("SELECT `name` FROM users WHERE username = :username");

// Bind the parameters
$stmt->bindParam(':username', $_SESSION['username']);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Store the user's name in the session
$_SESSION['name'] = $result['name'];

// Send the user's name to the client-side
echo '<script type="text/javascript">console.log("User\'s name: ' . $_SESSION['name'] . '");</script>';

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
    // Your Discord Webhook URL
$webhookurl = "https://discord.com/api/webhooks/1223319909711351939/kK5df6ZP-6-mu1kv2dJ-IA-ojgoUN9_FYUdE00-RC-AMLxIB-PxXC1yI-SptrWfqvH-Z";

foreach ($items as $item) {
    // The message you want to send
    $msg = $_SESSION['name'] . " wants to receive " . $item['skin'];

    // The JSON data
    $json_data = array ('content'=> $msg);
    $make_json = json_encode($json_data);

    // Create a new cURL resource
$ch = curl_init($webhookurl);

// Setup options for the cURL resource
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $make_json);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Send the request
$response = curl_exec($ch);

// Check if the request was successful
if ($response === false) {
    // The request failed, output the error
    echo 'Error: ' . curl_error($ch);
} else {
    // The request was successful, output the response
    echo 'Response: ' . $response;
}

// Close cURL resource
curl_close($ch);
}
?>