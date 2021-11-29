<?php
   session_start();
   ob_start();
   // check that session has correct role, if not jump to login screen
   if ($_SESSION['role'] != 'teacher') {
     header('HTTP/1.0 403 Forbidden');
     echo 'You are forbidden!';
     session_unset();
     session_destroy();
     header("Location: index.php");
     exit();
   }
?>

<?php include "database.php"; ?>

<html lang = "en">
   <head>
      <title>Entrance Test Results</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      <link href = "css/styles.css" rel = "stylesheet">
   </head>
<body>
    <div class = "container">
    <?php
       echo "<h2>Student entrance test results</h2>";

       $sql="SELECT u.firstname, u.lastname, t.start_time, t.questions_correct, t.questions_total, t.pass, t.end_time, t.id FROM student_test t, users u WHERE t.username = u.username";
       $retval=mysqli_query($conn, $sql);
       if (!$retval) {
         printf("Error: %s\n", mysqli_error($conn));
         exit();
       }

        $riveja = mysqli_num_rows($retval);
        if ($riveja == 0) {
         echo "<center><p>No tests done yet!</p>";
        } else {
         echo "<center><table border=\"1\">";
         echo "<tr><td>First Name</td><td>Last Name</td><td>Test Time</td><td>correct/total</td><td>Pass</td></tr>";
         while($row=mysqli_fetch_array($retval, MYSQLI_NUM)) {
           if ($row[5]) $result = 'True'; else $result = 'False';
           echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td><td><a href='test_details.php?testId={$row[7]}'>{$row[3]}/{$row[4]}</a></td><td>{$result}</td></tr>";
         }
         echo "</table></center>";
       }

    ?>
    </div>
    <div class = "container">
      <p>
       <center><a href="logout.php" target="_"><input type="button" value="LOGOUT"/></a><center>
    </div>
 </body>
</html>
