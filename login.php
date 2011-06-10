
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

<?php
if (file_exists('firstrun.php')){header('Location: servercheck.php');} 
echo "<center>";
echo  "<br>";
echo "<br><br>";

echo"<form action=\"auth.php\" method=\"post\">";

echo   "<table class=\"widget\" width=259 cellpadding=0 cellspacing=0 id=1>";
echo      "<tr style=\"cursor: move; \">";
echo        "<td align=center colspan=2 height=25><div class=\"widget-head\">MediaFrontPage Authentication</div></td>";

echo"<tr>";
echo        "<td align=left><br>&nbsp; &nbsp;Username:</td>";
echo"<td align=center>";
echo          "<br><input type='text' name=\"user\" size=15 />";
echo        "</td>";

echo"<tr>";
echo       "<td align=left>&nbsp; &nbsp;Password:</td>";
echo"<td align=center>";
echo         "<input type='password' name=\"password\" size=15 />";
echo        "</td>";

echo"<tr>";
echo       "<td align=center colspan=2>&nbsp;</td>";

echo"<tr>";
echo"<td align=center colspan=2>";
echo         "<input type='submit' value='Log in' /><br><br>";
echo        "</td>";

echo"</table>";
echo"</form>";

echo"</center>";
?>
</head>

</html>