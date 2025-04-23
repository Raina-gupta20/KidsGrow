<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "kidsgrow";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $organization = $_POST["organization"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: charity_register.html?error=PasswordMismatch");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and insert into database
    $stmt = $conn->prepare("INSERT INTO charities (name, email, organization, mobile, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $organization, $mobile, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit();
    } else {
        header("Location: charity_register.html?error=InsertFailed");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
