<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

	$yid 		= isset($_POST['yid']) ? sanitize_text_field( $_POST['yid'] ) : "" ;
	$table_name = $wpdb->prefix . "ytube_setting";	
	$result 	= $wpdb->get_results( $wpdb->prepare( "SELECT `id`,`channel_id`,`yt_api_key`,`yt_playlist_id`,`yt_playlist_name`,`yt_ribbon_name`,`status` FROM `$table_name` WHERE `id`=%d",$yid ), OBJECT );	
	
	/* Convert stdclass to array */
	$array_data = json_decode(json_encode($result), true);

	$get_yid 		=  $array_data[0]['id'];
	$get_chid 		=  $array_data[0]['channel_id'];
	$get_apikey 	=  $array_data[0]['yt_api_key'];
	$get_plid 		=  $array_data[0]['yt_playlist_id'];
	$get_plname 	=  $array_data[0]['yt_playlist_name'];
	$get_rbname 	=  $array_data[0]['yt_ribbon_name'];
	$get_plstat 	=  $array_data[0]['status'];

	$send_json_array = array( "take_yid" => $get_yid , "take_chid" => $get_chid , "take_apikey" => $get_apikey , "take_plid" => $get_plid , "take_plname" => $get_plname , "take_rbname" => $get_rbname, "take_plstat" => $get_plstat );
	echo json_encode($send_json_array);	
die();