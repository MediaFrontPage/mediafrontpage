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
			?>
			
            
            
            <div id="WEBROOT" class="panel">
              <table>
                <tr>
                  <td colspan="2"><p align="justify" style="width: 500px;">Reverse Proxy changes your programs locations from http://serverip:port to http://serverip/programs. These also need to be edited within some of the programs you use. Further information on this is available from <a href="http://mediafrontpage.lighthouseapp.com/projects/76089/apache-configuration-hints" target="_blank">MediaFrontPage's Development Site</a>.</p></td>
                </tr>                
                <tr>
                  <td align="right"><p>Reverse Proxy:</p></td>
                  <td align="left"><p><input type="checkbox" title="Tick To Enable" name="ENABLED" <?php echo ($config->get('ENABLED','WEBROOT')=="true")?'CHECKED':'';?> /></p></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC:</p></td>
                  <td align="left"><input name="XBMC" size="20" title="XBMC's IP Address" value="<?php echo $config->get('XBMC','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Sickbeard:</p></td>
                  <td align="left"><input name="SICKBEARD" size="20" title="Sickbeard's IP Address" value="<?php echo $config->get('SICKBEARD','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Couch Potato:</p></td>
                  <td align="left"><input name="COUCHPOTATO" size="20" title="CouchPotato's IP Address" value="<?php echo $config->get('COUCHPOTATO','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>SabNZBd+:</p></td>
                  <td align="left"><input name="SABNZBD" size="20" title="SabNZBd+'s IP Address" value="<?php echo $config->get('SABNZBD','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>jDownloader:</p></td>
                  <td align="left"><input name="JDOWNLOADER" size="20" title="jDownloaders's IP Address" value="<?php echo $config->get('JDOWNLOADER','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Transmission:</p></td>
                  <td align="left"><input name="TRANSMISSION" size="20" title="Transmission's IP Address" value="<?php echo $config->get('TRANSMISSION','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>uTorrent:</p></td>
                  <td align="left"><input name="UTORRENT" size="20" title="uTorrent's IP Address" value="<?php echo $config->get('UTORRENT','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Headphones:</p></td>
                  <td align="left"><input name="HEADPHONES" size="20" title="HeadPhones's IP Address" value="<?php echo $config->get('HEADPHONES','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>SubSonic:</p></td>
                  <td align="left"><input name="SUBSONIC" size="20" title="SubSonic's IP Address" value="<?php echo $config->get('SUBSONIC','WEBROOT')?>" /></td>
                </tr>              
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('WEBROOT');" />
            </div>
            <div id="XBMC" class="panel">
              <br />
              <br />
              <a href="http://www.xbmc.org/" title="Go to XBMC's home page"><h3>XBMC</h3></a>
              <table>
                <tr>
                  <td colspan="2">
                    <p align="justify">To connect to XBMC, you need to enable these settings under Network Settings in XBMC.</p>
                    <p align="justify" style="padding-left:20px;">
                      &ndash; Allow control of XBMC via HTTP<br />
                      &ndash; Allow programs on this system to control XBMC<br />
                      &ndash; Allow programs on other systems to control XBMC.
                    </p>
                  </td>
                </tr>
                <tr>            
                  <td align="right"><p>XBMC IP:</p></td>
                  <td align="left"><input name="IP" title="Insert your XBMC IP Address" size="20" value="<?php echo $config->get('IP','XBMC')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC Port:</p></td>
                  <td align="left"><input name="PORT" title="Insert your XBMC Port" size="4" value="<?php echo $config->get('PORT','XBMC')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC Username:</p></td>
                  <td align="left"><input name="USERNAME" title="Insert your XBMC Username" size="20" value="<?php echo $config->get('USERNAME','XBMC')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC Password:</p></td>
                  <td align="left"><input type="password" title="Insert your XBMC Password" name="PASSWORD" size="20" value="<?php echo $config->get('PASSWORD','XBMC')?>" /></td>
                </tr>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('XBMC');" />
            </div>
            <div id="SICKBEARD" class="panel">
              <br />
              <br />
              <a href="http://www.sickbeard.com/" title="Go to SickBeard's home page"><h3>Sickbeard</h3></a>
                <table>
                  <tr>
                    <td colspan="2"><p>Enter the details where MediaFrontPage will find SickBeard.</p></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard IP:</p></td>
                    <td align="left"><input name="IP" title="Insert your SickBeard IP Address" size="20" value="<?php echo $config->get('IP','SICKBEARD')?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard Port:</p></td>
                    <td align="left"><input name="PORT" title="Insert your SickBeard Port" size="4" value="<?php echo $config->get('PORT','SICKBEARD')?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard Username:</p></td>
                    <td align="left"><input name="USERNAME" title="Insert your SickBeard Username" size="20" value="<?php echo $config->get('USERNAME','SICKBEARD')?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard Password:</p></td>
                    <td align="left"><input name="PASSWORD" title="Insert your SickBeard Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','SICKBEARD')?>" /></td>
                  </tr>
                </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SICKBEARD');" />
            </div>
            <div id="COUCHPOTATO" class="panel">
              <br />
              <br />
              <a href="http://www.couchpotatoapp.com" target="_blank" title="Visit CouchPotato"><h3>Couch Potato</h3></a>
							<table>
				        <tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find CouchPotato.</p></td>
								</tr>
								<tr>
									<td align="right"><p>Couch Potato IP:</p></td>
									<td align="left"><input name="IP" title="Insert your CouchPotato IP Address" size="20" value="<?php echo $config->get('IP','COUCHPOTATO')?>" /></td>
								</tr>
								<tr>
				          <td align="right"><p>Couch Potato Port:</p></td>
				          <td align="left"><input name="PORT" title="Insert your CouchPotato Port" size="4" value="<?php echo $config->get('PORT','COUCHPOTATO')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Couch Potato Username:</p></td>
								  <td align="left"><input name="USERNAME" title="Insert your CouchPotato Username" size="20" value="<?php echo $config->get('USERNAME','COUCHPOTATO')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Couch Potato Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your CouchPotato Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','COUCHPOTATO')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('COUCHPOTATO');" />
            </div>
            <div id="SABNZBD" class="panel">
              <br />
              <br />
              <a href="http://sabnzbd.org" title="Visit SabNZBd+" target="_blank"><h3>Sabnzbd+</h3></a>
							<table>
				        <tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find SabNZBd+.</p></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ IP:</p></td>
									<td align="left"><input name="IP" title="Insert your SabNZBd+ IP Address" size="20" value="<?php echo $config->get('IP','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your SabNZBd+ Port" size="4" value="<?php echo $config->get('PORT','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your SabNZBd+ Username" size="20" value="<?php echo $config->get('USERNAME','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your SabNZBd+ Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ API:</p></td>
									<td align="left"><input name="API" title="Insert your SabNZBd+ API" type="password" size="40" value="<?php echo $config->get('API','SABNZBD')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SABNZBD');" />
            </div>
            <div id="TRANSMISSION" class="panel">
              <br />
              <br />
              <a href="http://www.transmissionbt.com" target="_blank" title="Visit Transmission"><h3>Transmission</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find Transmission.</p></td>
								</tr>
								<tr>
									<td align="right"><p>Transmission IP:</p></td>
									<td align="left"><input name="IP" title="Insert your Transmission IP Address" size="20" value="<?php echo $config->get('IP','TRANSMISSION')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Transmission Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your Transmission Port" size="4" value="<?php echo $config->get('PORT','TRANSMISSION')?>" /></td>
								</tr>
								<tr>
				                	<td align="right"><p>Transmission Username:</p></td>
				                    <td align="left"><input name="USERNAME" title="Insert your Transmission Username" size="20" value="<?php echo $config->get('USERNAME','TRANSMISSION')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Transmission Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your Transmission Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','TRANSMISSION')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('TRANSMISSION');" />
            </div>
            <div id="UTORRENT" class="panel">
              <br />
              <br />
              <a href="http://www.utorrent.com" target="_blank" title="Visit uTorrent"><h3>uTorrent</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find uTorrent.</p></td>
								</tr>
								<tr>
									<td align="right"><p>uTorrent IP:</p></td>
									<td align="left"><input name="IP" title="Insert your uTorrent IP Address" size="20" value="<?php echo $config->get('IP','UTORRENT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>uTorrent Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your uTorrent Port" size="4" value="<?php echo $config->get('PORT','UTORRENT')?>" /></td>
								</tr>
								<tr>
				               		<td align="right"><p>uTorrent Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your uTorrent Username" size="20" value="<?php echo $config->get('USERNAME','UTORRENT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>uTorrent Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your uTorrent Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','UTORRENT')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('UTORRENT');" />
            </div>
            <div id="JDOWNLOADER" class="panel">
              <br />
              <br />
              <a href="http://jdownloader.org/home/index?s=lng_en" target="_blank" title="Visit jDownloader"><h3>jDownloader</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find jDownloader.</p></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader IP:</p></td>
									<td align="left"><input name="IP" title="Insert your jDownloader IP Address" size="20" value="<?php echo $config->get('IP','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader Web Port:</p></td>
				          <td align="left"><input name="WEB_PORT" title="Insert your jDownloader Web Port" size="4" value="<?php echo $config->get('WEB_PORT','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader Remote Port:</p></td>
									<td align="left"><input name="REMOTE_PORT" title="Insert your jDownloader Remote Port" size="4" value="<?php echo $config->get('REMOTE_PORT','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader Username:</p></td>
				          <td align="left"><input name="USERNAME" title="Insert your jDownloader Username" size="20" value="<?php echo $config->get('USERNAME','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
				          <td align="right"><p>jDownloader Password:</p></td>
				          <td align="left"><input name="PASSWORD" title="Insert your jDownloader Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','JDOWNLOADER')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('JDOWNLOADER');" />
            </div>
            <div id="SUBSONIC" class="panel">
              <br />
              <br />
              <a href="http://www.subsonic.org/pages/index.jsp" target="_blank" title="Visit SubSonic"><h3>SubSonic</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find SubSonic.</p></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic IP:</p></td>
									<td align="left"><input name="IP" title="Insert your SubSonic IP Address" size="20" value="<?php echo $config->get('IP','SUBSONIC')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your SubSonic Port" size="4" value="<?php echo $config->get('PORT','SUBSONIC')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your SubSonic Username" size="20" value="<?php echo $config->get('USERNAME','SUBSONIC')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your SubSonic Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','SUBSONIC')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onClick="updateSettings('SUBSONIC');" />
            </div>
            <div id="HEADPHONES" class="panel">
              <br />
              <br />
              <h3>HeadPhones</h3>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find HeadPhones.</p></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones IP:</p></td>
									<td align="left"><input name="IP" title="Insert your HeadPhones IP Address"  size="20" value="<?php echo $config->get('IP','HEADPHONES')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your HeadPhones Port"  size="4" value="<?php echo $config->get('PORT','HEADPHONES')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your HeadPhones Username"  size="20" value="<?php echo $config->get('USERNAME','HEADPHONES')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your HeadPhones Password"  size="20" type="password" value="<?php echo $config->get('PASSWORD','HEADPHONES')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onClick="updateSettings('HEADPHONES');" />
            </div>          
            <div id="SEARCH" class="panel">
              <h3>Search Widget</h3>
							<table>
								<tr>
									<td colspan="2"><p>Here you can specify your prefered Search criteria.</p></td>
								</tr><tr>
									<td align="right"><p>Preferred Index Site:</p></td>
									<td align="left">
									  <p>
									    <input type="radio" title="Defaults to NZBMatrix" name="preferred_site" value="1" <?php echo ($config->get('preferred_site','SEARCH')=="1")?'CHECKED':'';?> />NZB Matrix 
									    <input type="radio" title="Defaults to NZB.SU" name="preferred_site" value="2" <?php echo ($config->get('preferred_site','SEARCH')=="2")?'CHECKED':'';?> />NZB.SU
									  </p>
									</td>
								</tr>
								<tr>
									<td align="right"><p>Preferred Category:</p></td>
									<td align="left"><input name="preferred_categories" title="This denotes which Category you want to search by default from your Preferred Provider." size="20" value="<?php echo $config->get('preferred_categories','SEARCH')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>NZB Matrix Username:</p></td>
									<td align="left"><input name="NZBMATRIX_USERNAME" title="Insert your NZBMatrix Username" size="20" value="<?php echo $config->get('NZBMATRIX_USERNAME','SEARCH')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>NZB Matrix API:</p></td>
									<td align="left"><input name="NZBMATRIX_API" title="Insert your NZBMatrix API" type="password" size="40" value="<?php echo $config->get('NZBMATRIX_API','SEARCH')?>" /><a href="http://nzbmatrix.com/account.php" target="_blank" title="go to Account page"><img src="media/question.png" height="20px"></a></td>
								</tr>
								<tr>
									<td align="right"><p>NZB.SU API:</p></td>
									<td align="left"><Input name="NZBSU_API" title="Insert your NZB.SU API" type="password" size="40" value="<?php echo $config->get('NZBSU_API','SEARCH')?>" /><a href="http://nzb.su/profile" target="_blank" title="go to profile page"><img src="media/question.png" height="20px"></a></td>
								</tr>
								<tr>
				          <td align="right"><p>NZB.SU Download Code:</p></td>
									<td align="left"><input name="NZB_DL" title="Insert your NZB.SU Download Code" type="password" size="40" value="<?php echo $config->get('NZB_DL','SEARCH')?>" /><a href="http://nzb.su/rss" target="_blank" title="go to rss profile page"><img src="media/question.png" height="20px"></a></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SEARCH');" />
            </div>
            <div id="TRAKT" class="panel">
              <h3>Trakt.tv</h3>
							<table>
								<tr>
									<td colspan="2"><p>trakt.tv info</p></td>
								</tr>
								<tr>
									<td align="right"><p>trakt Username:</p></td>
									<td align="left"><input name="TRAKT_USERNAME" title="Insert your trakt.tv Username" size="20" value="<?php echo $config->get('TRAKT_USERNAME','TRAKT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>trakt Password:</p></td>
									<td align="left"><input name="TRAKT_PASSWORD" title="Insert your trakt.tv Password" type="password" size="20" value="<?php echo $config->get('TRAKT_PASSWORD','TRAKT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>trakt API:</p></td>
								  <td align="left"><input name="TRAKT_API" type="password" title="Insert your trakt.tv API"  ize="40" value="<?php echo $config->get('TRAKT_API','TRAKT')?>" /><a href="http://trakt.tv/settings/api" target="_blank"><img src="media/question.png" height="20px"></a></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('TRAKT');" />
            </div>
            <div id="NAVBAR" class="panel">
              <h3>Nav Links</h3>
							<p>Here are the Navigation Links you see at the top of your page. You can add or remove them depending on the programs and URL's you use.</p>
							<table id='table_nav'>
								<tr>
									<td>title</td>
									<td>URL</td>
								</tr>
								<?php
								  $x = $config->get('NAVBAR');
									foreach ($x as $title=>$url){
									  echo "<tr>
										 			  <td><input size='13' title='This will be the name in the Navigation Bar' name='title' value='".str_ireplace('_', ' ', $title)."'/></td>
													  <td><input name='VALUE' title='This will be the URL for ".str_ireplace('_', ' ', $title)."'  size='30' value='$url'/></td>
											    </tr>";
								  }
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('nav', 13, 30);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('nav');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save & Reload" onclick="updateAlternative('NAVBAR');setTimeout(top.frames['nav'].location.reload(), 5000);" />
            </div>
            <div id="SUBNAV" class="panel">
              <h3>SubNav Links</h3>
              <p style="width: 500px;" align="justify">Here are the Sub Navigation Links you see at the bottom of your page. You can add or remove any site you like. Simply give it a Title and a URL and it will show up on the Footer at the bottom of MediaFrontPage.</p>
							<table id='table_subnav'>
							  <tr>
									<td>Title</td>
									<td>URL</td>
								</tr>
								<?php
									$x = $config->get('SUBNAV');
									foreach ($x as $title=>$url){
										echo "<tr>
												    <td><input size='13' Title='Subnavigation label' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/></td>
												    <td><input name='VALUE' Title='Subnavigation URL' size='30' value='$url'/></td>
											    </tr>";
										 }
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('subnav', 13, 30);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('subnav');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save & Reload" onclick="updateAlternative('SUBNAV');setTimeout(top.frames['nav'].location.reload(), 5000);" />
            </div>
            <div id="HDD" class="panel">
              <h3>Hard Drives</h3>
							<p style="width: 500px;" align="justify">It does not matter what system it is running on, but you need to know where your media is stored on your HDD's.</p>
							<table id='table_hdd'>
								<tr>
									<td>Title</td>
									<td>Path</td>
								</tr>
								<?php
									$x = $config->get('HDD');
									foreach ($x as $title=>$url){
										echo "<tr>
											<td><input size='20' Title='Hard Drive name (the name in MFP, not necessarily the actual name)' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/></td>
											<td><input name ='VALUE' Title='Direct path to Hard Drive' size='20' value='$url'/></td>
											</tr>";
										}
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('hdd', 20, 20);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('hdd');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('HDD');" />
            </div>
            <div id="MESSAGE" class="panel">
              <h3>XBMC Instances for Message Widget</h3>
							<p align="justify" style="width: 500px;">Do you have multiple instance of XBMC with different IP Addresses/Port Numbers. IE - The Kids room or Kitchen? If so, the Message Widget can send customized messages to these machine. IE - "Turn it off" or "Cup of Coffee please".</p>
							<table id="table_msg">
								<tr>
									<td>Title</td>
									<td>URL</td>
								</tr>
								<?php
									$x = $config->get('MESSAGE');
									foreach ($x as $title=>$url){
										echo "<tr>
											<td><input size='10' Title='XBMC Name' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/></td>
											<td><input size='40' Title='XBMC IP Address & Port' name='VALUE' value='$url'/></td>
											</tr>";
										}
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('msg', 10, 40);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('msg');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('MESSAGE');" />
            </div>
            <div id="SECURITY" class="panel">
              <h3>Security</h3>
									<p>Worried someone could mess up your settings or interfere with your MediaFrontPage?</p>
							<table>
								<tr>
									<td align="right"><p>MediaFrontPage Authentication:</p></td>
									<td align="left"><p><input type="checkbox" name="PASSWORD_PROTECTED" <?php echo ($config->get('PASSWORD_PROTECTED','SECURITY') == "true")?'CHECKED':'';?> /></p></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage Username:</p></td>
									<td align="left"><input name="USERNAME" size="20" Title="Insert the desired MediaFrontPage Username" value="<?php echo $config->get('USERNAME','SECURITY')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage Password:</p></td>
									<td align="left"><input name="PASSWORD" size="20" Title="Insert the desired MediaFrontPage Password" type="password" value="<?php echo $config->get('PASSWORD','SECURITY')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage Secured with API:</p></td>
									<td align="left"><p><input type="checkbox" name="mfpsecured" <?php echo ($config->get('mfpsecured','SECURITY') == "true")?'CHECKED':''; ?>></p></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage API Key:</p></td>
									<td align="left"><input name="mfpapikey" Title="Type an API for MediaFrontPage - You can make this up" type="password" size="20" value="<?php echo $config->get('mfpapikey','SECURITY')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SECURITY');" />
            </div>
            <div id="MODS" class="panel">
              <h3>CSS Modifications:</h3>
              <p align="justify" style="width: 500px;">These are 'user created' CSS modifications submitted by some of our users. These change mainly the look and colours of MediaFrontPage. If you want to contribute your own modification, submit it to us on the <a href="http://forum.xbmc.org/showthread.php?t=83304" target="_blank">MediaFrontPage Support Thread</a>.</p>
              <table style="max-height:300px;">
                <tr align="center">
                  <td><img class="widget" src="media/examples/lightheme.jpg" height="100px" /></td>
                  <td><img class="widget" src="media/examples/hernadito.jpg" height="100px" /></td>
                  <td><img class="widget" src="media/examples/black_modern_glass.jpg" height="100px" /></td>
                </tr>
                <tr>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="lighttheme" <?php echo ($config->get('ENABLED','MODS') == "lighttheme")?'CHECKED':'';?> />
                    <p>Light Theme</p>
                  </td>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="hernandito" <?php echo ($config->get('ENABLED','MODS') == "hernandito")?'CHECKED':'';   ?>>
                    <p>Hernandito's Theme</p>
                  </td>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="black_modern_glass" <?php echo ($config->get('ENABLED','MODS') == "black_modern_glass")?'CHECKED':'';?> />
                    <p>Black Modern Glass Theme</p>
                  </td>
                </tr>
                <tr>
                  <td><img class="widget" src="media/examples/minimal-posters.jpg" height="100px" /></td>
                  <td><img class="widget" src="media/examples/minimal-banners.jpg" height="100px" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="comingepisodes-minimal-poster" <?php echo ($config->get('ENABLED','MODS') == "comingepisodes-minimal-poster")?'CHECKED':'';?> />
                    <p>Minimal Posters</p>
                  </td>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="comingepisodes-minimal-banner" <?php echo ($config->get('ENABLED','MODS') == "comingepisodes-minimal-banner")?'CHECKED':'';?> />
                    <p>Minimal Banners</p>
                  </td>
                  <td>
                    <input type="radio" name="ENABLED" value="" <?php echo ($config->get('ENABLED','MODS') == "")?'CHECKED':'';   ?> />
                    <p>OFF</p>
                  </td>
                </tr>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('MODS');" />
            </div>
            <div id="RSS" class="panel">
              <h3>RSS Feeds</h3>
              <p align="justify" style="width: 500px;">We also added an RSS Feed from the most popular NZB Sites so you can instantly grab an NZB from their Feeds and load it straight to SabNZBd+ with no other user intervention. The default/shown RSS is the first one on this list.</p>
              <table id="table_rss">
                <tr>
                  <td>title</td>
                  <td>URL</td>
                </tr>
                <?php
                 $x = $config->get('RSS');
                 foreach ($x as $title=>$url){
                   echo "<tr>
                           <td>
                             <input size='20' name='title' value='".urldecode(str_ireplace('_', ' ', $title))."'/>
                           </td>
                           <td>
                             <input size='40' name='VALUE' value='$url'/>
                           </td>
                         </tr>";
                 }
                 ?>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('rss', 20, 40);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('rss');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('RSS');" />
            </div>
            <div id="CONTROL" class="panel">
              <h3>Control Widget</h3>
              <p align="justify" style="width: 500px;">These commands are JSON API controls that directly communicate with the computer that MediaFrontPage is installed on. A few options are available. Will be added here soon.</p>
              <table id="table_control">
                <tr>
                  <td>title</td>
                  <td>URL</td>
                </tr>
                <?php
                $x = $config->get('CONTROL');
                foreach ($x as $title=>$url){
                  echo "<tr>
                          <td>
                            <input size='20' name='title' value='".urldecode(str_ireplace('_', ' ', $title))."'/>
                          </td>
                          <td>
                            <input size='40' name='VALUE' value='$url'/>
                          </td>
                        </tr>";
                }
                ?>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('control', 20, 40);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('control');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('CONTROL');" />
            </div>
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
