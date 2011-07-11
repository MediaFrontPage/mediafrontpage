<?php
$wdgtControl = array("name" => "Control", "type" => "inline", "function" => "widgetControl(\"widgets/wControl.php\", true);", "headerfunction" => "widgetControlHeader();");
$wIndex["wControl"] = $wdgtControl;

function widgetControlHeader() {
	echo <<< CONTROLHEADER
		<script type="text/javascript" language="javascript">
		<!--
			function cmdControl(requesturl) {
				var cmdControlRequest = new ajaxRequest();
				cmdControlRequest.open("GET", requesturl, true);
				cmdControlRequest.onreadystatechange = function() {//Call a function when the state changes.
					if(cmdControlRequest.readyState == 4 && cmdControlRequest.status == 200) {
						try {
							var returnedjson = eval("("+cmdControlRequest.responseText+")");
							if(returnedjson.status) {
								if(returnedjson.message) {
									alert(returnedjson.message);
								}
							} else {
								alert("Error returned from call to widget.\\r\\n\\r\\nError: " + returnedjson.error);
							}
						}
						catch(e) {
							alert("Problem calling Control Widget.\\r\\n\\r\\n"+cmdControlRequest.responseText);
						}
					}
				}
				cmdControlRequest.send(null);
			}
		-->
		</script>

CONTROLHEADER;
}
function widgetMenu($baseurl) {
	global $shortcut, $mfpapikey;

	if(empty($_GET["style"])) {
		$style = "w";
	} else {
		$style = $_GET["style"];
	}

	echo "<ul class=\"widget-list\">\n";
	$alt = false;
	foreach( $shortcut as $shortcutlabel => $shortcutmixed) {
		if(is_array($shortcutmixed)) {
			if(!empty($shortcutmixed["json"])) {
				$href = $baseurl."?w=wControl&style=".$style."&json=".urlencode($shortcutmixed["json"]);
			}
			if(!empty($shortcutmixed["cmd"])) {
				$href = $baseurl."?w=wControl&style=".$style."&cmd=".$shortcutmixed["cmd"];
			}
			if(!empty($shortcutmixed["xbmcsend"])) {
				$href = $baseurl."?w=wControl&style=".$style."&xbmcsend=".urlencode($shortcutmixed["xbmcsend"]).(!empty($shortcutmixed["host"]) ? "&host=".$shortcutmixed["host"] : "").(!empty($shortcutmixed["port"]) ? "&port=".$shortcutmixed["port"] : "").(!empty($mfpapikey) ? "&apikey=".$mfpapikey : "");
			}
			if(!empty($shortcutmixed["shell"])) {
				$href = $baseurl."?w=wControl&style=".$style."&shell=".urlencode($shortcutmixed["shell"]).(!empty($mfpapikey) ? "&apikey=".$mfpapikey : "");
			}
			if(!empty($shortcutmixed["url"])) {
				echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" href=\"".$shortcutmixed["url"]."\">".$shortcutlabel."</a><br/></li>\n";
				unset($style);
			}
			
			if($style == "m") {
				echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" href=\"".$href."\">".$shortcutlabel."</a><br/></li>\n";
			} elseif($style == "w") {
				echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" onclick=\"cmdControl('".$href."');\" href=\"#\">".$shortcutlabel."</a><br/></li>\n";
			}
		} else {
			echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" href=\"".$shortcutmixed."\">".$shortcutlabel."</a><br/></li>\n";
		}
		$alt = !$alt;
	}
	echo "</ul>\n";
}
function widgetControl($baseurl = "widgets/wControl.php", $forcemenu = false) {
	global $mfpsecured, $mfpapikey;

	$json = '{"status":true}';
	$errmsg = '';
	if(!empty($_GET["style"]) && (($_GET["style"] == "w") || ($_GET["style"] == "m"))) {

		$displayMenu = (($_GET["style"] == "m") || $forcemenu);
		if(!empty($_GET["cmd"])) {
			switch ($_GET["cmd"]) {
				case "shutdown":  // Shutdown
					$results = jsonmethodcall("System.Shutdown");
					break;
   				case "suspend":  // Suspend
					$results = jsonmethodcall("System.Suspend");
					break;                  
   				case "hibernate":  // Hibernate
					$results = jsonmethodcall("System.Hibernate");
					break;
				case "reboot":    // Reboot
					$results = jsonmethodcall("System.Reboot");
					break;
   				case "exit":  // Exit
				case "quit":
					$results = jsonmethodcall("XBMC.Quit");
					break;                    
				case "vidscan":  // Video Library ScanForContent
					$results = jsonmethodcall("VideoLibrary.ScanForContent");
					break;
				default:
					$errmsg = "Invalid Command";
					$displayMenu = ($_GET["style"] != "m");
			}
		} elseif(!empty($_GET["json"])) {
			$request = stripslashes(urldecode($_GET["json"]));
			$results = jsoncall($request);
		// This method will only work if MFP is on the same system as xbmc.
		} elseif(!empty($_GET["xbmcsend"])) {
			if((!empty($mfpapikey) && !empty($_GET["apikey"]) && ($_GET["apikey"] == $mfpapikey)) || $mfpsecured) {
				$request = "xbmc-send";
				$request .= (!empty($_GET["host"]) ? " --host=".$_GET["host"] : "");
				$request .= (!empty($_GET["port"]) ? " --port=".$_GET["port"] : "");
				$request .= " --action=\"".stripslashes(urldecode($_GET["xbmcsend"]))."\"";
				$results = shell_exec($request);
				$json = '{"status":true, "message": "'.str_replace("\"", "\\\"", $results).'"}';
			} else {
				$errmsg = "Authorization failure";
			}
		} elseif(!empty($_GET["shell"])) {
			if((!empty($mfpapikey) && !empty($_GET["apikey"]) && ($_GET["apikey"] == $mfpapikey)) || $mfpsecured) {
				$request = stripslashes(urldecode($_GET["shell"]));
				$results = shell_exec($request);
				$json = '{"status":true, "message": "'.str_replace("\"", "\\\"", $results).'"}';
			} else {
				$errmsg = "Authorization failure";
			}
		} else {
			$displayMenu = $forcemenu;
			$errmsg = "No action.";
		}
	} else {
		$displayMenu = $forcemenu;
	}

	if($displayMenu) {
		widgetMenu($baseurl);
	} else {
		if(!empty($_GET["style"]) && ($_GET["style"] == "w")) {
			if(!empty($errmsg)) {
				$json = '{"status":false, "error": "'.$errmsg.'"}';
			}
			echo str_replace("\n", "\\n", $json);
		}
	}
}

if(!empty($_GET["style"]) && ($_GET["style"] == "w")) {
	require_once "../config.php";
	require_once "../functions.php";

	widgetControl();
}

?>
