<?php
//Authentication check
require_once('config.php');
if ($authsecured && (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<?php
include "config.php";
echo "<html>";
echo "<head>";
echo "<title>Navigation</title>";
echo "<link rel='stylesheet' type='text/css' href='css/nav.css'>";
echo "<script type=\"text/javascript\" language=\"javascript\">";
echo 'function logout(){
     alert("Logging out");
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
          if(xmlhttp.responseText)
          {
            window.top.document.location.href = "login.php";
            alert("Logout successful");
          }
        }
      }
    xmlhttp.open("GET","logout.php",true);
    xmlhttp.send();
    }';
echo "</script>";
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
	echo "</div>";
}
//Logout button 
require_once('config.php');
if ($authsecured) {
  echo "<div id='nav-menu2' style='text-decoration: none; font-size:small; position:absolute; top:0; right:0;'>";
  echo "&nbsp; &nbsp;";
  echo "<ul><li><a href='#' onclick=\"logout();\"/>Logout</a></li></ul>";
 }
//<--LOGOUT-->

echo "</body>";
echo "</html>";
?>