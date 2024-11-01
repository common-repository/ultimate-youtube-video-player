<?php
/**
 * The plugin Widget handler page.
 *
 * @package ultimate-youtube-video-player
 */
defined( 'ABSPATH' ) or die();

if (! class_exists( 'CDLZRYTWidget' )){
	class CDLZRYTWidget extends WP_Widget {	

	/**
	* @return CDLZRYTWidget constructor.
	*/	

	public function __construct() {		
		parent::__construct(
			'cdlzr_yt_video_widget',// Base ID
			__( 'Ultimate YouTube Subscriber', 'CDLZR_PLUG_YTUBE_DOM' ),// Name
			array('description' => esc_html('Display Your Subscriber Button','CDLZR_PLUG_YTUBE_DOM')),// Args
			array(
				'customize_selective_refresh' => true,
			)
		);
	}// end constructor

	/*The widget form (for the backend )*/
	public function form( $instance ) {
		global $wpdb;
		$tbl_name = $wpdb->prefix . "ytube_setting";
		$results  = $wpdb->get_results( "SELECT * FROM `$tbl_name`", OBJECT );
		$rowcount = $wpdb->get_var( "SELECT COUNT(*) FROM $tbl_name" );
		/*Set widget defaults*/
		$defaults = array(
			'title'    			=> '',
			'select_yt'     	=> '',	
			'checkbox_layout'   => '',	
			'checkbox_theme'	=> '',
			'checkbox_subcount' => ''		
		);

		/*Parse current settings with defaults*/
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); 
		$select   = isset( $instance['select_yt'] ) ? $instance['select_yt'] : '';
		$checkbox_layout = isset( $instance['checkbox_layout'] ) ? $instance['checkbox_layout'] : '';
		$checkbox_theme  = isset( $instance['checkbox_theme'] ) ? $instance['checkbox_theme'] : '';
		$checkbox_subcount = isset( $instance['checkbox_subcount'] ) ? $instance['checkbox_subcount'] : '';
		?>

		<p>				
			<label for="Title"><?php _e( 'Title', 'CDLZR_PLUG_YTUBE_DOM' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'select_yt' ); ?>"><?php _e( 'YouTube Channel ID', 'CDLZR_PLUG_YTUBE_DOM' ); ?></label>			
			<select name="<?php echo $this->get_field_name( 'select_yt' ); ?>" id="<?php echo $this->get_field_id( 'select_yt' ); ?>" class="widefat select">
			<?php
			$chan_arr = [];
			if($rowcount>0){			
				foreach ($results as $res) {
					$chan_arr[] = $res->channel_id;		
				}

				$final_chan_arr = array_unique($chan_arr);		
				foreach ($final_chan_arr as $single_chan) {
					$chan_res  = $wpdb->get_row( "SELECT * FROM `$tbl_name` WHERE `channel_id`='$single_chan'", OBJECT );					
					?>
					<option <?php if($select==$single_chan){ echo esc_html("selected=selected"); } ?> id="<?php echo esc_attr($res->id); ?>" value="<?php echo esc_attr($single_chan); ?>"><?php echo esc_html($chan_res->yt_playlist_name." "."[".$single_chan."]"); ?></option>
					<?php
				}	
			}else{
				?><option>No Channel Found</option><?php
			}			
			?>
			</select>			
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_layout' ) ); ?>" type="checkbox" value="<?php echo esc_attr("1"); ?>" <?php checked( '1', $checkbox_layout ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_layout' ) ); ?>"><?php _e( 'Enable Full Layout', 'CDLZR_PLUG_YTUBE_DOM' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_theme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_theme' ) ); ?>" type="checkbox" value="<?php echo esc_attr("1"); ?>" <?php checked( '1', $checkbox_theme ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_theme' ) ); ?>"><?php _e( 'Enable Dark Theme', 'CDLZR_PLUG_YTUBE_DOM' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox_subcount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox_subcount' ) ); ?>" type="checkbox" value="<?php echo esc_attr("1"); ?>" <?php checked( '1', $checkbox_subcount ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox_subcount' ) ); ?>"><?php _e( 'Hide Subscriber Count', 'CDLZR_PLUG_YTUBE_DOM' ); ?></label>
		</p>
		<?php
	}

	/*Update widget settings*/
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';	
		$instance['select_yt']   = isset( $new_instance['select_yt'] ) ? wp_strip_all_tags( $new_instance['select_yt'] ) : '';
		$instance['checkbox_layout'] = isset( $new_instance['checkbox_layout'] ) ? 1 : false;
		$instance['checkbox_theme'] = isset( $new_instance['checkbox_theme'] ) ? 1 : false;	
		$instance['checkbox_subcount'] = isset( $new_instance['checkbox_subcount'] ) ? 1 : false;		
		return $instance;
	}

	/*Display the widget*/
	public function widget( $args, $instance ) {
		extract( $args );
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';	
		$select_yt   = isset( $instance['select_yt'] ) ? $instance['select_yt'] : 'UCkY_HCTtYM8Et_BBbnTV6ow';
		$checkbox_layout = ! empty( $instance['checkbox_layout'] ) ? 'full' : 'default';
		$checkbox_theme = ! empty( $instance['checkbox_theme'] ) ? 'dark' : 
		'default';	
	    $checkbox_subcount = ! empty( $instance['checkbox_subcount'] ) ? 
		'hidden' : 'default';
				     
	    echo $before_widget;	     
	    if ( $title ) {
	        echo $before_title . $title . $after_title;
	    }
		?>
		<style type="text/css">
			.dark_theme{
				padding: 8px; 
				background: rgb(85, 85, 85);
			}
		</style>
		<div class="ytsubscribe_container <?php echo $checkbox_theme; ?>_theme">
			<script src="https://apis.google.com/js/platform.js"></script>
			<div class="g-ytsubscribe" data-channelid="<?php echo $select_yt; ?>" data-layout="<?php echo $checkbox_layout; ?>" data-theme="<?php echo $checkbox_theme; ?>" data-count="<?php echo $checkbox_subcount; ?>">
			</div>
		</div>
		<?php
		echo $after_widget;	
		
	}
} // end class CDLZRYTWidget

	/*Register the CDLZR YT widget*/
	function cdlzr_yt_register_widget() {
		register_widget( 'CDLZRYTWidget' );
	}
	add_action( 'widgets_init', 'cdlzr_yt_register_widget' );
} // end if exist class CDLZRYTWidget