<?php
session_start();

unset($_SESSION['petty_cash']);



header("Location: login.php");

?>