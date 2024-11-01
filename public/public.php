<?php
defined( 'ABSPATH' ) or die();
require_once( 'class-cdlzr-yt-shortcode.php' );
require_once( 'class-cdlzr-frontend-actions.php' );

require_once( CDLZR_YTUBE_PLUGIN_DIR_PATH . 'admin/widget/class-cdlzr-yt-widget.php' );
new CDLZRYTWidget;

add_action( 'wp_enqueue_scripts', array( 'CDLZR_YT_Shortcode', 'frontend_assests' ) );
add_shortcode( 'cdlzr_ytplyr', array( 'CDLZR_YT_Shortcode', 'show_youtubeplayer' ) );
add_shortcode( 'cdlzr_ytvideo', array( 'CDLZR_YT_Shortcode', 'show_youtubesingvid' ) );
add_shortcode( 'cdlzr_ytrichvideo_plyr', array( 'CDLZR_YT_Shortcode', 'show_rich_videoplyr' ) );