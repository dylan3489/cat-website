<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Appointment Details - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-cat-container {
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

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-cat-container button {
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

        .edit-cat-container button:hover {
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
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

$appointment = null;
$message = '';

// fetch appointment details
if (isset($_GET['appointment_id'])) {
    $appointment_id = mysqli_real_escape_string($con, $_GET['appointment_id']);
    $query = "SELECT * FROM appointments WHERE appointment_id = '$appointment_id'";
    $result = mysqli_query($con, $query);
    $appointment = mysqli_fetch_assoc($result);

    if (!$appointment) {
        $message = "Appointment not found.";
    }
} else {
    $message = "No appointment selected.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = mysqli_real_escape_string($con, $_POST['appointment_id']);
    $appointment_date = mysqli_real_escape_string($con, $_POST['appointment_date']);
    $vet_name = mysqli_real_escape_string($con, $_POST['vet_name']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $notes = mysqli_real_escape_string($con, $_POST['notes']);
    
    if (empty($message)) {
        $update_query = "UPDATE appointments SET 
                            appointment_date = ?, 
                            vet_name = ?, 
                            status = ?, 
                            notes = ? 
                         WHERE appointment_id = ?";

        $stmt = $con->prepare($update_query);
        $stmt->bind_param("ssssi", $appointment_date, $vet_name, $status, $notes, $appointment_id);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Appointment details have been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'adminAppointmentsDatabasePage.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue updating the appointment details.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    }
}
?>

<body>
    <div class="edit-cat-container">
        <h2>Edit Appointment Details</h2>
        <form method="post">
            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['appointment_id']); ?>">

            <label for="appointment_date">Appointment Date:</label>
            <input type="datetime-local" name="appointment_date" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($appointment['appointment_date']))); ?>" required>

            <label for="vet_name">Vet Name:</label>
            <input type="text" name="vet_name" value="<?= htmlspecialchars($appointment['vet_name']); ?>">

            <label for="status">Status:</label>
            <select name="status">
                <option value="pending" <?= $appointment['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="scheduled" <?= $appointment['status'] == 'scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?= $appointment['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <label for="notes">Appointment Notes:</label>
            <textarea name="notes" required><?= htmlspecialchars($appointment['notes']); ?></textarea>

            <button type="submit">Update Appointment</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
