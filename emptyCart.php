<?php

require_once 'DatabaseConnection.php';

$stmt = $conn->prepare('DELETE from cart');
$stmt->execute();
$stmt->close();
header('location: /cart.php');