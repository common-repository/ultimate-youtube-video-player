jQuery(document).ready( function () {	
        
   jQuery('#yt_playlist_height').on('change', function(e){
  	e.preventDefault();
  		var yt_playlist_height = jQuery('#yt_playlist_height').val();
  		jQuery('#textInput').val(yt_playlist_height+" PX");
  	}); 
	
	  jQuery('#yt_video_limit').on('change', function(e){
		e.preventDefault();
			var yt_video_limit = jQuery('#yt_video_limit').val();
			jQuery('#textInputvid').val(yt_video_limit+" Video");
		});      
  

  jQuery('#addytsetform').on('submit', function(e){
  	e.preventDefault();
	jQuery.ajax({
		method: 'post',
		url: ajaxurl + "?action=addidkey",
		data: new FormData(this),
		contentType: false,
		processData: false,
		success: function(youtube_save_key) {
			var result = jQuery.parseJSON(youtube_save_key);
			if( result.success_msg == 1 ) {
				alert('Record added successfully');
				location.reload(true);				
			}
			else {
				
				alert('For add more data - This feature in pro version');
				location.reload(true);	
			}
		}
	});
  });

  jQuery('#singlevideolistTable').DataTable();
  

   jQuery('.get_data_editidkey').on('click', function(e){
  	e.preventDefault();
	var yid = jQuery(this).attr('data-id');
	jQuery.ajax({
		type: 'post',
		dataType:'json',
		url: ajaxurl,
		data:{
			action:"getytdata",
			yid:yid
		},
		success: function(response){
			jQuery('.upd_yt_btn').data('id',response.take_yid)			
			jQuery('#edit_chid').val(response.take_chid);
			jQuery('#edit_apikey').val(response.take_apikey);
			jQuery('#edit_plid').val(response.take_plid);
			jQuery('#edit_plname').val(response.take_plname);
			jQuery('#edit_rbname').val(response.take_rbname);			
			jQuery('#edit_plstat option[value="'+response.take_plstat+'"]').attr("selected", "selected");
		}
	});
  });

  jQuery('.upd_yt_btn').on('click', function(e){
  	e.preventDefault();
  	var get_chid 	= jQuery('#edit_chid').val();
  	var get_apikey 	= jQuery('#edit_apikey').val();
  	var get_plid 	= jQuery('#edit_plid').val();
  	var get_plname 	= jQuery('#edit_plname').val();
  	var get_rbname 	= jQuery('#edit_rbname').val();
  	var get_plstat 	= jQuery('#edit_plstat').val();
  	var get_yid 	= jQuery(this).data('id');  

  	jQuery.ajax({
		type: 'post',
		dataType:'json',
		url: ajaxurl,
		data:{
			action:"updateytval",
			nonce_yt_data : jQuery('.upd_yt_btn').data('ytnonce'),
			get_yid:get_yid,
			get_chid:get_chid,
			get_apikey:get_apikey,
			get_plid:get_plid,
			get_plname:get_plname,
			get_rbname:get_rbname,
			get_plstat:get_plstat
		},
		success: function(response){
			if(response.success_msg == "1"){
				alert("Successfully Updated.");
				location.reload(true);
			}else{
				alert("Please try after some time.");
			}
		}
	});
  });

  jQuery('.copy_short').on('click', function(e){
  	e.preventDefault();
  	var cid = jQuery(this).data('scode');  	
  	var clipboard = new ClipboardJS('#copy_short_'+cid);

	clipboard.on('success', function(e) {
	    console.info('Action:', e.action);
	    var x = document.getElementById("snackbar");
  		x.className = "show";
  		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	    e.clearSelection();
	});

	clipboard.on('error', function(e) {
	    console.error('Action:', e.action);	    
	});
  }); 

  jQuery('#sv_plid').on('change', function(e){
  	e.preventDefault();
  	var sv_plid 	= jQuery('#sv_plid option:selected').val();
	if( sv_plid == "vimeo"){
		jQuery('#sv_plvidid').hide();
		jQuery('#sv_plid_vimeo').show();
	}else{
		jQuery('#sv_plvidid').show();
		jQuery('#sv_plid_vimeo').hide();
		//console.log(sv_plid);
			jQuery('#sv_plvidid').find('option').remove();	
			jQuery.ajax({
			type: 'post',
			dataType:'json',
			url: ajaxurl,
			data:{
				action:"singytvidplid",			
				sv_plid:sv_plid			
			},
			success: function(response){
				var total_vid    = response.take_totalvideos;
				var thumb_data   = response.take_data_video;
				var get_apikey   = response.take_apikey;
				jQuery('#api_singvid').val(get_apikey);			
				var i;
				for (i = 0; i < total_vid; i++) {	
					var vid_title = thumb_data['items'][i]['snippet']['title'];	
					var vid_id    = thumb_data['items'][i]['snippet']['resourceId']['videoId'];					
					jQuery('#sv_plvidid').append(jQuery("<option></option>").attr("value", vid_id).text(vid_title));							 
				}
			}
		});
	} 
  }); 

   jQuery('#singvidytform').on('submit', function(e){
  	e.preventDefault();
	jQuery.ajax({
		method: 'post',
		url: ajaxurl + "?action=savesingvid",
		data: new FormData(this),
		contentType: false,
		processData: false,
		success: function(youtube_save_sv) {
			var result = jQuery.parseJSON(youtube_save_sv);
			if( result.success_msg == 1 ) {
				alert('Saved successfully');
				location.reload(true);				
			}			
		}
	});
  });

  jQuery('.get_data_delsingvid').on('click', function(e){
  	e.preventDefault();
	var del_singvid_yid = jQuery(this).attr('data-id');	
	var conf = confirm("Are you sure ?");
	if (conf == true) {
		jQuery.ajax({
			type: 'post',
			dataType:'json',
			url: ajaxurl,
			data:{
				action:"delsvytval",
				del_singvid_yid:del_singvid_yid
			},
			success: function(resp_delsv){
				if(resp_delsv['success_msg_delsv']==1){
					alert("Deleted Successfully.");
					location.reload(true);
				}
			}
		});
	}else{
		location.reload(true);
	}
  }); 

   jQuery('.get_data_setting').on('click', function(e){
  	e.preventDefault();
	var yt_settingid = jQuery(this).attr('data-id');		
	jQuery.ajax({
		type: 'post',
		dataType:'json',
		url: ajaxurl,
		data:{
			action:"getsettingid",
			yt_settingid:yt_settingid
		},
		success: function(resp_setting){			
			jQuery('#yt_settingid').val(resp_setting['take_settingid']);
			var yt_settingarr_val = resp_setting.yt_settingarr
		    jQuery('#yt_custcss').val(yt_settingarr_val['yt_custcss']);
		    jQuery('#yt_title').val(yt_settingarr_val['yt_title']);
			var yt_theme_val = yt_settingarr_val['yt_theme'];
		
			jQuery("input[name=yt_theme][value=" + yt_theme_val + "]").prop('checked', true);
			if(yt_theme_val=="yt_theme_a"){
		    	jQuery('#yt_theme_a').prop('checked', true);
		    }
			
			if(yt_theme_val=="yt_theme_b"){
		    	jQuery('#yt_theme_b').prop('checked', true);
		    }
		    
		    if(yt_settingarr_val['yt_subsc_btn']=="true"){
		    	jQuery('#yt_subsc_btn').prop('checked', true);
		    }else{
		    	jQuery('#yt_subsc_btn').prop('checked', false);
		    }

		    if(yt_settingarr_val['yt_subsc_layout']=="full"){
		    	jQuery('#yt_subsc_layout').prop('checked', true);
		    }else{
		    	jQuery('#yt_subsc_layout').prop('checked', false);
		    }

		    if(yt_settingarr_val['yt_subsc_theme']=="dark"){
		    	jQuery('#yt_subsc_theme').prop('checked', true);
		    }else{
		    	jQuery('#yt_subsc_theme').prop('checked', false);
		    }
		    
		    if(yt_settingarr_val['yt_subsc_count']=="hidden"){
		    	jQuery('#yt_subsc_count').prop('checked', true);
		    }else{
		    	jQuery('#yt_subsc_count').prop('checked', false);
		    }

		    if(yt_settingarr_val['yt_playlist_height'] === undefined){
		    	jQuery('#textInput').val(438+" PX");
		    	jQuery('#yt_playlist_height').val(438);
		    }else{
		    	 jQuery('#yt_playlist_height').val(yt_settingarr_val['yt_playlist_height']);
		    	 jQuery('#textInput').val(yt_settingarr_val['yt_playlist_height']+" PX");
		    }	
			if(yt_settingarr_val['yt_video_limit'] === undefined){
		    	jQuery('#textInput').val(438+" PX");
		    	jQuery('#yt_video_limit').val(438);
		    }else{
		    	 jQuery('#yt_video_limit').val(yt_settingarr_val['yt_video_limit']);
		    	 jQuery('#textInputvid').val(yt_settingarr_val['yt_video_limit']+" Video");
		    }   
		    
		}
	});	
  });  

  	/*action - when button click close the modal its reload it*/
	jQuery('.close').on('click', function(e){  
		location.reload(true);	
	});

	/*action when modal is close  - reload it*/
	jQuery('#cdlzr_theme_modal_xl').on('hidden.bs.modal', function () {
		// do something…
		location.reload(true);
	});

	jQuery('.savesetting_btn').on('click', function(e){
  		e.preventDefault();
  		var yt_settingid 			= jQuery('#yt_settingid').val();
  		var yt_custcss 				= jQuery('#yt_custcss').val();
  		var yt_title 				= jQuery('#yt_title').val();
  		var yt_playlist_height 		= jQuery('#yt_playlist_height').val();
		var yt_video_limit 		= jQuery('#yt_video_limit').val();
		var yt_theme				= jQuery("input[name='yt_theme']:checked").val();
		
  		if(jQuery('#yt_subsc_btn').is(':checked')){
  			var yt_subsc_btn    = "true";
  		}else{
  			var yt_subsc_btn    = "false";
  		}

  		if(jQuery('#yt_subsc_layout').is(':checked')){
  			var yt_subsc_layout    = "full";
  		}else{
  			var yt_subsc_layout    = "default";
  		}

  		if(jQuery('#yt_subsc_theme').is(':checked')){
  			var yt_subsc_theme    = "dark";
  		}else{
  			var yt_subsc_theme    = "default";
  		}
      
  		if(jQuery('#yt_subsc_count').is(':checked')){
  			var yt_subsc_count    = "hidden";
  		}else{
  			var yt_subsc_count    = "default";
  		} 		

  		jQuery.ajax({
			type: 'post',
			dataType:'json',
			url: ajaxurl,
			data:{
				action:"savesetting",
				yt_settingid:yt_settingid,
				yt_custcss:yt_custcss,
				yt_title:yt_title,
				yt_subsc_btn:yt_subsc_btn,
				yt_subsc_layout:yt_subsc_layout,
				yt_subsc_theme:yt_subsc_theme,
				yt_subsc_count:yt_subsc_count,		
				yt_playlist_height:yt_playlist_height,
				yt_video_limit:yt_video_limit,
				yt_theme:yt_theme
						
			},
			success: function(resp_setting){
				
				jQuery('#yt_settingid').val(resp_setting['take_settingid']);

				if(resp_setting['key_ins']==1){
					alert("Saved Successfully");
				}else{
					alert("Updated Successfully");
				}

				location.reload(true);
				
			}
		}); 		
  	});	  

  	 /*jQuery(".lined").linedtextarea({
	    selectedLine: 10
	  });	
*/
  	 jQuery('.delete_setting').on('click', function(e){
	  	e.preventDefault();
		var del_yid = jQuery(this).attr('data-id');	
		var conf = confirm("Are you sure ?");
		if (conf == true) {	
			jQuery.ajax({
				type: 'post',
				dataType:'json',
				url: ajaxurl,
				data:{
					action:"delytdata",
					del_yid:del_yid
				},
				success: function(response){
					if(response['success_msg_delst']==1){
						alert("Deleted Successfully.");
						location.reload(true);
					}else{
						alert("Something went wrong.");
						location.reload(true);
					}
				}
			});
		}	
	 });  

     jQuery('#rpvidytform').on('submit', function(e){
		  	e.preventDefault();
				jQuery.ajax({
				method: 'post',
				url: ajaxurl + "?action=saverichvids",
				data: new FormData(this),
				contentType: false,
				processData: false,
				success: function(youtube_save_svr) {
					var result = jQuery.parseJSON(youtube_save_svr);
					if( result.success_msg == 1 ) {
						alert('Saved successfully');
						location.reload(true);				
					}			
				}
			});
		 });

	/*Delete single rich video*/	
	jQuery('.del_sing_ytvid').on('click', function(e){
	  	e.preventDefault();
		var rich_video_id = jQuery(this).attr('data-id');		
		var conf = confirm("Are you sure ?");
		if (conf == true) {	
			jQuery.ajax({
				type: 'post',
				dataType:'json',
				url: ajaxurl,
				data:{
					action:"richdelsingytvideo",
					rich_video_id:rich_video_id
				},
				success: function(response){
					if(response['success_msg_delrsv']==1){
						alert("Deleted Successfully.");
						location.reload(true);
					}else{
						alert("Something went wrong.");
						location.reload(true);
					}
				}
			});
		}	
	 }); 	
});