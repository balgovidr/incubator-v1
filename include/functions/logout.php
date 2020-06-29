<?php
  session_start();
  session_destroy();
  include '../../lib/database.php';
  header("Location:".BASE_URL);
?>
