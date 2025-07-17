<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];
    $method = $_POST['payment_method'];
    $txn = $_POST['transaction_id'];
    $status = $_POST['status'];

    $sql="INSERT INTO payment (order_id, amount, payment_method, transaction_id, status)
        VALUES ( $order_id, $amount, '$method', '$txn', '$status')";;
    if ($conn->query($sql)) {
        echo "User payment successfully paid";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>