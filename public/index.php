<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!--
Copyright (C) 2005 and onwards, Raphael J. Schmid <rjs@schattenschreiber.org>
Licensed under the GNU GPL, the version of your liking.
Do copy, share and modify!
-->

<? $url = 'http://schattenschreiber.org/php-directory-listing/sample/'; ?>

<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <title>
    <? 
      // With a tip o' the hat to http://blogs.sitepoint.com/2005/03/15/title-case-in-php/
      // (See there if you need commentary)
      // Converts $title to Title Case, and returns the result. 
      function strtotitle($title) 
      {
        $smallwordsarray = array( 'of','a','the','and','an','or','nor','but','is','if','then','else','when', 'at','from','by','on','off','for','in','out','over','to','into','with' );
        $words = explode(' ', $title); 
        foreach ($words as $key => $word) { 
          if ($key == 0 or !in_array($word, $smallwordsarray)) {
            $words[$key] = ucwords($word);
          }
        } 
        $newtitle = implode(' ', $words); 
        return $newtitle; 
      }

      // I would like to thank cythrawll (who helped by loosening the jarlid and sends out love)
      // and erisco from irc.freenode.net/##php for this MOTHER of all regular expressions.
      // Amazing what a human brain can accomplish when it begins to see things as a challenge...
      preg_match('!(?:.*://[^/]*)?([^/?]*)/?(?:/[^/?]+\.[^/?]+)?(?:\?.*)?$!', $_SERVER['REQUEST_URI'], $matches); 
      if ($matches[1]) {
        echo strtotitle($matches[1]);
      } else {
        echo '/';
      }
    ?>
  </title>
  <link rel="stylesheet" type="text/css" href="<? echo $url; ?>index.css" />
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
