<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

extract(shortcode_atts(array(
				'id'=>'1'
			),$paras));

$table_name = $wpdb->prefix . "ytube_singviddata";
$array_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `$table_name` WHERE `id`=%d",$id ));

$sv_array       = json_decode(json_encode($array_data), true);
$unser_arr      = unserialize($sv_array['singvid_arr']);
$sv_plid        =  $unser_arr['sv_plid'];
$sv_plvidid     =  $unser_arr['sv_plvidid'];  
$apikey_singvid =  $unser_arr['apikey_singvid'];

if(isset($unser_arr['sv_plvidttle'])){
	$sing_plttle    =  $unser_arr['sv_plvidttle'];
}else{
	$sing_plttle    =  "";
}

$api_url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$sv_plid."&key=".$apikey_singvid."&maxResults=1";
//$data = json_decode(file_get_contents($api_url));
?>
<div class="container">

    <div class="row" style="margin-top:50px;">
      <div class="col-xs-12 col-md-8 col-sm-8 cdlzr_video-container yt_player">
      	<h2 class="mb-2"><?php echo $sing_plttle; ?></h2>
        <?php
          if($sv_plid == "vimeo"){
            ?>
                <iframe width="100%" height="450px" src="https://player.vimeo.com/video/<?php echo $sv_plvidid; ?>" frameborder="0" allowfullscreen="">
        </iframe>
            <?php
          }else{
            ?>
                <iframe width="100%" height="450px" src="https://www.youtube.com/embed/<?php echo $sv_plvidid; ?>" frameborder="0" allowfullscreen="">
        </iframe>
            <?php
          }
        ?>
    
        <h2 class="cdlzr_video-title"></h2>			
      </div>
    </div>
</div>
<style type="text/css">
	.yt_player {
    border: 15px solid #eee;
    border-radius: 5px;
    background: #eee;
}
</style>