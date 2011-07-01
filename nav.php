<?php
//Authentication check
require_once('config.php');
if ($authsecured && (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<link rel="stylesheet" href="css/nav_style.css" type="text/css" charset="utf-8"/>
<div class="header"></div>
<ul id="navigation">
<li class="MFP"><a href="/"><H3>Widgets</H3></a></li>
<?php
if(!empty($navlink)){
	foreach( $navlink as $navlinklabel => $navlinkpath) {
echo "<li class=".$navlinklabel."><a href='".$navlinkpath."'><H3>".$navlinklabel."</H3></a></li>";
}
?>
<?php
//Logout button 
require_once('config.php');
if ($authsecured) {
  echo "<li class='logout'><a href='login.php' onclick='logout();'><H3>Logout</H3></a></li>";
	}
}
//<--LOGOUT-->
?>
</ul>
</div>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script> 
<script type="text/javascript">
            $(function() {
                var d=300;
                $('#navigation a').each(function(){
                    $(this).stop().animate({
                        'marginTop':'-80px'
                    },d+=150);
                });

                $('#navigation > li').hover(
                function () {
                    $('a',$(this)).stop().animate({
                        'marginTop':'-2px'
                    },200);
                },
                function () {
                    $('a',$(this)).stop().animate({
                        'marginTop':'-80px'
                    },200);
                }
            );
            });
        </script>