<?php
defined( 'ABSPATH' ) or die();
global $wpdb;

extract(shortcode_atts(array(
				'id'=>'1'
			),$paras));

$table_name = $wpdb->prefix . "ytube_setting";
$array_data = $wpdb->get_row( $wpdb->prepare( "SELECT `id`,`channel_id`,`yt_api_key`,`yt_playlist_id`,`yt_playlist_name`,`yt_ribbon_name`,`status` FROM `$table_name` WHERE `id`=%d",$id ) );

$get_yid      =  $array_data->id; 
$get_chid     =  $array_data->channel_id;
$get_apikey   =  $array_data->yt_api_key;
$get_plid     =  $array_data->yt_playlist_id;
$get_plname   =  $array_data->yt_playlist_name;
$get_rbname   =  $array_data->yt_ribbon_name;
$get_plstat   =  $array_data->status;

$table_name_setting = $wpdb->prefix . "ytube_themedata";
$rowcount = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name_setting WHERE `postid_ytube`=%d",$id ) );

if($rowcount>0){
    $result = $wpdb->get_row( $wpdb->prepare( "SELECT `theme_arr` FROM `$table_name_setting` WHERE `postid_ytube`=%d",$id ) );
    $upd_themedataget = unserialize($result->theme_arr); 
    $yt_subsc_btn      = $upd_themedataget['yt_subsc_btn'];
    $yt_subsc_layout   = $upd_themedataget['yt_subsc_layout'];
    $yt_subsc_theme    = $upd_themedataget['yt_subsc_theme'];
    $yt_subsc_count    = $upd_themedataget['yt_subsc_count'];
    $yt_theme          = $upd_themedataget['yt_theme'];
    $yt_playlist_height = $upd_themedataget['yt_playlist_height'];
    $yt_video_limit     = $upd_themedataget['yt_video_limit'];
    $yt_title           = $upd_themedataget['yt_title'];
    $yt_custcss         = $upd_themedataget['yt_custcss'];
}else{
  $yt_theme           = "yt_theme_a";
  $yt_playlist_height = "438px";
  $yt_custcss         = "";
  $yt_title           = get_the_title();
}


 if($yt_theme == "yt_theme_a" && $get_plid && $get_apikey){
  $api_url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$get_plid."&key=".$get_apikey."&maxResults=".$yt_video_limit;
  $data = json_decode(file_get_contents($api_url));
?>
<div class="container">
    <div class="row" style="margin-top:50px;">
      <div class="col-md-12">        
        <?php
          if(isset($upd_themedataget['yt_title'])){
            ?>
            <h3><?php echo $yt_title = $upd_themedataget['yt_title']; ?></h3>
            <?php            
          }else{
            echo $yt_title = "";
          }
       ?>
      </div>
    
      <div class="col-xs-12 col-md-8 col-sm-8 cdlzr_video-container">
        <iframe width="100%" height="450px" src="https://www.youtube.com/embed/<?php echo $data->items[0]->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen="">
        </iframe>

        <?php if($rowcount>0){ if($yt_subsc_btn=="true" ): ?>
          <div class="ytsubscribe_container <?php echo $yt_subsc_theme; ?>_theme">
            <script src="https://apis.google.com/js/platform.js"></script>
            <div class="g-ytsubscribe" data-channelid="<?php echo $get_chid; ?>" data-layout="<?php echo $yt_subsc_layout; ?>" data-theme="<?php echo $yt_subsc_theme; ?>" data-count="<?php echo $yt_subsc_count; ?>">
            </div>
          </div>
        <?php endif; } ?>  
        <h2 class="cdlzr_video-title"></h2>			
      </div>
       
        <div class="col-xs-12 col-md-4 col-sm-4 box" style="padding: 0px;">
          <?php
            if($get_rbname!=""){
              ?>
                <div class="cdlzr_ribbon cdlzr_ribbon-top-right"><span><?php echo $get_rbname; ?></span></div>
              <?php
            }
          ?>        	
            <ul id="style-6" class="cdlzr_playlist_flow">
                <?php
                    foreach ($data->items as $video) {                         
                        $title       = $video->snippet->title;
                        $description = $video->snippet->description;
                        $thumbnail   = $video->snippet->thumbnails->high->url;
                        $videoId     = $video->snippet->resourceId->videoId;
                        $date        = $video->snippet->publishedAt;                    
                ?>
                <li class="cdlzr_list_video">
                    <span style="cursor: pointer;margin-bottom: 10px;" onclick="switchVideo('<?php echo $videoId; ?>')">
                        <div class="row" id="cdlzr_vid-<?php echo $videoId; ?>" style="padding-right: 0px;padding-top: 10px;padding-bottom: 10px;border-bottom: 1px solid white;">
                            <div class="cdlzr_image col-md-12 col-xs-12 col-lg-12">
                                <img class="cdlzr_thumb_vid" src="https://i.ytimg.com/vi/<?php echo $videoId; ?>/hqdefault.jpg">								              
                            </div>
                            <div class="col-md-12 col-xs-12 col-lg-12">
                                <p class="cdlzr_video-thumb-title"><?php echo $title; ?><p>
                                <p style="margin-bottom: 10px;" class="cdlzr_date"><?php echo date('M j, Y',strtotime($date)); ?></p>
                            </div>
                        </div>
                    </span>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">    
  jQuery("#cdlzr_vid-<?php echo $data->items[0]->snippet->resourceId->videoId; ?>").addClass('selected');

  function switchVideo( videoId ){
      jQuery(".cdlzr_video-container iframe").attr('src','https://www.youtube.com/embed/'+videoId);
      jQuery(".selected").removeClass('selected');
      jQuery("#cdlzr_vid-"+videoId).addClass('selected'); 
  }
</script>
<?php }

if($yt_theme == "yt_theme_b"){
  ?>    
    <script>
        jQuery(function($){
            jQuery('#youtube').spidochetube({
                key         : '<?=$get_apikey?>',
                id          : '<?=$get_plid?>',
                max_results : 8,
				        paging      : 5,
                <?php if($yt_theme == "yt_theme_b"){
                  ?> 
                    theme       :'dark',
                  <?php
                } ?>
				      
                complete    : function(){
                    // Initialize the scroll plugin after the playlist is ready
                    jQuery('#spidochetube_list').niceScroll({
                        cursorcolor  : '#666',
                        cursorborder : '0px solid #fff',
                        autohidemode : false
                    });
                }
            });
        });
        
    </script>
    <div id="youtube" class="spidochetube cdlzr_youtube"></div>
  <?php
}

if($yt_theme == "yt_theme_c"){
  ?> 
 <style>
  .swiper {
    width: 100%;
    height: 100%;
  }

  .swiper.mySwiper{
      width: 390px !important;      
  }
  .swiper-wrapper{
    height: 600px !important;
  }
  .swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #000;

    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
  }

  .swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .swiper-pagination.swiper-pagination-fraction.swiper-pagination-horizontal {       
      color: wheat;
      font-weight: 600;
      background: black;
      padding: 10px;
  }

  .cdlzr_video-container embed, iframe, object {
      border: 5px solid #272a2c;       
  }
  .swiper-button-next, .swiper-rtl .swiper-button-prev {        
      color: #f44336;
  }
  .swiper-button-prev, .swiper-rtl .swiper-button-next{
    color: #f44336;
  }
  .swiper-pagination.swiper-pagination-fraction.swiper-pagination-horizontal {
      color: #f44336;
      font-weight: 600;
      background: black;
      padding: 14px;
  }
</style>

 <?php
 //$Max_Results = 30; 
   
 // Get videos from channel by YouTube Data API 
 $apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$get_chid.'&maxResults='.$yt_video_limit.'&key='.$get_apikey.''); 
 if($apiData){ 
     $videoList = json_decode($apiData); 
 }else{ 
     echo 'Invalid API key or channel ID.'; 
 }
 
 function YoutubeVideoInfo($video_id) {
 
   $url = 'https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key=AIzaSyCeGAQoVO3DyMv89spT2YFCxLe5UiShukk&part=snippet,contentDetails';
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   $response = curl_exec($ch);
   curl_close($ch);
   $response_a = json_decode($response);
   if(isset($response_a->items)){
    return $response_a->items[0]->contentDetails->duration; //get video duaration 
   }else{
    return "";
   }
   
 }
 
 if(!empty($videoList->items)){ 
   ?>
     <div class="swiper mySwiper">
      <h2><?php echo $yt_title; ?></h2>
        <div class="swiper-wrapper">
             <?php
               foreach($videoList->items as $item){ 
                   // Embed video 
                   if(isset($item->id->videoId)){       
             
                     $vid_word = YoutubeVideoInfo($item->id->videoId);
                     
                     if(strpos($vid_word, "M") == false){
               
                     $shortvidid = "https://www.youtube.com/embed/".$item->id->videoId;
                     $shortvidimg = "http://i3.ytimg.com/vi/".$item->id->videoId."/sddefault.jpg";       
                     ?>

                           <div class="swiper-slide">
                               <iframe class="swiper-slide" src="<?php echo $shortvidid; ?>" height="200" width="180"></iframe>
                           </div> 
                     <?php 
                     }      
                       
                   } 
               } 
             ?>
           </div>  
           <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>  
          <script>
            jQuery(document).ready( function () {
    var swiper = new Swiper(".mySwiper", {
        pagination: {
          el: ".swiper-pagination",
          type: "fraction",
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
});
          </script>    
   <?php
 }else{ 
   echo '<p class="error">'.$apiError.'</p>'; 
 } 
} 

if($yt_theme == "yt_theme_d"){
  $api_url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$get_plid."&key=".$get_apikey."&maxResults=".$yt_video_limit;
  $data = json_decode(file_get_contents($api_url));
  ?>
  <div style="max-width: 730px; margin:0px auto">    
    
     <container class="vid-main-wrapper clearfix">
     <h2><?php echo $yt_title; ?></h2>
      <!-- THE YOUTUBE PLAYER -->
      <div class="vid-container">
        <iframe id="vid_frame" src="https://www.youtube.com/embed/<?php echo $data->items[0]->snippet->resourceId->videoId; ?>?rel=0&showinfo=0&autohide=1&autoplay=1" frameborder="0" width="730" height="315" allow="autoplay" allowfullscreen></iframe>
      </div>
    </container>

  <section id="extra wrapper" style="position: relative; padding-right: 32px; padding-left: 32px; background: #f6f6f6;">

    <!-- CUSTOM ARROWS -->
    <button title="Next" class="swiper-custom-next" style="position: absolute; padding: 10px 2px; right: 1px;top: 32%; z-index: 100;
    display: inline-block;cursor: pointer;">     
      <svg style="position: relative; top: 1px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g class="nc-icon-wrapper" fill="#111111"><polygon fill="#111111" points="4.9,15.7 3.4,14.3 9.7,8 3.4,1.7 4.9,0.3 12.6,8 "></polygon></g></svg>
    </button>
    <button title="Prev" class="swiper-custom-prev" style="position: absolute; padding: 10px 2px; left: 2px; top: 35%; z-index: 100;
    display: inline-block;cursor: pointer;font-size: 15px;">
     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g class="nc-icon-wrapper" fill="#111111"><polygon fill="#111111" points="11.1,15.7 3.4,8 11.1,0.3 12.6,1.7 6.3,8 12.6,14.3 "></polygon></g></svg>
    </button>

    <!-- Swiper -->
    <nav class="swiper swiper-container-videos slider-produtos-destaque">
      <ol class="swiper-wrapper" style="list-style-type: none; padding: 0px;">
        <?php
            foreach ($data->items as $video) {                         
                $title       = $video->snippet->title;
                $description = $video->snippet->description;
                $thumbnail   = $video->snippet->thumbnails->high->url;
                $videoId     = $video->snippet->resourceId->videoId;
                $date        = $video->snippet->publishedAt;                    
          ?>
        <li class="swiper-slide">
          <a class="" href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://youtube.com/embed/<?php echo $videoId; ?>?autoplay=1&rel=0&showinfo=0&autohide=1'">
          <span class="vid-thumb">
     <img src="https://img.youtube.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" />
        </span>
                  <p class="desc"><?php echo $title; ?></p>
                </a>
        </li>
        <?php } ?>        
      </ol>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
      <!-- If we need navigation buttons -->
    </nav>
  </section>  
</div>
<style>  
/* ####################################
           SITON STYLES 
####################################### */

.swiper-custom-next.swiper-button-disabled,
.swiper-custom-prev.swiper-button-disabled
{
  opacity: 0.2;
  
}

/* Zoom In on hover */
.vid-thumb {
	overflow: hidden;
  display: block;
  width: auto;
}

.vid-thumb img{
   display: block;
}

.swiper-slide:hover .desc{
  margin: 0px;
  padding: 0px;
  text-decoration: underline;
}

.vid-thumb img {
	-webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.vid-thumb:hover img {
	-webkit-transform: scale(1.08);
	transform: scale(1.08);
}

/* #####################
      SWIPER STYLES
#######################*/
.swiper-container-videos .swiper-pagination.swiper-pagination-clickable.swiper-pagination-bullets {
  position: relative;
  top: 0px;
}

.swiper-container-videos .swiper-slide a {
  text-decoration: none;
  font-size: 14px;
  color: #1f2f3c;
}
@media only screen and (max-width: 800px) {
  .swiper-container-videos .swiper-slide a {
    font-size: 11px;
    line-height: 14px;
  }
}
.swiper-container-videos  .selected.swiper-slide a .desc {
  color: #721e2e;
  font-weight: bold;
}
.swiper-container-videos  .selected {
  border-bottom: 1px solid #c4c4c4;
}
/*  
slidesPerView: "auto" so the width of each slide set by CSS */
.swiper-container-videos .swiper-slide {
  max-width: auto;
  width: 36%;
  text-align: center;
  font-size: 18px;
  background: #fff;
}

.swiper-container-videos .swiper-slide a .desc {
  margin-top: 3px;
  margin-bottom: 3px;
}

.swiper-container-videos .swiper-slide img {
  height: auto;
  width: 100%;
}

.swiper-pagination-bullet-active {
    background: #b4234c;
}
.swiper-pagination-bullet {
    width: 12px;
    height: 12px;
}
</style>
<script>
  /* webflow only this section swiper pagination */
jQuery(document).ready(function() {
  /* add html by js (no way to add this HTML by webflow UI beacuse this is CMS list*/
  var part1 = "<div class=swiper-pagination></div>";
  //  var part2 = '<div class="swiper-button-prev"></div>';
  //var part3 = '<div class="swiper-button-next"></div>';
  // var swiperString = part1.concat(part2, part3);
  jQuery("#swiper-press").append(part1);

/* change active class when click */
jQuery(".swiper-container-videos .swiper-wrapper .swiper-slide a").click(function() {
  jQuery(this)
    .closest(".swiper-slide")
    .addClass("selected")
    .siblings()
    .removeClass("selected");
  mySwiper1.slideTo(mySwiper1.clickedIndex);
});

jQuery(".swiper-container-videos .swiper-slide")
  .first()
  .addClass("selected");

/* 1 of 2 : SWIPER */
var mySwiper1 = new Swiper(".swiper-container-videos", {
  // If loop true set photoswipe - counterEl: false
  loop: false,
  /* slidesPerView || auto - if you want to set width by css like flickity.js layout - in this case width:80% by CSS */
  slidesPerView: "auto",
  spaceBetween: 15,
  centeredSlides: false,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  navigation: {
    nextEl: ".swiper-custom-next",
    prevEl: ".swiper-custom-prev"
  },

  keyboard: {
    enabled: true,
    onlyInViewport: true
  }
});
jQuery(".vid-container").fitVids();

  jQuery(".vid-item").each(function(index) {
    jQuery(this).on("click", function() {
      var current_index = index + 1;
      jQuery(".vid-item .thumb").removeClass("active");
      jQuery(".vid-item:nth-child(" + current_index + ") .thumb").addClass("active");
    });
  });
});
</script>

  <?php
}// end of theme d
?>
<style type="text/css">
  <?php
      echo $yt_custcss;
  ?>

  .dark_theme{
    padding: 8px; 
    background: rgb(85, 85, 85);
  }
  
.cdlzr_playlist_flow {
    height: <?php echo $yt_playlist_height; ?>px;       
}
</style>