<?php
// Check if the item data is in the query string
if (isset($_GET['index']) && isset($_GET['skin']) && isset($_GET['rarity'])) {
    // Create a new item
    $item = [
        'index' => $_GET['index'],
        'skin' => $_GET['skin'],
        'rarity' => $_GET['rarity']
    ];

    // If the 'items' array doesn't exist in the session, create it
    if (!isset($_SESSION['items'])) {
        $_SESSION['items'] = [];
    }

    // Add the new item to the 'items' array in the session
    $_SESSION['items'][] = $item;
}
?>