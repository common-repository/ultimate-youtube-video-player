<?php
	defined( 'ABSPATH' ) or die();
	global $wpdb;

?>
<div class="cdlzr_ytube">
	<section id="richvidsetting">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">					
					<h3 class="cdlzr_yt_head"><?php _e('Rich YouTube Video Playlist',CDLZR_PLUG_YTUBE_DOM);?></h3>
				</div>
			</div>
			<form id="rpvidytform" method="post">
				<?php wp_nonce_field( 'ytrp_form_submit', 'ytrpform_generate_nonce' );?>
				<div class="form-row mt-3">					
					<div class="form-group col-md-3">
						<label for="rp_plvidttle"><?php _e('Add Video Title',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" name="rp_plvidttle" id="rp_plvidttle" class="form-control" placeholder="Enter Video Title">
					</div>
					<div class="form-group col-md-3">
						<label for="rp_vid_id"><?php _e('Add Video ID',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" name="rp_vid_id" id="rp_vid_id" class="form-control" placeholder="Enter Video ID">
					</div>
					<div class="form-group col-md-3" style="margin-top:30px;">
						<button id="btn_yt_rp_save" class="btn btn-success"><?php _e('Save',CDLZR_PLUG_YTUBE_DOM); ?> <i class="far fa-save"></i></button>
					</div>	
				</div>
			</form>	
			<p>
				<h6>Shortcode - For display rich video player with selected video ID</h6>
				<code>[cdlzr_ytrichvideo_plyr cdlzr_utvideoid=youtubevideoid1,youtubevideoid2,youtubevideoid3]</code>
			</p>
		</div>
	</section>

	<section id="richsinglevideolist" class="mt-2">
		<div class="container-fluid">
			<div class="row">
				<div class="col mt-2 mb-2">
					<h5><?php _e('Player Video List',CDLZR_PLUG_YTUBE_DOM); ?></h5>
				</div>
			</div>
			<div class="row">
				<div class="col table-responsive">
					<table class="table table-stripped" id="singlevideolistTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?php _e('Video Title',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Video ID',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Delete',CDLZR_PLUG_YTUBE_DOM); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$table_name  = $wpdb->prefix . "ytube_richpldata";
								$query 		 = "SELECT * FROM `$table_name`";
								$result_svid = $wpdb->get_results($query);								
							
								$sv_array 	 = json_decode(json_encode($result_svid), true);

								//var_dump($sv_array);

								$h = 1;
								foreach($sv_array as $sing_sv_array){
									$final_rp_arr = unserialize($sing_sv_array['richplist_arr']);
									?>
										<tr>
											<td><?php echo $h; ?></td>
											<td><?php echo $final_rp_arr['rp_plvidttle']; ?></td>
											<td><?php echo $final_rp_arr['rp_vid_id']; ?></td>
											<td><button data-id="<?php echo $h; ?>" class="btn btn-danger del_sing_ytvid" type="button"><i class="fas fa-trash"></i></button></td>
										</tr>
									<?php
								$h++; }
							?>
							
						</tbody>
					</table>								
				</div>
			</div>
		</div>
	</section>
</div>	