<?php 
$wIndex["wSystem"] = array("name" => "System info", "type" => "ajax", "block" => "systeminfowrapper", "call" => "widgets/wSystem.php?style=w", "interval" => 60000);

function wSystem(){
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 

        // Identify the browser. Check Opera and Safari first in case of spoof. Let Google Chrome be identified as Safari. 
        if (preg_match('/opera/', $userAgent)) { 
            $name = 'Opera'; 
        } 
        elseif (preg_match('/chrome/', $userAgent)) { 
            $name = 'Chrome'; 
        } 
        elseif (preg_match('/webkit/', $userAgent)) { 
            $name = 'Safari'; 
        } 
        elseif (preg_match('/msie/', $userAgent)) { 
            $name = 'Internet Explorer'; 
        } 
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) { 
            $name = 'Firefox'; 
        } 
        else { 
            $name = 'unrecognized'; 
        } 

        // What version? 
        if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
            $version = $matches[1]; 
        } 
        else { 
            $version = 'unknown'; 
        } 

        // Running on what platform? 
        if (preg_match('/linux/', $userAgent)) { 
            $platform = 'Linux'; 
        } 
        elseif (preg_match('/macintosh|mac os x/', $userAgent)) { 
            $platform = 'Mac OS'; 
        } 
        elseif (preg_match('/windows|win32/', $userAgent)) { 
            $platform = 'Windows'; 
        } 
        else { 
            $platform = 'Unrecognized'; 
        } 

/*
        return array( 
            'name'      => $name, 
            'version'   => $version, 
            'platform'  => $platform, 
            'userAgent' => $userAgent 
        ); 
*/
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

		global $xbmcjsonservice;
		//$xbmcjsonservice = 'localhost:8080';
		try {
		    $rpc = new XBMC_RPC_HTTPClient(str_replace('/jsonrpc', '' , str_replace("http://","", $xbmcjsonservice)));
		} catch (XBMC_RPC_ConnectionException $e) {
		    die($e->getMessage());
		}
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
