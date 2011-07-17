<?php
//Authentication check
require_once('config.php');
if ($authsecured && (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
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
?>
		<link rel="stylesheet" href="css/nav_style.css" type="text/css" charset="utf-8"/>
		<link href="css/widget.css" rel="stylesheet" type="text/css" />	
		<link href="css/front.css" rel="stylesheet" type="text/css" />	
        
        		<!-- START: Dynamic Header Inserts From Widgets -->
<?php
		if(!empty($customStyleSheet)) {
			echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".$customStyleSheet."\">\n";
		}
?>
		<!-- END: Dynamic Header Inserts From Widgets -->
		<div class="header"></div>
<ul id="navigation">
<li><a href="./" style='background-image: url(./media/nav/mfp.png)'><H3>Widgets</H3></a></li>
<?php
if(!empty($navlink)){
	foreach( $navlink as $navlinklabel => $navlinkpath) {
    if(!is_array($navlinkpath)){
      $image = (file_exists('./media/nav/'.$navlinklabel.'.png')) ? $navlinklabel : 'default';
      echo "<li><a href='".$navlinkpath."' style='background-image: url(./media/nav/".$image.".png)'><H3>".$navlinklabel."</H3></a></li>";
    }
    else{
      $title = (!empty($navlinkpath['title'])) ? $navlinkpath['title'] : $navlinklabel;
      $image = (!empty($navlinkpath['image']) && file_exists('./media/nav/'.$navlinkpath['image'])) ? $navlinkpath['image'] : 'default.png';
      $target = (!empty($navlinkpath['target'])) ? $navlinkpath['target'] : '';
      echo "<li><a href='".$navlinkpath['path']."' target='".$target."' style='background-image: url(./media/nav/".$image.")'><H3>".$title."</H3></a></li>";    
    }
  }
}
//<--START LOGOUT--> 
echo "<li><a href='settings.php' style='background-image: url(./media/nav/config.png)'><H3>Config</H3></a></li>";
if ($authsecured) {
  echo "<li><a href='login.php' onclick='logout();' style='background-image: url(./media/nav/logout.png)'><H3>Logout</H3></a></li>";
}
//<--END LOGOUT-->
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