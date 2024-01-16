<?php
// Чтение содержимого файла desc.txt и name.txt
$description = file_get_contents('desc.txt');
$name = file_get_contents('name.txt');
$win = file_get_contents('windows.txt');
$andr = file_get_contents('android.txt');
$isDefault = file_get_contents('isDefault.txt');
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../include/components/css/mains.css">
<style>
    .block {
        border: 1px solid #ff8640;
        border-radius: 5px;
        padding: 10px;
        color: #fff;
    }
    .warning {
        border: 3px solid #ffe140;
        border-radius: 10px;
        padding: 10px;
        color: #fff;
        text-decoration: bold;
        margin: 15px;
        font-weight: bold;
    }
    .success {
        border: 3px solid #07ff12;
        border-radius: 10px;
        padding: 10px;
        color: #fff;
        text-decoration: bold;
        margin: 15px;
        font-weight: bold;
    }
    .link {
        text-decoration: underline;
        font-weight: bold;
        color: orange;
    }
</style>
<div class="form">
    <section id="toolbox">
        <h1>Установка <font color="white"><?php echo $name; ?></font></h1>
        <div class="block">
            <?php echo $description; ?>
        </div>
        <br>
        <br>
        <button onclick="window.location.href = '<?php echo $win; ?>';"><strong>Windows</strong></button>
        <button onclick="window.location.href = '<?php echo $andr; ?>';"><strong>Android</strong></button>
        <br>
        <br>
        <div class="warning">
            После регистрации тебе нужно активировать аккаунт в <a class="link" href="../panel"><font color="orange">панели управления</font></a>
        </div>
        <br>
        <?php echo $isDefault; ?> 

    </section>
</div>

