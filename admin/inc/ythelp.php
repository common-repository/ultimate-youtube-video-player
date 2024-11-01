<?php
	defined( 'ABSPATH' ) or die();
	global $wpdb;
?>
<div class="cdlzr_ytube_help">
	<section id="help_docs">
		<div class="container-fluid">			
			<div class="col-md-12">					
				<h3 class="cdlzr_yt_head"><?php _e('How to create API Key',CDLZR_PLUG_YTUBE_DOM);?></h3>
			</div>
			<div class="container">
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 1. First Open your browser & login with your google account.</h4>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 2. Next type & search "Google Developer Console". or <a href="https://console.cloud.google.com/projectselector2/home/dashboard" target="_blank">Click</a></h4>					
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 3. Now Select or Create a New Google Cloud Project</h4>
					<img src="<?php echo CDLZR_YTUBE_URL ?>/assets/img/help/img1.PNG" class="img-responsive" style="width:85%;margin-top: 10px;"/>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 4. After creation the project go to the APIs & Services -> Credentials.</h4>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 5. Now click the button +CREATE CREDENTIALS and select API key menu.</h4>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 6. Your API Key is created, please copy it and paste to the safe place.</h4>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 7. Now go the again APIs & Services -> Library.</h4>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 8. Type and search here "You Tube Data API v3" and select it.</h4>					
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 9. Click the button Enable API</h4>
					<img src="<?php echo CDLZR_YTUBE_URL ?>/assets/img/help/img2.PNG" class="img-responsive" style="width:85%;margin-top: 10px;"/>
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 10. You successfully enabled the api and API KEY for your project.
				</div>
				<div class="col-md-12 mt-4">
					<h4><i class="far fa-hand-point-right help_docs"></i>Step - 11. For more help and want to know about you tube channel id, playlist id & video id <a target="_blank" href="https://codelizar.com/how-to-detect-you-tube-channel-playlist-video-id-in-you-tube-account/">click</a>
				</div>			
			</div>
		</div>	
	</section>
</div>			