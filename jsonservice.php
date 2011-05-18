<?php
require_once "config.php";
require_once "functions.php";
require_once "layouts/layout-config.php";

function error_array($code, $message) {
	return array ( "error" => array ( "code" => $code, "message" => $message));
}

$jsonRequest = urldecode(file_get_contents("php://input"));

$arrRequest = json_decode($jsonRequest, true);
if(!empty($DEBUG) && $DEBUG && !empty($arrRequest['jsonrpc']) && ($arrRequest['jsonrpc'] == "2.0") && !empty($xbmcjsonserviceoverride)) {
	// Use XBMC test harness
	if(!empty($arrRequest['method']) && file_exists($arrRequest['method'])) {
		$response = file_get_contents($arrRequest['method']);
	} else {
		//json rpc call procedure
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $xbmcjsonserviceoverride);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
		$response = curl_exec($ch);
		curl_close($ch);
	}
	echo $response;
} else {
	if(!empty($arrRequest)) {
		switch ($arrRequest["method"]) {
			case "SaveLayout":
				$arrResult = save_layout($arrRequest);
				break;
			case "GetWidgets":
				$arrResult = get_widgets($arrRequest);
				break;
			case "XBMCPassthough":
				$arrResult = xbmc_passthough($arrRequest);
				break;
			default:
				$arrResult = error_array(-32601, "Method not found.");
		}
	} else {
		$arrResult = error_array(-32700, "Parse error.");
	}
	echo json_encode($arrResult);
}

function save_layout($arrRequest) {
	global $layout;
	if(!empty($arrRequest["params"]) && is_array($arrRequest["params"])) {
		$layoutfile = "layouts/layout-".$layout.".php";
		if(is_writable($layoutfile)) {
			$layout_code_string .= "<?php\n".'$arrLayout = '.return_array_code($arrRequest["params"]).";\n?>\n";
			
			if ($handle = fopen($layoutfile, 'w')) {
				if(fwrite($handle, $layout_code_string)) {
					$arrResult = array ( "result" => array ( "success" => true, "message" => "Layout file ($layoutfile) saved." ) );
					fclose($handle);
				} else {
					$arrResult = error_array(-32502, "Problem writing to file ($layoutfile).");
				}
			} else {
				$arrResult = error_array(-32501, "Problem opening file ($layoutfile).");
			}
		} else {
			$arrResult = error_array(-32500, "File not writeable. ($layoutfile)");
		}
	} else {
		$arrResult = error_array(-32602, "Invalid parameters. ($layoutfile)");
	}
	return $arrResult;
}

function get_widgets($arrRequest) {
	if(!empty($arrRequest["params"]) && is_array($arrRequest["params"])) {
		$wIndex = array();

		foreach (glob("widgets/*.php") as $filename) {
			include_once $filename;
		}
		
		$arrResult = array ( "result" => array ( "widgets" => $wIndex ) );
	} else {
		$arrResult = error_array(-32602, "Invalid parameters.");
	}
	return $arrResult;
}

function xbmc_passthough($arrRequest) {
	if(!empty($arrRequest["params"]) && is_array($arrRequest["params"])) {
		$request = json_encode($arrRequest["params"]);
		$arrResult = jsoncall($request);
		if(empty($arrResult) || !is_array($arrResult)) {
			$arrResult = error_array(-32503, "Invalid response.");
		}
	} else {
		$arrResult = error_array(-32602, "Invalid parameters.");
	}
	return $arrResult;
}
?>