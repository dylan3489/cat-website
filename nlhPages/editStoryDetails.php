<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Success Story - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-story-container {
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

        .edit-story-container button {
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

        .edit-story-container button:hover {
            background-color: rgb(211, 133, 64);
        }

        input[readonly] {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }

        #deleteButton {
            background: #735134;
            border: none;
            padding: 10px 20px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }

        #deleteButton:hover {
            background: rgb(87, 55, 27);
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';

// Verify admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

// Check if story_id is provided
if (isset($_GET['story_id'])) {
    $story_id = mysqli_real_escape_string($con, $_GET['story_id']);

    // Fetch success story details 
    $query = "SELECT * FROM success_stories WHERE story_id = '$story_id'";
    $result = mysqli_query($con, $query);
    $story = mysqli_fetch_assoc($result);

    // If the story is not found, show an error popup
    if (!$story) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Success story not found.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'adminStoriesDatabasePage.php';
                });
              </script>";
        exit();
    }
} else {
    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'No story selected.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'adminStoriesDatabasePage.php';
            });
          </script>";
    exit();
}

// Handle form submission for updating story
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $story_id = mysqli_real_escape_string($con, $_POST['story_id']);
    $story_text = mysqli_real_escape_string($con, $_POST['story_text']);
    $before_image_url = mysqli_real_escape_string($con, $_POST['before_image_url']);
    $after_image_url = mysqli_real_escape_string($con, $_POST['after_image_url']);

    $update_query = "UPDATE success_stories SET 
                        story_text = ?, 
                        before_image_url = ?, 
                        after_image_url = ? 
                     WHERE story_id = ?";
    
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("sssi", $story_text, $before_image_url, $after_image_url, $story_id);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Success story has been updated successfully.',
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
                    text: 'There was an issue updating the success story.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: 'rgb(211, 133, 64)' 
                });
              </script>";
    }
}

// Handle story deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $story_id = mysqli_real_escape_string($con, $_POST['story_id']);

    // Delete story from database
    $delete_query = "DELETE FROM success_stories WHERE story_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $story_id);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Success story has been deleted.',
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
                    text: 'There was an issue deleting the success story.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: 'rgb(211, 133, 64)'  
                });
              </script>";
    }
}
?>

<body>
    <div class="edit-story-container">
        <h2>Edit Success Story</h2>
        <form action="" method="post">
            <!-- Hidden field to retain story_id -->
            <input type="hidden" name="story_id" value="<?= htmlspecialchars($story['story_id']) ?>">

            <label>User ID:</label>
            <input type="text" name="user_id" value="<?= htmlspecialchars($story['user_id']) ?>" readonly>

            <label>Cat ID:</label>
            <input type="text" name="cat_id" value="<?= htmlspecialchars($story['cat_id']) ?>" readonly>

            <label>Story Text:</label>
            <textarea name="story_text" rows="6"><?= htmlspecialchars($story['story_text']) ?></textarea>

            <label>Before Image URL:</label>
            <input type="text" name="before_image_url" value="<?= htmlspecialchars($story['before_image_url']) ?>">

            <label>After Image URL:</label>
            <input type="text" name="after_image_url" value="<?= htmlspecialchars($story['after_image_url']) ?>">

            <button type="submit" name="update">Update</button>
        </form>

        <!-- Delete form -->
        <form action="" method="post" id="deleteForm" style="margin-top: 20px;">
            <input type="hidden" name="story_id" value="<?= htmlspecialchars($story['story_id']) ?>">
            <button type="submit" name="delete" id="deleteButton">Delete Story</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
