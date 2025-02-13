<?php
$servername = "localhost:5222";
$username = "root";
$password = "";
$dbname = "nursery";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
