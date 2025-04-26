<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Add Success Story - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .add-story-container {
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

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-story-container button {
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

        .add-story-container button:hover {
            background-color: rgb(211, 133, 64);
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-column {
            flex: 1;
        }

        /* making fields other than user and cat as vertical layout */
        textarea,
        input[type="text"] {
            margin-top: 15px;
        }

        label {
            margin-top: 20px;
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav

if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

$users_query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name FROM users ORDER BY first_name ASC";
$users_result = mysqli_query($con, $users_query);
$users = mysqli_fetch_all($users_result, MYSQLI_ASSOC);

$cats_query = "SELECT cat_id, cat_name FROM cats ORDER BY cat_name ASC";
$cats_result = mysqli_query($con, $cats_query);
$cats = mysqli_fetch_all($cats_result, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
    $story_text = mysqli_real_escape_string($con, $_POST['story_text']);
    $before_image_url = mysqli_real_escape_string($con, $_POST['before_image_url']);
    $after_image_url = mysqli_real_escape_string($con, $_POST['after_image_url']);

    if (empty($user_id) || empty($cat_id) || empty($story_text)) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'User, Cat, and Story Text are required.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: 'rgb(211, 133, 64)'  
                });
              </script>";
    } else {
        $query = "INSERT INTO success_stories (user_id, cat_id, story_text, before_image_url, after_image_url) 
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $con->prepare($query);
        $stmt->bind_param("iisss", $user_id, $cat_id, $story_text, $before_image_url, $after_image_url);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'New success story added successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: 'rgb(211, 133, 64)'  
                    }).then(function() {
                        window.location.href = 'adminStoriesDatabasePage.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue adding the success story.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: 'rgb(211, 133, 64)'  
                    });
                  </script>";
        }
    }
}
?>

<body>
    <div class="add-story-container">
        <h2>Add Success Story</h2>
        <form action="" method="post">
            <div class="form-row">
                <div class="form-column">
                    <label>User:</label>
                    <select name="user_id" required>
                        <option value="">Select a user</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['user_id']) ?>">
                                <?= htmlspecialchars($user['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-column">
                    <label>Cat:</label>
                    <select name="cat_id" required>
                        <option value="">Select a cat</option>
                        <?php foreach ($cats as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['cat_id']) ?>">
                                <?= htmlspecialchars($cat['cat_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <label>Story Text:</label>
            <textarea name="story_text" rows="6" required></textarea>

            <label>Before Image URL:</label>
            <input type="text" name="before_image_url">

            <label>After Image URL:</label>
            <input type="text" name="after_image_url">

            <button type="submit">Add Story</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; // footer ?>
