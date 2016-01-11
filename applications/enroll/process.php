<?php
  date_default_timezone_set('America/Los_Angeles');

  function debug_to_console( $data ) {

      if ( is_array( $data ) ) {
          $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
      } else {
          $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
      }
      echo $output;
  }

  $contacts_file = "contacts.json";

  function loadContacts() {
     global $contacts_file;

     // parse permissions
     if (!file_exists($contacts_file)) {
        echo ('error: contacts file does not exist');
        return;
     }
     if (!is_readable($contacts_file)) {
        echo ('error: cannot read file '.$contacts_file.'...');
        return;
     }
     $d = json_decode(file_get_contents($contacts_file), true);
     if (!is_array($d)) {
        echo('error: could not parse the ref file, contained: '.$d.'\n');
     }
     return $d;
  }

  function saveContacts( $contacts ) {
    global $contacts_file;

     // parse permissions
     if (!file_exists($contacts_file)) {
        echo ('error: notes file '.$contacts_file.' does not exist');
        return;
     }
     if (!is_writable($contacts_file)) {
        echo ('error: cannot write projects file ('.$contacts_file.')');
        return;
     }

     // lets sort the contacts alphabetically first
     //sort($contacts);

     //echo ("{ \"message\": \"save these values: " . join($contacts) . "\"}");

     // be more careful here, we need to write first to a new file, make sure that this
     // works and copy the result over to the pw_file
     $testfn = $contacts_file . '_test';
     file_put_contents($testfn, json_encode($contacts, JSON_PRETTY_PRINT));
     if (filesize($testfn) > 0) {
        // seems to have worked, now rename this file to pw_file
        rename($testfn, $contacts_file);
     } else {
        syslog(LOG_EMERG, 'error: could not write file into '.$testfn);
     }
  }

  function addContact( $id, $opted, $schoolName, $preferredContact, $referredBy ) {
    $d = loadContacts();
    $now = date("F_j_Y_g:i_a");
    // do not store PII in the database. replace PII with NA string for now
    array_push($d, array( 'date' => $now, 'id' => $id, 'opted' => $opted, 'schoolName' => $schoolName, 'preferredContact' => $preferredContact, 'referredBy' => $referredBy ) );
    saveContacts($d);
    return $id;
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
      
      if (isset($_POST["schoolName"])) {
        $schoolName = $_POST["schoolName"];
      } else {
        echo "Error: schoolName was not set";
      }

      if (isset($_POST["preferredContact"])) {
        $preferredContact = $_POST["preferredContact"];
      } else {
        echo "Error: preferredContact was not set";
      }

      if (isset($_POST["referredBy"])) {
        $referredBy = $_POST["referredBy"];
      } else {
        echo "Error: referredBy was not set";
      }
    } else {
      // the form is opt-out, so set these fields to empty
      $phone = "";
      $schoolName = "";
      $preferredContact = "";
      $referredBy = "";
    }

    if (isset($_POST["message"])) {
      $message = $_POST["message"];
    } else {
      echo "Error: message was not set";
    }

    $id = md5( $email );
    addContact( $id, $opted, $schoolName, $preferredContact, $referredBy );

    if (strcmp($opted, "opt-in") == 0) {
      $result='<div class="alert alert-success">Thank you for sending us your contact information. We will be in touch!</div>';
    } else {
      $result='<div class="alert alert-success">Thank you for your response. We will remove you from our contact list.</div>';
    }

    // send an email
    $to = "alexdecastro2@gmail.com";
    $subject = "ABCD Study Contact Form";
    $body = "ID: $id\n Name: $name\n Email: $email\n Phone: $phone\n Opted: $opted\n School name: $schoolName\n Preferred contact: $preferredContact\n Referred By: $referredBy, Message:\n $message";
    debug_to_console( $body );

    $header = "From:abcd-study@ucsd.edu \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail ($to, $subject, $body, $header);

    if( $retval == true ) {
      debug_to_console("Message sent successfully...\n");
    } else {
      debug_to_console("Message could not be sent...\n");
    }
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

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <?php echo $result; ?>

</body>
</html>
