<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

	$del_singvid_yid 	= isset($_POST['del_singvid_yid']) ? sanitize_text_field( $_POST['del_singvid_yid'] ) : "" ;

	$table_name = $wpdb->prefix . "ytube_singviddata";
	$wpdb->delete( $table_name, array( 'id' => $del_singvid_yid ), array( '%d' ) );
		
	$send_json_array = array( "success_msg_delsv" => "1");
	echo json_encode($send_json_array);	
	
die();