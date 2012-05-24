<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!--
PHP Directory Listing (http://weitnahbei.de/php-directory-listing)
Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>
Licensed under the GNU GPL, the version of your liking.
Do copy, share and modify!
-->

<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <title>
    <?php 
      // I would like to thank cythrawll (who helped by loosening the jarlid and sends out love)
      // and erisco from irc.freenode.net/##php for this MOTHER of all regular expressions.
      // Amazing what a human brain can accomplish when it begins to see things as a challenge...
      preg_match('!(?:.*://[^/]*)?([^/?]*)/?(?:/[^/?]+\.[^/?]+)?(?:\?.*)?$!', $_SERVER['REQUEST_URI'], $matches); 

      if ($title == 'titlecase') {
        require_once path(__FILE__).'thirdparty/strtotitle.function.php';
        $title = ($matches[1] ? strtotitle(preg_replace('/\-/', ' ', $matches[1])) : '-');
      } else {
        $title = ($matches[1] ? $matches[1] : '/');
      }

      echo $title;
    ?>
  </title>
  <?
    $css_files = array(
      $url.'thirdparty/fancybox/jquery.fancybox.css?v=2.0.6',
      $url.'index.css'
    ); foreach ($css_files as $css_file) {
      echo '<link rel="stylesheet" type="text/css" href="'.$css_file.'" />'."\n";
    }

    $js_files = array(
      $url.'thirdparty/jquery-1.7.2.min.js',
      $url.'thirdparty/jquery.mousewheel-3.0.6.pack.js',
      $url.'thirdparty/fancybox/jquery.fancybox.pack.js?v=2.0.6',
      $url.'thirdparty/soundmanager2/script/soundmanager2.js'
    ); foreach ($js_files as $js_file) {
      echo '<script type="text/javascript" src="'.$js_file.'"></script>'."\n";
    }
  ?>
  <style type="text/css">
    html {
      background: url(background.jpg) no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.fancybox').fancybox({
        padding: 15,
        margin: 50,
        prevEffect: 'none',
        nextEffect: 'none',
        closeBtn: false,
        helpers: {
          overlay: {opacity: 0.9, css: {'background-color': '#000'}}
        }
      });

      $('#playpause').click(function() {
        soundManager.togglePause('backgroundMusic');
        var obj = $(this);
        if (obj.attr('src') == '<?php echo $url.'icons/pause.png'; ?>') {
          obj.attr('src', '<?php echo $url.'icons/play.png'; ?>');
        } else {
          obj.attr('src', '<?php echo $url.'icons/pause.png'; ?>');
        }
      });
    });

    soundManager.url = '<?php echo $url.'thirdparty/soundmanager2/swf/'; ?>';
    soundManager.flashVersion = 9;
    soundManager.waitForWindowLoad = true;

    soundManager.onready(function() {
      var backgroundMusic = soundManager.createSound({
        id: 'backgroundMusic',
        url: 'background.mp3',
        onid3: function() {
          $('#songtitle').html(this.id3['TPE2'] + ' - ' + this.id3['TIT2']);
        },
        onfinish: function() {
          $('#playpause').attr('src', '<?php echo $url.'icons/play.png'; ?>');
        }
      });

      backgroundMusic.play();
    });
  </script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount','UA-30932255-1']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>
<body>
  <div id="content">
    <?php 
      require_once path(__FILE__).'DirectoryListing.class.php'; 
      new DirectoryListing(getcwd(), $url); 
      
      if (is_file('README.txt')) {
        echo "<pre>\n"; require 'README.txt'; echo "</pre>\n";
      }
    ?>
  </div>
  <div id="controls"></div>
  <img src="<?php echo $url.'icons/pause.png'; ?>" id="playpause" />
  <div id="songtitle"></div>
</body>
</html>
