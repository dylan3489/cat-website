<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require 'connectdb.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
    $cat_name = mysqli_real_escape_string($con, $_POST['cat_name']);
    $breed = mysqli_real_escape_string($con, $_POST['breed']);
    $cat_health = mysqli_real_escape_string($con, $_POST['cat_health']);
    $cat_description = mysqli_real_escape_string($con, $_POST['cat_description']);
    $adoption_status = mysqli_real_escape_string($con, $_POST['adoption_status']);
    $special_requirements = mysqli_real_escape_string($con, $_POST['special_requirements']);

    $query = "UPDATE cats SET 
                cat_name='$cat_name', 
                breed='$breed', 
                cat_health='$cat_health', 
                cat_description='$cat_description', 
                adoption_status='$adoption_status', 
                special_requirements='$special_requirements' 
              WHERE cat_id='$cat_id'";

    if (mysqli_query($con, $query)) {
        header('Location: adminCatDatabasePage.php');
    } else {
        echo "Error updating cat details: " . mysqli_error($con);
    }
}
?>
