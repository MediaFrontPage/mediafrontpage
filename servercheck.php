<html>
<head>
<title>MediaFrontPage Server Check</title>
<script type="text/javascript">
function redirect(){
	window.location = 'index.php';
}
</script>
<link href="css/front.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.widget {
	border:1px solid black;
	-moz-border-radius:6px 6px 6px 6px;
	border-radius:6px 6px 6px 6px;
	margin:0px 0px;
	box-shadow: 3px 3px 3px #000;
	background:#2C2D32;
}
.widget-head {
	-moz-border-radius:6px 6px 0px 0px;
	border-radius:6px 6px 0px 0px;
	background:#3d3d3d;
	border-bottom:1px solid black;
	width: 100%;
	height: 30px;
	line-height: 30px;
	font-weight:bold;
	cursor: move;
}
</style>
</head>
<body>
<center>
<br>
<br>
<br>
<table class="widget" width=300 cellpadding=0 cellspacing=0>
<tr>
  <td align=center colspan=2 height=25><div class="widget-head">Welcome to <a href="http://mediafrontpage.net/" target="_blank">MediaFrontPage</a></div></td>
<tr>
<td align=centre><br>
  If you have no text below,<br>
  your PHP is not working.<br>
  <br>
  <?php if(false){
}
else{}
$redirect = true;
$version = phpversion();
if(false){
?>
  If you have no text below, your PHP is not working.
<?php
}
else{}
$redirect = true;
$version = phpversion();

echo "<tr><td>PHP Version $version</td><td>";if($version > 5){echo "<img src='media/green-tick.png' height='15px'/>";}else{echo "<img src='media/red-cross.png' height='15px'/>";$redirect = false;} echo "</td></tr>";
if(extension_loaded('libxml')){
	echo "<tr><td>LibXML found</td><td><img src='media/green-tick.png' height='15px'/></td></tr>";
}else{
	echo "<tr><td>LibXML <b>NOT</b> found</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
	$redirect = false;
}
if(extension_loaded('curl')){
	echo "<tr><td>cURL found </td><td><img src='media/green-tick.png' height='15px'/></td></tr>";
}else{
	echo "<tr><td>cURL <b>NOT</b> found</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
	$redirect = false;
}
if (file_exists('config.ini')){
	echo "<tr><td>Config found. </td><td><img src='media/green-tick.png' height='15px'/></td></tr>";
}else{
	//echo "<tr><td><input type='button' value='config.ini' onclick=\"toggle('config'); \"/>  <b>NOT</b> found";
	if(file_exists('default-config.ini')){
		if(copy("default-config.ini", "config.ini")){
			echo "<tr><td>Config created successfully";
			echo "</td><td><img src='media/green-tick.png' height='15px'/></td></tr>";
		}
		else{
			echo "<tr><td>Config could not be created! Please check if permissions are correct";
			echo "</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
			$redirect = false;
		}
	} else {
		echo "<tr><td>No config file found please redownload MediaFrontPage.";
		echo "</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
		$redirect = false;
	}
}
if (file_exists('layout.php')){
	$valid = true;
	echo "<tr><td>layout.php found";
	if(!is_writable('layout.php')){
		if(@chmod("layout.php", 0777)){
			echo " and CHMODDED";
		}
		else{
			echo ", could not be written. Please CHMOD it.";
			$redirect = false;
			$valid = false;
		}
	}
	else{
		echo ", writeable";
	}
	echo ($valid)?"</td><td><img src='media/green-tick.png' height='15px'/></td></tr>":"</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
}else{
	echo '<tr><td>default-layout.php';
	$valid = true;
	if(file_exists("default-layout.php")){
		if(copy("default-layout.php", "layout.php")){
			echo " renamed successfully. ";
		}
	}
	else{
		echo " could not be found. ";
		$redirect = false;
		$valid = false;
	}
	if(file_exists("layout.php")){
		if(!is_writable('layout.php')){
			if(@chmod("layout.php", 0777)){
				echo " and CHMODDED";
			}
			else{
				echo ", could not be written. Please CHMOD it.";
				$redirect = false;
				$valid = false;
			}
		}
		else{
			echo ", writeable";
		}
	}
	echo ($valid)?"</td><td><img src='media/green-tick.png' height='15px'/></td></tr>":"</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
}
echo '</table>';
if($redirect){
	//echo "<script>setTimeout('redirect()', 5000);</script>";
	echo "<p>Congratulations! Everything seems to be in working order.</p>";
	echo "<p><input type='button' onclick=\"window.location = 'index.php';\" value='CONTINUE' /></p>";
	if (file_exists('firstrun.php')){
		unlink('firstrun.php');
	}
} else {
	echo "<p>It looks like some problems were found, please fix them then <input type=\"button\" value=\"reload\" onClick=\"window.location.reload()\"> the page.</p>";
	echo "<p>If further assistance is needed, please visit the <a href='http://forum.xbmc.org/showthread.php?t=83304' target='_blank'>forum</a> or our <a href='http://mediafrontpage.lighthouseapp.com' target='_blank'>project page</a>.</p>";
	echo "Attention WINDOWS users, please remember our WEB Server of choice for your platform is <a href='http://www.uniformserver.com/' target='_blank'>The Uniform Server</a>.";
}
?>
</body>
</html>