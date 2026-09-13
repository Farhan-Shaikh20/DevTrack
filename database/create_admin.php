<?php
require "../config/database.php";

$name = "Admin";
$email = "admin@devtrack.com";
$password = "devtrack065";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role = "admin";

$sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashed_password, $role);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>