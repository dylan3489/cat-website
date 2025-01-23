<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<?php
session_start();
require 'connectdb.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: userSignInPage.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $cat_id = $_POST['cat_id'];
    $appointment_date = $_POST['appointment_date'];
    $vet_name = isset($_POST['vet_name']) ? mysqli_real_escape_string($con, $_POST['vet_name']) : null;
    $notes = mysqli_real_escape_string($con, $_POST['notes']);
    $status = 'pending';
    $image_url = 'default_image.jpg';

    // validate cat_id
    $query = "
        SELECT 1
        FROM cats AS c
        INNER JOIN adoption_applications AS aa ON c.cat_id = aa.cat_id
        WHERE c.cat_id = '$cat_id'
          AND c.adoption_status = 'adopted'
          AND aa.user_id = '$user_id'
          AND aa.application_status = 'accepted'
    ";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $insert_query = "
            INSERT INTO appointments (user_id, cat_id, appointment_date, vet_name, status, image_url, notes)
            VALUES ('$user_id', '$cat_id', '$appointment_date', '$vet_name', '$status', '$image_url', '$notes')
        ";
        if (mysqli_query($con, $insert_query)) {
            echo "<script>
                    alert('Appointment booked successfully!');
                    window.location.href = 'userViewAppointmentsPage.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error booking appointment: " . mysqli_error($con) . "');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid cat selection. Please select an adopted cat with an approved application.');
                window.history.back();
              </script>";
    }
}
?>
