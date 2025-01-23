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

echo "<script>console.log('PHP is working');</script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // this validates the form data
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $card_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_NUMBER_INT);
    $expiry_date = filter_input(INPUT_POST, 'expiry_date', FILTER_SANITIZE_SPECIAL_CHARS);
    $cvv = filter_input(INPUT_POST, 'cvv', FILTER_SANITIZE_NUMBER_INT);   

    // check the required fields are entered
    if ($amount === false || $amount <= 0) {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Invalid Donation Amount",
                text: "Please enter a valid donation amount.",
                confirmButtonColor: "#f4ac6d"
            }).then(() => {
                window.location.href = "userMakeDonationPage.php"; 
            });
        </script>';
        exit();
    }
    if (empty($card_number) || empty($expiry_date) || empty($cvv)) {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Payment Details Required",
                text: "Card number, expiry date, and CVV are required.",
                confirmButtonColor: "#f4ac6d"
            }).then(() => {
                window.location.href = "userMakeDonationPage.php"; 
            });
        </script>';
        exit();
    }

    // simulate payment processing - would need to implement properly in a real application
    $payment_successful = true; // would need to replace with actual payment processing logic

    if ($payment_successful) {
        // insert donation into the database
        try {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Ensure the user is logged in

            // query to insert donation into database
            $query = "INSERT INTO donations (user_id, amount, message) 
                      VALUES (?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("iis", $user_id, $amount, $message);
            
            $stmt->execute();

            // check if it inserted successfully
            if ($stmt->affected_rows > 0) {
                // close the statement before redirection
                $stmt->close();
                
                // success message with redirection
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Donation Successful",
                        text: "Thank you for your generous donation!",
                        confirmButtonColor: "#f4ac6d"
                    }).then(() => {
                        window.location.href = "homePage.php"; // 
                    });
                </script>';
                exit();
            } else {
                // report failure in donation insertion
                $stmt->close();
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Donation Failed",
                        text: "We could not process your donation at the moment. Please try again later.",
                        confirmButtonColor: "#f4ac6d"
                    }).then(() => {
                        window.location.href = "userMakeDonationPage.php";
                    });
                </script>';
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            // display the error
            error_log($e->getMessage());
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Database Error",
                    text: "Failed to process the donation. Please try again later.",
                    confirmButtonColor: "#f4ac6d"
                }).then(() => {
                    window.location.href = "userMakeDonationPage.php";
                });
            </script>';
            exit();
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Payment Failed",
                text: "Payment failed. Please check your details and try again.",
                confirmButtonColor: "#f4ac6d"
            }).then(() => {
                window.location.href = "userMakeDonationPage.php"; 
            });
        </script>';
        exit();
    }
} else {
    // block direct access to script
    header("HTTP/1.1 403 Forbidden");
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Access Denied",
            text: "You are not allowed to access this page directly.",
            confirmButtonColor: "#f4ac6d"
        }).then(() => {
            window.location.href = "homePage.php";
        });
    </script>';
    exit();
}
?>
