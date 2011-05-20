<?php
$wIndex["wFrameTransmission"] = array("name" => "uTransmit", "type" => "inline", "function" => "widgetuTransmit();");
function widgetuTransmit() {
	require "config.php";
	echo "<iframe src='$transmission_web' frameborder='0' scrolling='auto' width='99%' height='40%'></iframe>";
}

?>

