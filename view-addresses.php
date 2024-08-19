<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    die("You must be logged in to view addresses.");
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

// Fetch addresses for the user
$sql = "SELECT * FROM addresses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$addresses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Addresses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>View Addresses</h1>
    <table>
        <thead>
            <tr>
                <th>Address Line 1</th>
                <th>Address Line 2</th>
                <th>City</th>
                <th>State</th>
                <th>Postal Code</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($addresses)): ?>
                <?php foreach ($addresses as $address): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($address['address_line1']); ?></td>
                        <td><?php echo htmlspecialchars($address['address_line2']); ?></td>
                        <td><?php echo htmlspecialchars($address['city']); ?></td>
                        <td><?php echo htmlspecialchars($address['state']); ?></td>
                        <td><?php echo htmlspecialchars($address['postal_code']); ?></td>
                        <td><?php echo htmlspecialchars($address['country']); ?></td>
                        <td>
                            <a href="edit-address.php?id=<?php echo $address['id']; ?>">Edit</a> |
                            <a href="delete-address.php?id=<?php echo $address['id']; ?>" onclick="return confirm('Are you sure you want to delete this address?');">Delete</a>
                        </td>

                    </tr>
                    <a href="manage-address.php" class="normal">Back</a>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No addresses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
