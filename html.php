<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- -------------------------------------------------------------------- *
 * PHP Directory Listing (http://weitnahbei.de/php-directory-listing)     *
 * Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>  *
 * Licensed under the GNU GPL, the version of your liking.                *
 * Do copy, share and modify!                                             *
 * -------------------------------------------------------------------- -->

<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <title><?php echo $pdl->title(); ?></title>
  <?php echo $pdl->stylesheet_link_tags(); ?>
  <?php echo $pdl->javascript_include_tags(); ?>
  <style type="text/css">
    html {
      background: url(background.jpg) no-repeat center center fixed;
    }
  </style>
  <?php require_once path(__FILE__).'js.php'; ?>
  <?php require_once path(__FILE__).'analytics.html'; ?>
</head>
<body>
<div id="content">
<?php new DirectoryListing(getcwd(), $pdl->url(), $pdl->getConfig('filenames')); ?>
</div>
<?php if (is_file('background.mp3')) { ?>
<div id="controls"></div>
<img src="<?php echo $pdl->url().'icons/pause.png'; ?>" id="playpause" />
<div id="songtitle"></div>
<?php } ?>
</body>
</html>
