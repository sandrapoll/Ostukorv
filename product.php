<?php

require_once 'DatabaseConnection.php';
require_once 'header.php';
$id = $_GET['id'];

$stmt = $conn->prepare('SELECT * from products WHERE id='. $id);
$stmt->execute();
$data = $stmt->bind_result($id, $name, $description, $image, $price);

$products = [];

while ($stmt->fetch()) {
    $products[] = [
        'id'          => $id,
        'name'        => $name,
        'description' => $description,
        'image'       => $image,
        'price'       => $price,
    ];
}
$stmt->close();

foreach ($products as $item) {
    echo '<li><div class="cd-single-item">';
    echo '<p class="selected"><a href="product.php?id=' . $item['id'] . '"><img src="' . $item['image'] . '" alt="Preview image"></a></p>';
    echo '<div class="cd-customization"><a href="addToCart.php?id=' . $item['id'] . '" class="add-to-cart"><em>Add to Cart</em>';
    echo '<svg x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32">
                        <path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF"
                              stroke-width="2" stroke-linecap="square" stroke-miterlimit="10"
                              d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/>
                    </svg>';
    echo '</a></div><div class="cd-item-info"><b>' . $item['name'] . '</b>';
    echo '<em>$' . $item['price'] . '</em><br><p>' . $item['description'] . '</p></div></div></li>';
}
require_once 'footer.php';