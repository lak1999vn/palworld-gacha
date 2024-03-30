<?php
// decide.php
session_start();

function generate() {
    // Get the URL of the page that made the request
    $referer = $_SERVER['HTTP_REFERER'];

    // Extract the filename from the URL
    $filename = basename(parse_url($referer, PHP_URL_PATH));

    // Replace the extension with .json to get the name of the JSON file
    $jsonFile = str_replace('.php', '.json', $filename);

    // Load JSON file
    $json = file_get_contents($jsonFile);
    $items = json_decode($json, true);

    $rarity = 'common';
    $randed = rand(1, 1000);
    if ($randed <= 10) { // 1% chance for mythical
        $rarity = 'mythical';
    } else if ($randed <= 60) { // 5% chance for legendary
        $rarity = 'legendary';
    } else if ($randed <= 160) { // 10% chance for epic
        $rarity = 'epic';
    } else if ($randed <= 410) { // 25% chance for rare
        $rarity = 'rare';
    } // 59% chance for common

    if (!empty($items[$rarity])) {
        $item = $items[$rarity][array_rand($items[$rarity])];
    } else {
        // Default to 'common' rarity
        if (!empty($items['common'])) {
            $item = $items['common'][array_rand($items['common'])];
        } else {
            // Handle the case when there are no 'common' items
            // This could be throwing an exception, returning a default value, etc.
        }
    }

    // Return the entire item
    return $item;
}

$index = $_GET['index'];

$item = generate();
$item['index'] = $index;

// Add the reward message to the item

if ($index == 83) {
    $skin = $item['skin'];
    try {
        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=login', 'root', 'Lak8541692?');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the skin column exists
        $stmt = $db->prepare("SHOW COLUMNS FROM inventory LIKE :skin");
        $stmt->execute([':skin' => $skin]);

        // If the skin column exists
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            // Prepare the SQL query to increment the value in the cell
            $stmt = $db->prepare("UPDATE inventory SET `$skin` = `$skin` + 1 WHERE username = :username");
            $stmt->execute([':username' => $_SESSION['username']]);
        } else {
            echo "The $skin column does not exist in the inventory table.";
            exit;
        }
    } catch (PDOException $e) {
        // If there's an error, print it out and exit
        echo 'Database error: ' . $e->getMessage();
        exit;
    }
}

echo json_encode($item);




?>