<?php

require('../code/main.inc.php');
include('../code/mobileDetect.inc.php');
require('../code/phpFlickr/phpFlickr.php'); // phpflickr

$detect = new Mobile_Detect();
$is_mobile = $detect->isMobile();

$f = new phpFlickr(FLICKR_API_KEY); // the api key
$f->enableCache($type='fs', FS_CACHE, FLICKR_CACHE_EXPIRE);

$photosets = $f->photosets_getList(FLICKR_NSID);

if (is_array($photosets['photoset']) && count($photosets['photoset'])>0 ) {

  $photosets = $photosets['photoset'];

  $key_first_set = null;
  while(list($key,$photoset) = each($photosets)) {

    if ($photoset['id']==FLICKR_FIRST_SET) $key_first_set=$key;

    if ($photos = $f->photosets_getPhotos($photoset['id'], $extras = NULL, $privacy_filter = NULL, $per_page = 1)) {
      $photosets[$key]['total'] = $photos['photoset']['total'];
      $photosets[$key]['photos'] = $photos['photoset']['photo'];
    }

  }
  if ($key_first_set!==null) {
    $first_set = $photosets[$key_first_set];
    unset($photosets[$key_first_set]);
    array_unshift($photosets,$first_set);
  }

/* echo '<pre>';
  print_r($photosets);
  echo '</pre>';*/

}

$photo_size = ($is_mobile? 'Square':'Medium');

$page_title = 'Sitamet photo sets';

include('../templates/header.inc.php');

?>
<div data-role="page" data-fullscreen="false" class="ps-sets">
  <div data-role="header" id="Header" class="ps-toolbar">
    <h1 id="title"><?php echo $page_title ?></h1>
  </div>

  <div data-role="content" class="page-content" data-theme="c">
    <ul data-role="listview">
  	<?php
    reset($photosets);
    $i=0;

    while(list($key,$set)=each($photosets)) {
      $i++;
      $set_a_href_title = 'href="'.prepareForUrl($set['title']).'-set-'.$set['id'].'" title="'.$set['title'].'"';

      list($photo_id,$photo)=each($set['photos']);
      echo '<li'.(($i&1)? ' class="first"':'').'><a '.$set_a_href_title.'><img src="'.$f->buildPhotoURL($photo,$photo_size).'" alt="'.$set['photo']['title'].'" />';
      echo '<h3>'.$set['title'].'</h3>'."\n";
      echo '<span class="ui-li-count">'.$set['total'].'</span>';
      echo '</a>';
      echo '</li>'."\n";
    }
    ?>
  </ul>
 </div>

<?php
include('../templates/footer.inc.php');
?>