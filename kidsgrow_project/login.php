<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidsgrow";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    // Determine user table
    if ($role == "charity") {
        $table = "charities";
    } elseif ($role == "donor") {
        $table = "donors";
    } elseif ($role == "volunteer") {
        $table = "volunteer";
    } else {
        echo "<script>alert('Invalid role selected!'); window.location.href='login.html';</script>";
        exit();
    }

    // Prepare SQL
    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check user and password
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = [
                'name'  => $row['name'],
                'email' => $row['email'],
                'role'  => $role,
                'image' => $row['image'] ?? '' 
            ];

            //Set login success flag for alert on next page
            $_SESSION['login_success'] = true;
            header("Location: donation.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
