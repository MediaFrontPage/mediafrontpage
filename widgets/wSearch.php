<?php
$wdgtSearch = array("name" => "Search Widget", "type" => "inline", "function" => "widgetSearch();");
$wIndex["wSearch"] = $wdgtSearch;

function widgetSearch() {	
	 echo <<<BODY
            <div><input type="text" value="" size="13" id="searchterm" onkeydown="if (event.keyCode == 13) document.getElementById('searchbutton').click()">  
                  <select id='provider' onchange="catDropDown(this.value);">
                    <option value="0" selected>Default</option>
                    <option value="1" >nzb.su</option>
                    <option value="2" >NZB Matrix</option>
                    <option value="3" >TMDB</option>
    			        </select>  
    			        <input type="button" id="searchbutton" value="Find" onclick="results()">
                  <input type="button" id="clearbutton" value="X" onclick="clearResults()" ondblclick="resetWidget()">
                  <select name="type" style="display:none;" id="type"></select>
           </div>
        <div id="resultstable"></div>
        <div id='extra_info'></div> 

BODY;
}

?>
		<html>
			<head>
				<link rel='stylesheet' type='text/css' href='css/front.css'>
		        <script type="text/javascript" src="widgets/searchComponents/searchWidget.js"></script>
			</head>
			<body>
				<iframe name="nothing" height="0" width="0" style="visibility:hidden;display:none"></iframe>
			</body>
		</html>