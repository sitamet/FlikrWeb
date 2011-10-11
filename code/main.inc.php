<?php

//////////////////////////////////////////////////////////////////////////
// basic definitions
//////////////////////////////////////////////////////////////////////////


//ini_set('display_errors',1);

date_default_timezone_set('Europe/Madrid'); 
setlocale(LC_ALL, 'es_ES.UTF8');


define('FS_CACHE','/home/httpd/www.sitamet/www.cache');  // a writable directory for you cache files

define('HTTP_SERVER', 'http://'.$_SERVER["HTTP_HOST"]);
define('HTTP_WEB', HTTP_SERVER.WS_BASE);



$user_id_NSID = '54780865@N07';
define('FLICKR_NSID','54780865@N07');
define('FLICKR_API_KEY','place_here_you_flickr_api_key');
define('FLICKR_CACHE_EXPIRE','86400'); // in seconds (24h=24x3600=86400)

// we will work with large or original size depending on screen resolution:
define('FLICKR_PHOTO_LARGE_KEY', 5);    // 5 is the array key of "Large" in my photo_sizes array
define('FLICKR_PHOTO_ORIGINAL_KEY', 6); // set it to 5 if you don't have a flickr pro account with "original" size available.

define('FLICKR_FIRST_SET','72157627623821871'); // id of our "default" photoset, the one we want to show first (optional)

// allowed EXIF tags:
$allowed_exif_tags = array(
'ObjectName','ImageDescription','Caption-Abstract','Keywords','Format','Make','Model','DateTimeOriginal','ModifyDate','ExposureTime','Aperture','ExposureProgram',
'ISO','ExposureCompensation','MaxApertureValue','MeteringMode','LightSource','Flash','Lens','FocalLength','ExposureMode','WhiteBalance',
'FocalLengthIn35mmFormat','CreatorTool','Software','Artist','Copyright','CopyrightNotice','UsageTerms'
);

// initializing vars
$back_button = false;
$js_photos_obj = false;
$is_mobile = false;

/**
 * @param $str The string to be placed in the url
 * @param array $replace array of strings you want to avoid/skip
 * @param string $delimiter the char used to jump from one word to the other
 * @return mixed|string the safe url string
 */
function prepareForUrl($str, $replace = array(), $delimiter ="_") {
  if (!empty($replace)) {
    $str = str_replace((array)$replace, ' ', $str);
  }

$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ї','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','ё','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','ї','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','Ļ','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','Ż','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǎ','ǎ','Ǐ','ǐ','Ǒ','ǒ','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','ϋ','Ǻ','ǻ','Ǽ','ǽ','Ǿ','ǿ','΄','ό','Α','ϊ','ฺB','Η','Ḩ','ā','ţ','ḯ','ố','ạ','ẖ','ộ','Ḩ','ḩ','H̱');
$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','u','A','a','AE','ae','O','o','','o','a','i','b','h','h','a','t','i','o','a','h','o','h','h','h');
$clean = str_replace($a, $b, $str);

$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
$clean = strtolower(trim(ltrim(rtrim($clean)), '-'));
$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

return $clean;
}

/**
 * @param $photo_size array of flickr photo sizes
 * @return url of your large photo.
 */
function getLargePhotoUrl($photo_size) {

  $large_photo_key = FLICKR_PHOTO_LARGE_KEY;

  if ($_COOKIE['resolution']>1024 &&
      is_array($photo_size[FLICKR_PHOTO_ORIGINAL_KEY])) {
    $large_photo_key = FLICKR_PHOTO_ORIGINAL_KEY;
  }

  return $photo_size[$large_photo_key]['source'];
}

/**
 * @return int
 */
function getLargePhotoLabel() {


  if ($_COOKIE['resolution']>=2048) {
    $large_photo_key = FLICKR_PHOTO_ORIGINAL_KEY;
  } else {
    $large_photo_key = FLICKR_PHOTO_LARGE_KEY;
  }

  return $large_photo_key;
}

?>