<?php
class DataBase
{
	private $host = 'localhost'; // адрес сервера 
	private $database = 'id8392395_usersdb'; // имя базы данных
	private $user = 'id8392395_root'; // имя пользователя
	private $password = 'azx340761'; // пароль
	
	function connectToDB()
	{
    // подключаем бд
    $link = mysqli_connect($this->host, $this->user, $this->password, $this->database)
        or die("Ошибка подключения к БД:" . mysqli_error($link));
    // возвращаем ссылку на подключение
    return $link;
	}

	function checkLoginFree($link, $username)
	{
	    $clear = mysqli_real_escape_string($link, $username);
        $query = "SELECT * FROM users WHERE username = '$clear'";
        $result = mysqli_query($link, $query)
            or die("Ошибка " . mysqli_error($link));
		// если запрос вернул хоть одну строку - логин занят
        if (mysqli_fetch_row($result) > 0) {
        	return false;
        }
        return true;
	}
}
?>
