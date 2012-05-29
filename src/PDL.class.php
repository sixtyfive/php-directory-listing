<?php
  /* PHP Directory Listing (http://weitnahbei.de/php-directory-listing)
   * Copyright (C) 2009 and onwards, J. R. Schmid <jrs-spam@weitnahbei.de>
   * Licensed under the GNU GPL, the version of your liking.
   * Do copy, share and modify! */

  function utf8_urldecode($url) {
    return utf8_decode(urldecode($url));
  }

  class PDL {
    protected $config;

    public function PDL($config_file = 'config.ini')
    {
      $this->setConfig($config_file);
    }

    protected function setConfig($config_file)
    {
      if (!$this->config = parse_ini_file(path(__FILE__).'..'.pd().$config_file, TRUE)) throw new exception('Unable to open '.$config_file.'.');
      if (is_file($config_file)) {
        if (!$this->config = parse_ini_file($config_file, TRUE)) throw new exception('Unable to open '.$config_file.'.');
      }
    }

    public function getConfig($section, $setting)
    {
      return $this->config[$section][$setting];
    }

    public function url()
    {
      return $this->config['general']['url'];
    }

    public function title()
    {
      // I would like to thank cythrawll (who helped by loosening the jarlid and sends out love)
      // and erisco from irc.freenode.net/##php for this MOTHER of all regular expressions.
      // Amazing what a human brain can accomplish when it begins to see things as a challenge...
      preg_match('!(?:.*://[^/]*)?([^/?]*)/?(?:/[^/?]+\.[^/?]+)?(?:\?.*)?$!', $_SERVER['REQUEST_URI'], $matches); 
 
      $titlesetting = $this->getConfig('general', 'title');

      if ($titlesetting == 'titlecase') {
        require_once path(__FILE__).'src'.pd().'thirdparty'.pd().'strtotitle.function.php';
        $title = ($matches[1] ? strtotitle(preg_replace('/\-/', ' ', $matches[1])) : '-');
      } elseif ($titlesetting == 'dirname') {
        $title = ($matches[1] ? utf8_urldecode($matches[1]) : '/');
      } else {
        $title = $titlesetting; 
      }
  
      return $title;
    }

    public function stylesheet_link_tags()
    {
      $retval = '';
  
      $css_files = array(
        $this->url().'thirdparty/fancybox/jquery.fancybox.css?v=2.0.6',
        $this->url().'thirdparty/fancybox/helpers/jquery.fancybox-buttons.css',
        $this->url().'css/index.css'
      ); 
      
      if ($this->getConfig('general', 'interface') == 'gallery') {
        $css_files[] = $this->url().'css/gallery.css';
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
        $this->url().'thirdparty/fancybox/helpers/jquery.fancybox-buttons.js',
        $this->url().'thirdparty/soundmanager2/script/soundmanager2-nodebug-jsmin.js'
      ); foreach ($js_files as $js_file) {
        $retval .= '<script type="text/javascript" src="'.$js_file.'"></script>'."\n  ";
      }
      
      return trim($retval)."\n";
    }
  }
  
  require_once path(__FILE__).'DirectoryListing.class.php'; 
?>
