<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Error: Only POST requests are allowed.");
}

echo "Form was submitted<br>";

// Retrieve form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

echo "Received: name = $name, email = $email, message = $message<br>";

// Connect to MySQL
$conn = new mysqli('localhost', 'root', '', 'guvgs');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connected<br>";

// Prepare SQL
$stmt = $conn->prepare("INSERT INTO contact_info ( name , email, message) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "Success! Data inserted.<br>";
} else {
    die("Execute failed: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
