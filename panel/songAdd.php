<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: login/index.php');
                    exit();
} else {
    // next... 
}
//error_reporting(0);
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
require_once "../incl/lib/Captcha.php";
echo '<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../include/components/css/mains.css">
<div class="form">
<section id="toolbox">';
$gs = new mainLib();
if (!empty($_POST['songlink'])) {

    if (!Captcha::validateCaptcha())
        exit('Вы не прошли капчу!<br><button onclick="window.location.href = \'songAdd.php\';"><strong>Повторить</strong></button>');

    $result = $gs->songReupload($_POST['songlink']);
    if ($result == "-4") {
        echo 'Ссылка содержит неправильный формат аудиофайла <br> <button onclick="window.location.href = \'songAdd.php\';"><strong>Повторить</strong></button>';
    } elseif ($result == "-3")
        echo 'Музыка уже есть в БД<br><button onclick="window.location.href = \'songAdd.php\';"><strong>Повторить</strong></button>';
    elseif ($result == "-2")
        echo 'Ошибка в ссылке <br> <button onclick="window.location.href = \'songAdd.php\';"><strong>Повторить</strong></button>';
    else
        echo 'Музыка загружена. ID: <font color="#fff"><b>',
    $result,
    '</b></font><hr>';

} else {
    echo '<h1>Добавление музыки в <font color="#fff">GDPS</font></h1>
	<b>ТОЛЬКО</b> Dropbox, Discord и прямые ссылки. <font color="#ff2206">НЕ ВСТАВЛЯТЬ <b>YouTube</b> ссылки<br></font><br>
		<form action="songAdd.php" method="post">
		Ссылка: <input type="text" placeholder="Ссылка" name="songlink"><br>';
    Captcha::displayCaptcha();
    echo '<input type="submit" value="Добавить на сервер"></form>
	<br>
	Инструмент добавления музыки из файлов: <font color="#fff" style="text-decoration: underline; color: #fff;"><a href="songs/index.php">[Добавить музыку из файлов]</a></font>';
}
?>
<br>
<br>
<button onclick="window.location.href = 'index.php';"><strong>На главную</strong></button>
</section>
</div>
<style>
a {
user-select: none;
/* Убираем текстовое выделение */
text-decoration: none;
/* Убираем подчеркивание */
outline: none;
/* Убираем контур вокруг ссылки */
color: #fff;
}
</style>