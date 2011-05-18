<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$widget_init = array(	
			'Id' 			=> "wRSS", 
			'Child'			=> "false",
			'Type' 			=> "inline", 
			'Title' 		=> "RSS Feeds", 
			'Function' 		=> "widgetRSS();",
			'HeaderFunction'=> "widgetRSSHeader();", 
			'Stylesheet' 	=> "",
			'Section' 		=> 3, 
			'Position' 		=> 4,
			'Parts'			=> "",
			'Block' 		=> "",  
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> ""
		    );

$settings_init['wRSS'] =	array(  'rssfeeds' =>	array(	
							'label'	=>	'RSS Feeds',
								'value' =>	array(	
											'rssfeed1' =>	array(	
														'label' 	=> 'mediafrontpage on github',
														'type'	 	=> 'atom',
														'url'		=> 'https://github.com/MediaFrontPage/mediafrontpage/commits/master.atom',
														'category'	=> '',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed2' =>	array(	'label' 	=> 'xbmc.org',
														'type    '	 	=> 'rss',
														'url     '		=> 'http://xbmc.org/feed/',
														'category'	=> '',
														'priority'	=> '',
														'postprocess'	=> '',
														'script  '	=> ''),
											'rssfeed3' =>	array(	'label' 	=> 'NZBMatrix - Sports',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=7',
														'category'	=> 'sports',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed4' =>	array(	'label' 	=> 'NZBMatrix - TV Shows (DivX)',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=6',
														'category'	=> 'tv',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed5' =>	array(	'label' 	=> 'NZBMatrix - TV Shows (HD x264)',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=41',
														'category'	=> 'tv',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed6' =>	array(	'label' 	=> 'NZBMatrix - Movies (DivX)',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=2',
														'category'	=> 'movies',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed7' =>	array(	'label' 	=> 'NZBMatrix - Movies (HD x264)',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=42',
														'category'	=> 'movies',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed8' =>	array(	'label' 	=> 'NZBMatrix - Music (MP3)',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=22',
														'category'	=> 'music',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> ''),
											'rssfeed9' =>	array(	'label' 	=> 'NZBMatrix - Music (Loseless)',
														'type'	 	=> 'rss',
														'url'		=> 'http://rss.nzbmatrix.com/rss.php?subcat=23',
														'category'	=> 'music',
														'priority'	=> '',
														'postprocess'	=> '',
														'script'	=> '')
										)
								)
					);

function widgetRSSHeader() {
	echo <<< RSSHEADER
<script type="text/javascript" language="javascript">
	<!--
		function showRSS(str) {
			if (str.length==0) {
				document.getElementById("rssOutput").innerHTML="";
				return;
			}
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("rssOutput").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","widgets/RSS Feeds/wRSS.php?style=s&rss="+str,true);
			xmlhttp.send();
		}
		function sabAddUrl(sablink) {
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.open("POST", "widgets/RSS Feeds/wRSS.php?style=a", true);

			//Send the proper header information along with the request
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.setRequestHeader("Content-length", sablink.length);
			xmlhttp.setRequestHeader("Connection", "close");

			xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					try {
						var sabjson = eval("("+xmlhttp.responseText+")");
						if(sabjson.status) {
							alert('Item successfully added to SABnzdd+.');
						} else {
							alert("Problem adding link to SABnzdd+.\\r\\n\\r\\nError: " + sabjson.error + "\\r\\n\\r\\n\\r\\n" + xmlhttp.responseText);
						}
					}
					catch(e) {
						alert("Problem calling SABnzdd+.\\r\\n\\r\\n"+xmlhttp.responseText);
					}
				}
			}
			xmlhttp.send(sablink);
		}
	-->
</script>

RSSHEADER;
}

function widgetRSS($formaction = "") {
	global $settings;

	$rssfeeds = $settings['rssfeeds'];
	$response = sabadd();
	if(!empty($response)) {
		$responsejson = json_decode($response, true);
		if(!empty($responsejson)) {
			if($responsejson['status']) {
				echo "<p>Item successfully added to SABnzdd+.</p>\n";
			} else {
				echo "<p>Problem adding link to SABnzdd+.</p>\n<p>Error: ".$responsejson["error"]."</p>\n";
			}
		} else {
			echo "<p>Problem calling SABnzdd+.</p>\n<pre>\n".$response."\n</pre>\n";
		}
	}
	
	if(!empty($formaction)) {
		echo "<form action=\"".$formaction."\" method=\"get\">\n";
		echo "<input type=\"hidden\" name=\"style\" value=\"".(!empty($_GET['style']) ? $_GET['style'] : "m")."\" />";
		echo "<input type=\"hidden\" name=\"w\" value=\"wRSS\" />";
		echo "\t<select name=\"feed\">\n";
	} else {
		echo "<form>\n";
		echo "\t<select onchange=\"showRSS(this.value);\">\n";
	}
	foreach($rssfeeds as $rssfeed) {
		echo "\t\t<option value=\"".$rssfeed['label']."\"".((!empty($_GET['feed']) && ($_GET['feed'] == $rssfeed['label'])) ? " selected=\"selected\"" : "").">".$rssfeed['label']."</option>\n";
	}
	echo "\t</select>\n";
	if(!empty($formaction)) {
		echo "\t<input type=\"submit\" value=\"Go\" />\n";
	}
	echo "</form>\n";
	echo "<div id=\"rssOutput\">";
	if(!empty($_GET['feed']) && !empty($rssfeeds[$_GET['feed']])) {
		displayRSS($rssfeeds[$_GET['feed']]);
	} else {
		displayRSS(reset($rssfeeds));
	}
	echo "</div>\n";
}

function sab_addurl($link, $name, $rssfeed){
	global $settings;
	$rssfeeds = $settings['rssfeeds'];
	$saburl = $settings['saburl'];
	$sabapikey = $settings['sabapikey'];

	$queryurl = $saburl."api?mode=addurl&name=".urlencode($link)."&nzbname=".urlencode($name);
	$queryurl .= (!empty($rssfeed['category']) ? "&category=".urlencode($rssfeed['category']) : "");
	$queryurl .= (!empty($rssfeed['script']) ? "&script=".$rssfeed['script'] : "");
	$queryurl .= (!empty($rssfeed['postprocess']) ? "&postprocess=".$rssfeed['postprocess'] : "");
	$queryurl .= (!empty($rssfeed['priority']) ? "&priority=".$rssfeed['priority'] : "");
	$queryurl .= "&output=json&apikey=".$sabapikey;
	return $queryurl;
}
function sabadd($sabaddurl = "") {
	$response = "";
	
	if(!empty($_GET['sabadd']) && empty($sabaddurl)) {
		$sabaddurl = ($_GET['sabadd']);
	}
	if(!empty($sabaddurl)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_URL, $sabaddurl);

		$response = curl_exec($ch);
		curl_close($ch);
	}

	return $response;
}
function displayRSS($rssfeed, $count = 10, $returnonly = false) {
	$return = "";
	if(!empty($rssfeed['url'])) {
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($rssfeed['url']);

		if(!empty($rssfeed['type']) && ($rssfeed['type'] == 'atom')) {
			//get and output "<item>" elements
			$x = $xmlDoc->getElementsByTagName('entry');
		} else {
			//get and output "<item>" elements
			$x = $xmlDoc->getElementsByTagName('item');
		}
		$alt = false;
		for ($i=0; $i<$count; $i++){
			if(!empty($rssfeed['type']) && ($rssfeed['type'] == 'atom')) {
				$item_title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				$item_desc = $x->item($i)->getElementsByTagName('content')->item(0)->childNodes->item(0)->nodeValue;
				$item_desc = str_replace("  ", " ", $item_desc);
				$item_desc = str_replace("\n\n", "\n", $item_desc);
				$item_desc = str_replace("\n", " <br/>", $item_desc);
				$item_link = $x->item($i)->getElementsByTagName('link')->item(0)->getAttribute('href');
			} else {
				$item_title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				$item_link = $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
				$item_desc = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
			}
			$item_desc = str_replace("'", "", str_replace("\"", "'", $item_desc));
			$return .= "<p class=\"".($alt ? " alt" : "")."\">";

			if(!empty($rssfeed['category']) || !empty($rssfeed['script']) || !empty($rssfeed['postprocess']) || !empty($rssfeed['priority'])) {
				$return .= "<a href=\"#\" class=\"sablink\" onclick=\"sabAddUrl('".htmlentities(sab_addurl($item_link, $item_title, $rssfeed))."'); return false;\">";
				$return .= "<img class=\"sablink\" src=\"style/images/sab2_16.png\" alt=\"Download with SABnzdd+\"/>";
				$return .= "</a>";
			}

			$return .= "<a href=\"".$item_link."\" target=\"_blank\" onMouseOver=\"ShowPopupBox('".$item_desc."');\" onMouseOut=\"HidePopupBox();\">".$item_title."</a>";
			$return .= "</p>";

			$alt = !$alt;
		}
	} else {
		$return = "<p>No RSS feed supplied.</p>";
	}

	if(!$returnonly) {
		echo $return;
	}
	return $return;
}
if(!empty($_GET['style']) && ($_GET['style'] == "a")){
	$sablink = file_get_contents("php://input");

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_URL, $sablink);

	$response = curl_exec($ch);
	curl_close($ch);

	echo $response;
}

if(!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {
	include_once "../../functions.php";

	$settingsDB = getAllSettings('sqlite:../../settings.db');
	$settings = formatSettings($settingsDB);

	$rssfeeds = $settings['rssfeeds'];
	$count = (!empty($_GET['c'])) ? $_GET['c'] : 10;
	if(!empty($_GET['rss']) || !empty($_GET['rssurl'])) {
		if(!empty($_GET['rssurl'])) {
			$rssfeed['url'] = $_GET['rssurl'];
		} else {
			foreach ($rssfeeds as $feed) {
					//echo $_GET['rss']."<br/>";
					//echo $feed['label']."<br/>";
				if ($feed['label'] == $_GET['rss']) {
					$rssfeed = $feed;
				}
			}
		}
	} else {
		$rssfeed = reset($rssfeeds);
	}
	if($_GET['style'] == "w") {
		?>
		<html>
			<head>
				<title>Media Front Page - RSS Feed</title>
				<link rel='stylesheet' type='text/css' href='css/front.css'>
			</head>
			<body>
				<?php displayRSS($rssfeed, $count); ?>
			</body>
		</html>
		<?php
	} else {
		displayRSS($rssfeed, $count);
	}
}
  
?>
