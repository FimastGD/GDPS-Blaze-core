<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: ../login/index.php');
                    exit();
} else {
    // next... 
}
?>
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">
<section id="toolbox">
<div class="form">
<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/Captcha.php";
require_once "../../incl/lib/exploitPatch.php";
//here im getting all the data
if(!empty($_POST["userName"]) && !empty($_POST["password"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	if(!Captcha::validateCaptcha())
		exit('Вы не прошли капчу!
		<br>
		<button onclick="window.location.href = \'activate.php\';"><strong>Повторить</strong></button>');
	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == -2){
		$query = $db->prepare("UPDATE accounts SET isActive = 1 WHERE userName LIKE :userName");
		$query->execute(['userName' => $userName]);
		echo 'Аккаунт успешно <b>активирован.</b>
		';
	}
	elseif ($pass == 1) {
		echo 'Аккаунт уже был активирован.
		<br>
		<button onclick="window.location.href = \'activate.php\';"><strong>Повторить</strong></button>';
	}else{
		echo 'Неверный пароль или аккаунт
		<br>
		<button onclick="window.location.href = \'activate.php\';"><strong>Повторить</strong></button>';
	}
}else{
	echo '<form method="post">
	<h1>Активация аккаунта <font color="#fff">GDPS</font></h1>
		Никнейм: <input type="text" placeholder="Никнейм GDPS" name="userName"><br>
		Пароль: <input type="password" placeholder="Пароль GDPS" name="password"><br>';
		Captcha::displayCaptcha();
	echo '<input type="submit" value="Активировать"></form>';
}
?>
<br>
<br>
<button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
</section>
</div>