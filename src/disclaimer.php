<?php
   session_start();
   ob_start();
   // check that session has correct role, if not jump to login screen
   if ($_SESSION['role'] != 'student') {
     header('HTTP/1.0 403 Forbidden');
     echo 'You are forbidden!';
     session_unset();
     session_destroy();
     header("Location: index.php");
     exit();
   }
?>

<html lang = "en">
   <head>
      <title>Entrance Test</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      <link href = "css/styles.css" rel = "stylesheet">
   </head>
<body>
  <div class = "container">
    <center>
      <p>Your test will start on next page.</p>
      <p>You have 1 hour time to complete it - Good Luck!</p>
      <a href="do_quizz.php" target="_"><input type="button" class = "btn btn-lg btn-primary" value="START"/></a><p><p><a href="logout.php" target="_"><input type="button" class = "btn btn-lg btn-primary" value="LOGOUT"/></a>
    </center>
  </div>
 </body>
</html>
