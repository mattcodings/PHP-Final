<?php
include 'includes/header.php';
?>

    <title>The FOOD Database</title>

<?php
require_once "includes/database.php";

$sort = $_GET['sort'] ?? 'MenuItemName';

$query = "SELECT FoodMenu.MenuItemName, FoodMenu.Ingredients, FoodMenu.Price, FoodMenu.MenuName
FROM FoodMenu";

$result = mysqli_query($db, $query) or die('Error loading food.');

$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

    <h2 class="menu-header">Menu</h2>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="food-tab" data-bs-toggle="tab" data-bs-target="#food" type="button" role="tab" aria-controls="food" aria-selected="true">Food</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="drinks-tab" data-bs-toggle="tab" data-bs-target="#drinks" type="button" role="tab" aria-controls="drinks" aria-selected="false">Drinks</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dessert-tab" data-bs-toggle="tab" data-bs-target="#dessert" type="button" role="tab" aria-controls="dessert" aria-selected="false">Desserts</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="food" role="tabpanel" aria-labelledby="food-tab">
                <?php
                $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    if ($row['MenuName'] == 'food'){

                        ?>
                        <section class="menu-item">
                            <h3><?=$row['MenuItemName'] ?></h3>
                            <p><?=$row['Ingredients'] ?></p>
                            <p>$<?=$row['Price'] ?></p>
                            <button class="buy-juice-button"><a href="food-items.php">Buy Juice</a></button>
                        </section>

                        <?php
                    }
                }
                ?>
            </div>
            <div class="tab-pane fade" id="drinks" role="tabpanel" aria-labelledby="drinks-tab"><?php
                $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    if ($row['MenuName'] == 'juices'){
                        ?>
                        <section class="menu-item">
                            <h3><?=$row['MenuItemName'] ?></h3>
                            <p><?=$row['Ingredients'] ?></p>
                            <p>$<?=$row['Price'] ?></p>
                            <button class="buy-juice-button"><a href="food-items.php">Buy Juice</a></button>
                        </section>

                        <?php
                    }
                }
                ?></div>
            <div class="tab-pane fade" id="dessert" role="tabpanel" aria-labelledby="dessert-tab"><?php
                $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    if ($row['MenuName'] == 'desserts'){
                        ?>
                        <section class="menu-item">
                            <h3><?=$row['MenuItemName'] ?></h3>
                            <p><?=$row['Ingredients'] ?></p>
                            <p>$<?=$row['Price'] ?></p>
                            <button class="buy-juice-button"><a href="food-items.php">Buy Juice</a></button>
                        </section>

                        <?php
                    }
                }
                ?></div>
        </div>



<?php
include 'includes/footer.php';
?>