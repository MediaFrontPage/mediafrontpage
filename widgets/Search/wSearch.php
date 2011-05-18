<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
$widget_init = array(	
			'Id' 			=> "wSearch",
			'Child'			=> "false",
			'Type' 			=> "inline", 
			'Title' 		=> "Search Widget", 
			'Function' 		=> "widgetSearch();",
			'HeaderFunction'=> "", 
			'Stylesheet' 	=> "",
			'Section' 		=> 2, 
			'Position' 		=> 4,
			'Parts'			=> "",
			'Block' 		=> "",  
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> ""
		    );
$settings_init['wSearch'] =	array( 	'Search' 		=>	array(	
											'label'	=> '',
											'value' =>  array(	
												'NZBMatrix' => array(	
																'username' => '',
																'api' => '',
															),
												'NZB.su'	=> array(
																'api' => '',
																'download_code' => '',
															)
												)
										),
									'CouchPotato' => array(
										'label'	=>	'CouchPotatoURL',
										'value'	=>	'',
									)
								);


function widgetSearch() {	
	echo <<<BODY
            <div><input type="text"
                  value=""
                  id="searchterm"
                  onkeydown="if (event.keyCode == 13) document.getElementById('searchbutton').click()">  <select id='provider' onchange="catDropDown(this.value);">
                  <option value="0" selected>Default</option>
                  <option value="1">nzb.su</option>
                  <option value="2">NZB Matrix</option>
                  <option value="3">TMDB</option>
    			  </select> <select name="type" style="display:none;"
                  id="type">
            </select> <input type="button"
                  id="searchbutton"
                  value="Search"
                  onclick="results()"> <input type="button"
                  id="clearbutton"
                  value="Clear"
                  onclick="clearResults()"
                  ondblclick="resetWidget()"></div>
        <div id="resultstable"></div>
        <div id='extra_info'></div>         		
BODY;
}
function getResults() {
	include_once "../../functions.php";
	$settingsDB = getAllSettings('sqlite:../../settings.db');
	$settings = formatSettings($settingsDB);
	//print_r($settings);
	$saburl		= $settings['saburl'];
	$sabapikey 	= $settings['sabapikey'];
	

	$q=$_GET["q"];
	$site = $_GET["site"];
	$column2 = "class=\"header filesize\"><a href=#>Size ";
	$column3 = "Category";
	
	
	$cp_url = $settings['CouchPotato'];
	$settings = $settings['Search'];
	if($site == 1 || $site == 0){
		if(!empty($settings['NZB_su']['api']) && !empty($settings['NZB_su']['download_code'])){
			$nzbsuapi	= $settings['NZB_su']['api'];
			$nzbsudl 	= $settings['NZB_su']['download_code'];
		} else {
			echo "Missing NZB.su info. Check in the <a href='/settings.php?w=wSearch'>SETTINGS</a>";
		}

		$results = nzbsu($q, $saburl,$sabapikey, $nzbsuapi, $nzbsudl);
	}
	elseif($site == 2) {
		if(!empty($settings['NZBMatrix']['username']) && !empty($settings['NZBMatrix']['api'])){
			$nzbusername = $settings['NZBMatrix']['username'];
			$nzbapi 	 = $settings['NZBMatrix']['api'];
		}
		else{
			echo "Missing NZBMatrix info. Check in the <a href='/settings.php?w=wSearch'>SETTINGS</a>";
		}
		
		$results = nzbmatrix($q, $nzbusername, $nzbapi,$saburl,$sabapikey);		
	}
	elseif($site == 3) {
		$column2 = "><a href=#>Rating ";
		$column3 = "Year";

		$results = imdb($q,$cp_url);

		return false;
	}
	elseif(!empty($_GET['id']))
	{
		if(intval($_GET['id'])!=0)
		{
			getInfo($_GET['id'],$cp_url);
			return false;
		}
		else
		{
			getCP($id, $cp_url);
			return false;
		}
	}	
	$tablebody = "<div id='wSearch'>
					<table id='search-Table' class='tablesorter' width='100%' style='table-layout:fixed;' cellspacing='0'>
						<thead>
							<tr>
								<th style='width:3%;'></th>
								<th style='width:60%;' onclick=\"setTimeout('updateRows()',10);\"><a href=#>Name <img src=\"style/images/arrow.png\"/></a></th>
								<th style='width:15%;'onclick=\"setTimeout('updateRows()',10);\"$column2<img src=\"style/images/arrow.png\"/></a></th>
								<th style='width:20%;' onclick=\"setTimeout('updateRows()',10);\"><a href=#>$column3 <img src=\"style/images/arrow.png\"/></a></th>
							</tr>
						</thead>
						<tbody>";
	echo (!empty($results))? $tablebody.$results."</tbody></table></div>" : "<h1>Nothing found!</h1>";
}
function nzbsu($q, $saburl,$sabapikey, $nzbsuapi, $nzbsudl){
	$type = (!empty($_GET['type']))?("&cat=".$_GET['type']):"";
	$search = "http://nzb.su/api?t=search&q=".urlencode($q).$type."&apikey=".$nzbsuapi."&o=json";
	$json = @file_get_contents($search);
	$content = json_decode($json, true);
	//print_r($content);
	$table = "";
	foreach($content as &$array){
		//print_r($array);
		$id = $array['guid'];
		$name = $array['name'];
		$cat = $array['category_name'];
		$size = $array['size'];
		$postdate = "<p>Date Posted: ".$array['postdate']."</p>";
		$coments = "<p>Coments: ".$array['comments']."</p>";
		$group_name = "<p> Group name: ".$array['group_name']."</p>";
		$grabs = "<p> Grabs: ".$array['grabs']."</p>";
		(!empty($array['seriesfull']))?($seriesfull=("<p>Episode info: ".$array['seriesfull']." ".$array['tvtitle']." ".$array['tvairdate']."</p>")):($seriesfull="");

		$url="http://nzb.su/getnzb/".$id.".nzb".$nzbsudl;
		$addToSab = $saburl.'api?mode=addurl&name='.urlencode($url).'&output=json&apikey='.$sabapikey;
		$nzblink = "http://nzb.su/details/".$id;
		$name = str_replace(".", "\n", $name);
		$name = str_replace(" ", "\n", $name);
		$item_desc = "<p>Name: $name</p>".$postdate.$coments.$group_name.$grabs.$seriesfull;
		$item_desc = str_replace("\n", "<br>", $item_desc);
		$item_desc = str_replace("\"", " - ", $item_desc);		
		$item_desc = str_replace("'", "|", $item_desc);		

		$addToSab = addCategory($cat,$addToSab);
		if(strlen($name)!=0){
			$table .= (strpos(strtolower($cat), "xxx")===false)?printTable($name,$cat,$size,$addToSab,$nzblink,$item_desc):("");
		}
	}
	return $table;

}

function nzbmatrix($item, $nzbusername, $nzbapi,$saburl,$sabapikey) {
	$type = (!empty($_GET['type']))?("&catid=".$_GET['type']):"";
	$search = "https://api.nzbmatrix.com/v1.1/search.php?search=".urlencode($item).$type."&num=50&username=".$nzbusername."&apikey=".$nzbapi;
	$content = file_get_contents($search);
/*
	echo '<pre>';print_r($content);echo "</pre>";
	echo "---------";
*/
	if(!strstr($content, 'error')){
		$itemArray = explode('|',$content);
		$table = "";
		foreach($itemArray as $item){
		$item = explode(';',$item);
			if(strstr($item['0'],'N')){
/*
					foreach($item as $key => $value){
						echo $key;
						echo "-->";
						echo $value;
						echo "</br>";
						}
*/
				$id = str_replace(':', '', strstr($item['0'],':'));
				$name = str_replace(':', '', strstr($item['1'],':'));
				$link = str_replace(':', '', strstr($item['2'],':'));
				$size = 0+str_replace(':', '', strstr($item['3'],':'));;
				$size = $size;
				$cat = str_replace(':', '', strstr($item['6'],':'));
				$addToSab=$saburl."api?mode=addurl&name=http://www.".$link."&nzbname=".urlencode($name)."&output=json&apikey=".$sabapikey;
				$indexdate 	= $item['4'];
				$group 		= $item['7'];
				$comments 	= $item['8'];
				$hits 		= $item['9'];
				$nfo 		= $item['10'];
				$weblink 	= "http://www.".substr($item['11'], 9);
				$image 		= substr($item['13'],7);
				$item_desc	= "<p>Name: ".$name."</p><p>".$id."</p><p>".$group."</p><p>".$comments."</p><p>".$hits."</p><p>".$nfo."</p><p>".$indexdate."</p>";
				//echo "$name  |  $link  |  $size  |  $cat  |  $indexdate  |  $group  |  $comments  |  $hits  |  $nfo  |  $weblink  |  $image  |  $item_desc";
				
				$addToSab = addCategory($cat,$addToSab);
		
				if(strlen($name)!=0){
					$table .= printTable($name,$cat,$size,$addToSab,$link,$item_desc,$image, $weblink);
				}

			}
		}
	}
	else {
		return "Problems: $content";
	}
	return $table;

}

function imdb($item,$cp){
	
	$api = '1b0319774deb9c07ca72ecafa8f13f8f';
	$search = 'http://api.themoviedb.org/2.1/Movie.search/en/json/'.$api.'/'.urlencode($item);
	$json = @file_get_contents($search);
	$result = json_decode($json);

	//echo "<pre>";print_r($result);echo "</pre>";

	$table = "";
	if($result[0]!="Nothing found."){
		foreach($result as $e){
				$score		= $e->score;
				$popularity	= $e->popularity;
				$translated = $e->translated;
				$adult		= $e->adult;
				$lang		= $e->language;
				$orig_name	= $e->original_name;
				$name		= $e->name;
				$alt_name	= $e->alternative_name;
				$type		= $e->type;
				$id			= $e->id;
				$imdb_id	= $e->imdb_id;
				$votes		= $e->votes;
				$rating		= $e->rating;
				$certific	= $e->certification;
				$overview	= $e->overview;
				$released	= $e->released;
				$poster_th	= $e->posters['2']->image->url;
				$poster_lg	= $e->posters['1']->image->url;
				$last_mod	= $e->last_modified_at;
				$backdrops	= $e->backdrops;
				$url 		= $e->url;
				
				if(!empty($poster_th))
				{
					$image = "<a href=".$poster_lg." class=\"highslide\" onclick=\"return hs.expand(this)\"><img id='search-thumb' src='".$poster_th."' /></a>";			
				}
				else
				{
					$image = "<img id='search-thumb' src='style/images/no_poster.jpg' />";			

				}
				$imdb  = "<a href='http://www.imdb.com/title/".$imdb_id."' target='_blank'><img id='imdb-badge' src='style/images/imdb.png' /></a>";
				
				
				$item_desc = "";
				$item_desc .= ((!empty($orig_name))&&($orig_name!='null'||$orig_name!=""))? "<p><b>Original Name</b>: ".$orig_name."</p>":"";
				$item_desc .= ((!empty($type))&&($type!='null'||$type!=""))? "<p><b>Type</b>: ".urlencode($type)."</p>":"";
				$item_desc .= "<p><b>Overview</b>: ".$overview."</p>";
				$item_desc .= (!empty($certific))? "<p><b>Rated</b>: ".$certific."</p>":"";
				//$item_desc .= (!empty($orig_name))? "<p>Original Name:".$orig_name."</p>":"";
				//$item_desc .= (!empty($orig_name))? "<p>Original Name:".$orig_name."</p>":"";
				
				$item_desc = str_replace("\"", " - ", $item_desc);		
				$item_desc = str_replace("'", "|", $item_desc);		
				
				$cp_add = $cp."movie/imdbAdd/?id=".$imdb_id;
				
				$table .= "<tr class=\"row\">";
				$table .= "<td style='width:5%;'><a href='".$cp_add."?iframe=true&width=200&height=40' rel='prettyPhoto'><img class=\"couchpotato\" height='20px' src=\"style/images/couchpotato.png\" alt=\"Add to CouchPotato Queue\"/></a></td>";
				$table .= "<td>".$image.$imdb."<a href='#' onMouseOver=\"ShowPopupBox('$item_desc');\" onMouseOut=\"HidePopupBox();\" onClick=\"getExtra('".$id."');\">".$name."</a></td>";
				$table .= "<td style='width:13%'>$rating</td>";
				$table .= "<td style='width:10%'>".substr($released,0,4)."</td></tr>";
	
			}
			return $table;
		}
	return "";
}
function printTable($name,$cat,$size,$addToSab,$nzblink,$item_desc, $image="", $weblink="" ){
	if($image!=""){
	$image = "<a href=".$image." class=\"highslide\" onclick=\"return hs.expand(this)\"><img id='search-thumb' src='".$image."' /></a>";
	}
	if($weblink!=""){
		if(strpos($weblink,'imdb')!==false){
			$weblink = "<a href=".$weblink." target='_blank'><img id='imdb-badge' src='style/images/imdb.png' /></a>";
		}
		else{
			$weblink = "";
		}
	}
	return "	<tr class=\"row\">
					<td style='padding-top:5px;'><a href=\"#\";  onclick=\"sabAddUrl('".htmlentities($addToSab)."'); return false;\"><img class=\"sablink\" src=\"style/images/sab2_16.png\" alt=\"Download with SABnzdd+\"/></a></td>
					<td style='text-overflow:ellipsis;overflow:hidden; white-space: nowrap;'>".$image.$weblink."<a href='".$nzblink."' target='_blank'; onMouseOver=\"ShowPopupBox('".$item_desc."');\" onMouseOut=\"HidePopupBox();\"><div style='padding-top:4px;'>$name</div></a></td>
					<td style='padding-top:4px;' class='filesize'>".ByteSize($size)."</td>
					<td style='padding-top:4px;text-overflow:ellipsis;overflow:hidden; white-space: nowrap;'>$cat</td>
				</tr>";
}
function addCategory($cat,$url){
	$cat = strtolower($cat);
	if(strpos($cat, "movies")!==false||strpos($cat, "documentaries")!==false){
		$cat="&cat=movies";
	}
	elseif(strpos($cat, "tv")!==false){
		$cat="&cat=tv";
	}
	elseif(strpos($cat, "audio")!==false||strpos($cat, "music")!==false){
		$cat="&cat=music";
	}
	elseif(strpos($cat, "games")!==false||strpos($cat, "console")!==false){
		$cat="&cat=games";
	}
	elseif(strpos($cat, "apps")!==false||strpos($cat, "pc")!==false){
		$cat="&cat=apps";
	}
	else $cat="";

	if(!empty($cat)){
		$url .= $cat;
	}
	return $url;
}
function getInfo($id,$cp)
{
	echo "<button type='button' onclick='closeExtra();'><-Back</button>";
	echo "<div>";
	$search = "http://api.themoviedb.org/2.1/Movie.getInfo/en/json/1b0319774deb9c07ca72ecafa8f13f8f/".$id;
	$json = @file_get_contents($search);
	$result = json_decode($json);

	//echo "<pre>";print_r($result[0]);echo "</pre>";
	
	
	$m = $result[0];
	$name	  = $m->name; 
	$overview = $m->overview;
	$famous   = $m->popularity;
	$orig_name= $m->original_name;
	$rating	  = $m->rating;
	$tag	  = $m->tagline;
	$cert	  = $m->certification;
	$runtime  = $m->runtime;
	$budget	  = $m->budget;
	$revenue  = $m->revenue;
	$homepage = $m->homepage;
	$trailer  = $m->trailer;
	$votes	  = $m->votes;
	$imdb_id  = $m->imdb_id;
	$url	  = $m->url;
	$released = $m->released;	
	/*
	$	  = $m->;
	$	  = $m->;
	$	  = $m->;
	$	  = $m->;
	$	  = $m->;
	*/



	$x=0;
	foreach($m->posters as $c){
		if($c->image->height>150 && $c->image->height<250){
			$poster[$x] = $c->image->url;
			$x++;
		}
	}

	$x=0;
	foreach($m->backdrops as $c){
		if($c->image->size == 'poster'){
			$backdrop[$x] = $c->image->url;
			$x++;
		}
	}
	
	$poster[0] = (empty($poster[0]))?"style/images/no_poster.jpg":$poster[0];

	setlocale(LC_MONETARY, 'en_US');
	
	$budget  = (!empty($budget))?money_format('%(#0n', $budget):"NaN";
	$revenue = (!empty($revenue))?money_format('%(#0n', $revenue):"NaN";


	$cp_add = $cp."movie/imdbAdd/?id=".$imdb_id;
	$homepage_tag = (!empty($homepage))?("<a href='".$homepage."' target='_blank' >$homepage</a>"):"<a>";
	$trailer_tag  = (!empty($trailer))?("<a href='".$trailer."' rel='prettyPhoto' >$trailer</a>"):"";	//onclick='toggleTrailer(this)'
		
	echo "<p><a href='$cp_add?iframe=true&height=40&width=190' rel='prettyPhoto'><img id='movie-extra-badge' src='style/images/couchpotato.png' /></a>";
	echo "<a href='http://www.imdb.com/title/".$imdb_id."?iframe=true&height=95%&width=100%' rel='prettyPhoto'><img id='movie-extra-badge' src='style/images/imdb.png' /></a>";
	echo "<a href='$url?iframe=true?iframe=true&height=95%&width=100%' rel='prettyPhoto'><img id='movie-extra-badge' src='style/images/moviedb.png' /></a>";
	echo "<h1>$name <i id='movie-extra-rating'>$rating ($votes votes)</i></h1></p>";
	echo "<div style='float: left; width:28%;'><p><img src='".$poster[0]."' id='movie-extra-poster'></p><p>$orig_name</p><p>Date Released: $released</p><p>$tag</p></div>";
	echo "<table width='70%'>";
	echo "<tr><td align='right'><b>Overview</b>:</td><td id='movie-extra-overview'>$overview</td></tr>";
	echo "<tr><td align='right'><b>Genre</b>:</td><td id='movie-extra-generalinfo'> ";
	$x=0;
	foreach($m->genres as $c){
		$genre_name[$x] = $c->name;
		echo $genre_name[$x]." | ";
		$x++;
	}
	echo "</td></tr>";
	
	echo "<tr><td align='right'><b>Trailer</b>:</a></b></td><td id='movie-extra-generalinfo'>$trailer_tag</td></tr>";
	echo "<tr><td align='right'><b>Homepage</b>:</td><td id='movie-extra-generalinfo'>$homepage_tag</td></tr>";
	echo "<tr><td align='right'><b>Runtime</b>:</td><td id='movie-extra-generalinfo'> $runtime minutes</td></tr>";
	echo "<tr><td align='right'><b>Budget</b>:</td><td id='movie-extra-generalinfo'> $budget</td></tr>";
	echo "<tr><td align='right'><b>Revenue</b>:</td><td id='movie-extra-generalinfo'> $revenue</td></tr>";
	echo "<tr><td align='right'><b>Rated</b>:</td><td id='movie-extra-generalinfo'> $cert</td></tr>";
	echo "<tr><td align='right'><b>IMDB ID</b>:</td><td id='movie-extra-generalinfo'> $imdb_id</td></tr>";
	echo "<tr><td align='right'><b>Keywords</b>:</td><td id='movie-extra-generalinfo'> ";
	$x=0;
	foreach($m->keywords as $c){
		$keywords[$x] = $c;
		echo $keywords[$x]." | ";
		$x++;
	}
	echo "</td></tr>";
	echo "<tr><td align='right'><b>Studios</b>:</td><td id='movie-extra-generalinfo'> ";
	$x=0;
	foreach($m->studios as $c){
		$studio_name[$x] = $c->name;
		echo $studio_name[$x]." | ";
		$x++;
	}
	echo "</td></tr></table>";


	echo "<div style='float: right;'><button type='button' onclick='toggleCast();'>Cast & Crew</button></div>";
	echo "<div id='cast' style='display:none; width:100%;'>";
	echo "<table width='100%'><tr width='100%'><th></th><th> Name</th><th>Job</th><th>Character</th></tr>";
	foreach($m->cast as $c){
		$actor_name = $c->name;
		$actor_job	= $c->job;
		$actor_char	= $c->character;
		$actor_url 	= $c->url;
		$actor_thumb= $c->profile;

		$bg = ($x%2)?"class='actor-odd'":"";
		$x++;
		$actor_thumb = (!empty($actor_thumb))?$actor_thumb:"style/images/no_face.png";
		echo "<tr $bg><td width='25px'><img src='$actor_thumb' id='actor-thumb'></td><td> $actor_name </td><td> $actor_job </td><td> $actor_char</td></tr>";
				
	}
	echo "</table>";
	echo "</div>";
	echo "<div class='clear-float'></div>";
	$trailer_id = substr($trailer,31);
	echo "</div>";
}

function ByteSize($bytes)
{
	$size = $bytes / 1024;
	if($size < 1024)
	{
		$size = number_format($size, 2);
		$size .= ' KB';
	}
	else
	{
		if($size / 1024 < 1024)
		{
			$size = number_format($size / 1024, 2);
			$size .= ' MB';
		}
		else if ($size / 1024 / 1024 < 1024)
			{
				$size = number_format($size / 1024 / 1024, 2);
				$size .= ' GB';
			}

		else if ($size / 1024 / 1024 / 1024 < 1024)
			{
				$size = number_format($size / 1024 / 1024/ 1024, 2);
				$size .= ' TB';
			}
	}
	return $size;
}
if(!empty($_GET["q"])){
	getResults();
}
?>
		<html>
			<head>
				<title>Media Front Page - Search Widget</title>
				<link rel='stylesheet' type='text/css' href='css/front.css'>
		        <script type="text/javascript" src="widgets/Search/searchWidget.js"></script>
			</head>
			<body>
				<iframe name="nothing" height="0" width="0" style="visibility:hidden;display:none"></iframe>
			</body>
		</html>