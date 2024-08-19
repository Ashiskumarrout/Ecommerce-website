<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    die("You must be logged in to delete addresses.");
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "ashis";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the address ID from the URL
$address_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($address_id <= 0) {
    die("Invalid address ID.");
}

// Prepare and execute SQL statement
$stmt = $conn->prepare("DELETE FROM addresses WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $address_id);
    if ($stmt->execute()) {
        $message = "Address deleted successfully.";
    } else {
        $message = "Error deleting address: " . $stmt->error;
    }
    $stmt->close();
} else {
    $message = "Error preparing statement: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Address</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Delete Address</h1>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="manage-address.php" class="normal">Back</a>
</body>
</html>
