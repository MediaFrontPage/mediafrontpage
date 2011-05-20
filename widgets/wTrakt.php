<?php
$wIndex["wTrakt"] = array("name" => "trakt.tv", "type" => "inline", "function" => "wTrakt();", "headerfunction" => "wTraktHeader();");

function wTraktHeader()
{
echo <<< TRAKTHEADER
		<script type="text/javascript" language="javascript">
		<!-- 				
		function toggleTrakt(x)
		{
			if(document.getElementById(x).style.display == 'none')
			{
				document.getElementById(x).style.display = 'inline';
			}
			else
			{
				document.getElementById(x).style.display = 'none';
			}
		}

		-->
		</script>
TRAKTHEADER;

}
function wTrakt()
{
	require_once "config.php";
	global $trakt_api;

	echo (empty($trakt_api))?"<h1>API not set in config.php</h1>":"";
	wTraktTrendingMovies($trakt_api);
}


function wTraktTrendingMovies($api)
{	
	$result = json_decode(file_get_contents("http://api.trakt.tv/movies/trending.json/$api"));
	//echo "<pre>";print_r($result);echo "</pre>";
	if(!empty($result))
	{
	echo "<div id='ajax_cf' class=\"ContentFlow\" style='height:200; width:100%;'>
        <div class=\"loadIndicator\">
        	<div class=\"indicator\">
        	</div>
        </div>
        <div class=\"flow\">";
		foreach($result as $movie)
		{
			$title 	= $movie->title;
	        $year 	= $movie->year;
	        $date	= $movie->released;
	        $url 	= $movie->url;
	        $trailer= $movie->trailer;
	        $runtime= $movie->runtime;
	        $tag 	= $movie->tagline;
	        $overview= $movie->overview;
	        $cert 	= $movie->certification; 
	        $imdb 	= $movie->imdb_id;
	        $tmdb 	= $movie->tmdb_id;
	        $poster = $movie->poster;
	        $poster = $movie->images->poster;
	        $fanart = $movie->images->fanart;
	        $watch 	= $movie->watchers;

			echo "<img class=\"item\" title=\"$title\" src=\"$poster\"/ href=\"$url\" target=\"_blank\" >";

	
		}
    echo "</div>
       <div class=\"globalCaption\">
       </div>
    </div>";
	}
}

function wTraktComingShows($api) 
{	
	$result = json_decode(file_get_contents("http://api.trakt.tv/calendar/shows.json/$api"));

	//	echo "<pre>";print_r($result0);echo "</pre>";
	echo "<div style='overflow:scroll; height:60%;'>";
	foreach($result as $item)
	{
		$date = $item->date;
		foreach($item->episodes as $episodes)
		{
			//print_r($episodes->show)
            $showTitle 	= $episodes->show->title;
            $year 		= $episodes->show->year;
            $showUrl 	= $episodes->show->url;
            $aired 		= $episodes->show->first_aired;
            $country 	= $episodes->show->country;
            $showOverview 	= $episodes->show->overview;
            $runtime 	= $episodes->show->runtime;
            $network 	= $episodes->show->network;
            $airday 	= $episodes->show->air_day;
            $airtime 	= $episodes->show->air_time;
            $cert		= $episodes->show->certification;
            $imdb 		= $episodes->show->imdb_id;
            $tvdb 		= $episodes->show->tvdb_id;
            $tvrage 	= $episodes->show->tvrage_id;
            $poster 	= $episodes->show->images->poster;
            $fanart 	= $episodes->show->images->fanart;
            $season 	= sprintf('%02d',$episodes->episode->season);
            $episode 	= sprintf('%02d',$episodes->episode->number);
            $Title 		= $episodes->episode->title;
            $overview 	= $episodes->episode->overview;
            $url		= $episodes->episode->url;
            $firstaired = $episodes->episode->first_aired;
            $screen 	= $episodes->episode->images->screen;
            
            $c = sprintf('%2u',$a+$b);
            echo "<a onclick=\"toggleTrakt('$url');\">v</a><h1><div style='text-align:left; text-overflow:ellipsis; overflow:hidden; white-space: nowrap;'><a href='$showUrl' target='_blank'>$showTitle</a> ($year) </div></h1>";
            echo "<div id='$url' style='height:60%; width:100%; display:none;'>";
            echo "<div id='content'>";
            echo "<p><img src='$poster' width='20%' style='float:left;padding-bottom:5px;' /><font color='white'><p> $network  </p><p> $airday's @ $airtime for $runtime minutes </p><p><a href='$url' target='_blank'>S$season"."E$episode - $title<a>  </p><p> $overview </p></font></p>";
            echo "</div>";
            echo "</div>";
        }
	}
	echo "<div id='clear-float'></div>";
	echo "</div>";
}
//wTrakt();

?>
