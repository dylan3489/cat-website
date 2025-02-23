<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Cat Details - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-cat-container {
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

        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-cat-container button {
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

        .edit-cat-container button:hover {
            background-color:rgb(211, 133, 64);
        }

        .swal2-styled.swal2-confirm {
            background-color: #f4ac6d !important;
            color: white !important;
            border: none !important;
        }

        .swal2-styled.swal2-confirm:hover {
            background-color: #d68b4b !important;
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header("Location: adminSignInPage.php");
    exit();
}

$cat = null;
$message = '';

// fetch cat details
if (isset($_GET['cat_id'])) {
    $cat_id = mysqli_real_escape_string($con, $_GET['cat_id']);
    $query = "SELECT * FROM cats WHERE cat_id = '$cat_id'";
    $result = mysqli_query($con, $query);
    $cat = mysqli_fetch_assoc($result);

    if (!$cat) {
        $message = "Cat not found.";
    }
} else {
    $message = "No cat selected.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
    $cat_name = mysqli_real_escape_string($con, $_POST['cat_name']);
    $breed = mysqli_real_escape_string($con, $_POST['breed']);
    $cat_age = mysqli_real_escape_string($con, $_POST['cat_age']);
    $cat_health = mysqli_real_escape_string($con, $_POST['cat_health']);
    $cat_description = mysqli_real_escape_string($con, $_POST['cat_description']);
    $adoption_status = mysqli_real_escape_string($con, $_POST['adoption_status']);
    $special_requirements = mysqli_real_escape_string($con, $_POST['special_requirements']);
    $image_url = $cat['image_url']; // Keep existing image by default

// new image upload
if (!empty($_FILES['image']['name'])) {
    $target_dir = "../nlhImages/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowed_types)) {
        // remove the file extension from the image name
        $image_name_without_extension = pathinfo($image_name, PATHINFO_FILENAME);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // save image without the extension
            $image_url = $image_name_without_extension;
        } else {
            $message = "Error uploading image.";
        }
    } else {
        $message = "Invalid image format (JPG, JPEG, PNG, GIF only).";
    }
}


    // update the database
    if (empty($message)) {
        $update_query = "UPDATE cats SET cat_name = ?, breed = ?, cat_age = ?, cat_health = ?, cat_description = ?, image_url = ?, adoption_status = ?, special_requirements = ? WHERE cat_id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("ssisssssi", $cat_name, $breed, $cat_age, $cat_health, $cat_description, $image_url, $adoption_status, $special_requirements, $cat_id);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Cat details have been updated successfully.',
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
                        text: 'There was an issue updating the cat details.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: '$message',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<body>
    <div class="edit-cat-container">
        <h2>Edit Cat Details</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="cat_id" value="<?= htmlspecialchars($cat['cat_id']); ?>">

            <label for="cat_name">Cat Name:</label>
            <input type="text" name="cat_name" value="<?= htmlspecialchars($cat['cat_name']); ?>" required>

            <label for="breed">Breed:</label>
            <input type="text" name="breed" value="<?= htmlspecialchars($cat['breed']); ?>">

            <label for="cat_age">Age:</label>
            <input type="number" name="cat_age" value="<?= htmlspecialchars($cat['cat_age']); ?>">

            <label for="cat_health">Health:</label>
            <input type="text" name="cat_health" value="<?= htmlspecialchars($cat['cat_health']); ?>">

            <label for="cat_description">Description:</label>
            <textarea name="cat_description" required><?= htmlspecialchars($cat['cat_description']); ?></textarea>

            <label for="adoption_status">Adoption Status:</label>
            <select name="adoption_status">
                <option value="available" <?= $cat['adoption_status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                <option value="adopted" <?= $cat['adoption_status'] == 'adopted' ? 'selected' : ''; ?>>Adopted</option>
            </select>

            <label for="special_requirements">Special Requirements:</label>
            <textarea name="special_requirements" required><?= htmlspecialchars($cat['special_requirements']); ?></textarea>

            <label for="image">Cat Image (optional):</label>
            <input type="file" name="image">

            <button type="submit">Update Details</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
