session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if user_id is set
if (!isset($_SESSION['user_id'])) {
    echo "Error: User ID is not set in the session.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Continue with database operations
$servername = "localhost";
$username = "root"; 
$password = "password"; 
$dbname = "ashis"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch addresses
$sql = "SELECT * FROM addresses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Address</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="manage-address" class="section-p1">
        <h2>Manage Address</h2>

        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
                        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                        <p><strong>Pincode:</strong> <?php echo htmlspecialchars($row['pincode']); ?></p>
                        <p><strong>State:</strong> <?php echo htmlspecialchars($row['state']); ?></p>
                        <p><strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?></p>
                        <p><strong>House No:</strong> <?php echo htmlspecialchars($row['house_no']); ?></p>
                        <p><strong>Building Name:</strong> <?php echo htmlspecialchars($row['building_name']); ?></p>
                        <p><strong>Road/Area:</strong> <?php echo htmlspecialchars($row['road']); ?></p>
                        <p><strong>Colony:</strong> <?php echo htmlspecialchars($row['colony']); ?></p>
                        <a href="edit-address.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete-address.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this address?');">Delete</a>
                    </li>
                    <hr>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No addresses found.</p>
        <?php endif; ?>
    </section>
</body>
</html>

<?php
$conn->close();
?>
