<?
  /***
   * php-directory-listing, version 0.3.0
   * Copyright (C) 2005 and onwards, Raphael J. Schmid <rjs@schattenschreiber.org>
   * Licensed under either the GNU GPL (any version of your liking) or the CreativeCommons
   * BY-SA 3.0 license.
   *
   * Do copy, share and modify!
   * 
   * Additions in functionality by Andreas Aronsson <aron@aron.nu>.
   ***/

  require_once path(__FILE__).'Thumbnail.class.php'; 
  
  class DirectoryListing {
    var $EXCLUDE_FILES = array(
      ".",
      "..",
      "README.txt",
      ".htaccess",
      ".thumbnails",
      "index.php",
      "dir-generator.php",
      "file.php",
      "googlehostedservice.html",
      "mail",
      "DirectoryListing.class.php",
      "Thumbnail.class.php",
      "visible.css",
      "hidden.css",
      "index.css",
      "thirdparty",
      "config.ini",
      "background.mp3",
      "background.jpg",
      "icons",
      ".icons" // ,
               // ".???"
    );

    var $FILETYPE_ICON_PATH = 'icons';

    var $_filetype_icon_path;

    var $_thumbnail_width;
    var $_thumbnail_height;
    var $_thumbnail_quality;
    var $_max_filename_length;
    var $_max_content_length;
    
    function DirectoryListing(
      $path,
      $url = '',
      $filenames = 'inline',
      $width = 75,
      $height = NULL, 
      $max_filename_length = 8,
      $max_content_length = 60,
      $quality = 85
    )  {
      $this->filetype_icon_path = $this->FILETYPE_ICON_PATH.$this->pd();
      $this->thumbnail_width = $width;
      $this->thumbnail_height = $height;
      $this->max_filename_length = $max_filename_length;
      $this->max_content_length = $max_content_length;
      $this->thumbnail_quality = $quality;
      $dir_handle = opendir($path) or die("Unable to open $path");
      $cnt = 0;
      $dirs = array();
      $files = array();

      // Split the file and directory cases.
      // Add trailing slash if directory.
      while (false !== ($file=readdir($dir_handle)))
      {
        if (substr($file,0,1) != ".") {
          if (is_dir($path.'/'.$file)) {
            array_push($dirs, $file);
          } else {
            array_push($files, $file);
          }
        }
      }

      @closedir($dir_handle);

      // Sorting alphabetically.
      if ($files) {
        natcasesort($files);
      }
      if ($dirs) {
        natcasesort($dirs);
      }
     
      $files=array_merge($dirs, $files);

      foreach ($files as $file) {
        if (! in_array($file, $this->EXCLUDE_FILES)) {        
          echo "<div class=\"item\" id=\"file_"
               .preg_replace('/(\+|\%)/', '_', urlencode($file))
               ."\">"
               .$this->href($file, $url, $filenames)
               ."</div>\n";
        }
      }
      
      @closedir($dir_handle);
     
      // Print contents of README.txt file if present. 
      if (is_file('README.txt')) {
        echo "<pre>\n"; require 'README.txt'; echo "</pre>\n";
      }
    }

    function href($file, $url, $filenames)
    {
      $type = $this->type($file);
      
      $fancybox_tag = FALSE;
      if (!is_dir($file)) {
        switch(strtolower($type)) {
          case 'jpg':
          case 'png':
          case 'gif':
          case 'jpeg':
          case 'jpe':
          $fancybox_tag = TRUE;
          break;
        }
      }; if ($fancybox_tag == TRUE) {
        $href = '<div class="thumbnail image"><div class="rightlimit"></div><div class="bottomlimit"></div>';
        $href .= '<a class="fancybox" rel="group" href="'.rawurlencode($file).'" title="'.$file.'">';
      } else {
        $href = '<div class="thumbnail icon"><div class="rightlimit"></div><div class="bottomlimit"></div>';
        $href .= '<a href="'.rawurlencode($file).'" title="'.$file.'">';
      }

      if (is_dir($file)) {
        $href .= '<img src="'.$url.$this->filetype_icon_path.'directory.png" alt="'.$file.'"/>';
      } else {
        switch(strtolower($type)) {
          case 'jpg':
          case 'png':
          case 'gif':
          case 'jpeg':
          case 'jpe':
          $tn = new Thumbnail($file, $this->thumbnail_width, $this->thumbnail_height, $this->thumbnail_quality);
          if ($tn) $href .= '<img src="'.rawurlencode($tn->getPath()).'" alt="'.$file.'"/>';
          break;
  
          case 'txt':
          case 'html':
          case 'c':
          case 'cpp':
          case 'h':
          case 'rb':
          case 'py':
          case 'php':
          case 'pl':
          case 'asp':
          case 'phps':
          case 'log':
          case 'sh':
          case 'list':
          case 'diff':
          case 'patch':
          case 'tex':
          case 'po':
          case 'conf':
          $fh = fopen($file, 'r');
          if (filesize($file)!= 0) { // If file is NOT empty.
            if ($fh) $href .= '<code class="txt">'.htmlspecialchars(substr(fread($fh, filesize($file)), 0, $this->max_content_length)).'</code>';
          } else {                   // If file IS empty.
           if ($this->max_content_length >= 12) $href .= '<code class="txt">&mdash;</code>'; // Changed from "[empty file]" to maintain language agnosticism.
          }
          break;
          
          case 'pdf':
          $output = ".thumbnails/".basename(str_replace(".pdf", ".jpg", $file));
          if (!file_exists($output)) {
            exec("gs -q -dNOPAUSE -dBATCH -sDEVICE=jpeg -sOutputFile=\"$output\" \"$file\"");
            exec("convert -resize 50x75 \"$output\" \"$output\"");
          }  
          $href .= '<img src="'.rawurlencode($output).'" alt="'.$file.'"/>';
          break;
  
          default:
          $href .= '<img src="'.$url.$this->filetype_icon_path;
          if (is_file(path(__FILE__).$this->filetype_icon_path.$type.'.png')) $href .= $type;
          else $href .= 'unknown';
          $href .= '.png" alt="?"/>';
          break;
        }
      }
      $href .= '</a></div>';

      if ($filenames == 'inline') {
        $words = $this->words(substr($file, 0, $this->max_filename_length));
        $underscore = '<span class="hidden">_</span>';
        $cnt = 0;
        $link_text = '';
        foreach ($words as $word) {
          if ($cnt++ > 0)  $link_text .= $underscore;
          $link_text .= $word;
        }
        if ($type) $type = '<span class="hidden">'.$type.'</span>';
        if (strlen($file) > $this->max_filename_length) $type = '&hellip;'.$type;
        else if ($type) $type = '.'.$type;
        $href .= '<a href="'.rawurlencode($file).'">';
        $href .= $link_text.$type."</a>"; 
        if (is_dir($file)) $href .= "</a>";
      }
      
      return $href;
    }

    function words($file)
    {
      $words = explode('_', trim($file));
      $last_word = array_pop($words);
      $last_word = explode('.', $last_word);
      $last_word = $last_word[0];
      $words[] = $last_word;
      return $words;
    }
  
    function type($file)
    {
      $chunks = explode('.', trim($file));
  
      if (count($chunks) > 1)
      return array_pop($chunks);
  
      else
      return false;
    }
    
    function pd()
    {
      $OS = strtolower(substr(PHP_OS, 0, 3));
      $OS == 'win' ? $PD = '\\' : $PD = '/';
      return $PD;
    }
  }
?>
