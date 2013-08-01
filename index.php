<?php
  /* PHP Directory Listing (http://weitnahbei.de/php-directory-listing)
   * Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>
   * Licensed under the GNU GPL, the version of your liking.
   * Do copy, share and modify! */
 
  error_reporting(E_ERROR | E_PARSE);

  function pd()
  {
    $OS = strtolower(substr(PHP_OS, 0, 3));
    $OS == 'win' ? $PD = '\\' : $PD = '/';
    return $PD;
  }

  function path($file)
  {
    return dirname($file).pd();
  }
    
  require_once path(__FILE__).'src'.pd().'PDL.class.php';
  $pdl = new PDL('config.ini');

  require_once path(__FILE__).'src'.pd().'html.php';
?>
