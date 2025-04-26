<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Sponsorship Details - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        input[readonly],
        select[readonly] {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }
    </style>
    <script>
        // JS toggles renewal date 
        function toggleRenewalDate() {
            const sponsorshipType = document.querySelector('select[name="sponsorship_type"]').value;
            const renewalDateField = document.getElementById('renewal_date_field');
            if (sponsorshipType === 'recurring') {
                renewalDateField.style.display = 'block';
            } else {
                renewalDateField.style.display = 'none';
            }
        }

        window.onload = toggleRenewalDate;
    </script>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

$sponsorship = null;
$message = '';

if (isset($_GET['sponsorship_id'])) {
    $sponsorship_id = mysqli_real_escape_string($con, $_GET['sponsorship_id']);
    $query = "SELECT s.sponsorship_id, s.user_id, s.cat_id, s.sponsorship_amount, s.sponsorship_date, s.status, s.sponsorship_type, s.renewal_date,
                     u.first_name, u.last_name, c.cat_name
              FROM sponsorships AS s
              JOIN users AS u ON s.user_id = u.user_id
              JOIN cats AS c ON s.cat_id = c.cat_id
              WHERE s.sponsorship_id = '$sponsorship_id'";
    $result = mysqli_query($con, $query);
    $sponsorship = mysqli_fetch_assoc($result);

    if (!$sponsorship) {
        $message = "Sponsorship not found.";
    }
} else {
    $message = "No sponsorship selected.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sponsorship_id = mysqli_real_escape_string($con, $_POST['sponsorship_id']);
    $sponsorship_amount = mysqli_real_escape_string($con, $_POST['sponsorship_amount']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $sponsorship_type = mysqli_real_escape_string($con, $_POST['sponsorship_type']);
    $renewal_date = isset($_POST['renewal_date']) ? mysqli_real_escape_string($con, $_POST['renewal_date']) : null;

    if ($sponsorship_type == 'recurring' && empty($renewal_date)) {
        $message = "Renewal Date is required for recurring sponsorships.";
    }

    if (empty($message)) {
        if ($sponsorship_type == 'one-time') {
            $renewal_date = null;
        }

        if ($sponsorship_type == 'recurring') {
            $update_query = "UPDATE sponsorships SET 
                                sponsorship_amount = ?, 
                                status = ?, 
                                sponsorship_type = ?, 
                                renewal_date = ? 
                             WHERE sponsorship_id = ?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("dsssi", $sponsorship_amount, $status, $sponsorship_type, $renewal_date, $sponsorship_id);
        } else {
            $update_query = "UPDATE sponsorships SET 
                                sponsorship_amount = ?, 
                                status = ?, 
                                sponsorship_type = ?, 
                                renewal_date = NULL 
                             WHERE sponsorship_id = ?";
            $stmt = $con->prepare($update_query);
            $stmt->bind_param("dssi", $sponsorship_amount, $status, $sponsorship_type, $sponsorship_id);
        }

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Sponsorship details have been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: 'rgb(211, 133, 64)'  
                    }).then(function() {
                        window.location.href = 'adminSponsorshipDatabasePage.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue updating the sponsorship details.',
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
    <div class="edit-sponsorship-container">
        <h2>Edit Sponsorship Details</h2>
        <?php if ($message): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="sponsorship_id" value="<?= htmlspecialchars($sponsorship['sponsorship_id']); ?>">

            <label for="user_id">User Name:</label>
            <input type="text"
                value="<?= htmlspecialchars($sponsorship['first_name'] . ' ' . $sponsorship['last_name']); ?>" readonly>

            <label for="cat_id">Cat Name:</label>
            <input type="text" value="<?= htmlspecialchars($sponsorship['cat_name']); ?>" readonly>

            <label for="sponsorship_amount">Sponsorship Amount (£):</label>
            <input type="number" step="0.01" name="sponsorship_amount"
                value="<?= htmlspecialchars($sponsorship['sponsorship_amount']); ?>" required>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="active" <?= $sponsorship['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= $sponsorship['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                <option value="expired" <?= $sponsorship['status'] == 'expired' ? 'selected' : ''; ?>>Expired</option>
                <option value="canceled" <?= $sponsorship['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
            </select>

            <label for="sponsorship_type">Sponsorship Type:</label>
            <select name="sponsorship_type" required onchange="toggleRenewalDate()">
                <option value="one-time" <?= $sponsorship['sponsorship_type'] == 'one-time' ? 'selected' : ''; ?>>One-time
                </option>
                <option value="recurring" <?= $sponsorship['sponsorship_type'] == 'recurring' ? 'selected' : ''; ?>>
                    Recurring</option>
            </select>

            <div id="renewal_date_field"
                style="display: <?= $sponsorship['sponsorship_type'] == 'recurring' ? 'block' : 'none'; ?>;">
                <label for="renewal_date">Renewal Date:</label>
                <input type="date" name="renewal_date" value="<?= htmlspecialchars($sponsorship['renewal_date']); ?>">
            </div>

            <button type="submit">Update Sponsorship</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
