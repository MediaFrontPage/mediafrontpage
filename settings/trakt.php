<html>
	<body>
		<div id="TRAKT" class="panel">
              <h3>Trakt.tv</h3>
							<table>
								<tr>
									<td colspan="2"><p>trakt.tv info</p></td>
								</tr>
								<tr>
									<td align="right"><p>trakt Username:</p></td>
									<td align="left"><input name="TRAKT_USERNAME" title="Insert your trakt.tv Username" size="20" value="<?php echo $config->get('TRAKT_USERNAME','TRAKT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>trakt Password:</p></td>
									<td align="left"><input name="TRAKT_PASSWORD" title="Insert your trakt.tv Password" type="password" size="20" value="<?php echo $config->get('TRAKT_PASSWORD','TRAKT')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>trakt API:</p></td>
								  <td align="left"><input name="TRAKT_API" type="password" title="Insert your trakt.tv API"  ize="40" value="<?php echo $config->get('TRAKT_API','TRAKT')?>" /><a href="http://trakt.tv/settings/api" target="_blank"><img src="../media/question.png" height="20px"></a></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('TRAKT');" />
            </div>
	</body>
</html>
