<?php
require '../lib/class.settings.php';
require '../lib/class.github.php';
$config = new ConfigMagik('../config.ini', true, true);

if(!empty($_GET) && strpos($_SERVER['HTTP_REFERER'],'settings')){
  if(!is_writeable('../config.ini')){
    echo 'Could not write to config.ini';
    return false;
  }
  //if there is no section parameter, we will not do anything.
  if(!isset($_GET['section'])){ 
    echo false; return false;
  } else {
    $section_name = $_GET['section'];
    unset($_GET['section']);     //Unset section so that we can use the GET array to manipulate the other parameters in a foreach loop.
    if (!empty($_GET)){
      foreach ($_GET as $var => $value){
      //Here we go through all $_GET variables and add the values one by one.
        $var = urlencode($var);
        try{
          $config->set($var, $value, $section_name); //Setting variable '. $var.' to '.$value.' on section '.$section_name;
        } catch(Exception $e) {
          echo 'Could not set variable '.$var.'<br>';
          echo $e;
          return false;
        }
      }
    }
    try{
      $section = $config->get($section_name); //Get the entire section so that we can check the variables in it.
      foreach ($section as $title=>$value){
      //Here we go through all variables in the section and delete the ones that are in there but not in the $_GET variables
      //Used mostly for deleting things.
        if(!isset($_GET[$title]) && ($config->get($title, $section_name) !== NULL)){
          $title = urlencode($title);
          try{
            $config = new ConfigMagik('../config.ini', true, true);
            $config->removeKey($title, $section_name);  //$title removed;
            $config->save();
          } catch(Exception $e){
            echo 'Unable to remove variable '.$title.' on section'.$section_name.'<br>';
            echo $e;
          }
        }
      }
    } catch(Exception $e){
      echo $e;
    }
    echo true;
    return true;
  }
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--
   @author: Gustavo Hoirisch
  -->

<html>
<head>
  <title>Settings</title>
  <link href="../css/front.css" rel="stylesheet" type="text/css">
  <link href="../css/settings.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src="../js/fisheye-iutil.min.js"></script>
  <script type="text/javascript" src="../js/settings.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/widget.css">
  <link rel="stylesheet" type="text/css" href="../css/static_widget.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <script src="../js/jquery.scrollTo-1.3.3-min.js" type="text/javascript"></script>
  <script src="../js/jquery.localscroll-1.2.5-min.js" type="text/javascript"></script>
  <script src="../js/jquery.serialScroll-1.2.1-min.js" type="text/javascript"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>  
  <link rel="stylesheet" type="text/css" href="../css/jquery.pnotify.default.css">
  <link rel="stylesheet" type="text/css" href="../css/UI/jquery-ui-1.8.14.custom.css">
  <script src="../js/jquery.pnotify.js" type="text/javascript"></script>
  <script type="text/javascript" src="../js/jquery.tipsy.js"></script>
  <link rel="stylesheet" href="../css/tipsy.css" type="text/css" />
  <script type='text/javascript'>
  $(function() {
    $('input').tipsy({gravity: 'w', fade: true});
    $('img').tipsy({fade: true, gravity: 'n'});  
  });
  </script>
</head>

<body style="overflow: hidden;">
  <center>
    <div style="width:90%; height:95%;" class="widget">
      <div class="widget-head">
        <h3>MediaFrontPage Settings</h3>
      </div>
          <br />
      <div id="slider">
        <ul class="navigation">
          <li><a href="#ABOUT">About</a></li>
          <li><a href="#GLOBAL">General</a></li>
          <li><a href="#PROGRAMS">Programs</a></li>
          <li><a href="#SEARCH">Search Widget</a></li>
          <li><a href="#TRAKT">Trakt.tv</a></li>
          <li><a href="#NAVBAR">Nav Bar</a></li>
          <li><a href="#SUBNAV">Sub Nav</a></li>
          <li><a href="#HDD">Hard Drives</a></li>
          <li><a href="#MESSAGE">Message Widget</a></li>
          <li><a href="#SECURITY">Security</a></li>
          <li><a href="#MODS">CSS Mods</a></li>
          <li><a href="#RSS">RSS Feeds</a></li>
          <li><a href="#CONTROL">Control Widget</a></li>
        </ul>
      <!-- element with overflow applied -->
        <div class="scroll">
          <!-- the element that will be scrolled during the effect -->
          <div class="scrollContainer">
            
			<?php
			
			include "about.php";
			include "global.php";
			include "programs.php";
			include "webroot.php";
			include "xbmc.php";
			include "sickbeard.php";
			include "couchpotato.php";
			include "sabnzbd.php";
			include "transmission.php";
			include "utorrent.php";
			include "jdownloader.php";
			include "subsonic.php";
			include "search.php";
			include "trakt.php";
			include "navbar.php";
			include "subnav.php";
			include "hdd.php";
			include "message.php";
			include "security.php";
			include "mods.php";
			include "rss.php";
			include "control.php";
			?>
			             
          </div>
        </div>
        <!-- <input type="button" value="Save ALL" onclick="saveAll();">  -->
      </div>
    </div>  
  </center>
<!--
  <div>
    <input value="Regular Notice" onclick="$.pnotify({
            pnotify_title: 'Regular Notice',
            pnotify_text: 'Check me out! I\'m a notice.'
          });" type="button" class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">  
  </div>
-->
</body>
</html>
<?php 
}
?>
