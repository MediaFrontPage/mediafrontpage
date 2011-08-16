<html>
	<body>
		<div id="UTORRENT" class="panel">
              <br />
              <br />
              <a href="http://www.utorrent.com" target="_blank" title="Visit uTorrent"><h3>uTorrent</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find uTorrent.</p></td>
								</tr>
								<tr>
									<td align="right"><p>uTorrent IP:</p></td>
									<td align="left"><input name="IP" title="Insert your uTorrent IP Address" size="20" value="<?php echo $config->get('IP','UTORRENT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>uTorrent Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your uTorrent Port" size="4" value="<?php echo $config->get('PORT','UTORRENT')?>" /></td>
								</tr>
								<tr>
				               		<td align="right"><p>uTorrent Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your uTorrent Username" size="20" value="<?php echo $config->get('USERNAME','UTORRENT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>uTorrent Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your uTorrent Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','UTORRENT')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('UTORRENT');" />
            </div>
	</body>
</html>
