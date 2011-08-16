<html>
	<body>
		<div id="SUBSONIC" class="panel">
              <br />
              <br />
              <a href="http://www.subsonic.org/pages/index.jsp" target="_blank" title="Visit SubSonic"><h3>SubSonic</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find SubSonic.</p></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic IP:</p></td>
									<td align="left"><input name="IP" title="Insert your SubSonic IP Address" size="20" value="<?php echo $config->get('IP','SUBSONIC')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic Port:</p></td>
									<td align="left"><input name="PORT" title="Insert your SubSonic Port" size="4" value="<?php echo $config->get('PORT','SUBSONIC')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic Username:</p></td>
									<td align="left"><input name="USERNAME" title="Insert your SubSonic Username" size="20" value="<?php echo $config->get('USERNAME','SUBSONIC')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>SubSonic Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your SubSonic Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','SUBSONIC')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onClick="updateSettings('SUBSONIC');" />
            </div>
	</body>
</html>
