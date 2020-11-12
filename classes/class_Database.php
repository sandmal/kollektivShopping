<?php

// superclass definition : Database
// contains Database related methods.

class Database
{
  protected function connecty()
  {
    $host = 'localhost';
    $username = 'root';
    $password = 'root';
    $database = 'kollektivet';

    $connection = mysqli_connect($host, $username, $password, $database);

    if (!$connection) {
      die("Database connection failed");
    }
    return $connection;
  }

  protected function disconnect($connection)
  {
    mysqli_close($connection);
  }

  protected function readFromTable($tableName)
  {
    $connection = $this->connect();
    // Query the database

    $query = "SELECT * FROM $tableName";

    $result = mysqli_query($connection, $query);

    // Printing error message in case of query failure
    if (!$result) {
      die('Query failed!' . mysqli_error($connection));
    }
    //read 1 row at a time
    $idx = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $resArray[$idx] = $row;
      $idx++;
    }

    $this->disconnect($connection);
    return $resArray;
  }

  protected function cleanVar($var, $connection)
  {
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    $var = mysqli_real_escape_string($connection, $var);
    return $var;
  }
}
