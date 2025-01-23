<!DOCTYPE html>
<html lang="en">
    
<?php
session_start();
require 'connectdb.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

if (isset($_GET['appointment_id'])) {
    $appointment_id = mysqli_real_escape_string($con, $_GET['appointment_id']);

    // fetch appointment details
    $query = "SELECT * FROM appointments WHERE appointment_id = '$appointment_id'";
    $result = mysqli_query($con, $query);
    $appointment = mysqli_fetch_assoc($result);

    if (!$appointment) {
        echo "Appointment not found.";
        exit();
    }

    // fetch ENUM options for 'status'
    $enum_query = "SHOW COLUMNS FROM appointments LIKE 'status'";
    $enum_result = mysqli_query($con, $enum_query);
    $enum_row = mysqli_fetch_assoc($enum_result);

    // parse ENUM options
    preg_match("/^enum\((.*)\)$/", $enum_row['Type'], $matches);
    $enum_values = array_map(function ($value) {
        return trim($value, "'");
    }, explode(',', $matches[1]));
} else {
    echo "No appointment selected.";
    exit();
}
?>

<head>
    <title>Edit Appointment Details</title>
</head>
<body>
    <h1>Edit Appointment Details</h1>
    <form action="updateAppointmentDetails.php" method="post">
        <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['appointment_id']) ?>">
        <label>Appointment Date:</label>
        <input type="text" name="appointment_date" value="<?= htmlspecialchars($appointment['appointment_date']) ?>"><br>

        <label>Appointment Status:</label>
        <select name="status">
            <?php foreach ($enum_values as $value): ?>
                <option value="<?= htmlspecialchars($value) ?>" <?= $appointment['status'] == $value ? 'selected' : '' ?>>
                    <?= htmlspecialchars(ucfirst($value)) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Appointment Notes:</label>
        <input type="text" name="notes" value="<?= htmlspecialchars($appointment['notes']) ?>"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
