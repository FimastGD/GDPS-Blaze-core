<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: login/index.php');
                    exit();
} else {
    // next... 
} 
?>
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../include/components/css/mains.css">
<section id="toolbox">
<form action="songList.php" class="form" method="post">
	<h1>Список кастомной <font color="white">музыки</font></h1>Поиск: <input type="text" name="name" placeholder="Введите значение">
	<br>Тип поиска: <center><select class="select-css" name="type">
		<option value="1">По названию</option>
		<option value="2">По автору</option>
	</select>
	</center>
	<br>
	<input type="submit" value="Найти">
	<br><br>
	<a class="a" href="index.php"><strong>На главную</strong></a>
	</section>
</form>
<table class="table" border="1">
	<tr>
		<th>ID</th>
		<th>Название</th>
		<th>Авторr</th>
		<th>Размер</th>
	</tr>

	<?php
	include "../incl/lib/connection.php";
	require "../incl/lib/exploitPatch.php";
	if (isset($_POST['type']) == true) {
		$type = ExploitPatch::number($_POST['type']);
	} else {
		$type = 2;
	}
	switch ($type) {
		case 1:
			$searchType = "name";
			break;
		case 2:
			$searchType = "authorName";
			break;
		default:
			$searchType = "name";
			break;
	}
	if (isset($_POST['name']) == true) {
		$name = ExploitPatch::remove($_POST['name']);
	} else {
		$name = 'blaze song';
	}
	$query = $db->prepare("SELECT ID,name,authorName,size FROM songs WHERE " . $searchType . " LIKE CONCAT('%', :name, '%') ORDER BY ID DESC LIMIT 5000");
	$query->execute([':name' => $name]);
	$result = $query->fetchAll();
	foreach ($result as &$song) {
		echo "<tr><td>" . $song["ID"] . "</td><td>" . htmlspecialchars($song["name"], ENT_QUOTES) . "</td><td>" . $song['authorName'] . "</td><td>" . $song['size'] . "mb</td></tr>";
	}
	?>
</table>

<style>
.select-css { 
text-align: center;
display: block; 
font-size: 16px; 
font-family: sans-serif; 
font-weight: 700; 
color: #fe9d39; 
line-height: 1.3; 
padding: .6em 1.4em .5em .8em; width: 150px; 
max-width: 100%; 
box-sizing: border-box; 
margin: 0; 
border: 1px solid #fff;
 box-shadow: 0 1px 0 1px rgba(0,0,0,.04); 
border-radius: .5em;
 -moz-appearance: none;
 -webkit-appearance: none;
 appearance: none;
 background-color: #1b1b1b; 
background: #1b1b1b;
margin-top: 10px;
/* background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'), linear-gradient(to bottom, #ffffff 0%,#e5e5e5 100%); 
*/
background-repeat: no-repeat, repeat;
background-position: right .7em top 50%, 0 0;
background-size: .65em auto, 100%; 
} 
 .select-css::-ms-expand { display: none; } 
 .select-css:hover { border-color: #fff; } 
 .select-css:focus { border-color: #fff; 
 box-shadow: 0 0 1px 3px rgba(255,165,74,0.389);
 box-shadow: 0 0 0 3px -moz-mac-focusring; 
color: #fff;
 outline: none; 
} 
 .select-css option { font-weight:normal; } 
 *[dir="rtl"] .select-css, :root:lang(ar) .select-css, :root:lang(iw) .select-css { 
background-position: left .7em top 50%, 0 0; 
padding: .6em .8em .5em 1.4em; 
}
</style>
