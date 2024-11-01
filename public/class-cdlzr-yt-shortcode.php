<?php
defined( 'ABSPATH' ) or die();

if( ! class_exists('CDLZR_YT_Shortcode') ) { 
	class CDLZR_YT_Shortcode {

		/* Enqueue the frontend assests */
		public static function frontend_assests() {
			global $post;
			$version = "3.1";

			
			if( has_shortcode( $post->post_content,'cdlzr_ytplyr' ) || has_shortcode( $post->post_content,'cdlzr_ytrichvideo_plyr' ) ) {
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script('youtubeapijs','https://www.youtube.com/iframe_api');
				//add_filter('wp_enqueue_scripts',['CDLZR_YT_Shortcode','enqjs'],1);
				wp_enqueue_style( 'bootstrap', CDLZR_YTUBE_URL . 'assets/css/bootstrap.min.css' );
				wp_enqueue_style( 'public_style', CDLZR_YTUBE_URL . 'public/libs/css/style-css.css'  );
				wp_enqueue_style( 'darkscroll', CDLZR_YTUBE_URL . 'public/libs/css/darkscroll.css'  );
				wp_enqueue_style( 'swiper', CDLZR_YTUBE_URL . 'public/libs/css/swiper-bundle.min.css'  );
				
				wp_enqueue_script( 'bootstrap', CDLZR_YTUBE_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), $version, true );

				
				/* Custom JS file load */
				//wp_enqueue_script( 'public_script', CDLZR_YTUBE_URL . "public/libs/js/public-js.js", ['jquery'], $version, true );	
				
				wp_enqueue_script( 'nicescroll', CDLZR_YTUBE_URL . "public/libs/js/jquery.nicescroll.min.js", ['jquery'], $version, true );	
				wp_enqueue_script( 'spidochetube', CDLZR_YTUBE_URL . "public/libs/js/jquery.spidochetube.js", ['jquery'], $version, true );	
				
				wp_enqueue_script( 'swiper', CDLZR_YTUBE_URL . "public/libs/js/swiper-bundle.min.js", ['jquery'], $version, true );	

			}
		}

		public static function enqjs(){
			wp_enqueue_script( 'jquery',false, array(), false, false );
		}
	

		/*Short code*/
		public static function show_youtubeplayer($paras) {			
			ob_start();
			include( "inc/show_youtubeplayer.php" );
			return ob_get_clean();			
		}

		public static function show_youtubesingvid($paras) {			
			ob_start();
			include( "inc/show_youtubesinglevideo.php" );
			return ob_get_clean();			
		}

		public static function show_rich_videoplyr($paras){
			ob_start();

			include( "inc/show_richyoutubevideoplyr.php" );
			return ob_get_clean();
		}
		
	}
}