<?php
session_start();

unset($_SESSION["usercookie"]);
unset($_SESSION['c_username']);
unset($_SESSION['c_password']);
session_destroy();
header('Location: ../login/index.php');
exit();
?>