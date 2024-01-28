

<?php
require_once "includes/database.php";
$sort = $_GET['sort'] ?? 'Name';

$queryMenu = "SELECT FoodMenu.MenuItemName, FoodMenu.Ingredients, FoodMenu.Price
FROM FoodMenu";

$resultMenu = mysqli_query($db, $queryMenu) or die('Error loading food.');

$menuItem = mysqli_fetch_array($resultMenu, MYSQLI_ASSOC);

$query = "SELECT Food.FoodID, Food.Name, Food.FoodCategoryID, Food.FoodQuantity
FROM Food
ORDER BY $sort";

$result = mysqli_query($db, $query) or die('Error loading food.');
$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
$choices = $_POST['choices'] ?? [];

include 'includes/header.php';

$formIsValid = true;

//if (isset($_POST['purchase'])) {
//    echo 'Array: ' . implode(" ", $choices);
//}
//    if (count($choices) < 1) {
//
//        $formIsValid = false;
//        $error = 'Please select at least one ingredient';
//        echo $error;
//    }

//if($formIsValid)
//    echo 'Array: ' . implode(' ', $choices);
foreach ($choices as &$food){
    $query = "UPDATE Food SET FoodQuantity = FoodQuantity + 1 WHERE Name = '$food'";
    $stmt = mysqli_prepare($db, $query) or die('Invalid query');
    mysqli_stmt_execute($stmt);
}
//    for($i = 0; $i < count($choices); $i++){
//
//    }


?>
                <form method="post">
                    <section class="order-container">
                    <section class="select-a-juice-container">
                    <h2>Select a Juice</h2>
                    <section class="select-a-juice">

                        <?php
                        $resultMenu = mysqli_query($db, $queryMenu) or die('Error: ' . mysqli_error($db));
                        while($row = mysqli_fetch_array($resultMenu, MYSQLI_ASSOC)) {
                            $ingredients = $row['Ingredients'];
                            $ingredients = ucwords(implode(', ', preg_split('/[\s]+/', $ingredients)));

                        ?>
                            <section class="select-a-juice-item">
                                <section>
                                <h3 class="select-a-juice-name"><?=$row['MenuItemName'] ?></h3>
                                <p class="select-a-juice-ingredients"><?= $ingredients ?></p>
                                <p class="select-a-juice-price">$<?=$row['Price'] ?></p>
                                <button class="buy-juice-button"><a href="food-items.php">Buy Juice</a></button>
                                </section>
                            </section>
                            <?php
                        }
                            ?>

                    </section>
                    </section>
<!--                        <p class="or-divider">Or</p>-->
                    <section class="build-your-own-container">
                    <h2>Build Your Own</h2>

                    <section class="build-your-own">

                        <?php
//                        $result = @mysqli_query($db, $query) or die('Error in query: ' . mysqli_error($db));

                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            if ($row['FoodCategoryID'] == 1 && $row['FoodQuantity'] > 0 || $row['FoodCategoryID'] == 2 && $row['FoodQuantity'] > 0){

                                ?>
                                <label class="build-your-own-item"><input type="checkbox" name="choices[]" value=<?=$row['Name']?>><?=$row['Name']?></label>
                                <?php
                            }
                            else {


                                ?>
                                <span class=" build-your-own-item out-of-stock-text"><?=$row['Name']?> (out of stock)</span>
                                <?php
                            }
                        }

                        ?>
                    </section>

                    </section>
                    </section>
                    <button type="submit">Place Order</button>
                </form>
    <pre>
    <?php
    print_r($_POST);
    ?>
</pre>

<?php

