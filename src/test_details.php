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
      <title>Detailed Test Results</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      <link href = "css/styles.css" rel = "stylesheet">
   </head>
<body>
    <div class = "container">
    <?php
       echo "<h2>Detailed test results</h2>";

       if (isset($_GET['testId']))  {
         $testId = $_GET['testId'];
         $sql="SELECT test_id, question_id, question, answer, correct_answer, unit, category FROM answers WHERE test_id = $testId";
         $retval=mysqli_query($conn, $sql);
         if (!$retval) {
           printf("Error: %s\n", mysqli_error($conn));
           exit();
         }
         echo "<center><table border=\"1\">";
         echo "<tr><td>QID</td><td>Question</td><td>Answer</td><td>Correct Answer</td><td>Category</td></tr>";
         while($row=mysqli_fetch_array($retval, MYSQLI_NUM)) {
           if ($row[3] == $row[4])
             echo "<tr><td>{$row[1]}</td><td>{$row[2]}</td><td>{$row[3]}{$row[5]}</td><td>{$row[4]}{$row[5]}</td><td>{$row[6]}</td></tr>";
           else {
             echo "<tr><td>{$row[1]}</td><td>{$row[2]}</td><td style='background-color:#FF0000'>{$row[3]}{$row[5]}</td><td>{$row[4]}{$row[5]}</td><td>{$row[6]}</td></tr>";
           }
         }
         echo "</table></center>";

      }

    ?>
    <p>
    <center><a href="review_quizz.php" target="_"><input type="button" value="BACK"/></a> <a href="logout.php" target="_"><input type="button" value="LOGOUT"/></a></center>
    </div>
 </body>
</html>
