<?php
require "../../includes/auth.php";
require "../../config/database.php";

if (!isset($_GET["id"])) {
    die("Client ID is missing.");
}

$client_id = $_GET["id"];

$sql = "SELECT user_id FROM client WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $client_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) != 1) {
    die("Client not found.");
}

$client = mysqli_fetch_assoc($result);
$user_id = $client["user_id"];
mysqli_stmt_close($stmt);

$sql_delete = "DELETE FROM client WHERE id = ?";
$stmt_delete = mysqli_prepare($conn, $sql_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $client_id);

if (mysqli_stmt_execute($stmt_delete)) {
    $sql_user = "DELETE FROM users WHERE id = ?";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "i", $user_id);
    mysqli_stmt_execute($stmt_user);
    mysqli_stmt_close($stmt_user);
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting client.";
}

mysqli_stmt_close($stmt_delete);
mysqli_close($conn);
?>