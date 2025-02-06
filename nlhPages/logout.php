<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - Nine Lives Haven</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
        Swal.fire({
            icon: "success",
            title: "You have been logged out.",
            confirmButtonColor: "#f4ac6d"
        }).then(function() {
            window.location.href = "homePage.php";
        });
    </script>
</body>

</html>

<?php
exit;
?>
