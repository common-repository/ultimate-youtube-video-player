<?php
defined( 'ABSPATH' ) or die();
global $wpdb;
	
	$table_name = $wpdb->prefix . "ytube_themedata";

	$yt_settingid = isset($_POST['yt_settingid']) ? sanitize_text_field( $_POST['yt_settingid'] ) : "" ;

	$rowcount = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE `postid_ytube`=%d",$yt_settingid ));

	if($rowcount>0){		
		$result = $wpdb->get_row( $wpdb->prepare( "SELECT `theme_arr` FROM `$table_name` WHERE `postid_ytube`=%d",$yt_settingid ) );
		$upd_themedataget = unserialize($result->theme_arr);	
		$send_json_array = array( "take_settingid" => $yt_settingid, "yt_settingarr"=>$upd_themedataget );
	}else{
		$send_json_array = array( "take_settingid" => $yt_settingid, "yt_settingarr"=>'' );
	}
	
	echo json_encode($send_json_array);	
die();