<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: login/index.php');
                    exit();
} else {
    // next... 
}
$userid = $_SESSION['userd']['ID'];
if ($userid == 1 or $userid == 2) {
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.9">


<?php 
include '../include/lib/mainLib.php';
include '../config/name.php';

$gs = new mainLib();

$lvl = $gs->getCount("levels");
$usrs = $gs->getCount("users");
$com = $gs->getCount("levels");
$acc = $gs->getCount("acc");
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">

<div class="form">
    <section id="toolbox">
        <h1>Статистика GDPS</h1>
        
        </section>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

		<section id="toolbox" style="height: 45rem; width: 99%;">

			<canvas id="statistic"></canvas>
			<script>
				const ctx = document.getElementById("statistic");
				const statistic = new Chart(ctx, {
					type: 'bar',
					data: {
						
						labels: ['Аккаунты', 'Уровни', 'Комментарии'],
						datasets: [{
							label: 'Статистика',
							data: [<?php echo $acc; ?>, <?php echo $lvl; ?>, <?php echo $com; ?>, <?php echo $usrs; ?>],
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
				});
				</script>
<button onclick="window.location.href = 'index.php';"><strong>На главную</strong></button>
		</div>

	


