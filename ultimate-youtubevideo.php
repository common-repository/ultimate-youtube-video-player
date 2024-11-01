<?php
/**
 * Plugin Name: Ultimate YouTube Video Player & Shorts With Vimeo
 * Plugin URI: https://wordpress.org/plugins/ultimate-youtube-video-player/
 * Description: Ultimate YouTube Video & Shorts Player With Vimeo Plugin shows your youtube,vimeo videos in gallery and slider view & subscriber button from related user account and you can manage video using your account token. plugin shows playlist with date time. it is really help in to check the latest video and its status.
 * Version: 3.3
 * Author: Codelizar
 * Author URI: https://codelizar.com
 * Text Domain: CDLZR_PLUG_YTUBE_DOM
 * Domain Path: /languages
 * @package ultimate-youtube-video-player
 */

defined( 'ABSPATH' ) or die();

if ( ! defined( 'CDLZR_YTUBE_URL' ) ) {
	define( "CDLZR_YTUBE_URL", plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'CDLZR_YTUBE_PLUGIN_DIR_PATH' ) ) {
	define( 'CDLZR_YTUBE_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'CDLZR_PLUG_YTUBE_DOM' ) ) {
	define( 'CDLZR_PLUG_YTUBE_DOM', 'CDLZR_PLUG_YTUBE_DOM' );
}

if ( ! defined( 'CDLZR_YTUBE_FILE' ) ) {
	define( 'CDLZR_YTUBE_FILE', __FILE__ );
}

if ( ! class_exists( 'CDLZR_YTUBE_CLS' ) ) {
	final class CDLZR_YTUBE_CLS
	{
		private static $instance = null;

		private function __construct()
		{
			$this->initialize_hooks();
			$this->setupDBactivation();
			add_action( 'admin_notices', array('CDLZR_YTUBE_CLS','cdlzr_uyt_display_admin_notice' ));		
			add_action( 'admin_init', array('CDLZR_YTUBE_CLS','cdlzr_uyt_spare'), 5 );			
		}

		private function initialize_hooks() {
			if ( is_admin() ) {
				require_once( 'admin/admin.php' );
			}
			require_once( 'public/public.php' );
		}

		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/*Set up database*/
		private function setupDBactivation() {
			require_once('admin/class-cdlzr-yt-dbsetup.php');
			register_activation_hook( __FILE__, array( 'CDLZR_YT_Dbsetup', 'setupdb' ) );
		}

		public static function cdlzr_uyt_display_admin_notice() {
			$dont_disturb = esc_url( get_admin_url() . '?uyt_spare_me=1' );
			$plugin_info = get_plugin_data( __FILE__ , true, true );       
			$reviewurl = esc_url( 'https://wordpress.org/support/plugin/'. sanitize_title( $plugin_info['Name'] ) . '/reviews/' );
			if( !get_option('uyt_spare') ){
				printf(__('<div class="notice notice-success" style="padding: 10px;">You have been using <b> %s </b> for a while. We hope you liked it! Please give us a quick rating, it works as a boost for us to keep working on the plugin!<br><div class="void-review-btn"><a href="%s" style="margin-top: 10px; display: inline-block; margin-right: 5px;" class="button button-primary" target=
				"_blank">Rate Now!</a><a href="%s" style="margin-top: 10px; display: inline-block; margin-right: 5px;" class="button button-secondary">Already Done !</a></div></div>', $plugin_info['TextDomain']), $plugin_info['Name'], $reviewurl, $dont_disturb );
			}
		}

		// remove the notice for the user if review already done or if the user does not want to
		public static function cdlzr_uyt_spare(){    
		    if( isset( $_GET['uyt_spare_me'] ) && !empty( $_GET['uyt_spare_me'] ) ){
		        $uyt_spare_me = $_GET['uyt_spare_me'];
		        if( $uyt_spare_me == 1 ){
		            add_option( 'uyt_spare' , TRUE );
		        }
		    }
		}
	}
}
CDLZR_YTUBE_CLS::get_instance();