<?php 
$wIndex["wSystem"] = array("name" => "System info", "type" => "ajax", "block" => "systeminfowrapper", "call" => "widgets/wSystem.php?style=w", "interval" => 10000);

function wSystem(){
  echo '<!-- START System Widget -->';
	echo '<p style="float:right; font-size: 7px;" onclick="systeminfowrapper_interval = window.setInterval(ajaxPageLoad(\'widgets/wSystem.php?style=w\', \'systeminfowrapper\'), 10000);" />RELOAD</p>';
  echo '<div onmouseover="window.clearInterval(systeminfowrapper_interval);">'; 
  $userAgent = $_SERVER['HTTP_USER_AGENT'];

	// Safari useragent preg
	if(preg_match('/U;\s(.*);\s.*Version\/(.*)\s(.*)\//i', $userAgent, $match)){
                $name = $match[3];
                $version = $match[2];
                $platform = $match[1];
        }
	// Firefox, Chrome, etc. useragent preg
	else if(preg_match('/(windows|macintosh|linux).*\s(.*)\/(.*).*(firefox|safari)\/(.*)/i', $userAgent, $match)){
		// If Chrome is found use its name and version instead of Safari
		if($match[2] == "Chrome"){
			$name = $match[2];
			$version = $match[3];
		}
		else{
			$name = $match[4];
			$version = $match[5];
		}
		$platform = $match[1];
	}
	// Internet Explorer useragent preg
	else if(preg_match('/compatible;\s(.*)\s(.*);\s(.*);\strident/i', $userAgent, $match)){
		// Change MSIE to Internet Explorer
		if(trim($match[1]) == "MSIE"){
			$name = "Internet Explorer";
		}
		else{
			$name = $match[1];
		}
		$version = $match[2];
		$platform = $match[3];
	}
	// UnKnown, need string submitted for preg adaption or creation
	else{
		$name = "Unknown";
		$version = "N/A";
		$platform = "Unknown";
	}
/*
        return array( 
            'name'      => $name, 
            'version'   => $version, 
            'platform'  => $platform, 
            'userAgent' => $userAgent 
        ); 
*/
    	echo '<!-- Start Server INFO -->';
    	echo '<h1> System Info <img src="media/arrow.png" onclick="$(\'#system\').toggle();" /></h1>';
    	echo '<div id="system" style="height: 100px; overflow-y: auto; overflow-x: hidden;">';
    	echo "<p>Browser: $name $version</p>";
    	echo "<p>OS: $platform</p>";
    	echo "<p>Server Address: ".$_SERVER['SERVER_ADDR']."</p>";
    	echo "<p>Server name: ".$_SERVER['SERVER_NAME']."</p>";
    	echo "<p>Server software: ".$_SERVER['SERVER_SOFTWARE']."</p>";
    	echo "<p>Server protocol: ".$_SERVER['SERVER_PROTOCOL']."</p>";
    	echo "<p>Request time: ".date('l, F j, Y g:i a', $_SERVER['REQUEST_TIME'])."</p>";
    	echo "<p>HTTP Referrer: ".$_SERVER['HTTP_REFERER']."</p>";
    	echo "<p>Remote address: ".$_SERVER['REMOTE_ADDR']."</p>";
    	echo "<p>Remote host: ".$_SERVER['REMOTE_HOST']."</p>";
    	echo "<p>Remote port: ".$_SERVER['REMOTE_PORT']."</p>";
    	echo "<p>Server port: ".$_SERVER['SERVER_PORT']."</p>";
    	echo "<p>Request URI: ".$_SERVER['REQUEST_URI']."</p>";
		  echo '</div>';
		  echo '<!-- END Server INFO -->';

		global $xbmcjsonservice;
		//$xbmcjsonservice = 'localhost:8080';
		try {
		    $rpc = new XBMC_RPC_HTTPClient(str_replace('/jsonrpc', '' , str_replace("http://","", $xbmcjsonservice)));
		} catch (XBMC_RPC_ConnectionException $e) {
		    die();
		}
		echo '<!-- START XBMC General info-->';
		echo '<h1>XBMC Info <img src="media/arrow.png" onclick="$(\'#libxbmc\').toggle();" /></h1>';
		echo '<div id="libxbmc">';
		try {
		    $response = $rpc->VideoLibrary->GetMovies();
   			$params = $rpc->isLegacy() ? $response['end'] : $response['limits']['total'];
			echo '<p> Total Movies: '.$params.'</p>';
		} catch (XBMC_RPC_Exception $e) {
		    die($e->getMessage());
		}

		try {
		    $response = $rpc->VideoLibrary->GetTVShows();
   			$params = $rpc->isLegacy() ? $response['end'] : $response['limits']['total'];
			echo '<p> Total TV Shows: '.$params.'</p>';
		} catch (XBMC_RPC_Exception $e) {
		    die($e->getMessage());
		}
		try {
		    $response = $rpc->JSONRPC->Version();
			echo '<p> JSON RPC Version: '.$response['version'].'</p>';
		} catch (XBMC_RPC_Exception $e) {
		    die($e->getMessage());
		}
		try {
		    $response = $rpc->Player->GetActivePlayers();
		    foreach($response as $title=>$status){
		    	if($status){
		    		echo ucwords($title).' is active';
		    	}
		    }
		} catch (XBMC_RPC_Exception $e) {
		    die($e->getMessage());
		}
		try {
		    $response = $rpc->Files->GetSources(array("media"=>"video"));
		    if(!empty($response['shares'])){
		   		foreach($response['shares'] as $item){
		    		echo '<p>'.$item['label'].' path: '.$item['file'].'</p>';
		    	}
		    }
		} catch (XBMC_RPC_Exception $e) {
		    die($e->getMessage());
		}
		//echo '<pre>';print_r($response);echo '</pre>';
		echo '</div>';
		echo '<!-- END XBMC General info -->';

  	echo '<!-- Start XBMC System info -->';
		echo '<h1>XBMC System Info <img src="media/arrow.png" onclick="$(\'#systemxbmc\').toggle();" /></h1>';
		echo '<div id="systemxbmc" style="height: 100px; overflow: auto;">';
		try {
			$legacy = array( 'System.Time', 'System.CPUTemperature','System.GPUTemperature','System.FanSpeed', 'System.BuildVersion', 	'System.BuildDate', 'System.FPS', 'System.HddTemperature','System.ProfileName', 'System.Language', 'System.Bios', 'System.VideoEncoderInfo', 'System.ScreenResolution', 'System.AvCablepackInfo', 'System.CpuFrequency', 'System.TotalUptime', 'System.Uptime', 'System.KernelVersion', 'Weather.Temperature', 'Weather.Location', 'Weather.Conditions', 'Network.IPAddress', 'Network.MacAddress', 'Network.IsDHCP', 'Network.LinkState', 'Network.SubnetAddress', 'Network.GatewayAddress', 'Network.DHCPAddress', 'Network.DNS1Address', 'Network.DNS2Address', 'Skin.CurrentTheme', 'System.FreeMemory');

			$nonLegacy = array('labels' => array( 'System.Time', 'System.CPUTemperature','System.GPUTemperature','System.FanSpeed', 'System.BuildVersion', 	'System.BuildDate', 'System.FPS', 'System.HddTemperature','System.ProfileName', 'System.Language', 'System.Bios', 'System.VideoEncoderInfo', 'System.ScreenResolution', 'System.AvCablepackInfo', 'System.CpuFrequency', 'System.TotalUptime', 'System.Uptime', 'System.KernelVersion', 'Weather.Temperature', 'Weather.Location', 'Weather.Conditions', 'Network.IPAddress', 'Network.MacAddress', 'Network.IsDHCP', 'Network.LinkState', 'Network.SubnetAddress', 'Network.GatewayAddress', 'Network.DHCPAddress', 'Network.DNS1Address', 'Network.DNS2Address', 'Skin.CurrentTheme', 'System.FreeMemory'));
			$params = $rpc->isLegacy() ? $legacy : $nonLegacy ;
			$response = $rpc->System->GetInfoLabels($params);
			if(!empty($response)){
				foreach($response as $key=>$value){
					if(!empty($value)){
						echo '<p>'.$key.': '.$value.'</p>';
					}
				}
			}
		} catch (XBMC_RPC_Exception $e) {
		    die($e->getMessage());
		}
		echo '</div>';
	 	echo '<!-- END XBMC System info -->';
		echo '</div><!-- END System Widget-->';
}
if(!empty($_GET['style']) && ($_GET['style'] == "w")) {
	require_once "../config.php";
	require_once '../XBMC-Class/rpc/HTTPClient.php';
	if($_GET['style'] == "w") {
?>
<html>
	<head>
		<title>Media Front Page - System Info</title>
		<link rel='stylesheet' type='text/css' href='css/front.css'>
	</head>
	<body>
<?php
		wSystem();
?>
	</body>
</html>
<?php
	} else {
		wSystem();
	}
}
?>