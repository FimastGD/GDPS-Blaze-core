<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location:  ../login/index.php');
                    exit();
} else {
    // next... 
}
include "../../config/security.php";
include "../../incl/lib/connection.php";
require "../../incl/lib/exploitPatch.php";
require "../../incl/lib/generatePass.php";
echo '
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">
<div class="form">
<section id="toolbox"> ';
if(!isset($preactivateAccounts)){
	$preactivateAccounts = true;
}

// here begins the checks
if(!empty($_POST["username"]) AND !empty($_POST["email"]) AND !empty($_POST["repeatemail"]) AND !empty($_POST["password"]) AND !empty($_POST["repeatpassword"])){
	// catching all the input
	$username = ExploitPatch::remove($_POST["username"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$repeat_password = ExploitPatch::remove($_POST["repeatpassword"]);
	$email = ExploitPatch::remove($_POST["email"]);
	$repeat_email = ExploitPatch::remove($_POST["repeatemail"]);
	if(strlen($username) < 3){
		// choose a longer username
		echo '<font color="red">Никнейм должен быть длиннее 3 символов.</font><hr><form action="register.php" method="post">Никнейм: <input type="text" placeholder="Никнейм" name="username" maxlength=15><br>Пароль: <input type="password" placeholder="Пароль" name="password" maxlength=20><br>Повторите пароль: <input type="password" placeholder="Повторите пароль" name="repeatpassword" maxlength=20><br>E-mail: <input type="text" placeholder="E-mail" name="email" maxlength=50><br>Повторите E-mail: <input type="text" placeholder="Повторите E-mail" name="repeatemail" maxlength=50><br><input type="submit" value="Зарегистрироваться"></form>';
	}elseif(strlen($password) < 6){
		// just why did you want to give a short password? do you wanna be hacked?
		echo '<font color="red">Пароль должен быть длиннее 6 символов.</font><hr><form action="register.php" method="post">Никнейм: <input type="text" placeholder="Никнейм" name="username" maxlength=15><br>Пароль: <input type="password" placeholder="Пароль" name="password" maxlength=20><br>Повторите пароль: <input type="password" placeholder="Повторите пароль" name="repeatpassword" maxlength=20><br>E-mail: <input type="text" placeholder="E-mail" name="email" maxlength=50><br>Повторите E-mail: <input type="text" placeholder="Повторите E-mail" name="repeatemail" maxlength=50><br><input type="submit" value="Зарегистрироваться"></form>';
	}else{
		// this checks if there is another account with the same username as your input
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $username]);
		$registred_users = $query->fetchColumn();
		if($registred_users > 0){
			// why did you want to make a new account with the same username as someone else's
			echo '<font color="red">Имя пользователя уже занято.</font><hr><form action="register.php" method="post">Никнейм: <input type="text" placeholder="Никнейм" name="username" maxlength=15><br>Пароль: <input type="password" placeholder="Пароль" name="password" maxlength=20><br>Повторите пароль: <input type="password" placeholder="Повторите пароль" name="repeatpassword" maxlength=20><br>E-mail: <input type="text" placeholder="E-mail" name="email" maxlength=50><br>Повторите E-mail: <input type="text" placeholder="Повторите E-mail" name="repeatemail" maxlength=50><br><input type="submit" value="Зарегистрироваться"></form>';
		}else{
			if($password != $repeat_password){
				// this is when the passwords do not match
				echo '<font color="red">Пароли не совпадают.</font><hr><form action="register.php" method="post">Никнейм: <input type="text" placeholder="Никнейм" name="username" maxlength=15><br>Пароль: <input type="password" placeholder="Пароль" name="password" maxlength=20><br>Повторите пароль: <input type="password" placeholder="Повторите пароль" name="repeatpassword" maxlength=20><br>E-mail: <input type="text" placeholder="E-mail" name="email" maxlength=50><br>Повторите E-mail: <input type="text" placeholder="Повторите E-mail" name="repeatemail" maxlength=50><br><input type="submit" value="Зарегистрироваться"></form>';
			}elseif($email != $repeat_email){
				// this is when the emails dont match
				echo '<font color="red">E-mail не совпадают.</font><hr><form action="register.php" method="post">Никнейм: <input type="text" placeholder="Никнейм" name="username" maxlength=15><br>Пароль: <input type="password" placeholder="Пароль" name="password" maxlength=20><br>Повторите пароль: <input type="password" placeholder="Повторите пароль" name="repeatpassword" maxlength=20><br>E-mail: <input type="text" placeholder="E-mail" name="email" maxlength=50><br>Повторите E-mail: <input type="text" placeholder="Повторите E-mail" name="repeatemail" maxlength=50><br><input type="submit" value="Зарегистрироваться"></form>';
			}else{
				// hashing your password and registering your account
				$hashpass = password_hash($password, PASSWORD_DEFAULT);
				$query2 = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive, gjp2)
				VALUES (:userName, :password, :email, :time, :isActive, :gjp2)");
				$query2->execute([':userName' => $username, ':password' => $hashpass, ':email' => $email,':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0, ':gjp2' => GeneratePass::GJP2hash($password)]);
				// there you go, you are registered.
				$activationInfo = $preactivateAccounts ? "No e-mail verification required, you can login." : "<a href='activateAccount.php'>Click here to activate it.</a>";
				echo 'Аккаунт зарегистрирован, E-mail подтверждать не надо. <br>
				<button onclick="window.location.href = \'activate.php\';"><strong>Активировать аккаунт</strong></button>
				<br>';
			}
		}
	}
}else{
	// this is given when we dont have an input
	echo '<form action="register.php" method="post"><h1>Регистрация аккаунтов <font color="#fff">GDPS</font></h1> Никнейм: <input type="text" placeholder="Никнейм" name="username" maxlength=15><br>Пароль: <input type="password" placeholder="Пароль" name="password" maxlength=20><br>Повторите пароль: <input type="password" placeholder="Повторите пароль" name="repeatpassword" maxlength=20><br>E-mail: <input type="text" placeholder="E-mail" name="email" maxlength=50><br>Повторите E-mail: <input type="text" placeholder="Повторите E-mail" name="repeatemail" maxlength=50><br><input type="submit" value="Зарегистрироваться"></form>';
}
?>
<br>
<br>
<button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
</section>
</div>