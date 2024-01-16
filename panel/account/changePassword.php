<?php
if (!isset($_SESSION["usercookie"])) {
                    header('Location: ../login/index.php');
                    exit();
} else {
    // next... 
}
include "../../incl/lib/connection.php";
include_once "../../config/security.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
include_once "../../incl/lib/defuse-crypto.phar";
echo '<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">
<div class="form">
<section id="toolbox">';
error_reporting(E_ERROR | E_PARSE);
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$userName = ExploitPatch::remove($_POST["userName"]);
$oldpass = $_POST["oldpassword"];
$newpass = $_POST["newpassword"];
$salt = "";
if($userName != "" AND $newpass != "" AND $oldpass != ""){
$pass = GeneratePass::isValidUsrname($userName, $oldpass);
if ($pass == 1) {
	//creating pass hash
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt]);
	GeneratePass::assignGJP2($accid, $pass);
	echo "Пароль изменён.";
	//decrypting save
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
	$saveData = file_get_contents("../../data/accounts/$accountID");
	if(file_exists("../../data/accounts/keys/$accountID")){
		$protected_key_encoded = file_get_contents("../../data/accounts/keys/$accountID");
		if($protected_key_encoded != ""){
			$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
			$user_key = $protected_key->unlockKey($oldpass);
			try {
				$saveData = Crypto::decrypt($saveData, $user_key);
			} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
				exit("Unable to update save data encryption");	
			}
			file_put_contents("../../data/accounts/$accountID",$saveData);
			file_put_contents("../../data/accounts/keys/$accountID","");
		}
	}
}else{
	echo 'Неправильный старый пароль или неизвестный аккаунт.<br><button onclick="window.location.href = \'changePassword.php\';"><strong>Повторить</strong></button>';

}
}else{
	echo '<form action="changePassword.php" method="post"><h1>Смена пароля <font color="#fff">GDPS</font></h1> Никнейм: <input type="text" placeholder="Никнейм" name="userName"><br>Старый пароль: <input type="password" placeholder="Старый пароль" name="oldpassword"><br>Новый пароль: <input type="password" placeholder="Новый пароль" name="newpassword"><br><br><div class="warning"><font color="yellow">⚠️<b>Внимание!</b>Вы должны сохранить свой аккаунт, а после изменения зайти через refresh login.</font></div><br><input type="submit" value="Изменить пароль"></form>';
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