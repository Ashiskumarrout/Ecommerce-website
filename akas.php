<?php
// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 86400, // 24 hours
    'path' => '/',
    'domain' => '', // Leave empty for the current domain
    'secure' => false, // Set to true if using HTTPS
    'httponly' => true,
    'samesite' => 'Lax', // or 'Strict'
]);

session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "password"; // Update with your MySQL password
$dbname = "ashis"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT password, username, profile_photo FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password, $username, $profile_photo);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            // Check password
            if (password_verify($password, $hashed_password)) {
                // Password is correct
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['profile_photo'] = $profile_photo;
                header("Location: akas.php");
                exit();
            } else {
                $message = "Invalid email or password.";
            }
        } else {
            $message = "Invalid email or password.";
        }

        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: akas.php");
    exit();
}

// Display content based on session state
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="account.css">
    <script defer src="script.js"></script>
    <script src="https://kit.fontawesome.com/e6878467af.js" crossorigin="anonymous"></script>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Ecmerse photos/smalllogo.png" alt="Logo" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shope.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-cart-plus"></i></a></li>

                <?php if ($isLoggedIn): ?>
                    <li class="user-info">
                        <a href="akas.php"><img src="<?php echo htmlspecialchars($_SESSION['profile_photo']); ?>" alt="Profile Photo" class="profile-photo"></a>
                        <a class="active"  href="akas.php?logout=true" class="logout">Logout</a>
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

    <?php if ($isLoggedIn): ?>
    <!-- Dashboard view when logged in -->
    <div class="main-content">
        <!-- Sidebar -->
        <!-- Sidebar -->
      <!-- Sidebar -->
<!-- Sidebar Links -->
<aside class="sidebar">
    <div class="profile-section">
        <img src="<?php echo htmlspecialchars($_SESSION['profile_photo']); ?>" alt="Profile Photo" class="sidebar-profile-photo">
        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    </div>
    <ul>
        <li><a href="#" data-target="profile-info">Profile Information</a></li>
        <!-- Add other sidebar links here -->
        <li><a href="#" data-target="my-orders">My Orders</a></li>
        <li><a href="#" data-target="account-settings">Account Settings</a>
            <ul>
                
            <li><a href="manage-address.php">Manage Address</a></li>


            <li><a href="account/pan-card.php">PAN Card Information</a></li>

            </ul>
        </li>
        <li><a href="account/cart.html">Payments</a>
            <ul>
                <li><a href="account/cart.html">Gift Cards</a></li>
                <li><a href="account/cart.html">Saved UPI</a></li>
                <li><a href="account/cart.html">Saved Cards</a></li>
            </ul>
        </li>
        <li><a href="#" data-target="help-center">Help Center</a>
            <ul>
                <li>Phone: 7008448569</li>
                <li>Email: support@example.com</li>
                <li><a href="account/chat.php">Chat Assistant</a></li>
            </ul>
        </li>
        <li><a href="account/fi.html">Feedback & Information</a></li>
        <li><a href="account/Terms.html">Terms & Policy</a></li>
        <li><a href="akas.php?logout=true">Logout</a></li>
    </ul>
</aside>

<!-- Main Content Area -->
<section class="content">
    <div id="welcome-message" class="content-section">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Profile Photo</p>
        <p>Select an option from the sidebar to view details.</p>
    </div>

    <div id="profile-info" class="content-section">
        <h2>Profile Information</h2>
        <p>Name: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <img src="<?php echo htmlspecialchars($_SESSION['profile_photo']); ?>" alt="Profile Photo">
    </div>

    <!-- Add other content sections here -->
</section>

    </div>
    <?php else: ?>
    <!-- Login box when not logged in -->
    <div class="login-box">
        <h1>Login</h1>
        <form action="akas.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="login" value="Login">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>

        <?php if (isset($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <section id="newsletter"  class="section-p1">
    <div class="newstext">
        <h4>Sign up for newsletter</h4>
        <p>Get E-mail updets your leters shop and <span> sepecial offer</span></p>
    </div>
<div class="form">
    <input type="text" placeholder="your E-mail addres">
    <button class="normal">sign up</button>
</div>

</section>
    <!-- Footer -->
    <footer class="section-p1">
        <div class="col">
            <img class="logo1" src="Ecmerse photos/smalllogo.png" alt="Company Logo">
            <h4>Contact</h4>
            <p><strong>Address:</strong> Cuttack, Odisha, near Chandhi Temple</p>
            <p><strong>Hours:</strong> 10:00-18:00, Mon-Sat</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <a href="https://facebook.com/AshisKumarRout" target="_blank" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://wa.me/7008448569" target="_blank" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://instagram.com/ashis5769" target="_blank" title="Instagram"><i class="fa-brands fa-square-instagram"></i></a>
                    <a href="https://github.com/Ashiskumarrout" target="_blank" title="GitHub"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="Ecmerse photos/app.jpg" alt="App Store">
                <img src="Ecmerse photos/play.jpg" alt="Google Play">
            </div>
            <p>Secure Payment Options</p>
            <img src="Ecmerse photos/pay.png" alt="Payment Methods">
        </div>

        <div class="copyright">
            <hr>
            <p>&copy; 2024 Ashis. Made with <i class="fa-solid fa-heart"></i> by Ashis. Thank you for visiting!</p>
        </div>
    </footer>
</body>
</html>



<script src="acc.js"></script>