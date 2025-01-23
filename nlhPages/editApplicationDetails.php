<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
</head>

<?php
session_start();

require 'connectdb.php';

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
        header("Location: viewIndvApplication.php?application_id=$application_id");
        exit();
    } else {
        echo "Error updating application: " . $stmt->error;
    }
    exit();
} else {
    echo "No application ID provided.";
    exit();
}
?>

<body>
    <h1>Edit Application Details</h1>
    <form method="post" action="">
        <input type="hidden" name="application_id" value="<?= htmlspecialchars($application['application_id']) ?>">
        <?php foreach ($application as $field => $value): 
            if ($field === 'application_id') continue; // skip application_id
        ?>
            <div>
                <label for="<?= $field ?>"><?= ucwords(str_replace('_', ' ', $field)) ?>:</label>
                <?php if (in_array($field, ['why_interest', 'previous_experience'])): ?>
                    <textarea name="<?= $field ?>" id="<?= $field ?>"><?= htmlspecialchars($value) ?></textarea>
                <?php else: ?>
                    <input type="<?= is_numeric($value) ? 'number' : 'text' ?>" 
                           name="<?= $field ?>" 
                           id="<?= $field ?>" 
                           value="<?= htmlspecialchars($value) ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit">Save Changes</button>
    </form>
    <a href="viewIndvApplication.php?application_id=<?= htmlspecialchars($application['application_id']) ?>">Cancel</a>
</body>

</html>
