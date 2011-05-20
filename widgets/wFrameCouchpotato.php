<?php
$wIndex["wFrameCouchpotato"] = array("name" => "uCouchpotato", "type" => "inline", "function" => "widgetuCouchpotato();");
function widgetuCouchpotato() {
	require "config.php";
	echo "<iframe src='$cp_url/movie/#zoom=50' frameborder='0' scrolling='auto' width='99%' height='87%'></iframe>";
}

?>

