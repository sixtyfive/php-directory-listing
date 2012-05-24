<?php
  /* PHP Directory Listing (http://weitnahbei.de/php-directory-listing)
   * Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>
   * Licensed under the GNU GPL, the version of your liking.
   * Do copy, share and modify! */
  
  $url = 'http://weitnahbei.de/php-directory-listing/';
  $title = 'titlecase'; # Options: 'dirname' (default) or 'titlecase'.
  $filenames = 'inline'; # Options: 'inline' (default) or 'tooltip'.

  function path($file)
  {
    $OS = strtolower(substr(PHP_OS, 0, 3));
    $OS == 'win' ? $PD = '\\' : $PD = '/';
    return dirname($file).$PD;
  }
  
  require_once path(__FILE__).'html.php';
?>
