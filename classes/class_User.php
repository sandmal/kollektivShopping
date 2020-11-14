<?php

require_once 'class_Database.php';

class User extends Database
{

  //initial properties
  protected $username;
  protected $role;
  private $password;

  function __construct()
  {
    //use only for login
  }

  // create User methods

  protected function createUser($name, $surname)
  {
    echo "User : in createUser<br>";

    $this->generateUsername($name, $surname);
    $this->generateDefaultPassword($name, $surname);

    $classType = get_class($this);
    if ($classType == "Admin") {
      $this->role = 1;
    } elseif ($classType == "Roomie") {
      $this->role = 2;
    }

    echo "Username : $this->username <br>";
    echo "Role : $this->role <br>";
    echo "Password : $this->password <br>";

    $this->addUserEntryinDB();
  }

  protected function generateUsername($name, $surname)
  {
    echo "User : in generateUsername <br>";

    $str = substr($name, 0, 3); // First two letter of firstname
    $str .= substr($surname, 0, 3); // First three letters of lastname
    $string = strtolower($str); // making lowercase

    $isUsernameUnique = FALSE;
    $idx = 0;
    while ($isUsernameUnique == FALSE) {
      $username = $string; //. rand(0, 9); // appending a random digit
      //$username .= rand(0, 9); //appending a random digit

      $isUsernameUnique = $this->checkIfUsernameUnique($username);
      $idx++;

      if ($idx > 100) {
        echo "No unique username could be generated!";
        break;
      }
    }

    $this->username = $username;
  }

  protected function checkIfUsernameUnique($username)
  {
    $isUsernameUnique = TRUE;
    $usersArray = $this->readFromTable("users");

    foreach ($usersArray as $item) {
      if ($username == $item['username']) {
        $isUsernameUnique = FALSE;
        //echo "Not new user";
        break;
      }
    }
    return $isUsernameUnique;
  }

  protected function generateDefaultPassword($name, $surname)
  {
    $this->password = $name . $surname;
  }

  //Database methods
  protected function addUserEntryinDB()
  {
    $connection = $this->connect();

    //hash password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    //query the database
    $query = "INSERT INTO users (username, role, password)";
    $query .= "VALUES ('$this->username', '$this->role', '$password_hashed')";

    $result = mysqli_query($connection, $query);

    // printing error message in case of query failure
    if (!$result) {
      die('User Creating Failed!' . mysqli_error($connection));
    } else {
      echo "New User Created! <br>";
    }
    $this->disconnect($connection);
  }

  //Registration methods
  protected function updateUserPassword()
  {
    // function to update password upon registration
  }
} //end class
