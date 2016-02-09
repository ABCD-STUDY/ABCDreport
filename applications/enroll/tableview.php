<?php
  session_start();

  include($_SERVER["DOCUMENT_ROOT"]."/code/php/AC.php");
  $user_name = check_logged(); /// function checks if visitor is logged.
  $admin = false;

  if ($user_name == "") {
    // user is not logged in

  } else {
    $admin = true;
    echo('<script type="text/javascript"> user_name = "'.$user_name.'"; </script>'."\n");
    echo('<script type="text/javascript"> admin = '.($admin?"true":"false").'; </script>'."\n");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ABCD Study Contacts</title>

  <!-- Bootstrap Core CSS -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="//cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css" rel="stylesheet">

</head>

<body id="page-top" class="index">
  <div class="container">

    <h1 class="page-header text-center">ABCD Study Contacts</h1>

    <!-- User administration -->
    <div>
      <div>
        <a href="#" class="btn btn-primary" onclick="logout();">Logout</a>
        <label>Logged in as: </label><label id="user_name"></label>
      </div>
      <div>
        <a href="../User/admin.php" class="btn btn-primary" id="user_admin_button">User Administration</a>
        <label>Roles: </label><label id="roles"></label>
      </div>
    </div>
    <hr>

    <!-- List of contacts -->
    <div>
      <table class="table-striped table table-condensed" id="contacts-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>ID</th>
            <th>Opted</th>
            <th>School name</th>
            <th>Preferred contact</th>
            <th>Referred by</th>
          </tr>
        </thead>
        <tbody id="contacts-list"></tbody>
      </table>
    </div>

</div>

<!-- jQuery Version 2.1.4 -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>

<!-- allow users to download tables as csv and excel -->
<script src="../../js/excellentexport.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/all.js"></script>

</body>

</html>
