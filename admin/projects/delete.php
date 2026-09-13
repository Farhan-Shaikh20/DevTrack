<?php
require "../../includes/auth.php";
require "../../config/database.php";

if (!isset($_GET["id"])) {
    die("Project ID is missing.");
}

$project_id = $_GET["id"];

$sql = "DELETE FROM projects WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $project_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting project.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>