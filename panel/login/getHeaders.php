<?php
session_start();

require_once '../config/connect.php';
$connect;
$_SESSION['log'] = '';
$_SESSION['c_username'] = $_POST['username'];
$_SESSION['c_password'] = $_POST['password'];

header('Location: ../index.php');
exit();



