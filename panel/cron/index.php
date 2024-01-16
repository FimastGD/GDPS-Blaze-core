<?php
session_start();
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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
    <link href="../../include/components/css/mains.css" rel="stylesheet">
    <?php // echo '<link href="../../include/components/images/tools_favicon.png" rel="shortcut icon">' ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <title>GDPS Tools [Cron]</title>
</head>
<body>
    <main id="cron">
        <p id="1">
            <a class="button" onclick="autoban()">Запустить CRON</a>
        </p>
        <p id="2"></p>
        <p id="3"></p>
        <p id="4"></p>
        <p id="5">
            <p id="6"></p>
        </main>
    </body>
</html>

    <script>
        function autoban() {
            $("#1").html("<h1>CRON логи</h1><br>Запуск автобана...");
            var old = $("#1").html();
            var a = "1";
            $.ajax({
                type: "POST",
                url: "autoban.php",
                data: {
                    a: a
                }
            }).done(function(result) {
                if (result == 1) {
                    $("#1").html(old + "<br />ЗАВЕРШЕНО<hr>");
                    fixcps();
                } else {
                    $("#1").html(result + "");
                    fixcps();
                }
            });
        }
        function fixcps() {
            $("#2").html("Выдача недостающих креатор-поинтов...");
            var old = $("#2").html();
            var a = "1";
            $.ajax({
                type: "POST",
                url: "fixcps.php",
                data: {
                    a: a
                }
            }).done(function(result) {
                if (result == 1) {
                    $("#2").html(old + "<br />ВЫДАНО<hr>");
                    fixnames();
                } else {
                    $("#2").html(result + "");
                    fixnames();
                }
            });
        }
        function fixnames() {
            $("#3").html("Исправление никнеймов...");
            var old = $("#3").html();
            var a = "1";
            $.ajax({
                type: "POST",
                url: "fixnames.php",
                data: {
                    a: a
                }
            }).done(function(result) {
                if (result == 1) {
                    $("#3").html(old + "<br />ИСПРАВЛЕНО<hr>");
                    friends();
                } else {
                    $("#3").html(result + "");
                    friends();
                }
            });
        }
        function friends() {
            $("#4").html("Исправление списка друзей...");
            var old = $("#4").html();
            var a = "1";
            $.ajax({
                type: "POST",
                url: "friendsLeaderboard.php",
                data: {
                    a: a
                }
            }).done(function(result) {
                if (result == 1) {
                    $("#4").html(old + "<br />ИСПРАВЛЕНО<hr>");
                    rbl();
                } else {
                    $("#4").html(result + "");
                    rbl();
                }
            });
        }
        function rbl() {
            $("#5").html("Очистка мусора...");
            var old = $("#5").html();
            var a = "1";
            $.ajax({
                type: "POST",
                url: "removeBlankLevels.php",
                data: {
                    a: a
                }
            }).done(function(result) {
                if (result == 1) {
                    $("#5").html(old + "<br />ОЧИЩЕНО<hr>");
                    lvls();
                } else {
                    $("#5").html(result + "");
                    lvls();
                }
            });
        }
        function lvls() {
            $("#6").html("Исправление уровней...");
            var old = $("#6").html();
            var a = "1";
            $.ajax({
                type: "POST",
                url: "fixlevels.php",
                data: {
                    a: a
                }
            }).done(function(result) {
                if (result == 1) {
                    $("#6").html(old + "<br />ИСПРАВЛЕНО<hr><font color='#24ff39'><b>CRON завершил работу с кодом: 0</b></font>");
                } else {
                    $("#6").html(result + "");
                }
            });
        }
    </script>