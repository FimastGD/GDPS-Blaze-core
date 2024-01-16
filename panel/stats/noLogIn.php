<?php
session_start();
ob_start();
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
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">


<div class="form">
    <section id="toolbox">
<h1>Неактивные аккаунты</h1>
<button onclick="window.location.href = '../index.php';"><strong>На главную</strong></button>
</section>
</div>
<br>
<br>

<table class="table" border="1"><tr><th>#</th><th>ID</th><th>Никнейм</th><th>Дата регистрации</th><th> </th></tr>
<?php
set_time_limit(0);
ob_flush();
flush();
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT accountID, userName, registerDate FROM accounts");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$account){
	$query = $db->prepare("SELECT count(*) FROM users WHERE extID = :accountID");
	$query->execute([':accountID' => $account["accountID"]]);
	if($query->fetchColumn() == 0){
		$register = date("d/m/Y G:i:s", $account["registerDate"]);
		echo "<tr><td>$x</td><td>".$account["accountID"] . "</td><td>" . $account["userName"] . "</td><td>$register</td>";
		ob_flush();
		flush();
		$time = time() - 2592000;
		if($account["registerDate"] < $time){
			echo "<td>1</td>";
		}
		echo "</tr>";
		$x++;
	}
}
?>
</table>