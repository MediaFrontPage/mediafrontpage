<link rel="stylesheet" href="css/nav_style.css" type="text/css" charset="utf-8"/>
<div class="header"></div>
<ul id="navigation">
  <li class="mfp"><a href="/">
    <H3>Widgets</H3>
    </a></li>
  <li class="xbmc"><a href="http://xbmclive/programs.php?p=XBMC">
    <H3>XBMC</H3>
    </a></li>
  <li class="sickbeard"><a href="http://xbmclive/programs.php?p=SickBeard">
    <H3>Sickbeard</H3>
    </a></li>
  <li class="couchpotato"><a href="http://xbmclive/programs.php?p=CouchPotato">
    <H3>CouchPotato</H3>
    </a></li>
  <li class="headphones"><a href="http://xbmclive/programs.php?p=HeadPhones">
    <H3>HeadPhones</H3>
    </a></li>
  <li class="transmission"><a href="http://xbmclive/programs.php?p=Transmission">
    <H3>Transmission</H3>
    </a></li>
  <li class="utorrent"><a href="http://xbmclive/programs.php?p=uTorrent">
    <H3>uTorrent</H3>
    </a></li>
  <li class="jdownloader"><a href="http://xbmclive/programs.php?p=JDownloader">
    <H3>JDownloader</H3>
    </a></li>  
  <li class="tvheadend"><a href="http://xbmclive/programs.php?p=TVHeadend">
    <H3>TVHeadend</H3>
    </a></li>
  <li class="sabnzbd"><a href="http://xbmclive/programs.php?p=SabNZBd">
    <H3>SabNZBd</H3>
    </a></li>
  <li class="config"><a href="mfpedit.php">
    <H3>Config</H3>
    </a></li>
<?php
//Logout button 
require_once('config.php');
if ($authsecured) {
  echo "<li class=\"logout\"><a href=\"#\" onclick=\"logout();\"><H3>Logout</H3></a></li>";
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