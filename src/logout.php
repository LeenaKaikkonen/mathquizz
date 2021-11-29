<?php
   ob_start();
   session_start();
   session_unset();
   session_destroy();

   echo 'You have cleaned session';
   header("Location: index.php");
   ob_end_flush();
   exit();
?>
