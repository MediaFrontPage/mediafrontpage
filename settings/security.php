<html>
	<body>
		<div id="SECURITY" class="panel">
              <h3>Security</h3>
									<p>Worried someone could mess up your settings or interfere with your MediaFrontPage?</p>
							<table>
								<tr>
									<td align="right"><p>MediaFrontPage Authentication:</p></td>
									<td align="left"><p><input type="checkbox" name="PASSWORD_PROTECTED" <?php echo ($config->get('PASSWORD_PROTECTED','SECURITY') == "true")?'CHECKED':'';?> /></p></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage Username:</p></td>
									<td align="left"><input name="USERNAME" size="20" Title="Insert the desired MediaFrontPage Username" value="<?php echo $config->get('USERNAME','SECURITY')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage Password:</p></td>
									<td align="left"><input name="PASSWORD" size="20" Title="Insert the desired MediaFrontPage Password" type="password" value="<?php echo $config->get('PASSWORD','SECURITY')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage Secured with API:</p></td>
									<td align="left"><p><input type="checkbox" name="mfpsecured" <?php echo ($config->get('mfpsecured','SECURITY') == "true")?'CHECKED':''; ?>></p></td>
								</tr>
								<tr>
									<td align="right"><p>MediaFrontPage API Key:</p></td>
									<td align="left"><input name="mfpapikey" Title="Type an API for MediaFrontPage - You can make this up" type="password" size="20" value="<?php echo $config->get('mfpapikey','SECURITY')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SECURITY');" />
            </div>
	</body>
</html>
