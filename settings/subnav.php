<html>
	<body>
		<div id="SUBNAV" class="panel">
              <h3>SubNav Links</h3>
              <p style="width: 500px;" align="justify">Here are the Sub Navigation Links you see at the bottom of your page. You can add or remove any site you like. Simply give it a Title and a URL and it will show up on the Footer at the bottom of MediaFrontPage.</p>
							<table id='table_subnav'>
							  <tr>
									<td>Title</td>
									<td>URL</td>
								</tr>
								<?php
									$x = $config->get('SUBNAV');
									foreach ($x as $title=>$url){
										echo "<tr>
												    <td><input size='13' Title='Subnavigation label' name='TITLE' value='".str_ireplace('_', ' ', $title)."'/></td>
												    <td><input name='VALUE' Title='Subnavigation URL' size='30' value='$url'/></td>
											    </tr>";
										 }
								?>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('subnav', 13, 30);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('subnav');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save & Reload" onclick="updateAlternative('SUBNAV');setTimeout(top.frames['nav'].location.reload(), 5000);" />
            </div>
	</body>
</html>
