<?php
// Start the session
session_start();

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "Lak8541692?";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the username and password from the form data
$login_username = $_POST['username'];
$login_password = $_POST['password']; // In a real-world application, you should hash the password

// Query the database for the user
$sql = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $login_username, $login_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // User exists and provided correct password
  // Store the username in the session
  $_SESSION['username'] = $login_username;
  $_SESSION['name'] = $login_name;
  // Redirect to the case-opener.html page
  header('Location: warrior.php');
  exit;
} else {
  // User does not exist or provided incorrect password
  echo "Login failed";
}

$stmt->close();
$conn->close();
?>