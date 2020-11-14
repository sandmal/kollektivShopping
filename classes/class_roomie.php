<?php

require_once 'classes/class_User.php';
include 'functions.php';

class Roomie extends User
{

  //Initial properties
  protected $roomieID;
  protected $name;
  protected $surname;

  function __construct($roomieID, $name, $surname)
  {
    $connection = $this->connect();

    $this->roomieID = $this->cleanVar($roomieID, $connection);
    $this->name = $this->cleanVar($name, $connection);
    $this->surname = $this->cleanVar($surname, $connection);

    $this->disconnect($connection);

    $isNewRoomie = $this->checkIfNewRoomie();
    if ($isNewRoomie) {
      //echo "New Roomie!<br>";
      $this->createUser($this->name, $this->surname);
      $this->createRoomieEntry();
    } else {
      //echo "Roomie already exists <br>";
    }
  }

  protected function checkIfNewRoomie()
  {
    $isNewRoomie = TRUE;
    $roomieArray = $this->readFromTable("roomies");

    echo "<pre>";
    /*print_r($roomieArray);*/

    foreach ($roomieArray as $item) {
      if ($this->roomieID == $item['roomieid']) {
        $isNewRoomie = FALSE;
        //echo "Not new roomie! <br>";
        break;
      }
    }
    return $isNewRoomie;
  }

  protected function createRoomieEntry()
  {
    $connection = $this->connect();

    //Query the database
    $query = "INSERT INTO roomies(roomieid,username,name,surname)";
    $query .= "VALUES ('$this->roomieID', '$this->username', '$this->name', '$this->surname')";

    $result = mysqli_query($connection, $query);

    //printing error message in case of query failure
    if (!$result) {
      die('Roomie Creation Failed!' . mysqli_error($connection));
    } else {
      echo "New Roomie Created! <br>";
    }

    $this->disconnect($connection);
  }
}
