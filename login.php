<html>
<head>
<title>Media Center</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/front.css" />
<link rel="stylesheet" type="text/css" href="css/static_widget.css" />
</head>

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
</html>