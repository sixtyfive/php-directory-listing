<?php
  /* PHP Directory Listing (http://weitnahbei.de/php-directory-listing)
   * Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>
   * Licensed under the GNU GPL, the version of your liking.
   * Do copy, share and modify! */
 
  error_reporting(E_ALL);

  function path($file)
  {
    $OS = strtolower(substr(PHP_OS, 0, 3));
    $OS == 'win' ? $PD = '\\' : $PD = '/';
    return dirname($file).$PD;
  }
    
  class PDL {
    protected $config;

    protected function setConfig($config_file)
    {
      if (!$this->config = parse_ini_file(path(__FILE__).$config_file, TRUE)) throw new exception('Unable to open '.$config_file.'.');
      if (is_file($config_file)) {
        if (!$this->config = parse_ini_file($config_file, TRUE)) throw new exception('Unable to open '.$config_file.'.');
      }
    }

    public function getConfig($setting)
    {
      return $this->config['general'][$setting];
    }

    public function PDL($config_file = 'config.ini')
    {
      $this->setConfig($config_file);
    }

    public function url()
    {
      return $this->config['general']['url'];
    }

    // I would like to thank cythrawll (who helped by loosening the jarlid and sends out love)
    // and erisco from irc.freenode.net/##php for this MOTHER of all regular expressions.
    // Amazing what a human brain can accomplish when it begins to see things as a challenge...
    public function title()
    {
      preg_match('!(?:.*://[^/]*)?([^/?]*)/?(?:/[^/?]+\.[^/?]+)?(?:\?.*)?$!', $_SERVER['REQUEST_URI'], $matches); 
  
      if ($this->getConfig('title') == 'titlecase') {
        require_once path(__FILE__).'thirdparty/strtotitle.function.php';
        $title = ($matches[1] ? strtotitle(preg_replace('/\-/', ' ', $matches[1])) : '-');
      } else {
        $title = ($matches[1] ? $matches[1] : '/');
      }
  
      return $title;
    }

    public function stylesheet_link_tags()
    {
      $retval = '';
  
      $css_files = array(
        $this->url().'thirdparty/fancybox/jquery.fancybox.css?v=2.0.6',
        $this->url().'index.css'
      ); 
      
      if (is_file('background.mp3')) {
        $css_files[] = $this->url().'gallery.css';
      }

      foreach ($css_files as $css_file) {
        $retval .= '<link rel="stylesheet" type="text/css" href="'.$css_file.'" />'."\n  ";
      }

      return trim($retval)."\n";
    }

    public function javascript_include_tags()
    {
      $retval = '';
  
      $js_files = array(
        $this->url().'thirdparty/jquery-1.7.2.min.js',
        $this->url().'thirdparty/jquery.mousewheel-3.0.6.pack.js',
        $this->url().'thirdparty/fancybox/jquery.fancybox.pack.js?v=2.0.6',
        $this->url().'thirdparty/soundmanager2/script/soundmanager2-nodebug-jsmin.js'
      ); foreach ($js_files as $js_file) {
        $retval .= '<script type="text/javascript" src="'.$js_file.'"></script>'."\n  ";
      }
      
      return trim($retval)."\n";
    }
  }
  
  $pdl = new PDL('config.ini');

  require_once path(__FILE__).'DirectoryListing.class.php'; 
  require_once path(__FILE__).'html.php';
?>
