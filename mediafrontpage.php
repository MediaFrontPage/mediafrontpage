<?php
require_once "functions.php";
require_once "widgets.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');
// Add Widgets
foreach (glob("widgets/*/w*.php") as $widgetfile) {
	include_once $widgetfile;

	// Initialise widget 
	$$widget_init['Id'] = new widget ($widget_init, $widgetfile);
	
	if (!empty($$widget_init['Id']->Parts)) {
		foreach ($$widget_init['Id']->Parts as $part) {
			$$part['Id'] = new widget ($part, $widgetfile);
		}
	}
	// Add widget to database
	$$widget_init['Id']->addWidget();
	if (!empty($$widget_init['Id']->Parts)) {
		foreach ($$widget_init['Id']->Parts as $part) {
			$$part['Id']->addWidget();
		}
	}

}
// Global settings
$settings_init['Global'] =	array(  'navlinks' =>	array(	'label'	=>	'Navigation Bar Links',
								'value' =>	array(	'navlink1' =>	array(	
								
														'label' 	=> 'XBMC',
														'url'		=> 'http://localhost:8080'),
											'navlink2' =>	array(	
														'label' 	=> 'SickBeard',
														'url'		=> 'http://localhost:8080'),
											'navlink3' =>	array(	
														'label' 	=> 'Couch Potato',
														'url'		=> 'http://localhost:5000'),
											'navlink4' =>	array(	
														'label' 	=> 'Sabnzbd',
														'url'		=> 'http://localhost:8081'),
											'navlink5' =>	array(	
														'label' 	=> 'TV Headend',
														'url'		=> 'http://localhost:8080'),
											'navlink6' =>	array(	
														'label' 	=> 'Settings',
														'url'		=> 'settings.php?w=Global')
										)
								),
				'customstylesheets' =>	array(	'label'	=>	'Custom Stylesheets',
								'value' =>	array(	'customstylesheet1' =>	array(	'label' 	=> 'Light Theme',
															'path'	=> 'style/css/lighttheme.css',
															'enabled'	=> 'false'),
													'customstylesheet2' =>	array(	'label' 	=> 'Minimal Coming Episodes',
															'path'	=> 'style/css/comingepisodes-minimal-banner.css',
															'enabled'	=> 'false'),
													'customstylesheet3' =>	array(	'label' 	=> '3 Columns',
															'path'	=> 'style/layout/3col.css',
															'enabled'	=> 'true'),
													'customstylesheet3' =>	array(	'label' 	=> '4 Columns',
															'path'	=> 'style/layout/4col.css',
															'enabled'	=> 'false')
										)
								),
					'mfpsecured' =>	array(	'label'	=>	'MFP Secured',
								'value' =>	'false'),
					'mfpapikey' =>	array(	'label'	=>	'MFP API Key',
								'value' =>	'12345678923829482293882')
					);



// Add settings
addSettings($settings_init);

// Get widgets
$widgets = getAllWidgets();

//Get settings
$settingsDB = getAllSettings();

$settings = formatSettings($settingsDB);

?>
<html>
	<head>
		<title>Media Front Page</title>
		<script type="text/javascript" language="javascript" src="style/js/ajax.js"></script>
		<script type="text/javascript" language="javascript" src="style/js/popuptext.js"></script>
		<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="style/js/highslide/highslide.js"></script>
    	<script type="text/javascript" src="style/js/jquery.tablesorter.js"></script>
    	<script type="text/javascript" src="style/js/prettyPhoto/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" type="text/css" href="style/js/prettyPhoto/prettyPhoto.css" />
    	<script type="text/javascript" src="style/js/prettyLoader/js/jquery.prettyLoader.js"></script>
		<link rel="stylesheet" type="text/css" href="style/js/prettyLoader/css/prettyLoader.css" />
		<link rel="stylesheet" type="text/css" href="style/js/highslide/highslide.css" />
		<script type="text/javascript">
			//<![CDATA[
			// override Highslide settings here
			// instead of editing the highslide.js file
			hs.registerOverlay({
				html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
				position: 'top right',
				fade: 2 // fading the semi-transparent overlay looks bad in IE
			});
			
			hs.showCredits = false; 
			hs.graphicsDir = 'style/js/highslide/graphics/';
			hs.wrapperClassName = 'borderless';
			//hs.outlineType = 'outer-glow';
			//hs.outlineType = 'borderless';
			//hs.outlineType = 'rounded-white';
			hs.outlineType = null;
			//hs.wrapperClassName = 'outer-glow';
			hs.dimmingOpacity = 0.75;
			//]]>
		</script>
		<style type="text/css">
			.highslide-dimming {
				background: black;
			}
			a.highslide {
				border: 0;
			}
		</style>		
		<link href="style/css/widget.css" rel="stylesheet" type="text/css" />	
		<link href="style/css/front.css" rel="stylesheet" type="text/css" />
		<link href="style/layouts/3col-equal.css" rel="stylesheet" type="text/css" />

		<!-- START: Dynamic Header Inserts From Widgets -->
<?php
		// Render widget headers 
		foreach ($widgets as $widget) {
			$directory = dirname($widget['File']);
			$$widget['Id']->renderWidgetHeaders($directory);
		}    	

		$customstylesheets = $settings['customstylesheets'];

		if(!empty($customstylesheets)) {
			foreach ($customstylesheets as $customstylesheet) {
				if ($customstylesheet['enabled'] !== 'false') {
					echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".$customstylesheet['path']."\">\n";
				}
			}
		}
?>
		<!-- END: Dynamic Header Inserts From Widgets -->
		<script type="text/javascript">InitPopupBox();</script>
	</head>
	<body>
		<div id="main">
		<!-- START: Dynamic Inserts From Widgets -->
<?php
		$s = 1;
		while ( $s <= 3 ) {
			echo "\n\t<ul id=\"section-".$s."\" class=\"section ui-sortable\">\n";

			// Output widgets
			foreach ($widgets as $widget) {

				if ($widget['Section'] == $s) {
					// Don't give child widgets their own widget box				
					if ($widget['Child'] != 'true' && $widget['Type'] != 'empty') {
						echo "\t\t<li id=\"".$widget['Id']."\" class=\"widget\"";
		
						// Is widget collapsed
						if (!empty($widget["Display"])) {
							echo " ".$widget["Display"];
						}
						echo "\">";
						echo "\t\t\t<div class=\"widget-head\">";
						echo "\t\t\t\t<h3>".$widget['Title']."</h3>\n";
						echo "\t\t\t</div><!-- .widget-head -->\n";
						echo "\t\t\t<div class=\"widget-content\">\n";
						
						// Render parent widget
						$$widget['Id']->renderWidget($widget);
					
						// Render child widgets	
						if (!empty($widget['Parts']) && $widget['Type'] == 'mixed') {
							$parts = unserialize($widget['Parts']);
							foreach ($parts as $part) {
								$part_class = $part['Id'];
								$$part_class->renderWidget();
							}
						}			
						echo "\t\t\t</div><!-- .widget-content -->\n";
						echo "\t\t</li><!-- #".$widget['Id']." .widget -->\n";
					}
				}
			}
			echo "\n\t</ul><!-- #section-".$s." -->\n";
			$s++;  
		}
 ?>
		<!-- END: Dynamic Inserts From Widgets -->
		</div><!-- #main -->
	    	<script type="text/javascript" src="style/js/jquery.js"></script>
    		<script type="text/javascript" src="style/js/widget.js"></script>
	</body>
</html>

