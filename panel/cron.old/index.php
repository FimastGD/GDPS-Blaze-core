<?php
session_start();
ob_start();
chdir(dirname(__FILE__));
set_time_limit(0);
include "fixcps.php";
ob_flush();
flush();
sleep(1);
include "autoban.php";
ob_flush();
flush();
sleep(1);
include "friendsLeaderboard.php";
ob_flush();
flush();
sleep(1);
include "removeBlankLevels.php";
ob_flush();
flush();
sleep(1);
include "songsCount.php";
ob_flush();
flush();
sleep(1);
include "fixnames.php";
ob_flush();
flush();
sleep(1);
echo "CRON done";
file_put_contents("../logs/cronlastrun.txt",time());
?>
