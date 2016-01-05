<?php
  $enroll_file = "/Users/alex/Sites/ABCDreport/applications/enroll/enroll.json";

  date_default_timezone_set('America/Los_Angeles');
  session_start(); /// initialize session
  include("AC.php");
  $user_name = check_logged(); /// function checks if visitor is logged.
  if (!$user_name)
     return; // nothing
  /*
  if (!check_permission("can-order")) {
     echo ("{ \"message\": \"no permission to order for this user\" }");
     return; // do nothing
  }
  */

  function loadEnrolls() {
     global $enroll_file;

     // parse permissions
     if (!file_exists($enroll_file)) {
        echo ('error: enroll file does not exist');
        return;
     }
     if (!is_readable($enroll_file)) {
        echo ('error: cannot read file '.$enroll_file.'...');
        return;
     }
     $d = json_decode(file_get_contents($enroll_file), true);
     if (!is_array($d)) {
        echo('error: could not parse the ref file, contained: '.$d.'\n');
     }
     return $d;
  }

  function saveEnrolls( $enrolls ) {
    global $enroll_file;

     // parse permissions
     if (!file_exists($enroll_file)) {
        echo ('error: notes file '.$enroll_file.' does not exist');
        return;
     }
     if (!is_writable($enroll_file)) {
        echo ('Error: cannot write projects file ('.$enroll_file.')');
        return;
     }

     // lets sort the enrollees alphabetically first
     //sort($enrolls);

     //echo ("{ \"message\": \"save these values: " . join($enrolls) . "\"}");

     // be more careful here, we need to write first to a new file, make sure that this
     // works and copy the result over to the pw_file
     $testfn = $enroll_file . '_test';
     file_put_contents($testfn, json_encode($enrolls, JSON_PRETTY_PRINT));
     if (filesize($testfn) > 0) {
        // seems to have worked, now rename this file to pw_file
        rename($testfn, $enroll_file);
     } else {
        syslog(LOG_EMERG, 'ERROR: could not write file into '.$testfn);
     }
  }

  function findNewID( $d ) {
     for ($id = 0; $id < 1000000; $id++) {
       $found = 0;
       foreach ( $d as $d1 ) {
          if ($d1['id'] == $id) {
	     $found = 1;
          }
       }
       if ($found == 0) {
          return $id;
       }
     }
     echo ("no id found");
  }

  function addEnroll( $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message ) {
    $d = loadEnrolls();
    $now = date("F_j_Y_g:i_a");
    // create a new id
    $id = findNewID( $d );
    array_push($d, array( 'date' => $now, 'id' => $id, 'opted' => $opted, 'name' => $name, 'email' => $email, 'phone' => $phone, 'preferredContact' => $preferredContact, 'schoolName' => $schoolName, 'referredBy' => $referredBy, 'message' => $message ) );
    saveEnrolls($d);
    return $id;
  }
  function changeEnroll( $id, $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message ) {
     $d = loadEnrolls();
     foreach ( $d as &$prot ) {
        if ($prot['id'] == $id ) {
	   // found what we are looking for, replace this entry with the updated one
     //$prot['date'] = time(); // time last changed
     $prot['date'] = date("F_j_Y_g:i_a"); // time last changed
     $prot['opted'] = $opted;
	   $prot['name'] = $name;
	   $prot['email'] = $email;
	   $prot['phone'] = $phone;
	   $prot['preferredContact'] = $preferredContact;
	   $prot['schoolName'] = $schoolName;
     $prot['referredBy'] = $referredBy;
     $prot['message'] = $message;
	   break;
        }
     }
     saveEnrolls($d);
  }
  function removeEnroll( $id ) {
     $d = loadEnrolls();
     $found = 0;
     foreach ($d as $key => $ds ) {
        if ( $ds['id'] == $id ) {
           unset($d[$key]);
	   $found = $found + 1;
        }
     }
     if ($found == 1) {
       saveEnrolls(array_values($d));
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


  if ($action == "create") { // create a new id add to enrolls
    $id = addEnroll( $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message ); 
    echo ("{ \"id\": ".$id."}");
    return;
  } else if ($action == "remove") {
    $num = removeEnroll( $id );
    echo ("{ \"num\": ".$num."}");
    return;  
  } else if ($action == "change") {  
    changeEnroll( $id, $opted, $name, $email, $phone, $preferredContact, $schoolName, $referredBy, $message );
    echo ("{ \"message\": \"done\" }");
    return;  
  } else if ($action == "load") {  
    $d = loadEnrolls();
    echo(json_encode( $d ));
    return;
  } else {
    return;
  }
 ?>
 