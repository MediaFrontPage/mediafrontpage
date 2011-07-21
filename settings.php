<?php
require_once('class.ConfigMagik.php');
$config = new ConfigMagik('config.ini', true, true);

if(!empty($_GET)){
	if(!is_writeable('config.ini')){
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
        	try{
            $config = new ConfigMagik('config.ini', true, true);
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
<?php include "nav.php" ?>
<html>
<head>
  <title>MediaFrontPage - Settings</title>
  <link href="css/front.css" rel="stylesheet" type="text/css">
  <link href="css/settings.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src="js/fisheye-iutil.min.js"></script>
  <script type="text/javascript" src="js/settings.js"></script>
  <link rel="stylesheet" type="text/css" href="css/widget.css">
  <link rel="stylesheet" type="text/css" href="css/static_widget.css">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <script src="js/jquery.scrollTo-1.3.3-min.js" type="text/javascript"></script>
  <script src="js/jquery.localscroll-1.2.5-min.js" type="text/javascript"></script>
  <script src="js/jquery.serialScroll-1.2.1-min.js" type="text/javascript"></script>
</head>

<body style="overflow: hidden;">
  <center>
    <div style="width:90%; height:95%;" class="widget">
      <div class="widget-head">
        <h3>MediaFrontPage Settings</h3>
      </div>
					<br />
      <div id="slider">
        <ul class="settings_nav">
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
					<div id="ABOUT" class="panel">
						<table cellpadding="5px">
						<tr>
							<img src="media/mfp.png" />
						</tr>
						<tr>
							<td colspan="2">
							<p align="justify" style="width: 500px;padding-bottom: 20px;">
								MediaFrontPage is a HTPC Web Program Organiser. Your HTPC utilises a number of different programs to do certain tasks. What MediaFrontPage does is creates a user specific web page that will be your nerve centre for everything you will need. It was originally created by <a href="http://forum.xbmc.org/member.php?u=24286">Nick8888</a> and has had a fair share of contributors. If you'd like to contribute please consider making a donation or come and join us developing this great tool.
<!-- 			                As of this writing it has been kept mainly by <a href="http://forum.xbmc.org/member.php?u=68433">DejaVu</a> and <a href="http://forum.xbmc.org/member.php?u=52241">gugahoi</a>. -->
			              </p>
			              <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			                <input type="hidden" name="cmd" value="_s-xclick">
			                <input type="hidden" name="hosted_button_id" value="D2R8MBBL7EFRY">
			                <input type="image" src="media/donate.png" value="Donate" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
			                <img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
			              </form>by<br><img src="media/paypal.png">
			            </td>
			          </tr>
			          <tr align="left">
			          	<td>Homepage</td><td><a href="http://mediafrontpage.net/">http://mediafrontpage.net/</a></td>
			          </tr>
			          <tr align="left">
			            <td>Forum</td><td><a href="http://forum.xbmc.org/showthread.php?t=83304">http://forum.xbmc.org/showthread.php?t=83304</a></td>
			          </tr>
			          <tr align="left">
			            <td>Source</td><td><a href="https://github.com/MediaFrontPage/mediafrontpage">https://github.com/MediaFrontPage/mediafrontpage</a></td>
			          </tr>
			          <tr align="left">
			            <td>Bug Tracker</td><td><a href="http://mediafrontpage.lighthouseapp.com">http://mediafrontpage.lighthouseapp.com</a></td>
			          </tr>
			        </table>
			      </div>				
			      <div id="GLOBAL" class="panel"><br><br>
				   <h3>Glogal Settings</h3>
			        <table>
			          <tr>
			            <td align="right">
			              <p>Global URL:</p>
			            </td>
			            <td align="left">
			              <p><input type="checkbox" name="ENABLED" <?php echo ($config->get('ENABLED','GLOBAL')=="true")?'CHECKED':'';?>>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="URL" size="20" value="<?php echo $config->get('URL','GLOBAL')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Global Authentication:</p>
			            </td>
			            <td align="left">
			              <p>
			                <input type="checkbox" name="AUTHENTICATION" <?php echo ($config->get('AUTHENTICATION','GLOBAL') == "true")?'CHECKED':'';?>>
			              </p>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Username:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','GLOBAL')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Password:</p>
			            </td>
			            <td align="left"><input type="password" name="PASSWORD" size="20" value="<?php echo $config->get('PASSWORD','GLOBAL')?>">
			            </td>
			          </tr>
			        </table>
			        <input type="button" value="Save" onclick="updateSettings('GLOBAL');" />
			      </div>
			      <div id="PROGRAMS" class="panel"><br><br>
				  	<style type="text/css">
						.zoom { 
						   width: 32; padding: 0px; border: 0px; 
						   -webkit-transition: all .2s ease-out; 
						   -moz-transition: all .2s ease-out; 
						   -o-transition: all .2s ease-out; 
						   transition: all .2s ease-out; 
						}
						.zoom:hover { 
						   -moz-transform: scale(2);
						   -webkit-transform: scale(2);
						   -o-transform: scale(2);
						   transform: scale(2);
						   }
						</style>
				   <h3>Program Settings</h3>
			        <table cellspacing="30px" cellpadding="30px">
			          <tr>
					    <td><div class="zoom"><a href="#XBMC" title="XBMC"><img src="media/nav/XBMC.png" style="-moz-transform :scale(0.5);opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			            <td><div class="zoom"><a href="#SABNZBD" title="SabNZBd+"><img src="media/nav/SabNZBd.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
						<td><div class="zoom"><a href="#SUBSONIC" title="Subsonic"><img src="media/nav/SubSonic.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			          </tr>
			          <tr>
			            <td><div class="zoom"><a href="#SICKBEARD" title="Sick Beard"><img src="media/nav/SickBeard.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			            <td><div class="zoom"><a href="#COUCHPOTATO" title="Couch Potato"><img src="media/nav/CouchPotato.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
						<td><div class="zoom"><a href="#HEADPHONES" title="Headphones"><img src="media/nav/HeadPhones.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			            </tr>
			          <tr>
			            <td><div class="zoom"><a href="#TRANSMISSION" title="Transmission"><img src="media/nav/Transmission.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			            <td><div class="zoom"><a href="#UTORRENT" title="uTorrent"><img src="media/nav/uTorrent.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			            <td><div class="zoom"><a href="#JDOWNLOADER" title="jDownloader"><img src="media/nav/JDownloader.png" style="opacity:0.4;filter:alpha(opacity=40)" onMouseOver="this.style.opacity=1;this.filters.alpha.opacity=100" onMouseOut="this.style.opacity=0.4;this.filters.alpha.opacity=40" /></a></div></td>
			          </tr>
			          <tr><td colspan="3"><input type="button" value="REVERSE PROXIES" onclick="window.location.href='#WEBROOT'" /></td></tr>
			        </table>
			      </div>
			      <div id="WEBROOT" class="panel"><br><br>
				  <h3>Webroot Settings</h3>
			        <table>
			          <tr><br /></tr>
			          <tr>
			            <td align="right">
			              <p>ENABLED:</p>
			            </td>
			            <td align="left">
			              <p><input type="checkbox" name="ENABLED" <?php echo ($config->get('ENABLED','WEBROOT')=="true")?'CHECKED':'';?>></p>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>XBMC:</p>
			            </td>
			            <td align="left">
			              <input name="XBMC" size="20" value="<?php echo $config->get('XBMC','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Sickbeard:</p>
			            </td>
			            <td align="left">
			              <input name="SICKBEARD" size="20" value="<?php echo $config->get('SICKBEARD','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Couch Potato:</p>
			            </td>
			            <td align="left">
			              <input name="COUCHPOTATO" size="20" value="<?php echo $config->get('COUCHPOTATO','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>SabNZBd+:</p>
			            </td>
			            <td align="left">
			              <input name="SABNZBD" size="20" value="<?php echo $config->get('SABNZBD','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>jDownloader:</p>
			            </td>
			            <td align="left">
			              <input name="JDOWNLOADER" size="20" value="<?php echo $config->get('JDOWNLOADER','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Transmission:</p>
			            </td>
			            <td align="left">
			              <input name="TRANSMISSION" size="20" value="<?php echo $config->get('TRANSMISSION','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>uTorrent:</p>
			            </td>
			            <td align="left">
			              <input name="UTORRENT" size="20" value="<?php echo $config->get('UTORRENT','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Headphones:</p>
			            </td>
			            <td align="left">
			              <input name="HEADPHONES" size="20" value="<?php echo $config->get('HEADPHONES','WEBROOT')?>">
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>SubSonic:</p>
			            </td>
			            <td align="left">
			              <input name="SUBSONIC" size="20" value="<?php echo $config->get('SUBSONIC','WEBROOT')?>">
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('WEBROOT');" />
			      </div>
			      <div id="XBMC" class="panel"><br><br>
			        <h3>XBMC Settings</h3><br><img src="media/nav/XBMC.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','XBMC')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','XBMC')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			            	<input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','XBMC')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input type="password" name="PASSWORD" size="20" value="<?php echo $config->get('PASSWORD','XBMC')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('XBMC');" />
			      </div>
			      <div id="SICKBEARD" class="panel"><br><br>
			        <h3>Sickbeard Settings</h3><br><img src="media/nav/SickBeard.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','SICKBEARD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','SICKBEARD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','SICKBEARD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','SICKBEARD')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('SICKBEARD');" />
			      </div>
			      <div id="COUCHPOTATO" class="panel"><br><br>
			        <h3>Couch Potato Settings</h3><br><img src="media/nav/CouchPotato.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','COUCHPOTATO')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','COUCHPOTATO')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','COUCHPOTATO')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','COUCHPOTATO')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('COUCHPOTATO');" />
			      </div>
			      <div id="SABNZBD" class="panel"><br><br>
			        <h3>SabNZBd+ Settings</h3><br><img src="media/nav/SabNZBd.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','SABNZBD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','SABNZBD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','SABNZBD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','SABNZBD')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>API:</p>
			            </td>
			            <td align="left">
			              <input name="API" type="password" size="40" value="<?php echo $config->get('API','SABNZBD')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('SABNZBD');" />
			      </div>
			      <div id="TRANSMISSION" class="panel"><br><br>
			        <h3>Transmission Settings</h3><br><img src="media/nav/Transmission.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','TRANSMISSION')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','TRANSMISSION')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','TRANSMISSION')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','TRANSMISSION')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('TRANSMISSION');" />
			      </div>
			      <div id="UTORRENT" class="panel"><br><br>
			        <h3>uTorrent Settings</h3><br><img src="media/nav/uTorrent.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','UTORRENT')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','UTORRENT')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','UTORRENT')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','UTORRENT')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('UTORRENT');" />
			      </div>
			      <div id="JDOWNLOADER" class="panel"><br><br>
			        <h3>jDownloader Settings</h3><br><img src="media/nav/JDownloader.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','JDOWNLOADER')?>" /></td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>WEB PORT:</p>
			            </td>
			            <td align="left"><input name="WEB_PORT" size="4" value="<?php echo $config->get('WEB_PORT','JDOWNLOADER')?>" /></td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>REMOTE PORT:</p>
			            </td>
			            <td align="left"><input name="REMOTE_PORT" size="4" value="<?php echo $config->get('REMOTE_PORT','JDOWNLOADER')?>" /></td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','JDOWNLOADER')?>" /></td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','JDOWNLOADER')?>" /></td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onclick="updateSettings('JDOWNLOADER');" />
			      </div>
			      <div id="SUBSONIC" class="panel"><br><br>
			        <h3>SubSonic Settings</h3><br><img src="media/nav/SubSonic.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','SUBSONIC')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','SUBSONIC')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','SUBSONIC')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','SUBSONIC')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onClick="updateSettings('SUBSONIC');" />
			      </div>
			      <div id="HEADPHONES" class="panel"><br><br>
			        <h3>HeadPhones Settings</h3><br><img src="media/nav/HeadPhones.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>IP:</p>
			            </td>
			            <td align="left">
			              <input name="IP" size="20" value="<?php echo $config->get('IP','HEADPHONES')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PORT:</p>
			            </td>
			            <td align="left">
			              <input name="PORT" size="4" value="<?php echo $config->get('PORT','HEADPHONES')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','HEADPHONES')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','HEADPHONES')?>" />
			            </td>
			          </tr>
			        </table>
					    <input type=button value="Back" onClick="history.go(-1)">
			        <input type="button" value="Save" onClick="updateSettings('HEADPHONES');" />
			      </div>				  
			      <div id="SEARCH" class="panel"><br><br>
			        <h3>Search Widget Settings</h3><br><img src="media/nav/search.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>Preferred Site:</p>
			            </td>
			            <td align="left">
			              <p>
			                <input type="radio" name="preferred_site" value="1" <?php echo ($config->get('preferred_site','SEARCH')=="1")?'CHECKED':'';?> />
			                	NZB Matrix 
			                <input type="radio" name="preferred_site" value="2" <?php echo ($config->get('preferred_site','SEARCH')=="2")?'CHECKED':'';?> />
			                	nzb.su
			              </p>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Preffered Category:</p>
			            </td>
			            <td align="left">
			              <input name="preferred_categories" size="20" value="<?php echo $config->get('preferred_categories','SEARCH')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>NZB Matrix USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="NZBMATRIX_USERNAME" size="20" value="<?php echo $config->get('NZBMATRIX_USERNAME','SEARCH')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>NZB Matrix API:</p>
			            </td>
			            <td align="left">
			              <input name="NZBMATRIX_API" type="password" size="40" value="<?php echo $config->get('NZBMATRIX_API','SEARCH')?>" />
			              <a href="http://nzbmatrix.com/account.php"><img src="media/question.png" height="20px"></a>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>NZB.su API:</p>
			            </td>
			            <td align="left">
			              <input name="NZBSU_API" type="password" size="40" value="<?php echo $config->get('NZBSU_API','SEARCH')?>" />
			              <a href="http://nzb.su/profile"><img src="media/question.png" height="20px"></a>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>NZB.su DL Code:</p>
			            </td>
			            <td align="left">
			              <input name="NZB_DL" size="40" value="<?php echo $config->get('NZB_DL','SEARCH')?>" />
			              <a href="http://nzb.su/rss"><img src="media/question.png" height="20px"></a>
			            </td>
			          </tr>
			        </table>
			        <input type="button" value="Save" onclick="updateSettings('SEARCH');" />
			      </div>
			      <div id="TRAKT" class="panel"><br><br>
			        <h3>Trakt.tv Settings</h3><br><img src="media/nav/Trakt.png">
			        <table>
			          <tr>
			            <td align="right">
			              <p>Username:</p>
			            </td>
			            <td align="left"><input name="TRAKT_USERNAME" size="20" value="<?php echo $config->get('TRAKT_USERNAME','TRAKT')?>" /></td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>Password:</p>
			            </td>
			            <td align="left">
			              <input name="TRAKT_PASSWORD" type="password" size="20" value="<?php echo $config->get('TRAKT_PASSWORD','TRAKT')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>API:</p>
			            </td>
			            <td align="left">
			              <input name="TRAKT_API" type="password" size="40" value="<?php echo $config->get('TRAKT_API','TRAKT')?>" />
			              <a href="http://trakt.tv/settings/api"><img src="media/question.png" height="20px"></a>
			            </td>
			          </tr>
			        </table>
			        <input type="button" value="Save" onclick="updateSettings('TRAKT');" />
			      </div>
			      <div id="NAVBAR" class="panel"><br><br>
			        <h3>Navigation Links</h3>
			        <table id='table_nav'>
			          <tr>
			            <td>Title</td>
			            <td>URL</td>
			          </tr>
			          <?php
			           $x = $config->get('NAVBAR');
			           foreach ($x as $title=>$url){
			             echo "<tr>
			                     <td>
			                       <input size='13' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/>
			                     </td>
			                     <td>
			                       <input name='VALUE' size='30' value='$url'/>
			                     </td>
			                   </tr>";
			           }
			           ?>
			        </table>
			        <input type="button" value="ADD" onclick="addRowToTable('nav', 13, 30);" />
			        <input type="button" value="REMOVE" onclick="removeRowToTable('nav');" />
			        <br />
			        <br />
			        <input type="button" value="Save & Reload" onclick="updateAlternative('NAVBAR');setTimeout(top.frames['nav'].location.reload(), 5000);" />
			      </div>
			      <div id="SUBNAV" class="panel"><br><br>
			        <h3>Sub Navigation Links</h3>
			        <table id='table_subnav'>
			          <tr>
			            <td>Title</td>
			            <td>URL</td>
			          </tr>
			          <?php
			           $x = $config->get('SUBNAV');
			           foreach ($x as $title=>$url){
			             echo "<tr>
			                     <td>
			                       <input size='13' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/>
			                     </td>
			                     <td>
			                       <input name='VALUE' size='30' value='$url'/>
			                     </td>
			                   </tr>";
			           }
			           ?>
			        </table>
			        <input type="button" value="ADD" onclick="addRowToTable('subnav', 13, 30);" />
			        <input type="button" value="REMOVE" onclick="removeRowToTable('subnav');" />
			        <br />
			        <br />
			        <input type="button" value="Save & Reload" onclick="updateAlternative('SUBNAV');setTimeout(top.frames['nav'].location.reload(), 5000);" />
			      </div>
			      <div id="HDD" class="panel"><br><br>
			        <h3>Hard Drives Settings</h3>
			        <table id='table_hdd'>
			          <tr>
			            <td>Title</td>
			            <td>Path</td>
			          </tr>
			          <?php
			           $x = $config->get('HDD');
			           foreach ($x as $title=>$url){
			             echo "<tr>
			                     <td>
			                       <input size='20' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/>
			                     </td>
			                     <td>
			                       <input name ='VALUE' size='20' value='$url'/>
			                     </td>
			                   </tr>";
			           }
			          ?>
			        </table>
			        <input type="button" value="ADD" onclick="addRowToTable('hdd', 20, 20);" />
			        <input type="button" value="REMOVE" onclick="removeRowToTable('hdd');" />
			        <br />
			        <br />
			        <input type="button" value="Save" onclick="updateAlternative('HDD');" />
			      </div>
			      <div id="MESSAGE" class="panel"><br><br>
			        <h3>XBMC Instances for Message Widget</h3>
			        <table id="table_msg">
			          <tr>
			            <td>Title</td>
			            <td>URL</td>
			          </tr>
			          <?php
			           $x = $config->get('MESSAGE');
			           foreach ($x as $title=>$url){
			             echo "<tr>
			                     <td>
			                       <input size='10' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/>
			                     </td>
			                     <td>
			                       <input size='40' name='VALUE' value='$url'/>
			                     </td>
			                   </tr>";
			           }
			           ?>
			        </table>
			        <input type="button" value="ADD" onclick="addRowToTable('msg', 10, 40);" />
			        <input type="button" value="REMOVE" onclick="removeRowToTable('msg');" />
			        <br />
			        <br />
			        <input type="button" value="Save" onclick="updateAlternative('MESSAGE');" />
			      </div>
			      <div id="SECURITY" class="panel"><br><br>
			        <h3>Security Settings</h3>
			        <table>
			          <tr>
			            <td align="right">
			              <p>MFP Authentication:</p>
			            </td>
			            <td align="left">
			              <p>
			                <input type="checkbox" name="PASSWORD_PROTECTED" <?php echo ($config->get('PASSWORD_PROTECTED','SECURITY') == "true")?'CHECKED':'';?> />
			              </p>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>USERNAME:</p>
			            </td>
			            <td align="left">
			              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','SECURITY')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>PASSWORD:</p>
			            </td>
			            <td align="left">
			              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','SECURITY')?>" />
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>MFPSECURED:</p>
			            </td>
			            <td align="left">
			              <p><input type="checkbox" name="mfpsecured" <?php echo ($config->get('mfpsecured','SECURITY') == "true")?'CHECKED':'';   ?>></p>
			            </td>
			          </tr>
			          <tr>
			            <td align="right">
			              <p>MFP API Key:</p>
			            </td>
			            <td align="left">
			              <input name="mfpapikey" type="password" size="20" value="<?php echo $config->get('mfpapikey','SECURITY')?>" />
			            </td>
			          </tr>
			        </table>
			        <input type="button" value="Save" onclick="updateSettings('SECURITY');" />
			      </div>
			      <div id="MODS" class="panel"><br><br>
					  <h3>CSS Modifications:</h3>
					  <table border="0" cellpadding="0" cellspacing="10">
						<tr>
						  <td><img class="widget" src="media/examples/lightheme.jpg" height="120px" /></td>
						  <td><img class="widget" src="media/examples/hernadito.jpg" height="120px" /></td>
						  <td><img class="widget" src="media/examples/dpickles.jpg" height="120px" /></td>
						  <td><img src="media/examples/black_modern_glass.jpg" height="120" class="widget" /></td>
						</tr>
						<tr>
						  <td><p>
							  <input type="radio" name="ENABLED" value="lighttheme" <?php echo ($config->get('ENABLED','MODS') == "lighttheme")?'CHECKED':'';?> />
							  Light Theme</p></td>
						  <td><p>
							  <input type="radio" name="ENABLED" value="hernandito" <?php echo ($config->get('ENABLED','MODS') == "hernandito")?'CHECKED':'';   ?> />
							  Hernandito's Theme</p></td>
						  <td><p>
							  <input type="radio" name="ENABLED" value="dpickles" <?php echo ($config->get('ENABLED','MODS') == "dpickles")?'CHECKED':'';?> />
							  DPickles Theme</p></td>
						  <td><p>
							  <input type="radio" name="ENABLED" value="black_modern_glass" <?php echo ($config->get('ENABLED','MODS') == "black_modern_glass")?'CHECKED':'';?> />
							  Black Modern Glass Theme</p></td>
						</tr>
						<tr>
						  <td><img src="media/examples/space6.jpg" height="120" class="widget" /></td>
						  <td><img class="widget" src="media/examples/minimal-posters.jpg" height="120px" /></td>
						  <td><img class="widget" src="media/examples/minimal-banners.jpg" height="120px" /></td>
						  <td><img src="media/examples/original.jpg" height="120" class="widget" /></td>
						</tr>
						<tr>
						  <td><p>
							  <input type="radio" name="ENABLED" value="space6" <?php echo ($config->get('ENABLED','MODS') == "space6")?'CHECKED':'';?> />
							  Space 6 Theme</p></td>
						  <td><p>
							  <input type="radio" name="ENABLED" value="comingepisodes-minimal-poster" <?php echo ($config->get('ENABLED','MODS') == "comingepisodes-minimal-poster")?'CHECKED':'';?> />
							  Minimal Posters</p></td>
						  <td><p>
							  <input type="radio" name="ENABLED" value="comingepisodes-minimal-banner" <?php echo ($config->get('ENABLED','MODS') == "comingepisodes-minimal-banner")?'CHECKED':'';?> />
							  Minimal Banners</p></td>
						  <td><input type="radio" name="ENABLED" value="" <?php echo ($config->get('ENABLED','MODS') == "")?'CHECKED':'';   ?> />
							OFF</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td colspan="2"><p>
							  <input type="button" value="Save" onClick="updateSettings('MODS');" />
							</p></td>
						  <td>&nbsp;</td>
						  </p>
						</tr>
					  </table>
					</div>
			      <div id="RSS" class="panel"><br><br>
			        <h3>RSS Feeds</h3>
			        <table id="table_rss">
			          <tr>
			            <td>Title</td>
			            <td>URL</td>
			          </tr>
			          <?php
			           $x = $config->get('RSS');
			           foreach ($x as $title=>$url){
			             echo "<tr>
			                     <td>
			                       <input size='40' name='TITLE' value='".urldecode(str_ireplace('_', ' ', $title))."'/>
			                     </td>
			                     <td>
			                       <input size='80' name='VALUE' value='$url'/>
			                     </td>
			                   </tr>";
			           }
			           ?>
			        </table>
			        <input type="button" value="ADD" onclick="addRowToTable('RSS', 40, 80);" />
			        <input type="button" value="REMOVE" onclick="removeRowToTable('RSS');" />
			        <br />
			        <br />
			        <input type="button" value="Save" onclick="updateAlternative('RSS');" />
			      </div>
			      <div id="CONTROL" class="panel"><br><br>
			        <h3>Control Widget Settings</h3>
			        <table id="table_control">
			          <tr>
			            <td>Title</td>
			            <td>URL</td>
			          </tr>
						    <?php
						    $x = $config->get('CONTROL');
						    foreach ($x as $title=>$url){
						      echo "<tr>
						              <td>
						                <input size='40' name='TITLE' value='".urldecode(str_ireplace('_', ' ', $title))."'/>
						              </td>
						              <td>
						                <input size='80' name='VALUE' value='$url'/>
						              </td>
						            </tr>";
						    }
						    ?>
			        </table>
			        <input type="button" value="ADD" onclick="addRowToTable('CONTROL', 40, 80);" />
			        <input type="button" value="REMOVE" onclick="removeRowToTable('CONTROL');" />
			        <br />
			        <br />
			        <input type="button" value="Save" onclick="updateAlternative('CONTROL');" />
			      </div>
			    </div>
			  </div>
        <!-- <input type="button" value="Save ALL" onclick="saveAll();">  -->
      </div>
    </div>  
  </center>
  <?php 
  }
  include "footer.php";
  ?>
</body>
</html>