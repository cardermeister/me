<?php 
require "db.php";
unset($_SESSION['logged_user']);
session_unset();
session_destroy();
header('Location: index.php');
?>