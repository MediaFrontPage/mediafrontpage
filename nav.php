<?php
include "config.php";
echo "<html>";
echo "<head>";
echo "<title>Navigation</title>";
echo "<link rel='stylesheet' type='text/css' href='css/nav.css'>";
echo "</head>";
echo "<body>";
echo "<div id='header'>";
echo "<div id='home'>";
echo "<a href='./mediafrontpage.php' target='main'></a>";
echo "</div>";
echo "<div id='nav-menu'>";
echo "<ul>";
if(!empty($navlink)){
	foreach( $navlink as $navlinklabel => $navlinkpath) {
		echo "<li><a href='".$navlinkpath."' target='main'>".$navlinklabel."</a></li>";
	}
}
if(!empty($navlink_blank)){
	foreach( $navlink_blank as $navlinklabel => $navlinkpath) {
		echo "<li><a href='".$navlinkpath."' target='_blank'>".$navlinklabel."</a></li>";
	}
}

if(!empty($navselect)){
	echo "<select onchange=\"top.frames['main'].location.href = this.value;\">";
	echo "<option value='mediafrontpage.php' selected>MFP</option>";
	foreach($navselect as $navselectlabel => $navselectpath){
		echo "<option value='".$navselectpath."'>".$navselectlabel."</option>";

	}
	echo "</select>";
}

echo "</ul>";
echo "<div id='multiples' style='float:right;'>";
echo "<ul><select onchange=\"top.frames['main'].location.href = this.value;\">";
echo "<option value='mediafrontpage.php?layout=main'>MFP</option>";
echo "<option value='mediafrontpage.php?layout=download-f'>Downloads</option>";
echo "<option value='mediafrontpage.php?layout=manager-f'>Managers</option>";
echo "<option value='mediafrontpage.php?layout=research'>Browse</option>";
echo "</select></ul>";
echo "</div>";
echo "</div>";
echo "</div>";

if(!empty($subnavlink)||!empty($subnavlink_blank)||!empty($subnavselect)){
	echo "<div id='nav-menu2'>";
	//echo "<br> ";
	echo "<ul>";

	if(!empty($subnavlink)){
		foreach( $subnavlink as $navlinklabel => $navlinkpath) {
			echo "<li><a href='".$navlinkpath."' target='main'>".$navlinklabel."</a></li>";
		}
	}
	if(!empty($subnavlink_blank)){
		foreach( $subnavlink_blank as $navlinklabel => $navlinkpath) {
			echo "<li><a href='".$navlinkpath."' target='_blank'>".$navlinklabel."</a></li>";
		}
	}
	
/*
	if(!empty($subnavselect)){
		echo "<li><select onchange=\"top.frames['main'].location.href = this.value;\">";
		echo "<option value='mediafrontpage.php' selected></option>";
		foreach($subnavselect as $navselectlabel => $navselectpath){
			echo "<option value='$navselectpath'>".$navselectlabel."</option>";
		}
		echo "</select></li>";
	}
*/

	echo "</ul>";
	echo "</div>";
}
echo "</div>";
echo "</body>";
echo "</html>";
?>