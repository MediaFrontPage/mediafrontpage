<?php
$wdgtSabnzbd = array("name" => "Sabnzbd", "type" => "ajax", "block" => "sabnzbdwrapper", "headerfunction" => "widgetSabnzbdHeader();", "call" => "widgets/wSabnzbd.php?style=w&c=15", "interval" => 10000);
$wIndex["wSabnzbd"] = $wdgtSabnzbd;

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
	global $saburl, $SABNZBD_API;

	$getParameter = "";
	foreach ($values as $key => $value) {
		$getParameter .= "&" . $key . "=" . $value;
	}
	
	$queryurl = $saburl."api?mode=".$command."&output=json"."&apikey=".$SABNZBD_API;
	$queryurl .= $getParameter;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $queryurl);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //ignoring the check of SSL certificates.
        $results = json_decode(curl_exec($ch), true);
	curl_close($ch);
	
	return $results;
}

function sabStatus($count = 15) {
	global $saburl, $sabapikey;


	//$sabqueue = sabQuery("qstatus");
	$sabqueueAdvanced = sabQuery("queue");
	$sabqueue = $sabqueueAdvanced['queue'];
	
	if(!empty($_GET['debug']) && $_GET['debug']=='y') {
		echo "<br/><pre>".print_r($sabqueue, true)."</pre>";
	}

	$ajaxurl = (!empty($_GET['style']) && ($_GET['style'] == "m") ? "index.php?w=wSabnzbd&" : "widgets/wSabnzbd.php?").(!empty($_GET['style']) ? "style=".$_GET['style']."&" : "")."c=".$count."&";
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

		//href link is the resume URL for all the queue
		echo " - Speed: ".$sabqueue["speed"]." - Timeleft: ".$sabqueue["timeleft"]."</p>\n";
		$totalQ = (int)$sabqueue["mb"];
		$remainingQ = (int)$sabqueue["mbleft"];
		if($totalQ!=0){
			$percentageQ = (int)((($totalQ - $remainingQ) / $totalQ)*100);
			//Total progress bar with Time Left and MB left/ MB remainig as you can see from previous posts. It only shows up when the queue is not paused
			echo "\t\t\t<div id=\"sab-total\" class=\"progressbar\"><div class=\"progress\" style=\"width:".$percentageQ."%\"></div><div class=\"progresslabel\">".$sabqueue['sizeleft']." / ".$sabqueue['size']."</div></div>\n";
		}
	} else {
		//href link is the pause URL for all the queue
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
					$name = $slot["filename"];

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
						//$name = "PAUSED - ".$fullname;
						$font = "red";
					}
					else{
						// if not paused $pause is the PAUSE url
						$cmdPauseResume = $ajaxurl."cmd=".urlencode("queue&name=pause&value=".$id);
						//$name = $fullname;
						$font = "green";
					}
					if(!empty($_GET['style']) && ($_GET['style'] == "w")) {
						$actions = "<img src=\"".$pathtoimages."media/btnPlayPause.png\" onclick=\"cmdSabnzbd('".$cmdPauseResume."');\" />";
						$actions .= "<img src=\"".$pathtoimages."media/btnQueueDelete.png\" onclick=\"cmdSabnzbd('".$cmdDelete."');\" />";
					} else {
						$actions = "<a href=\"".$cmdPauseResume."\" target=\"nothing\"><img src=\"".$pathtoimages."media/btnPlayPause.png\" /></a>";
						$actions .= "<a href=\"".$cmdDelete."\" target=\"nothing\"><img src=\"".$pathtoimages."media/btnQueueDelete.png\" /></a>";
					}
					echo "\t\t\t<div class=\"queueitem\">\n";
					echo "\t\t\t\t<div class=\"progressbar\">\n";
					echo "\t\t\t\t\t<div class=\"progress\" style=\"width:".$percentage."%\"></div>\n";
					echo "\t\t\t\t\t<div class=\"progresslabel\"><font color='".$font."' >".$name."</font></div>\n";
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
	require_once "../config.php";

	sabQuery(urldecode($_GET['cmd']));
}

if(!empty($_GET['style']) && (($_GET['style'] == "w") || ($_GET['style'] == "s"))) {
	require_once "../config.php";

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

