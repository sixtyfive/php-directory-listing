<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!--
Copyright (C) 2012 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>
Licensed under the GNU GPL, the version of your liking.
Do copy, share and modify!
-->

<? $url = 'http://weitnahbei.de/php-directory-listing/'; ?>

<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <title>
    <? 
      // I would like to thank cythrawll (who helped by loosening the jarlid and sends out love)
      // and erisco from irc.freenode.net/##php for this MOTHER of all regular expressions.
      // Amazing what a human brain can accomplish when it begins to see things as a challenge...
      preg_match('!(?:.*://[^/]*)?([^/?]*)/?(?:/[^/?]+\.[^/?]+)?(?:\?.*)?$!', $_SERVER['REQUEST_URI'], $matches); 
      echo ($matches[1] ? $matches[1] : '/');
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
      $url.'thirdparty/fancybox/jquery.fancybox.pack.js?v=2.0.6'
    ); foreach ($js_files as $js_file) {
      echo '<script type="text/javascript" src="'.$js_file.'"></script>'."\n";
    }
  ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.fancybox').fancybox({
        prevEffect: 'none',
        nextEffect: 'none',
        closeBtn: false,
        helpers: {
          overlay: {opacity: 0.8, css: {'background-color': '#000'}},
        }
      });
    });
  </script>
</head>
<body>
  <? 
  function path($file)
  {
    $OS = strtolower(substr(PHP_OS, 0, 3));
    $OS == 'win' ? $PD = '\\' : $PD = '/';
    return dirname($file).$PD;
  }
  
  require_once path(__FILE__).'DirectoryListing.class.php'; 
  new DirectoryListing(getcwd(), $url); 
  ?>
</body>
</html>
