<?php
  //include 'getContacts.php';

  //$d = loadContacts();
  //$count = count($d);
  //echo $count . "\n";

  $to = "alexdecastro2@gmail.com";
  $subject = "New Contacts for ABCD Study";

  //$message = $count . ' new contacts have signed in since yesterday.<br>';
  //$message .= '<a href=\"/applications/User/login.php\">Click here to see the contacts.</a>';
  $message = "hello";
  echo $message . "\n";

  $header = "From:abcd-study@ucsd.edu \r\n";
  $header .= "MIME-Version: 1.0\r\n";
  $header .= "Content-type: text/html\r\n";

  $retval = mail ($to,$subject,$message,$header);

  if( $retval == true ) {
    echo "Message sent successfully...\n";
  } else {
    echo "Message could not be sent...\n";
  }
?>
