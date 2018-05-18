<!DOCTYPE HTML>  
<html>
    <head>
        <style>
            .error {color: #FF0000;}
        </style>
    </head>

<body>  

<?php
// define variables and set to empty values. set verified to 0 
$events_nameErr = "";
$events_emailErr = "";
$events_websiteErr = "";
$events_name = "";
$events_email = "";
$events_description = "";
$events_website = "";
$events_start_date = "";
$events_end_date = "";
$events_verified = 0;
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //check name input
    if (empty($_POST["events_name"])) {
      $events_nameErr = "Name is required";
    }
    else {
      $events_name = filter_data($_POST["events_name"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/", $events_name)) {
        $events_nameErr = "Only letters and white space allowed"; 
      }
    }
  
   //check email input
    if (empty($_POST["events_email"])) {
       $events_emailErr = "Email is required";
    } 
    else {
       $events_email = filter_data($_POST["events_email"]);
       
        // check if e-mail address is the right structure
        if (filter_var($events_email, FILTER_VALIDATE_EMAIL) == FALSE) {
            $events_emailErr = "Invalid email format"; 
        }
        // check if email length is under 65 characters
        if (strlen($events_email) > 65){
            $events_emailErr = "Email length must be under 65 characters.";
        }
    }
    
    if (empty($_POST["events_website"])) {
    $events_website = "";
    } 
    else {
    $events_website = filter_data($_POST["events_website"]);
        //FIX THIS... DOESN'T EXCEPT VALID WEBSITES IDK WHY
        //if (filter_var($events_website, FILTER_VALIDATE_URL) == FALSE) {
        //    $events_websiteErr = "Invalid URL"; 
        //}
    }
    
    if (empty($_POST["events_start_date"])) {
        $events_start_date = "";
    }
    else {
        $events_start_date = filter_data($_POST["events_start_date"]);
    }
    
    
    if (empty($_POST["events_end_date"])) {
        $events_end_date = "";
    }
    else {
        $events_end_date = filter_data($_POST["events_end_date"]);
    }
	
    
    if (empty($_POST["events_description"])) {
      $events_description = "";
    }  
    else {
        $events_description = filter_data($_POST["events_description"]);
    }
  
}

    
function filter_data($data) {
  $data = trim($data);
  $data = htmlspecialchars($data);
  $data = filter_var($data, FILTER_SANITIZE_STRING);
  return $data;
}

// function to filter date input
// start date has to be minimum current date. (need js for this?)
// start date has to be lower than end date
// consider using jquery for date instead of date type input in html?
function filter_date($date){
    
}
    
//used to access wordpress database functions, etc.
global $wpdb;

//can't dynamically call $events_table from events-plugin.php so it's hardcoded for now
//kept getting errors, wasn't working not sure why
$events_table = $wpdb->prefix . 'events';

//if there are no errors, and name and email are not empty, then store the info in the db. 
if($events_nameErr == null && $events_emailErr == null && $events_websiteErr == null){
    if(!empty($events_name && $events_email)){
	   $wpdb->insert($events_table, array(
		  'event_name' => $events_name,
		  'event_email' => $events_email,
		  'event_website' => $events_website,
		  'event_start_date' => $events_start_date,   
          'event_end_date' => $events_end_date,
		  'event_description' => $events_description,
		  'event_verified' => $events_verified )
                    );
    }
}

?>
        
            
<!-- the HTML submission form -->
<h2> Event Submission Form </h2>
    
<p> <span class="error">* required field </span> </p>
    
<form method="post" action="">  
    Name: <input type="text" name="events_name" value="">
    <span class="error">* <?php echo $events_nameErr; ?> </span>
    <br><br>
    
    E-mail: <input type="text" name="events_email" value="">
    <span class="error">* <?php echo $events_emailErr; ?> </span>
    <br> <br>
    
    Website: <input type="text" name="events_website" value="">
    <span class="error">* <?php echo $events_websiteErr; ?> </span>
    <br> <br>
    
    Start date: <input type="date" name="events_start_date" value="">
    <br> <br>
    
    End date: <input type="date" name="events_end_date" value="">
    <br> <br>
    
    Description: <textarea name="events_description" rows="5" cols="40"> </textarea>
    <br> <br>
    <input type="submit" name="submit" value="Submit">  
</form>    
    


    </body>
</html>