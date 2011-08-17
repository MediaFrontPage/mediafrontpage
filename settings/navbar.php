<html>
	<body>
		<div id="NAVBAR" class="panel">
              <h3>Nav Links</h3>
							<p>Here are the Navigation Links you see at the top of your page. You can add or remove them depending on the programs and URL's you use.</p>
							<table id='table_nav'>
								<tr>
									<td>title</td>
									<td>URL</td>
								</tr>
								<?php
								  $x = $config->get('NAVBAR');
									foreach ($x as $title=>$url){
									  echo "<tr>
										 			  <td><input size='13' title='This will be the name in the Navigation Bar' name='title' value='".str_ireplace('_', ' ', $title)."'/></td>
													  <td><input name='VALUE' title='This will be the URL for ".str_ireplace('_', ' ', $title)."'  size='30' value='$url'/></td>
											    </tr>";
								  }
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('nav', 13, 30);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('nav');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save & Reload" onclick="updateAlternative('NAVBAR');setTimeout(top.frames['nav'].location.reload(), 5000);" />
            </div>
	</body>
</html>
