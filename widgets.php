<?php
require_once "config.php";
require_once "functions.php";

$wIndex = array();

foreach (glob("widgets/*.php") as $filename) {
    include_once $filename;
}

function renderWidget($widget, $params = "") {
	global $DEBUG;
	
	switch ($widget["type"]) {
		case "inline":
			if($DEBUG) { echo "\n<!-- Calling Function:".$widget["function"]." -->\n"; }
			eval($widget["function"]);
			echo "\n";
			break;
		case "ajax":
			echo "\n\t\t\t<div id=\"".$widget["block"]."\"></div>\n";
			break;
		case "header":
			//Support header only widgets.
			break;
		case "mixed":
			foreach( $widget["parts"] as $widgetsub ) {
				renderWidget($widgetsub);
			}
			break;
		default:	
			if(!empty($widget)) {
				echo "\n\n<strong>INVALID WIDGET SPECIFIED (".$widget["block"].") in section ".$sectionId."</strong>\n<pre>".print_r($widget)."</pre>\n";
			}
	}
}
//Support the Widget "sytlesheet", "headerfunction", "headerinclude", "script" properties
function renderWidgetHeaders($widget, $params = "") {
	global $DEBUG;
	
	switch ($widget["type"]) {
		case "ajax":
			echo "\t\t<script type=\"text/javascript\" language=\"javascript\">\n";
			
			$loader = (!empty($widget["loader"])) ? $widget["loader"] : "ajaxPageLoad('".$widget["call"]."', '".$widget["block"]."');"; 
			if((int)$widget["interval"] > 0) {
				echo "\t\t\tvar ".$widget["block"]."_interval = setInterval(\"".$loader."\", ".$widget["interval"].");\n";
			}
			echo "\t\t\t".$loader."\n";
			echo "\t\t</script>\n";
			break;
		case "mixed":
			foreach( $widget["parts"] as $widgetsub ) {
				renderWidgetHeaders($widgetsub);
			}
			break;
	}
	if(!empty($widget["stylesheet"]) && (strlen($widget["stylesheet"]) > 0)) {
		echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".$widget["stylesheet"]."\">\n";
	}
	if(!empty($widget["script"]) && (strlen($widget["script"]) > 0)) {
		echo "\t\t<link type=\"text/javascript\" language=\"javascript\ src=\"".$widget["script"]."\">\n";
	}
	if(!empty($widget["headerinclude"]) && (strlen($widget["headerinclude"]) > 0)) {
		echo "\t\t".$widget["headerinclude"]."\n";
	}
	if(!empty($widget["headerfunction"]) && (strlen($widget["headerfunction"]) > 0)) {
		if($DEBUG) { echo "\n<!-- Calling Function:".$widget["headerfunction"]." -->\n"; }
		eval($widget["headerfunction"]);
	}
}

?>
