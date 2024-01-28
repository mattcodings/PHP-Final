<link rel="stylesheet" href="css/style.css">
<?php
session_name('mzwerlein_class');
session_start();
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());
require_once 'includes/database.php';
$id = $_GET['id'] ?? '';

$id = intval($id);

$query = "SELECT * 
FROM Food 
JOIN FoodCategory ON Food.FoodCategoryID = FoodCategory.FoodCategoryID
WHERE FoodID = '$id'";

$result = mysqli_query($db, $query) or die('Error in query');

$foodItem = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<div class="edit-form">
<h1>Edit Food</h1>
<?php


if (isset($_POST['edit'])) {
    if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
        die('Invalid token.');
    }

    $formIsValid = true;

    $name = $_POST['name'] ?? '';
    $foodCategoryID = $_POST['food-category-id'] ?? '';
    $foodQuantity = $_POST['food-quantity'] ?? '';

    $foodId = $_POST['foodId'] ?? '';

    if (empty($name) || strlen($name) < 2) {
        $formIsValid = false;
        $nameError = "Name must be at least 2 characters.";
    }

    $name = strip_tags($name);

    if($formIsValid) {

        $query = "UPDATE `Food` SET `Name` = ?, `FoodCategoryID` = ?, `FoodQuantity` = ?
WHERE `Food`.`FoodID` = ?";

        $stmt = mysqli_prepare($db, $query) or die('Invalid query');

        mysqli_stmt_bind_param($stmt, 'siii', $name, $foodCategoryID, $foodQuantity, $foodId);
        mysqli_stmt_execute($stmt);

        header('Location: item.php?id=' . $foodId);
    }

}
?>

<form method="post">
    <p class="edit-line">
        <label for="name">Name: </label>
        <input type="text" id="name" name="name" value="<?= $foodItem['Name'] ?>">
        <label for="name" class="error"><?= $nameError ?? '' ?></label>
    </p>
    <p class="edit-line">
        <label for="food-category-id">Type of Food: </label>
        <select type="text" id="food-category-id" name="food-category-id">
            <option value="1" <?= $foodItem['FoodCategoryID'] == 1 ? 'selected' : '' ?>>Fruit</option>
            <option value="2" <?= $foodItem['FoodCategoryID'] == 2 ? 'selected' : '' ?>>Vegetable</option>
        </select>
    </p>
    <p class="edit-line">
        <label for="food-quantity">Food Quantity: </label>
        <input type="number" id="food-quantity" name="food-quantity" value="<?= $foodItem['FoodQuantity'] ?>">
        <label for="name" class="error"><?= $nutrientError ?? '' ?></label>
    </p>
<br>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="foodId" value="<?= $foodItem['FoodID'] ?>">
        <button type="submit" name="edit" class="btn btn-save">Save Changes</button>
        <button class="back-to-food"><a href="food-items.php">Back to Food</a></button>
</form>
</div>
