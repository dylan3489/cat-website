<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

// required for styling
echo '<!DOCTYPE html>';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
<?php
session_start();

require 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // validates the form data
    $sponsorship_amount = $_POST['sponsorship_amount'];
    $cat_name = $_POST['cat_name'];
    $sponsorship_type = $_POST['sponsorship_type'];
    $renewal_date = isset($_POST['renewal_date']) && $sponsorship_type === 'recurring' ? $_POST['renewal_date'] : null;

    // fetch the cat_id based on the selected cat_name
    $cat_query = "SELECT cat_id FROM cats WHERE cat_name = ?";
    $stmt = $con->prepare($cat_query);
    $stmt->bind_param('s', $cat_name);  
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $cat_row = $result->fetch_assoc();
        $cat_id = $cat_row['cat_id'];
    } else {
        // where cat_name doesn't exist
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Cat Not Found',
                    text: 'The cat you selected could not be found. Please try again.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f4ac6d'
                });
              </script>";
        exit();
    }

    // insert sponsorship 
    $user_id = $_SESSION['user_id'];  
    $insert_query = "INSERT INTO sponsorships (user_id, cat_id, sponsorship_amount, sponsorship_type, renewal_date) 
                     VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param('iidsd', $user_id, $cat_id, $sponsorship_amount, $sponsorship_type, $renewal_date);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sponsorship Successful!',
                    text: 'Thank you for sponsoring a cat! Your support is greatly appreciated.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f4ac6d'
                }).then(() => {
                    window.location.href = 'userViewSponsorshipsPage.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an issue processing your sponsorship. Please try again later.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f4ac6d'
                });
              </script>";
    }
}
?>
