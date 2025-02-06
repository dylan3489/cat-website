<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Our Cats - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/ourCatsCSS.css">

</head>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

$cats = []; // empty array to avoid errors if no data is retrieved.

$cats_per_page = 16;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $cats_per_page;

// search and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'cat_name';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

$query = "SELECT * FROM cats WHERE cat_name LIKE '%$search%' ORDER BY $sort $order LIMIT $cats_per_page OFFSET $offset";

$result = mysqli_query($con, $query);

if ($result) {
    $cats = mysqli_fetch_all($result, MYSQLI_ASSOC); // fetch all rows as an associative array
} else {
    echo "Error fetching data: " . mysqli_error($con);
}

// total number of cats for pagination
$total_query = "SELECT COUNT(*) as total FROM cats WHERE cat_name LIKE '%$search%'";
$total_result = mysqli_query($con, $total_query);
$total_cats = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_cats / $cats_per_page);
?>

<body>
    <section class="intro-section">
        <div class="intro-text">
            <h1>Take a look at our feline friends searching for a home </h1>
            <p>All of our friends are in need of a warm and supportive home - each with their own curious personalities
                and quirks!<br>
                Take a look below to see these little guys and what kind of life they need - and if they'd fit with you!
            </p>
        </div>
    </section>

    <section class="cat-profiles">
        <h1 id="cats-header">Our Cats</h1><br>
        <section class="content">
            <form action="ourCatsPage.php" method="get">
                <select name="sort">
                    <option value="cat_name">Name</option>
                    <option value="breed">Breed</option>
                    <option value="cat_age">Age</option>
                    <option value="cat_health">Health</option>
                    <option value="special_requirements">Special Requirements</option>
                </select>

                <select name="order">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>

                <input type="submit" value="Go" class="go-button">
            </form>

        </section>

        <div class="cats-container">
            <?php foreach ($cats as $cat): ?>
                <div class="cat-box">
                    <a href="catProfilePage.php?id=<?php echo $cat['cat_id']; ?>">
                        <img src="../nlhImages/<?php echo $cat['image_url']; ?>.jpg" alt="<?php echo $cat['cat_name']; ?>">
                    </a>
                    <!-- Cat information box -->
                    <div class="cat-info">
                        <p><span>Name:</span> <?php echo $cat['cat_name']; ?></p>
                        <p><span>Breed:</span> <?php echo $cat['breed']; ?></p>
                        <p><span>Age:</span> <?php echo $cat['cat_age']; ?></p>
                        <p><span>Health:</span> <?php echo $cat['cat_health']; ?></p>
                        <p><span>Special Requirements:</span> <?php echo $cat['special_requirements']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a
                    href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>&sort=<?= $sort ?>&order=<?= $order ?>">Previous</a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
                <a
                    href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>&sort=<?= $sort ?>&order=<?= $order ?>">Next</a>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>

<?php include 'footer.php'; // footer ?>
