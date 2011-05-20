<?php
$wIndex["wFrameSabzndb"] = array("name" => "jDown", "type" => "inline", "function" => "widgetFrameSabnzbd();");

function widgetFrameSabnzbd() {
	require "config.php";
	echo "<iframe src='$saburl' frameborder='0' scrolling='auto' width='99%' height='90%'></iframe>";
}

?>

