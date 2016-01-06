<?php
  include 'getContacts.php';

  date_default_timezone_set('America/Los_Angeles');

  function debug_to_console( $data ) {

      if ( is_array( $data ) ) {
          $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
      } else {
          $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
      }
      echo $output;
  }

  if (isset($_POST["submit"])) {

    if (isset($_POST["opted"])) {
      $opted = $_POST["opted"];
    } else {
      echo "Error: opted was not set";
    }

    if (isset($_POST["name"])) {
      $name = $_POST["name"];
    } else {
      echo "Error: name was not set";
    }

    if (isset($_POST["email"])) {
      $email = $_POST["email"];
    } else {
      echo "Error: email was not set";
    }
    
    // If the form is opt-in, then check additional fields
    if (strcmp($opted, "opt-in") == 0) {
      if (isset($_POST["phone"])) {
        $phone = $_POST["phone"];
      } else {
        echo "Error: phone was not set";
      }
      
      if (isset($_POST["preferredContact"])) {
        $preferredContact = $_POST["preferredContact"];
      } else {
        echo "Error: preferredContact was not set";
      }

      if (isset($_POST["schoolName"])) {
        $schoolName = $_POST["schoolName"];
      } else {
        echo "Error: schoolName was not set";
      }

      if (isset($_POST["referredBy"])) {
        $referredBy = $_POST["referredBy"];
      } else {
        echo "Error: referredBy was not set";
      }
    } else {
      // the form is opt-out, so set these fields to empty
      $phone = "";
      $preferredContact = "";
      $schoolName = "";
      $referredBy = "";
    }

    if (isset($_POST["message"])) {
      $message = $_POST["message"];
    } else {
      echo "Error: message was not set";
    }

    addContact( $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message );

    if (strcmp($opted, "opt-in") == 0) {
      $result='<div class="alert alert-success">Thank you for sending us your contact information. We will be in touch!</div>';
    } else {
      $result='<div class="alert alert-success">Thank you for your response. We will remove you from our contact list.</div>';
    }
    // send an email
    /*
    if (mail ($to, $subject, $body, $from)) {
      $result='<div class="alert alert-success">Thank You! I will be in touch</div>';
    } else {
      $result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
    }
    */
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ABCD Study Interest Form">
  <meta name="author" content="ABCD Study">

  <title>ABCD Study Interest Form</title>

    <!-- Bootstrap Core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <?php echo $result; ?>

</body>
</html>
