<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <script src="https://kit.fontawesome.com/e6878467af.js" crossorigin="anonymous"></script>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Ecmerse photos/smalllogo.png" alt="Logo" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a  href="index.php">Home</a></li>
                <li><a href="shope.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a class="active" href="about.php">About</a></li>
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
<!-- ---------------------------------------------------page hader------------------------- -->
 </section>
<section id="page-header" class="about-header">

<h2>#Know more</h2>

<p>Welcome to our website! We aim to provide you with the best products and services. Explore our offerings and enjoy a seamless shopping experience.</p>




</section>
<!-- ------------------------------------------------about head------------------ -->
<section id="about-header" class="section-p1">
    <img src="Ecmerse photos/a6.jpg" alt="">
    <div>
        <h2>Who We Are</h2>
        <p>Welcome to our e-commerce store! We specialize in providing high-quality products that blend style and comfort. Our mission is to offer a seamless shopping experience, ensuring that you find exactly what you're looking for.</p>
        <abbr title="Learn more about our journey and values">Discover more about our journey, values, and commitment to quality. We're passionate about bringing you the best in fashion and lifestyle.</abbr>
        <br><br>
        <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">Creating a unique shopping experience with top-quality products and exceptional customer service. Join us on our journey to redefine online shopping!</marquee>
    </div>
</section>



<!-- --------------------------our vedio----------------------------- -->
<section id="about-app" class="section-p1">
    <h1>Dowenlod our App <a href="">App</a> </h1>
    <div class="vedio">
        <video autoplay muted loop src="Ecmerse photos/1.mp4"></video>
    </div>
</section>

<!-- --------------------------fethure------------------------------------ -->
<section id="feature" class="section-p1">
    <div class="fe-box">
        <img src="Ecmerse photos/f1.png">
        <h6>free shoping</h6>
    </div>
    <div class="fe-box">
        <img src="Ecmerse photos/f2.png">
        <h6>online order</h6>
    </div>
    <div class="fe-box">
        <img src="Ecmerse photos/f3.png">
        <h6>Saving</h6>
    </div>
    <div class="fe-box">
        <img src="Ecmerse photos/f4.png">
        <h6>promoction</h6>
    </div>
    <div class="fe-box">
        <img src="Ecmerse photos/f5.png">
        <h6>Happy sall</h6>
    </div>
    <div class="fe-box">
        <img src="Ecmerse photos/f6.png">
        <h6>F24/7 Support</h6>
    </div>
    
</section>

<!-- -------------------------------------------------navaslider-------------------- -->


    
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
<!-- ----------------------------------------footer-------------------------- -->
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









    <script src="e.js"></script>
</body>
</html>