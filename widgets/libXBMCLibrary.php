<?php
error_reporting(E_ALL ^ E_NOTICE);
	$jsonVersion = jsonmethodcall("JSONRPC.Version"); //pull the JSON version # from XBMC
function executeVideo($style = "w", $action, $breadcrumb, $params = array()) {
	global $COMM_ERROR;
	global $videodetailfields;
	$jsonVersion = jsonmethodcall("JSONRPC.Version"); //pull the JSON version # from XBMC
	$breadcrumbs = explode("|", $breadcrumb);
	$previousaction = end($breadcrumbs);
	switch ($action) {
		case "l":  // Library
			displayLibraryMenu($style, $params);
			break;
		case "lp": // Photo Library
			displayLibraryPhotoMenu($style, $params);
			break;
		case "lv": // Video Library
			displayLibraryVideoMenu($style, $params);
			break;
		case "lm": // Music Library
			displayLibraryMusicMenu($style, $params);
			break;
		case "p":  // Play
			switch ($previousaction)
			{
				case "re": //RecentEpisodes
				case "e": //Episodes
				case "rm": //Recent Movies
				case "m": //Movies 
					if (($previousaction == "re") || ($previousaction == "e"))
					{
						if ($previousaction == "re")
						{
							if($jsonVersion['result']['version'] == '2') { $request = jsonstring("VideoLibrary.GetRecentlyAddedEpisodes"); }
							if($jsonVersion['result']['version'] == '3') { $request = jsonstring("VideoLibraryV3.GetRecentlyAddedEpisodes"); }
						} else
						{
							$showid = $params['showid'];
							$season = $params['season'];
							if($jsonVersion['result']['version'] == '2') { $request = jsonstring("VideoLibrary.GetEpisodes", array('tvshowid' => $params['showid'], 'season' => $params['season'])); }
							if($jsonVersion['result']['version'] == '3') { $request = jsonstring("VideoLibraryV3.GetEpisodes", array('tvshowid' => $params['showid'], 'season' => $params['season'])); }
						}
						$results = jsoncall($request);
						$videos = $results['result']['episodes'];
						$typeId = "episodeid";
					}
					elseif (($previousaction == "rm") || ($previousaction == "m"))
					{
						if($jsonVersion['result']['version'] == '2') { $request = jsonstring("VideoLibrary.GetMovies"); }
						if($jsonVersion['result']['version'] == '3') { $request = jsonstring("VideoLibraryV3.GetMovies"); }
						$results = jsoncall($request);
						$videos = $results['result']['movies'];
						$typeId = "movieid";
					}
					if (!empty($videos)) {
						$videoId = $params['videoid'];
						playVideoFromList($videos, $typeId, $videoId); 
					} 
					break;
				case "so": // Songs
					$jsonVersion = jsonmethodcall("JSONRPC.Version"); //pull the JSON version # from XBMC
					if (!empty($params['songid'])) {
						PlaySongFromList($params['songid']);
					} else {
						echo "<pre>No Song Specified</pre>";
					}
					break;
			
			break;  // Don't break and flow into display.
			}
		case "d":  // Display
			switch ($previousaction) {
				case "e": //Episodes
					$showid = $params['showid'];
					$season = (!empty($params['season']) ? $params['season'] : 0);
					if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetEpisodes", array('tvshowid' => $params['showid'], 'season' => $season)); }
					if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetEpisodes", array('tvshowid' => $params['showid'], 'season' => $season)); }		
					$videos = $results['result']['episodes'];
					$params['typeid'] = "episodeid";
					if (!empty($videos)) {
						displayVideoFromList($videos, $style, $action, $breadcrumb, $params);
					} else {
						echo $COMM_ERROR;
						echo "<pre>$request</pre>";
					}
					break;
				case "re": // Recent Episodes
					if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetRecentlyAddedEpisodes"); }
					if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetRecentlyAddedEpisodes"); }
					$videos = $results['result']['episodes'];
					$params['typeid'] = "episodeid";
					if (!empty($videos)) {
						displayVideoFromList($videos, $style, $action, $breadcrumb, $params);
					} else {
						echo $COMM_ERROR;
						echo "<pre>$request</pre>";
					}
					break;
				case "m":  // Movies
					if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetMovies"); }
					if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetMovies"); }
					$videos = $results['result']['movies'];
					$params['typeid'] = "movieid";
					if (!empty($videos)) {
						displayVideoFromList($videos, $style, $action, $breadcrumb, $params);
					} else {
						echo $COMM_ERROR;
						echo "<pre>$request</pre>";
					}
					break;
				case "rm": // Recent Movies
					if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetRecentlyAddedMovies"); }
					if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetRecentlyAddedMovies"); }
					$videos = $results['result']['movies'];
					$params['typeid'] = "movieid";
					if (!empty($videos)) {
						displayVideoFromList($videos, $style, $action, $breadcrumb, $params);
					} else {
						echo $COMM_ERROR;
						echo "<pre>$request</pre>";
					}
					break;
				case "d":
				case "ms": // Music Sources
					$directory = $params['directory'];
					$results = jsonmethodcall("Files.GetDirectory", array('directory' => $directory));
					$result = $results['result'];
					if (!empty($result)) {
						displayFilesFromList($result, $style, $action, $breadcrumb, $params);
					} else {
						echo $COMM_ERROR;
						echo "<pre>$request</pre>";
					}
					break;
			}
			break;
		case "t":  // TV Shows
			$results = jsonmethodcall("VideoLibrary.GetTVShows");
			if (!empty($results['result'])) {
				$videos = $results['result']['tvshows'];
				displayVideoListTVShows($videos, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>$request</pre>";
			}
			break;
		case "s":  // Seasons
			$showid = $params['showid'];
			if( $jsonVersion['result']['version'] == "2") { $results = jsonmethodcall("VideoLibrary.GetSeasons", array('tvshowid' => $showid)); }
			if( $jsonVersion['result']['version'] == "3") { $results = jsonmethodcall("VideoLibraryV3.GetSeasons", array('tvshowid' => $showid)); }
			if (!empty($results['result'])) {
				$videos = (!empty($results['result']['seasons'])) ? $results['result']['seasons'] : array();
				displayVideoListSeasons($videos, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("VideoLibrary.GetSeasons", array('tvshowid' => $showid))."</pre>";
			}
			break;
		case "e":  // Episodes
			$showid = $params['showid'];
			$season = (!empty($params['season'])) ? $params['season'] : 0;
			if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetEpisodes", array('tvshowid' => $showid, 'season' => $season)); }
			if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetEpisodes", array('tvshowid' => $showid, 'season' => $season)); }
			if (!empty($results['result'])) {
				$videos = $results['result']['episodes'];
				displayVideoListEpisodes($videos, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("VideoLibrary.GetEpisodes", array('tvshowid' => $showid, 'season' => $season))."</pre>";
			}
			break;
		case "re": // Recent Episodes
			if(!empty($params['count'])) {
				$count = $params['count'];
			} else {
				$count = 15;
			}
			if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetRecentlyAddedEpisodes", $count); }
			if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetRecentlyAddedEpisodes", $count); }
			if (!empty($results['result'])) {
				$videos = $results['result']['episodes'];
				displayVideoListEpisodes($videos, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("VideoLibrary.GetRecentlyAddedEpisodes", $count)."</pre>";
			}
			break;
		case "m":  // Movies
			if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetMovies"); }
			if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetMovies"); }			
			if (!empty($results['result'])) {
				$videos = $results['result']['movies'];
				displayVideoListMovie($videos, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("VideoLibrary.GetMovies")."</pre>";
			}
			break;
		case "rm": // Recent Movies
			if(!empty($params['count'])) {
				$count = $params['count'];
			} else {
				$count = 15;
			}
			if($jsonVersion['result']['version'] == '2') { $results = jsonmethodcall("VideoLibrary.GetRecentlyAddedMovies", $count); }
			if($jsonVersion['result']['version'] == '3') { $results = jsonmethodcall("VideoLibraryV3.GetRecentlyAddedMovies", $count); }
			if (!empty($results['result'])) {
				$videos = $results['result']['movies'];
				displayVideoListMovie($videos, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("VideoLibrary.GetRecentlyAddedMovies")."</pre>";
			}
			break;
		case "mv": // Music Videos
			echo "<ul class=\"widget-list\"><li>Not Supported Yet</li></ul>";
			$anchor = buildBackAnchor($style, "l|lv", $params);
			echo "<div class=\"widget-control\">".$anchor."</div>\n";
			break;
		case "ar":  // Artists
			echo "<ul class=\"widget-list\"><li>Under Construction</li></ul>";
			$results = jsonmethodcall("AudioLibrary.GetArtists");
			if (!empty($results['result'])) {
				$artists = $results['result']['artists'];
				displayMusicListArtist($artists, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("AudioLibrary.GetArtists")."</pre>";
			}
			break;
		case "al": // Albums
			echo "<ul class=\"widget-list\"><li>Under Construction</li></ul>";
			if (!empty($params['artistid'])) {
				$artistid = $params['artistid'];
				$request = jsonstring("AudioLibrary.GetAlbums", '"artistid": '.$artistid.',');
			} else {
				$artistid = "";
				$request = jsonstring("AudioLibrary.GetAlbums");
			}
			$results = jsoncall($request);
			if (!empty($results['result'])) {
				$albums = $results['result']['albums'];
				displayMusicListAlbum($albums, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>$request</pre>";
			}
			break;
		case "so": // Songs
			echo "<ul class=\"widget-list\"><li>Under Construction</li></ul>";
			if (!empty($params['artistid']) && !empty($params['albumid'])) {
				$request = jsonstring("AudioLibrary.GetSongs", array("artistid" => '"artistid": '.$params['artistid'].',', "albumid" => '"albumid": '.$params['albumid'].','));
			} elseif (!empty($params['albumid'])) {
				$request = jsonstring("AudioLibrary.GetSongs", array("artistid" => '"artistid": "" ,', "albumid" => '"albumid": '.$params['albumid'].','));
			} else {
				$request = jsonstring("AudioLibrary.GetSongs", array("artistid" => '', "albumid" => ''));
			} 
			$results = jsoncall($request);
			if (!empty($results['result'])) {
				$songs = $results['result']['songs'];
				displayMusicListSong($songs, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>$request</pre>";
			}
			break;
		case "ms": // Music Source
			echo "<ul class=\"widget-list\"><li>Under Construction</li></ul>";
			$results = jsonmethodcall("Files.GetSources", "music");
			if (!empty($results['result'])) {
				$sources = $results['result']['shares'];
				displayMusicListSource($sources, $style, $action, $breadcrumb, $params);
			} else {
				echo $COMM_ERROR;
				echo "<pre>".jsonstring("Files.GetSources", "music")."</pre>";
			}
			break;
	}
}
function getParameters($request) {
	$params = array();
	if(!empty($request['c'])) {
		$params['count'] = $request['c'];
	}
	if(!empty($request['showid'])) {
		$params['showid'] = $request['showid'];
	}
	if(!empty($request['season'])) {
		$params['season'] = $request['season'];
	}
	if(!empty($request['videoid'])) {
		$params['videoid'] = $request['videoid'];
	}
	if(!empty($request['artistid'])) {
		$params['artistid'] = $request['artistid'];
	}
	if(!empty($request['albumid'])) {
		$params['albumid'] = $request['albumid'];
	}
	if(!empty($request['songid'])) {
		$params['songid'] = $request['songid'];
	}
	if(!empty($request['directory'])) {
		$params['directory'] = $request['directory'];
	}

	return $params;
}

function renderMenu($data) {
	echo "<ul class=\"widget-list\">\n";
	$alt = false;
	foreach ($data as $id => $info) {
		echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a href=\"".$info['href']."\" id='".$id."' class='menu'".$info['onclick'].">".$info['label']."</a></li>\n";
		$alt = !$alt;
	}
	echo "</ul>\n";
}

function displayLibraryMenu($style, $params) {
	global $COMM_ERROR;

	$arrResult = jsonmethodcall("JSONRPC.Version");
	if(!is_array($arrResult)) {
		echo $COMM_ERROR;
	} else if ($style == "w") {
			$data = array (
						  "menu-lp" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'lp', 'l', '', false);\"", "label" => "Photos")
						, "menu-lv" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'lv', 'l', '', false);\"", "label" => "Videos")
						, "menu-lm" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'lm', 'l', '', false);\"", "label" => "Music")
					  );
	} else {
			$data = array (
						  "menu-lp" => array( "href" => "?style=".$style."&a=lp&bc=l", "onclick" => "", "label" => "Photos")
						, "menu-lv" => array( "href" => "?style=".$style."&a=lv&bc=l", "onclick" => "", "label" => "Videos")
						, "menu-lm" => array( "href" => "?style=".$style."&a=lm&bc=l", "onclick" => "", "label" => "Music")
					  );
	}

	renderMenu($data);
}
function displayLibraryPhotoMenu($style, $params) {
	echo "<ul class=\"widget-list\"><li>Not Supported Yet</li></ul>";

	$anchor = buildBackAnchor($style, "l", $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}
function displayLibraryVideoMenu($style, $params) {
	if ($style == "w") {
		$data = array (
						  "menu-t" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 't', 'l|lv', '', false);\"", "label" => "TV Shows")
						, "menu-m" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'm', 'l|lv', '', false);\"", "label" => "Movies")
						, "menu-re" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 're', 'l|lv', '', false);\"", "label" => "Recent Episodes")
						, "menu-rm" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'rm', 'l|lv', '', false);\"", "label" => "Recent Movies")
						, "menu-mv" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'mv', 'l|lv', '', false);\"", "label" => "Music Videos")
					  );
	} else {
		$data = array (
						  "menu-t" => array( "href" => "?style=".$style."&a=t&bc=l|lv", "onclick" => "", "label" => "TV Shows")
						, "menu-m" => array( "href" => "?style=".$style."&a=m&bc=l|lv", "onclick" => "", "label" => "Movies")
						, "menu-re" => array( "href" => "?style=".$style."&a=re&bc=l|lv", "onclick" => "", "label" => "Recent Episodes")
						, "menu-rm" => array( "href" => "?style=".$style."&a=rm&bc=l|lv", "onclick" => "", "label" => "Recent Movies")
						, "menu-mv" => array( "href" => "?style=".$style."&a=mv&bc=l|lv", "onclick" => "", "label" => "Music")
					  );
	}

	renderMenu($data);

	$anchor = buildBackAnchor($style, "l", $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}
function displayLibraryMusicMenu($style, $params) {
	echo "<ul class=\"widget-list\"><li>Under Construction</li></ul>";
	if ($style == "w") {
		$data = array (			// Files currently unsecure, allow browsing full fs by clicking back - needs work 
						  "menu-ar" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'ar', 'l|lm', '');\"", "label" => "Artists")
						, "menu-al" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'al', 'l|lm', '');\"", "label" => "Albums")
						, "menu-so" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'so', 'l|lm', '');\"", "label" => "Songs")
						//, "menu-ms" => array( "href" => "#", "onclick" => " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', 'ms', 'l|lm', '');\"", "label" => "Files")
					);
	} else {
		$data = array (
						  "menu-ar" => array( "href" => "?style=".$style."&a=ar&bc=l|lm", "onclick" => "", "label" => "Artists")
						, "menu-al" => array( "href" => "?style=".$style."&a=al&bc=l|lm", "onclick" => "", "label" => "Albums")
						, "menu-so" => array( "href" => "?style=".$style."&a=so&bc=l|lm", "onclick" => "", "label" => "Songs")
						//, "menu-ms" => array( "href" => "?style=".$style."&a=ms&bc=l|lm", "onclick" => "", "label" => "Files")
					  );
	}

	renderMenu($data);

	$anchor = buildBackAnchor($style, "l", $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}
function getTVShowId($showtitle) {
	$return = -1;

	$results = jsonmethodcall("VideoLibrary.GetTVShows");
	$videos = $results['result']['tvshows'];

	foreach ($videoList as $videoInfo) {
		if(!empty($videoInfo['showtitle']) && ($videoInfo['showtitle'] == $showtitle)) {
			if (!empty($videoInfo['tvshowid'])) {
				$return = $videoInfo['tvshowid'];
			}
			break;
		}
	}
}

function playVideoFromList($videoList, $idType = "episodeid", $videoId = -1) {
	foreach ($videoList as $videoInfo) {
		if(!empty($videoInfo[$idType]) && ($videoInfo[$idType] == $videoId) && !empty($videoInfo['file'])) {
			jsonmethodcall("XBMC.Play", '"file": "'.$videoInfo['file'].'"');
		}
	}
}

function playSongFromList($songid) {
	$results = jsonmethodcall("Player.GetActivePlayers");
	if (!empty($results)) {
		if ($results['result']['audio'] == 1) {
			$request = jsonstring("AudioPlaylist.Add", $songid);
		} else {
			$request = jsonstring("XBMC.Play", '"songid": '.$songid);
		}
		$results = jsoncall($request);
		if (empty($results)) {
			echo $COMM_ERROR;
			echo "<pre>$request</pre>";
		}
	} else {
		echo $COMM_ERROR;
	}
}

function displayVideoFromList($videoList, $style, $action, $breadcrumb, $params) {
	$idType = $params['typeid'];
	foreach ($videoList as $videoInfo) {
		if(!empty($videoInfo[$idType]) && ($videoInfo[$idType] == $params['videoid'])) {
			switch($idType) {
				case "episodeid": // Episodes
					displayVideoEpisode($videoInfo, $style, $action, $breadcrumb, $params);
					break;
				case "movieid":   // Movies
					displayVideoMovie($videoInfo, $style, $action, $breadcrumb, $params);
					break;
			}
			break;
		}
	}
}

function displayVideoEpisode($videoInfo, $style, $action, $breadcrumb, $params) {
	global $xbmcimgpath;
	
	echo "<div id='recentTV'>\n";
	echo "\t<div class='library-title'><h2>".$videoInfo['showtitle']."</h2></div>\n";
	echo "\t<div class='library-info'>\n";
	echo "\t<span class='library-img'>\n";

	if(!empty($videoInfo['thumbnail'])) {
		echo "\t\t<a href=\"".$xbmcimgpath.$videoInfo['thumbnail']."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
		echo "\t\t\t<img src='".$xbmcimgpath.$videoInfo['thumbnail']."' title='Click to enlarge'/>\n";
		echo "\t\t<a>\n";
	} elseif(!empty($videoInfo['fanart'])) {
		echo "\t\t<a href=\"".$xbmcimgpath.$videoInfo['fanart']."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
		echo "\t\t\t<img src='".$xbmcimgpath.$videoInfo['fanart']."' title='Click to enlarge'/>\n";
		echo "\t\t<a>";
	}
	$plot = (!empty($videoInfo['plot'])) ? $videoInfo['plot'] : "";
	echo "<div class=\"highslide-caption\">"; 
	echo $videoInfo['showtitle']." - ".(!empty($videoInfo["season"]) ? $videoInfo["season"] : "Specials ")."x".str_pad($videoInfo['episode'], 2, '0', STR_PAD_LEFT)." - ".$videoInfo['label']."<br />\n";
	echo "\t\t".$plot."\n";
	echo "\t\t</div>\n"; 

	echo "\t</span>\n";
	echo "\t<span class='library-desc'>\n";
	echo "\t\t<p>";
	echo "\t\t\t<strong>".(!empty($videoInfo["season"]) ? ("Season: ".$videoInfo["season"]) : "")." Episode: ".$videoInfo['episode']."<br />".$videoInfo['label']."</strong>";
	//echo "\t\t\t<strong>".$videoInfo['season']."x".str_pad($videoInfo['episode'], 2, '0', STR_PAD_LEFT)."<br />".$videoInfo['label']."</strong>";
	echo "\t\t</p>\n";
	echo "\t\t<p class=\"plot\">".$plot."</p>\n";
	if(!empty($videoInfo['firstaired'])) {
		echo "\t\t<p>Aired: ".$videoInfo['firstaired']."</p>\n";
	}
	
	if(!empty($videoInfo['duration'])) {
		echo "\t\t<p>Runtime: ".(int)($videoInfo['duration']/60)." min.</p>\n";
	} elseif(!empty($videoInfo['runtime'])) {
		echo "\t\t<p>Runtime: ".$videoInfo['runtime']." min.</p>\n";
	}
	if(!empty($videoInfo['rating'])) {
		echo "\t\t<p>Rating: ".number_format($videoInfo['rating'], 1)."</p>\n";
	}
	echo "\t</span>\n";
	echo "\t</div>\n";

	$showid = (!empty($params['showid'])) ? $params['showid'] : "";
	$season = (!empty($params['season'])) ? $params['season'] : "0";
	
	$query = "&showid=".$showid."&season=".$season."&videoid=".$videoInfo["episodeid"];
	$playanchor = buildAnchor("Play", $style, "", "", "p", $breadcrumb, $params, $query);
	$backanchor = buildBackAnchor($style, $breadcrumb, $params, "&showid=".$showid."&season=".$season);
	echo "\t<div class=\"widget-control\">".$playanchor." | ".$backanchor."</div>\n";
	echo "</div>\n";
}

function displayVideoMovie($videoInfo, $style, $action, $breadcrumb, $params) {
	global $xbmcimgpath;
	
	echo "<div id='movies'>\n";
	echo "\t<div class='library-title'><h2>".$videoInfo['label']." &nbsp;(".$videoInfo['year'].")</h2></div>\n";
	echo "\t<div class='library-info'>\n";
	echo "\t<span class='library-img'>\n";

	if(!empty($videoInfo['thumbnail'])) {
		echo "\t\t<a href=\"".$xbmcimgpath.$videoInfo['thumbnail']."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
		echo "\t\t\t<img src='".$xbmcimgpath.$videoInfo['thumbnail']."' title='Click to enlarge'/>\n";
		echo "\t\t<a>\n";
	} elseif(!empty($videoInfo['fanart'])) {
		echo "\t\t<a href=\"".$xbmcimgpath.$videoInfo['thumbnail']."\" class=\"highslide\" onclick=\"return hs.expand(this)\">\n";
		echo "\t\t\t<img src='".$xbmcimgpath.$videoInfo['fanart']."' title='Click to enlarge'/>\n";
		echo "\t\t<a>\n";
	}
	echo "\t\t<div class=\"highslide-caption\">\n"; 
	echo "\t\t".$videoInfo['label']." &nbsp;(".$videoInfo['year'].")<br />\n";
	echo "\t\t".$videoInfo['plot']."\n";
	echo "\t\t</div>\n"; 

	echo "\t</span>\n";
	echo "\t<span class='library-desc'>\n";
	if(!empty($videoInfo['originaltitle']) && ($videoInfo['originaltitle'] != $videoInfo['title'])) {
		echo "\t\t<p>".$videoInfo['originaltitle']."</p>\n";
	}
	echo "\t\t<p>".$videoInfo['genre']."</p>\n";
	echo "\t\t<p class=\"plot\">".$videoInfo['plot']."</p>\n";
	if(!empty($videoInfo['premiered'])) {
		echo "\t\t<p>Premiered: ".$videoInfo['premiered']."</p>\n";
	}
	if(!empty($videoInfo['director'])) {
		echo "\t\t<p>Director: ".$videoInfo['director']."</p>\n";
	}
	if(!empty($videoInfo['runtime'])) {
		echo "\t\t<p>Runtime: ".$videoInfo['runtime']." min.</p>\n";
	}
	if(!empty($videoInfo['rating'])) {
		echo "\t\t<p>Rating: ".number_format($videoInfo['rating'], 1)."</p>\n";
	}
	echo "\t</span>\n";
	echo "\t</div>\n";
	$playanchor = buildAnchor("Play", $style, "", "", "p", $breadcrumb, $params, "&videoid=".$videoInfo["movieid"]);
	$backanchor = buildBackAnchor($style, $breadcrumb, $params, "");
	echo "\t<div class=\"widget-control\">".$playanchor." | ".$backanchor."</div>\n";
	echo "</div>\n";
}

function displayVideoListTVShows($videos, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	if (!empty($videos)) {
		$alt = false;
		foreach ($videos as $videoInfo) {
			$label = $videoInfo['label'];
			$id = "tvshow-".$videoInfo["tvshowid"];
			$class = "recent-tv";
			$query = "&showid=".$videoInfo["tvshowid"];
			$anchor = buildAnchor($label, $style, $id, $class, "s", $newbreadcrumb, $params, $query);
			echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
			$alt = !$alt;
		}
	} else {
		echo "<li>[empty]</li>\n";
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayVideoListSeasons($videos, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	if (!empty($videos)) {
		$alt = false;
		foreach ($videos as $videoInfo) {
			$season = (!empty($videoInfo["season"])) ? $videoInfo["season"] : 0;
			$label = $videoInfo['showtitle']." - ".$videoInfo['label'];
			$id = "season-".$season;
			$class = "recent-tv";
			$query = "&showid=".$params["showid"]."&season=".$season;
			$anchor = buildAnchor($label, $style, $id, $class, "e", $newbreadcrumb, $params, $query);
			echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
			$alt = !$alt;
		}
	} else {
		echo "<li>[empty]</li>\n";
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params, "&showid=".$params["showid"]);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayVideoListEpisodes($videos, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);
	$showid = (!empty($params["showid"])) ? $params["showid"] : "";

	echo "<ul class=\"widget-list\">";
	if (!empty($videos)) {
		$alt = false;
		foreach ($videos as $videoInfo) {
			if(!empty($videoInfo['label'])) {
				$title = " - ".$videoInfo['label'];
			} else {
				$title = "";
				if(!empty($videoInfo['season'])) {
					$title .= " Season: ".$videoInfo['season'];
				}
				if(!empty($videoInfo['episode'])) {
					$title .= " Episode: ".$videoInfo['episode'];
				}
				if($title != "") {
					$title = " - ".$title;
				}
			}
			$season = (!empty($videoInfo['season'])) ? $videoInfo['season'] : "";
			$label = $videoInfo['showtitle']." - ".$season."x".str_pad($videoInfo['episode'], 2, '0', STR_PAD_LEFT).$title;
			$id = "episode-".$videoInfo["episodeid"];
			$class = "recent-tv";
			$query = "&showid=".$showid."&season=".$season."&videoid=".$videoInfo["episodeid"];
			$anchor = buildAnchor($label, $style, $id, $class, "d", $newbreadcrumb, $params, $query);
			echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
			$alt = !$alt;
		}
	} else {
		echo "<li>[empty]</li>\n";
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params, "&showid=".$showid."&season=".(!empty($videoInfo["season"]) ? $videoInfo["season"] : 0));
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayVideoListMovie($videos, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	$alt = false;
	foreach ($videos as $videoInfo) {
		$label = $videoInfo['label'].(!empty($videoInfo['year']) ? " &nbsp;(".$videoInfo['year'].")" : "");
		$id = "movie-".$videoInfo["movieid"];
		$class = "recent-movie";
		$query = "&videoid=".$videoInfo["movieid"];
		$anchor = buildAnchor($label, $style, $id, $class, "d", $newbreadcrumb, $params, $query);
		echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
		$alt = !$alt;
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayMusicListArtist($artists, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	$alt = false;
	asort($artists);
	foreach ($artists as $artistInfo) {
		$label = $artistInfo['label'];
		$id = "music-".$artistInfo["artistid"];
		$class = "music-artist";
		$query = "&artistid=".$artistInfo["artistid"];
		$anchor = buildAnchor($label, $style, $id, $class, "al", $newbreadcrumb, $params, $query);
		echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
		$alt = !$alt;
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayMusicListAlbum($albums, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	$alt = false;
	foreach ($albums as $albumInfo) {
		$label = $albumInfo['artist']." - ".$albumInfo['label']." &nbsp;(".$albumInfo['year'].")";
		$id = "music-".$albumInfo["albumid"];
		$class = "music-album";
		$query = (!empty($params["artistid"]) ? "&artistid=".$params["artistid"] : "");
		$query .="&albumid=".$albumInfo["albumid"];
		$anchor = buildAnchor($label, $style, $id, $class, "so", $newbreadcrumb, $params, $query);
		echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
		$alt = !$alt;
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayMusicListSong($songs, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	$alt = false;
	foreach ($songs as $songInfo) {
		$label = $songInfo['artist']." - ".$songInfo['label'];
		$id = "music-".$songInfo["songid"];
		$class = "music-song";
		$query = (!empty($params["artistid"]) ? "&artistid=".$params["artistid"] : "");
		$query .= (!empty($params["albumid"]) ? "&albumid=".$params["albumid"] : "");
		$query .= (!empty($songInfo["songid"]) ? "&songid=".$songInfo["songid"] : "");
		$anchor = buildAnchor($label, $style, $id, $class, "p", $newbreadcrumb, $params, $query);
		echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
		$alt = !$alt;
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params, (!empty($params["artistid"]) ? "&artistid=".$params["artistid"] : ""));
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayMusicListSource($sources, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	$alt = false;
	$i = 0;
	foreach ($sources as $source) {
		if(!empty($source["file"])) {
			$label = $source['label'];
			$id = "source-".$i;
			$class = "music-source";
			$query = "&directory=".$source["file"];
			$anchor = buildAnchor($label, $style, $id, $class, "d", $newbreadcrumb, $params, $query);
			echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
			$alt = !$alt;
			$i++;
		}
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function displayFilesFromList($results, $style, $action, $breadcrumb, $params) {
	$newbreadcrumb = getNewBreadcrumb($action, $breadcrumb);

	echo "<ul class=\"widget-list\">";
	$alt = false;
	$i = 0;
	$directories = $results['directories'];
	$files = $results['files'];
	foreach ($directories as $directory) {
		if(!empty($directory['file'])) {
			$label = $directory['label'];
			$id = "directory-".$i;
			$class = "music-directory";
			$query = "&directory=".$directory['file'];
			$anchor = buildAnchor($label, $style, $id, $class, "d", $newbreadcrumb, $params, $query);
			echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
			$alt = !$alt;
			$i++;
		}
	}
	$i = 0;
	foreach ($files as $file) {
		if(!empty($file['file'])) {
			$label = $file['label'];
			$id = "file-".$i;
			$class = "music-file";
			$query = "&file=".$file['file'];
			$anchor = buildAnchor($label, $style, $id, $class, "d", $newbreadcrumb, $params, $query);
			echo "<li".(($alt) ? " class=\"alt\"" : "").">".$anchor."</li>\n";
			$alt = !$alt;
			$i++;
		}
	}
	echo "</ul>";

	$anchor = buildBackAnchor($style, $breadcrumb, $params);
	echo "<div class=\"widget-control\">".$anchor."</div>\n";
}

function getNewBreadcrumb($action, $breadcrumb) {
	if(strlen($breadcrumb) > 0) {
		$newbreadcrumb = $breadcrumb."|".$action;
	} else {
		$newbreadcrumb = $action;
	}

	return $newbreadcrumb;
}

function buildAnchor($label, $style, $id, $class, $action, $breadcrumb, $params, $query = "") {
	if ($style == "w") {
		$onclick =  " onclick=\"".$params['onclickcmd']."('".$params['wrapper']."', '".$params['harness']."', '".$action."', '".$breadcrumb."', '".$query."', ".((!empty($params['refresh']) && $params['refresh']) ? "true" : "false").");\"";
		$href = "#";
	} else {
		$onclick = "";
		$href = $params['href'].((strpos($params['href'],"?")===false) ? "?" : "&")."style=".$style."&a=".$action."&bc=".$breadcrumb.$query;
	}
	if (strlen($id) > 0) {
		$id = " id=\"".$id."\"";
	}
	if (strlen($class) > 0) {
		$class = " class=\"".$class."\"";
	}
	return "<a href=\"".$href."\"".$id.$class.$onclick.">".$label."</a>";
}

function buildBackAnchor($style, $breadcrumb, $params, $query = "") {
	if(strlen($breadcrumb) > 0) {
		$breadcrumbs = explode("|", $breadcrumb);	
		$previousaction = array_pop($breadcrumbs);
		$previousbreadcrumb = implode("|", $breadcrumbs);
		return buildAnchor("Back", $style, "", "", $previousaction, $previousbreadcrumb, $params, $query);
	}
}
?>

