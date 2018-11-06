
<?php
   session_start();
   unset($_SESSION["admin"]);
   unset($_SESSION["log_on"]);
    unset($_SESSION["user_id"]);
   header("location: index.php");
?>
