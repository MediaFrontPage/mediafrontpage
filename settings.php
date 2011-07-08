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
		$section_name = (string) $_GET['section'];
		unset($_GET['section']);
		$section = $config->get($section_name);
		if(empty($section)){
			echo 'Section '.$section_name.' does not exist!';
			exit;
		}
		echo 'UPDATING '.$section_name.' INFO';
		echo '<br>';
		foreach ($_GET as $var=>$value){
			$var = (string) $var;
			$value = (string) $value;
			$content = $config->get($var, $section_name);
			//echo '<script>alert("'.$content.'");</script>';	
				if($content || $content == ''){
					if($content==$value){
						echo $var.' => No update required<br />';
					}
					else{
						try{
							$config->set($var, $value, $section_name);
							echo '<b>'.$var.'</b> :';
							echo ' updated';
							echo '<br>';
						} catch(Exception $e) {
							echo 'Error!';
						}
					}
				}
				else{
					echo '<b>'.$var.'</b> does not exist<br>';
				}
		}
	}
}else{
?>

<html>
<head>
    <title>Settings</title>
    <link href="css/front.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js"></script>
    <style type="text/css">

    div.tabs {
    font-size: 80%;
    font-weight: bold;
    }

    a.tab {
    border-bottom-width: 0px;
    padding: 2px 1em 2px 1em;
    text-decoration: none;
    cursor: pointer;
    }

    a.tab, a.tab:visited {
    color: #808080;
    }

    a.tab:hover {
    background-color: #d0d0d0;
    color: #606060;
    }


    /*
    * note that by default all tab content areas
    * have display set to 'none'
    */
    div.tabContent {
    padding: 4px;
    display: none;
    }
    </style>
    <script type="text/javascript">

      // this is a bit of a hack here
      // just list the tab content divs here
      var tabs = ["global","XBMC", "SICKBEARD", "COUCHPOTATO", "SABNZBD", "TRANSMISSION", "UTORRENT", "JDOWNLOADER", "Search_Widget", "Trakt_Widget", "NavBar_Section", "HardDrive_Widget", "Message_Widget", "Security"];

      function showTab( tab ){

        // first make sure all the tabs are hidden
        for(i=0; i < tabs.length; i++){
          var obj = document.getElementById(tabs[i]);
          obj.style.display = "none";
        }
          
        // show the tab we're interested in
        var obj = document.getElementById(tab);
        obj.style.display = "block";
        document.getElementById('result').innerHTML = '';

      
      }
	
	function updateSettings(section){
		var contents = document.getElementById(section).getElementsByTagName('input');
		//$("#result").html(contents);
		var params = 'section='+section; 
		for(i=0;i<contents.length;i++){
			//alert(contents[i].name+'='+contents[i].value);
			var value = contents[i].value;
			if(contents[i].type == 'checkbox'){
				if(contents[i].value == 'on'){
					value = 'true';
				} else {
					value = 'false';
				}
			}
			if(contents[i].type == 'radio'){
				var name = contents[i].name;
				while(contents[i].type == 'radio'){
					if(contents[i].checked && contents[i].name == name){
						//alert(contents[i].name+' '+contents[i].value);
						value = contents[i].value;
						params = params+'&'+contents[i].name+'='+encodeURIComponent(value);
					}
					i++;
				}
				i--;
			}
			else if(contents[i].name != ''){
				params = params+'&'+contents[i].name+'='+value;
			}
		}
		//alert(params);
	    $.ajax(
	    {
	        type: 'GET',
	        url: "settings.php?"+params,
	        beforeSend: function ()
	        {
	            // this is where we append a loading image
           	    $("#result").html('Saving');
	        },
	        success: function (data)
	        {
	            // successful request; do something with the data
	            $("#result").html(data);
           	    //$("#result").html('Saved');
	        },
	        error: function ()
	        {
	            // failed request; give feedback to user
	            alert("Sorry, but I couldn't create an XMLHttpRequest");
	        }
	    });

	}
	
	function addRowToTable(section, size1, size2)
	{
	  var tbl = document.getElementById('table_'+section);
	  var lastRow = tbl.rows.length;
	  // if there's no header row in the table, then iteration = lastRow + 1
	  var iteration = lastRow;
	  var row = tbl.insertRow(lastRow);
	  	  
	  // left cell
	  var cellLeft = row.insertCell(0);
	  var el = document.createElement('input');
	  el.type = 'text';
	  el.name = 'TITLE';
	  el.size = size1;
	  
	  cellLeft.appendChild(el);
	  
	  // select cell
	  var cellRightSel = row.insertCell(1);
	  var sel = document.createElement('input');
	  sel.name = 'VALUE';
	  sel.type = 'text';
	  sel.size = size2;
	  cellRightSel.appendChild(sel);
	}

	function removeRowToTable(section){
		var tbl = document.getElementById('table_'+section);
	  var lastRow = tbl.rows.length;
  	if (lastRow > 2) tbl.deleteRow(lastRow - 1);
	}
    </script>
</head>

<body>
    <h1>MediaFrontPage Settings</h1>
    <center>
    <div class="tabs">
        <a class="tab" onclick="showTab('global')">Global</a> <a class="tab" onclick="showTab('XBMC')">XBMC</a> <a class="tab" onclick="showTab('SICKBEARD')">Sickbeard</a> <a class="tab" onclick="showTab('COUCHPOTATO')">CouchPotato</a> <a class="tab" onclick="showTab('SABNZBD')">SabNZBd+</a> <a class="tab" onclick="showTab('TRANSMISSION')">Transmission</a> <a class="tab" onclick="showTab('UTORRENT')">uTorrent</a> <a class="tab" onclick="showTab('JDOWNLOADER')">jDownloader</a> <a class="tab" onclick="showTab('Search_Widget')">Search Widget</a> <a class="tab" onclick="showTab('Trakt_Widget')">Trakt.tv</a> <a class="tab" onclick="showTab('NavBar_Section')">NavBar</a> <a class="tab" onclick="showTab('HardDrive_Widget')">Hard Drives</a> <a class="tab" onclick="showTab('Message_Widget')">Message Widget</a>	<a class="tab" onclick="showTab('Security')">Security</a>
    </div>
</center>
        <div id="global" class="tabContent" style="display:block">
            <center>
                <table>
                    <tr>
                        <td align="right">
                            <p>Global URL:</p>
                        </td>

                        <td align="left">
                            <p><input type="checkbox" name="ENABLED" class="global" <?php echo ($config->get('ENABLED','global') == "true")?'CHECKED':'';   ?> ></p>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="URL" size="20" class="global" value="<?php echo $config->get('URL','global')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>Global Authentication:</p>
                        </td>

                        <td align="left">
                            <p><input type="checkbox" name="AUTHENTICATION" class="global"  <?php echo ($config->get('AUTHENTICATION','global') == "true")?'CHECKED':'';?> ></p>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>Username:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" class="global" value="<?php echo $config->get('USERNAME','global')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>Password:</p>
                        </td>

                        <td align="left"><input type="password" name="PASSWORD" size="20" class="global" value="<?php echo $config->get('PASSWORD','global')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('global');">

            </center>
        </div>

        <div id="XBMC" class="tabContent">
            <center>
            <h3>XBMC</h3>
                <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','XBMC')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PORT:</p>
                        </td>

                        <td align="left"><input name="PORT" size="4" value="<?php echo $config->get('PORT','XBMC')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','XBMC')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input type="password" name="PASSWORD" size="20" value="<?php echo $config->get('PASSWORD','XBMC')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('XBMC');">
            </center>
        </div>

        <div id="SICKBEARD" class="tabContent">
            <center>
             <h3>Sickbeard</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','SICKBEARD')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PORT:</p>
                        </td>

                        <td align="left"><input name="PORT" size="4" value="<?php echo $config->get('PORT','SICKBEARD')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','SICKBEARD')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','SICKBEARD')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('SICKBEARD');">
            </center>
        </div>

        <div id="COUCHPOTATO" class="tabContent">
            <center>
             <h3>Couch Potato</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','COUCHPOTATO')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PORT:</p>
                        </td>

                        <td align="left"><input name="PORT" size="4" value="<?php echo $config->get('PORT','COUCHPOTATO')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','COUCHPOTATO')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','COUCHPOTATO')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('COUCHPOTATO');">
            </center>
        </div>

        <div id="SABNZBD" class="tabContent">
            <center>
            <h3>Sabnzbd+</h3>
                <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','SABNZBD')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PORT:</p>
                        </td>

                        <td align="left"><input name="PORT" size="4" value="<?php echo $config->get('PORT','SABNZBD')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','SABNZBD')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','SABNZBD')?>"></td>
                    </tr>
                    
                    <tr>
                        <td align="right">
                            <p>API:</p>
                        </td>

                        <td align="left"><input name="API" size="40" value="<?php echo $config->get('API','SABNZBD')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('SABNZBD');">
            </center>
        </div>

        <div id="TRANSMISSION" class="tabContent">
            <center>
             <h3>Transmission</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','TRANSMISSION')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PORT:</p>
                        </td>

                        <td align="left"><input name="PORT" size="4" value="<?php echo $config->get('PORT','TRANSMISSION')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','TRANSMISSION')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','TRANSMISSION')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('TRANSMISSION');">
            </center>
        </div>
        <div id="UTORRENT" class="tabContent">
            <center>
             <h3>uTorrent</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','UTORRENT')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PORT:</p>
                        </td>

                        <td align="left"><input name="PORT" size="4" value="<?php echo $config->get('PORT','UTORRENT')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','UTORRENT')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','UTORRENT')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('UTORRENT');">
            </center>
        </div>
        <div id="JDOWNLOADER" class="tabContent">
            <center>
             <h3>jDownloader</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>IP:</p>
                        </td>

                        <td align="left"><input name="IP" size="20" value="<?php echo $config->get('IP','JDOWNLOADER')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>WEB PORT:</p>
                        </td>

                        <td align="left"><input name="WEB_PORT" size="4" value="<?php echo $config->get('WEB_PORT','JDOWNLOADER')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>REMOTE PORT:</p>
                        </td>

                        <td align="left"><input name="REMOTE_PORT" size="4" value="<?php echo $config->get('REMOTE_PORT','JDOWNLOADER')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" value="<?php echo $config->get('USERNAME','JDOWNLOADER')?>"></td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" type="password" value="<?php echo $config->get('PASSWORD','JDOWNLOADER')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('JDOWNLOADER');">
            </center>
        </div>
        <div id="Search_Widget" class="tabContent">
            <center>
             <h3>Search Widget</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>Preferred Site:</p>
                        </td>

                        <td align="left"><p><input type="radio" name="preferred_site" value="1" <?php echo ($config->get('preferred_site','Search_Widget') == "1")?'CHECKED':'';   ?> >NZB Matrix</input> 
                        <input type="radio" name="preferred_site" value="2" <?php echo ($config->get('preferred_site','Search_Widget') == "2")?'CHECKED':'';   ?> >nzb.su</input></p></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>NZB Matrix USERNAME:</p>
                        </td>

                        <td align="left"><input name="NZBMATRIX_USERNAME" size="20" value="<?php echo $config->get('NZBMATRIX_USERNAME','Search_Widget')?>"></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>NZB Matrix API:</p>
                        </td>

                        <td align="left"><input name="NZBMATRIX_API" size="40" value="<?php echo $config->get('NZBMATRIX_API','Search_Widget')?>"></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>NZB.su API:</p>
                        </td>

                        <td align="left"><input name="NZBSU_API" size="40" value="<?php echo $config->get('NZBSU_API','Search_Widget')?>"></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>NZB.su DL Code:</p>
                        </td>

                        <td align="left"><input name="NZB_DL" size="20" value="<?php echo $config->get('NZB_DL','Search_Widget')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('Search_Widget');">
            </center>
        </div>
        <div id="Trakt_Widget" class="tabContent">
            <center>
             <h3>Trakt.tv</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>Username:</p>
                        </td>

                        <td align="left"><input name="TRAKT_USERNAME" size="20" value="<?php echo $config->get('TRAKT_USERNAME','Trakt_Widget')?>"></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>Password:</p>
                        </td>

                        <td align="left"><input name="TRAKT_PASSWORD" type="password" size="20" value="<?php echo $config->get('TRAKT_PASSWORD','Trakt_Widget')?>"></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>API:</p>
                        </td>

                        <td align="left"><input name="TRAKT_API" size="40" value="<?php echo $config->get('TRAKT_API','Trakt_Widget')?>"></td>
                    </tr>
                </table>
                <input type="button" value="Save" onclick="updateSettings('Trakt_Widget');">
            </center>
        </div>
        <div id="NavBar_Section" class="tabContent">
            <center>
             <h3>Nav Links</h3>
               <table id='table_nav'>
	               <tr><td>Title</td><td>URL</td></tr>
	               <?php
	               $x = $config->get('NavBar_Section');
	               foreach ($x as $title=>$url){
	                   echo "<tr><td><input size='10' name='TITLE' value='$title'/></td><td><input name='VALUE' size='30' value='$url'/></td></tr>";
	               }
	               ?>
               </table>
               <input type="button" value="ADD" onclick="addRowToTable('nav', 10, 30);" /><input type="button" value="REMOVE" onclick="removeRowToTable('nav');" />
            </center>
        </div>
        <div id="HardDrive_Widget" class="tabContent">
            <center>
             <h3>Hard Drives</h3>
               <table id='table_hdd'>
               <tr><td>Title</td><td>Path</td></tr>
               <?php
               $x = $config->get('HardDrive_Widget');
               foreach ($x as $title=>$url){
                   echo "<tr><td><input size='20' name='TITLE' value='$title'/></td><td><input name ='VALUE' size='20' value='$url'/></td></tr>";
               }
               ?>
               </table>
               <input type="button" value="ADD" onclick="addRowToTable('hdd', 20, 20);" /><input type="button" value="REMOVE" onclick="removeRowToTable('hdd');" />
            </center>
        </div>
        <div id="Message_Widget" class="tabContent">
            <center>
             <h3>XBMC Instances for Message Widget</h3>
               <table id="table_msg">
               <tr><td>Title</td><td>URL</td></tr>
               <?php
               $x = $config->get('Message_Widget');
               foreach ($x as $title=>$url){
                   echo "<tr><td><input size='10' name='TITLE' value='$title'/></td><td><input size='40' name='VALUE' value='$url'/></td></tr>";
               }
               ?>
               </table>
               <input type="button" value="ADD" onclick="addRowToTable('msg', 10, 40);" /><input type="button" value="REMOVE" onclick="removeRowToTable('msg');" />
            </center>
        </div>
        <div id="Security" class="tabContent">
            <center>
             <h3>Security</h3>
               <table>
                    <tr>
                        <td align="right">
                            <p>MFP Authentication:</p>
                        </td>

                        <td align="left">
                            <p><input type="checkbox" name="PASSWORD_PROTECTED" class="global" <?php echo ($config->get('PASSWORD_PROTECTED','Security') == "true")?'CHECKED':'';   ?> ></p>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <p>USERNAME:</p>
                        </td>

                        <td align="left"><input name="USERNAME" size="20" class="global" value="<?php echo $config->get('USERNAME','Security')?>"></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <p>PASSWORD:</p>
                        </td>

                        <td align="left"><input name="PASSWORD" size="20" class="global" type="password" value="<?php echo $config->get('PASSWORD','Security')?>"></td>
                    </tr>
               </table>
                <input type="button" value="Save" onclick="updateSettings('Security');">
            </center>
        </div>
        <center><div id="result"></div></center>
</body>
</html>
<?php 
}
?>