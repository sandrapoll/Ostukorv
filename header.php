<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Work+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->

    <title>Ostukorv</title>
</head>
<body>

<header>
    <!--    <h1>--><?php // echo $sessionId; ?><!--</h1>-->
    <a href="/" class="navLink">Tooted</a>
</header>

<a href="cart.php" class="cd-cart">
    <?php
    require_once 'cartCount.php';
    ?>
</a>

<ul class="cd-gallery">
