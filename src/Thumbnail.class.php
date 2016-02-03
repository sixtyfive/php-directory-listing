<?php
  /*
  Copyright (C) 2005 and onwards, Raphael J. Schmid <rjs@schattenschreiber.org>
  Licensed under the GNU GPL, the version of your liking.
  Do copy, share and modify!

  I learned from lasse84's thumbnail creator at http://jack-the-ripper.mine.nu/justThumb/.
  */
  
  class Thumbnail {
    var $DEFAULT_QUALITY = 75;
    var $CACHE_DIRECTORY = '.thumbnails';
    
    var $_file_name;
    var $_file_width;
    var $_file_height;
    var $_file_type;

    var $_thumb_directory;
    var $_thumb_width;
    var $_thumb_height;
    var $_thumb_quality;
    var $_thumb_name;
    
    /* If either $width or $height are NULL, the aspect
     * ratio will be kept. $quality may be omitted and
     * will default to 75.
     */
    function Thumbnail($file, $width, $height, $quality)
    {
      if (is_file($file)) {
        /* set file name */
        $this->file_name = $file;
      
        /* set file width & height, set thumbnail width & height */
        if (! $width && ! $height) die("Must supply either desired width or height or both.");
        list($this->file_width, $this->file_height, $this->file_type) = getimagesize($file);

        if ($width && $height) {
          $this->thumb_width = $width;
          $this->thumb_height = $height;
        }

        if (! $width && $height) {
          $this->thumb_height = $height;
          $this->thumb_width = round($this->file_width * ($height / $this->file_height));
        }

        if ($width && ! $height) {
          $this->thumb_width = $width;
          $this->thumb_height = round($this->file_height * ($width / $this->file_width));
        }

        /* set desired quality */
        if ($quality) {
          $this->thumb_quality = $quality;
        } else {
          $this->thumb_quality = $this->DEFAULT_QUALITY;
        }

        /* set cache directory, cache file name for this thumbnail */
        $this->thumb_directory = /*dirname(__FILE__).$this->pd().*/$this->CACHE_DIRECTORY.$this->pd();
        $this->thumb_name = $file.'-' // Creating .jpg's seems to be compatible with more server setups.
                           .$this->thumb_width.'x'
                           .$this->thumb_height.'@'
                           .$this->thumb_quality.'.jpg';

        /* make sure cache directory exists */
        if (! file_exists($this->thumb_directory))
          mkdir ($this->thumb_directory, 0777);

        /* create thumbnail from scratch if it is not already cached */
        if (! is_file($this->thumb_directory.$this->thumb_name)) {
          $this->createFromFile($file);
        }
      } else {
        return false; /* file does not exist */
      }
    }

    function pd()
    {
      $OS = strtolower(substr(PHP_OS, 0, 3));
      $OS == 'win' ? $PD = '\\' : $PD = '/';
      return $PD;
    }
    
    function createFromFile()
    {
      /* load original image */
      switch ($this->file_type) {
        case IMAGETYPE_JPEG:
        $orig_img = imagecreatefromjpeg($this->file_name);
        break;

        case IMAGETYPE_PNG:
        $orig_img = imagecreatefrompng($this->file_name);
        break;

        case IMAGETYPE_GIF:
        $orig_img = imagecreatefromgif($this->file_name);
        break;
      }

      /* create thumbnail */
      $thumb_img = imagecreatetruecolor($this->thumb_width, $this->thumb_height);
      imagecopyresampled($thumb_img, $orig_img, 
                         0, 0, 0, 0,
                         $this->thumb_width, $this->thumb_height,
                         $this->file_width, $this->file_height);
      imagedestroy($orig_img);

      /* save thumbnail - creating .jpg's seems to be compatible with more server setups. */
      #switch ($this->file_type) {
       # case IMAGETYPE_JPEG:
        imagejpeg($thumb_img, $this->thumb_directory.$this->thumb_name, $this->thumb_quality);
        #break;

        /*case IMAGETYPE_PNG:
        imagepng($thumb_img, $this->thumb_directory.$this->thumb_name, $this->thumb_quality);
        break;
        
        case IMAGETYPE_GIF:
        imagegif($thumb_img, $this->thumb_directory.$this->thumb_name, $this->thumb_quality);
        break;
      }*/

      /* clean up */
      imagedestroy($thumb_img);
    }

    function getPath()
    {
      return $this->thumb_directory.$this->thumb_name;
    }
  }
?>
