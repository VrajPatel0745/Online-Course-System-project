<?php
// C:\xampp\htdocs\web_technologies\cart.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - EduLearn</title>
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">EduLearn</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                require('config/db.php');
                session_start();
                if (isset($_SESSION["username"])) {
                    echo '<li><a href="user-dashboard.php">Dashboard</a></li>';
                    echo '<li><a href="cart.php">Cart</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="signup.php">Signup</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <section class="cart-content">
        <h2>Your Cart</h2>
        <?php
        if (!isset($_SESSION["username"])) {
            echo "<p class='error'>Please <a href='login.php'>login</a> to view your cart.</p>";
        } else {
            // Display cart messages
            if (isset($_SESSION['cart_message'])) {
                $message_class = $_SESSION['cart_success'] ? 'success' : 'error';
                echo "<p class='$message_class'>" . htmlspecialchars($_SESSION['cart_message']) . "</p>";
                unset($_SESSION['cart_message']);
                unset($_SESSION['cart_success']);
            }

            // Get user_id
            $username = $_SESSION["username"];
            $query = "SELECT user_id FROM users WHERE username='$username'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            $user_id = mysqli_fetch_array($result)['user_id'];

            // Fetch cart items
            $query = "SELECT c.course_id, c.title, c.price 
                      FROM cart ca 
                      JOIN courses c ON ca.course_id = c.course_id 
                      WHERE ca.user_id='$user_id'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                $total = 0;
                while ($row = mysqli_fetch_array($result)) {
                    echo "<li>";
                    echo htmlspecialchars($row['title']) . " - $" . number_format($row['price'], 2);
                    echo " <form action='remove-from-cart.php' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='course_id' value='" . $row['course_id'] . "'>";
                    echo "<button type='submit' class='btn-remove'>Remove</button>";
                    echo "</form>";
                    echo "</li>";
                    $total += $row['price'];
                }
                echo "</ul>";
                echo "<p>Total: $" . number_format($total, 2) . "</p>";

                // Payment Form
                ?>
                <form action="process-payment.php" method="post" onsubmit="return validatePaymentForm()">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                    </div>
                    <div class="form-group">
                        <label for="card_holder">Card Holder Name</label>
                        <input type="text" name="card_holder" id="card_holder" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry">Expiry Date (MM/YY)</label>
                        <input type="text" name="expiry" id="expiry" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" name="cvv" id="cvv" placeholder="123" maxlength="4" required>
                    </div>
                    <button type="submit" class="btn">Pay Now</button>
                </form>
                <?php
            } else {
                echo "<p>Your cart is empty. <a href='courses.php'>Browse courses</a></p>";
            }
        }
        ?>
        <p><a href="courses.php">Continue Shopping</a></p>
    </section>

    <footer>
        <p>© 2025 EduLearn. All rights reserved.</p>
        <div class="footer-links">
            <a href="contact.php">Contact Us</a>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>