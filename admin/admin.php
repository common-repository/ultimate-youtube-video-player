<?php
defined( 'ABSPATH' ) or die();

require_once( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/class-cdlzr-yt-menu.php' );
require_once( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/class-cdlzr-yt-actions.php' );
require_once( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/widget/class-cdlzr-yt-widget.php' );
new CDLZRYTWidget;

add_action( 'admin_menu', array( 'CDLZR_YT_Menu', 'yt_create_menu' ) );

/* To call ajax to save form */
add_action( 'wp_ajax_addidkey', array( 'CDLZR_YT_Actions', 'add_yt_idkey' ) );
add_action( 'wp_ajax_savesingvid', array( 'CDLZR_YT_Actions', 'save_single_video' ) );
add_action( 'wp_ajax_singytvidplid', array( 'CDLZR_YT_Actions', 'get_ytsingviddata' ) );
add_action( 'wp_ajax_getytdata', array( 'CDLZR_YT_Actions', 'get_ytdata' ) );
add_action( 'wp_ajax_updateytval', array( 'CDLZR_YT_Actions', 'update_ytdata' ) );
add_action( 'wp_ajax_delsvytval', array( 'CDLZR_YT_Actions', 'del_ytsingvid' ) );
add_action( 'wp_ajax_getsettingid', array( 'CDLZR_YT_Actions', 'get_setting' ) );
add_action( 'wp_ajax_savesetting', array( 'CDLZR_YT_Actions', 'save_setting' ) );
add_action( 'wp_ajax_delytdata', array( 'CDLZR_YT_Actions', 'del_ytsetting' ) );
add_action( 'wp_ajax_richdelsingytvideo', array( 'CDLZR_YT_Actions', 'rich_del_single_video' ) );
add_action( 'wp_ajax_saverichvids', array( 'CDLZR_YT_Actions', 'save_rich_single_video' ) );
add_filter( 'plugin_action_links_' . plugin_basename(CDLZR_YTUBE_FILE), array( 'CDLZR_YT_Actions', 'cdlzr_yt_plugin_actions_links' ) );