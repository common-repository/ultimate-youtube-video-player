<?php
defined( 'ABSPATH' ) or die();

if ( ! class_exists('CDLZR_YT_Menu') ) {
	class CDLZR_YT_Menu
	{
		/* Create Menu of plugin*/
		public static function yt_create_menu() {

			/*Main Menu*/
			global $submenu;
			/*add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )*/
			
			$dashboard = add_menu_page( __('
Ultimate YouTube', CDLZR_PLUG_YTUBE_DOM ), __('Ultimate YouTube', CDLZR_PLUG_YTUBE_DOM ), 'manage_options', 'cdlzr_yt_plug', array( 'CDLZR_YT_Menu', 'dashboard' ), esc_url(CDLZR_YTUBE_URL.'/assets/img/youtube.png'), '10' );
			add_action( 'admin_print_styles-' . $dashboard, array( 'CDLZR_YT_Menu', 'dashboard_assets' ) );	

			/*Sub Menu*/

			/*add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', int $position = null )*/					

			$help_video = add_submenu_page( 'cdlzr_yt_plug', __('YT Help', CDLZR_PLUG_YTUBE_DOM ),  __('YT Help', CDLZR_PLUG_YTUBE_DOM ), 'manage_options', 'ytv_help', array( 'CDLZR_YT_Menu', 'yt_helpmenu' ) );
			add_action( 'admin_print_styles-' . $help_video, array( 'CDLZR_YT_Menu', 'dashboard_assets' ) );
			$submenu['cdlzr_yt_plug'][0][0] = "How to use";

			$manage_video_setting = add_submenu_page( 'cdlzr_yt_plug', 'YT Settings', 'YT Settings', 'manage_options', 'ytv_settings', array( 'CDLZR_YT_Menu', 'yt_submenu' ) );
			add_action( 'admin_print_styles-' . $manage_video_setting, array( 'CDLZR_YT_Menu', 'dashboard_assets' ) );

			$single_video_setting = add_submenu_page( 'cdlzr_yt_plug', 'Single YT Vimeo Video', 'Single YT Vimeo Video', 'manage_options', 'ytv_singlevideo', array( 'CDLZR_YT_Menu', 'yt_singvidmenu' ) );
			add_action( 'admin_print_styles-' . $single_video_setting, array( 'CDLZR_YT_Menu', 'dashboard_assets' ) );

			$rich_yt_video = add_submenu_page( 'cdlzr_yt_plug', 'Rich YT Playlist', 'Rich YT Playlist', 'manage_options', 'ytv_richvideo', array( 'CDLZR_YT_Menu', 'yt_richvidmenu' ) );
			add_action( 'admin_print_styles-' . $rich_yt_video, array( 'CDLZR_YT_Menu', 'dashboard_assets' ) );		

			$upgradepro_setting = add_submenu_page( 'cdlzr_yt_plug', 'Upgrade To Pro', 'Upgrade To Pro', 'manage_options', 'ytv_gopro', array( 'CDLZR_YT_Menu', 'ytv_gopromenu' ) );
			add_action( 'admin_print_styles-' . $upgradepro_setting, array( 'CDLZR_YT_Menu', 'dashboard_assets' ) );			

		}

		/* enqueue libs */
		public static function dashboard_assets() {
			self::enqueue_libs();
		}

		public static function enqueue_libs() {			
			wp_enqueue_style( 'bootstrap_css', CDLZR_YTUBE_URL . 'assets/css/bootstrap.min.css'  );			
			wp_enqueue_style( 'admin_css', CDLZR_YTUBE_URL . 'admin/libs/css/admin-css.css'  );
			wp_enqueue_style( 'font-awesome', CDLZR_YTUBE_URL . 'assets/fontawesome/css/all.min.css'  );
			wp_enqueue_style( 'sidebar-bootstrap', CDLZR_YTUBE_URL . 'admin/libs/css/bootstrap-side-modals.css'  );		
			wp_enqueue_script( 'jquery' );
			
			wp_enqueue_script( 'bootstrap_js', CDLZR_YTUBE_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), true, true );			
			wp_enqueue_style( 'datatable-css', CDLZR_YTUBE_URL . 'admin/libs/css/datatables.min.css' );
			wp_enqueue_script( 'datatable-js', CDLZR_YTUBE_URL . 'admin/libs/js/datatables.min.js', array( 'jquery' ) );			
			wp_enqueue_style( 'admin-css', CDLZR_YTUBE_URL . 'admin/libs/css/admin-css.css' );	

			wp_enqueue_script( 'custom-js', CDLZR_YTUBE_URL . 'admin/libs/js/custom-js.js' );			

			wp_enqueue_script( 'clipboard-js', CDLZR_YTUBE_URL . 'admin/libs/js/clipboard.min.js' );
		}

		public static function dashboard() {
			require_once( 'inc/dashboard.php' );
		}

		public static function yt_submenu() {
			require_once( 'inc/ytsetting.php' );
		}

		public static function yt_helpmenu() {
			require_once( 'inc/ythelp.php' );
		}

		public static function yt_singvidmenu() {
			require_once( 'inc/ytsingvid.php' );
		}

		public static function ytv_gopromenu() {
			require_once( 'inc/ytgopro.php' );
		}

		public static function yt_richvidmenu() {
			require_once( 'inc/ytrichplaylist.php' );
		}					
	}
}