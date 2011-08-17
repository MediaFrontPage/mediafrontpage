<html>
	<body>
		<div id="TRANSMISSION" class="panel">
              <br />
              <br />
              <a href="http://www.transmissionbt.com" target="_blank" title="Visit Transmission"><h3>Transmission</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find Transmission.</p></td>
								</tr>
								<tr>
									<td align="right"><p>Transmission IP:</p></td>
									<td align="left"><input name="IP" title="Insert your Transmission IP Address" size="20" value="<?php echo $config->get('IP','TRANSMISSION')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Transmission Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your Transmission Port" size="4" value="<?php echo $config->get('PORT','TRANSMISSION')?>" /></td>
								</tr>
								<tr>
				                	<td align="right"><p>Transmission Username:</p></td>
				                    <td align="left"><input name="USERNAME" title="Insert your Transmission Username" size="20" value="<?php echo $config->get('USERNAME','TRANSMISSION')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Transmission Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your Transmission Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','TRANSMISSION')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('TRANSMISSION');" />
            </div>
	</body>
</html>
