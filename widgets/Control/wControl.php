<?php

$widget_init = array(	
			'Id' 			=> "wControl",
			'Child'			=> "false",
			'Type' 			=> "inline",
			'Title' 		=> "Control",
			'Function' 		=> "widgetControl(\"widgets/Control/wControl.php\", true);",
			'HeaderFunction'=> "widgetControlHeader();",
			'Stylesheet' 	=> "",
			'Section' 		=> 1,
			'Position' 		=> 3,
			'Parts'			=> "",
			'Block' 		=> "",
			'Call'			=> "",
			'Loader'		=> "",
			'Interval'		=> "",
			'Script'		=> "",
		    );

$settings_init['wControl'] = array('shortcuts' =>	array(	
											'label'	=>	'Shortcuts',
											'value' =>	array(	
													'shortcut1' =>	array(	
																'label' 	=> 'Shutdown XBMC',
																'type'	 	=> 'cmd',
																'action'	=> 'shutdown'),
													'shortcut2' =>	array(	
																'label' 	=> 'Update XBMC Video Library',
																'type'	 	=> 'cmd',
																'action'	=> 'vidscan'),
													'shortcut3' =>	array(	
																'label' 	=> 'Clean XBMC Video Library',
																'type'	 	=> 'xbmcsend',
																'action'	=> 'CleanLibrary(video)'),
													'shortcut4' =>	array(	
																'label' 	=> 'Update XBMC Audio Library',
																'type'	 	=> 'json',
																'action'	=> '{"jsonrpc": "2.0", "method": "AudioLibrary.ScanForContent", "id" : 1 }'),
													'shortcut5' =>	array(	
																'label' 	=> 'Google',
																'type'	 	=> 'link',
																'action'	=> 'http://www.google.com')
											)
								)
					);


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
	global $settings;
	if(empty($_GET["style"])) {
		$style = "w";
	} else {
		$style = $_GET["style"];
	}

	echo "<ul class=\"widget-list\">\n";
	$alt = false;

	foreach ($settings['shortcuts'] as $shortcut) {
		if($shortcut['type'] !== 'link') {

			if(!empty($shortcut['type'])) {
				switch ($shortcut['type']) {
					case "cmd":
					case "json":
						$href = $baseurl."?w=wControl&style=".$style."&".$shortcut['type']."=".urlencode($shortcut['action']);
						break;
					case "xbmcsend":
						$href = $baseurl."?w=wControl&style=".$style."&xbmcsend=".urlencode($shortcut["action"]).(!empty($shortcut["host"]) ? "&host=".$shortcut["host"] : "").(!empty($shortcut["port"]) ? "&port=".$shortcut["port"] : "").(!empty($mfpapikey) ? "&apikey=".$mfpapikey : "");
						break;
					case "shell" :
						$href = $baseurl."?w=wControl&style=".$style."&shell=".urlencode($shortcut["action"]).(!empty($mfpapikey) ? "&apikey=".$mfpapikey : "");
						break;
				}
			}
			if($style == "m") {
				echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" href=\"".$href."\">".$shortcut['label']."</a><br/></li>\n";
			} elseif($style == "w") {
				echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" onclick=\"cmdControl('".$href."');\" href=\"#\">".$shortcut['label']."</a><br/></li>\n";
			}
		} else {
			echo "\t<li".(($alt) ? " class=\"alt\"" : "")."><a class=\"shortcut\" href=\"".$shortcut['action']."\">".$shortcut['label']."</a><br/></li>\n";
		}
		$alt = !$alt;
	}
	echo "</ul>\n";
}
function widgetControl($baseurl = "widgets/Control/wControl.php", $forcemenu = false) {
	global $settings;
	$mfpsecured = $settings['mfpsecured'];
	//$mfpapikey = $settings['mfpapikey'];

	$json = '{"status":true}';
	$errmsg = '';
	if(!empty($_GET["style"]) && (($_GET["style"] == "w") || ($_GET["style"] == "m"))) {
		$displayMenu = ($_GET["style"] == "m");
		if(!empty($_GET["cmd"])) {
			switch ($_GET["cmd"]) {
				case "shutdown":
					$results = jsonmethodcall("System.Shutdown");
					break;
   				case "suspend":
					$results = jsonmethodcall("System.Suspend");
					break;                  
   				case "hibernate":
					$results = jsonmethodcall("System.Hibernate");
					break;
				case "reboot":
					$results = jsonmethodcall("System.Reboot");
					break;
   				case "exit":
				case "quit":
					$results = jsonmethodcall("XBMC.Quit");
					break;                    
				case "vidscan":
					$results = jsonmethodcall("VideoLibrary.ScanForContent");
					break;
				default:
					$errmsg = "Invalid Command";
					$displayMenu = false;
			}
		} elseif(!empty($_GET["json"])) {
			$request = stripslashes(urldecode($_GET["json"]));
			$results = jsoncall($request);
		// This method will only work if MFP is on the same system as xbmc.
		} elseif(!empty($_GET["xbmcsend"])) {
			if((!empty($mfpapikey) && !empty($_GET["apikey"]) && ($_GET["apikey"] == $mfpapikey)) || $mfpsecured !== 'false') {
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
			if((!empty($mfpapikey) && !empty($_GET["apikey"]) && ($_GET["apikey"] == $mfpapikey)) || $mfpsecured !== 'false') {
				$request = stripslashes(urldecode($_GET["shell"]));
				$results = shell_exec($request);
				$json = '{"status":true, "message": "'.str_replace("\"", "\\\"", $results).'"}';
			} else {
				$errmsg = "Authorization failure";
			}
		} else {
			$displayMenu = $forcemenu;
			$errmsg = "No action.";
			$displayMenu = false;
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
	require_once "../../functions.php";
	widgetControl();
}
?>
