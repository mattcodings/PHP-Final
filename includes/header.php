<?php

session_name('php_final');
session_start();
include "includes/database.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<nav class="container">
    <div class="main-nav-item"><a href="index.php">Menu</a></div>
    <div class="main-nav-item"><a href="food-items.php">Create</a></div>

    <div class="main-nav-item"><a href="login.php">Sign In/Sign Up</a></div>
    <?php
    if(isset($_SESSION['foodAuthUser']) and $_SESSION['foodAuthUser']):
        ?>
        <?php if($_SESSION['foodAuthUser']['role'] == 'admin'): ?>
        <div class="main-nav-item"><a href="inventory.php">Inventory</a></div>
    <?php endif; ?>


    <?php endif; ?>

</nav>
<header class="hero-image"></header>



