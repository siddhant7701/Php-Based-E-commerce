<?php
session_start();
require_once('db.php');

$result = $conn->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple E-commerce</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="cart.php">Go to Cart</a>
        <a href="logout.php">Logout</a>

      
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
     
</nav>


<h2>Product List</h2>

<div class="product-container">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h3><?= $product['name'] ?></h3>
            <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="150">
            <p><?= $product['description'] ?></p>
            <p>Price: $<?= $product['price'] ?></p>
            <?php
            if(isset($_SESSION['user_id'])) {
                echo '<a href="add_to_cart.php?id=' . $product['id'] . '">Add to Cart</a>';
            }
            ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
