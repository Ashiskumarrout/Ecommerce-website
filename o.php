<?php
session_start();
include 'database.php'; // Ensure this path is correct

if (!isset($_SESSION['user_id'])) {
    header('Location: akas.php'); // Redirect to login if not authenticated
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $userId = $_SESSION['user_id'];
    $fullName = $_POST['full-name'];
    $phone = $_POST['phone'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $houseNo = $_POST['house-no'];
    $buildingName = $_POST['building-name'];
    $road = $_POST['road'];
    $colony = $_POST['colony'];
    $payment = $_POST['payment'];

    // Save the order to the database
    $query = "INSERT INTO orders (user_id, full_name, phone, pincode, state, city, house_no, building_name, road, colony, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId, $fullName, $phone, $pincode, $state, $city, $houseNo, $buildingName, $road, $colony, $payment]);

    // Redirect to order summary page with the order ID
    $orderId = $pdo->lastInsertId(); // Get the last inserted order ID
    header("Location: o.php?order_id=$orderId");
    exit;
}

// Handle displaying the order summary
$order = null;
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Fetch order details from the database
    $query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$orderId, $_SESSION['user_id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo 'Order not found.';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <script src="https://kit.fontawesome.com/e6878467af.js" crossorigin="anonymous"></script>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Ecmerse photos/smalllogo.png" alt="Logo" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="shope.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-cart-plus"></i></a></li>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                    <li class="user-info">
                        <a href="akas.php"><img src="<?php echo htmlspecialchars($_SESSION['profile_photo']); ?>" alt="Profile Photo" class="profile-photo"></a>
                        <a href="akas.php?logout=true" class="logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li id="login"><a href="akas.php"><i class="fa-solid fa-user-circle"></i> Login</a></li>
                <?php endif; ?>

                <a href="#" id="close"><i class="fa-solid fa-circle-xmark" style="color: #19191a;"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-cart-plus"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="order-summary" class="section-p1">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <h2>Order Summary</h2>
            <h3>Order ID: <?php echo htmlspecialchars($orderId); ?></h3>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <p><strong>Pincode:</strong> <?php echo htmlspecialchars($pincode); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($state); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($city); ?></p>
            <p><strong>House No:</strong> <?php echo htmlspecialchars($houseNo); ?></p>
            <p><strong>Building Name:</strong> <?php echo htmlspecialchars($buildingName); ?></p>
            <p><strong>Road/Area:</strong> <?php echo htmlspecialchars($road); ?></p>
            <p><strong>Colony:</strong> <?php echo htmlspecialchars($colony); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment); ?></p>
        <?php elseif (isset($order)): ?>
            <h2>Order Summary</h2>
            <h3>Order ID: <?php echo htmlspecialchars($order['id']); ?></h3>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
            <p><strong>Pincode:</strong> <?php echo htmlspecialchars($order['pincode']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($order['state']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
            <p><strong>House No:</strong> <?php echo htmlspecialchars($order['house_no']); ?></p>
            <p><strong>Building Name:</strong> <?php echo htmlspecialchars($order['building_name']); ?></p>
            <p><strong>Road/Area:</strong> <?php echo htmlspecialchars($order['road']); ?></p>
            <p><strong>Colony:</strong> <?php echo htmlspecialchars($order['colony']); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
        <?php else: ?>
            <h2>Place Your Order</h2>
            <form id="order-form" action="o.php" method="POST">
                <h3>Delivery Address</h3>
                <label for="full-name">Full Name:</label>
                <input type="text" id="full-name" name="full-name" required>
                
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required>
                
                <label for="pincode">Pincode:</label>
                <input type="text" id="pincode" name="pincode" pattern="[0-9]{6}" title="Please enter a 6-digit pincode" required>
                
                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>
                
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
                
                <label for="house-no">House No:</label>
                <input type="text" id="house-no" name="house-no" required>
                
                <label for="building-name">Building Name:</label>
                <input type="text" id="building-name" name="building-name" required>
                
                <label for="road">Road/Area:</label>
                <input type="text" id="road" name="road" required>
                
                <label for="colony">Colony:</label>
                <input type="text" id="colony" name="colony" required>

                <h3>Payment Options</h3>
                <input type="radio" id="cash-on-delivery" name="payment" value="cash-on-delivery" checked>
                <label for="cash-on-delivery">Cash on Delivery</label>
                <br>
                <input type="radio" id="card-payment" name="payment" value="card-payment">
                <label for="card-payment">Card Payment</label>
                <br>

                <button type="submit" class="normal">Place Order</button>
            </form>
        <?php endif; ?>
    </section>

    <section id="newsletter" class="section-p1">
        <div class="newstext">
            <h4>Sign up for our newsletter</h4>
            <p>Get email updates about our latest shop and <span>special offers</span>.</p>
        </div>
        <div class="form">
            <input type="email" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>
</body>
</html>
