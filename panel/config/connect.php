<?php
$username = "USER";
$password = "PASSWORD";
$dbname = "DATABASE NAME";



// other connection, do not change
$connect = mysqli_connect('localhost', $username, $password, $dbname);

if (!$connect) {
    die('Error connect to Database!');
} 