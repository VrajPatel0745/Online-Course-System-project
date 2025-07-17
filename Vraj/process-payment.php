<?php
// C:\xampp\htdocs\web_technologies\process-payment.php
session_start();
require('config/db.php');

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = stripslashes($_POST['user_id']);
    $total_amount = stripslashes($_POST['total_amount']);
    $card_number = stripslashes($_POST['card_number']);
    $card_holder = stripslashes($_POST['card_holder']);
    $expiry = stripslashes($_POST['expiry']);
    $cvv = stripslashes($_POST['cvv']);

    $user_id = mysqli_real_escape_string($con, $user_id);
    $total_amount = mysqli_real_escape_string($con, $total_amount);
    $card_number = mysqli_real_escape_string($con, $card_number);
    $card_holder = mysqli_real_escape_string($con, $card_holder);
    $expiry = mysqli_real_escape_string($con, $expiry);
    $cvv = mysqli_real_escape_string($con, $cvv);

    // Server-side validation
    $errors = [];
    if (!preg_match('/^\d{4}\s?\d{4}\s?\d{4}\s?\d{4}$/', $card_number)) {
        $errors[] = "Invalid card number. Must be 16 digits.";
    }
    if (!preg_match('/^[A-Za-z\s]+$/', $card_holder)) {
        $errors[] = "Invalid card holder name.";
    }
    if (!preg_match('/^(0[1-9]|1[0-2])\/[0-9]{2}$/', $expiry)) {
        $errors[] = "Invalid expiry date. Use MM/YY format.";
    } else {
        // Check if expiry is in the future
        $exp_parts = explode('/', $expiry);
        $exp_month = (int)$exp_parts[0];
        $exp_year = (int)$exp_parts[1] + 2000;
        $current_year = (int)date('Y');
        $current_month = (int)date('m');
        if ($exp_year < $current_year || ($exp_year == $current_year && $exp_month < $current_month)) {
            $errors[] = "Card has expired.";
        }
    }
    if (!preg_match('/^\d{3,4}$/', $cvv)) {
        $errors[] = "Invalid CVV. Must be 3 or 4 digits.";
    }

    if (empty($errors)) {
        // Simulate payment processing (replace with real gateway in production)
        $payment_success = true; // Assume success for localhost

        if ($payment_success) {
            // Start transaction
            mysqli_begin_transaction($con);

            try {
                // Insert order
                $query = "INSERT INTO orders (user_id, total_amount, status) 
                          VALUES ('$user_id', '$total_amount', 'completed')";
                mysqli_query($con, $query);
                $order_id = mysqli_insert_id($con);

                // Insert order items and enrollments
                $query = "SELECT c.course_id, c.price 
                          FROM cart ca 
                          JOIN courses c ON ca.course_id = c.course_id 
                          WHERE ca.user_id='$user_id'";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $course_id = $row['course_id'];
                    $price = $row['price'];
                    $query = "INSERT INTO order_items (order_id, course_id, price) 
                              VALUES ('$order_id', '$course_id', '$price')";
                    mysqli_query($con, $query);

                    $query = "INSERT IGNORE INTO enrollments (user_id, course_id) 
                              VALUES ('$user_id', '$course_id')";
                    mysqli_query($con, $query);
                }

                // Clear cart
                $query = "DELETE FROM cart WHERE user_id='$user_id'";
                mysqli_query($con, $query);

                // Commit transaction
                mysqli_commit($con);

                header("Location: payment-success.php");
                exit();
            } catch (Exception $e) {
                mysqli_rollback($con);
                $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
                header("Location: payment-failure.php");
                exit();
            }
        } else {
            $_SESSION['payment_error'] = "Payment declined. Please check your card details.";
            header("Location: payment-failure.php");
            exit();
        }
    } else {
        $_SESSION['payment_error'] = implode("<br>", $errors);
        header("Location: payment-failure.php");
        exit();
    }
}

header("Location: cart.php");
exit();
?>