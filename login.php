<?php // login page

if (isset($_POST['submit'])) {
  session_start();
  $_SESSION['username'] = "corsan";
  $_SESSION['name'] = "Cornelius";
  $_SESSION['surname'] = "Sandmal";
  $_SESSION['isLoggedIn'] = TRUE;
  $_SESSION['ipAdress'] = $_SERVER['REMOTE_ADDR'];
  $_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
  header('Location: profile_roomie.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Login page</h1>
  <form method="POST">
    <input type="submit" name="submit" value="Simulate login">
  </form>
</body>

</html>
