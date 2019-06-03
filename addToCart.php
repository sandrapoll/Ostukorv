<?php

require_once 'DatabaseConnection.php';
require_once 'cart.php';

/*session_start();

$items = $_SESSION['cart'];
$cartItems = explode(",", $items);
$items .= "," . $_GET['id'];
$_SESSION['cart'] = $items;*/

$id = $_GET['id'];
$quantity = 1;

$filteredArray = array_filter($cartItems, function ($item) use ($id) {
    return $item['id'] == $id;
});

if (!empty($filteredArray)) {
    $stmt = $conn->prepare("UPDATE cart SET quantity=quantity + 1 WHERE product_id=' $id '");
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('location: http://localhost/');
} else {
    $stmt = $conn->prepare("INSERT INTO cart(product_id, quantity) VALUES (?, ?)");
    $stmt->bind_param("ss", $id, $quantity);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('location: http://localhost/');
}

