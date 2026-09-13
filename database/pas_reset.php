<?php
require "../config/database.php";

$email = "farhan@gmail.com";
$new_password = "farhan065";
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = ? WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);

if (mysqli_stmt_execute($stmt)) {
    echo "Password reset successfully!";
} else {
    echo "Error resetting password: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>