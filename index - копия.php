<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
function connectToDB($config)
{           
    require_once "$config";                                  // подключаем скрипт
    $link = mysqli_connect($host, $user, $password, $database)  // подключаем бд 
        or die("Ошибка " . mysqli_error($link));
    return $link;
}
/**
 * 
 */
class User
{
    public $username;
    public $password;
    public $firstName;
    public $lastName;
    public $mission;
    public $email;
    public $dob;
    
    function __construct($link, $Username, $Password, $FirstName, $LastName, $Mission, $Email, $DoB)
    {
        // экранирование символов для mysql и html
        $this->username = htmlentities(mysqli_real_escape_string($link, $Username));
        $this->password = htmlentities(mysqli_real_escape_string($link, $Password));
        $this->firstName = htmlentities(mysqli_real_escape_string($link, $FirstName));
        $this->lastName = htmlentities(mysqli_real_escape_string($link, $LastName));
        $this->mission = htmlentities(mysqli_real_escape_string($link, $Mission));
        $this->email = htmlentities(mysqli_real_escape_string($link, $Email));
        $this->dob = htmlentities(mysqli_real_escape_string($link, $DoB));
    }

    public function setUserToDB($link)
    {
            // создание строки запроса
        $query = "INSERT INTO `users` (`id`, `username`, `password`, `firstName`,
                                `lastName`, `mission`, `email`, `DoB`) VALUES
                                (NULL, '$this->username', '$this->password', '$this->firstName',
                                '$this->lastName', '$this->mission', '$this->email', '$this->dob')";
            // выполняем запрос
        $result = mysqli_query($link, $query)
            or die("Ошибка " . mysqli_error($link));
            // закрываем подключение
        mysqli_close($link);
        return true;
    }
}

if (isset($_POST['username']) && isset($_POST['password']) &&
    isset($_POST['passwordVerif']) && isset($_POST['firstName']) &&
    isset($_POST['lastName']) && isset($_POST['DoB']) &&
    isset($_POST['mission']) && isset($_POST['email'])) {

    //проверка корректности ввода
    if (strlen($_POST['password']) < 6) {
        //header("Refresh:0");
        echo "Минимальная длинна пароля - 6 символов";
        exit;
    }
    if ($_POST['password'] != $_POST['passwordVerif']) {
        //header("Refresh:0");
        echo "Введённые пароли не совпадают!";
        exit;
    }
    if (!strstr($_POST['email'], "@")) {
        //header("Refresh:0");
        echo "Email должен содержать символ '@'";
        exit;
    }

    //подключение к БД
    $link = connectToDB('config.php');
    
    //создание нового экземпляра класса User
    $user = new User ($link, $_POST['username'], $_POST['password'],
                    $_POST['firstName'], $_POST['lastName'],
                    $_POST['mission'], $_POST['email'], $_POST['DoB']);

    //запись юзера в БД; в случае успешного запроса - редирект
    if ($user->setUserToDB($link)) {
        echo "<script language='javascript'>
        document.location.href = './view.php';
        </script>";
        exit;
    }
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