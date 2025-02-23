<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Cat Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/catDatabaseCSS.css">

</head>

<?php
session_start();

// if admin is not logged in, redirect
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// search and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'cat_name';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

$query = "SELECT * FROM cats WHERE cat_name LIKE '%$search%' ORDER BY $sort $order";
$result = mysqli_query($con, $query);
$cats = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
?>

<body>
    <section class="page-title">
        <h1>Cat Database</h1>
    </section>

    <section class="cat-database">
        <form action="adminCatDatabasePage.php" method="get">
            <input type="text" name="search" class="search-bar" value="<?= htmlspecialchars($search) ?>"
                placeholder="Search...">
            <select name="sort">
                <option value="cat_id">Cat ID</option>
                <option value="cat_name">Cat Name</option>
                <option value="breed">Breed</option>
                <option value="cat_health">Health</option>
                <option value="cat_description">Description</option>
                <option value="adoption_status">Adoption Status</option>
                <option value="special_requirements">Special Requirements</option>
            </select>

            <select name="order">
                <option value="asc" <?= $order === 'asc' ? 'selected' : '' ?>>Ascending</option>
                <option value="desc" <?= $order === 'desc' ? 'selected' : '' ?>>Descending</option>
            </select>

            <input type="submit" value="Search">
            <a href="addCat.php" class="add-cat-button">Add New Cat</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Cat Image</th>
                    <th>Cat ID</th>
                    <th>Cat Name</th>
                    <th>Breed</th>
                    <th>Health</th>
                    <th>Description</th>
                    <th>Adoption Status</th>
                    <th>Special Requirements</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cats as $cat): ?>
                    <tr>
                        <td><img src="../nlhImages/<?= htmlspecialchars($cat['image_url']) ?>.jpg" alt="Cat Image"></td>
                        <td><?= htmlspecialchars($cat['cat_id']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_name']) ?></td>
                        <td><?= htmlspecialchars($cat['breed']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_health']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_description']) ?></td>
                        <td><?= htmlspecialchars($cat['adoption_status']) ?></td>
                        <td><?= htmlspecialchars($cat['special_requirements']) ?></td>
                        <td>
                            <form action="editCatDetails.php" method="get">
                                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($cat['cat_id']) ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>
