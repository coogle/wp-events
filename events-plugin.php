<?php

/*
Plugin Name: Event Calendar
Plugin URI: 
Description: A plugin that lets users submit events and admins verify them
Version: 1.0
Author: Dimas Moosa
Author URI: 
*/

if(!defined('ABSPATH')){
	die;
}

//generate table if it doesn't exist
function install_events_table(){
    global $wpdb;
	
	$events_table_version = '1.0';
    $charset_collate = $wpdb->get_charset_collate();
	
	global $events_table;
	$events_table = $wpdb->prefix . 'events';
            
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
		 $sql = "CREATE TABLE $events_table (
    event_id int(11) NOT NULL AUTO_INCREMENT,
    event_name varchar(65) NOT NULL,
	event_email varchar(65),
    event_date date,
    event_website varchar(65),
	event_description text,
    event_verified TINYINT(1),
    PRIMARY KEY  (event_id)
    ) $charset_collate;";
            
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $sql );
	add_option( 'events_table_version', $events_table_version );
		
	}
   
	
}
	
function display_event_form(){
	include 'templates/admin.php';
}

/*
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
*/

//activation
//register_activation_hook(__FILE__, 'install_events_table');


//deactivation
//register_deactivation_hook(__FILE__, 'NAME_OF_A_FUNCTION');

//shortcode for event submission form
function events_form_shortcode() {
		ob_start();
		
		//function names
		display_event_form();
		install_events_table();
		
		return ob_get_clean();
	}

//add admin page for verification


add_shortcode( 'events_form', 'events_form_shortcode' );

//shortcode for showing all events
function events_display_shortcode(){
	ob_start();
	
	display_events();
	
	return ob_get_clean();
	
}

add_shortcode( 'events_display', 'events_display_shortcode')

?>
