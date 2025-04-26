<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Edit Sponsorship - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-sponsorship-container {
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
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-sponsorship-container button {
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

        .edit-sponsorship-container button:hover {
            background-color: rgb(211, 133, 64);
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
    <script>
        // JS function to toggle visibility of  renewal date
        function toggleRenewalDate() {
            var sponsorshipType = document.querySelector("select[name='sponsorship_type']").value;
            var renewalDateRow = document.querySelector(".renewal-date-row");

            if (sponsorshipType === "recurring") {
                renewalDateRow.style.display = "block";
            } else {
                renewalDateRow.style.display = "none";
                document.querySelector("input[name='renewal_date']").value = "";
            }
        }
        window.onload = function () {
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

$query = "SELECT * FROM sponsorships WHERE sponsorship_id = ? AND user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $sponsorship_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$sponsorship = $result->fetch_assoc();

if (!$sponsorship) {
    die("Sponsorship not found or unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_amount = $_POST['amount'];
    $new_status = $_POST['status'];
    $new_sponsorship_type = $_POST['sponsorship_type'];

    $new_renewal_date = ($new_sponsorship_type == 'one-time') ? null : $_POST['renewal_date'];

    if (!in_array($new_sponsorship_type, ['one-time', 'recurring'])) {
        die("Invalid sponsorship type.");
    }

    $update_query = "UPDATE sponsorships SET sponsorship_amount = ?, status = ?, renewal_date = ?, sponsorship_type = ? WHERE sponsorship_id = ? AND user_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("dsssii", $new_amount, $new_status, $new_renewal_date, $new_sponsorship_type, $sponsorship_id, $user_id);

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
    <div class="edit-sponsorship-container">
        <h2>Edit Sponsorship</h2>
        <form method="post">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" value="<?= htmlspecialchars($sponsorship['sponsorship_amount']); ?>"
                required><br>

            <label for="status">Status:</label>
            <select name="status">
                <option value="active" <?= $sponsorship['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= $sponsorship['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select><br>

            <div class="renewal-date-row">
                <label for="renewal_date">Renewal Date:</label>
                <input type="text" id="renewal" name="renewal_date" required>
                <script>
                    flatpickr("#renewal", {
                        dateFormat: "Y-m-d",
                    });
                </script>
            </div>

            <label for="sponsorship_type">Sponsorship Type:</label>
            <select name="sponsorship_type" onchange="toggleRenewalDate()">
                <option value="one-time" <?= $sponsorship['sponsorship_type'] == 'one-time' ? 'selected' : ''; ?>>one-time
                </option>
                <option value="recurring" <?= $sponsorship['sponsorship_type'] == 'recurring' ? 'selected' : ''; ?>>
                    recurring</option>
            </select><br>

            <button type="submit">Update Sponsorship</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
