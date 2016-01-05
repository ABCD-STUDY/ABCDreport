<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ABCD Study Interest Form">
  <meta name="author" content="ABCD Study">

  <title>ABCD Study Opt-out Form</title>

    <!-- Bootstrap Core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

</head>

<body>
  <div class="container">
    <h1 class="page-header text-center">Opt-out of the ABCD Study?</h1>
    <form role="form" method="post" action="process.php">

      <input type="hidden" name="opted" value="opt-out"/>

      <div class="form-group">
        <label for="info" class="control-label"></label>
        <label for="info" class="control-label">I would like to opt-out of the ABCD Study. Please remove me from your contact list.</label>
      </div>
      
      <div class="form-group">
        <label for="name" class="control-label">Parent's First & Last Name *</label>
        <input type="text" class="form-control" id="nameID" name="name" placeholder="Parent's First & Last Name">
      </div>

      <div class="form-group">
        <label for="email" class="control-label">Parent's Email *</label>
        <input type="email" class="form-control" id="emailID" name="email" placeholder="example@domain.com">
      </div>

      <div class="form-group">
        <label for="message" class="control-label">Additional comments</label>
        <textarea class="form-control" rows="4" name="message"></textarea>
      </div>

      <div class="form-group">
        <label for="spamCheck" class="control-label">2 + 3 = ? *</label>
        <input type="text" class="form-control" id="spamCheckID" name="spamCheck" placeholder="Your Answer">
      </div>

      <div class="form-group">
        <label for="delcare" class="control-label"></label>
        <label for="declare" class="control-label">I do not wish to be contacted by the ABCD Study.</label>
      </div>

      <div class="form-group">
        <input id="submitID" name="submit" type="submit" value="Remove me from your contact list" class="btn btn-primary">
      </div>

    </div>
  </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
  <script type="text/javascript">

    // enable the submit button only all if the form fields have valid values
    function checkEverything() {

      var field1 = (jQuery('#nameID').val() != "");
      var field2 = (jQuery('#emailID').val() != "");
      var field3 = (jQuery('#spamCheckID').val() == "5");

      // if all the fields are valid, then enable the submit button
      if (field1 && field2 && field3) {
        jQuery('#submitID').removeAttr('disabled');
      } else {
        jQuery('#submitID').attr('disabled', 0);
      }
  }

    jQuery(document).ready(function() {
      // disable the submit button
      jQuery('#submit-now').attr('disabled','disabled');
      checkEverything();

    });

    // if a form field is changed, then check everything again
    jQuery('#nameID').change(function() {
      checkEverything();
    });
    jQuery('#emailID').change(function() {
      checkEverything();
    });
    jQuery('#spamCheckID').bind('keyup change', function() {
      checkEverything();
    });

  </script>

</body>
</html>
