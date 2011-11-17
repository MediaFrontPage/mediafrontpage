<?php
$wdgtNowPlayingAjax = array("type" => "ajax", "block" => "nowplayingwrapper", "call" => "widgets/wNowPlaying.php?ajax=w", "interval" => 1000);
$wdgtNowPlayingControls = array("type" => "inline", "function" => "widgetNowPlayingControls();", "headerfunction" => "widgetNowPlayingHeader();");
$wdgtNowPlaying = array("name" => "Now Playing", "type" => "mixed", "parts" => array($wdgtNowPlayingAjax, $wdgtNowPlayingControls));
$wIndex["wNowPlaying"] = $wdgtNowPlaying;

function widgetNowPlayingControls($baseurl = "") {
	echo "<div id=\"nowplaying-controls\" class=\"controls\">\n";
	echo "\t".anchorControlButton($baseurl, 'SkipPrevious', 'btnSkipBackward.png', 'Skip Back')."\n";
	echo "\t".anchorControlButton($baseurl, 'PlayPause', 'btnPlayPause.png', 'Play/Pause')."\n";
	echo "\t".anchorControlButton($baseurl, 'Stop', 'btnStop.png')."\n";
	echo "\t".anchorControlButton($baseurl, 'SkipNext', 'btnSkipForward.png', 'Skip Next')."\n";
	echo "\t".anchorControlButton($baseurl, 'ShowPlaylist', 'btnPlayList.png')."\n";
	echo "</div>\n";
	echo "<div class=\"clear-float\"></div>\n";
	echo "<div id=\"nowplaying-list\"></div>\n";
}
function widgetNowPlayingHeader() {
	echo <<< NOWPLAYINGHEADER
		<script type="text/javascript" language="javascript">
		<!--
			function cmdNowPlaying(cmd) {
				var cmdXbmcPlayingRequest = new ajaxRequest();
				cmdXbmcPlayingRequest.open("GET", "widgets/wNowPlaying.php?ajax=c&command="+cmd, true);
					cmdXbmcPlayingRequest.onreadystatechange = function() {
						if (cmdXbmcPlayingRequest.readyState==4) {
							if (cmdXbmcPlayingRequest.status==200 || window.location.href.indexOf("http")==-1) {
								document.getElementById("nowplaying-list").innerHTML=cmdXbmcPlayingRequest.responseText;
							} else {
								alert("An error has occured making the request");
							}
						}
					}

				cmdXbmcPlayingRequest.send(null);
			}
		-->
		</script>

NOWPLAYINGHEADER;
}
?>
<?php
function anchorControlButton($baseurl, $cmd, $img = "", $label = "") {
	if(empty($label)) {
		$label = $cmd;
	}
	if(!empty($_GET['style']) && ($_GET['style'] == "m")) {
		$mediadir = "../media";
		$anchorlink = "href=\"".$baseurl."?style=m";
		$anchorlink .= (!empty($_GET['w']) ? "&w=".$_GET['w'] : "");
		$anchorlink .= "&cmd=".$cmd."\"";
	} else {
		$mediadir = "media";
		$anchorlink = "onclick=\"cmdNowPlaying('".$cmd."');\" href=\"#\"";
	}
	$anchorlabel = (!empty($img) ? "<img src=\"".$mediadir."/".$img."\" alt=\"".$label."\"/>" : $label);
	return "<a class=\"controlbutton\" ".$anchorlink.">".$anchorlabel."</a>";
}
function displayNowPlaying($baseurl = "")
{
	global $xbmcimgpath;
	if(!empty($_GET['style']) && ($_GET['style'] == 'm') && !empty($_GET['cmd']))
	{
		processCommand($_GET['cmd']);
	}
	echo "<div id=\"nowplaying\">\n";
	//json rpc call procedure
	$jsonVersion = jsonmethodcall("JSONRPC.Version"); //pull the JSON version # from XBMC
	$results = jsonmethodcall("Player.GetActivePlayers");
	//The results are going to be very different if we're running the newer XBMC, so we fork here for the different versions of XBMC
	//BEGIN VERSION 2 CODE
	if($jsonVersion['result']['version'] == '2')
	{
		//First of all check to ensure SOMETHING is playing
		if(empty($results['result']['audio']) && empty($results['result']['picture']) && empty($results['result']['video']))
		{
			echo "\t<p>Nothing Playing</p>\n";
		}
		//VIDEO PLAYER CASE
		else if(!empty($results['result']['video']))
		{
			$results = jsonmethodcall("VideoPlaylist.GetItems"); //Pull the current "playlist"
			//If there's anything there, get the current item and stick it into an array called "items" for easy access
			if(!empty($results['result']['items'])) { $items = $results['result']['items'][0]; } 
			//DETERINE CASE
			//The older interface doesn't explicitly return a "type"
			//However, all TV shows will have an episode #, so if this is set, we're watching a TV show
			//TV SHOW
			if(isset($items['episode']))
			{
				if(!empty($items['showtitle'])) //We begin building the first line with the show's title
				{
					$line1=$items['showtitle'];
				}
				if(!empty($items['season']))
				{
					$line1=$line1." - S".sprintf("%02d", $items['season']);
				}
				if(empty($items['season'])) //There's a bug with the interface where if you're watching a "special" episode, the season # is 0, but nothing is returned
				{
					$line1=$line1." - S00";
				}
				if(!empty($items['episode']))
				{
					$line1=$line1."E".sprintf("%02d", $items['episode']);
				}
				if(!empty($items['title']))
				{
					$line2='"'.$items['title'].'"';
				}
				if(empty($items['plot']))
				{
					$line3="Plot Summary Unavailable";
					$plot="Plot Summary Unavailable";
				}
				if(!empty($items['plot']))
				{
					$line3=$items['plot'];
					$plot=$items['plot'];
				}
			}
			//MOVIE CASE
			//If the episode # is not set, we can assume its a movie and go from there
			if(!isset($items['episode']))
			{
				if(!empty($items['title']))
				{
					$line1=$items['title'];
				}
				if(!empty($items['year']))
				{
					$line1=$line1.' ('.$items['year'].')';
				}
				if(!empty($items['director']))
				{
					$line1=$line1." | Directed by ".$items['director'];
				}
				if(empty($line1)) //For some reason, with the old interface if you launch a video from one of the widgets, basically NONE of the metadata is populated
				// As a result we can't do any of the normal nice stuff.
				{ // In this lame case, we can fall back to the file name
					$line1=substr($items['file'],strrpos($items['file'],'/'));
				}
				$line2 =''; // set this variable so that PHP won't error if it remains unset
				if(!empty($items['tagline']))
				{
					$line2=$items['tagline'];
				}
				if(empty($items['plot']))
				{
					$line3="Plot Summary Unavailable";
					$plot="Plot Summary Unavailable";
				}
				if(!empty($items['plot']))
				{
					$line3=$items['plot'];
					$plot=$items['plot'];
				}
			}
			//Gather thumbnail / fanart if possible, then output
			if (!empty($items['thumbnail'])) {
				$thumb = $items['thumbnail'];
			} else {
				if(!empty($items['fanart'])){ $thumb = $items['fanart']; }
			}
			if(strlen($thumb) > 0) {
				echo "\t<div id=\"thumbblock\" class=\"thumbblockvideo\">\n";
				if(!empty($baseurl)) {
					echo "\t\t<img src=\"".$xbmcimgpath.$thumb."\" alt=\"".htmlentities($plot, ENT_QUOTES)."\" />";
				} else {
					echo "\t\t <b>".$line1."</b><a href=\"".$xbmcimgpath.$thumb."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
					echo "\t\t\t<img src=\"".$xbmcimgpath.$thumb."\" title=\"Click to enlarge\" alt=\"".htmlentities($plot, ENT_QUOTES)."\" />";
					echo "\t\t</a>\n";
				}
				echo "\t</div>\n";
			}
			echo "\t\t<p><i>".$line2."</i></p>\n";
			echo "\t\t<p>".$line3."</p>\n";
			//progress time
			$results = jsonmethodcall("VideoPlayer.GetTime");
			$time = $results['result']['time']; // Current time (in seconds)
			$total = $results['result']['total']; // Total time (in seconds)
			$timeFormatted = ''; //Instantiate the "timeFormatted" variable so we don't get errors
			$timeFormatted = formattimes($time, $total);
			echo "$timeFormatted</p>\n";
			if(!empty($results['result']['paused']) && ($results['result']['paused']))
			{
				echo "\t\t<p>Paused</p>\n";
			}
			//progress bar
			$results = jsonmethodcall("VideoPlayer.GetPercentage");
			$percentage = $results['result'];
			echo "\t\t<div class='progressbar'><div class='progress' style='width:".$percentage."%'></div></div>";
		}
		//AUDIO PLAYER CASE----------------------------------------------------------------------------------------------
		else if(!empty($results['result']['audio']))
		{
			$results = jsonmethodcall("AudioPlaylist.GetItems"); //Pull the current "playlist"
			//If there's anything there, get the current item and stick it into an array called "items" for easy access
			if(!empty($results['result']['items'])) { $items = $results['result']['items'][0];
			}
			$description=$items['title'].' by '.$items['artist'];
			$line1='<b>Artist:</b> '.$items['artist'];
			$line2='<b>Title:</b> '.$items['title'];
			$line3='<b>Album:</b> '.$items['album'];
			//$line4='<b>Year:</b> '.$items['year'];
			//Gather thumbnail if possible, then output
			if (!empty($items['thumbnail']))
			{
				$thumb = $items['thumbnail'];
			}
			if(strlen($thumb) > 0) {
				echo "\t<div id=\"thumbblock\" class=\"thumbblockvideo\">\n";
				if(!empty($baseurl)) {
					echo "\t\t<img src=\"".$xbmcimgpath.$thumb."\" alt=\"".htmlentities($description, ENT_QUOTES)."\" />";
				} else {
					echo "\t\t ".$line1."<a href=\"".$xbmcimgpath.$thumb."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
					echo "\t\t\t<img src=\"".$xbmcimgpath.$thumb."\" title=\"Click to enlarge\" alt=\"".htmlentities($description, ENT_QUOTES)."\" />";
					echo "\t\t</a>\n";
				}
				echo "\t</div>\n";
				echo "\t\t<p>".$line2."</p>\n";
				echo "\t\t<p>".$line3."</p>\n";
				//echo "\t\t<p>".$line4."</p>\n";
				//progress time
				$results = jsonmethodcall("AudioPlayer.GetTime");
				$time = $results['result']['time']; // Current time (in seconds)
				$total = $results['result']['total']; // Total time (in seconds)
				$timeFormatted = ''; //Instantiate the "timeFormatted" variable so we don't get errors
				$timeFormatted = formattimes($time, $total);
				echo "$timeFormatted</p>\n";
				if(!empty($results['result']['paused']) && ($results['result']['paused']))
				{
					echo "\t\t<p>Paused</p>\n";
				}
				//progress bar
				$results = jsonmethodcall("AudioPlayer.GetPercentage");
				$percentage = $results['result'];
				echo "\t\t<div class='progressbar'><div class='progress' style='width:".$percentage."%'></div></div>";
			}
		}
		//PICTURE CASE----------------------------------------------------------------------------
		else if(!empty($results['result']['picture']))
		{
			echo "Now Viewing Pictures";
		}
		//regardless of what case we get, we need to cap off the output
		echo "</div>\n";
	}
	//BEGIN VERSION 3 CODE-----------------------------------------------------------------------------------------------------
	else if($jsonVersion['result']['version'] == '3')
	{
		if(!empty($results['result']['0']['type']))//check to make sure there is SOMETHING playing. If nothing is, this variable is empty. 
		{
		//video Player
		if (($results['result']['0']['type']) == "video")
		{
			$playerid=$results['result']['0']['playerid']; //Determine current player ID
			$items=jsonmethodcall("Player.GetItem",$playerid); //then dump current item information
			$items=$items['result']['item'];
			//Now that we have the current video item, we can grab the type and proceed from there
			//the "type" field will return "episode" for a TV show, and "movie" the rest of the time, even if its not a movie!
			//TV---------------------------------------------------------------------------------------------------------------
			if ($items['type']=='episode')
			{
				//its a TV show!
				$episodeid=$items['id']; //from the playlist items we only get an ep ID, so we need to get the rest of the info from that
				$items = jsonmethodcall("VideoLibrary.GetEpisodeDetailsV3",$episodeid);
				$items = $items['result']['episodedetails']; //Push just the episode details into a nice array
				//print_r($items);
				if(!empty($items['showtitle']))
				{
					$line1=$items['showtitle'];
				}
				if(!empty($items['season']))
				{
					$line1=$line1." - S".sprintf("%02d", $items['season']);
				}
				if(!empty($items['episode']))
				{
					$line1=$line1."E".sprintf("%02d", $items['episode']);
				}
				if(!empty($items['title']))
				{
					$line2='"'.$items['title'].'"';
				}
					if(empty($items['plot']))
				{
					$line3="Plot Summary Unavailable";
					$plot="Plot Summary Unavailable";
				}
				if(!empty($items['plot']))
				{
					$line3=$items['plot'];
					$plot=$items['plot'];
				}
			}
			else if ($items['type']=='movie')
			{
			if(!empty($items['id']))
			{
				$movieid=$items['id'];//from the playlist items we only get an movie ID, so we need to get the rest of the info from that
				$items = jsonmethodcall("VideoLibrary.GetMovieDetailsV3",$movieid);
				$items = $items['result']['moviedetails']; //Push just the movie details into a nice array
			}
				//it's a movie
				if(empty($items['title']))
				{
					$line1=$items['label'];
				}
				if(!empty($items['title']))
				{
					$line1=$items['title'];
				}
				if(!empty($items['year']))
				{
					$line1=$line1.' ('.$items['year'].')';
				}
				if(!empty($items['director']))
				{
					$line1=$line1." | Directed by ".$items['director'];
				}
				$line2 = '';
				if(!empty($items['tagline']))
				{
					$line2=$items['tagline'];
				}
				if(empty($items['plot']))
				{
					$line3="Plot Summary Unavailable";
					$plot="Plot Summary Unavailable";
				}
				if(!empty($items['plot']))
				{
					$line3=$items['plot'];
					$plot=$items['plot'];
				}
			}
			$thumb = '';
			if (!empty($items['thumbnail']))
			{
				$thumb = $items['thumbnail'];
			}
			else
			{
				if(!empty($items['fanart']))
				{
					$thumb = $items['fanart'];
				}
			}
			if(strlen($thumb) > 0)
			{
				echo "\t<div id=\"thumbblock\" class=\"thumbblockvideo\">\n";
				if(!empty($baseurl))
				{
					echo "\t\t<img src=\"".$xbmcimgpath.$thumb."\" alt=\"".htmlentities($plot, ENT_QUOTES)."\" />";
				}
				else
				{
					echo "\t\t <b>".$line1."</b><a href=\"".$xbmcimgpath.$thumb."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
					echo "\t\t\t<img src=\"".$xbmcimgpath.$thumb."\" title=\"Click to enlarge\" alt=\"".htmlentities($plot, ENT_QUOTES)."\" />";
					echo "\t\t</a>\n";
				}
				echo "\t</div>\n";
			}
			if(strlen($thumb) == 0)
			{
				echo "\t\t<p><b><i>".$line1."</i></b></p>\n";
			}
			echo "\t\t<p><i>".$line2."</i></p>\n";
			echo "\t\t<p>".$line3."</p>\n";
			//progress time
			$results = jsonmethodcall("Player.GetProperties",1);
			$time = $results['result']['time']; // pulls a nice array for the current position
			$total = $results['result']['totaltime']; // same but for the total time
			$timeFormatted = ''; //Instantiate the "timeFormatted" variable so we don't get errors
			if($time['hours']!=0) { $timeFormatted = $time['hours'].":"; } //If there's actually any "hours" value, we format and add them to the string
			$timeFormatted = "\t\t<p>".$timeFormatted.sprintf("%02d", $time['minutes']).':'.sprintf("%02d", $time['seconds']).' / ';
			if($total['hours']!=0)
			{
				$timeFormatted = $timeFormatted.$total['hours'].":";
			}
			$timeFormatted = $timeFormatted.sprintf("%02d", $total['minutes']).":".sprintf("%02d", $total['seconds']);
			if(!empty($items['imdbnumber']))//generate IMDB link
			{
				$imdb='http://www.imdb.com/title/'.$items['imdbnumber'];
				$imdb='<a href="'.$imdb.'" target="blank"><img src="/mfp/media/imdb.png"></a>';
			}
			echo "$timeFormatted$imdb ";
			if($results['result']['speed']=="0")
			{
				echo "     <b>Paused</b></p>\n";
			}
			echo"</p>\n";
			//progress bar
			$percentage = $results['result']['percentage'];
			echo "\t\t<div class='progressbar'><div class='progress' style='width:".$percentage."%'></div></div>";

		if(!empty($_GET['style']) && $_GET['style'] == 'm') {
			widgetNowPlayingControls($baseurl);
		}
	}
	//AUDIO Playback
	elseif (($results['result']['0']['type']) == "audio")
	{
		$results= jsonmethodcall("Player.GetItem",0);
		$results=$results['result']['item'];
		//print_r($results);
		$thumb = $results['thumbnail'];
		$artist = $results['artist'];
		$title = $results['title'];
		$album = $results['album'];
		$line1='<b>Artist:</b> '.$results['artist'];
		$line2='<b>Title:</b> '.$results['title'];
		$line3='<b>Album:</b> '.$results['album'];
		$line4='<b>Year:</b> '.$results['year'];
		if(strlen($thumb) > 0) {
			echo "\t<div id=\"thumbblock\" class=\"thumbblockaudio\">\n";
			if(!empty($baseurl)) {
				echo "\t\t<img src=\"".$xbmcimgpath.$thumb."\" alt=\"".htmlentities($artist." - ".$album." - ".$title, ENT_QUOTES)."\" />";
			} else {
				echo "\t\t<a href=\"".$xbmcimgpath.$thumb."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
				echo "\t\t\t<img src=\"".$xbmcimgpath.$thumb."\" title=\"Click to enlarge\" alt=\"".htmlentities($artist." - ".$album." - ".$title, ENT_QUOTES)."\" />";
				echo "\t\t</a>\n";
			}
			echo "\t</div>\n";
		}
		echo "\t</div>\n";
				echo "\t\t<p>".$line1."</p>\n";
				echo "\t\t<p>".$line2."</p>\n";
				echo "\t\t<p>".$line3."</p>\n";
				echo "\t\t<p>".$line4."</p>\n";
		$results = jsonmethodcall("Player.GetProperties",0);
		$time = $results['result']['time']; // pulls a nice array for the current position
		$total = $results['result']['totaltime']; // same but for the total time
		$timeFormatted = ''; //Instantiate the "timeFormatted" variable so we don't get errors
		if($time['hours']!=0) { $timeFormatted = $time['hours'].":"; } //If there's actually any "hours" value, we format and add them to the string
		$timeFormatted = "\t\t<p>".$timeFormatted.sprintf("%02d", $time['minutes']).':'.sprintf("%02d", $time['seconds']).' / ';
			if($total['hours']!=0)
			{
				$timeFormatted = $timeFormatted.$total['hours'].":";
			}
			$timeFormatted = $timeFormatted.sprintf("%02d", $total['minutes']).":".sprintf("%02d", $total['seconds']);
			echo "$timeFormatted</p>\n";
			if($results['result']['speed']=="0")
			{
				echo "\t\t<p>Paused</p>\n";
			}
			//progress bar
			$percentage = $results['result']['percentage'];
			echo "\t\t<div class='progressbar'><div class='progress' style='width:".$percentage."%'></div></div>";

		if(!empty($_GET['style']) && $_GET['style'] == 'm') {
			widgetNowPlayingControls($baseurl);
		}
	}
	elseif (($results['result']['0']['type']) == "picture")
	{
		echo "Picture player";
	}
	else
	{
		echo "\t<p>Nothing Playing</p>\n";
	} 
	echo "</div>\n";
}
else
{
	echo "\t<p>Nothing Playing</p>\n";
	echo "</div>\n";
}
	}

}
function processCommand($command)
{
	global $xbmcimgpath;

	switch($command)
	{
		case "ShowPlaylist":
			$jsonVersion = jsonmethodcall("JSONRPC.Version"); //pull the JSON version # from XBMC
			$results = jsonmethodcall("Player.GetActivePlayers");
			//The results are going to be very different if we're running the newer XBMC, so we fork here for the different versions of XBMC
			//BEGIN VERSION 2 CODE
			if($jsonVersion['result']['version'] == '2')
			{
				if (($results['result']['video']) == 1)
				{
					echo "\t<p>Not Yet Implemented</p>\n";
				}
				elseif (($results['result']['audio']) == 1)
				{
					$results = jsonmethodcall("AudioPlaylist.GetItems");
					if (array_key_exists('items', $results['result']))
					{
						$items = $results['result']['items'];
						$current = $results['result']['current'];

						$songcount = count($results);
						$i = 0;

						foreach ($items as $queueItem)
						{
							if ($i > $current)
							{
								$thumb = $queueItem['thumbnail'];
								$artist = $queueItem['artist'];
								$title = $queueItem['title'];
								$album = $queueItem['album'];
								if(strlen($thumb) > 0)
								{
									echo "<div id=\"playlist-item-".$i."\" class=\"playlist-item\">\n";
									echo "\t<img src=\"".$xbmcimgpath.$thumb."\" />\n";
								}
								echo "\t<p>".$artist."</p>\n";
								echo "\t<p>".$title."</p>\n";
								echo "\t<p>".$album."</p>\n";
								echo "</div>\n";
								echo "<div class=\"clear-float\"></div>\n";
							}
							$i++;
						}
					}
				}
				break;
			}
			//Suppress error reporting because the variables are half-instantiated because of how the buttons work
			error_reporting('E_NONE');
			//BEGIN VERSION 3 CODE---------------------------------------------------------------------------------

			if($jsonVersion['result']['version'] == '3')
			{
				$playerid=$results['result']['0']['playerid']; //get PlayerID so we can pull items off of it
				$results=jsonmethodcall("Playlist.GetItems",$playerid);
				$current=jsonmethodcall("Player.GetItem",$playerid);
				$current=$current['result'];
				$title=$current['item']['label'];
				//echo "current song: $title";
				$items = $results['result']['items']; //get an array of the currently queued up items
				$i = 0;
				foreach ($items as $queueItem)
						{
							$label = $queueItem['label'];
							if($label == $title)
							{
								echo "\t<p><b>".$label."</b></p>\n";
							}
							if($label != $title)
							{
								echo "\t<p>".$label."</p>\n";
							}

							echo "</div>\n";
							echo "<div class=\"clear-float\"></div>\n";
							$i++;
						}
				break;
			}
		default:
		/*
			XBMC Player Commands
			PlayPause,            Pauses or unpause playback
			Stop,                 Stops playback
			SkipPrevious,         Skips to previous item on the playlist
			SkipNext,             Skips to next item on the playlist
			BigSkipBackward,      
			BigSkipForward,       
			SmallSkipBackward,    
			SmallSkipForward,     
			Rewind,               Rewind current playback
			Forward,              Forward current playback
		*/

		//get active players
		$results = jsonmethodcall("Player.GetActivePlayers");
		$jsonVersion = jsonmethodcall("JSONRPC.Version"); //pull the JSON version # from XBMC
		//BEGIN VERSION 2 CODE
		if($jsonVersion['result']['version'] == '2')
		{
			//Video Player
			if (($results['result']['video']) == 1)
			{
				//get playlist items
				$player = "VideoPlayer";
			//Music Player
			}
			elseif (($results['result']['audio']) == 1)
			{
				//get playlist items
				$player = "AudioPlayer";
			}
			else
			{
				// Nothing Playing
			}
			if(!empty($player) && !empty($command))
			{
				$results = jsonmethodcall($player.'.'.$command);
			}
		}
		//BEGIN VERSION 3-----------------------------------------------------------
		if($jsonVersion['result']['version'] == '3')
		{
			$results = jsonmethodcall("Player.GetActivePlayers");
			if(!empty($results['result']['0']['playerid']))
			{
				$playerid=$results['result']['0']['playerid'];
			}
			//print_r($results);
			if($command=='SkipPrevious')
			{
				$command='GoPrevious';
			}
			elseif($command=='SkipNext')
			{
				$command='GoNext';
			}
			if(!empty($command))
			{
				if(empty($playerid))
				{
					$playerid=0;
				}
				$realcommand = 'Player.'.$command;
				$results = jsonmethodcall($realcommand,$playerid);
			}
		}
		// debugging
		if(!empty($_GET["debug"]) && ($_GET["debug"] == "y"))
		{
			echo "<br/>Call: <pre>";
			echo print_r($request,1);
			echo "</pre><br/>";
			echo "<br/>Result: <pre>";
			echo print_r($result,1);
			echo "</pre><br/>";
		}
	}
}


if (!empty($_GET['ajax']) && ($_GET['ajax'] == "w"))
{
	require_once "../config.php";
	require_once "../functions.php";
	displayNowPlaying();
}
?>
<?php
if (!empty($_GET['ajax']) && ($_GET['ajax'] == "c"))
{
	require_once "../config.php";
	require_once "../functions.php";
	if (!empty($_GET['command']))
	{
		$command = $_GET["command"];
		processCommand($command);
	} else {
		echo "<br/>\n";
		echo "<p><strong>Invalid Request<strong></p>\n";
		echo "<p>Call: <pre>\n";
		echo print_r($_GET,1);
		echo "\n</pre>\n</p>\n";
	}
}

if (!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {
	if ($_GET['style'] == "w") {
?>
<html>
	<head>
		<title>Media Front Page - Now Playing</title>
		<link rel="stylesheet" type="text/css" href="css/front.css">
	</head>
	<body>
<?php
		displayNowPlaying();
?>
	</body>
</html>
<?php
	} else {
		displayNowPlaying();
	}
}
?>