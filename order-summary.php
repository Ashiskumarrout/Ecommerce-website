<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
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

                <?php if ($isLoggedIn): ?>
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
        <h2>Order Summary</h2>
        <form id="order-form" action="process-order.php" method="POST">
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
