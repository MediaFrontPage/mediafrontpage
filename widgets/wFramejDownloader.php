<?php
$wIndex["wFramejDownloader"] = array("name" => "jDown", "type" => "inline", "function" => "widgetjDown();");

function widgetjDown() {
	require "config.php";
	echo "<iframe src='$jd_weburl' frameborder='0' scrolling='auto' width='99%' height='40%'></iframe>";
}

?>

