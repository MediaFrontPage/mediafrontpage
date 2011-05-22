<?php
$wIndex["wTrakt"] = array("name" => "trakt.tv", "type" => "inline", "function" => "wTrakt();", "headerfunction" => "wTraktHeader();");

function wTraktHeader()
{
echo <<< TRAKTHEADER
		<script type="text/javascript" language="javascript">
		<!--
		$(function() {
			$("a[rel^='prettyPhoto']").prettyPhoto(
	        {
	            social_tools: false
	        });		
		 });
		 				 				
		-->
		</script>
TRAKTHEADER;

}
function wTrakt()
{
	global $num;
	$num = rand(0,10);
/*
	echo '<h1>Featured Movie</h1>';
	wTraktTrendingMovies();
	echo '<h1>Featured TV Show</h1>';
	wTraktTrendingShows();
	echo '<h1>Featured New Episode</h1>';
	wTraktComingShows();
*/
	echo '<h1>Movie Recommendation</h1>';
	wTraktMovieRecommendations();
	echo '<h1>TV Recommendation</h1>';
	wTraktTVRecommendations();
	
/*
	echo '<script type="text/javascript" language="javascript">
		<!--
		$("a[rel^=\'prettyPhoto\']").prettyPhoto(
        {
            social_tools: false
        });		
		-->
		</script>';
*/

}
function traktMethods($traktApiMethods = "", $post = false, $format = "json", $debug = false) 
{
	require_once "config.php";
	global $trakt_api,$trakt_USERNAME,$trakt_PASSWORD;
	$response = "";
	echo (empty($trakt_api))?"<h1>API not set in config.php</h1>":"";
	$format = (!empty($format))?".".$format:"";
	$trakturl = 'http://api.trakt.tv/'.$traktApiMethods.$format.'/'.$trakt_api;
	$ttpass = sha1($trakt_PASSWORD);

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
				curl_setopt($ch, CURLOPT_USERPWD, $trakt_USERNAME.':'.$ttpass); 
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
			$tagline= $movie->tagline;
			$overview= $movie->overview;
			$cert  	= $movie->certification;
			$imdb  	= $movie->imdb_id;
			$tmdb  	= $movie->tmdb_id;
			$poster = $movie->images->poster;
			$fanart = $movie->images->fanart;
			$watch  = $movie->watchers;
			if($i==$num){
				if(!empty($tagline)){
					$overview = $tagline;
				}
				printItem('movie', $url, $title, $year, $poster, $overview, $runtime, $imdb, $tmdb, $trailer);
				return false;
			}
			$i++;
		}
	}
}
function wTraktMovieRecommendations()
{
	global $num;
	$result = traktMethods("recommendations/movies", true, "");
	if(!empty($result))
	{
		if($result->status !== "failure"){
			$i=0;
			foreach($result as $movie)
			{
				$title 	 = $movie->title;
				$year 	 = $movie->year;
				$url 	 = $movie->url;
				$runtime = $movie->runtime;
				$tagline = $movie->tagline;
				$overview= $movie->overview;
				$cert 	 = $movie->certification;
				$imdb 	 = $movie->imdb_id;
				$tmdb 	 = $movie->tmdb_id;
				$poster  = $movie->images->poster;
				$fanart  = $movie->images->fanart;
				$ratings = $movie->ratings->percentage;
				$votes	 = $movie->ratings->votes;
				$loved	 = $movie->ratings->loved;
				$hated	 = $movie->ratings->hated;
				if($i==$num){
					if(!empty($tagline)){
						$overview = $tagline;
					}
					printItem('movie', $url, $title, $year, $poster, $overview, $runtime, $imdb, $tmdb);
					return false;
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
function wTraktTVRecommendations()
{
	global $num;
	$result = traktMethods("recommendations/shows", true, "");
	if(!empty($result))
	{
		if($result->status !== "failure"){
			$i=0;
			foreach($result as $show)
			{
				$title 	 = $show->title;
				$year 	 = $show->year;
				$url 	 = $show->url;
				$country = $show->country;
				$runtime = $show->runtime;
				$aired 	 = $show->first_aired;
				$overview= $show->overview;
				$cert 	 = $show->certification;
				$imdb 	 = $show->imdb_id;
				$tvdb 	 = $show->tvdb_id;
				$poster  = $show->images->poster;
				$fanart  = $show->images->fanart;
				$ratings = $show->ratings->percentage;
				$votes	 = $show->ratings->votes;
				$loved	 = $show->ratings->loved;
				$hated	 = $show->ratings->hated;
				if($i==$num){
					printItem('tv', $url, $title, $year, $poster, $overview, $runtime, $imdb, $tvdb);
					return false;
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
	global $num;
	$result = traktMethods("calendar/shows");

	if(!empty($result)){
		$i=0;
		foreach($result as $item)
		{
			foreach($item->episodes as $episodes)
			{
				//print_r($episodes->show)
				$title  	= $episodes->show->title;
				$year   	= $episodes->show->year;
				$showUrl  	= $episodes->show->url;
				$aired   	= $episodes->show->first_aired;
				$country  	= $episodes->show->country;
				$overview 	= $episodes->show->overview;
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
				$name	  	= $episodes->episode->title;
				$epOverview	= $episodes->episode->overview;
				$epurl 		= $episodes->episode->url;
				$firstaired = $episodes->episode->first_aired;
				$screen  	= $episodes->episode->images->screen;
				
				if(!empty($season) && !empty($episode)){
					$epTitle = '<a href="'.$epurl.'">S'.$season.'E'.$episode.' - '.$name.'</a>';
				}
				if($i==$num){
					printItem('tv', $epurl, $title, $year, $poster, $overview, $runtime, $imdb, $tvdb, '', $epOverview, $epTitle);
					return false;
				}
				$i++;
			}
		}
	}
}
function wTraktTrendingShows()
{
	global $num;
	$result = traktMethods("shows/trending");
	if(!empty($result)){
		$i=0;
		foreach($result as $episodes)
		{
			//print_r($episodes)
			$title  	= $episodes->title;
			$year   	= $episodes->year;
			$url  		= $episodes->url;
			$aired   	= $episodes->first_aired;
			$country  	= $episodes->country;
			$overview 	= $episodes->overview;
			$runtime  	= $episodes->runtime;
			$network  	= $episodes->network;
			$airday  	= $episodes->air_day;
			$airtime 	= $episodes->air_time;
			$cert  		= $episodes->certification;
			$imdb   	= $episodes->imdb_id;
			$tvdb   	= $episodes->tvdb_id;
			$tvrage 	= $episodes->tvrage_id;
			$poster  	= $episodes->images->poster;
			$fanart  	= $episodes->images->fanart;
			$watchers	= $episodes->watchers;
			if($i==$num){
				printItem('tv', $url, $title, $year, $poster, $overview, $runtime, $imdb, $tvdb);
				return false;
			}
			$i++;
		}
	}
}
function printItem($type, $url, $title, $year, $poster, $overview, $runtime, $imdb, $tvmvdb, $trailer='', $epOverview ='', $epTitle = ''){
	if(!empty($imdb)){
		$imdb = '<a href="http://www.imdb.com/title/'.$imdb.'?iframe=true&height=95%&width=100%" rel="prettyPhoto"><img src="media/imdb.png" /></a>';
	}
	if(!empty($tvmvdb)){
		if($type == 'tv'){
			$tvmvdb = '<a href="http://thetvdb.com/index.php?tab=series&id='.$tvmvdb.'?iframe=true&height=95%&width=100%" rel="prettyPhoto"><img src="media/moviedb.png" /></a>';
		}
		if($type == 'movie'){
			$tvmvdb = '<a href="http://www.themoviedb.org/movie/'.$tvmvdb.'?iframe=true&height=95%&width=100%" rel="prettyPhoto"><img src="media/moviedb.png" /></a>';		
		}
	}
	if(!empty($trailer)){
		$trailer = '<a href="'.$trailer.'" rel="prettyPhoto"><img height="7px" style="float:right" src="youtube.png" /></a>';
	}
	if(!empty($epOverview) && $epOverview !== ''){
		$overview = $epOverview;
	}
	if(!empty($epTitle) && $epTitle !== ''){
		$overview = $epTitle.' - '.$overview;
	}
	echo '<h3><a href="'.$url.'">'.$title.' ('.$year.')</a>'.$trailer.'</h3>';
	echo '<table width=\'100%\'><tr>';
	echo '<td style=\'width:20%;\'><a href="'.$poster.'" class="highslide" onclick="return hs.expand(this)"><img src="'.$poster.'" width="50px" style="max-width:100%;padding-right:10px;" /></a>'.$imdb.$tvmvdb.'</td>';
	echo '<td><p style="text-align:justify;max-height:70px;overflow:auto;">'.$overview.' ('.$runtime.'mins)</p></td>';
	echo '</tr></table>';

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
