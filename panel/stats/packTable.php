<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: ../login/index.php');
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
<style>
    h2 {
        color: #fff;
    }
</style>
<meta name="viewport" content="width=device-width, maximum-scale=0.5, user-scalable=yes">
<link rel="stylesheet" href="../../include/components/css/mains.css">
<div class="form">
    <section id="toolbox">
<h1>Список мап-паков и гаунтлетов</h1>
<br>
<br>
<button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
<h2>МАП-ПАКИ</h2>
</section>
</div>
<table class="table" border="1"><tr><th>#</th><th>ID</th><th>Мап-пак</th><th>Звёзды</th><th>Коины</th><th>Уровни</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT * FROM mappacks ORDER BY ID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["levels"]);
	echo "<tr><td>$x</td><td>".$pack["ID"]."</td><td>".htmlspecialchars($pack["name"],ENT_QUOTES)."</td><td>".$pack["stars"]."</td><td>".$pack["coins"]."</td><td>";
	$x++;
	foreach($lvlarray as &$lvl){
		echo $lvl . " - ";
		$query = $db->prepare("SELECT levelName FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$levelName = $query->fetchColumn();
		echo $levelName . ", ";
	}
	echo "</td></tr>";
}
/*
	GAUNTLETS
*/
?>
</table>
<div class="form">
    <section id="toolbox">
<h2>ГАУНТЛЕТЫ</h2>
</section>
</div>
<table class="table" border="1"><tr><th>#</th><th>Название</th><th>Уровень 1</th><th>Уровень 2</th><th>Уровень 3</th><th>Уровень 4</th><th>Уровень 5</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT * FROM gauntlets ORDER BY ID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$gauntlet){
	$gauntletname = "Unknown";
	switch($gauntlet["ID"]){
		case 1:
			$gauntletname = "Fire";
			break;
		case 2:
			$gauntletname = "Ice";
			break;
		case 3:
			$gauntletname = "Poison";
			break;
		case 4:
			$gauntletname = "Shadow";
			break;
		case 5:
			$gauntletname = "Lava";
			break;
		case 6:
			$gauntletname = "Bonus";
			break;
		case 7:
			$gauntletname = "Chaos";
			break;
		case 8:
			$gauntletname = "Demon";
			break;
		case 9:
			$gauntletname = "Time";
			break;
		case 10:
			$gauntletname = "Crystal";
			break;
		case 11:
			$gauntletname = "Magic";
			break;
		case 12:
			$gauntletname = "Spike";
			break;
		case 13:
			$gauntletname = "Monster";
			break;
		case 14:
			$gauntletname = "Doom";
			break;
		case 15:
			$gauntletname = "Death";
			break;
		
	}
	echo "<tr><td>".$gauntlet["ID"]."</td><td>".$gauntletname."</td>";
	for ($x = 1; $x < 6; $x++) {
		echo "<td>";
		$lvl = $gauntlet["level".$x];
		echo $lvl . " - ";
		$query = $db->prepare("SELECT levelName FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$levelName = $query->fetchColumn();
		echo "$levelName</td>";
	}
	echo "</tr>";
}
/*
	GAUNTLETS
*/
?>
</table>