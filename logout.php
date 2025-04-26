<?php
session_start();
require 'config.php';

if (isset($_SESSION["user_id"])) {
    logAction($_SESSION["user_id"], "Logged out");
}

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
