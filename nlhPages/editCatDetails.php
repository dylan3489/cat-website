<!DOCTYPE html>
<html lang="en">
    
<?php
session_start();
require 'connectdb.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

if (isset($_GET['cat_id'])) {
    $cat_id = mysqli_real_escape_string($con, $_GET['cat_id']);

    // fetch cat details from the database
    $query = "SELECT * FROM cats WHERE cat_id = '$cat_id'";
    $result = mysqli_query($con, $query);
    $cat = mysqli_fetch_assoc($result);

    if (!$cat) {
        echo "Cat not found.";
        exit();
    }
} else {
    echo "No cat selected.";
    exit();
}
?>

<head>
    <title>Edit Cat Details</title>
</head>
<body>
    <h1>Edit Cat Details</h1>
    <form action="updateCatDetails.php" method="post">
        <input type="hidden" name="cat_id" value="<?= htmlspecialchars($cat['cat_id']) ?>">
        <label>Cat Name:</label>
        <input type="text" name="cat_name" value="<?= htmlspecialchars($cat['cat_name']) ?>"><br>
        <label>Breed:</label>
        <input type="text" name="breed" value="<?= htmlspecialchars($cat['breed']) ?>"><br>
        <label>Health:</label>
        <input type="text" name="cat_health" value="<?= htmlspecialchars($cat['cat_health']) ?>"><br>
        <label>Description:</label>
        <textarea name="cat_description"><?= htmlspecialchars($cat['cat_description']) ?></textarea><br>
        <label>Adoption Status:</label>
        <input type="text" name="adoption_status" value="<?= htmlspecialchars($cat['adoption_status']) ?>"><br>
        <label>Special Requirements:</label>
        <textarea name="special_requirements"><?= htmlspecialchars($cat['special_requirements']) ?></textarea><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
