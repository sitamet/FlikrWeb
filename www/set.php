<?php

require('../code/main.inc.php'); 
include('../code/mobileDetect.inc.php');
require('../code/phpFlickr/phpFlickr.php'); // phpflickr

$detect = new Mobile_Detect();
$is_mobile = $detect->isMobile();

$f = new phpFlickr(FLICKR_API_KEY); // the api key
$f->enableCache($type='fs', FS_CACHE, FLICKR_CACHE_EXPIRE);

$set_id = strip_tags($_REQUEST['id']);


$js_photos_obj = array();
$photos_array = array();
$page_title = 'Empty photo stream';

$photo_size_thumb_label = ($is_mobile? 'Square':'Medium');
$photo_size_large_label = getLargePhotoLabel();  // depending on window size

if ($photo_set = $f->photosets_getInfo($set_id)) {

  $page_title = $photo_set['title'];
  $page_descr = $photo_set['description'];

  $photos = $f->photosets_getPhotos($set_id);

  foreach ($photos['photoset']['photo'] as $photo) {

    $id = $photo['id'];

    $url_thumb = $f->buildPhotoURL($photo, $photo_size_thumb_label);
    $url_large = $f->buildPhotoURL($photo, $photo_size_large_label);

    $js_photos_obj[] = "{ url: '".$url_large."', caption: '".addslashes($photo['title'])."'}";
    $photos_array[$id] = array(
      'url_thumb' => $url_thumb,
      'url_large' => $url_large,
      'title' => $photo['title'],
    );
  }

}

include('../templates/header.inc.php');

?>
<div id="ps-set_<?php echo $set_id ?>" data-role="page" data-fullscreen="false" class="ps-set" >
  <div data-role="header" id="Header" class="ps-toolbar">
    <h1 id="title"><?php echo $page_title ?></h1>
    <div class="ps-toolbar-play"><a href="#" id="ps-playslideshow"><div class="ps-toolbar-content"></div></a></div>
    <div class="ps-toolbar-close"><a href="<?php echo HTTP_WEB ?>" data-rel="back"><div class="ps-toolbar-content"></div></a></div>
  </div>

  <div data-role="content" class="page-content" data-theme="c">
    <ul class="gallery">
  <?php
    reset($photos_array);
    $i=0;
    while(list($photo_id,$photo)=each($photos_array)) {
      $i++;
      echo '<li'.(($i&1)? ' class="first"':'').'><a href="'.prepareForUrl($photo['title']).'-photo-'.$photo_id.'" title="'.$photo['url_title'].'" data-src="'.$photo['url_large'].'"><img src="'.$photo['url_thumb'].'" alt="'.$photo['title'].'" /></a></li>'."\n";
    }
    ?>
    </ul>
  </div>

<?php
include('../templates/footer.inc.php');
?>