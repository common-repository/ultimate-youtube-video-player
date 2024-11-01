<?php
	defined( 'ABSPATH' ) or die();
	global $wpdb;
	$table_name = $wpdb->prefix . "ytube_setting";
	$query 		= "SELECT `yt_playlist_id`,`yt_playlist_name` FROM `$table_name`";
	$result 	= $wpdb->get_results($query);
?>
<div class="cdlzr_ytube">
	<section id="singvidsetting">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">					
					<h3 class="cdlzr_yt_head"><?php _e('Single YouTube & Vimeo Video Player',CDLZR_PLUG_YTUBE_DOM);?></h3>
				</div>
			</div>
			<form id="singvidytform" method="post">
				<?php wp_nonce_field( 'ytsv_form_submit', 'ytsvform_generate_nonce' );?>
				<div class="form-row mt-3">					
					<div class="form-group col-md-3">
						<label for="sv_plid"><?php _e('Select Playlist Id',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="hidden" name="api_singvid" id="api_singvid" value="">
						<select name="sv_plid" id="sv_plid" class="form-control">
							<option>Select Playlist</option>
							<?php
								foreach ($result as $res ) {
									?>										
										<option value="<?php echo $res->yt_playlist_id; ?>"><?php echo $res->yt_playlist_name; ?></option>
									<?php
								}//end foreach loop
							?>
							<option value="vimeo">Vimeo Video</option>
						</select>	
					</div>					
					<div class="form-group col-md-3">
						<label for="sv_plvidid"><?php _e('Select Video',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<select name="sv_plvidid" id="sv_plvidid" class="form-control">							
						</select>	
						<input style="display:none;" type="text" name="sv_plid_vimeo" id="sv_plid_vimeo" class="form-control" placeholder="Enter Vimeo Video ID">
					</div>
					<div class="form-group col-md-3">
						<label for="sv_plvidttle"><?php _e('Add Title',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" name="sv_plvidttle" id="sv_plvidttle" class="form-control" placeholder="Enter Title for player">
					</div>				

					<div class="form-group col-md-3" style="margin-top:30px;">
						<button id="btn_yt_sv_save" class="btn btn-success"><?php _e('Save',CDLZR_PLUG_YTUBE_DOM); ?> <i class="far fa-save"></i></button>
					</div>	
				</div>
			</form>	
		</div>
	</section>

	<section id="savedsinglevideolist">
		<div class="container-fluid">
			<div class="row">
				<div class="col mt-2 mb-2">
					<h5><?php _e('Single Video List',CDLZR_PLUG_YTUBE_DOM); ?></h5>
				</div>
			</div>
			<div class="row">
				<div class="col table-responsive">
					<table class="table table-stripped" id="singlevideolistTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?php _e('You Tube Playlist ID',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Playlist Name',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Video',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Video Title',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Shortcode',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Delete',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<!--<th>Copy</th> -->
							</tr>
						</thead>
						<tbody>
							<?php
								$table_name  = $wpdb->prefix . "ytube_singviddata";
								$query 		 = "SELECT * FROM `$table_name`";
								$result_svid = $wpdb->get_results($query);								

								$sv_array 	 = json_decode(json_encode($result_svid), true);
								$count_svarr = count($sv_array);
								
								array_walk( $sv_array, function ( $data_firstarr, $val ) use ( $result_svid ){

									$nv_array   	= json_decode(json_encode($result_svid[$val]), true);	
									$unser_arr 		= unserialize($data_firstarr['singvid_arr']);	
									$sv_plid 		=  $unser_arr['sv_plid'];
									$sv_plvidid 	=  $unser_arr['sv_plvidid'];	
									$apikey_singvid	=  $unser_arr['apikey_singvid'];
								

									if(isset($unser_arr['sv_plvidttle'])){
										$sing_plttle    =  $unser_arr['sv_plvidttle'];
									}else{
										$sing_plttle    =  $sv_plid_vimeo;
									}
									

									$apikey 		= $apikey_singvid;
								    $googleApiUrl 	= 'https://www.googleapis.com/youtube/v3/videos?id=' . $sv_plvidid . '&key=' . $apikey . '&part=snippet';
								    
									$ch = curl_init();								    
								    curl_setopt($ch, CURLOPT_HEADER, 0);
								    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
								    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
								    curl_setopt($ch, CURLOPT_VERBOSE, 0);
								    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								    $response = curl_exec($ch);								        
								    curl_close($ch);
								        
								    $data = json_decode($response);								        
								    $value = json_decode(json_encode($data), true);

									if(isset($value['items'])){
										$title = $value['items'][0]['snippet']['title'];
									}else{
										$title = "Vimeo";
									}
								    
								    //$description = $value['items'][0]['snippet']['description'];

								    /*get playlist name acc to playlist id*/
								    global $wpdb;
								    $table_name = $wpdb->prefix . "ytube_setting";
								    $query_plname   = "SELECT * FROM `$table_name` WHERE `yt_playlist_id`='$sv_plid'";
									$res_plname 	= $wpdb->get_row($query_plname);
									?>
										<tr>
											<td><?php echo $val+1 ; ?></td>
											<td>
												<?php 
													if($sv_plid == "vimeo"){
														echo $sv_plvidid; 
													}else{
														echo $sv_plid; 
													}													
												?>
											</td>
											<td><?php if(isset($res_plname->yt_playlist_name)){ 
												echo $res_plname->yt_playlist_name; }
												else{ 
													if($sv_plid == "vimeo"){
														echo "Vimeo Video"; 
													}else{
														echo "Not Found"; 
													}
													
													} ?>
												</td>
											<td>
												<div class="row">
													<div class="col-md-12">
														<?php
															if($sv_plid == "vimeo"){
																
																?>
																<img width="320" heigjt="180" class="cdlzr_thumb_singvid" src="https://vumbnail.com/<?php echo $sv_plvidid; ?>.jpg">
																<?php
															}else{
																?>
																<img class="cdlzr_thumb_singvid" src="https://i.ytimg.com/vi/<?php echo $sv_plvidid; ?>/mqdefault.jpg">
																<?php
															}
														?>														
													</div>
													<div class="col-md-12">
														<kbd>
															<?php 
															if($sv_plid == "vimeo"){
															
																echo "Vimeo";
															}else{
																echo $title;  
															}
															?>
														</kbd>
													</div>
												</div>
											</td>	
											<td><?php echo $sing_plttle; ?></td>
											<td><?php echo "[cdlzr_ytvideo id=".$nv_array['id']."]";?></td>
											<td><button class="btn btn-danger get_data_delsingvid" data-id="<?php echo $nv_array['id']; ?>"><i class="fas fa-trash" style="font-size:20px;"></i></button></td>
											<!--<td><button id="copy_short_<?php //echo $ytid; ?>" class="btn btn-warning copy_short" title="Copy Shortcode" data-scode='<?php //echo $ytid; ?>'  data-clipboard-target="#inptxt_<?php //echo $ytid; ?>"><i class="fas fa-copy"></i></button></td> -->
										</tr>
									<?php	
								});//end foreach loop
							?>
						</tbody>
					</table>
					<!-- <div id="snackbar_sv">Copied <i class="fas fa-copy"></i></div> -->					
				</div>
			</div>
		</div>
	</section>
</div>