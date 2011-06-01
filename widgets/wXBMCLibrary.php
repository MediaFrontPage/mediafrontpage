<?php
$wdgtXbmcLibrary = array("name" => "XBMC Library", "type" => "ajax", "block" => "xbmclibrarywrapper", "call" => "widgets/wXBMCLibrary.php?w=l&style=w&a=l", "interval" => 10000, "headerfunction" => "widgetLibraryHeader(\$params);");
$wIndex["wXBMCLibrary"] = $wdgtXbmcLibrary;

$wdgtRecentMovie = array("name" => "Recent Movies", "type" => "ajax", "block" => "recentmoviewrapper", "call" => "widgets/wXBMCLibrary.php?w=rm&style=w&a=rm&c=15", "interval" => 10000, "loader" => "cmdXbmcLibrary('recentmoviewrapper', 'widgets/wXBMCLibrary.php?w=rm&', 'rm', '', '', true);");
$wIndex["wRecentMovies"] = $wdgtRecentMovie;

$wdgtRecentTV = array("name" => "Recent Episodes", "type" => "ajax", "block" => "recenttvwrapper", "call" => "widgets/wXBMCLibrary.php?w=re&style=w&a=re&c=15", "interval" => 10000, "loader" => "cmdXbmcLibrary('recenttvwrapper', 'widgets/wXBMCLibrary.php?w=re&', 're', '', '', true);");
$wIndex["wRecentTV"] = $wdgtRecentTV;


function widgetLibraryHeader($params = array('count' => 15)) {
	//check the parameter
	echo <<< LIBRARYHEADER
		<script type="text/javascript" language="javascript">
		<!--
			function cmdXbmcLibrary(wrapper, harness, action, breadcrumb, query, refresh) {
				var cmdXbmcLibraryRequest = new ajaxRequest();
				var request = harness+"style=w&a="+action+"&bc="+breadcrumb+query;
				cmdXbmcLibraryRequest.open("GET", request, true);

				if(action!="p") {
					cmdXbmcLibraryRequest.onreadystatechange = function() {
						if (cmdXbmcLibraryRequest.readyState==4) {
							if (cmdXbmcLibraryRequest.status==200 || window.location.href.indexOf("http")==-1) {
								document.getElementById(wrapper).innerHTML=cmdXbmcLibraryRequest.responseText;
							} else {
								//alert("An error has occured making the request (XbmcLibrary)");
							}
						}
					}
				}
				cmdXbmcLibraryRequest.send(null);
				if(refresh) {
					var cmd = "cmdXbmcLibrary('" + wrapper + "', '" + harness + "', '" + action + "', '" + breadcrumb + "', '" + query + "', true)";
					if(action=="rm" && recentmoviewrapper_interval=="") {
						recentmoviewrapper_interval = setInterval(cmd, 60000);
					}
					if(action=="re" && recenttvwrapper_interval=="") {
						recenttvwrapper_interval = setInterval(cmd, 60000);
					}
					if(action=="d") {
						if(breadcrumb == "rm") {
							//alert("bc="+breadcrumb);
							clearInterval(recentmoviewrapper_interval);
							recentmoviewrapper_interval = "";
						}
						if(breadcrumb == "re") {
							clearInterval(recenttvwrapper_interval);
							recenttvwrapper_interval = "";
						}
					}
				}
				if(wrapper == 'xbmclibrarywrapper'){
					//alert(xbmclibrarywrapper_interval);
					clearTimeout(xbmclibrarywrapper_interval);
					xbmclibrarywrapper_interval = "";
				}
			}
		-->
		</script>

LIBRARYHEADER;
}
// ajaxPageLoad('widgets/wXBMCLibrary.php?w=re&style=w&a=re&c=15', 'recenttvwrapper');
// cmdXbmcLibrary('recenttvwrapper', 'widgets/wXBMCLibrary.php?w=re&', 'lv', 'l', '', false);
// echo "\t\t\tsetInterval(\"ajaxPageLoad('".$widget["call"]."', '".$widget["block"]."')\", ".$widget["interval"].");\n";

if (!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {
	require_once "../config.php";
	require_once "../functions.php";
	require_once "libXBMCLibrary.php";

	$action = $_GET['a'];
	$breadcrumb = (!empty($_GET['bc'])) ? $_GET['bc'] : "";

	$params = getParameters($_GET);

	if ($_GET['style'] == "w") {
		switch ($_GET['w']) {
			case "re": // Recent Episodes
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['wrapper'])) {
					$params['wrapper'] = $wdgtRecentTV['block'];
				}
				$params['harness'] = "widgets/wXBMCLibrary.php?w=re&";
				$params['refresh'] = true;
				break;
			case "rm":  // Recent Movies
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['wrapper'])) {
					$params['wrapper'] = $wdgtRecentMovie['block'];
				}
				$params['harness'] = "widgets/wXBMCLibrary.php?w=rm&";
				$params['refresh'] = true;
				break;
			default:
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['href'])) {
					$params['wrapper'] = $wdgtXbmcLibrary['block'];
				}
				$params['harness'] = "widgets/wXBMCLibrary.php?w=l&";
		}
		$params['href'] = "#";
	} else {
		if(empty($params['href'])) {
			$params['href'] = "wXBMCLibrary.php";
		}
	}
	
	executeVideo($_GET['style'], $action, $breadcrumb, $params);
}
?>