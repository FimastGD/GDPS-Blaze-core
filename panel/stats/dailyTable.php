<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location:  ../login/index.php');
                    exit();
} else {
    // next... 
}
$userid = $_SESSION['checkmod'];
if ($userid == 1 or $userid == 2) {
    // start... 
} else {
    die('
    <meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
    <link href="../../include/components/css/mains.css" rel="stylesheet">
    <div class="form"><section id="toolbox">У вас нет прав на использование данного инструмента

    <br>
    <br>
    <button onclick="window.location.href = \'../index.php\';"><strong>На главную</strong></button>
    </section></div>');
}
?>
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">
<div class="form">
    <section id="toolbox">
<h1>Таблица Daily уровней</h1>
<button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
<br>
<br>
</section>
</div>
<title>GDPS Panel [Daily Table]</title>
<table class="table" border="1"><tr><th>#</th><th>ID</th><th>Название</th><th>Создатель</th><th>Время</tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT dailyfeatures.feaID, dailyfeatures.levelID, dailyfeatures.timestamp, levels.levelName, users.userName FROM dailyfeatures INNER JOIN levels ON dailyfeatures.levelID = levels.levelID INNER JOIN users ON levels.userID = users.userID  WHERE timestamp < :time ORDER BY feaID DESC");
$query->execute([':time' => time()]);
$result = $query->fetchAll();
foreach($result as &$daily){
	//basic daily info
	$feaID = $daily["feaID"];
	$levelID = $daily["levelID"];
	$time = $daily["timestamp"];
	$levelName = $daily["levelName"];
	$creator = $daily["userName"];
	echo "<tr><td>$feaID</td><td>$levelID</td>";
	//level name
	/*$query = $db->prepare("SELECT levelName, userID FROM levels WHERE levelID = :level");
	$query->execute([':level' => $levelID]);
	$level = $query->fetch();
	$levelName = $level["levelName"];
	$userID = $level["userID"];*/
	echo "<td>$levelName</td>";
	//creator name
	/*$query = $db->prepare("SELECT userName FROM users WHERE userID = :userID");
	$query->execute([':userID' => $userID]);
	$creator = $query->fetchColumn();*/
	echo "<td>$creator</td>";
	//timestamp
	$time = date("d/m/Y H:i", $time);
	echo "<td>$time</td></tr>";
}
?>
</table>