<html>
	<body>
		<div id="HEADPHONES" class="panel">
              <br />
              <br />
              <h3>HeadPhones</h3>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find HeadPhones.</p></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones IP:</p></td>
									<td align="left"><input name="IP" title="Insert your HeadPhones IP Address"  size="20" value="<?php echo $config->get('IP','HEADPHONES')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your HeadPhones Port"  size="4" value="<?php echo $config->get('PORT','HEADPHONES')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your HeadPhones Username"  size="20" value="<?php echo $config->get('USERNAME','HEADPHONES')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>HeadPhones Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your HeadPhones Password"  size="20" type="password" value="<?php echo $config->get('PASSWORD','HEADPHONES')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onClick="updateSettings('HEADPHONES');" />
            </div>
	</body>
</html>
