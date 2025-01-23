<?php     /*this is the php code to connect to the database*/

$serverName = "localhost";
$userName = "root";
$password  = "";
$dbName = "ninelives";

$con = mysqli_connect($serverName, $userName, $password, $dbName);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} else {
    echo "Database connection successful!";
}
?>

