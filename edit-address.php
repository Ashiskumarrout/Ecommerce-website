<?php
session_start();
require 'db_connection.php'; // Include your database connection file

// Function to check if the form has been submitted
function hasAddressFormBeenSubmitted($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT address_form_submitted FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($submitted);
    $stmt->fetch();
    $stmt->close();
    return $submitted;
}

// Function to update the form submission status
function markAddressFormAsSubmitted($userId) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET address_form_submitted = TRUE WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

$userId = $_SESSION['user_id']; // Ensure you have user ID in session

// Check if the form has been submitted
$formHidden = hasAddressFormBeenSubmitted($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $addressLine1 = $_POST['address_line1'];
    $addressLine2 = $_POST['address_line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postal_code'];
    $country = $_POST['country'];

    // Insert or update address in the database
    // (Make sure to add appropriate SQL queries to handle address data)

    // Mark the form as submitted
    markAddressFormAsSubmitted($userId);

    // Redirect or show a success message
    header('Location: success.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Address</title>
    <style>
        .form-container {
            display: <?php echo $formHidden ? 'none' : 'block'; ?>;
        }
        .btn {
            padding: 8px 16px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
        }
        .btn-back {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="edit-address.php" method="post">
            <label for="address_line1">Address Line 1:</label>
            <input type="text" id="address_line1" name="address_line1" required><br>
            <label for="address_line2">Address Line 2:</label>
            <input type="text" id="address_line2" name="address_line2" required><br>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br>
            <label for="state">State:</label>
            <input type="text" id="state" name="state" required><br>
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required><br>
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required><br>
            <button type="submit">Submit</button>
        </form>
    </div>
    <a href="asak.php" class="btn btn-back">Back</a>
</body>
</html>
