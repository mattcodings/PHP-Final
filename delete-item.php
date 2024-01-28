<link rel="stylesheet" href="css/style.css">
<?php
include 'includes/header.php';
//session_name('mzwerlein_class');
//session_start();

$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());
require_once "includes/database.php";

$id = $_GET['id'] ?? '1';

$id = intval($id);
$query = "SELECT * FROM Food WHERE FoodID = '$id'";

$result = mysqli_query($db, $query) or die('Error loading item.');

$food = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<h1>Delete Item</h1>

<?php
if (isset($_POST['delete'])) {
    if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
        die('Invalid token.');
    }
    $foodId = $_POST['foodId'] ?? '';
    $query = "DELETE FROM `Food` WHERE `Food`.`FoodID` = ? LIMIT 1;";
    $stmt = mysqli_prepare($db, $query) or die('Invalid query');
    mysqli_stmt_bind_param($stmt, 'i', $foodId);
    mysqli_stmt_execute($stmt);

    header('Location: item.php?id=' . $food['FoodID']);
}
?>
<form method="post">
    <p>Are you sure you want to delete "<?= $food['Name']?>?</p>
    <p>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
        <input type="hidden" name="foodId" value="<?= $food['FoodID'] ?>">
        <button type="submit" name="delete" class="btn btn-danger">Delete Item</button>
        <button class="back-to-food"><p><a href="food-items.php">Back to Food</a></p></button>
    </p>
</form>

