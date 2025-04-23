<?php
session_start();
include 'db.php';

$email    = $_POST['email']    ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, password FROM donor WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        header("Location: donation.php");
        exit;
    } else {
        die("Invalid password.");
    }
} else {
    die("User not found.");
}
?>
