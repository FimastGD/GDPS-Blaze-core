<?php
session_start();
if (!isset($_SESSION["usercookie"])) {
                    header('Location: ../login/index.php');
                    exit();
} else {
    // next... 
}
error_reporting(E_ALL);
include "../../include/lib/connection.php";
require_once "../../include/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
require_once "../../incl/lib/Captcha.php";
echo '<link href="../../include/components/css/mains.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">';
$log = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!Captcha::validateCaptcha())
        exit('<div class="form"><section id="toolbox"><h2><font color="red">ОШИБКА</font></h2> Вы не прошли капчу!<br><button onclick="window.location.href = \'index.php\';"><strong>Повторить</strong></button></section></div>');
    if ($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
        if (isset($_POST['authorname'] ) && isset($_POST['songname'])) {
            if ($_FILES['filename']['size'] >= 8485760) {
                $log = "Максимальный размер файла: 8 МБ. (Вы можете сжать его, если нужно)";
            } else {
                $author_name = $_POST['authorname'];
                $song_name = $_POST['songname'];

                $songName = $author_name . "" . $song_name;
                $url = str_replace(" ", "", $songName);

                move_uploaded_file($_FILES['filename']['tmp_name'], "song/$url.mp3");

                $size = round($_FILES['filename']['size'] / 1024 / 1024, 2);
                $hash = hash_file('sha256', "song/$url.mp3");

                $song = "http://blazehst.fgdgdps.ru/db$value/panel/songs/song/";
                $cur = str_replace('upload.php', '', $song) . $url . ".mp3";

                $query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download, hash)
                VALUES (:name, '9', :author, :size, :download, :hash)");
                $query->execute([':name' => $songName, ':download' => $cur, ':author' => 'Blaze Song File', ':size' => $size, ':hash' => $hash]);
                
                $log = "Успешно! ID: <b>". $db->lastInsertId() ."</b>";
            }
        } else {
            $log = "Укажите название музыки";
        }    
    } else {
        $log = "ОШИБКА: ".$_FILES['filename']['error'];
    }
}

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
    <link href="../../include/components/css/mains.css" rel="stylesheet">
    <title>Добавить трек</title>
</head>

<body>
	<section id="toolbox">
        <h1>Добавить музыку <font color="#fff">из файлов</font></h1>
        <form class="form" method="post"  action="index.php" enctype='multipart/form-data'>
            <input type='text' style="margin-top: 5%;" placeholder="Название трека" name='songname'><br>
            <input type='text' placeholder="Author" hidden name='authorname'><br>
            <input type='file' name='filename' size='7'><br><br>
            <?php Captcha::displayCaptcha(); ?>            <br>
            <input type="submit" value="Добавить музыку">
        </form>
        <p class='log'>
            <?php echo $log ?>
        </p>
	</section>
</body>
