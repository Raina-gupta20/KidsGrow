<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href='donor_signup.html';</script>";
        exit();
    }

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM donors WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('Email already registered! Try logging in.'); window.location.href='login.html';</script>";
        exit();
    }

    $checkStmt->close();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert donor into DB
    $stmt = $conn->prepare("INSERT INTO donors (name, email, mobile, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $mobile, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
