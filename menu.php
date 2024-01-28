<?php
include 'includes/header.php';
?>

    <title>The FOOD Database</title>

<?php
require_once "includes/database.php";

$sort = $_GET['sort'] ?? 'Name';

$query = "SELECT FoodMenu.FoodName, FoodMenu.Ingredients, FoodMenu.Price
FROM FoodMenu";

$result = mysqli_query($db, $query) or die('Error loading food.');

$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
    <section class="menu-page">
    <h2 class="menu-header">Menu</h2>
    <section class="food-menu">

        <?php
        $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
            <section class="menu-item">
                <h3><?=$row['FoodName'] ?></h3>
                <p><?=$row['Ingredients'] ?></p>
                <p>$<?=$row['Price'] ?></p>
                <button class="buy-juice-button"><a href="food-items.php">Buy Juice</a></button>
            </section>

            <?php
        }
        ?>
    </section>

<?php
include 'includes/footer.php';
?>