<?php

require('../code/main.inc.php'); 
include('../code/mobileDetect.inc.php');
require('../code/phpFlickr/phpFlickr.php'); // phpflickr

$page_title = 'Sitamet photo stream';
$back_button = true;

$detect = new Mobile_Detect();
$is_mobile = $detect->isMobile();

$f = new phpFlickr(FLICKR_API_KEY); // the api key
$f->enableCache($type='fs', FS_CACHE, FLICKR_CACHE_EXPIRE);

$photos_url = $f->urls_getUserPhotos(FLICKR_NSID);


$photo_id = strip_tags($_REQUEST['id']);
$photosize = $f->photos_getSizes($photo_id, $secret = NULL);


// lets load an image depending on resolution
$url_large = getLargePhotoUrl($photosize);

$photo = array(
  'url_large' => $url_large,
  'exif' => array()
);

$exif_rsp = $f->photos_getExif($photo_id, $secret = NULL);

if (is_array($exif_rsp)) {

  foreach ($exif_rsp['exif'] as $e) {
    //print_r($e);
    if (in_array($e['tag'], $allowed_exif_tags) && empty($photo['exif'][$e['tag']])) {

      $text = (empty($e['clean']) ? $e['raw'] : $e['clean']);
      $photo['exif'][$e['tag']] = array('label'=> $e['label'],'text' => $text);

    }
  }
}

// place exif info in its correpsonding html place:
$i=0;
foreach($allowed_exif_tags as $exif_tag) {
  if ($photo['exif'][$exif_tag]) {

    $skip_dl = false;
    $text = $photo['exif'][$exif_tag]['text'];
    
    switch($exif_tag) {
      case 'ObjectName':
        $page_title = $text;
        break;

      case 'ImageDescription':
        $page_description = $text;
        $skip_dl = true;
        break;

      case 'Caption-Abstract':
        if ($text=='' || $page_description==$text) $skip_dl = true;
        break;

      case 'Software':
        if ($photo['exif']['CreatorTool']['text']==$text) $skip_dl = true;
        break;

    }

    if (!$skip_dl) {
      $i++;
      $dl_content.= '<dt'.(($i&1)? ' class="first"':'').'>'.$photo['exif'][$exif_tag]['label'].':</dt>'."\n";
      $dl_content.= '<dd'.(($i&1)? ' class="first"':'').'>'.$text.'</dd>'."\n";
    }

  }
}

include('../templates/header.inc.php');

?>
<div data-role="page">
  <div data-role="header" id="Header" class="ps-toolbar">
    <h1 id="title"><?php echo $page_title ?></h1>
    <div class="ps-toolbar-close"><a href="<?php echo HTTP_WEB ?>" data-rel="back"><div class="ps-toolbar-content"></div></a></div>
  </div>

  <div data-role="content" class="page-content photo">
  <?php
  echo '<img src="'.$photo['url_large'].'" style="width:100%" alt="'.$photo['title'].'" />';
  echo '<h2>'.$page_description.'</h2>'."\n";
  echo '<dl class="info">'."\n";
  echo $dl_content;
  echo '<dt>Flickr page:</dt>'."\n";
  echo '<dd><a href="'.$photos_url.$photo_id.'" rel="external">View on Flickr</a></dd>'."\n";
  echo '</dl>';

  ?>
  </div>

<?php
include('../templates/footer.inc.php');
?>