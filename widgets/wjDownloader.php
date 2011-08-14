<?php
$wIndex["wjDownloader"]  = array("name" => "jDownloader", "type" => "ajax", "block" => "jdownloaderwrapper", "headerfunction" => "widgetjDHeader();", "call" => "widgets/wjDownloader.php?style=w", "interval" => 10000);

function widgetjDHeader() {
	echo <<< JDHEADER
		<script type="text/javascript" language="javascript">
		<!--
		function toggleSubItem(name)
		{
			var array = document.getElementsByName(name);

				for( var c = 0; c < array.length; c++){
					if (array[c].style.display == 'none'){
						array[c].style.display = 'table-row';
					}
					else{
						array[c].style.display = 'none';
					}
				}		}
		-->
		</script>
JDHEADER;
}

function widgetjDownloader(){

	try{
		$speed   = getInfoDownloader("get/speed");
		$status  = getInfoDownloader("get/downloadstatus");
		$speedLimit = getInfoDownloader("get/speedlimit");
		//echo $speed.'<br>'.$status.'<br>'.$speedLimit;
		$action="";

		switch($status){
		case 'RUNNING':
			$status="Downloading @".$speed." kB/s";
			$action = "stop";
			break;
		case 'STOPPING':
			$status="Stopping";
			break;
		case 'NOT_RUNNING':
			$status="Stopped";
			$action = "start";
			break;
		}

		echo "<a href='#' onclick=\"$.get('widgets/wjDownloader.php?action=".$action."', function(data) { alert(data);});\">".$status."</a>";

		$dlList = getInfoDownloader("get/downloads/alllist");		
		if($dlList){
			$doc = new DOMDocument();
			$doc->loadXML($dlList);
		}
		else{
			echo "ERROR! $dlList";
			return false;
		}
		
		if(is_object($doc->getElementsByTagName('jdownloader')))
		{
			if(is_object($doc->getElementsByTagName('package')))
			{
				echo "<table border=\"0\" width='100%' style='table-layout:fixed;' cellspacing='0' cellpadding='0'>";
				echo "<tr>";
				echo "<th></th>";
				echo "<th style='width:95%;'></th>";
				echo "</tr>";

				$package = $doc->getElementsByTagName('package');
				foreach($package as $item){
					$progress  = $item->getAttribute('package_linksinprogress');
					$eta   = $item->getAttribute('package_ETA');
					$total   = $item->getAttribute('package_linkstotal');
					$loaded  = $item->getAttribute('package_loaded');
					$name   = $item->getAttribute('package_name');
					$percent  = $item->getAttribute('package_percent');
					$size   = $item->getAttribute('package_size');
					$speed   = $item->getAttribute('package_speed');
					$todo   = $item->getAttribute('package_todo');

					//echo "$name | $eta | $progress | $total | $loaded | $percent | $size | $speed | $todo";

					$colour = "green";
					if(intval($progress) == 0){
						$colour = "red";
					}
					$popup = "<p>Name: $name</p>";
					$popup .= "<p>ETA: $eta</p>";
					$popup .= "<p>Links: $progress of $total</p>";
					$popup .= "<p>Size: $size</p>";
					$popup .= "<p>Name: $name</p>";

					$pack = $name;

					echo "<tr>";
					echo "<td><img width='17px' src='media/btnAddToPlaylist.png' style:'vertical-align:middle;' onClick=\"toggleSubItem('".$pack."');\" /></td>";
					echo "<td><div class=\"queueitem\">";
					echo "\t\t\t\t<div class=\"progressbar\">";
					echo "\t\t\t\t\t<div class=\"progress\" style=\"width:".$percent."\"></div>";
					echo "\t\t\t\t\t<div class=\"progresslabel\" style='text-align: left;'><font color=".$colour." onMouseOver=\"ShowPopupBox('".$popup."');\" onMouseOut=\"HidePopupBox();\">$name $loaded of $size @ $speed</font></div>";
					echo "\t\t\t\t</div><!-- .progressbar -->";
					echo "\t\t\t</div><!-- .queueitem -->";
					echo "</td>";
					echo "</tr>";

					$file = $item->getElementsByTagName('file');
					foreach($file as $sub){
						$hoster  = $sub->getAttribute('file_hoster');
						$subname = $sub->getAttribute('file_name');
						$package = $sub->getAttribute('file_package');
						$peercent = $sub->getAttribute('file_percent');
						$speed  = $sub->getAttribute('file_speed');
						$status  = $sub->getAttribute('file_status');

						$colour = "green";
						if(intval($speed) == 0){
							$colour = "red";
						}


						echo "<tr name='".$pack."' style='display:none;'>";
						echo "<td></td>";
						echo "<td><div class=\"queueitem\">";
						echo "\t\t\t\t<div class=\"progressbar\">";
						echo "\t\t\t\t\t<div class=\"progress\" style=\"width:".$percent."\"></div>";
						echo "\t\t\t\t\t<div class=\"progresslabel\" style='text-align: center;'><font color=".$colour.">".$subname." $loaded of $size @ $speed</font></div>";
						echo "\t\t\t\t</div><!-- .progressbar -->";
						echo "\t\t\t</div><!-- .queueitem -->";
						echo "</td>";
						echo "</tr>";

					}
					echo "</div>";
				}
				echo "</table>";
			}
		}
	}
	catch(Exception $e){
		echo $e;
	}
}
function getInfoDownloader($param = ""){
	global $jd_url;

	if(!empty($param)){
		$url = $jd_url.$param;
	}
	else{
		echo false;
		return false;
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	$response = curl_exec($ch);
	curl_close($ch);

	return $response;
}

if(!empty($_GET['action'])){
	require_once "../config.php";
	if($_GET['action'] == "start"){
		$x = getInfoDownloader("action/start");
		echo "$x";
	}
	elseif($_GET['action'] == "stop"){
		$x = getInfoDownloader("action/stop");
		echo "$x";
	}
}

if(!empty($_GET['style']) && ($_GET['style'] == "w")) {
	require_once "../config.php";
	if($_GET['style'] == "w") {
?>
<html>
	<head>
		<title>Media Front Page - jDownloader</title>
		<link rel='stylesheet' type='text/css' href='css/front.css'>
	</head>
	<body>
<?php
		widgetjDownloader();
?>
	</body>
</html>
<?php
	} else {
		widgetjDownloader();
	}
}
?>
