<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cat - Nine Lives Haven</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .add-cat-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #8B5E3C;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-cat-container button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f4ac6d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .add-cat-container button:hover {
            background-color: #e19350;
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// check if the admin is not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $cat_name = mysqli_real_escape_string($con, $_POST['cat_name']);
    $breed = mysqli_real_escape_string($con, $_POST['breed']);
    $cat_age = mysqli_real_escape_string($con, $_POST['cat_age']);
    $cat_health = mysqli_real_escape_string($con, $_POST['cat_health']);
    $cat_description = mysqli_real_escape_string($con, $_POST['cat_description']);
    $image_url = mysqli_real_escape_string($con, $_POST['image_url']);
    $adoption_status = mysqli_real_escape_string($con, $_POST['adoption_status']);
    $special_requirements = mysqli_real_escape_string($con, $_POST['special_requirements']);

    // Insert new cat data into the database
    $query = "INSERT INTO cats (cat_name, breed, cat_age, cat_health, cat_description, image_url, adoption_status, special_requirements)
              VALUES ('$cat_name', '$breed', '$cat_age', '$cat_health', '$cat_description', '$image_url', '$adoption_status', '$special_requirements')";

    if (mysqli_query($con, $query)) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'New cat has been added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'adminCatDatabasePage.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue adding the cat.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<body>
    <section class="add-cat-container">
        <h2>Add New Cat</h2>
        <form action="addCat.php" method="post">
            <label for="cat_name">Cat Name:</label>
            <input type="text" name="cat_name" required>

            <label for="breed">Breed:</label>
            <input type="text" name="breed">

            <label for="cat_age">Age:</label>
            <input type="number" name="cat_age">

            <label for="cat_health">Health:</label>
            <input type="text" name="cat_health">

            <label for="cat_description">Description:</label>
            <textarea name="cat_description"></textarea>

            <label for="image_url">Image URL:</label>
            <input type="text" name="image_url">

            <label for="adoption_status">Adoption Status:</label>
            <select name="adoption_status">
                <option value="available">Available</option>
                <option value="adopted">Adopted</option>
            </select>

            <label for="special_requirements">Special Requirements:</label>
            <textarea name="special_requirements" required></textarea>

            <button type="submit">Add Cat</button>
        </form>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>
