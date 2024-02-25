<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("
    SELECT cart.quantity, products.name, products.image, products.price
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
");
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="logout.php">Logout</a>

</nav>

<h2>Shopping Cart</h2>

<div class="cart-container">
    <?php foreach ($cart_items as $item): ?>
        <div class="cart-item">
            <h3><?= $item['name'] ?></h3>
            <img src="images/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" width="100">
            <p>Quantity: <?= $item['quantity'] ?></p>
            <p>Price: $<?= $item['price'] ?></p>
        </div>
    <?php endforeach; ?>
</div>

<p style="font-weight: bold; padding-left: 10%;">Total Amount to be Paid: $<?= $total_amount ?></p>

</body>
</html>
