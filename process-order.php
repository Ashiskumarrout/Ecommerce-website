<?php
$servername = "localhost";
$username = "root"; // your MySQL username
$password = "password"; // your MySQL password
$dbname = "ashis"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$full_name = $_POST['full-name'];
$phone = $_POST['phone'];
$pincode = $_POST['pincode'];
$state = $_POST['state'];
$city = $_POST['city'];
$house_no = $_POST['house-no'];
$building_name = $_POST['building-name'];
$road = $_POST['road'];
$colony = $_POST['colony'];
$payment_method = $_POST['payment'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO orders (full_name, phone, pincode, state, city, house_no, building_name, road, colony, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $full_name, $phone, $pincode, $state, $city, $house_no, $building_name, $road, $colony, $payment_method);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to thank-you page
    header("Location: thank-you.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
