<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

	$yt_settingid 	= isset($_POST['yt_settingid']) ? sanitize_text_field( $_POST['yt_settingid'] ) : "" ;
	$yt_custcss 	= isset($_POST['yt_custcss']) ? sanitize_text_field( $_POST['yt_custcss'] ) : "" ;	
	$yt_title 		= isset($_POST['yt_title']) ? sanitize_text_field( $_POST['yt_title'] ) : "" ;
	$yt_playlist_height = isset($_POST['yt_playlist_height']) ? sanitize_text_field( $_POST['yt_playlist_height'] ) : "438" ;
	$yt_video_limit = isset($_POST['yt_video_limit']) ? sanitize_text_field( $_POST['yt_video_limit'] ) : "5" ;
	$yt_subsc_btn   = isset($_POST['yt_subsc_btn']) ? sanitize_text_field( $_POST['yt_subsc_btn'] ) : "false" ;
	$yt_subsc_layout= isset($_POST['yt_subsc_layout']) ? sanitize_text_field( $_POST['yt_subsc_layout'] ) : "default" ;
	$yt_subsc_theme = isset($_POST['yt_subsc_theme']) ? sanitize_text_field( $_POST['yt_subsc_theme'] ) : "default" ;
	$yt_subsc_count = isset($_POST['yt_subsc_count']) ? sanitize_text_field( $_POST['yt_subsc_count'] ) : "default" ;
	$yt_theme 		= isset($_POST['yt_theme']) ? sanitize_text_field( $_POST['yt_theme'] ) : "yt_theme_a" ;
	
	$yt_setting_arr = array(
	    'yt_settingid'  	=> $yt_settingid,
	    'yt_custcss' 		=> $yt_custcss,
	    'yt_title'			=> $yt_title,
	    'yt_subsc_btn'		=> $yt_subsc_btn,
	    'yt_subsc_layout'   => $yt_subsc_layout,
	    'yt_subsc_theme'    => $yt_subsc_theme,
	    'yt_subsc_count'    => $yt_subsc_count,
	    'yt_playlist_height' => $yt_playlist_height,
		'yt_video_limit' => $yt_video_limit,
		'yt_theme' 			=> $yt_theme
	);

	$final_yt_setting_arr = serialize($yt_setting_arr);

	$table_name = $wpdb->prefix . "ytube_themedata";

	
	$rowcount = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE `postid_ytube`=%d",$yt_settingid) );

	if($rowcount==0){
		$wpdb->insert( $table_name, array('id' => "", 'postid_ytube' => $yt_settingid, 'theme_id' => "", 'theme_arr' => $final_yt_setting_arr, 'selected_theme' => "") );
		$send_json_array = array("key_ins"=>"1");		
	}

	if($rowcount>0){
		$wpdb->update( $table_name, array( 'theme_arr' => $final_yt_setting_arr ), array( 'postid_ytube' => $yt_settingid), array( '%s' ), array( '%d' ) );
		$send_json_array = array("key_ins"=>"2");		
	}

	echo json_encode($send_json_array);
die();