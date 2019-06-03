<?php

require_once 'DatabaseConnection.php';

//session_start();
//$sessionId = session_id();
require_once 'header.php';

$stmt = $conn->prepare('SELECT product_id, name, description, image, price, quantity FROM cart
    LEFT JOIN products ON products.id = cart.product_id;');
$stmt->execute();
$data = $stmt->bind_result($id, $name, $description, $image, $price, $quantity);

$cartItems = [];

while ($stmt->fetch()) {
    $cartItems[] = [
        'id'          => $id,
        'name'        => $name,
        'description' => $description,
        'image'       => $image,
        'price'       => $price,
        'quantity'    => $quantity,
    ];
}
$stmt->close();

$priceAll = [];

foreach ($cartItems as $item) {
    if ($item['quantity'] === 1) {
        echo '<li><div class="cd-single-item">';
        echo '<p class="selected"><a href="product.php?id=' . $item['id'] . '"><img src="' . $item['image'] . '" alt="Preview image"></a></p>';
        echo '<div class="cd-item-info"><b>' . $item['name'] . '</b>';
        echo '<br><p>' . $item['description'] . '</p></div><div class="cartInfo"><br><p>Kogus: ' . $item['quantity'] . '</p>
            <br><p>Summa: $' . $item['price'] . '</p></div></div></li>';
        array_push($priceAll, $item['price']);
    } else {
        echo '<li><div class="cd-single-item">';
        echo '<p class="selected"><a href="product.php?id=' . $item['id'] . '"><img src="' . $item['image'] . '" alt="Preview image"></a></p>';
        echo '<div class="cd-item-info"><b>' . $item['name'] . '</b>';
        echo '<br><p>' . $item['description'] . '</p></div><div class="cartInfo"><br><p>Kogus: ' . $item['quantity'] . '</p>
            <br><p>Summa: $' . $item['price'] . '</p><p>Summa kokku: $' . $item['price'] * $item['quantity'] . '</p></div></div></li>';
        array_push($priceAll, $item['price'] * $item['quantity']);
    }
}

require_once 'footer.php';
echo '<p class="priceAll">Ostukorvi summa: $' . $price = array_sum($priceAll). '</p>';
require_once 'pangalink.php';
?>

<form method="post" action="http://localhost:8080/banklink/lhv-common">
    <!-- include all values as hidden form fields -->
    <?php foreach ($fields as $key => $val): ?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>"/>
    <?php endforeach; ?>

    <!-- draw table output for demo -->
    <table>
        <?php /*foreach ($fields as $key => $val): */?><!--
            <tr>
                <td><strong><code><?php /*$key; */?></code></strong></td>
                <td><code><?php /*htmlspecialchars($val); */?></code></td>
            </tr>
        --><?php /*endforeach; */?>

        <?php
            if ($price != 0) {
        ?>
            <tr>
                <td colspan="2"><input type="submit" class="payButton" value="Maksma"/></td>
            </tr>
        <?php
            }
        ?>
    </table>
</form>
