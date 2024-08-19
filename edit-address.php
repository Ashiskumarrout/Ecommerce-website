<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    die("You must be logged in to edit addresses.");
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

// Fetch the address details
$sql = "SELECT * FROM addresses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $address_id);
$stmt->execute();
$address = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$address) {
    die("Address not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $address_line1 = isset($_POST['address_line1']) ? $conn->real_escape_string($_POST['address_line1']) : '';
    $address_line2 = isset($_POST['address_line2']) ? $conn->real_escape_string($_POST['address_line2']) : '';
    $city = isset($_POST['city']) ? $conn->real_escape_string($_POST['city']) : '';
    $state = isset($_POST['state']) ? $conn->real_escape_string($_POST['state']) : '';
    $postal_code = isset($_POST['postal_code']) ? $conn->real_escape_string($_POST['postal_code']) : '';
    $country = isset($_POST['country']) ? $conn->real_escape_string($_POST['country']) : '';

    if (empty($address_line1) || empty($city) || empty($state) || empty($postal_code) || empty($country)) {
        $message = "Please fill in all required fields.";
    } else {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("UPDATE addresses SET address_line1 = ?, address_line2 = ?, city = ?, state = ?, postal_code = ?, country = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ssssssi", $address_line1, $address_line2, $city, $state, $postal_code, $country, $address_id);
            if ($stmt->execute()) {
                $message = "Address updated successfully.";
            } else {
                $message = "Error updating address: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Address</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Address</h1>

    <form action="edit-address.php?id=<?php echo $address_id; ?>" method="post">
        <label for="address_line1">Address Line 1:</label>
        <input type="text" id="address_line1" name="address_line1" value="<?php echo htmlspecialchars($address['address_line1']); ?>" required>
        
        <label for="address_line2">Address Line 2:</label>
        <input type="text" id="address_line2" name="address_line2" value="<?php echo htmlspecialchars($address['address_line2']); ?>">
        
        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($address['city']); ?>" required>
        
        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($address['state']); ?>" required>
        
        <label for="postal_code">Postal Code:</label>
        <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($address['postal_code']); ?>" required>
        
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($address['country']); ?>" required>
        
        <input type="submit" value="Update Address">
        <a href="manage-address.php" class="normal">Back</a>
    </form>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>
