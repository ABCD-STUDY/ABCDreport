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

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">ABCD Study Contacts</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="/index.php" title="Back to report page">Report</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#" class="connection-status" id="connection-status">Connection Status</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span id="session-active">User</span> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#" id="user_name"></a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#" onclick="logout();">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.collapse navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <!-- List of contacts -->
  <div class="container">
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
