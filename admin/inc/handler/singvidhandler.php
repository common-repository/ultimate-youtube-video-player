<?php
defined( 'ABSPATH' ) or die();
global $wpdb;
$sv_table_name = $wpdb->prefix . "ytube_singviddata";
$table_name = $wpdb->prefix . "ytube_setting";

if( ! wp_verify_nonce( $_POST['ytsvform_generate_nonce'],'ytsv_form_submit' ) ) {
	die("Error in submit");
}
else {

		

		if( $_POST['sv_plid'] == "vimeo"){
			$sv_plvidid 	= isset( $_POST['sv_plid_vimeo'] ) ? sanitize_text_field( $_POST['sv_plid_vimeo'] ) : "";
		}else{
			$sv_plvidid 	= isset( $_POST['sv_plvidid'] ) ? sanitize_text_field( $_POST['sv_plvidid'] ) : "";
		}

		$sv_plid 	  	= isset( $_POST['sv_plid'] ) ? sanitize_text_field( $_POST['sv_plid'] ) : "";
		$api_singvid	= isset( $_POST['api_singvid'] ) ? sanitize_text_field( $_POST['api_singvid'] ) : "";
		$sv_plvidttle 	= isset( $_POST['sv_plvidttle'] ) ? sanitize_text_field( $_POST['sv_plvidttle'] ) : "";
		

		$singvid_arr = array(
			'sv_plid' 				=> $sv_plid,	
	   		'sv_plvidid'  			=> $sv_plvidid,
	   		'apikey_singvid' 		=> $api_singvid,
	   		'sv_plvidttle' 			=> $sv_plvidttle,
			
		);

	$final_singvid_arr = serialize($singvid_arr);

	$wpdb->insert( $sv_table_name, array( 'id' => "",'singvid_arr' => $final_singvid_arr ), array( '%d', '%s' ) );

	$send_json_array = array( "success_msg" => "1" );
 	echo json_encode($send_json_array);
		
		
	die();
}