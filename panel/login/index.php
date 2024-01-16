<?php 
session_start();

error_reporting ( E_ERROR | E_PARSE );
if (isset($_SESSION["usercookie"])) {
                    header('Location: ../index.php');
                    exit();
}


?>
<meta name="viewport" content="width=device-width, maximum-scale=0.9, user-scalable=no">
<link rel="stylesheet" href="../../include/components/css/mains.css">

<style>
    .und {
        text-decoration: underline;
        color: white;
    }
</style>
<div class="form">
    <section id="toolbox">
        <form action="getHeaders.php" method="post">
            <h1>Вход в панель управления GDPS</h1>
            Нет аккаунта? <a class="und" href="../register/index.php"><strong>Зарегистрируйся!</strong></a>
            <br>
            <br>
            <label>Имя пользователя: </label>
            <input type="text" name="username" placeholder="Имя пользователя">
            <br>
            <label>Пароль: </label>
            <input type="password" name="password" placeholder="Пароль">
            <br>
            <button><strong>Войти</strong></button>
            <hr>
            <br>
            <?php echo $_SESSION['log'];
            // unset($_SESSION['log']);
            $_SESSION['log'] = ''; ?>
        </form>
    </section>
</div>