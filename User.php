<?php
class User
{
    public $id;
    public $username;
    public $password;
    public $dob;
    public $registrDate;
    public $firstName;
    public $lastName;
    public $mission;
    public $email;


    function setUser($link, $Username, $Password, $PasswordVerif,
                        $FirstName, $LastName, $Mission, $Email, $DoB) {
        // экранирование символов для mysql и html
        $this->username = htmlentities(mysqli_real_escape_string($link, $Username));
        $this->password = htmlentities(mysqli_real_escape_string($link, $Password));
        $this->firstName = htmlentities(mysqli_real_escape_string($link, $FirstName));
        $this->lastName = htmlentities(mysqli_real_escape_string($link, $LastName));
        $this->mission = htmlentities(mysqli_real_escape_string($link, $Mission));
        $this->email = htmlentities(mysqli_real_escape_string($link, $Email));
        $this->dob = htmlentities(mysqli_real_escape_string($link, $DoB));
    }

    public function setUserToDB($link) {
        // создание строки запроса
        $query = "INSERT INTO `users` (`id`, `username`, `password`, `firstName`,
                                `lastName`, `mission`, `email`, `DoB`) VALUES
                                (NULL, '$this->username', '$this->password', '$this->firstName',
                                '$this->lastName', '$this->mission', '$this->email', '$this->dob')";
        // выполняем запрос
        $result = mysqli_query($link, $query)
            or die("Ошибка запроса: " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);
        return true;
    }

    public function getUserID($link, $username, $password)
    {
        $query = 'SELECT * FROM users';
        $result = mysqli_query($link, $query)
            or die("Ошибка " . mysqli_error($link));
        $rows = mysqli_num_rows($result);   // количество полученных строк
        for ($i = 0 ; $i < $rows ; ++$i)    // поочерёдно достаём каждую строку и проверяем на совпадение
        {
            $row = mysqli_fetch_row($result);
            if ($row[1] == $username && $row[2] == $password) {
                mysqli_close($link);
                return $row[0]; //id
            }
        }
        // если все строки перебрали, а совпадений не было
        return false;
    }

    public function setUserFromDB($link, $id)
    {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($link, $query)
            or die("Ошибка " . mysqli_error($link));
        $row = mysqli_fetch_row($result);
        $this->id = $row[0];
        $this->username = $row[1];
        $this->password = $row[2];
        $this->dob = $row[3];
        $this->registrDate = $row[4];
        $this->firstName = $row[5];
        $this->lastName = $row[6];
        $this->mission = $row[7];
        $this->email = $row[8];
        return true;
    }
}
?>