<?php

$widgetMediaLibrary = array(
			'Id' 			=> "wMediaLibrary", 
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Media Library", 
			'Parts'			=> "",
			'Stylesheet' 	=> "",
			'Section' 		=> 2, 
			'Position' 		=> 1,
			'Function' 		=> "",
			'HeaderFunction'=> "",
			'Block' 		=> "medialibrarywrapper",   
			'Call'			=> "widgets/xbmc/wXBMC.php?w=l&style=w&a=l",
			'Loader'		=> "",
			'Interval'		=> "0",
			'Script'		=> ""
		     );

$widgetRecentEpisodes = array(	
			'Id' 			=> "wRecentEpisodes", 
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Recent Episodes", 
			'Parts'			=> "",
			'Stylesheet' 	=> "",
			'Section' 		=> 1, 
			'Position' 		=> 2,
			'Function' 		=> "",
			'HeaderFunction'=> "",
			'Block' 		=> "recentepisodeswrapper",   
			'Call'			=> "widgets/xbmc/wXBMC.php?w=l&style=w&a=re&c=15",
			'Loader'		=> "cmdXbmcLibrary('recentepisodeswrapper', 'widgets/xbmc/wXBMC.php?w=re&', 're', '', '', true);",
			'Interval'		=> "60000",
			'Script'		=> ""
		     );

$widgetRecentMovies = array(	
			'Id' 			=> "wRecentMovies", 
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Recent Movies", 
			'Parts'			=> "",
			'Stylesheet' 	=> "",
			'Section' 		=> 3, 
			'Position' 		=> 2,
			'Function' 		=> "",
			'HeaderFunction'=> "",
			'Block' 		=> "recentmovieswrapper",   
			'Call'			=> "widgets/xbmc/wXBMC.php?w=rm&style=w&a=rm&c=15",
			'Loader'		=> "cmdXbmcLibrary('recentmovieswrapper', 'widgets/xbmc/wXBMC.php?w=rm&', 'rm', '', '', true);",
			'Interval'		=> "60000",
			'Script'		=> ""
		     );

$widget_init = array(
			'Id' 			=> "wXBMC", 
			'Child'			=> "false",
			'Type' 			=> "empty", 
			'Title' 		=> "XBMC", 
			'Parts'			=> array($widgetMediaLibrary,$widgetRecentEpisodes,$widgetRecentMovies),
			'Stylesheet' 	=> "",
			'Section' 		=> 0, 
			'Position' 		=> 0,
			'Function' 		=> "",
			'HeaderFunction'=> "widgetMediaLibraryHeader();",
			'Block' 		=> "",   
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> ""
		     );

$settings_init['wXBMC'] =	array(  'xbmcjsonservice'	=>	array(	
										'label' => 'XBMC JSON Server Address',
										'value' => 'http://USER:PASSWORD@localhost:8080/jsonrpc'),
					
									'xbmcimgpath'		=>	array(	
										'label' => 'XBMC Image Path',
										'value' => 'http://localhost:8080/vfs/'),		
										'xbmcdbconn' 		=>	array(	
											'label'	=> 'XBMC Database',
											'value' =>  array(	
												'video' => array(	
																'dns' => 'sqlite:/home/xbmc/.xbmc/userdata/Database/MyVideos34.db',
																'username' => '',
																'password' => '',
																'options' => array()
															),
													'music' => array(
																'dns' => 'sqlite:/home/xbmc/.xbmc/userdata/Database/MyMusic7.db',
																'username' => '',
																'password' => '',
																'options' => array()
															)
												)
										)
					);

function widgetMediaLibraryHeader($params = array('count' => 15)) {
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
								alert("An error has occured making the request (XbmcLibrary)");
							}
						}
					}
				}
				cmdXbmcLibraryRequest.send(null);
				if(refresh) {
					var cmd = "cmdXbmcLibrary('" + wrapper + "', '" + harness + "', '" + action + "', '" + breadcrumb + "', '" + query + "', true)";
					if(action=="rm" && recentmovieswrapper_interval=="") {
						recentmovieswrapper_interval = setInterval(cmd, 60000);
					}
					if(action=="re" && recentepisodeswrapper_interval=="") {
						recentepisodeswrapper_interval = setInterval(cmd, 60000);
					}
					if(action=="d") {
						if(breadcrumb == "rm") {
							//alert("bc="+breadcrumb);
							clearInterval(recentmovieswrapper_interval);
							recentmoviewsrapper_interval = "";
						}
						if(breadcrumb == "re") {
							clearInterval(recentepisodeswrapper_interval);
							recentepisodeswrapper_interval = "";
						}
					}
				}
			}
		-->
		</script>

LIBRARYHEADER;
}

if (!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {
	require_once "../../functions.php";
	require_once "libXBMC.php";

	$settingsDB = getAllSettings('sqlite:../../settings.db');
	$settings = formatSettings($settingsDB);
	$xbmcjsonservice = $settings['xbmcjsonservice'];
	$xbmcimgpath = $settings['xbmcimgpath'];
	$action = $_GET['a'];
	$breadcrumb = (!empty($_GET['bc'])) ? $_GET['bc'] : "";

	$params = getParameters($_GET);

	if ($_GET['style'] == "w") {
		switch ($_GET['w']) {
			case "re": // Recent Episodes
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['wrapper'])) {
					$params['wrapper'] = $widgetRecentEpisodes['Block'];
				}
				$params['harness'] = "widgets/xbmc/wXBMC.php?w=re&";
				$params['refresh'] = true;
				break;
			case "rm":  // Recent Movies
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['wrapper'])) {
					$params['wrapper'] = $widgetRecentMovies['Block'];
				}
				$params['harness'] = "widgets/xbmc/wXBMC.php?w=rm&";
				$params['refresh'] = true;
				break;
			default:
				$params['onclickcmd'] = "cmdXbmcLibrary";
				if(empty($params['href'])) {
					$params['wrapper'] = $widgetMediaLibrary['Block'];
				}
				$params['harness'] = "widgets/xbmc/wXBMC.php?w=l&";
		}
		$params['href'] = "#";
	} else {
		if(empty($params['href'])) {
			$params['href'] = "widgets/xbmc/wXBMC.php";
		}
	}
	
	executeVideo($_GET['style'], $action, $breadcrumb, $params);
}

?>
