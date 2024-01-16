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

echo('<meta name="viewport" content="width=device-width, maximum-scale=0.6, user-scalable=yes">
<link rel="stylesheet" href="../../include/components/css/mains.css">');

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();

	
	

		//$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		// $query->execute([':userName' => $userName]);
		// $accountID = $query->fetchColumn();

			// $accountID = $query->fetchColumn();
			$query = $db->prepare("SELECT suggestBy,suggestLevelId,suggestDifficulty,suggestStars,suggestFeatured,suggestAuto,suggestDemon,timestamp FROM suggest ORDER BY timestamp DESC");
			$query->execute();
			$result = $query->fetchAll();
			echo '<div class="form"><section id="toolbox"><h1>Список реквестов модераторов на оценку уровней</h1><button onclick="window.location.href = \'../index.php\';"><strong>На главную</strong></button></section></div><br><br><table class="table" border="1"><tr><th>Время</th><th>Реквест отправлен</th><th>ID уровня</th><th>Запрашиваемая сложность</th><th>Звёзды</th><th>Featured (1-да/0-нет)</th></tr>';
		foreach($result as &$sugg){
			echo "<tr><td>".date("d/m/Y G:i", $sugg["timestamp"])."</td><td>".$gs->getAccountName($sugg["suggestBy"])."(".$sugg["suggestBy"].")</td><td>".htmlspecialchars($sugg["suggestLevelId"],ENT_QUOTES)."</td><td>".htmlspecialchars($gs->getDifficulty($sugg["suggestDifficulty"],$sugg["suggestAuto"],$sugg["suggestDemon"]), ENT_QUOTES)."</td><td>".htmlspecialchars($sugg["suggestStars"],ENT_QUOTES)."</td><td>".htmlspecialchars($sugg["suggestFeatured"],ENT_QUOTES)."</td></tr>";
		}
			echo "</table>";
			
		
		
		