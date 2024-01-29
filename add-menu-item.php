<link rel="stylesheet" href="css/style.css">
<?php
session_name('mzwerlein_class');
session_start();

$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());

require_once "includes/database.php";

$id = $_GET['id'] ?? '1';

$id = intval($id);

// build query
$query = "SELECT * FROM FoodMenu WHERE MenuItemID = '$id'";

// execute query
$result = mysqli_query($db, $query) or die('Error loading table.');

// get one record from the database
$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

$sort = $_GET['sort'] ?? 'Name';
$queryFood = "SELECT Food.FoodID, Food.Name, Food.FoodCategoryID, Food.FoodQuantity
FROM Food
ORDER BY $sort";

$foodResult = mysqli_query($db, $queryFood) or die('Error loading food.');
$foodItem = mysqli_fetch_array($foodResult, MYSQLI_ASSOC);
$ingredients = $_POST['ingredients'] ?? [];
?>

<h1>Add Menu Item</h1>

<?php
if (isset($_POST['add'])) {
    if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
        die('Invalid token.');
    }

    $formIsValid = true;
    $menuItemId = $_POST['menuItemId'] ?? '';
    $menuItemName = $_POST['menuItemName'] ?? '';
    $ingredients = implode( ', ' , $_POST['ingredients']) ?? '';
    $price = $_POST['price'] ?? '';
    $menuName = $_POST['menuName'] ?? '';



    $menuItemName = strip_tags($menuItemName);
    $price = strip_tags($price);
    $menuName = strip_tags($menuName);

    if ($formIsValid) {
        $query = "INSERT INTO `FoodMenu`
(`MenuItemID`, `MenuItemName`, `Ingredients`, `Price`, MenuName)
VALUES
(NULL, ?, ?, ?, ?);";

        $stmt = mysqli_prepare($db, $query) or die('Invalid query');
        mysqli_stmt_bind_param($stmt, 'ssis', $menuItemName, $ingredients, $price, $menuName);
        mysqli_stmt_execute($stmt);
        if (mysqli_insert_id($db)) {
            header('Location: food-items.php?id=' . $menuItemId);
        }
    }
}
mysqli_close($db);
?>
<form method="post"
<p class="edit-line">
    <label for="menuItemName">Name: </label>
    <input type="text" id="menuItemName" name="menuItemName">
    <label for="menuItemName" class="error"><?= $nameError ?? '' ?></label>
</p>

<?php


while($row = mysqli_fetch_array($foodResult, MYSQLI_ASSOC)){


        ?>
        <label class=""><input type="checkbox" name="ingredients[]" value=<?=$row['Name']?>><?=$row['Name']?></label>
        <?php


}

?>

<!--<p class="edit-line">-->
<!--    <label for="ingredients">Ingredients: </label>-->
<!--    <input type="text" id="ingredients" name="ingredients">-->
<!--    <label for="ingredients" class="error">--><?php //= $quantityError ?? '' ?><!--</label>-->
<!--</p>-->
<p class="edit-line">
    <label for="price">Price: </label>
    <input type="text" id="price" name="price">
    <label for="price" class="error"><?= $quantityError ?? '' ?></label>
</p>
<p class="edit-line">
    <label for="menu-name">Menu: </label>
    <label>Food
    <input type="radio" name="menuName" value="food">
    </label>
    <label>Juices
        <input type="radio" name="menuName" value="juices">
    </label>
    <label>Desserts
        <input type="radio" name="menuName" value="desserts">
    </label>

</p>
<p class="edit-line">
    <input type="hidden" name="foodId" value="<?= $item['MenuItemID'] ?>">
</p>
<p class="edit-line">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <button class="btn btn-add btn-save" type="submit" name="add">Add Item</button>
    <button class="back-to-food"><p><a href="food-items.php">Back to Food</a></p></button>
</p>