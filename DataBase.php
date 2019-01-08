<?php
class DataBase
{
	public $host = 'localhost'; // адрес сервера 
	public $database = 'id8392395_usersdb'; // имя базы данных
	public $user = 'id8392395_root'; // имя пользователя
	public $password = 'azx340761'; // пароль
	
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
        if (mysqli_fetch_row($result) > 0) {
        	return false;
        }
        return true;
	}
}
?>