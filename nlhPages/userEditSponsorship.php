<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Edit Sponsorship - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // JS function to toggle visibility of the renewal date field based on sponsorship type
        function toggleRenewalDate() {
            var sponsorshipType = document.querySelector("select[name='sponsorship_type']").value;
            var renewalDateRow = document.querySelector(".renewal-date-row");

            if (sponsorshipType === "recurring") {
                renewalDateRow.style.display = "block";
            } else {
                renewalDateRow.style.display = "none";
                document.querySelector("input[name='renewal_date']").value = ""; // clears renewal date if not recurring
            }
        }

        // run function when the page loads (checks if renewal is needed)
        window.onload = function() {
            toggleRenewalDate();
        };
    </script>
</head>

<?php

session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

if (!isset($_SESSION['user_id'])) {
    header("Location: userSignInPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sponsorship_id = $_GET['sponsorship_id'] ?? null;

if (!$sponsorship_id) {
    die("Invalid request.");
}

// fetch sponsorship details
$query = "SELECT * FROM sponsorships WHERE sponsorship_id = ? AND user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $sponsorship_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$sponsorship = $result->fetch_assoc();

if (!$sponsorship) {
    die("Sponsorship not found or unauthorized access.");
}

// form submission 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_amount = $_POST['amount'];
    $new_status = $_POST['status'];
    $new_renewal_date = $_POST['renewal_date'] ?? null; // renewal is optional (recurring/one-time)
    $new_sponsorship_type = $_POST['sponsorship_type'];

    if (!in_array($new_sponsorship_type, ['one-time', 'recurring'])) {
        die("Invalid sponsorship type.");
    }

    $update_query = "UPDATE sponsorships SET sponsorship_amount = ?, status = ?, renewal_date = ?, sponsorship_type = ? WHERE sponsorship_id = ? AND user_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("dsssii", $new_amount, $new_status, $new_renewal_date, $new_sponsorship_type, $sponsorship_id, $user_id);

    // SweetAlert popups for success/failure
    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Your sponsorship has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'userViewSponsorshipsPage.php';
                });
              </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue updating your sponsorship.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<body>
    <h2>Edit Sponsorship</h2>
    <form method="post">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" value="<?= htmlspecialchars($sponsorship['sponsorship_amount']); ?>" required><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active" <?= $sponsorship['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?= $sponsorship['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select><br>

        <div class="renewal-date-row">
            <label for="renewal_date">Renewal Date:</label>
            <input type="date" name="renewal_date" value="<?= htmlspecialchars($sponsorship['renewal_date']); ?>"><br>
        </div>

        <label for="sponsorship_type">Sponsorship Type:</label>
        <select name="sponsorship_type" onchange="toggleRenewalDate()">
            <option value="one-time" <?= $sponsorship['sponsorship_type'] == 'one-time' ? 'selected' : ''; ?>>one-time</option>
            <option value="recurring" <?= $sponsorship['sponsorship_type'] == 'recurring' ? 'selected' : ''; ?>>recurring</option>
        </select><br>

        <button type="submit">Update Sponsorship</button>
    </form>
</body>

<?php include 'footer.php' // footer ?> 


</html>
