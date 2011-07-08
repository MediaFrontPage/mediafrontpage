<html>
<head>
<title>MediaFrontPage Server Check</title>
<script type="text/javascript">
function redirect(){
	window.location = 'index.php';
}
function toggle(div){
	if(document.getElementById(div).style.display == 'inline'){
		document.getElementById(div).style.display = 'none';
	}
	else{
		document.getElementById(div).style.display = 'inline';
	}
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
if (file_exists('config.php')){
	echo "<tr><td><input type='button' value='config.php' onclick=\"toggle('config'); \"/> found. </td><td><img src='media/green-tick.png' height='15px'/></td></tr>";
}else{
	echo "<tr><td><input type='button' value='config.php' onclick=\"toggle('config'); \"/>  <b>NOT</b> found";
	if(file_exists('default-config.php')){
	}
	echo "</td><td><img src='media/red-cross.png' height='15px'/></td></tr>";
	$redirect = false;
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
			echo " renamed successfully<br><br>";
		}
	}
	else{
		echo " could not be found<br>";
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
	if(file_exists('default-config.php') || file_exists('config.php')){
		$valid = true;
		if(file_exists('config.php')){
			$load = "config.php";
		}else{
			$load = "default-config.php";
		}
		if(isset($_POST['save_file']) && $_POST['save_file']) {
			if(file_exists('config.php')){
				$load = 'config.php';
			}else{
				if(copy("default-config.php", "config.php")){
					$load = 'config.php';
				}else{
					$load = 'default-config.php';
					$valid = false;
				}
			}
			$savecontent = stripslashes($_POST['savecontent']);
			$fp = @fopen($load, "w");
			if ($fp) {
				fwrite($fp, $savecontent);
				fclose($fp);
				if($valid){
					echo "
					<script>
						alert('Configuration saved successfully');
						window.location = 'servercheck.php';
					</script>";

				}else{
					echo "<script>alert('Unable to save configuration. Please open default-config.php in a text editor, fill in your information and save it as config.php.');</script>";
				}
				print '<a href='.$_SERVER['PHP_SELF'].'><input type="button" value="Refresh" /></a>';
				//print "<html><head><META http-equiv=\"refresh\" content=\"0;URL='".$_SERVER['PHP_SELF']."'\"></head><body>";

			}
		}
		$fp = @fopen($load, "r");
		$loadcontent = fread($fp, filesize($load));
		$lines = explode("\n", $loadcontent);
		$count = count($lines);
		$loadcontent = htmlspecialchars($loadcontent);
		fclose($fp);
		$line = '';
		for ($a = 1; $a < $count+1; $a++) {
			$line .= "$a\n";
		}
?>
<div id='config' style='display:none;'>
  <table class="widget" cellpadding=0 cellspacing=0 id=1>
    <tr style="cursor: move; ">
      <td align=center colspan=2 height=25><div class="widget-head">MediaFrontPage One-Time Setup (<?php echo $load; ?>)</div></td>
    <tr>
      <td align=right><form method=post action="<?php echo $_SERVER['PHP_SELF']?>">
          <table width="50%" valign="top" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="50%" align="right" valign="top"><pre style="color:#FF9522; text-align: right; padding: 2px; overflow: auto; border: 0px groove; font-size: 10px" name="lines" cols="5" rows="<?php echo $count+10;?>"><?php echo $line;?>
</pre></td>
              <td width="100%" align="center" valign="top"><textarea style="border:1px solid #2C2D32; background:#2C2D32; color:#666666; text-align: left;  padding-left: 3px; overflow: auto; font-size: 10px" name="savecontent" cols="160" rows="<?php echo $count;?>" wrap="OFF"><?php echo $loadcontent?>
	</textarea></td>
            </tr>
          </table>
          <input type="submit" name="save_file" value="Save">
        </form></td>
    </tr>
    </tr>

  </table>
  <p>&nbsp;</p>
</div>
<?php
}
?>
</body>
</html>