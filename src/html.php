<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- -------------------------------------------------------------------- *
 * PHP Directory Listing (http://weitnahbei.de/php-directory-listing)     *
 * Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>  *
 * Licensed under the GNU GPL, the version of your liking.                *
 * Do copy, share and modify!                                             *
 * -------------------------------------------------------------------- -->

<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo utf8_encode($pdl->title()); ?></title>
    <?php echo $pdl->stylesheet_link_tags(); ?>
    <?php echo $pdl->javascript_include_tags(); ?>
    <?php if ($pdl->getConfig('general', 'interface') == 'gallery') { ?>
      <style type="text/css">
        html {
          background: url(background.jpg) no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      </style>
    <?php } ?>
    <?php require_once path(__FILE__).'js.php'; ?>
    <?php require_once path(__FILE__).'analytics.php'; ?>
  </head>
  <body>
    <div id="content">
      <?php new DirectoryListing(
        getcwd(),
        $pdl->url(),
        $pdl->getConfig('general', 'filenames'),
        $pdl->title(),
        $pdl->getConfig('general', 'download'),
        $pdl->getConfig('download', 'download_caption')
      ); ?>
    </div>
    <?php if ($pdl->getConfig('general', 'interface') == 'gallery') { ?>
      <div id="controls"></div>
      <?php if (is_file('background.mp3')) { ?>
        <?php if ($pdl->getConfig('gallery', 'backgroundmusic_autostart')) { ?>
          <img src="<?php echo $pdl->url().'icons/pause.png'; ?>" id="playpause" />
        <?php } else { ?>
          <img src="<?php echo $pdl->url().'icons/play.png'; ?>" id="playpause" />
        <?php } ?>
      <?php } ?>
      <div id="songtitle"></div>
    <?php } ?>
  </body>
</html>
