<?php
   session_start();
   ob_start();
?>

<?php include "database.php"; ?>

<html lang = "en">

   <head>
      <title>Entrance Test</title>
      <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<link rel="stylesheet" href="css/styles.css">
 
 
   </head>

   <body>


      <div class = "container2 form-signin">


         <?php
            $msg = '';
            $user = '';

            if (isset($_POST['login']) && !empty($_POST['username'])
               && !empty($_POST['password'])) {


               $user = $_POST['username'];
               $sql = "SELECT id,firstname,lastname,username,password,email,role FROM users WHERE username = '$user'";
               $retval = mysqli_query($conn, $sql);
               if(! $retval ) {
                  die('Could not get data: ' . mysqli_error());
               }

               $row_count = mysqli_num_rows($retval);

               if ($row_count == 1) {

                 $row = mysqli_fetch_row($retval);
                 $pass = $row[4];

                 $password_ok = password_verify($_POST['password'], $pass);
                 if ($password_ok) {

                    $_SESSION['valid'] = true;
                    $_SESSION['timeout'] = time();
                    $_SESSION['username'] = $user;
                    $_SESSION['firstname'] = $row[1];
                    $_SESSION['lastname'] = $row[2];
                    $_SESSION['role'] = $row[6];
                    echo $_SESSION['role'];
                    echo 'Welcome, you have entered valid use name and password';
                    if ($_SESSION['role'] == "student") {
                      header("Location: disclaimer.php");
                    } else {
                      header("Location: review_quizz.php");
                    }
                 } else {
                    $msg = 'Wrong username or password';
                 }

                 } else {
                  $msg = 'Wrong username or password';
               }                 
            }
         ?>
      </div>

      <div class = "container">
      <h2>Enter Username and Password</h2>
         <form class = "form-signin" role = "form"
         action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control"
               name = "username"
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" required>
            <br><center><button class = "btn btn-lg btn-primary" type = "submit"
               name = "login">LOGIN</button>
         </form>
      </div>
   </body>
</html>
