<?php
	defined( 'ABSPATH' ) or die();
	global $wpdb;
	wp_enqueue_script( 'jquery');
	extract(shortcode_atts(array(
					'cdlzr_utvideoid'=>'1'
				),$paras));

	$vids_arr = explode (",", $cdlzr_utvideoid); 
?>

<div class="container">
	<div id="cdlzr-uytvideo-holder"></div>
</div>

<script type="text/javascript">
	var player,
	time_update_interval = 0;

	function onYouTubeIframeAPIReady() {
	    player = new YT.Player('cdlzr-uytvideo-holder', {
	        width: 600,
	        height: 400,
	        videoId: '<?php echo $vids_arr[0]; ?>',
	        playerVars: {
	            color: 'white',
	            playlist: '<?php echo $cdlzr_utvideoid; ?>'
	           
	        },
	        events: {
	            onReady: initialize
	        }
	    });
	}

	function initialize(){

	    // Update the controls on load
	    updateTimerDisplay();
	    updateProgressBar();

	    // Clear any old interval.
	    clearInterval(time_update_interval);

	    // Start interval to update elapsed time display and
	    // the elapsed part of the progress bar every second.
	    time_update_interval = setInterval(function () {
	        updateTimerDisplay();
	        updateProgressBar();
	    }, 1000);


	    jQuery('#volume-input').val(Math.round(player.getVolume()));
	}


	// This function is called by initialize()
	function updateTimerDisplay(){
	    // Update current time text display.
	    jQuery('#current-time').text(formatTime( player.getCurrentTime() ));
	    jQuery('#duration').text(formatTime( player.getDuration() ));
	}


	// This function is called by initialize()
	function updateProgressBar(){
	    // Update the value of our progress bar accordingly.
	    jQuery('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
	}
</script>