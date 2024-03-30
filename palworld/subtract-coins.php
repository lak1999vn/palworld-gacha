<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    echo "Error: User not logged in";
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

// Fetch current coins
$stmt = $pdo->prepare("SELECT `agi coins` FROM users WHERE username = ?");
$stmt->execute([$username]);
$coins = $stmt->fetchColumn();

if ($coins <= 0) {
    echo "Insufficient Balance";
    exit;
}

// Subtract coins
$stmt = $pdo->prepare("UPDATE users SET `agi coins` = `agi coins` - 10 WHERE username = ? AND `agi coins` > 0");
$stmt->execute([$username]);

// Fetch updated coins
$stmt = $pdo->prepare("SELECT `agi coins` FROM users WHERE username = ?");
$stmt->execute([$username]);
$coins = $stmt->fetchColumn();

echo $coins;
?>