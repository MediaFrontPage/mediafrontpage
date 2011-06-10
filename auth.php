<?php
require_once("config.php");
If (!$authsecured) {
    echo "<script>window.location = 'index.php';</script>";
    exit;
}
if (isset($_POST['user']) && isset($_POST['password'])) {
    if ($_POST['user']==$authusername && $_POST['password']==$authpassword) {
        // OK
        $_SESSION['loggedin'] = true;
        echo "<script>window.location = 'index.php';</script>";
        exit;
    } else {
?>
<html>
<head>
<title>Media Center</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/front.css" />
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
}
</style>
	<center><br><br><br>
	<form action="auth.php" method="post">
	<table class="widget" width=259 cellpadding=0 cellspacing=0 id=1>
	<tr style=cursor: move;>
	<td align=center height=25><div class="widget-head">MediaFrontPage Authentication</div></td>
	<tr>
	<td align=center height=25><br>Invalid Username and/or Password.</td>
	<tr>
	<td align=center height=25>&nbsp; &nbsp;</td>
	<tr>
	<td align=center height=25>Please try again.</td>
	<tr>
	<td align=center height=25>
	<input type="button" value="<< Back" onclick="history.go(-1);return false;" /><br><br>
	</td>
	</table>
	</form>
	</center>
	<?php
    }
} else {
    // not logging in
    echo "<script>window.location = 'login.php';</script>";
    exit;
}
?>