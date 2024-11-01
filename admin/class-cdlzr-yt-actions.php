<?php
defined( 'ABSPATH' ) or die();

if( ! class_exists('CDLZR_YT_Actions') ) {
	class CDLZR_YT_Actions {
		public static function add_yt_idkey() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/idkeyhandler.php' );
		}

		public static function get_ytdata() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/getytdata.php' );
		}

		public static function update_ytdata() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/updateytdata.php' );
		}
		
		public static function get_ytsingviddata() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/getsingviddata.php' );
		}	

		public static function save_single_video() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/singvidhandler.php' );
		}

		public static function del_ytsingvid() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/delsingvid.php' );
		}

		public static function get_setting() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/getsetting.php' );
		}

		public static function save_setting() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/savesetting.php' );
		}

		public static function del_ytsetting() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/delytsetting.php' );
		}

		public static function save_rich_single_video() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/singrichvidhandler.php' );
		}
			
		public static function rich_del_single_video() {
			include( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/inc/handler/richdelsingvidhandler.php' );
		}	
		
		/**
	     * Add Custom Links to All Plugins list page for this plugin
	     * @param $cdlzrgopro_links
	     * @return mixed
	     */
	    public static function cdlzr_yt_plugin_actions_links($cdlzrgopro_links)
	    {
	        $cdlzrgopro_links['go_pro'] = sprintf( '<a style="color:#c40f95;font-weight:800;" target="_blank" href="%1$s">%2$s</a>', esc_url('https://codelizar.com/product/ultimate-youtube-video-player-pro/'), esc_html__( 'Go Pro', 'CDLZR_PLUG_YTUBE_DOM' ) );
	        
	        	        
	        return $cdlzrgopro_links;
	    }		
	}
}