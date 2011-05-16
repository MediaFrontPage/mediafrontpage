<?php
$wIndex["wMessage"] = array("name" => "Message XBMC", "type" => "inline", "function" => "widgetMessage();", "headerfunction" => "widgetNotificationHeader();");

function widgetNotificationHeader(){
	echo <<< RSSHEADER
<script type="text/javascript" language="javascript">
	<!--
	function paramsMsg(){
			var dur = "10";
			var title = "MediaFrontPage";
			var extra;

			var xbmc  = document.getElementById('xbmc').value;
			var msg   = document.getElementById('keyword').value;
			if(document.getElementById('duration').value){
				dur = document.getElementById('duration').value;
			}
			if(document.getElementById('title').value){
				title = document.getElementById('title').value;
			}
			extra = "&duration="+dur+"&title="+title;
			sendMessage(xbmc, msg, extra);
	}
	
	function sendMessage(url, msg, extra) {
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.open("GET", "widgets/wMessage.php?msg="+msg+extra+"&url="+url, true);

			xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					//alert(xmlhttp.responseText);
					if(xmlhttp.responseText){
						alert('Message sent successfully');
					}
					else{
						alert('Failed sending message. ' + xmlhttp.responseText);
					}
				}
			}
			xmlhttp.send();
		}
	-->
</script>

RSSHEADER;
}
function widgetMessage() {
	require_once "config.php";
	global $xbmcimgpath,$xbmcMessages;

	echo "Send <b>Notice!</b><input type='text' style='border:0px; background:#3D3D3D; color:white' id='keyword' />to XBMC.
	<select id='xbmc'>";
	if(!empty($xbmcMessages)){
		foreach($xbmcMessages as $title => $link){
			echo "<option value='".$link."'>".$title."</option>";	
		}
	}
	else{
		echo "<option value='".substr($xbmcimgpath, 0, strlen($xbmcimgpath)-4)."'>Default</option>";
	}
	echo "</select>
	<input type='button' value='Send' onclick='paramsMsg();'>
	<p><input type='button' value='EXTRAS' onclick=\"$('#extras').toggle();\"></p>
	<div id='extras' style='display:none;'>
		<p>Title: <input type='text' style='border:0px; background:#3D3D3D; color:white' id='title' /></p>
		<p>Duration: <input type='text' style='border:0px; background:#3D3D3D; color:white' id='duration' /></p>
	</div>";
}
if(!empty($_GET['msg']) && !empty($_GET['url']))
{
/*
	echo "<p>".$_GET['msg']."</p>";
	echo "<p>".$_GET['url']."</p>";
*/
	$url = $_GET['url']."xbmcCmds/xbmcHttp?command=ExecBuiltIn(Notification(".urlencode($_GET['title']).",".urlencode($_GET['msg']).",".urlencode($_GET['duration'])."000))";
		
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_URL, $url);

	$response = curl_exec($ch);
	curl_close($ch);
	
	if(strstr($response, 'OK')){
		echo true;
	}
	else{
		echo $response;
	}
}
?>