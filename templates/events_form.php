<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$events_nameErr = $events_emailErr = $events_websiteErr = "";
$events_name = $events_email = $events_description = $events_website = $events_date = "";
$events_verified = 0;

	
//right now invalid name format and invalid email format still get stored in the db. Fix this.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["events_name"])) {
    $events_nameErr = "Name is required";
  } else {
    $events_name = test_input($_POST["events_name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$events_name)) {
      $events_nameErr = "Only letters and white space allowed"; 
    }
  }
  
  if (empty($_POST["events_email"])) {
    $events_emailErr = "Email is required";
  } else {
    $events_email = test_input($_POST["events_email"]);
    // check if e-mail address is well-formed
    if (!filter_var($events_email, FILTER_VALIDATE_EMAIL)) {
      $events_emailErr = "Invalid email format"; 
    }
  }
    
  if (empty($_POST["events_website"])) {
    $events_website = "";
  } else {
    $events_website = test_input($_POST["events_website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    /* //probably not needed.
     * if (!preg_match("/(?i)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/",$events_website)) {
      $events_websiteErr = "Invalid URL"; 
    } */
  }

  if (empty($_POST["events_date"])) {
    $events_date = "";
  } else {
    $events_date = test_input($_POST["events_date"]);
  }
	
  if (empty($_POST["events_description"])) {
    $events_description = "";
  }  else {
    $events_description = test_input($_POST["events_description"]);
  }
  
}

function test_input($data) {
  //$data = trim($data);
  $data = stripslashes($data);
  //$data = htmlspecialchars($data);
  return $data;
}
?>
<!-- the submission form -->
<h2>Event Submission Form</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="">  
  Name: <input type="text" name="events_name" value="">
  <span class="error">* <?php echo $events_nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="events_email" value="">
  <span class="error">* <?php echo $events_emailErr;?></span>
  <br><br>
  Website: <input type="text" name="events_website" value="">
  <span class="error"><?php echo $events_websiteErr;?></span>
  <br><br>
  Date: <input type="date" name="events_date" value="">
	<?php 
	$parts = explode('/', $_POST['events_date']);
	$events_date  = "$parts[2]$parts[0]$parts[1]";  ?>
  <br><br>
  Description: <textarea name="events_description" rows="5" cols="40"></textarea>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>
	


<?php

//used to access wordpress database functions, etc.
global $wpdb;

//can't dynamically call $events_table from events-plugin.php so it's hardcoded for now
//kept getting errors, wasn't working not sure why
$events_table = $wpdb->prefix . 'events';

//if name and email are not empty, then store the info in the db
if(!empty($events_name && $events_email)){
	$wpdb->insert($events_table, array(
		'event_name' => $events_name,
		'event_email' => $events_email,
		'event_website' => $events_website,
		'event_date' => $events_date,
		'event_description' => $events_description,
		'event_verified' => $events_verified)
				 );
}
	
?>


</body>
</html>