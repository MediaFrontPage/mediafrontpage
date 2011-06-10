<?php
//Check for config file and curl
if (file_exists('firstrun.php')){header('Location: servercheck.php');exit;}
//Authentication check
require_once('config.php');
if ($authsecured && (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
        echo "<script>window.location = 'login.php';</script>";
	exit;
}
// Redirect if on a mobile browser
require_once "m/mobile_device_detect.php";
if(mobile_device_detect(true,true,true,true,true,true,true,false,false) ) {
  echo "<script>window.location = 'm/';</script>";
  exit();
}
$submenu = false;
require_once "config.php";
  if(!empty($subnavlink)||!empty($subnavlink_blank)||!empty($subnavselect)){$submenu = true;}
?>
<html>
  <head>
    <title>Media Center</title>
    <link rel="shortcut icon" href="favicon.ico" />
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  </head>

  <frameset rows="<?php echo ($submenu)?"62px":"35px";?>, *" frameborder="0" border="0" framespacing="0">
    <frame src="nav.php" name="nav" noresize scrolling="no">
    <frame src="mediafrontpage.php" name="main" noresize scrolling="auto">
  </frameset>
  <noframes>
    <p>Your browser does not support frames</p>
  </noframes>
</html>
