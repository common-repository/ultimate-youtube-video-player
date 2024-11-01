<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

	$sv_plid 		= isset($_POST['sv_plid']) ? sanitize_text_field( $_POST['sv_plid'] ) : "" ;

	$table_name = $wpdb->prefix . "ytube_setting";	
	$array_data = $wpdb->get_row( $wpdb->prepare( "SELECT `yt_api_key` FROM `$table_name` WHERE `yt_playlist_id`=%s",$sv_plid ));

	$get_apikey   =  $array_data->yt_api_key;

	$api_url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$sv_plid."&key=".$get_apikey."&maxResults=50";
	$data = json_decode(file_get_contents($api_url));

	 $total_videos=0;
	 foreach ($data->items as $video) { 
        $total_videos++;
     }  

	$send_json_array = array( "success_msg" => "1", "take_yt_plid" => $sv_plid ,"take_data_video" => $data ,"take_totalvideos"=>$total_videos,"take_apikey"=>$get_apikey);
	echo json_encode($send_json_array);	
	
die();