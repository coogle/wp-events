function display_event_form(){
	include 'templates/admin.php';
}

//function to display all the events stored inside the db.
//later move this to another html form or something and use a function to call it and "include 'function_name.php'" like above
function display_events(){
	
	//to be able to use wpdb 
	global $wpdb;
	
	//table name... issues with making it global... it's hard coded for now
	$events_table = $wpdb->prefix . 'events';
	
	//grab results from the db and order them by nearest upcoming events
$results = $wpdb->get_results ( "
    SELECT * 
    FROM  $events_table
	ORDER BY event_date ASC
" );

//print out the contents of the results and do some formatting
echo '<section>';
echo '<div>';	
foreach ( $results as $result ){
   echo '<div>';
   //echo 'ID : '. $result->event_id . '<br/>';
	
   echo '<div class=event_name_css>' . '<br/>'; //this class is made here and edited in custom css editor. It's theme dependent.
   echo 'Name : '. $result->event_name . '<br/>';
   echo '</div>';
	
   //line breaks are getting lost in the HTML form or when they're stored in the wpdb. Need to fix this.
   echo '<p class=event_description_css>';
   echo 'Description : ' . $result->event_description . '<br/>';
   echo '</p>';
	
   echo 'E-mail : '. $result->event_email . '<br/>';
   echo 'Website : ' . $result->event_website . '<br/>';
   echo 'Date : ' . $result->event_date . '<br/>';
	
   //echo 'Verified : '. $result->event_verified . '<br/>';
   echo '</div>';
	}
echo '</div>';
echo '</section>';
	
}