<?php
// decide.php
session_start();
// Embed the contents of warrior.json directly into the script
$items = [
    'common' => [
    "Cattiva",
     
    "Nitewing",
      
    "Vanwyrm",
       
    "Incineram",
        
    "Eikthyrdeer",
       
    "Chillet",
       
    "Loupmoon",
       
    "Leezpunk Ignis",
        
    "Jolthog",
       
    "Daedream",
        
    "Hoocrates",
     
    "Tocotoco",
    "Rushoar",
    "Vixy",
    "Mozzarina",
    "Chipiki",
    "Lamball",
    "Depresso",
    "Foxparks",
    "99 Exp",
    "99 Gold",
    "Uncommon skill fruit",
    ],
    'rare' => [
        'Penking',
         
        'Incineram Noct',
           
        'Ragnahawk',
           
        'Helzephyr',
           
        'Dinossom',
           
        'Felbat',
           
        'Katress',
           
        'Pyrin Noct',
            
        'Univolt',
           
        'Quivern',
           
        'Beakon',
         
        'Rayhound',
        'Tombat',
        'Tanzee',
        'Lifmunk',
        'Flopie',
        'Bristla',
        'Beegarde',
        'Incineram',
        'Pyrin',
        '999 Exp',
        '999 Gold',
        "Rare skill fruit",
        ],
    'epic' => [

        "Grizzbolt",
           
        "Blazehowl Noct",
            
        "Blazamut",
            
        "Suzaku",
          
        "Relaxaurus Lux",
           
        "Menasting",
           
        "Relaxaurus",
           
        "Warsect",
            
        "Lyleen Noct",
     
        "Ice Reptyro",
        "Distoise",
        "Elizabee",
        "Vaelet",
        "Robinquill",
        "Wixen",
        "Reptyro",
        "9999 Exp",
        "9999 Gold",
        "Epic skill fruit",
            
    ],
    'legendary' => [
        "Mew-One",
        
        "Drogon",
      
        "Frostallion",
            
        "Frostallion Noct",
 
        "Jetragon",

        "Necromus",
  
        "Paladius",
 
        "Shadowbeak",
        "Astegon",
        "Lyleen",
        "Petallia",
        "Verdash",
        "Anubis",
        "Jormuntide Ignis",
        "99999 Exp",
        "99999 Gold",
        "All skill fruit",
    ],
    'mythical' => [
        "Fenrir the Wolfnarok (IV 130%)",
        "999999 Exp",
        "999999 Gold"

    ],
];
// Database connection details
$servername = "localhost";
$username = "root";
$password = "Lak8541692?";
$dbname = "login";

// Create a new PDO instance
$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Set the PDO error mode to exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Define the rarity values
$rarity_values = [
    'common' => 1,
    'rare' => 2,
    'epic' => 3,
    'legendary' => 4,
    'mythical' => 5,
];

// Check if the item skins array is set
if (isset($_POST['items'])) {
    $item_skins = json_decode($_POST['items'], true); // Decode the JSON string into an array

    // Loop through the item skins
    foreach ($item_skins as $skinObject) {
        $skin = $skinObject['skin']; // Get the skin property of the object

        // Loop through the items array
        foreach ($items as $rarity => $items_array) {
            // Loop through the items in the current rarity
            foreach ($items_array as $item) {
                // Check if the skin matches
                if ($item == $skin) {
                    // Print a debug message to the browser
                    echo "The rarity of $skin is $rarity.<br>";

                    // Get the value for the current rarity
                    $value = $rarity_values[$rarity];

                    // Prepare an SQL query to update the user's agi coins
                    $stmt = $db->prepare("UPDATE users SET `agi coins` = `agi coins` + :value WHERE username = :username");

                    // Bind the parameters
                    $stmt->bindParam(':value', $value);
                    $stmt->bindParam(':username', $_SESSION['username']);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "Updated agi coins for user {$_SESSION['username']} by $value.<br>";
                    } else {
                        echo "Failed to update agi coins for user {$_SESSION['username']} by $value.<br>";
                        print_r($stmt->errorInfo());
                    }

                    // Don't break out of the loops
                }
            }
        }
    }
} else {
    echo "No item skins received.";
}
?>