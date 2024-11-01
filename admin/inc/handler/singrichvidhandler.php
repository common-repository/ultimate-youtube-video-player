<?php
defined( 'ABSPATH' ) or die();
global $wpdb;
$svr_table_name = $wpdb->prefix . "ytube_richpldata";

if( ! wp_verify_nonce( $_POST['ytrpform_generate_nonce'],'ytrp_form_submit' ) ) {
	die("Error in submit");
}
else {

		$rp_plvidttle 	= isset( $_POST['rp_plvidttle'] ) ? sanitize_text_field( $_POST['rp_plvidttle'] ) : "";
		$rp_vid_id 	  	= isset( $_POST['rp_vid_id'] ) ? sanitize_text_field( $_POST['rp_vid_id'] ) : "";
		
		$singvid_arr = array(
			'rp_plvidttle' 			=> $rp_plvidttle,	
	   		'rp_vid_id'  			=> $rp_vid_id	   		
		);

	$final_singvid_arr = serialize($singvid_arr);

	$wpdb->insert( $svr_table_name, array( 'id' => "",'richplist_arr' => $final_singvid_arr ), array( '%d', '%s' ) );

	$send_json_array = array( "success_msg" => "1" );
 	echo json_encode($send_json_array);
		
		
	die();
}