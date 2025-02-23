<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-application-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #8B5E3C;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-application-container button {
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

        .edit-application-container button:hover {
            background-color: rgb(211, 133, 64);
        }

        .edit-application-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #8B5E3C;
        }
    </style>
</head>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php';

// if the admin is not logged in, redirect to sign in page
if (!isset($_SESSION['loggedin']) || $_SESSION['admin_status'] != 1) {
    header('Location:adminSignInPage.php');
    exit();
}

// check if received application_id 
if (isset($_GET['application_id'])) {
    $application_id = intval($_GET['application_id']);

    // fetch application details
    $query = "SELECT * FROM adoption_applications WHERE application_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();

    if (!$application) {
        echo "Application not found.";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // update application details if not
    $application_id = intval($_POST['application_id']);
    $fields = [
        'age', 'occupation', 'hear_about', 'dwelling', 'ownership',
        'landlord_permission', 'household_people', 'other_pets', 'allergies',
        'why_interest', 'preference', 'owned_cat_before', 'previous_experience',
        'secure_space', 'hours_alone', 'indoor_or_outdoor', 'secure_outdoor_area',
        'financial_prepared', 'lifetime_commitment', 'regular_care',
        'understood_responsibility', 'accuracy_confirm', 'home_visit_permission',
        'understood_terms', 'application_status'
    ];
    $values = [];
    $placeholders = [];

    foreach ($fields as $field) {
        $values[] = $_POST[$field];
        $placeholders[] = "$field = ?";
    }
    $values[] = $application_id;

    $query = "UPDATE adoption_applications SET " . implode(", ", $placeholders) . " WHERE application_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param(str_repeat("s", count($fields)) . "i", ...$values);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Application details have been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'viewIndvApplication.php?application_id=$application_id';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue updating the application details.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
    exit();
} else {
    echo "No application ID provided.";
    exit();
}
?>

<body>
    <div class="edit-application-container">
        <h1>Edit Application Details</h1>
        <form method="post">
            <input type="hidden" name="application_id" value="<?= htmlspecialchars($application['application_id']) ?>">
            <?php foreach ($application as $field => $value): 
                if ($field === 'application_id') continue; // skip application_id
            ?>
                <label for="<?= $field ?>"> <?= ucwords(str_replace('_', ' ', $field)) ?>:</label>
                <?php if (in_array($field, ['why_interest', 'previous_experience'])): ?>
                    <textarea name="<?= $field ?>" id="<?= $field ?>"> <?= htmlspecialchars($value) ?></textarea>
                <?php else: ?>
                    <input type="text" name="<?= $field ?>" id="<?= $field ?>" value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit">Save Changes</button>
        </form>
        <a href="viewIndvApplication.php?application_id=<?= htmlspecialchars($application['application_id']) ?>">Cancel</a>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
