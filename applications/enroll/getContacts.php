<?php
  $contacts_file = "contacts.json";

  date_default_timezone_set('America/Los_Angeles');
  session_start(); /// initialize session
  include("../../code/php/AC.php");
  $user_name = check_logged(); /// function checks if visitor is logged.
  if (!$user_name)
     return; // nothing
  /*
  if (!check_permission("can-order")) {
     echo ("{ \"message\": \"no permission to order for this user\" }");
     return; // do nothing
  }
  */

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
        echo ('Error: cannot write projects file ('.$contacts_file.')');
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
        syslog(LOG_EMERG, 'ERROR: could not write file into '.$testfn);
     }
  }

  function addContact( $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message ) {
    $d = loadContacts();
    $now = date("F_j_Y_g:i_a");
    // create a new id
    $id = md5( $email );
    // do not store PII in the database. replace PII with NA string for now
    array_push($d, array( 'date' => $now, 'id' => $id, 'opted' => $opted, 'name' => "NA", 'email' => "NA", 'phone' => "NA", 'preferredContact' => $preferredContact, 'schoolName' => $schoolName, 'referredBy' => $referredBy, 'message' => "NA" ) );
    saveContacts($d);
    return $id;
  }

  function changeContact( $id, $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message ) {
     $d = loadContacts();
     foreach ( $d as &$prot ) {
        if ($prot['id'] == $id ) {
	   // found what we are looking for, replace this entry with the updated one
     //$prot['date'] = time(); // time last changed
     $prot['date'] = date("F_j_Y_g:i_a"); // time last changed
     $prot['opted'] = $opted;
	   $prot['name'] = "NA";
	   $prot['email'] = "NA";
	   $prot['phone'] = "NA";
	   $prot['preferredContact'] = $preferredContact;
	   $prot['schoolName'] = $schoolName;
     $prot['referredBy'] = $referredBy;
     $prot['message'] = $message;
	   break;
        }
     }
     saveContacts($d);
  }
  
  function removeContact( $id ) {
     $d = loadContacts();
     $found = 0;
     foreach ($d as $key => $ds ) {
        if ( $ds['id'] == $id ) {
           unset($d[$key]);
	   $found = $found + 1;
        }
     }
     if ($found == 1) {
       saveContacts(array_values($d));
     }
     return $found;
  }

  if (isset($_GET['action']))
    $action = $_GET['action'];
  else
    $action = null;

  if (isset($_GET['id']))
    $id = $_GET['id'];
  else
    $id = null;

  if (isset($_GET['opted']))
    $opted = $_GET['opted'];
  else
    $opted = null;

  if (isset($_GET['name']))
    $name = $_GET['name'];
  else
    $name = null;

  if (isset($_GET['email']))
    $email = $_GET['email'];
  else
    $email = null;

  if (isset($_GET['phone']))
    $phone = $_GET['phone'];
  else
    $phone = null;

  if (isset($_GET['preferredContact']))
    $preferredContact = $_GET['preferredContact'];
  else
    $preferredContact = null;

  if (isset($_GET['schoolName']))
    $schoolName = $_GET['schoolName'];
  else
    $schoolName = null;

  if (isset($_GET['referredBy']))
    $referredBy = $_GET['referredBy'];
  else
    $referredBy = null;

  if (isset($_GET['message']))
    $message = $_GET['message'];
  else
    $message = null;


  if ($action == "create") {
    $id = addContact( $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message ); 
    echo ("{ \"id\": ".$id."}");
    return;
  } else if ($action == "remove") {
    $num = removeContact( $id );
    echo ("{ \"num\": ".$num."}");
    return;  
  } else if ($action == "change") {  
    changeContact( $id, $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message );
    echo ("{ \"message\": \"done\" }");
    return;  
  } else if ($action == "load") {  
    $d = loadContacts();
    echo(json_encode( $d ));
    return;
  } else {
    return;
  }
 ?>
 