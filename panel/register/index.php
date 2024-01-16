<?php
ob_start();
require_once '../config/connect.php'; ?> 
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">

<?php
$log = "";
$connect;
if (!empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['repeat_password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeat_pass = $_POST['repeat_password'];
    if ($password === $repeat_pass) {
        // connecting... 
    } else {
        $log = 'Пароли не совпадают!';
    }
    if (empty($username) AND empty($password)) {
        $log = "Вы не заполнили все данные";
    }
    $password = md5($password);
    
    // add account to db
    mysqli_query($connect, "INSERT INTO `accpanel` (`ID`, `Username`, `Password`, `isMOD`) VALUES (NULL, '$username', '$password', '0')"); 
    header('Location: ../login/index.php');
    ob_end_flush();
    exit();
}
?>






<div class="form">
    <section id="toolbox">
        <form action="index.php" method="post">
            <h1>Регистрация в панели GDPS</h1>
            <label>Никнейм: </label>
            <input type="text" name="username" placeholder="Имя пользователя">
            <br><label>Пароль: </label>
            <input type="password" minlength="5" name="password" placeholder="Пароль">
            <br><label>Повторите пароль: </label>
            <input type="password" name="repeat_password" placeholder="Повторите пароль">
            <br>
            <input type="submit" value="Регистрация">
            <br>
            <hr>
            <?php echo "<font color='red' size='+1'>$log</font>"; ?>
        </form>
        
        
        
        
        
    </section>
</div>