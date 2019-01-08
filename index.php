<?php
include 'User.php';
include 'DataBase.php';

if (isset($_POST['username']) && isset($_POST['password']) &&
    isset($_POST['passwordVerif']) && isset($_POST['firstName']) &&
    isset($_POST['lastName']) && isset($_POST['DoB']) &&
    isset($_POST['mission']) && isset($_POST['email'])) {

    //подключение к БД
    $db = new DataBase();
    $link = $db->connectToDB();
        
    // проверка корректности ввода
    if ($_POST['username'] == "") {
        echo "<h3 class='alert'>Поле логина не может быть пустым</h3>";
    }
    elseif (preg_match("/\ +/", $_POST['username'])) {
        echo "<h3 class='alert'>Поле логина не может содержать пробелов</h3>";
    }
    elseif (!$db->checkLoginFree($link, $_POST['username'])) {
        echo "<h3 class='alert'>К сожалению, данный логин занят, введите другой</h3>";
    }
    elseif (strlen($_POST['password']) < 6) {
        echo "<h3 class='alert'>Минимальная длинна пароля - 6 символов</h3>";
    }
    elseif ($_POST['password'] != $_POST['passwordVerif']) {
        echo "<h3 class='alert'>Введённые пароли не совпадают!</h3>";
    }
    elseif (!preg_match("/.+\@.+/", $_POST['email'])) {
        echo "<h3 class='alert'>Некоректно введён Email</h3>";
    }
    elseif (!preg_match("/[0-9]{1,4}\-[0-9]{1,2}\-[0-9]{1,2}/", $_POST['DoB'])) {
        echo "<h3 class='alert'>Некоректно введена дата рождения</h3>";
    }
    else {
        //создание нового экземпляра класса User
        $user = new User;
        $user->setUser($link, $_POST['username'], $_POST['password'],
                        $_POST['passwordVerif'], $_POST['firstName'],
                        $_POST['lastName'], $_POST['mission'],
                        $_POST['email'], $_POST['DoB']);
        //запись юзера в БД; в случае успешного запроса - редирект
        if ($user->setUserToDB($link)) {
            echo "<script language='javascript'>
            document.location.href = './LogIn.php';
            </script>";
            exit;
        }
    }
}
?>
<html>
<head>
    <link href="./styles.css" rel="stylesheet">
    <meta charset="utf-8">
</head>
<body>
    <div class="fixed">
    <h2>Добавить нового пользователя</h2>
    <form id="form" method="POST">
        <p>
            Логин:<br> 
            <input type="text" size="30" name="username" autofocus="autofocus"/>
        </p>
        <p>
            Пароль:<br> 
            <input type="password" size="30" name="password" placeholder=" 6 - 60 символов"/>
        </p>
        <p>
            Подтвердите пароль:<br> 
            <input type="password" size="30" name="passwordVerif" />
        </p>

        <p>
            Email:<br> 
            <input type="text" size="30" name="email" placeholder="exemple@email.com"/>
        </p>
        <p>
            Имя:<br> 
            <input type="text" size="30" name="firstName" />
        </p>
        <p>
            Фамилия:<br> 
            <input type="text" size="30" name="lastName" />
        </p>
        <p>
            Дата рождения:<br> 
            <input type="text" size="30" name="DoB" placeholder="гггг-мм-дд"/>
        </p>
        <p>
            Цель регистрации:<br> 
            <input type="text" size="30" name="mission" placeholder="Просветление."/>
        </p>
        <input class="button" type="submit" value="Добавить">
    </form>
    </div>
</body>
</html>