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
			include "headphones.php";
			?>
			            
                      
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
