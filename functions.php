<?php

// file handling functions

// function to read file and return headers and entries
function readThisFile($filename)
{
  //echo "In readThisFile <br>";

  $file = fopen($filename, "r") or die("Unable to open file");

  //Output one line until end-of-file
  $idx = 0;
  while (!feof($file)) {

    if ($idx == 0) {
      $headersArray = fgetcsv($file);
    } else {
      $line = fgetcsv($file);

      if (!(is_null($line[1]))) {
        $valuesArray[$idx - 1] = $line;
      }
    }

    $idx++;
  }

  fclose($file);

  return array(
    'headersArray' => $headersArray,
    'valuesArray' => $valuesArray
  );
}

function createAssocArray($headersArray, $valuesArray)
{
  // create an associative Array given headers and Values
  foreach ($valuesArray as $item => $value) {
    //print_r($item);print_r($value);echo "<br>";
    $idx = 0;
    foreach ($headersArray as $key) {
      $resArray[$item][$key] = $value[$idx];
      $idx++;
    }
  }

  return $resArray;
}

// Validate user entry. 
function validateInput($entry)
{
  // $entry takes in the whole $_GET array
  //echo "In Validate Input!<br>";
  $areFieldsEmpty = FALSE;
  $isDataOK = FALSE;

  //check if form was submitted
  if (array_key_exists('username', $entry)) {
    foreach ($entry as $key => $value) {
      $length = strlen($value);
      if ($length == 0) {
        $areFieldsEmpty = TRUE;
        break;
      }
    }

    if ($areFieldsEmpty == TRUE) {
      echo "Fields cannot be empty!<br>";
    } else {
      echo "Data is OK!<br>";
      $isDataOK = TRUE;
    }
  } else {
    echo "Array Empty!<br>";
  }

  return $isDataOK;
}

function getTime($str)
{
  $array = explode('/', $str);

  $month = $array[0];
  $date = $array[1];
  $year = $array[2];

  $unixTime = mktime(0, 0, 0, $month, $date, $year);

  return $unixTime;
}

// HTML functions

function createTable($resArray)
{

  $isFirstRow = false;
  echo "<table>";
  foreach ($resArray as $item) {
    if ($isFirstRow == FALSE) {
      // first print headers
      echo "<tr>";
      foreach ($item as $key => $value) {
        echo "<th> $key </th>";
      }
      echo "</tr>";

      //then print first row of values
      echo "<tr>";
      foreach ($item as $key => $value) {
        echo "<td> $value </td>";
      }
      echo "</tr>";

      $isFirstRow = TRUE;
    } else {
      //then print every subsequent row of values
      echo "<tr>";
      foreach ($item as $key => $value) {
        echo "<td> $value </td>";
      }
      echo "</tr>";
    }
  }
  echo "</table>";
}

/* function createForm($resArray) */
/* { */
/*   echo "<form>"; */
/*   echo "<fieldset>"; */
/*   foreach ($resArray as $item) { */
/*     echo "<legend>" . $item['Coursecode'] . " - " . $item['Coursename'] . "</legend>"; */
/*     echo "<label for='sname'>". $item['student'] */
/*   } */
/*   echo "</fieldset>"; */
/*   echo "</form>"; */
/* } */
