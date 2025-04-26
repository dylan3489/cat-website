<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Success Stories Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/adminStoriesDatabaseCSS.css">
</head>

<?php
session_start();

// if the admin is not logged in, redirect to the sign-in page
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

$stories = [];

// search and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'story_date';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'desc';

$query = "SELECT s.story_id, s.user_id, s.cat_id, s.story_text, s.before_image_url, s.after_image_url, s.story_date, 
                 u.first_name, u.last_name, c.cat_name 
          FROM success_stories AS s
          JOIN users AS u ON s.user_id = u.user_id
          JOIN cats AS c ON s.cat_id = c.cat_id
          WHERE s.story_text LIKE '%$search%' 
          OR u.first_name LIKE '%$search%' 
          OR u.last_name LIKE '%$search%' 
          OR c.cat_name LIKE '%$search%' 
          ORDER BY $sort $order";

$result = mysqli_query($con, $query);

if ($result) {
    $stories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error fetching data: " . mysqli_error($con);
}
?>

<body>
    <section class="page-title">
        <h1>Success Stories Database</h1>
    </section>

    <section class="stories-database">
        <form action="adminStoriesDatabasePage.php" method="get" style="display: flex; align-items: center; gap: 10px;">
            <input type="text" name="search" class="search-bar"
                value="<?= isset($search) && $search !== '' ? htmlspecialchars($search) : '' ?>"
                placeholder="Search success stories...">
            <select name="sort">
                <option value="story_date">Date</option>
                <option value="user_id">User ID</option>
                <option value="cat_id">Cat ID</option>
                <option value="story_id">Story ID</option>
            </select>
            <select name="order">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
            <input type="submit" value="Search">

            <a href="addStory.php" class="add-story-btn">+ Add New Story</a>
        </form>


        <table>
            <thead>
                <tr>
                    <th>Story ID</th>
                    <th>User Name</th>
                    <th>Cat Name</th>
                    <th>Story Text</th>
                    <th>Before Image</th>
                    <th>After Image</th>
                    <th>Story Date</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stories as $story): ?>
                    <tr>
                        <td><?= htmlspecialchars($story['story_id']) ?></td>
                        <td><?= htmlspecialchars($story['first_name'] . ' ' . $story['last_name']) ?></td>
                        <td><?= htmlspecialchars($story['cat_name']) ?></td>
                        <td><?= htmlspecialchars($story['story_text']) ?></td>
                        <td><img src="<?= htmlspecialchars($story['before_image_url']) ?>" alt="Before Image"></td>
                        <td><img src="<?= htmlspecialchars($story['after_image_url']) ?>" alt="After Image"></td>
                        <td><?= htmlspecialchars($story['story_date']) ?></td>
                        <td>
                            <form action="editStoryDetails.php" method="get">
                                <input type="hidden" name="story_id" value="<?= htmlspecialchars($story['story_id']) ?>">
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
