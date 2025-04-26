<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Adoption Application - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-adoption-container {
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
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-adoption-container button {
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

        .edit-adoption-container button:hover {
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
    header("Location: adminSignInPage.php");
    exit();
}

$application = null;
$message = '';

if (isset($_GET['application_id'])) {
    $application_id = mysqli_real_escape_string($con, $_GET['application_id']);
    $query = "SELECT * FROM adoption_applications WHERE application_id = '$application_id'";
    $result = mysqli_query($con, $query);
    $application = mysqli_fetch_assoc($result);

    if (!$application) {
        $message = "Application not found.";
    }
} else {
    $message = "No application selected.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = mysqli_real_escape_string($con, $_POST['application_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
    $application_status = mysqli_real_escape_string($con, $_POST['application_status']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $hear_about = mysqli_real_escape_string($con, $_POST['hear_about']);
    $dwelling = mysqli_real_escape_string($con, $_POST['dwelling']);
    $ownership = mysqli_real_escape_string($con, $_POST['ownership']);
    $landlord_permission = mysqli_real_escape_string($con, $_POST['landlord_permission']);
    $household_people = mysqli_real_escape_string($con, $_POST['household_people']);
    $other_pets = mysqli_real_escape_string($con, $_POST['other_pets']);
    $allergies = mysqli_real_escape_string($con, $_POST['allergies']);
    $why_interest = mysqli_real_escape_string($con, $_POST['why_interest']);
    $preference = mysqli_real_escape_string($con, $_POST['preference']);
    $owned_cat_before = mysqli_real_escape_string($con, $_POST['owned_cat_before']);
    $previous_experience = mysqli_real_escape_string($con, $_POST['previous_experience']);
    $secure_space = mysqli_real_escape_string($con, $_POST['secure_space']);
    $hours_alone = mysqli_real_escape_string($con, $_POST['hours_alone']);
    $indoor_or_outdoor = mysqli_real_escape_string($con, $_POST['indoor_or_outdoor']);
    $secure_outdoor_area = mysqli_real_escape_string($con, $_POST['secure_outdoor_area']);
    $financial_prepared = mysqli_real_escape_string($con, $_POST['financial_prepared']);
    $lifetime_commitment = mysqli_real_escape_string($con, $_POST['lifetime_commitment']);
    $regular_care = mysqli_real_escape_string($con, $_POST['regular_care']);
    $understood_responsibility = mysqli_real_escape_string($con, $_POST['understood_responsibility']);
    $accuracy_confirm = mysqli_real_escape_string($con, $_POST['accuracy_confirm']);
    $home_visit_permission = mysqli_real_escape_string($con, $_POST['home_visit_permission']);
    $understood_terms = mysqli_real_escape_string($con, $_POST['understood_terms']);

    if (empty($message)) {
        $update_query = "UPDATE adoption_applications SET application_status = ?, age = ?, occupation = ?, hear_about = ?, dwelling = ?, ownership = ?, landlord_permission = ?, household_people = ?, other_pets = ?, allergies = ?, why_interest = ?, preference = ?, owned_cat_before = ?, previous_experience = ?, secure_space = ?, hours_alone = ?, indoor_or_outdoor = ?, secure_outdoor_area = ?, financial_prepared = ?, lifetime_commitment = ?, regular_care = ?, understood_responsibility = ?, accuracy_confirm = ?, home_visit_permission = ?, understood_terms = ? WHERE application_id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param(
            "sisssssissssssssssssssiiii",
            $application_status,
            $age,
            $occupation,
            $hear_about,
            $dwelling,
            $ownership,
            $landlord_permission,
            $household_people,
            $other_pets,
            $allergies,
            $why_interest,
            $preference,
            $owned_cat_before,
            $previous_experience,
            $secure_space,
            $hours_alone,
            $indoor_or_outdoor,
            $secure_outdoor_area,
            $financial_prepared,
            $lifetime_commitment,
            $regular_care,
            $understood_responsibility,
            $accuracy_confirm,
            $home_visit_permission,
            $understood_terms,
            $application_id
        );
        # update cats database on submission (cats adoption status)
        if ($stmt->execute()) {
            if ($application_status == 'accepted') {
                $update_cat_query = "UPDATE cats SET adoption_status = 'adopted' WHERE cat_id = ?";
                $cat_stmt = $con->prepare($update_cat_query);
                $cat_stmt->bind_param("i", $cat_id);
                $cat_stmt->execute();
            } else {
                $update_cat_query = "UPDATE cats SET adoption_status = 'available' WHERE cat_id = ?";
                $cat_stmt = $con->prepare($update_cat_query);
                $cat_stmt->bind_param("i", $cat_id);
                $cat_stmt->execute();
            }

            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Adoption application updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue updating the application.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: '$message',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<body>
    <div class="edit-adoption-container">
        <h2>Edit Adoption Application</h2>
        <form method="post">
            <input type="hidden" name="application_id" value="<?= htmlspecialchars($application['application_id']); ?>">

            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?= htmlspecialchars($application['user_id']); ?>" required>

            <label for="cat_id">Cat ID:</label>
            <input type="text" name="cat_id" value="<?= htmlspecialchars($application['cat_id']); ?>" required>

            <label for="application_status">Application Status:</label>
            <select name="application_status">
                <option value="pending" <?= $application['application_status'] == 'pending' ? 'selected' : ''; ?>>Pending
                </option>
                <option value="processing" <?= $application['application_status'] == 'processing' ? 'selected' : ''; ?>>
                    Processing</option>
                <option value="accepted" <?= $application['application_status'] == 'accepted' ? 'selected' : ''; ?>>
                    Accepted</option>
                <option value="unsuccessful" <?= $application['application_status'] == 'unsuccessful' ? 'selected' : ''; ?>>Unsuccessful</option>
            </select>

            <label for="age">Age:</label>
            <input type="number" name="age" value="<?= htmlspecialchars($application['age']); ?>">

            <label for="occupation">Occupation:</label>
            <input type="text" name="occupation" value="<?= htmlspecialchars($application['occupation']); ?>">

            <label for="hear_about">How did you hear about us?</label>
            <input type="text" name="hear_about" value="<?= htmlspecialchars($application['hear_about']); ?>">

            <label for="dwelling">Type of Dwelling:</label>
            <input type="text" name="dwelling" value="<?= htmlspecialchars($application['dwelling']); ?>">

            <label for="ownership">Do you own your dwelling?</label>
            <input type="text" name="ownership" value="<?= htmlspecialchars($application['ownership']); ?>">

            <label for="landlord_permission">Landlord Permission:</label>
            <select name="landlord_permission">
                <option value="yes" <?= $application['landlord_permission'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['landlord_permission'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="household_people">Number of People in Household:</label>
            <input type="number" name="household_people"
                value="<?= htmlspecialchars($application['household_people']); ?>">

            <label for="other_pets">Do you have other pets?</label>
            <select name="other_pets">
                <option value="yes" <?= $application['other_pets'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['other_pets'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="allergies">Anyone in your household have allergies to cats?</label>
            <select name="allergies">
                <option value="yes" <?= $application['allergies'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['allergies'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="why_interest">Why are you interested in adopting this cat?</label>
            <textarea name="why_interest" required><?= htmlspecialchars($application['why_interest']); ?></textarea>

            <label for="preference">Do you have any preferences (e.g., age, personality)?</label>
            <input type="text" name="preference" value="<?= htmlspecialchars($application['preference']); ?>">

            <label for="owned_cat_before">Have you owned a cat before?</label>
            <select name="owned_cat_before">
                <option value="yes" <?= $application['owned_cat_before'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['owned_cat_before'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="previous_experience">Please describe any previous experience with pets:</label>
            <textarea
                name="previous_experience"><?= htmlspecialchars($application['previous_experience']); ?></textarea>

            <label for="secure_space">Do you have a secure space for the cat?</label>
            <select name="secure_space">
                <option value="yes" <?= $application['secure_space'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['secure_space'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="hours_alone">How many hours per day will the cat be alone?</label>
            <input type="text" name="hours_alone" value="<?= htmlspecialchars($application['hours_alone']); ?>">

            <label for="indoor_or_outdoor">Will the cat be indoor or outdoor?</label>
            <input type="text" name="indoor_or_outdoor"
                value="<?= htmlspecialchars($application['indoor_or_outdoor']); ?>">

            <label for="secure_outdoor_area">Do you have a secure outdoor area for the cat?</label>
            <select name="secure_outdoor_area">
                <option value="yes" <?= $application['secure_outdoor_area'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['secure_outdoor_area'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="financial_prepared">Are you financially prepared for the responsibility of a pet?</label>
            <select name="financial_prepared">
                <option value="yes" <?= $application['financial_prepared'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['financial_prepared'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="lifetime_commitment">Are you committed to a lifetime of care for the cat?</label>
            <select name="lifetime_commitment">
                <option value="yes" <?= $application['lifetime_commitment'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['lifetime_commitment'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="regular_care">Can you provide regular care for the cat?</label>
            <select name="regular_care">
                <option value="yes" <?= $application['regular_care'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?= $application['regular_care'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="understood_responsibility">Do you understand the responsibilities of pet ownership?</label>
            <select name="understood_responsibility">
                <option value="yes" <?= $application['understood_responsibility'] == 'yes' ? 'selected' : ''; ?>>Yes
                </option>
                <option value="no" <?= $application['understood_responsibility'] == 'no' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="accuracy_confirm">Do you confirm the accuracy of the information provided?</label>
            <select name="accuracy_confirm">
                <option value="1" <?= $application['accuracy_confirm'] == '1' ? 'selected' : ''; ?>>Yes</option>
                <option value="0" <?= $application['accuracy_confirm'] == '0' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="home_visit_permission">Do you grant permission for a home visit?</label>
            <select name="home_visit_permission">
                <option value="1" <?= $application['home_visit_permission'] == '1' ? 'selected' : ''; ?>>Yes</option>
                <option value="0" <?= $application['home_visit_permission'] == '0' ? 'selected' : ''; ?>>No</option>
            </select>

            <label for="understood_terms">Do you understand the adoption terms?</label>
            <select name="understood_terms">
                <option value="1" <?= $application['understood_terms'] == '1' ? 'selected' : ''; ?>>Yes</option>
                <option value="0" <?= $application['understood_terms'] == '0' ? 'selected' : ''; ?>>No</option>
            </select>

            <button type="submit">Update Application</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
