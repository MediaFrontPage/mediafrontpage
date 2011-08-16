<html>
	<body>
		<div id="JDOWNLOADER" class="panel">
              <br />
              <br />
              <a href="http://jdownloader.org/home/index?s=lng_en" target="_blank" title="Visit jDownloader"><h3>jDownloader</h3></a>
							<table>
								<tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find jDownloader.</p></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader IP:</p></td>
									<td align="left"><input name="IP" title="Insert your jDownloader IP Address" size="20" value="<?php echo $config->get('IP','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader Web Port:</p></td>
				          <td align="left"><input name="WEB_PORT" title="Insert your jDownloader Web Port" size="4" value="<?php echo $config->get('WEB_PORT','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader Remote Port:</p></td>
									<td align="left"><input name="REMOTE_PORT" title="Insert your jDownloader Remote Port" size="4" value="<?php echo $config->get('REMOTE_PORT','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>jDownloader Username:</p></td>
				          <td align="left"><input name="USERNAME" title="Insert your jDownloader Username" size="20" value="<?php echo $config->get('USERNAME','JDOWNLOADER')?>" /></td>
								</tr>
								<tr>
				          <td align="right"><p>jDownloader Password:</p></td>
				          <td align="left"><input name="PASSWORD" title="Insert your jDownloader Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','JDOWNLOADER')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('JDOWNLOADER');" />
            </div>
	</body>
</html>
