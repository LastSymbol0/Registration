<?php
include 'User.php';
include 'DataBase.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $db = new DataBase();
    $link = $db->connectToDB();
    $user = new User();
    if ($id = $user->getUserID($link, $_POST['username'], $_POST['password'])) {
        //устанавливаем в куки id на один день
        setcookie('id', $id, time() + (86400 * 1));
        header('Location: ./view.php');
    }
    else {
    echo '<h3 class="alert">Пароль и логин не совпадают, попробуйте ещё раз.</h3>';
    }
}
?>
<html>
<head>
    <link href="styles.css" rel="stylesheet">
    <meta charset="utf-8">
</head>
<body>
    <div class="fixed">
    <h1>Вход</h1>
    <form method="POST">
        <p>
            <input type="text" name="username" placeholder="Логин"/>
        </p>
        <p>
            <input type="text" name="password" placeholder="Пароль"/>
        </p>
        <input class="button" type="submit" value="Вход">
    </form>
    </div>
</body>
</html>