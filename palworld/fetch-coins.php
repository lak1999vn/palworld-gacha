<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    // User is not logged in. Redirect them to the login page
    header('Location: login.html');
    exit;
}

$username = $_SESSION['username'];

// Include the configuration file
$config = include 'config.php';

$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $config['user'], $config['pass'], $opt);

// Fetch coins and name
$stmt = $pdo->prepare("SELECT `agi coins`, `name` FROM users WHERE username = ?");
$stmt->execute([$username]);
$userData = $stmt->fetch();

if (!isset($userData['name'])) {
    // Name is not set. Echo "...." and exit.
    echo "....";
    exit;
}

$coins = $userData['agi coins'];
$name = $userData['name'];

// Store the name in a session variable
$_SESSION['name'] = $name;

echo $coins;