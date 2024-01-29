<?php
include 'includes/header.php';
?>

    <title>The FOOD Database</title>

<?php
require_once "includes/database.php";

$sort = $_GET['sort'] ?? 'Name';

$query = "SELECT Food.FoodID, Food.Name, FoodCategory.Category, Food.FoodQuantity
FROM Food
LEFT JOIN FoodCategory ON Food.FoodCategoryID = FoodCategory.FoodCategoryID
ORDER BY $sort";

$result = mysqli_query($db, $query) or die('Error loading food.');

$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="food-tab" data-bs-toggle="tab" data-bs-target="#food" type="button" role="tab" aria-controls="food" aria-selected="true">Food</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="juices-tab" data-bs-toggle="tab" data-bs-target="#juices" type="button" role="tab" aria-controls="juices" aria-selected="false">Juices</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="desserts-tab" data-bs-toggle="tab" data-bs-target="#desserts" type="button" role="tab" aria-controls="desserts" aria-selected="false">Desserts</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="food" role="tabpanel" aria-labelledby="food-tab"><section class="search-add-food-container">
                <form>
                    <label class="search">Search: <input id="search" placeholder="Search Food"></label>

                </form>
                <button class="btn-add-food"><a href="add-item.php?id=<?=$item['FoodID'] ?>" class="btn">Add Food</a></button>
                <button class="btn-add-food"><a href="add-menu-item.php?id=<?=$item['FoodID'] ?>" class="btn">Add Food to Menu</a></button>
            </section>
            <table id="food-items-table" class="data-table">
                <thead>
                <tr>
                    <th class="food-name-th"><a href="?sort=Name">Name</a></th>
                    <th class="food-category-th"><a href="?sort=Category">Category</a></th>
                    <th class="food-quantity-th">Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db));
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    ?>
                    <tr class="each-data">
                        <td class="food-name"><a href="item.php?foodid=<?= $row['FoodID'] ?>"><?=$row['Name'] ?></a></td>
                        <td class="food-category"><?= $row['Category'] ?></td>
                        <td class="food-quantity"><?= $row['FoodQuantity'] ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table></div>
        <div class="tab-pane fade" id="juices" role="tabpanel" aria-labelledby="juices-tab">...</div>
        <div class="tab-pane fade" id="desserts" role="tabpanel" aria-labelledby="desserts-tab">...</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/search-food.js"></script>
    <script src="js/functions.js"></script>
    </body>
<?php
include 'includes/footer.php';
?>