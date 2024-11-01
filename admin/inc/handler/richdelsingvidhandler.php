<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

	$del_rich_singvid_yid 	= isset($_POST['rich_video_id']) ? sanitize_text_field( $_POST['rich_video_id'] ) : "" ;

	$table_name = $wpdb->prefix . "ytube_richpldata";
	$wpdb->delete( $table_name, array( 'id' => $del_rich_singvid_yid ), array( '%d' ) );
		
	$send_json_array = array( "success_msg_delrsv" => "1");
	echo json_encode($send_json_array);	
	
die();