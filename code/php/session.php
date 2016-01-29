<?php

  session_start();

  include($_SERVER["DOCUMENT_ROOT"]."/code/php/AC.php");
  $user_name = check_logged(); /// function checks if visitor is logged.

  if (isset($_GET['subjid'])) {
    $_SESSION['subjid'] = $_GET['subjid'];
  }
  if (isset($_GET['session'])) {
    $_SESSION['sessionid'] = $_GET['session'];
  }
  
?>