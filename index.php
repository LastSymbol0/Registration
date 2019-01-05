<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
    if (isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['passwordVerif']) && isset($_POST['firstName']) &&
        isset($_POST['lastName']) && isset($_POST['DoB']) &&
        isset($_POST['mission']) && isset($_POST['email'])) {

        //проверка корректности ввода
        if (strlen($_POST['password']) < 6) {
            echo "Минимальная длинна пароля - 6 символов";
        }
        if ($_POST['password'] != $_POST['passwordVerif']) {
            echo "Введённые пароли не совпадают!";
        }
        if (!strstr($_POST['email'], "@")) {
            echo "Email должен содержать символ '@'";
        }


        // подключаем скрипт
        require_once 'config.php';
        // подключаем бд
        $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));


        // экранирования символов для mysql
        $username = htmlentities(mysqli_real_escape_string($link, $_POST['username']));
        $password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));
        $firstName = htmlentities(mysqli_real_escape_string($link, $_POST['firstName']));
        $lastName = htmlentities(mysqli_real_escape_string($link, $_POST['lastName']));
        $mission = htmlentities(mysqli_real_escape_string($link, $_POST['mission']));
        $email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
        $DoB = htmlentities(mysqli_real_escape_string($link, $_POST['DoB']));
        // создание строки запроса
        $query = "INSERT INTO `users` ('id', 'username', 'password', 'firstName',
                                    'lastName', 'mission', 'email', 'DoB') VALUES
                                    (NULL, '$username', '$password', '$firstName',
                                    '$lastName', '$mission', '$email', '$DoB')";    
        // выполняем запрос
        $result = mysqli_query($link, $query)
            or die("Ошибка " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);
        // в случае успешного запроса - редирект
        //header("Location: http://registration528123.000webhostapp.com/view.php");
        echo "<script language='javascript'>
        document.location.href = './view.php';
        </script>";
        exit;
    }
    else {
        echo "Заполните все поля!";
    }
?>
    <h2>Добавить нового пользователя</h2>
    <form method="POST">
        <p>
            Логин:<br> 
            <input type="text" name="username" />
        </p>
        <p>
            Пароль:<br> 
            <input type="text" name="password" />
        </p>
        <p>
            Подтвердите пароль:<br> 
            <input type="text" name="passwordVerif" />
        </p>

        <p>
            Email:<br> 
            <input type="text" name="email" />
        </p>
        <p>
            Имя:<br> 
            <input type="text" name="firstName" />
        </p>
        <p>
            Фамилия:<br> 
            <input type="text" name="lastName" />
        </p>
        <p>
            Дата рождения (в формате ГГГГ-ММ-ДД):<br> 
            <input type="text" name="DoB" />
        </p>
        <p>
            Цель регистрации:<br> 
            <input type="text" name="mission" />
        </p>
        <input type="submit" value="Добавить">
    </form>
</body>
</html>