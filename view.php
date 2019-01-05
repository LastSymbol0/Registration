<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h1>Данные успешно добавленны!</h1>

<?php
require_once 'config.php'; // подключаем скрипт
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link)); 
if (isset($_POST['username']))
{
    $query = "SELECT * FROM `users` WHERE username = '" . $_POST['username'] . "'";
    $result = mysqli_fetch_row(mysqli_query($link, $query))
        or die("Ошибка " . mysqli_error($link));
    if ($result)
    {
        $j = 0;
        echo "Your id: $result[$j]<br>";
        $j++;
        echo "Your username: $result[$j]<br>";
        $j++;
        echo "Your password: $result[$j]<br>";
        $j++;
        echo "Your date of birth: $result[$j]<br>";
        $j++;
        echo "Your registration date: $result[$j]<br>";
        $j++;
        echo "Your first name: $result[$j]<br>";
        $j++;
        echo "Your last name: $result[$j]<br>";
        $j++;
        echo "Your mission: $result[$j]<br>";
        $j++;
        echo "Your email: $result[$j]<br>";
    }
    // закрываем подключение
    mysqli_close($link);
}
?>
<form method="POST">
<p>Введите имя:<br> 
<input type="text" name="username" /></p>
<input type="submit" value="Просмотр">
</form>
</body>
</html>