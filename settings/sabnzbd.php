<html>
	<body>
		<div id="SABNZBD" class="panel">
              <br />
              <br />
              <a href="http://sabnzbd.org" title="Visit SabNZBd+" target="_blank"><h3>Sabnzbd+</h3></a>
							<table>
				        <tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find SabNZBd+.</p></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ IP:</p></td>
									<td align="left"><input name="IP" title="Insert your SabNZBd+ IP Address" size="20" value="<?php echo $config->get('IP','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your SabNZBd+ Port" size="4" value="<?php echo $config->get('PORT','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your SabNZBd+ Username" size="20" value="<?php echo $config->get('USERNAME','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your SabNZBd+ Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','SABNZBD')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SabNZBd+ API:</p></td>
									<td align="left"><input name="API" title="Insert your SabNZBd+ API" type="password" size="40" value="<?php echo $config->get('API','SABNZBD')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SABNZBD');" />
            </div>
	</body>
</html>
