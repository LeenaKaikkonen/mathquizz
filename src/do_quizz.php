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

<?php include "database.php"; ?>



<!DOCTYPE html>
<html lang = "en">
<head>
<title>Math Test</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<link rel="stylesheet" href="css/styles.css">
 
 
 
</head>

<body>




<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
	<li class="nav-item">

        <a class="nav-link" href="https://www.laurea.fi/" target=”_blank”>Linkki Laurean Sivuille <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.laurea.fi/en/" target=”_blank” >Linkki Laurean englanninkielisille sivuille</a>
      </li>

           <li class="nav-item">
        <a class="nav-link" href="https://www.laurea.fi/en/contact-information/" target=”_blank” >Laurean yhteystiedot</a>
      </li>
    </ul>

  </div>
</nav>

<br/> 


<div class="jumbotron text-center">
  <h1 >Math Test</h1>
  <p>Welcome, you have 60 minutes time to complete the test</p>
</div>


  <div class = "sisalto">
    <p id="timeLeft"> The test ends in <span id="countdowntimer">60:00</span> Seconds</p>
    <?php

      if (!empty($_POST['count'])) {
        echo "<script type='text/javascript'>document.getElementById('timeLeft').style.display = 'none';</script>";
        echo "<p>Quizz Done {$_SESSION['firstname']}!</p>";

        $user = $_SESSION['username'];
        $correct_sum = 0;
        $total_sum = 0;

        foreach ($_POST as $key => $value){
          // process only variables that contain answers
          if (strpos($key, 'answer') === 0) {

            // extract questionId part
            $questionId = substr($key, 6);

            // fetch question details so we can store those with the answer
            $sql="SELECT id, question, answer, unit, category FROM questions WHERE id='$questionId'";
            $retval=mysqli_query($conn, $sql);
            if (!$retval) {
              printf("Error: %s\n", mysqli_error($conn));
              exit();
            }

            $row = mysqli_fetch_row($retval);
            $correct_answer = $row[2];
            if ($correct_answer == $value) $correct_sum++;
            $total_sum++;

            // Do insert of user entered text using variable binding to prevent SQL injection attack
            // Also store original question as those may change and we need to have exact copy of them in the moment when test was done
            $stmt = mysqli_prepare($conn, "INSERT INTO answers(test_id, question_id, answer, correct_answer, question, unit, category) VALUES ((SELECT id FROM student_test WHERE username = ?), ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                echo "Error: " . $stmt . "<br>" . mysqli_error($conn);
            }

            mysqli_stmt_bind_param($stmt, 'sisssss', $user, $questionId, $value, $correct_answer, $row[1], $row[3], $row[4]);

            if (!mysqli_stmt_execute($stmt)) {
                echo "Error: " . $stmt . "<br>" . mysqli_error($conn);
            }
          }
        }

        // test is passed if student has correct answer in more than 80% of the questions
        if ($correct_sum / $total_sum * 100 > 80) {
          $pass = 1;
        } else {
          $pass = 0;
        }

        $sql = "UPDATE student_test SET questions_total = $total_sum, questions_correct = $correct_sum, end_time = now(), pass = $pass WHERE username = '$user'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        echo "<center><br>Thank you and see you later!</center>";




        
      } else {
        $user = $_SESSION['username'];
        $sql = "SELECT start_time, end_time FROM student_test WHERE username = '$user'";
        $retval=mysqli_query($conn, $sql);
        if(! $retval ) {
           die('Could not get data: ' . mysqli_error());
        }
        $rows = mysqli_num_rows($retval);
        // check that student can do the test only once
        if ($rows != 0) {
          $row = mysqli_fetch_row($retval);
          $test_time = $row[0];
          echo "<script type='text/javascript'>document.getElementById('timeLeft').style.display = 'none';</script>";
          if ($row[1])
            echo "<h2>Sorry - You have done test already {$test_time}, {$_SESSION['firstname']}!</h2>";
          else
            echo "<h2>Sorry - You have started (but not completed) test already {$test_time}, {$_SESSION['firstname']}!</h2>";

          echo "<center><a href='logout.php' target='_'><input type='button' value='LOGOUT'/></a></center>";
          exit();
        }
        echo "<p>You can now start the Quizz {$_SESSION['role']} {$_SESSION['firstname']}!</p>";
        echo "<p>Pay attention to the unit given in each section</p>";
        echo "<p>Only use a dot "." as decimal separator, not a comma "," </p>";

        // add some javascipt to update timer
        echo "<script type='text/javascript'>";
        echo "var timeleft = 3600;";
        echo "var downloadTimer = setInterval(function(){";
        echo "timeleft--;";
        echo "document.getElementById('countdowntimer').textContent = (new Date(timeleft * 1000).toISOString().substr(14, 5));";
        echo "if(timeleft <= 0) {";
        echo "clearInterval(downloadTimer);";
        // Do submit automatically if time expired
        echo "document.getElementById('theForm').submit();";
        echo "}},1000);";
        echo "</script>";

        $sql = "INSERT INTO student_test(username) VALUES ('$user')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        echo "<center>";
        $action = htmlspecialchars($_SERVER['PHP_SELF']);
        echo "<form id=\"theForm\" name=\"theForm\" method=\"post\" action=\"{$action}\">";

        // add to $categories all new units as needed
        

      
        

        $sql="SELECT id, question, unit, category, subcategory FROM questions ORDER BY category, subcategory, question_number ASC";
        $retval=mysqli_query($conn, $sql);
        if (!$retval) {
          printf("Error: %s\n", mysqli_error($conn));
          exit();
        }
        echo '<div class = "ryhma">';
        $category_name = NULL;
        $subcategory_name = NULL;

        $i=1;
        while($row=mysqli_fetch_array($retval, MYSQLI_NUM)) {
     
          if ($category_name != $row[3]){
            echo "<h3> {$row[3]}</h3>";
            $category_name=$row[3];
          }
          if ($subcategory_name != $row[4]){
            echo '</div>';
            echo '<div class = "ryhma">';
            echo "<h5>{$row[4]}</h5>";
            $subcategory_name=$row[4];            
          }

          $question=$row[1];
          echo "<pre>{$i}.  {$question}: ";
          // input field name contains unique questionId
          echo "  <input type=\"text\" name=\"answer{$row[0]}\"/> {$row[2]}<br/></pre>";
          $i++;

        }
        
      echo '</div>';
       echo "<input type=\"hidden\" name=\"count\" value=\"{$i}\">";
       echo "<br><input type=\"submit\" name=\"submit\" value=\"SEND\">";
     }
     echo "</center>";

    ?>
    <p>
       <center><a href="logout.php" target="_"><input type="button" value="LOGOUT"/></a><center>

  </div>
  </div>  
</div>
    <div>
      <p><br></br>
       <center><p>Laurea tests 2021 By Leena Kaikkonen</p><center>

    </div>
 </body>
</html>
