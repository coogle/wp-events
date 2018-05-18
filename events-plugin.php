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

global $events_table;

//generate table if it doesn't exist
function install_events_table(){
    global $wpdb;
	
	$events_table_version = '1.0';
    $charset_collate = $wpdb->get_charset_collate();
	
    //table name has to be hard coded for now
	$events_table = $wpdb->prefix . 'events';
            
	if($wpdb->get_var("SHOW TABLES LIKE $events_table") != $events_table){
		 $sql = "CREATE TABLE $events_table (
    event_id int(11) NOT NULL AUTO_INCREMENT,
    event_name varchar(65) NOT NULL,
	event_email varchar(65),
    event_start_date date,
    event_end_date date,
    event_website varchar(65535),
	event_description text,
    event_verified TINYINT(1),
    PRIMARY KEY  (event_id)
    ) $charset_collate;";
            
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $sql );
        
    //need code to handle the updgrade of the table.
	}
}

//calls the submission form template
function display_event_form(){
	include 'templates/events_form.php';
}

//calls the events display function
function display_events(){
    include 'templates/events_display.php';
}

//add admin page for verification
/* */

//function to truncate the table
function truncate_table(){
   global $wpdb;
    $query = "TRUNCATE TABLE $wpdb->prefix" . 'events';
    $wpdb->query($query); 
}

//function to delete the table
function delete_table(){
    global $wpdb;
    $query = "DROP TABLE $wpdb->prefix" . 'events';
    $wpdb->query($query);
}


//activation. For some reason this method of creating the table throws an error like this -> "The plugin generated 304 characters of unexpected output during activation." 
register_activation_hook(__FILE__, 'install_events_table');

//deactivation
//register_deactivation_hook(__FILE__, 'NAME_OF_A_FUNCTION');

//function for event submission form
function events_form_shortcode() {
		ob_start();
		
		//function names
		display_event_form();
		
		return ob_get_clean();
	}

//function for showing all events
function events_display_shortcode(){
	ob_start();
	
	display_events();
	
	return ob_get_clean();
}

//the shortcode for event submission form
add_shortcode( 'events_form', 'events_form_shortcode' );

//shortcode for showing all events
add_shortcode( 'events_display', 'events_display_shortcode')
?>
