<?php

$enroll_file = "enroll.json";

function loadDB() {
	global $enroll_file;

     // parse permissions
	if (!file_exists($enroll_file)) {
		echo ('error: permission file does not exist');
		return;
	}
	if (!is_readable($enroll_file)) {
		echo ('error: cannot read file...');
		return;
	}
	$d = json_decode(file_get_contents($enroll_file), true);
	if ($d == NULL) {
		echo ('error: could not parse the password file');
	}

	return $d;
}

function saveDB( $d ) {
	global $enroll_file;

     // parse permissions
	if (!file_exists($enroll_file)) {
		echo ('error: permission file does not exist');
		return;
	}
	if (!is_writable($enroll_file)) {
		echo ('Error: cannot write permissions file ('.$enroll_file.')');
		return;
	}
     // be more careful here, we need to write first to a new file, make sure that this
     // works and copy the result over to the enroll_file
	$testfn = $enroll_file . '_test';
	file_put_contents($testfn, json_encode($d));
	if (filesize($testfn) > 0) {
        // seems to have worked, now rename this file to enroll_file
		rename($testfn, $enroll_file);
	} else {
		syslog(LOG_EMERG, 'ERROR: could not write enroll file into '.$testfn);
	}
}

if (isset($_POST["submit"])) {
	$contactType = $_POST['contactType'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$preferredContact = $_POST['preferredContact'];
	$schoolName = $_POST['schoolName'];
	$schoolNotListed = $_POST['schoolNotListed'];
	$otherSchoolName = $_POST['otherSchoolName'];
	$schoolAddress = $_POST['schoolAddress'];
	$referredBy = $_POST['referredBy'];
	$otherReason = $_POST['otherReason'];
	$message = $_POST['message'];
	$human = intval($_POST['human']);
	$from = 'from@from.com'; 
	$to = 'to@to.com'; 
	$subject = 'Message from ABCD Study Interest Form';

	$body ="Contact type: $contactType\n Name: $name\n Email: $email\n Phone: $phone\n Preferred contact: $preferredContact\n School name: $schoolName\n School address: $schoolAddress\n Referred By: $referredBy, Message:\n $message";

	// Check if contact type has been entered
	if (!$_POST['contactType']) {
		$errContactType = 'Please enter your contact type';
	}

	// Check if name has been entered
	if (!$_POST['name']) {
		$errName = 'Please enter your name';
	}

	// Check if email has been entered and is valid
	if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errEmail = 'Please enter a valid email address';
	}

	// Check if phone has been entered
	if (!$_POST['phone']) {
		$errPhone = 'Please enter your phone number';
	}

	// Check if preferred contact has been entered
	if (!$_POST['preferredContact']) {
		$errPreferredContact = 'Please enter your preferred contact';
	}

	if (isset($_POST['schoolNotListed'])) {

		// Check if other school name has been entered
		if (!$_POST['otherSchoolName']) {
			$errOtherSchoolName = 'Please enter your school name';
		}
		else {
			$schoolName = $otherSchoolName;
		}

		//Check if school address has been entered
		if (!$_POST['schoolAddress']) {
			//$errSchoolAddress = 'Please enter your school address';
		}
	}

	//Check if referredBy has been entered
	if (!$_POST['referredBy']) {
		//$errReferredBy = 'Please enter how you found us';
	}
	else {
		if ($referredBy === "other") {
			if (!$_POST['otherReason']) {
				$errOtherReason = 'Please enter your how you found us';
			}
			else {
				$referredBy = $otherReason;
			}
		}
	}

	//Check if message has been entered
	if (!$_POST['message']) {
		//$errMessage = 'Please enter your message';
	}

	//Check if simple anti-bot test is correct
	if ($human !== 5) {
		$errHuman = 'Your anti-spam is incorrect';
	}

	// If there are no errors, send the email
	if (!$errContactType && !$errName && !$errEmail && !$errPhone && !$errPreferredContact && !$errOtherSchoolName && !$errHuman) {

		$d = loadDB();
		$id = md5($email);
		array_push( $d['users'], array( "id" => $id, "contactType" => $contactType, "name" => $name, "email" => $email, "phone" => $phone, "preferredContact" => $preferredContact, "schoolName" => $schoolName, "schoolAddress" => $schoolAddress, "referredBy" => $referredBy, "message" => $message ) );
		//var_dump($d, true);
		saveDB( $d );

		$result='<div class="alert alert-success">Thank You! We will be in touch</div>';

		// Send an email
		/*
		if (mail ($to, $subject, $body, $from)) {
			$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
		} else {
			$result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
		}
		*/
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="page-header text-center">Interested in the ABCD Study?</h1>
			<form role="form" method="post" action="index.php">

				<div class="form-group">
					<label for="contactType" class="control-label">What is your role? *</label><br>
					<label class="radio-inline"><input type="radio" name="contactType" value="schoolOfficial" checked>School official</label>
					<label class="radio-inline"><input type="radio" name="contactType" value="student">Student</label>
					<label class="radio-inline"><input type="radio" name="contactType" value="teacher">Teacher</label>
					<label class="radio-inline"><input type="radio" name="contactType" value="parent">Parent</label>
					<?php echo "<p class='text-danger'>$errContactType</p>";?>
				</div>

				<div class="form-group">
					<label for="name" class="control-label" id="nameLabel">First & Last Name *</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php echo htmlspecialchars($_POST['name']); ?>">
					<?php echo "<p class='text-danger'>$errName</p>";?>
				</div>

				<div class="form-group">
					<label for="email" class="control-label">Email *</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo htmlspecialchars($_POST['email']); ?>">
					<?php echo "<p class='text-danger'>$errEmail</p>";?>
				</div>

				<div class="form-group">
					<label for="phone" class="control-label">Phone *</label>
					<input type="tel" class="form-control" id="phone" name="phone" placeholder="(858) 555-1212" value="<?php echo htmlspecialchars($_POST['phone']); ?>">
					<?php echo "<p class='text-danger'>$errPhone</p>";?>
				</div>

				<div class="form-group">
					<label for="preferredContact" class="control-label">Preferred contact method *</label><br>
					<label class="radio-inline"><input type="radio" name="preferredContact" value="email" checked>Email</label>
					<label class="radio-inline"><input type="radio" name="preferredContact" value="phone">Phone</label>
					<?php echo "<p class='text-danger'>$errPreferredContact</p>";?>
				</div>

				<div class="form-group">
					<label for="schoolName" class="control-label">Select your school name *</label>
					<select class="form-control" name="schoolName" id="schoolName">
						<option selected="selected">Not listed</option>
					</select>
					<?php echo "<p class='text-danger'>$errContactType</p>";?>
				</div>

				<div class="checkbox">
					<label>
						<input id="schoolNotListed" type="checkbox" name="schoolNotListed"> My school is not in the list above. I will enter my school name and address below.
					</label>
				</div>

				<div class="form-group">
					<label for="otherSchoolName" class="control-label">School name if not listed above</label>
					<input type="otherSchoolName" class="form-control" id="otherSchoolName" name="otherSchoolName" placeholder="School name if not listed above" value="<?php echo htmlspecialchars($_POST['otherSchoolName']); ?>">
					<?php echo "<p class='text-danger'>$errOtherSchoolName</p>";?>
				</div>

				<div class="form-group">
					<label for="schoolAddress" class="control-label">School address</label>
					<textarea class="form-control" rows="4" id="schoolAddress" name="schoolAddress"><?php echo htmlspecialchars($_POST['schoolAddress']);?></textarea>
					<?php echo "<p class='text-danger'>$errSchoolAddress</p>";?>
				</div>

				<div class="form-group">
					<label for="referredBy" class="control-label">How did you hear about us? *</label>
					<div class="referredBy">
						<label class="radio-inline" name="flyer"><input type="radio" name="referredBy" value="flyer" checked>Received a flyer</label>
						<label class="radio-inline" name="email"><input type="radio" name="referredBy" value="email">Received an email</label>
						<label class="radio-inline" name="phone"><input type="radio" name="referredBy" value="phone">Received a phone call</label>
						<label class="radio-inline" name="other"><input type="radio" name="referredBy" value="other">Other reason</label>
						<?php echo "<p class='text-danger'>$errReferredBy</p>";?>
					</div>
				</div>

				<div class="form-group">
					<label for="otherReason" class="control-label">Other reason that you heard about us</label>
					<input type="otherReason" class="form-control" id="otherReason" name="otherReason" placeholder="Other reason that you heard about us" value="<?php echo htmlspecialchars($_POST['otherReason']); ?>">
					<?php echo "<p class='text-danger'>$errOtherReason</p>";?>
				</div>

				<div class="form-group">
					<label for="message" class="control-label">Additional comments</label>
					<textarea class="form-control" rows="4" name="message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
					<?php echo "<p class='text-danger'>$errMessage</p>";?>
				</div>

				<div class="form-group">
					<label for="human" class="control-label">2 + 3 = ? *</label>
					<input type="text" class="form-control" id="human" name="human" placeholder="Your Answer">
					<?php echo "<p class='text-danger'>$errHuman</p>";?>
				</div>

				<div class="form-group">
					<label for="delcare" class="control-label"></label>
					<label for="declare" class="control-label">By declaring my interest, I agree to be contacted by the ABCD Study.</label>
				</div>

				<div class="form-group">
					<input id="submit" name="submit" type="submit" value="Please contact me" class="btn btn-primary">
				</div>

				<div class="form-group">
					<?php echo $result; ?>	
				</form> 
			</div>
		</div>
	</div>   
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
	<script type="text/javascript">

	$("document").ready(function() {

       	// Disable optional text fields
       	jQuery('#otherSchoolName').attr('disabled','disabled');
       	jQuery('#schoolAddress').attr('disabled','disabled');
       	jQuery('#otherReason').attr('disabled','disabled');

		// Fill in the school names from a JSON file
		jQuery.getJSON('schools.json', function(data) {
			console.log("Fill in the school names from a JSON file");
			jQuery('#schoolName').select2( { data: data } );
		});

		// If schoolNotListed is checked, then enable the school name and address input fields
		jQuery('#schoolNotListed').click(function() {
			if(jQuery(this).prop("checked") == true) {
				jQuery('#otherSchoolName').removeAttr('disabled');
				jQuery('#schoolAddress').removeAttr('disabled');
			}
			else if(jQuery(this).prop("checked") == false) {
				jQuery('#otherSchoolName').attr('disabled','disabled');
				jQuery('#schoolAddress').attr('disabled','disabled');
			}
		});

    	// If other reasons is selected, then enable the other reasons text field
    	jQuery('.referredBy label').click(function() {
    		if (jQuery(this).attr('name') == 'other') {
    			jQuery('#otherReason').removeAttr('disabled');
    		} else {
    			jQuery('#otherReason').attr('disabled','disabled');
    		}
    	});
    });

</script>

</body>
</html>
