<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location:../login/index.php');
                    ob_end_flush();
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
        <h1>Репорты уровней</h1>
        <button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
        </section>
        </div>
        <br>
        <br>
<table class="table" border="1"><tr><th>ID уровня</th><th>Название уровня</th><th>Репорт получен</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$array = array();
$query = $db->prepare("SELECT levels.levelID, levels.levelName, count(*) AS reportsCount FROM reports INNER JOIN levels ON reports.levelID = levels.levelID GROUP BY levels.levelID ORDER BY reportsCount DESC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$report){
	$levelName = htmlspecialchars($report['levelName'], ENT_QUOTES);
	echo "<tr><td>${report['levelID']}</td><td>$levelName</td><td>${report['reportsCount']} times</td></tr>";
}
?>
</table>