<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}
if ($_SESSION["role"] != "client") {
    header("Location: ../index.php");
    exit;
}
?>