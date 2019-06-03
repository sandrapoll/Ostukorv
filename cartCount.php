<?php

require_once 'DatabaseConnection.php';

$stmt = $conn->prepare('SELECT COUNT(id) FROM cart');
$stmt->execute();
$data = $stmt->bind_result($count);
$count1 = [];

while ($stmt->fetch()) {
    $count1[] = [
        'count' => $count,
    ];
}
echo $count;

$stmt->close();