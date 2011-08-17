<html>
	<body>
		<div id="MESSAGE" class="panel">
              <h3>XBMC Instances for Message Widget</h3>
							<p align="justify" style="width: 500px;">Do you have multiple instance of XBMC with different IP Addresses/Port Numbers. IE - The Kids room or Kitchen? If so, the Message Widget can send customized messages to these machine. IE - "Turn it off" or "Cup of Coffee please".</p>
							<table id="table_msg">
								<tr>
									<td>Title</td>
									<td>URL</td>
								</tr>
								<?php
									$x = $config->get('MESSAGE');
									foreach ($x as $title=>$url){
										echo "<tr>
											<td><input size='10' Title='XBMC Name' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/></td>
											<td><input size='40' Title='XBMC IP Address & Port' name='VALUE' value='$url'/></td>
											</tr>";
										}
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('msg', 10, 40);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('msg');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('MESSAGE');" />
            </div>
	</body>
</html>
