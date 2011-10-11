<!DOCTYPE html><html>
<head>
<title><?php echo $page_title ?></title>
<meta name="author" content="Joan Vega - sitamet" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1;" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta charset="utf-8" />
<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; expires=; path=/';</script>
<link href="css/photoswipe.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/klass.min.js"></script>
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<?php

if ($is_mobile) {
?>
  <link href="http://code.jquery.com/mobile/latest/jquery.mobile.min.css" rel="stylesheet" type="text/css" />
<link href="css/default-mobile.css" type="text/css" rel="stylesheet" />
<script src="http://code.jquery.com/mobile/latest/jquery.mobile.min.js"></script>
<?php
} else {
?>
<link href="css/default.css" type="text/css" rel="stylesheet" />
<?php
}
?>
<script type="text/javascript" src="js/code.photoswipe.jquery-2.1.1.js"></script>
<script type="text/javascript">

  (function(window, $, PhotoSwipe){

    $(document).ready(function(){


      $.fn.loadPhotoSwipeInstanceId = function() {
        return this.each(function() {
        var currentPage = $(this),
            photoSwipeInstanceId = currentPage.attr('id'),
            options =  {
            autoStartSlideshow: true,
            preventHide: false,
            preventClick: true,
            slideshowDelay: 8000,
            imageScaleMethod: "zoom",
            getImageSource: function(obj){
              return obj.getAttribute('data-src');
            }
          },
          photoSwipeInstance = PhotoSwipe.getInstance(photoSwipeInstanceId);

        if (typeof photoSwipeInstance === "undefined" || photoSwipeInstance === null) {
          photoSwipeInstance = $("ul.gallery a", currentPage).photoSwipe(options, photoSwipeInstanceId);
        }

        return true;
        });
      }

      $('div.ps-set').loadPhotoSwipeInstanceId();


      $("#ps-playslideshow").live("click",function(page) {
        var photoSwipeInstanceId = $('div.ps-set').attr('id'),
        photoSwipeInstance = PhotoSwipe.getInstance(photoSwipeInstanceId);
        photoSwipeInstance.show(0);
      });


      $('div.ps-set').live('pageshow',function(event){
        return $(event.target).loadPhotoSwipeInstanceId();
      });

    });

  }(window, window.jQuery, window.Code.PhotoSwipe));




</script>


<!-- Favicons
================================================== -->
<link rel="shortcut icon" href="img/flickr.ico">
<link rel="apple-touch-icon" sizes="129x129" href="img/flickr_129x129.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/flickr_114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/flickr_72x72.png">

</head>
<body>

