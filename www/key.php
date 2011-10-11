<?php

require('../code/main.inc.php'); 
require('../code/phpFlickr/phpFlickr.php'); // phpflickr

$image_number = '30';
$keyword = 'Fullscreen'; 

$f = new phpFlickr(FLICKR_API_KEY); // the api key
$f->enableCache($type='fs', FS_CACHE, FLICKR_CACHE_EXPIRE);

$args = array('user_id'=>FLICKR_NSID,'tags'=>$keyword, 'tag_mode'=>'all','per_page'=>$image_number);
$photos = $f->photos_search($args);


$js_photos_obj = array();

$photos_array = array();

foreach ($photos['photo'] as $photo) {

  $id = $photo['id'];  
  $photosize = $f->photos_getSizes($id, $secret = NULL);  

  // assume that largest size comes last:
  $tmp = $photosize[0];
  $url_thumb = $tmp['source'];
  //print_r($photosize);

  $tmp = $photosize[count($photosize)-1];
  $url_large = $tmp['source'];
  $js_photos_obj[] = "{ url: '".$url_large."', caption: '".addslashes($photo['title'])."'}";
  $photos_array[$id] = array(
    'url_thumb' => $url_thumb,
    'url_large' => $url_large,
    'title' => $photo['title'],
  );
}


$page_title = 'Sitamet photo stream';

include('../templates/header.inc.php');

?>
<div data-role="page" data-fullscreen="false" >
  <div data-role="header" id="Header" class="ps-toolbar">
    <h1 id="title"><?php echo $page_title ?></h1>
    <div class="ps-toolbar-play"><a href="#" id="ps-playslideshow"><div class="ps-toolbar-content"></div></a></div>
    <div class="ps-toolbar-close"><a href="<?php echo HTTP_WEB ?>" data-rel="back"><div class="ps-toolbar-content"></div></a></div>
  </div>

  <div data-role="content" class="page-content set" data-theme="c">
    <h2><?php echo $keyword.' flickr gallery' ?></h2>
    <ul class="gallery">
  <?php
    reset($photos_array);
    while(list($photo_id,$photo)=each($photos_array)) {
      echo '<li><a href="'.prepareForUrl($photo['title']).'-photo-'.$photo_id.'" title="'.$photo['url_title'].'"><img src="'.$photo['url_thumb'].'" alt="'.$photo['url_title'].'" /></a></li>'."\n";
    }
    ?>
    </ul>
  </div>

<?php
include('../templates/footer.inc.php');
?>