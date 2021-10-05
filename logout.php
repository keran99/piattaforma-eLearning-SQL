<!-- Logout with session destruction -->
<?php
  session_start();
  session_destroy();
  header("location: index.php");
?>
