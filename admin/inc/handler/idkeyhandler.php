<?php
defined( 'ABSPATH' ) or die();
global $wpdb;
$table_name = $wpdb->prefix . "ytube_setting";
$rowcount = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

if( ! wp_verify_nonce( $_POST['ytform_generate_nonce'],'ytset_form_submit' ) ) {
	die("Error in submit");
}
else {
		$chid 			= isset($_POST['chid']) ? sanitize_text_field( $_POST['chid'] ) : "" ;
		$apikey 	  	= isset( $_POST['apikey'] ) ? sanitize_text_field( $_POST['apikey'] ) : "";
		$plid 	  		= isset( $_POST['plid'] ) ? sanitize_text_field( $_POST['plid'] ) : "";
		$plname 	  	= isset( $_POST['plname'] ) ? sanitize_text_field( $_POST['plname'] ) : "";
		$rbname 	  	= isset( $_POST['rbname'] ) ? sanitize_text_field( $_POST['rbname'] ) : "";
		$pldate 	  	= isset( $_POST['pldate'] ) ? sanitize_text_field( $_POST['pldate'] ) : "";
		$plstat 	  	= isset( $_POST['plstat'] ) ? sanitize_text_field( $_POST['plstat'] ) : "";

		if($rowcount<=5) {			
			$wpdb->insert( $table_name, array( 'id' => "", 'channel_id' => $chid, 'yt_api_key' => $apikey, 'yt_playlist_id' => $plid, 'yt_playlist_name' => $plname, 'yt_ribbon_name' => $rbname, 'yt_date' => $pldate, 'status' => $plstat ), array( '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ));

			$send_json_array = array( "success_msg" => "1" );
		 	echo json_encode($send_json_array);
		}
		else {
			$send_json_array = array( "success_msg" => "0" );
		 	echo json_encode($send_json_array);
		}
	die();
}