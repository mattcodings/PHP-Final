<?php
require_once "includes/database.php";
?>

<title>The FOOD Database</title>

<?php
$sort = $_GET['sort'] ?? 'Name';

$sort = in_array($sort, ['Name', 'Category']) ? $sort : 'Name';

$search = $_GET['search'] ?? '';

$search = mysqli_real_escape_string($db, $search);

$query = "SELECT Food.FoodID, Food.Name, FoodCategory.Category
FROM `Food`
LEFT JOIN FoodCategory ON Food.FoodCategoryID = FoodCategory.FoodCategoryID
WHERE Name LIKE '%$search%'
ORDER BY $sort";

$result = mysqli_query($db, $query) or die('Error loading food.');

$count = mysqli_num_rows($result);
echo "<p>$count foods found.";

//$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<table id="food-items-table" class="data-table">
    <thead>
    <tr>
        <th><a href="food-items.php?sort=Name">Name</a></th>
        <th><a href="?sort=Category">Category</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        ?>
        <tr>
            <td class="food-name"><a href="item.php?id=<?= $row['FoodID'] ?>"><?=$row['Name'] ?></a></td>
            <td><?= $row['Category'] ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<?php
include 'includes/footer.php';
?>
