<?php
//file to display all the events stored inside the db
    
//to be able to use wpdb 
global $wpdb;
	
//table name... issues with making it global... it's hard coded for now
$events_table = $wpdb->prefix . 'events';
	
//grab results from the db and order them by nearest upcoming events
$results = $wpdb->get_results ( "
    SELECT event_name, event_description, event_email, event_website, DATE_FORMAT(`event_start_date`,'%b %d, %Y') as event_start_date, DATE_FORMAT(`event_end_date`, '%b %d, %Y') as event_end_date
    FROM  $events_table
	ORDER BY event_start_date ASC
" );

//print out the contents of the results and do some formatting
echo '<section>';
echo '<div>';	
foreach ( $results as $result ){
    echo '<div>';
    //echo 'ID : '. $result->event_id . '<br/>';
	
    echo '<div class=event_name_css>' . '<br/>'; //this class is made here and edited in custom css editor. It's theme dependent.
    echo 'Name : '. esc_html($result->event_name) . '<br/>';
    echo '</div>';
	
    //line breaks are getting lost in the HTML form or when they're stored in the wpdb. Need to fix this.
    echo '<p class=event_description_css>';
    echo 'Description : ' . esc_html($result->event_description) . '<br/>';
    //echo '</p>';
	
    echo 'E-mail : '. esc_html($result->event_email) . '<br/>';
    echo 'Website : ' . esc_html($result->event_website) . '<br/>';
    echo 'Start date : ' . esc_html($result->event_start_date) . '<br/>';
    echo 'End date : ' . esc_html($result->event_end_date) . '<br/>';

	
   //echo 'Verified : '. $result->event_verified . '<br/>';
   echo '</div>';
	}
echo '</div>';
echo '</section>';
?>

