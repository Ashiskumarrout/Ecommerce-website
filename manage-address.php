<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    die("You must be logged in to manage addresses.");
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

// Get the username from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
if (empty($username)) {
    die("Username is not set in the session.");
}

// Fetch the user_id using the username
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
} else {
    die("User not found.");
}
$stmt->close();

// Initialize $show_form variable
$show_form = true;

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
        $stmt = $conn->prepare("INSERT INTO addresses (user_id, address_line1, address_line2, city, state, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issssss", $user_id, $address_line1, $address_line2, $city, $state, $postal_code, $country);
            if ($stmt->execute()) {
                $message = "Address added successfully.";
                $show_form = false;
            } else {
                $message = "Error adding address: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }
    }
}

// Fetch addresses for display
$addresses = [];
if (!$show_form) {
    $sql = "SELECT * FROM addresses WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Address</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .hidden { display: none; }
        .address-list { margin-top: 20px; }
        .address-item { margin-bottom: 10px; }
        .address-details { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Manage Address</h1>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if ($show_form): ?>
    <form action="manage-address.php" method="post">
        <label for="address_line1">Address Line 1:</label>
        <input type="text" id="address_line1" name="address_line1" required>
        
        <label for="address_line2">Address Line 2:</label>
        <input type="text" id="address_line2" name="address_line2">
        
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
        
        <label for="state">State:</label>
        <input type="text" id="state" name="state" required>
        
        <label for="postal_code">Postal Code:</label>
        <input type="text" id="postal_code" name="postal_code" required>
        
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required>
        
        <input type="submit" value="Add Address">
    </form>
    <?php endif; ?>

    <?php if (!empty($addresses)): ?>
    <div class="address-list">
        <?php foreach ($addresses as $address): ?>
        <div class="address-item">
            <p>
                <strong>Address Line 1:</strong> <?php echo htmlspecialchars($address['address_line1']); ?><br>
                <strong>Address Line 2:</strong> <?php echo htmlspecialchars($address['address_line2']); ?><br>
                <strong>City:</strong> <?php echo htmlspecialchars($address['city']); ?><br>
                <strong>State:</strong> <?php echo htmlspecialchars($address['state']); ?><br>
                <strong>Postal Code:</strong> <?php echo htmlspecialchars($address['postal_code']); ?><br>
                <strong>Country:</strong> <?php echo htmlspecialchars($address['country']); ?><br>
                <button onclick="toggleDetails('details-<?php echo $address['id']; ?>')">View</button>
                <a href="edit-address.php?id=<?php echo $address['id']; ?>">Edit</a> |
                <a href="delete-address.php?id=<?php echo $address['id']; ?>">Delete</a>
            </p>
            <div id="details-<?php echo $address['id']; ?>" class="address-details hidden">
                <p>
                    <strong>Address Line 1:</strong> <?php echo htmlspecialchars($address['address_line1']); ?><br>
                    <strong>Address Line 2:</strong> <?php echo htmlspecialchars($address['address_line2']); ?><br>
                    <strong>City:</strong> <?php echo htmlspecialchars($address['city']); ?><br>
                    <strong>State:</strong> <?php echo htmlspecialchars($address['state']); ?><br>
                    <strong>Postal Code:</strong> <?php echo htmlspecialchars($address['postal_code']); ?><br>
                    <strong>Country:</strong> <?php echo htmlspecialchars($address['country']); ?><br>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <script>
        function toggleDetails(id) {
            var details = document.getElementById(id);
            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
            } else {
                details.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
