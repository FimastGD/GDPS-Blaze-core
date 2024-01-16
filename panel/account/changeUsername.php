<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location:  ../login/index.php');
                    exit();
} else {
    // next... 
}
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
echo '<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">
<div class="form">
<section id="toolbox">';
error_reporting(E_ERROR | E_PARSE);
//here im getting all the data
$userName = ExploitPatch::remove($_POST["userName"]);
$newusr = ExploitPatch::remove($_POST["newusr"]);
$password = ExploitPatch::remove($_POST["password"]);
if($userName != "" AND $newusr != "" AND $password != ""){
	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == 1) {
		if(strlen($newusr) > 20)
			exit('Новый никнейм слишком большой. <button onclick="window.location.href = \'changeUsername.php\';"><strong>Повторить</strong></button>');
		$query = $db->prepare("UPDATE accounts SET username=:newusr WHERE userName=:userName");	
		$query->execute([':newusr' => $newusr, ':userName' => $userName]);
		if($query->rowCount()==0){
			echo 'Обнаружено совпадение никнеймов или неизвестный аккаунт.<br><button onclick="window.location.href = \'changeUsername.php\';"><strong>Повторить</strong></button>';
		}else{
			echo "Никнейм изменён.";
		}
	}else{
		echo 'Обнаружено совпадение никнеймов или неизвестный аккаунт. <br> <button onclick="window.location.href = \'changeUsername.php\';"><strong>Повторить</strong></button>';
	}
}else{
	echo '<form action="changeUsername.php" method="post"><h1>Смена никнейма <font color="#fff">GDPS</font></h1> Старый никнейм: <input type="text" placeholder="Старый никнейм" name="userName"><br>Новый никнейм: <input type="text" placeholder="Новый никнейм" name="newusr"><br>Пароль: <input type="password" placeholder="Пароль" name="password"><br><br><div class="warning"><font color="yellow">⚠️<b>Внимание! </b>Вы должны сохранить свой аккаунт, а после изменения зайти через refresh login.</font></div><br><input type="submit" value="Изменить никнейм"></form>';
}
?>
<br>
<br>
<button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
</section>
</div>
<style>
   .warning {
       border: 2px solid yellow;
       border-radius: 4px;
       background: rgba(239,200,0,0.495);
   }
 
 
</style>