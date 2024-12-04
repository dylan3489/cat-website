<?php     /*this is the php code to connect to the database*/

$serverName = "localhost";
$userName = "root";
$password  = "";
$dbName = "healthpointdb";

$con = mysqli_connect($serverName, $userName, $password, $dbName);

if(mysqli_connect_errno()){
    echo "Failed to connect";
    exit();
}
?>

