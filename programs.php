<html>
	<head>
  <title>Media Front Page</title>
	<link rel="shortcut icon" href="favicon.ico" />
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" type="text/css" href="css/widget.css" />
	<link rel="stylesheet" type="text/css" href="css/front.css" />
  <link rel="stylesheet" type="text/css" href="css/static_widget.css" />
	</head>
<?php 
include "nav.php"; 
require_once "config.php";
$qs = $_GET['p']
?>
  <body>
    <center>    
			<table width="95%" height="95%" align="center" cellpadding="0" cellspacing="0" class="widget">
				<tr style="cursor: move; ">
					<td align=center colspan=2 height=25>
		        <div class="widget-head"><h3><?php echo $qs; ?></h3></div>
				    </td>
						<tr>
							<td><br>
							  <iframe class='widget' src='
<?php 
if ($qs == 'SickBeard') {
	echo $sickbeardurl;
}	elseif($qs == 'CouchPotato') {
	echo $cp_url;
}	elseif($qs == 'SabNZBd') {
	echo $saburl;
}	elseif($qs == 'Transmission') {
	echo $transmission_web;
}	elseif($qs == 'uTorrent') {
	echo $utorrent_url;
}	elseif($qs == 'XBMC') {
	echo str_replace("vfs/","",$xbmcimgpath);
}	elseif($qs == 'HeadPhones') {
	echo $HEADPHONES_URL;
}	elseif($qs == 'JDownloader') {
	echo $jd_weburl;
}	elseif($qs == 'SubSonic') {
	echo $subsonicurl;
}
?>					
							'; frameborder='0' height='96%' width='98%' scrolling='auto'></iframe>
						</td>
			    </tr>
			  </tr>
      </table>
	    <?php include "footer.php"; ?>
    </center>
  </body>
</html>