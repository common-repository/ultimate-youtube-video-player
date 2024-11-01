<?php
	defined( 'ABSPATH' ) or die();
	global $wpdb;
	$table_name = $wpdb->prefix . "ytube_setting";
	$rowcount = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
?>
<div class="cdlzr_ytube">
	<section id="addsetting">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">					
					<h3 class="cdlzr_yt_head"><?php _e('Manage Account & Video',CDLZR_PLUG_YTUBE_DOM);?></h3>
				</div>
			</div>
			<form id="addytsetform" method="post">
				<?php wp_nonce_field( 'ytset_form_submit', 'ytform_generate_nonce' );?>
				<div class="form-row mt-3">
					<div class="form-group col-md-3">
						<label for="chid"><?php _e('Channel ID',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" id="chid" name="chid" class="form-control" placeholder="<?php _e('Enter Channel ID',CDLZR_PLUG_YTUBE_DOM); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="apikey"><?php _e('You Tube API KEY',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" id="apikey" name="apikey" class="form-control" placeholder="<?php _e('Enter API KEY',CDLZR_PLUG_YTUBE_DOM); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="plid"><?php _e('You Tube Playlist ID',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" id="plid" name="plid" class="form-control" placeholder="<?php _e('Enter Playlist ID',CDLZR_PLUG_YTUBE_DOM); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="plname"><?php _e('Playlist Name',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" id="plname" name="plname" class="form-control" placeholder="<?php _e('Enter Playlist Name',CDLZR_PLUG_YTUBE_DOM); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="rbname"><?php _e('Ribbon Text',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="text" id="rbname" name="rbname" class="form-control" placeholder="<?php _e('Enter Ribbon Text',CDLZR_PLUG_YTUBE_DOM); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="pldate"><?php _e('Date',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<input type="date" id="pldate" name="pldate" class="form-control" value="<?php echo date("Y-m-d"); ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="plstat"><?php _e('Status',CDLZR_PLUG_YTUBE_DOM); ?></label>
						<select name="plstat" id="plstat" class="form-control">
							<option value="1"><?php _e('Active',CDLZR_PLUG_YTUBE_DOM); ?></option>							
							<option value="0"><?php _e('Deactive',CDLZR_PLUG_YTUBE_DOM); ?></option>
						</select>	
					</div>
					<div class="form-group col-md-3" style="margin-top:30px;">
						<button id="btn_yt_save" class="btn btn-success"><?php _e('Save',CDLZR_PLUG_YTUBE_DOM); ?> <i class="far fa-save"></i></button>
					</div>	
				</div>
			</form>	
		</div>
	</section>

	<section id="savedidkeylist">
		<div class="container-fluid">
			<div class="row">
				<div class="col mt-2 mb-2">
					<h5><?php _e('Setting List',CDLZR_PLUG_YTUBE_DOM); ?></h5>
				</div>
			</div>
			<div class="row">
				<div class="col table-responsive">
					<table class="table table-stripped" id="bookedroomlistTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?php _e('Channel ID',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('You Tube API KEY',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('You Tube Playlist ID',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Playlist Name',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Ribbon',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Date',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Status',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Edit',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Shortcode',CDLZR_PLUG_YTUBE_DOM); ?></th>					
								<th><?php _e('Copy',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Setting',CDLZR_PLUG_YTUBE_DOM); ?></th>
								<th><?php _e('Delete',CDLZR_PLUG_YTUBE_DOM); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$table_name = $wpdb->prefix . "ytube_setting";
								$query 		= "SELECT * FROM `$table_name`";
								$result 	= $wpdb->get_results($query);

								function exep_str($str,$start_pos,$last_pos){
									echo substr($str,$start_pos,$last_pos)."....";
								}

								$sn=1;
								foreach ($result as $res ) {
									 $ytid 		= $res->id;
									 $start_pos = 0;
									 $last_pos 	= 20;
									?>
										<tr>
											<td><?php echo $sn ; ?></td>
											<td><?php exep_str($res->channel_id,$start_pos,$last_pos); ?></td>
											<td><?php exep_str($res->yt_api_key,$start_pos,$last_pos); ?></td>
											<td><?php exep_str($res->yt_playlist_id,$start_pos,$last_pos); ?></td>
											<td><?php echo $res->yt_playlist_name; ?></td>
											<td><?php echo $res->yt_ribbon_name; ?></td>
											<td><?php echo $res->yt_date; ?></td>
											<td><?php if($res->status == "1"){ ?><i class="fas fa-check-square" style="color:green;font-size:40px;"></i><?php }else{ ?><i class="fas fa-window-close" style="color:red;font-size:40px;"></i><?php } ?></td>
											<td><button  type="button" class="btn btn-info get_data_editidkey" data-toggle="modal" data-target="#YTModal" data-id="<?php echo $res->id; ?>"><i class="fas fa-edit" style="font-size:20px;"></i></button></td>
											<td id="inptxt_<?php echo $ytid; ?>">[<?php echo 'cdlzr_ytplyr'.' id="'.$ytid.'"' ?>]</td>
											<td><button type="button" id="copy_short_<?php echo $ytid; ?>" class="btn btn-warning copy_short" title="Copy Shortcode" data-scode='<?php echo $ytid; ?>'  data-clipboard-target="#inptxt_<?php echo $ytid; ?>"><i class="fas fa-copy"></i></button></td>
											<td><button type="button" class="btn btn-secondary get_data_setting" data-toggle="modal" data-target="#cdlzr_theme_modal_xl" data-id="<?php echo $res->id; ?>"><i class="fas fa-cog" style="font-size:20px;"></i></button></td>
											<td><button type="button" class="btn btn-danger delete_setting" data-id="<?php echo $res->id; ?>"><i class="fas fa-trash" style="font-size:20px;"></i></button></td>
										</tr>
									<?php									
								$sn++;
							}//end foreach loop
							?>
						</tbody>
					</table>
					<div id="snackbar">Copied <i class="fas fa-copy"></i></div>
					<!--Modal for edit api key and data-->
					<div class="modal fade" id="YTModal" tabindex="-1" role="dialog" aria-labelledby="YTModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="YTModalLabel"><?php _e('Edit Data',CDLZR_PLUG_YTUBE_DOM); ?></h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="row modal-body edit_yt_form">
					        <div class="form-group col-md-3">
								<label for="edit_chid"><?php _e('Channel ID',CDLZR_PLUG_YTUBE_DOM); ?></label>
								<input type="text" id="edit_chid" name="edit_chid" class="form-control" placeholder="<?php _e('Enter Channel ID',CDLZR_PLUG_YTUBE_DOM); ?>">
							</div>
							<div class="form-group col-md-3">
								<label for="edit_apikey"><?php _e('You Tube API KEY',CDLZR_PLUG_YTUBE_DOM); ?></label>
								<input type="text" id="edit_apikey" name="edit_apikey" class="form-control" placeholder="<?php _e('Enter API KEY',CDLZR_PLUG_YTUBE_DOM); ?>">
							</div>
							<div class="form-group col-md-3">
								<label for="edit_plid"><?php _e('You Tube Playlist ID',CDLZR_PLUG_YTUBE_DOM); ?></label>
								<input type="text" id="edit_plid" name="edit_plid" class="form-control" placeholder="<?php _e('Enter Playlist ID',CDLZR_PLUG_YTUBE_DOM); ?>">
							</div>
							<div class="form-group col-md-3">
								<label for="edit_plname"><?php _e('Playlist Name',CDLZR_PLUG_YTUBE_DOM); ?></label>
								<input type="text" id="edit_plname" name="edit_plname" class="form-control" placeholder="<?php _e('Enter Playlist Name',CDLZR_PLUG_YTUBE_DOM); ?>">
							</div>
							<div class="form-group col-md-3">
								<label for="edit_rbname"><?php _e('Ribbon Text',CDLZR_PLUG_YTUBE_DOM); ?></label>
								<input type="text" id="edit_rbname" name="edit_rbname" class="form-control" placeholder="<?php _e('Enter Ribbon Text',CDLZR_PLUG_YTUBE_DOM); ?>">
							</div>
							<div class="form-group col-md-3">
								<label for="edit_plstat"><?php _e('Status',CDLZR_PLUG_YTUBE_DOM); ?></label>
								<select name="edit_plstat" id="edit_plstat" class="form-control">
									<option value="1"><?php _e('Active',CDLZR_PLUG_YTUBE_DOM); ?></option>							
									<option value="0"><?php _e('Deactive',CDLZR_PLUG_YTUBE_DOM); ?></option>
								</select>	
							</div>
					      </div>
					      <div class="modal-footer">
					      	<?php
					      		/* Create Nonce */
    							$yt_edit_nonce = wp_create_nonce( 'yt-edit-nonce' );
					      	?>					      
					        <button data-id="" data-ytnonce="<?php echo esc_attr( $yt_edit_nonce ); ?>" type="button" class="btn btn-primary upd_yt_btn"><?php _e('Update',CDLZR_PLUG_YTUBE_DOM); ?></button>
					      </div>
					    </div>
					  </div>
					</div>

					<div class="modal right fade" id="cdlzr_theme_modal_xl" tabindex="-1" role="dialog" aria-labelledby="cdlzr_theme_modal_xl">
						<div class="modal-dialog modal-xl" role="document">
							<div class="modal-content">
								<div class="modal-header mt-3">
									<h5 class="modal-title">Setting for player</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body">
									<div class="row">
										<div class="col-md-4">
											<label for="yt_title"><?php _e('Title',CDLZR_PLUG_YTUBE_DOM); ?></label>
											<input type="text" name="yt_title" id="yt_title" value="" class="form-control" placeholder="Enter Title">
										</div>
										<div class="col-md-4">
											<label for="yt_playlist_height"><?php _e('Playlist Height (between 400 and 800)',CDLZR_PLUG_YTUBE_DOM); ?></label>
  											<input type="range" id="yt_playlist_height" name="yt_playlist_height" min="400" max="800" value="438">
  											<input type="text" id="textInput" value="438 PX" readonly>
										</div>
										<div class="col-md-4">
											<label for="yt_video_limit"><?php _e('Video Limit Number',CDLZR_PLUG_YTUBE_DOM); ?></label>
  											<input type="range" id="yt_video_limit" name="yt_video_limit" min="1" max="30" value="5">
  											<input type="text" id="textInputvid" value="5 Video" readonly>
										</div>
										<div class="col-md-4 mt-4">
											<label for="yt_theme_a"><?php _e('Player Theme',CDLZR_PLUG_YTUBE_DOM); ?></label>
											<br><input type="radio" id="yt_theme_a" name="yt_theme" value="yt_theme_a" checked><label for="html">THEME A</label><br><input type="radio" id="yt_theme_b" name="yt_theme" value="yt_theme_b"><label for="yt_theme_b">THEME B</label><br><input type="radio" id="yt_theme_c" name="yt_theme" value="yt_theme_c"><label for="yt_theme_c">THEME C - YouTube Shorts</label><br><input type="radio" id="yt_theme_d" name="yt_theme" value="yt_theme_d"><label for="yt_theme_d">THEME D - YouTube Slider Gallery</label></br><span><b>Note : </b>THEME A,B,D based on playlist id,</br> Theme C based on channel id</span></div>
										<div class="col-md-8 mt-4 mb-4">
											<h6>Subscriber Button Setting</h6>
											<input type="checkbox" name="yt_subsc_btn" id="yt_subsc_btn" value="1">
											<label for="yt_subsc_btn"><?php _e('Enable Button',CDLZR_PLUG_YTUBE_DOM); ?></label>
											<input type="checkbox" name="yt_subsc_layout" id="yt_subsc_layout" value="1">
											<label for="yt_subsc_layout"><?php _e('Enable Full Layout',CDLZR_PLUG_YTUBE_DOM); ?></label>
											<input type="checkbox" name="yt_subsc_theme" id="yt_subsc_theme" value="1">
											<label for="yt_subsc_theme"><?php _e('Enable Dark Theme',CDLZR_PLUG_YTUBE_DOM); ?></label>
											<input type="checkbox" name="yt_subsc_count" id="yt_subsc_count" value="1">
											<label for="yt_subsc_count"><?php _e('Hide Subscribe Count',CDLZR_PLUG_YTUBE_DOM); ?></label>
										</div>
										<div class="col-md-12 mt-2">
											<label for="cust_css_yt"><?php _e('Custom CSS',CDLZR_PLUG_YTUBE_DOM); ?></label>
											<textarea id="yt_custcss" name="yt_custcss" class="lined" rows="9" cols="150"></textarea>
											<input type="hidden" name="yt_settingid" id="yt_settingid" value="">
											<button class="btn btn-primary mt-2 float-right savesetting_btn">Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>		
					</div>
				</div>
			</div>
		</div>
	</section>
</div>