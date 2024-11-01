<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

	$del_yid 		= isset($_POST['del_yid']) ? sanitize_text_field( $_POST['del_yid'] ) : "" ;

	$table_name = $wpdb->prefix . "ytube_setting";
	$wpdb->delete( $table_name, array( 'id' => $del_yid ), array( '%d' ) );
		
	$send_json_array = array( "success_msg_delst" => "1");
	echo json_encode($send_json_array);	
	
die();