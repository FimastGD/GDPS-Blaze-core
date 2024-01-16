<meta name="viewport" content="width=device-width, maximum-scale=0.85, user-scalable=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="../include/components/css/mains.css">

    
    <div class="form">
        
        <h1 style="text-align: center">Панель<br>управления <font color="white">GDPS</font></h1>
        <img src="res/logo.png" style="position: absolute; left: 1px; top: -2px; width: 70px;">
        
        <section id="toolbox">
            <h1><font color="white">Общая </font>информация</h1>
            <button onclick="window.location.href = 'stats.php';"><strong><font color="#ffba82"><i class="fa fa-server"></i></font> Статистика GDPS </strong></button>
        </section>
        
        <section id="toolbox">
            <h1><font color="white">Инструменты</font> аккаунтов GDPS</h1>
            <button onclick="window.location.href = 'account/activate.php';"><strong><font color="#ffba82"><i class="fa fa-key"></i></font> Активация аккаунта</strong></button>
            <button onclick="window.location.href = 'account/register.php';"><strong><font color="#ffba82"><i class="fa fa-user"></i></font> Регистрация аккаунта</strong></button>
            <button onclick="window.location.href = 'account/changeUsername.php';"><strong><font color="#ffba82"><i class="fa fa-repeat"></i></font> Смена никнейма</strong></button>
            <button onclick="window.location.href = 'account/changePassword.php';"><strong><font color="#ffba82"><i class="fa fa-repeat"></i></font> Смена пароля</strong></button>
            <button disabled onclick="window.location.href = 'account/changePasswordNoSave';"><strong><font color="#ffba82"><i class="fa fa-repeat"></i></font> Смена пароля без сохранения</strong></button>
        </section>
        <section id="toolbox">
            <h1><font color="white">Основные </font>инструменты</h1>
            <button onclick="window.location.href = 'songAdd.php';"><strong><font color="#ffba82"><i class="fa fa-music"></i></font> Добавить музыку</strong></button>
            <button onclick="window.location.href = 'songs/index.php';"><strong><font color="#ffba82"><i class="fa fa-music"></i></font> Добавить музыку из файлов</strong></button>
            <button onclick="window.location.href = 'levelToGD.php';"><strong><font color="#ffba82"><i class="fa fa-upload"></i></font> Перенести уровень в GD</strong></button>
            <button onclick="window.location.href = 'songList.php';"><strong><font color="#ffba82"><i class="fa fa-list"></i></font> Список музыки</strong></button>
        </section>
        
        <section id="toolbox">
            <h1><font color="white">Elder Moderator</font> инструменты</h1>
            <button onclick="window.location.href = 'cron/cron.php';"><strong><font color="#ffba82"><i class="fa fa-plug"></i></font> CRON</strong></button>
            <button onclick="window.location.href = 'stats/suggestList.php';"><strong><font color="#ffba82"><i class="fa fa-list-ol"></i></font> Реквесты модераторов</strong></button>
            <button onclick="window.location.href = 'stats/dailyTable.php';"><strong><font color="#ffba82"><i class="fa fa-table"></i></font> Таблица Daily</strong></button>
            <button onclick="window.location.href = 'stats/modActions.php';"><strong><font color="#ffba82"><i class="fa fa-list-ol"></i></font> Логи модераторов</strong></button>
            <button onclick="window.location.href = 'stats/noLogIn.php';"><strong><font color="#ffba82"><i class="fa fa-list-ol"></i></font> Неактивные аккаунты</strong></button>
            <button onclick="window.location.href = 'stats/reportList.php';"><strong><font color="#ffba82"><i class="fa fa-list-ol"></i></font> Репорт уровней</strong></button>
            <button onclick="window.location.href = 'levelReupload.php';"><strong><font color="#ffba82"><i class="fa fa-download"></i></font> Перенос уровней на GDPS</strong></button>
        </section>
        
        <section id="toolbox">
            <h1><font color="white">Админ </font>инструменты</h1>
            <button onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-plus"></i></font> Создать мап-пак</strong></button>
            <button onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-plus"></i></font> Создать гаунтлет</strong></button>
            <button onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-plus"></i></font> Добавить квест</strong></button>
            <button onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-ban"></i></font> Бан</strong></button>
            <button onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-ban"></i></font> Разбан</strong></button>
            <button onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-list-ul"></i></font> Роли на GDPS</strong></button>
            <button disabled onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-plus-circle"></i></font> Выдать роль на GDPS</strong></button>
            <button disabled onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-plus-circle"></i></font> Выдать роль в панели</strong></button>
            <button disabled onclick="window.location.href = '';"><strong><font color="#ffba82"><i class="fa fa-clock-o"></i></font> Настройка сундуков</strong></button>
            
            
            
            
        </section>
    </div>
    
    
    
    
    
    
    
    
