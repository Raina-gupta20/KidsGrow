<?php
$servername = "localhost";
$username   = "root";
$password   = "";        
$dbname     = "kidsgrow";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>
