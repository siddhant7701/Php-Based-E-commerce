<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the cart
    $result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    $existing_item = $result->fetch_assoc();

    if ($existing_item) {
        // If the product is already in the cart, increase the quantity
        $quantity = $existing_item['quantity'] + 1;
        $conn->query("UPDATE cart SET quantity = $quantity WHERE id = " . $existing_item['id']);
    } else {
        // If the product is not in the cart, add it with quantity 1
        $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    }

    header("Location: index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
