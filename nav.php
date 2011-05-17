<?php
include_once "functions.php";
	$settingsDB = getAllSettings();
	$settings = formatSettings($settingsDB);
	$navlinks = $settings['navlinks'];

  echo	"<html>";
  echo	"  <head>";
  echo	"    <title>Navigation</title>";
  echo	"    <link rel='stylesheet' type='text/css' href='style/css/nav.css'>";
  echo	"  </head>";
  echo	"  <body>";
  echo	"    <div id=header>";
  echo	"      <div id=home>";
  echo	"        <a href='./mediafrontpage.php' target='main'></a>";
  echo	"      </div>";
  echo	"      <div id=nav-menu>";
  echo	"        <ul>";
  foreach( $navlinks as $navlink) {
    echo	"          <li><a href='".$navlink['url']."' target=main>".$navlink['label']."</a></li>";
  }
  echo	"        </ul>";
  echo	"      </div>";
  echo	"    </div>";
  echo	"  </body>";
  echo	"</html>";
?>
