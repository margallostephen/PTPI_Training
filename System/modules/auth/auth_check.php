<?php
include "../../includes/path.php";

session_start();

$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['user_id'])) {
    header("Location: /$systemFolder/pages/auth");
    exit();
}
?>