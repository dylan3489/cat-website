<!DOCTYPE html>
<html lang="en">
    
<?php
session_start();
require 'connectdb.php';

// check admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $story_id = mysqli_real_escape_string($con, $_POST['story_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
    $story_text = mysqli_real_escape_string($con, $_POST['story_text']);
    $before_image_url = mysqli_real_escape_string($con, $_POST['before_image_url']);
    $after_image_url = mysqli_real_escape_string($con, $_POST['after_image_url']);

    if (empty($story_text)) {
        echo "Error: Story text is required.";
        exit();
    }

    $query = "UPDATE success_stories 
              SET user_id = '$user_id', 
                  cat_id = '$cat_id', 
                  story_text = '$story_text', 
                  before_image_url = '$before_image_url', 
                  after_image_url = '$after_image_url' 
              WHERE story_id = '$story_id'";

    $result = mysqli_query($con, $query);

    if ($result) {
        header('Location: adminStoriesDatabasePage.php?success=1');
    } else {
        echo "Error updating story: " . mysqli_error($con);
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>
