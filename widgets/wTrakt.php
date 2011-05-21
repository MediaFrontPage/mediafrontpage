<?php
$wIndex["wTrakt"] = array("name" => "trakt.tv", "type" => "inline", "function" => "wTrakt();", "headerfunction" => "wTraktHeader();");

function wTraktHeader()
{
echo <<< TRAKTHEADER
		<script type="text/javascript" language="javascript">
		<!-- 				
		-->
		</script>
TRAKTHEADER;

}
function wTrakt()
{
/*
	echo "<div id='ajax_cf' class=\"ContentFlow\" style='height:200; width:100%;'>
        <div class=\"loadIndicator\">
        	<div class=\"indicator\">
        	</div>
        </div>
        <div class=\"flow\">";
		wTraktTrendingMovies();
    echo "</div>
       <div class=\"globalCaption\">
       </div>
    </div>";
*/
	global $num;
	$num = rand(1,10);
	echo '<h1>Featured Movie</h1>';
	wTraktTrendingMovies();
	echo '<h1>Featured New Episode</h1>';
	wTraktComingShows();
	echo '<h1>Featured Recommendation</h1>';
	wTraktMovieRecommendations();
}
function traktMethods($traktApiMethods = "", $post = false, $format = "json", $debug = false) 
{
	require_once "config.php";
	global $trakt_api,$trakt_USERNAME,$trakt_PASSWORD;
	$response = "";
	echo (empty($trakt_api))?"<h1>API not set in config.php</h1>":"";
	$format = (!empty($format))?".".$format:"";
	$trakturl = 'http://api.trakt.tv/'.$traktApiMethods.$format.'/'.$trakt_api;
	$trakt_PASSWORD = sha1($trakt_PASSWORD);

	if(!empty($traktApiMethods)) 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $trakturl);
		if($post)
		{
			if(!empty($trakt_PASSWORD) && !empty($trakt_USERNAME))
			{
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_USERPWD, $trakt_USERNAME.':'.$trakt_PASSWORD); 
			}
			else 
			{
				echo "Username|Password not set";
				curl_close($ch);
				return false;
			}
		}
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
	}
	if($debug)
	{
		echo "URL: $trakturl";
		echo "\nUSERNAME: $trakt_USERNAME";
		echo "\nPASSWORD: $trakt_PASSWORD";
		echo "<pre>";print_r($response);echo "</pre>";
		return false;
	}

	return $response;
}
function wTraktTrendingMovies()
{
	global $num;
	$result = traktMethods("movies/trending");
	if(!empty($result))
	{
		$i=0;
		foreach($result as $movie)
		{
			$title  = $movie->title;
			$year  	= $movie->year;
			$date 	= $movie->released;
			$url  	= $movie->url;
			$trailer= $movie->trailer;
			$runtime= $movie->runtime;
			$tag  	= $movie->tagline;
			$overview= $movie->overview;
			$cert  	= $movie->certification;
			$imdb  	= $movie->imdb_id;
			$tmdb  	= $movie->tmdb_id;
/* 			$poster = $movie->poster; */
			$poster = $movie->images->poster;
			$fanart = $movie->images->fanart;
			$watch  = $movie->watchers;
/* 			echo "<img class=\"item\" title=\"$title\" src=\"$poster\"/ href=\"$url\" target=\"_blank\" >"; */
			if($i==$num){
				echo '<h3><a href="'.$url.'">'.$title.' ('.$year.')</a></h3>';
				echo '<a href="'.$poster.'" class="highslide" onclick="return hs.expand(this)"><img style="float:left" src="'.$poster.'" height="50px" /></a>';
				echo '<p>'.(!empty($tag))?$tag:$overview.'</p>';
				echo '<p>Runtime: '.$runtime.' minutes</p>';
				echo '<div style="clear:both"></div>';
			}
			$i++;
		}
	}
}
function wTraktMovieRecommendations()
{
	$result = traktMethods("recommendations/movies", true, "");
	if(!empty($result))
	{
		if($result->status !== "failure"){
			$i=0;
			foreach($result as $movie)
			{
				$title 	 = $movie->title;
				$year 	 = $movie->year;
				$date 	 = $movie->date;
				$url 	 = $movie->url;
				$runtime = $movie->runtime;
				$tagline = $movie->tagline;
				$overview= $movie->overview;
				$cert 	 = $movie->certification;
				$imdb_id = $movie->imdb_id;
				$tmdb_id = $movie->tmdb_id;
				$poster  = $movie->images->poster;
				$fanart  = $movie->images->fanart;
				$ratings = $movie->ratings->percentage;
				$votes	 = $movie->ratings->votes;
				$loved	 = $movie->ratings->loved;
				$hated	 = $movie->ratings->hated;

/* 				echo "<img class=\"item\" title=\"$title\" src=\"$poster\"/ href=\"$url\" target=\"_blank\" >"; */
				if($i==$num){
					echo '<h3><a href="'.$url.'">'.$title.' ('.$year.')</a></h3>';
					echo '<a href="'.$poster.'" class="highslide" onclick="return hs.expand(this)"><img style="float:left" src="'.$poster.'" height="50px" /></a>';
					echo '<p>'.(!empty($tag))?$tag:$overview.'</p>';
					echo '<p>Runtime: '.$runtime.' minutes</p>';
					echo '<div style="clear:both"></div>';
				}
				$i++;
			}
		}
		else
		{
			echo "Authentication failed";
		}
	}
}
function wTraktComingShows()
{
	$result = traktMethods("calendar/shows");

	if(!empty($result)){
		$i=0;
		foreach($result as $item)
		{
			$date = $item->date;
			foreach($item->episodes as $episodes)
			{
				//print_r($episodes->show)
				$showTitle  = $episodes->show->title;
				$year   	= $episodes->show->year;
				$showUrl  	= $episodes->show->url;
				$aired   	= $episodes->show->first_aired;
				$country  	= $episodes->show->country;
				$showOverview = $episodes->show->overview;
				$runtime  	= $episodes->show->runtime;
				$network  	= $episodes->show->network;
				$airday  	= $episodes->show->air_day;
				$airtime 	= $episodes->show->air_time;
				$cert  		= $episodes->show->certification;
				$imdb   	= $episodes->show->imdb_id;
				$tvdb   	= $episodes->show->tvdb_id;
				$tvrage 	= $episodes->show->tvrage_id;
				$poster  	= $episodes->show->images->poster;
				$fanart  	= $episodes->show->images->fanart;
				$season  	= sprintf('%02d',$episodes->episode->season);
				$episode  	= sprintf('%02d',$episodes->episode->number);
				$Title   	= $episodes->episode->title;
				$overview  	= $episodes->episode->overview;
				$url  		= $episodes->episode->url;
				$firstaired = $episodes->episode->first_aired;
				$screen  	= $episodes->episode->images->screen;

/* 				echo "<img class=\"item\" title=\"$title\" src=\"$poster\"/ href=\"$url\" target=\"_blank\" >"; */
				if($i==$num){
					echo '<h3><a href="'.$showUrl.'">'.$showTitle.' ('.$year.')</a></h3>';
					echo '<a href="'.$poster.'" class="highslide" onclick="return hs.expand(this)"><img style="float:left" src="'.$poster.'" height="50px" /></a>';
					echo '<p>'.(!empty($overview))?$overview:$showOverview.'</p>';
					echo '<p>Runtime: '.$runtime.' minutes</p>';
					echo '<div style="clear:both"></div>';
				}
				$i++;
			}
		}
	}
}

if(!empty($_GET['type']))
{
	require_once "../config.php";
	if($_GET['type'] == 'movies_trakt')
	{
		wTraktTrendingMovies();
	}
	if($_GET['type'] == 'tvtrakt')
	{
		wTraktComingShows();
	}
	if($_GET['type'] == 'movie_rec')
	{
		wTraktMovieRecommendations();
	}
}
?>
