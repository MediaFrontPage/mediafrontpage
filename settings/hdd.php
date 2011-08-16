<html>
	<body>
		<div id="HDD" class="panel">
              <h3>Hard Drives</h3>
							<p style="width: 500px;" align="justify">It does not matter what system it is running on, but you need to know where your media is stored on your HDD's.</p>
							<table id='table_hdd'>
								<tr>
									<td>Title</td>
									<td>Path</td>
								</tr>
								<?php
									$x = $config->get('HDD');
									foreach ($x as $title=>$url){
										echo "<tr>
											<td><input size='20' Title='Hard Drive name (the name in MFP, not necessarily the actual name)' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/></td>
											<td><input name ='VALUE' Title='Direct path to Hard Drive' size='20' value='$url'/></td>
											</tr>";
										}
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('hdd', 20, 20);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('hdd');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('HDD');" />
            </div>
	</body>
</html>
