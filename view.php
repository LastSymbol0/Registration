<?php
    include 'User.php';
    include 'DataBase.php';

    $db = new DataBase();
    $link = $db->connectToDB();
    $user = new User();
    if ($user->setUserFromDB($link, $_COOKIE['id'])) {
        echo '<div class="fixed">
            <h1>Просмотр профиля</h1>';
        echo '<h3>Привет, '. $user->username . '!</h3><br>';
        echo '<div id="view">';
        echo '<b>Id: </b>' . $user->id . '<br>';
        echo '<b>Имя: </b>' . $user->firstName . '<br>';
        echo '<b>Фамилия: </b>' . $user->lastName . '<br>';
        echo '<b>Email: </b>' . $user->email . '<br>';
        echo '<b>Цель: </b>"' . $user->mission . '"<br>';
        echo '<b>Дата рождения: </b>' . $user->dob . '<br>';
        echo '<b>Дата регистрации: </b>' . $user->registrDate . '<br>';
        echo "<br></div></div>";
    }
?>
<html>
<head>
    <link href="./styles.css" rel="stylesheet">
    <meta charset="utf-8">
</head>
<body>
</body>
</html>