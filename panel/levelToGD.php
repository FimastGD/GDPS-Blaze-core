<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: login/index.php');
                    exit();
} else {
    // next... 
}
?>
<html>
<head>
<title>GDPS Panel</title>
</head>
<body>
<?php
function chkarray($source){
	return $source == "" ? "0" : $target;
}
//error_reporting(0);
include "../incl/lib/connection.php";
require "../incl/lib/XORCipher.php";
require_once "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/generateHash.php";
echo '<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../include/components/css/mains.css">
<div class="form">
<section id="toolbox">';
if(!empty($_POST["userhere"]) AND !empty($_POST["passhere"]) AND !empty($_POST["usertarg"]) AND !empty($_POST["passtarg"]) AND !empty($_POST["levelID"])){
	$userhere = ExploitPatch::remove($_POST["userhere"]);
	$passhere = ExploitPatch::remove($_POST["passhere"]);
	$usertarg = ExploitPatch::remove($_POST["usertarg"]);
	$passtarg = ExploitPatch::remove($_POST["passtarg"]);
	$levelID = ExploitPatch::remove($_POST["levelID"]);
	$server = trim($_POST["server"]);
	$pass = GeneratePass::isValidUsrname($userhere, $passhere);
	if ($pass != 1) { //verifying if valid local usr
		exit('Неверный никнейм/пароль<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>');
	}
	$query = $db->prepare("SELECT * FROM levels WHERE levelID = :level");
	$query->execute([':level' => $levelID]);
	$levelInfo = $query->fetch();
	$userID = $levelInfo["userID"];
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :user");
	$query->execute([':user' => $userhere]);
	$accountID = $query->fetchColumn();
	$query = $db->prepare("SELECT userID FROM users WHERE extID = :ext");
	$query->execute([':ext' => $accountID]);
	if($query->fetchColumn() != $userID){ //verifying if lvl owned
		exit("This level doesn't belong to the account you're trying to reupload from");
	}
	$udid = "S" . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(1,9); //getting accountid
	$sid = mt_rand(111111111,999999999) . mt_rand(11111111,99999999);
	//echo $udid;
	$post = ['userName' => $usertarg, 'udid' => $udid, 'password' => $passtarg, 'sID' => $sid, 'secret' => 'Wmfv3899gc9'];
	$ch = curl_init($server . "/accounts/loginGJAccount.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no"){
		if($result==""){
			echo 'Произошла ошибка у серверному подключению<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>';
		}else if($result=="-1"){
			echo 'Ошибка подключения к серверу<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>';
		}else{
			echo 'РобТоп тебя не любит или что-то в этом роде?<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>';
		}
		exit("<br>Код ошибки: $result");
	}
	if(!is_numeric($levelID)){ //checking if the level id is numeric due to possible exploits
		exit('ID уровня не найден<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>');
	}
	//TODO: move all file_get_contents calls like this to a separate function
	$levelString = file_get_contents("../data/levels/$levelID");
	$seed2 = base64_encode(XORCipher::cipher(GenerateHash::genSeed2noXor($levelString),41274));
	$accountID = explode(",",$result)[0];
	$gjp = base64_encode(XORCipher::cipher($passtarg,37526));
	$post = ['gameVersion' => $levelInfo["gameVersion"], 
	'binaryVersion' => $levelInfo["binaryVersion"], 
	'gdw' => "0", 
	'accountID' => $accountID, 
	'gjp' => $gjp,
	'userName' => $usertarg,
	'levelID' => "0",
	'levelName' => $levelInfo["levelName"],
	'levelDesc' => $levelInfo["levelDesc"],
	'levelVersion' => $levelInfo["levelVersion"],
	'levelLength' => $levelInfo["levelLength"],
	'audioTrack' => $levelInfo["audioTrack"],
	'auto' => $levelInfo["auto"],
	'password' => $levelInfo["password"],
	'original' => "0",
	'twoPlayer' => $levelInfo["twoPlayer"],
	'songID' => $levelInfo["songID"],
	'objects' => $levelInfo["objects"],
	'coins' => $levelInfo["coins"],
	'requestedStars' => $levelInfo["requestedStars"],
	'unlisted' => "0",
	'wt' => "0",
	'wt2' => "3",
	'extraString' => $levelInfo["extraString"],
	'seed' => "v2R5VPi53f",
	'seed2' => $seed2,
	'levelString' => $levelString,
	'levelInfo' => $levelInfo["levelInfo"],
	'secret' => "Wmfd2893gb7"];
	if($_POST["debug"] == 1){
		var_dump($post);
	}
	$ch = curl_init($server . "/uploadGJLevel21.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "Нет нет нет!"){
		if($result==""){
			echo 'Ошибка в подключении к кастомному серверу<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>';
		}else if($result=="-1"){
			echo 'Ошибка в переносе.<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>';
		}else{
			echo 'РобТоп тебя не любит, или что-то в этом роде?<br><button onclick="window.location.href = \'levelToGD.php\';"><strong>Повторить</strong></button>';
		}
		exit("<br>Код ошибки: $result");
	}
	echo 'Уровень перенесён - <font color="white">', $result, '</font>';
}else{
	echo '<form action="levelToGD.php" method="post"><h1>Перенос уровней в <font color="#fff">Geometry Dash</font></h1> 
	<h3>Текущий сервер</h3>Никнейм: <input type="text" placeholder="Никнейм" name="userhere"><br>
	Пароль: <input type="password" placeholder="Пароль" name="passhere"><br>
	ID уровня: <input type="text" placeholder="ID" name="levelID"><br>
	<h3>Сервер GD или кастомный</h3>Никнейм: <input type="text" placeholder="Никнейм" name="usertarg"><br>
	Пароль: <input type="password" placeholder="Пароль" name="passtarg"><br>
	<details>
		<summary>Дополнительные опции</summary>
		URL серверв: <input type="text" name="server" value="http://www.boomlings.com/database/"><br>
		Режим отладки (0=off, 1=on): <input type="text" placeholder="0/1" name="debug" value="0"><br>
	</details>
	<input type="submit" value="Выгрузить уровень"></form>';
}
?>
<br>
<br>
<button onclick="window.location.href = 'index.php';"><strong>На главную</strong></button>


</body>
</html>
</section>
</div>
<style>
    details {
    border: 1px solid #ff8606;
    border-radius: 4px;
    padding: 0.5em 0.5em 0;
    color: #fff;
}

summary {
    font-weight: bold;
    margin: -0.5em -0.5em 0;
    padding: 0.5em;
}

details[open] {
    padding: 0.5em;
}

details[open] summary {
    border-bottom: 1px solid #aaa;
    margin-bottom: 0.5em;
}
h3 {
    color: #fff;
    
}

</style>