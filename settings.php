<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "widgets.php";
require_once "functions.php";

foreach (glob("widgets/*/w*.php") as $filename) {
	include_once $filename;
}

?>
<html>
	<head>
		<title>Media Front Page - Settings</title>
		<!--<link href="settings.css" rel="stylesheet" type="text/css" /> -->
		<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js"></script>
		<link href="style/css/front.css" rel="stylesheet" type="text/css" />	
		<link href="style/css/settings.css" rel="stylesheet" type="text/css" />	
	</head>
	<body>
		<div id="page">
			<div id="header">
				<ul>
<?php
// Get widgets
$widgets = getAllWidgets();
// Display menu
echo "\t\t\t\t<li class=\"menuitem global\"><a href=\"?w=Global\"><span>MediaFrontPage Settings</span></a></li>\n";
foreach($widgets as $widget) {
	if (isset($settings_init[$widget['Id']])) {
		echo "\t\t\t\t<li class=\"menuitem ".$widget['Id']."\"><a href=\"?w=".$widget['Id']."\"><span>".$widget['Title']."</span></a></li>\n";
	}
}
// If there are any updated settings add them to database
if (!empty($_POST)) {
	updateSettings($_POST);
}
?>
			</ul>
			</div><!-- #header -->
			<div id="main">
<?php
// If a widget has been selected then show its settings
if (!empty($_GET['w'])) {
	echo "\t\t\t\t<h1>".$_GET['w']." Settings</h1><br/>\n";
	$settingsDB = getAllSettings();
	echo "\t\t\t\t<form action='settings.php?w=".$_GET['w']."' method='post'>\n";
	foreach ($settingsDB as $setting) {
		if ($setting['Widget'] == $_GET['w'] ) {
			$setting['Value'] = unserialize($setting['Value']);
			if (is_array($setting['Value'])) {
				displaySettingItems($setting);
			} else {
				displaySetting($setting);
			}
		} 
	}
	echo "\t\t\t\t\t<div id='save' class='save'>\n";
	echo "\t\t\t\t\t\t<input type='submit' value='Save' />\n";
	echo "\t\t\t\t\t</div>\n";
	echo "\t\t\t\t</form>\n";
} 

?>
			</div><!-- #main -->
		    	<script type="text/javascript" src="style/js/jquery.js"></script>
			<script type="text/javascript" src="style/js/settings.js"></script>
		</div><!-- #page -->
	</body>
</html>

<?php

function updateSettings($post) {
	$i = 1;
	if (!empty($post)) {
		//echo print_r($post,1);
		foreach ($post as $id => $value) {
			// Create setting arrays
			$id = explode('-',$id);
			$settingId = $id[0];

			// Check if form item is part of a setting with multiple items
			if (isset($id[2])) {
				// Check if form item is new item (additem) or existing item	
				if (isset($id[3])) {
					if ($id[3] == 'additem') {
						// Handle new items
						if (!empty($value)) {	
							$settingsArrays[$settingId][$id[1]][$id[2]] = $value;	
							// If new item then make sure all setting parts are included (even if empty)
							foreach ( $settingsArrays[$settingId][$id[1]-1] as $type => $value) {
								if (!isset($settingsArrays[$settingId][$id[1]][$type])) {
									$settingsArrays[$settingId][$id[1]][$type] = "";
								}
							}		
							$i++;
						}
					}		
				} else  {
					// Handle existing items
					$settingsArrays[$settingId][$id[1]][$id[2]] = $value;					
					$i++;				
				}
			} else { 
				$settingsArrays[$settingId] = $value;
			}
		}
		foreach ($settingsArrays as $settingId => $settingValue) { 
			updateSetting($settingId, $settingValue);
		}

	} 
}
function displaySetting($setting) {
	echo "\t\t\t\t\t<div  class='section'>\n";
	$setting['Value'] = $setting['Value'];
	echo "\t\t\t\t\t\t<h3>".$setting['Label']."</h3>\n";
	echo "\t\t\t\t\t\t<input type='text' value='".$setting['Value']."' size='100'  name='".$setting['Id']."'  />\n";
	echo "\t\t\t\t\t</div><!--  .section -->\n";
}
function displaySettingItems($setting) {
	$items = $setting['Value'];
	$i = 1;
	if (!empty($items)) {

		echo "\t\t\t\t\t<ul class='section ui-sortable'>\n";
		echo "\t\t\t\t\t\t<h3>".$setting['Label']."</h3>\n";

		foreach ($items as $type => $item){
			echo "\t\t\t\t\t\t<li class='setting collapsed'>\n";
			echo "\t\t\t\t\t\t\t<div class='setting-head'>\n";
			if (isset($item['label'])) {
				echo "\t\t\t\t\t\t\t\t<h3>".ucwords($item['label'])."</h3>\n";
			} else {
				echo "\t\t\t\t\t\t\t\t<h3>".$type."</h3>\n";
				$noadditem = 'true';
			}
			echo "\t\t\t\t\t\t\t</div><!-- .setting-head -->\n";
			echo "\t\t\t\t\t\t\t<div class='setting-content'>\n";
			echo "\t\t\t\t\t\t\t\t<table>";
			foreach ($item as $label => $value) {
				if (empty($noadditem)) {
/* 	 				if($label=='enabled'){
	 					echo "<tr><td></td><td>Activated:<input type='checkbox' ";

	 					if($value== 'on' ||$value=='true'){
	 						echo "checked=\"checked\"";
	 						$value = 'true';
	 					}
	 					else{
	 						$value = 'false';
	 					}
	 					echo "name='".$setting['Id']."-".$i."-".$label."'  /></td></tr>";

	 				}
	 				else{
*/
					if(!strstr($label,'example')){
	 					echo "<tr><td>".ucwords($label).":</td><td><input type='text' value='".$value."' size='50' name='".$setting['Id']."-".$i."-".$label."'  /></td></tr>";
	 				}
				} else {
					echo "<tr><td>".ucwords($label).":</td><td><input type='text' value='".$value."' size='50' name='".$setting['Id']."-".$type."-".$label."'  /></td></tr>";
				}
			}
			echo "</table>\n";
			echo "\t\t\t\t\t\t\t</div><!-- .setting-content -->\n";
			echo "\t\t\t\t\t\t</li><!-- .setting -->\n";

			$i++;
		}
			if (empty($noadditem)) {
				echo "\t\t\t\t\t\t<div class='add'>\n";
				echo "\t\t\t\t\t\t\t<div class='setting-head'>\n";
				echo "\t\t\t\t\t\t\t\t<h3>Add New Item</h3>\n";
				echo "\t\t\t\t\t\t\t</div><!-- .setting-head -->\n";
				echo "\t\t\t\t\t\t\t<div class='setting-content'>\n";
				echo "\t\t\t\t\t\t\t\t<table>";

				foreach ($item as $label => $value) {
 					if(strstr($label,'example')){
						echo "<tr><td>Example:</td><td><font color='yellow'>$value</font></td></tr>";
 					}
 					else{
 						echo "<tr><td>".ucwords($label).":</td><td><input type='text' value='' size='50' name='".$setting['Id']."-".$i."-".$label."-additem'  /></td></tr>";			
 					}
				}			
				echo "</table>\n";
				echo "\t\t\t\t\t\t\t</div><!-- .setting-content -->\n";
				echo "\t\t\t\t\t\t</div><!-- .add -->\n";
			}

		echo "\t\t\t\t\t</ul><!-- .section -->\n";
	}
}


?>
