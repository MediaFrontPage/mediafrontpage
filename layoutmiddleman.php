<?php
require_once "config.php";
require "layout.php";

function which_section($layoutarray, $layoutfind) {
  foreach ($layoutarray as $layoutkey => $layoutvalue)
    foreach ($layoutvalue as $k => $v)
      if ($k == $layoutfind) return $layoutkey;
  return false;
}



$wComingEpisodessection = which_section($arrLayout, 'wComingEpisodes');
$wXBMCLibrarysection = which_section($arrLayout, 'wXBMCLibrary');
$wControlsection = which_section($arrLayout, 'wControl');
$wRecentTVsection = which_section($arrLayout, 'wRecentTV');
$wRecentMoviessection = which_section($arrLayout, 'wRecentMovies');
$wSearchsection = which_section($arrLayout, 'wSearch');
$wRSSsection = which_section($arrLayout, 'wRSS');
$wHardDrivessection = which_section($arrLayout, 'wHardDrives');
$wNowPlayingsection = which_section($arrLayout, 'wNowPlaying');
$wTransmissionsection = which_section($arrLayout, 'wTransmission');
$wSabnzbdsection = which_section($arrLayout, 'wSabnzbd');
$wMessagesection = which_section($arrLayout, 'wMessage');
$wTraktsection = which_section($arrLayout, 'wTrakt');
$wSystemsection = which_section($arrLayout, 'wSystem');
$wUPSsection = which_section($arrLayout, 'wUPS');


if ( $wComingEpisodes == "false" )
	{ 
	unset($arrLayout[$wComingEpisodessection]['wComingEpisodes']);
	}

if ( $wXBMCLibrary == "false" )
	{ 
	unset($arrLayout[$wXBMCLibrarysection]['wXBMCLibrary']);
	}

if ( $wControl == "false" )
	{ 
	unset($arrLayout[$wControlsection]['wControl']);
	}
	
if ( $wRecentTV == "false" )
	{ 
	unset($arrLayout[$wRecentTVsection]['wRecentTV']);
	}

if ( $wRecentMovies == "false" )
	{ 
	unset($arrLayout[$wRecentMoviessection]['wRecentMovies']);
	}

if ( $wSearch == "false" )
	{ 
	unset($arrLayout[$wSearchsection]['wSearch']);
	}
	
if ( $wRSS == "false" )
	{ 
	unset($arrLayout[$wRSSsection]['wRSS']);
	}
	
if ( $wHardDrives == "false" )
	{ 
	unset($arrLayout[$wHardDrivessection]['wHardDrives']);
	}
	
if ( $wNowPlaying == "false" )
	{ 
	unset($arrLayout[$wNowPlayingsection]['wNowPlaying']);
	}
	
if ( $wTransmission == "false" )
	{ 
	unset($arrLayout[$wTransmissionsection]['wTransmission']);
	}
	
if ( $wSabnzbd == "false" )
	{ 
	unset($arrLayout[$wSabnzbdsection]['wSabnzbd']);
	}
	
if ( $wMessage == "false" )
	{ 
	unset($arrLayout[$wMessagesection]['wMessage']);
	}
	
if ( $wTrakt == "false" )
	{ 
	unset($arrLayout[$wTraktsection]['wTrakt']);
	}
	
if ( $wSystem == "false" )
	{ 
	unset($arrLayout[$wSystemsection]['wSystem']);
	}
	
if ( $wUPS == "false" )
	{ 
	unset($arrLayout[$wUPSsection]['wUPS']);
	}
?>
