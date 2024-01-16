<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: login/index.php');
                    ob_end_flush();
} else {
    // next... 
}
$userid2 = $_SESSION['checkmod'];
if ($userid2 == 1 or $userid2 == 2) {
    // start... 
} else {
    die('
    <meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
    <link href="../include/components/css/mains.css" rel="stylesheet">
    <div class="form"><section id="toolbox">У вас нет прав на использование данного инструмента

    <br>
    <br>
    <button onclick="window.location.href = \'index.php\';"><strong>На главную</strong></button>
    </section></div>');
}
?>
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../include/components/css/mains.css">
<div class="form">
    <section id="toolbox">


<html>
<head>
<title>GDPS Panel [Reupload]</title>
</head>
<body>
<?php
$newUsrID = 999999;
function chkarray($source, $default = 0){
	if($source == ""){
		$target = $default;
	}else{
		$target = $source;
	}
	return $target;
}
//error_reporting(0);
include "../incl/lib/connection.php";
require "../incl/lib/XORCipher.php";
require "../config/reuploadAcc.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
if(!empty($_POST["levelid"])){
	$levelID = $_POST["levelid"];
	$levelID = preg_replace("/[^0-9]/", '', $levelID);
	$url = $_POST["server"];
	$post = ['gameVersion' => '21', 'binaryVersion' => '33', 'gdw' => '0', 'levelID' => $levelID, 'secret' => 'Wmfd2893gb7', 'inc' => '1', 'extras' => '0'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no"){
		if($result==""){
			echo "Ошибка подключения к серверу.<br><br><button onclick=\"window.location.href = 'levelReupload.php';\"><strong>Повторить</strong></button>";
		}else if($result=="-1"){
			echo "Уровень не обнаружен. <br><br><button onclick=\"window.location.href = 'levelReupload.php';\"><strong>Повторить</strong></button>";
		}else{
			echo "RobTop тебя не любит? Или что тогда?<br><br><button onclick=\"window.location.href = 'levelReupload.php';\"><strong>Повторить</strong></button>";
		}
		echo "<br>Error code: $result";
	}else{
		$level = explode('#', $result)[0];
		$resultarray = explode(':', $level);
		$levelarray = array();
		$x = 1;
		foreach($resultarray as &$value){
			if ($x % 2 == 0) {
				$levelarray["a$arname"] = $value;
			}else{
				$arname = $value;
			}
			$x++;
		}
		//echo $result;
		if($_POST["debug"] == 1){
			echo "<br>".$result . "<br>";
			var_dump($levelarray);
		}
		if($levelarray["a4"] == ""){
			echo "Скрипт неожиданно завершил работу с кодом: <font color='white'>".htmlspecialchars($result,ENT_QUOTES."</font>");
		}
		$uploadDate = time();
		//old levelString
		$levelString = chkarray($levelarray["a4"]);
		$gameVersion = chkarray($levelarray["a13"]);
		if(substr($levelString,0,2) == 'eJ'){
			$levelString = str_replace("_","/",$levelString);
			$levelString = str_replace("-","+",$levelString);
			$levelString = gzuncompress(base64_decode($levelString));
			if($gameVersion > 18){
				$gameVersion = 18;
			}
		}
		//check if exists
		$query = $db->prepare("SELECT count(*) FROM levels WHERE originalReup = :lvl OR original = :lvl");
		$query->execute([':lvl' => $levelarray["a1"]]);
		if($query->fetchColumn() == 0){
			$parsedurl = parse_url($url);
			if($parsedurl["host"] == $_SERVER['SERVER_NAME']){
				exit("Вы пытаетесь перенести уровень со своего же сервера<br><br><button onclick=\"window.location.href = 'levelReupload.php';\"><strong>Повторить</strong></button>");
			}
			$hostname = $gs->getIP();
			//values
			$twoPlayer = chkarray($levelarray["a31"]);
			$songID = chkarray($levelarray["a35"]);
			$coins = chkarray($levelarray["a37"]);
			$reqstar = chkarray($levelarray["a39"]);
			$extraString = chkarray($levelarray["a36"], "");
			$starStars = chkarray($levelarray["a18"]);
			$isLDM = chkarray($levelarray["a40"]);
			$password = chkarray($levelarray["a27"]);
			if($password != "0"){
				$password = XORCipher::cipher(base64_decode($password),26364);
			}
			$starCoins = 0;
			$starDiff = 0;
			$starDemon = 0;
			$starAuto = 0;
			if($parsedurl["host"] == "www.boomlings.com"){
				if($starStars != 0){
					$starCoins = chkarray($levelarray["a38"]);
					$starDiff = chkarray($levelarray["a9"]);
					$starDemon = chkarray($levelarray["a17"]);
					$starAuto = chkarray($levelarray["a25"]);
				}
			}else{
				$starStars = 0;
			}
			$targetUserID = chkarray($levelarray["a6"]);
			//linkacc
			$query = $db->prepare("SELECT accountID, userID FROM links WHERE targetUserID=:target AND server=:url");
			$query->execute([':target' => $targetUserID, ':url' => $parsedurl["host"]]);
			if($query->rowCount() == 0){
				$userID = $reupUID;
				$extID = $reupAID;
			}else{
				$userInfo = $query->fetchAll()[0];
				$userID = $userInfo["userID"];
				$extID = $userInfo["accountID"];
			}
			//query
			$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, updateDate, originalReup, userID, extID, unlisted, hostname, starStars, starCoins, starDifficulty, starDemon, starAuto, isLDM)
												VALUES (:name ,:gameVersion, '27', 'Reupload', :desc, :version, :length, :audiotrack, '0', :password, :originalReup, :twoPlayer, :songID, '0', :coins, :reqstar, :extraString, :levelString, '', '', '$uploadDate', '$uploadDate', :originalReup, :userID, :extID, '0', :hostname, :starStars, :starCoins, :starDifficulty, :starDemon, :starAuto, :isLDM)");
			$query->execute([':password' => $password, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':gameVersion' => $gameVersion, ':name' => $levelarray["a2"], ':desc' => $levelarray["a3"], ':version' => $levelarray["a5"], ':length' => $levelarray["a15"], ':audiotrack' => $levelarray["a12"], ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':coins' => $coins, ':reqstar' => $reqstar, ':extraString' => $extraString, ':levelString' => "", ':originalReup' => $levelarray["a1"], ':hostname' => $hostname, ':starStars' => $starStars, ':starCoins' => $starCoins, ':starDifficulty' => $starDiff, ':userID' => $newUsrID, ':extID' => $extID, ':isLDM' => $isLDM]);
			$levelID = $db->lastInsertId();
			file_put_contents("../data/levels/$levelID",$levelString);
			echo "Уровень перенесён, ID: <font color='white'>$levelID</font><br><hr><br>";
		}else{
			echo 'Этот уровень уже был перенесён<br><button onclick="window.location.href = \'levelReupload.php\';"><strong>Повторить</strong></button>';
		}
	}
}else{
	echo '
		<form action="levelReupload.php" method="post">
		<h1>Перенос уровней на GDPS</h1>
		ID уровня в Geometry Dash: <input type="text" placeholder="ID уровня" name="levelid"><br>
		<details>
		    <summary>Дополнительные опции</summary>
		    URL сервера: <input type="text" placeholder="URL сервера" name="server" value="http://www.boomlings.com/database/downloadGJLevel22.php"><br>
			Режим отладки (0=выкл., 1=вкл.): <input type="text" placeholder="0 / 1" name="debug" value="0"><br>
		</details>
		<input type="submit" value="Перенести уровень"></form>
		';
}
?>
<br>
<br>
<button onclick="window.location.href = 'index.php';"><strong>На главную</strong></button>
</section>
</div>
</body>

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
</html>
