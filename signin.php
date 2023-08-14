<?php
session_start();
$servername = 'localhost';
$username = $_POST['username'];
$password = $_POST['password'];
$conn = new mysqli($servername, 'root', '', 'bookhive');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO credenentials (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
if ($stmt->execute()) {
    setcookie('username', $username, time() + (86400 * 30), "/");
    setcookie('password', $password, time() + (86400 * 30), '/');
    setcookie('loggedin', 'true', time() + (86400 * 30), "/");
    header('Location: index.html');
    exit();
} else {
    echo "<script>alert('Sign in failure')</script>";
}
?>