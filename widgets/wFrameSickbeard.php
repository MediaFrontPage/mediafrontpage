<?php
$wIndex["wFrameSickbeard"] = array("name" => "uSickbeard", "type" => "inline", "function" => "widgetuSickbeard();");
function widgetuSickbeard() {
	require "config.php";
	echo "<iframe src='$sickbeardurl' frameborder='0' scrolling='auto' width='99%' height='87%'></iframe>";
}

?>

