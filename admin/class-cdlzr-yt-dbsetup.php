<?php
defined( 'ABSPATH' ) or die();

if( ! class_exists('CDLZR_YT_Dbsetup') ) {
	class CDLZR_YT_Dbsetup {
		public static function setupdb() {
			global $wpdb;
			$ytube_setting_tbl 	 = $wpdb->prefix . 'ytube_setting';
			$ytube_singvid_tbl 	 = $wpdb->prefix . 'ytube_singviddata';
			$ytube_themedata_tbl = $wpdb->prefix . 'ytube_themedata';
			$ytube_richpl_tbl    = $wpdb->prefix . 'ytube_richpldata';

			$create_ytube_tbl = "CREATE TABLE IF NOT EXISTS `$ytube_setting_tbl`(
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`channel_id` text NOT NULL,
				`yt_api_key` text NOT NULL,
				`yt_playlist_id` text NOT NULL,
				`yt_playlist_name` varchar(255) NOT NULL,
				`yt_ribbon_name` varchar(255) NOT NULL,
				`yt_date` date NOT NULL,
				`status` text NOT NULL,
				PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	

			$create_ytubesingvid_tbl = "CREATE TABLE IF NOT EXISTS `$ytube_singvid_tbl`(
				`id` INT(11) NOT NULL AUTO_INCREMENT,				
				`singvid_arr` longtext NOT NULL,
				PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	

			$create_ytubetheme_tbl = "CREATE TABLE IF NOT EXISTS `$ytube_themedata_tbl`(
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`postid_ytube` INT(11) NOT NULL,
				`theme_id` varchar(100) NOT NULL,
				`theme_arr` longtext NOT NULL,	
				`selected_theme` INT(11) NOT NULL,			
				PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	

			$create_ytube_richpl_tbl = "CREATE TABLE IF NOT EXISTS `$ytube_richpl_tbl`(
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`richplist_arr` longtext NOT NULL,
				PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
			
			/*EXECUTE QUERIES*/
			$wpdb->query( $create_ytube_tbl );
			$wpdb->query( $create_ytubesingvid_tbl );
			$wpdb->query( $create_ytubetheme_tbl );	
			$wpdb->query( $create_ytube_richpl_tbl );			
		}
	}	
}