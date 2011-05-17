<?php

$widget_init = array(
			'Id' 			=> "wSabnzbd",
			'Child'			=> "false",
			'Type' 			=> "ajax", 
			'Title' 		=> "Sabnzbd", 
			'Function' 		=> "",
			'HeaderFunction'=> "widgetSabnzbdHeader();", 
			'Stylesheet' 	=> "",
			'Section' 		=> 3, 
			'Position' 		=> 3,
			'Parts'			=> "",
			'Block' 		=> "sabnzbdwrapper",  
			'Call'			=> "widgets/Sabnzbd/wSabnzbd.php?style=w&c=15",
			'Loader'		=> "",
			'Interval'		=> 10000,
			'Script'		=> ""
		    );

$settings_init['wSabnzbd'] =	array(  'saburl'    => 	array(	
												'label'	=>	'Sabnzbd URL',
												'value' =>	'http://localhost:8080/sabnzbd/'),
												'sabapikey' =>	array(	
													'label'	=>	'Sabnzbd API Key',
													'value' =>	'')
										);

function widgetSabnzbdHeader() {
	echo <<< SABNZBDHEADER
		<script type="text/javascript" language="javascript">
		<!--
			function cmdSabnzbd(requesturl) {
//alert(requesturl);
				var cmdSabnzbdRequest = new ajaxRequest();
				cmdSabnzbdRequest.open("GET", requesturl, true);
				cmdSabnzbdRequest.onreadystatechange = function() {
					if (cmdSabnzbdRequest.readyState==4) {
						if (cmdSabnzbdRequest.status==200 || window.location.href.indexOf("http")==-1) {
							document.getElementById("sabnzbdwrapper").innerHTML = cmdSabnzbdRequest.responseText;
						} else {
							//alert("An error has occured making the request");
						}
					}
				}
				cmdSabnzbdRequest.send(null);
			}
		-->
		</script>
SABNZBDHEADER;
}

function sabQuery($command, $values = array()) {
	include_once "../../functions.php";

	$settingsDB = getAllSettings('sqlite:../../settings.db');
	$settings = formatSettings($settingsDB);
	$saburl = $settings['saburl'];
	$sabapikey = $settings['sabapikey'];

	$getParameter = "";
	foreach ($values as $key => $value) {
		$getParameter .= "&" . $key . "=" . $value;
	}
	
	$queryurl = $saburl."api?mode=".$command."&output=json"."&apikey=".$sabapikey;
	$queryurl .= $getParameter;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $queryurl);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$results = json_decode(curl_exec($ch), true);
	curl_close($ch);
	
	return $results;
}

function sabStatus($count = 15) {
	include_once "../../functions.php";

	$settingsDB = getAllSettings('sqlite:../../settings.db');
	$settings = formatSettings($settingsDB);
	$saburl = $settings['saburl'];
	$sabapikey = $settings['sabapikey'];

	//$sabqueue = sabQuery("qstatus");
	$sabqueueAdvanced = sabQuery("queue");
	$sabqueue = $sabqueueAdvanced['queue'];
	
	if(!empty($_GET['debug']) && $_GET['debug']=='y') {
		echo "<br/><pre>".print_r($sabqueue, true)."</pre>";
	}

	$ajaxurl = (!empty($_GET['style']) && ($_GET['style'] == "m") ? "index.php?w=wSabnzbd&" : "widgets/Sabnzbd/wSabnzbd.php?").(!empty($_GET['style']) ? "style=".$_GET['style']."&" : "")."c=".$count."&";
	$pathtoimages = ((!empty($_GET['style']) && (($_GET['style'] == "m") || ($_GET['style'] == "s"))) ? "../" : "./");
	$state = ($sabqueue["status"]);	

	echo "\t\t<div id=\"sab-header\">\n";
	if (strtolower($state) == "downloading") {
		$cmdPauseResume = $ajaxurl."cmd=pause";
		if(!empty($_GET['style']) && ($_GET['style'] == "w")) {
			echo "\t\t\t<p><a href=\"#\" onclick=\"cmdSabnzbd('".$cmdPauseResume."');\">$state</a>";	
		} else {
			echo "\t\t\t<p><a href=\"".$cmdPauseResume."\" target=\"nothing\">$state</a>";	
		}

		echo " - Speed: ".$sabqueue["speed"]." - Timeleft: ".$sabqueue["timeleft"]."</p>\n";
		$totalQ = (int)$sabqueue["mb"];
		$remainingQ = (int)$sabqueue["mbleft"];
		if($totalQ!=0){
			$percentageQ = (int)((($totalQ - $remainingQ) / $totalQ)*100);
			//Total progress bar
			echo "\t\t\t<div id=\"sab-total\" class=\"progressbar\"><div class=\"progress\" style=\"width:".$percentageQ."%\"></div><div class=\"progresslabel\">".$sabqueue['sizeleft']." / ".$sabqueue['size']."</div></div>\n";
		}
	} else {
		$cmdPauseResume = $ajaxurl."cmd=".((strtolower($state) == "paused") ? "resume" : "pause");
		if(!empty($_GET['style']) && ($_GET['style'] == "w")) {
			echo "\t\t\t<p><a href=\"#\" onclick=\"cmdSabnzbd('".$cmdPauseResume."');\">$state</a></p>\n";	
		} else {
			echo "\t\t\t<p><a href=\"".$cmdPauseResume."\" target=\"nothing\">$state</a></p>\n";	
		}
		echo "\t\t</div><!-- #sab-header -->\n";
	}

	echo "\t\t<div id=\"sab-queue\">\n";
	if(!empty($sabqueue["slots"])) {
		$i = 0;
		foreach($sabqueue["slots"] as $slot) {
			if($i < $count) {
				$total = (int)$slot["mb"];
				$remaining = (int)$slot["mbleft"];
				if($total > 0 && is_numeric($remaining)) {
					$percentage = (int)((($total - $remaining) / $total)*100);

					// filename
					$fullname = $slot["filename"];

					//The sab ID to get individual pause/resume and delete 
					$id = $slot["nzo_id"];

					//the delete url for individual items
					$cmdDelete = $ajaxurl."cmd=".urlencode("queue&name=delete&value=".$id);

					//the current status for individual item
					$status = ($slot["status"]);
					if (strtolower($status) == "paused"){
						//If paused $pause is the RESUME url (the button resumes the item)
						$cmdPauseResume = $ajaxurl."cmd=".urlencode("queue&name=resume&value=".$id);
						//When paused, adds PAUSED to the front of the name.
						$name = "PAUSED - ".$fullname;
					}
					else{
						// if not paused $pause is the PAUSE url
						$cmdPauseResume = $ajaxurl."cmd=".urlencode("queue&name=pause&value=".$id);
						$name = $fullname;
					}
					if(!empty($_GET['style']) && ($_GET['style'] == "w")) {
						$actions = "<img src=\"".$pathtoimages."style/images/btnPlayPause.png\" onclick=\"cmdSabnzbd('".$cmdPauseResume."');\" />";
						$actions .= "<img src=\"".$pathtoimages."style/images/btnQueueDelete.png\" onclick=\"cmdSabnzbd('".$cmdDelete."');\" />";
					} else {
						$actions = "<a href=\"".$cmdPauseResume."\" target=\"nothing\"><img src=\"".$pathtoimages."style/images/btnPlayPause.png\" /></a>";
						$actions .= "<a href=\"".$cmdDelete."\" target=\"nothing\"><img src=\"".$pathtoimages."style/images/btnQueueDelete.png\" /></a>";
					}
					echo "\t\t\t<div class=\"queueitem\">\n";
					echo "\t\t\t\t<div class=\"progressbar\">\n";
					echo "\t\t\t\t\t<div class=\"progress\" style=\"width:".$percentage."%\"></div>\n";
					echo "\t\t\t\t\t<div class=\"progresslabel\">".$name."</div>\n";
					echo "\t\t\t\t</div><!-- .progressbar -->\n";
					echo "\t\t\t\t<div class=\"actions\">".$actions."</div>\n";
					echo "\t\t\t</div><!-- .queueitem -->\n";
				}

		} else {
				break;
			}
			$i += 1;
		}
	}
	echo "\t\t</div><!-- #sab-queue -->\n";

}

if(!empty($_GET['cmd'])) {

	sabQuery(urldecode($_GET['cmd']));
}

if(!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {

	$count = (!empty($_GET['c'])) ? $_GET['c'] : 15;
	if($_GET['style'] == "w") {
?>
<html>
	<head>
		<title>Media Front Page - SABnzbd Status</title>
		<link rel='stylesheet' type='text/css' href='css/front.css'>
	</head>
	<body>
<?php
		sabStatus($count);
?>
	</body>
</html>
<?php
	} else {
		sabStatus($count);
	}
}
?>

