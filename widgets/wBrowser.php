<?php
$wIndex["wBrowser"] = array("name" => "Browser", "type" => "inline", "function" => "widgetLinks();");

function widgetLinks() {

echo "<link rel='stylesheet' type='text/css' href='css/mybrowser.css'>";
	echo "<div id='nav-menu3'>";

		echo "<ul>
		<li><a href=http://www.themoviedb.org/ 			target='mfpbrowser'>TMDb</a></li>
		<li><a href=http://www.imdb.com/ 				target='mfpbrowser'>IMDb</a></li>
		<li><a href=http://www.joblo.com/digital/release_dates.php target='mfpbrowser'>DVD Releases</a></li>
		<li><a href=http://sharethe.tv/ 				target='mfpbrowser'>ShareThe.TV</a></li>
		<li><a href=http://x264-bb.com/ 				target='mfpbrowser'>x264-bb</a></li>
		<li><a href=http://www.demonoid.me/	 			target='mfpbrowser'>Demonoid</a></li>
		<li><a href=http://tehparadox.com/forum/f89/ 	target='mfpbrowser'>tehParadox</a></li>
		<li><a href=http://www.google.com 				target='mfpbrowser'>Google 4</a></li>
		</ul>";

	echo "</div><P>";
	echo "<iframe src='http://forum.xbmc.org/showthread.php?t=83304' frameborder='0' name='mfpbrowser'scrolling='auto' width='100%' height='100%' ></iframe>";


}

?>

