<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--
   @author: Gustavo Hoirisch
  -->
<?php
require_once('class.ConfigMagik.php');
$config = new ConfigMagik('config.ini', true, true);

if(!empty($_GET)){
  if(!isset($_GET['section'])){ 
    echo 'ERROR'; 
    exit;
  } else {
    $section_name = $_GET['section'];
    unset($_GET['section']);
    try{
      $section = $config->get($section_name);
    } catch(Exception $e){
      echo 'Section '.$section_name.' does not exist!';
      exit;
    }
    echo 'UPDATING '.$section_name.' INFO';
    echo '<br>';
    foreach ($_GET as $var=>$value){
      if($config->get($var, $section_name) != null){
        $content = $config->get($var, $section_name);
        //echo '<script>alert("'.$content.'");</script>';  
        if($content || $content == ''){
          if($content==$value){
            echo '<b>'.$var.'</b>: No update required<br />';
          }
          else{
            try{
              $config->set($var, $value, $section_name);
              echo '<b>'.$var.'</b>: updated<br>';
            } catch(Exception $e) {
              echo 'Error! Updating variable: '.$var;
            }
          }
        } else {
          echo '<b>'.$var.'</b> does not exist<br>';
        }
      } else {
        $content = $config->set($var, $value, $section_name);
        echo '<b>'.$var.'</b>: '.$value.' (NEW)<br>';
      }
    }
    foreach ($section as $title=>$value){
      if(!isset($_GET[$title])){
        try{
          $config->removeKey($title, $section_name);
          echo '<b>'.$title.'</b>: removed <br />';
        } catch(Exception $e){
          echo 'Problem: '.$e;
        }
      }
    }
    $config->save();
  }
} else {
?>

<html>
<head>
    <title>Settings</title>
    <link href="css/front.css" rel="stylesheet" type="text/css">
    <link href="css/settings.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/fisheye-iutil.min.js"></script>
    <script type="text/javascript" src="js/settings.js"></script>
    <link rel="stylesheet" type="text/css" href="css/widget.css">
    <link rel="stylesheet" type="text/css" href="css/static_widget.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
  <center>
    <div style="width:90%; height:95%;" class="widget">
      <div class="widget-head">
        <h3>MediaFrontPage Settings</h3>
      </div>
      <div class="tabs">
        <a class="tab" onclick="showTab('global')">Global</a> 
        <a class="tab" onclick="showTab('Search_Widget')">Search Widget</a> 
        <a class="tab" onclick="showTab('Trakt_Widget')">Trakt.tv</a> 
        <a class="tab" onclick="showTab('NavBar_Section')">NavBar</a> 
        <a class="tab" onclick="showTab('HardDrive_Widget')">Hard Drives</a> 
        <a class="tab" onclick="showTab('Message_Widget')">Message Widget</a> 
        <a class="tab" onclick="showTab('Security')">Security</a> 
        <a class="tab" onclick="showTab('Mods')">CSS Modifications</a> 
        <a class="tab" onclick="showTab('RSS_Widget')">RSS Widget</a> 
        <a class="tab" onclick="showTab('Control_Widget')">Control Widget</a>
      </div>
      <div id="global" class="tabContent" style="display:block">
        <table>
          <tr>
            <td align="right">
              <p>Global URL:</p>
            </td>
            <td align="left">
              <p><input type="checkbox" name="ENABLED" class="global" <?php echo ($config->get('ENABLED','global')=="true")?'CHECKED':'';?>></p>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>IP:</p>
            </td>
            <td align="left">
              <input name="URL" size="20" class="global" value="<?php echo $config->get('URL','global')?>">
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>Global Authentication:</p>
            </td>
            <td align="left">
              <p>
                <input type="checkbox" name="AUTHENTICATION" class="global" <?php echo ($config->get('AUTHENTICATION','global') == "true")?'CHECKED':'';?>>
              </p>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>Username:</p>
            </td>
            <td align="left">
              <input name="USERNAME" size="20" class="global" value="<?php echo $config->get('USERNAME','global')?>">
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>Password:</p>
            </td>
            <td align="left"><input type="password" name="PASSWORD" size="20" class="global" value="<?php echo $config->get('PASSWORD','global')?>">
            </td>
          </tr>
        </table>
        <input type="button" value="Save" onclick="updateSettings('global');" />
      </div>
      <div id="XBMC" class="tabContent">
        <h3>XBMC</h3>
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
        <input type="button" value="Save" onclick="updateSettings('XBMC');" />
      </div>
      <div id="SICKBEARD" class="tabContent">
        <h3>Sickbeard</h3>
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
        <input type="button" value="Save" onclick="updateSettings('SICKBEARD');" />
      </div>
      <div id="COUCHPOTATO" class="tabContent">
        <h3>Couch Potato</h3>
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
        <input type="button" value="Save" onclick="updateSettings('COUCHPOTATO');" />
      </div>
      <div id="SABNZBD" class="tabContent">
        <h3>Sabnzbd+</h3>
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
              <input name="API" size="40" value="<?php echo $config->get('API','SABNZBD')?>" />
            </td>
          </tr>
        </table>
        <input type="button" value="Save" onclick="updateSettings('SABNZBD');" />
      </div>
      <div id="TRANSMISSION" class="tabContent">
        <h3>Transmission</h3>
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
        <input type="button" value="Save" onclick="updateSettings('TRANSMISSION');" />
      </div>
      <div id="UTORRENT" class="tabContent">
        <h3>uTorrent</h3>
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
        <input type="button" value="Save" onclick="updateSettings('UTORRENT');" />
      </div>
      <div id="JDOWNLOADER" class="tabContent">
        <h3>jDownloader</h3>
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
        <input type="button" value="Save" onclick="updateSettings('JDOWNLOADER');" />
      </div>
      <div id="Search_Widget" class="tabContent">
        <h3>Search Widget</h3>
        <table>
          <tr>
            <td align="right">
              <p>Preferred Site:</p>
            </td>
            <td align="left">
              <p>
                <input type="radio" name="preferred_site" value="1" <?php echo ($config->get('preferred_site','Search_Widget')=="1")?'CHECKED':'';?> />
                	NZB Matrix 
                <input type="radio" name="preferred_site" value="2" <?php echo ($config->get('preferred_site','Search_Widget')=="2")?'CHECKED':'';?> />
                	nzb.su
              </p>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>Preffered Category:</p>
            </td>
            <td align="left">
              <input name="preferred_categories" size="20" value="<?php echo $config->get('preferred_categories','Search_Widget')?>" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>NZB Matrix USERNAME:</p>
            </td>
            <td align="left">
              <input name="NZBMATRIX_USERNAME" size="20" value="<?php echo $config->get('NZBMATRIX_USERNAME','Search_Widget')?>" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>NZB Matrix API:</p>
            </td>
            <td align="left">
              <input name="NZBMATRIX_API" size="40" value="<?php echo $config->get('NZBMATRIX_API','Search_Widget')?>" />
              <a href="http://nzbmatrix.com/account.php"><img src="media/question.png" height="20px"></a>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>NZB.su API:</p>
            </td>
            <td align="left">
              <input name="NZBSU_API" size="40" value="<?php echo $config->get('NZBSU_API','Search_Widget')?>" />
              <a href="http://nzb.su/profile"><img src="media/question.png" height="20px"></a>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>NZB.su DL Code:</p>
            </td>
            <td align="left">
              <input name="NZB_DL" size="40" value="<?php echo $config->get('NZB_DL','Search_Widget')?>" />
              <a href="http://nzb.su/rss"><img src="media/question.png" height="20px"></a>
            </td>
          </tr>
        </table>
        <input type="button" value="Save" onclick="updateSettings('Search_Widget');" />
      </div>
      <div id="Trakt_Widget" class="tabContent">
        <h3>Trakt.tv</h3>
        <table>
          <tr>
            <td align="right">
              <p>Username:</p>
            </td>
            <td align="left"><input name="TRAKT_USERNAME" size="20" value="<?php echo $config->get('TRAKT_USERNAME','Trakt_Widget')?>" /></td>
          </tr>
          <tr>
            <td align="right">
              <p>Password:</p>
            </td>
            <td align="left">
              <input name="TRAKT_PASSWORD" type="password" size="20" value="<?php echo $config->get('TRAKT_PASSWORD','Trakt_Widget')?>" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>API:</p>
            </td>
            <td align="left">
              <input name="TRAKT_API" size="40" value="<?php echo $config->get('TRAKT_API','Trakt_Widget')?>" />
              <a href="http://trakt.tv/settings/api"><img src="media/question.png" height="20px"></a>
            </td>
          </tr>
        </table>
        <input type="button" value="Save" onclick="updateSettings('Trakt_Widget');" />
      </div>
      <div id="NavBar_Section" class="tabContent">
        <h3>Nav Links</h3>
        <table id='table_nav'>
          <tr>
            <td>Title</td>
            <td>URL</td>
          </tr>
          <?php
           $x = $config->get('NavBar_Section');
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
        <input type="button" value="Save & Reload" onclick="updateAlternative('NavBar_Section');top.frames['nav'].location.reload();" />
      </div>
      <div id="HardDrive_Widget" class="tabContent">
        <h3>Hard Drives</h3>
        <table id='table_hdd'>
          <tr>
            <td>Title</td>
            <td>Path</td>
          </tr>
          <?php
           $x = $config->get('HardDrive_Widget');
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
        <input type="button" value="Save" onclick="updateAlternative('HardDrive_Widget');" />
      </div>
      <div id="Message_Widget" class="tabContent">
        <h3>XBMC Instances for Message Widget</h3>
        <table id="table_msg">
          <tr>
            <td>Title</td>
            <td>URL</td>
          </tr>
          <?php
           $x = $config->get('Message_Widget');
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
        <input type="button" value="Save" onclick="updateAlternative('Message_Widget');" />
      </div>
      <div id="Security" class="tabContent">
        <h3>Security</h3>
        <table>
          <tr>
            <td align="right">
              <p>MFP Authentication:</p>
            </td>
            <td align="left">
              <p>
                <input type="checkbox" name="PASSWORD_PROTECTED" <?php echo ($config->get('PASSWORD_PROTECTED','Security') == "true")?'CHECKED':'';?> />
              </p>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>USERNAME:</p>
            </td>
            <td align="left">
              <input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','Security')?>" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>PASSWORD:</p>
            </td>
            <td align="left">
              <input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','Security')?>" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>MFPSECURED:</p>
            </td>
            <td align="left">
              <p><input type="checkbox" name="mfpsecured" <?php echo ($config->get('mfpsecured','Security') == "true")?'CHECKED':'';   ?>></p>
            </td>
          </tr>
          <tr>
            <td align="right">
              <p>MFP API Key:</p>
            </td>
            <td align="left">
              <input name="mfpapikey" size="20" value="<?php echo $config->get('mfpapikey','Security')?>" />
            </td>
          </tr>
        </table>
        <input type="button" value="Save" onclick="updateSettings('Security');" />
      </div>
      <div id="Mods" class="tabContent">
        <h3>CSS Modifications:</h3>
        <table>
          <tr>
            <td align="right"></td>
              <td align="left">
                  <p>
                    <input type="radio" name="ENABLED" value="lighttheme" <?php echo ($config->get('ENABLED','Mods')=="lighttheme")?'CHECKED':'';?> />Light Theme 
                    <input type="radio" name="ENABLED" value="hernandito" <?php echo ($config->get('ENABLED','Mods')=="hernandito")?'CHECKED':'';?> />Hernandito's Theme 
                    <input type="radio" name="ENABLED" value="black_velvet" <?php echo ($config->get('ENABLED','Mods')=="black_velvet")?'CHECKED':'';?> />Black Velvet Theme 
                    <input type="radio" name="ENABLED" value="comingepisodes-minimal-poster" <?php echo ($config->get('ENABLED','Mods')=="comingepisodes-minimal-poster")?'CHECKED':'';?> />Minimal Posters 
                    <input type="radio" name="ENABLED" value="comingepisodes-minimal-banner" <?php echo ($config->get('ENABLED','Mods')=="comingepisodes-minimal-banner")?'CHECKED':'';?> />Minimal Banners 
                    <input type="radio" name="ENABLED" value="" <?php echo ($config->get('ENABLED','Mods') == "")?'CHECKED':'';?> />OFF
                  </p>
                </td>
            </tr>
        </table><input type="button" value="Save" onclick="updateSettings('Mods');">
      </div>
      <div id="RSS_Widget" class="tabContent">
        <h3>RSS Feeds</h3>
        <table id="table_rss">
          <tr>
            <td>Title</td>
            <td>URL</td>
          </tr>
          <?php
           $x = $config->get('RSS_Widget');
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
        <input type="button" value="ADD" onclick="addRowToTable('rss', 40, 80);" />
        <input type="button" value="REMOVE" onclick="removeRowToTable('rss');" />
        <br />
        <br />
        <input type="button" value="Save" onclick="updateAlternative('RSS_Widget');" />
      </div>
      <div id="Control_Widget" class="tabContent">
        <h3>Control Widget</h3>
          <table id="table_control">
            <tr>
              <td>Title</td>
              <td>URL</td>
            </tr>
			      <?php
			      $x = $config->get('Control_Widget');
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
          <input type="button" value="ADD" onclick="addRowToTable('control', 40, 80);" />
          <input type="button" value="REMOVE" onclick="removeRowToTable('control');" />
          <br />
          <br />
          <input type="button" value="Save" onclick="updateAlternative('Control_Widget');" />
        </div>
        <!-- <input type="button" value="Save ALL" onclick="saveAll();">  -->
        <div id="result"></div>
      </div>
    </div>  
  </center>
	<div class="bottom">
	  <div id="dock">
		  <div class="dock-container">
		    <a class="dock-item" href="#" onclick="showTab('global')">
		      <img src="media/home_dock.png" alt="home">
		    </a>  
		    <a class="dock-item" href="#" onclick="showTab('XBMC')">
		      <img src="media/xbmc.png" alt="XBMC">
		    </a> 
		    <a class="dock-item" href="#" onclick="showTab('SICKBEARD')">
		      <img src="media/SickBeard.png" alt="Sickbeard">
		    </a> 
		    <a class="dock-item" href="#" onclick="showTab('COUCHPOTATO')">
		      <img src="media/CouchPotato.png" alt="CP">
		    </a>   
		    <a class="dock-item" href="#" onclick="showTab('SABNZBD')">
		      <img src="media/SabNZBd.png" alt="SabNZBd">
		    </a> 
		    <a class="dock-item" href="#" onclick="showTab('TRANSMISSION')">
		      <img src="media/Transmission.png" alt="Transmission">
		    </a> 
		    <a class="dock-item" href="#" onclick="showTab('UTORRENT')">
		      <img src="media/uTorrent.png" alt="uTorrent">
		    </a> 
		    <a class="dock-item" href="#" onclick="showTab('JDOWNLOADER')">
		      <img src="media/JDownloader.png" alt="JDownloader">
		    </a> 
		    </div><!-- end div .dock-container -->
		  </div><!-- end div .dock #dock -->
		</div>
</div>  
  <?php 
  }
  ?>
</body>
</html>
