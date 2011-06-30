<link href="/css/footer.css" rel="stylesheet" type="text/css">
<?php
include "config.php";
if(!empty($subnavlink)||!empty($subnavlink_blank)||!empty($subnavselect)){
	echo "<div style=\"width:100%; position: fixed; bottom: 0px;\" id='footer'>";
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
	echo "</div>";	
}
?>