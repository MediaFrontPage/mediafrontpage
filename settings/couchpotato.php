<html>
	<body>
		<div id="COUCHPOTATO" class="panel">
              <br />
              <br />
              <a href="http://www.couchpotatoapp.com" target="_blank" title="Visit CouchPotato"><h3>Couch Potato</h3></a>
							<table>
				        <tr>
									<td colspan="2"><p>Enter the details where MediaFrontPage will find CouchPotato.</p></td>
								</tr>
								<tr>
									<td align="right"><p>Couch Potato IP:</p></td>
									<td align="left"><input name="IP" title="Insert your CouchPotato IP Address" size="20" value="<?php echo $config->get('IP','COUCHPOTATO')?>" /></td>
								</tr>
								<tr>
				          <td align="right"><p>Couch Potato Port:</p></td>
				          <td align="left"><input name="PORT" title="Insert your CouchPotato Port" size="4" value="<?php echo $config->get('PORT','COUCHPOTATO')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Couch Potato Username:</p></td>
								  <td align="left"><input name="USERNAME" title="Insert your CouchPotato Username" size="20" value="<?php echo $config->get('USERNAME','COUCHPOTATO')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>Couch Potato Password:</p></td>
									<td align="left"><input name="PASSWORD" title="Insert your CouchPotato Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','COUCHPOTATO')?>" /></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('COUCHPOTATO');" />
            </div>
	</body>
</html>
