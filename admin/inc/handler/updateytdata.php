<?php
defined( 'ABSPATH' ) or die();
global $wpdb;
$table_name = $wpdb->prefix . "ytube_setting";

if( ! check_ajax_referer( 'yt-edit-nonce', 'nonce_yt_data' ) ) {
	die("Error in submit");
}
else {	
	$get_yid 			= isset($_POST['get_yid']) ? sanitize_text_field( $_POST['get_yid'] ) : "" ;
	$get_chid 			= isset($_POST['get_chid']) ? sanitize_text_field( $_POST['get_chid'] ) : "" ;
	$get_apikey 	  	= isset( $_POST['get_apikey'] ) ? sanitize_text_field( $_POST['get_apikey'] ) : "";
	$get_plid 	  		= isset( $_POST['get_plid'] ) ? sanitize_text_field( $_POST['get_plid'] ) : "";
	$get_plname 	  	= isset( $_POST['get_plname'] ) ? sanitize_text_field( $_POST['get_plname'] ) : "";
	$get_rbname 	  	= isset( $_POST['get_rbname'] ) ? sanitize_text_field( $_POST['get_rbname'] ) : "";	
	$get_plstat 	  	= isset( $_POST['get_plstat'] ) ? sanitize_text_field( $_POST['get_plstat'] ) : "";
	$get_date 			= date("Y-m-d");

	$wpdb->update( 
	    $table_name, 
	    array( 
	        'channel_id' 		=> $get_chid,   
	        'yt_api_key' 		=> $get_apikey,  
	        'yt_playlist_id' 	=> $get_plid,
	        'yt_playlist_name'  => $get_plname,
	        'yt_ribbon_name' 	=> $get_rbname,
	        'yt_date' 			=> $get_date,
	        'status' 			=> $get_plstat
	    ), 
	    array( 'id' => $get_yid ), 
	    array( 
	        '%s',   
	        '%s',
	        '%s',   
	        '%s',
	        '%s',   
	        '%s',
	        '%s'
	    ), 
	    array( '%d' ) 
	);

	$send_json_array = array( "success_msg" => "1" );
	echo json_encode($send_json_array);
	die();
}