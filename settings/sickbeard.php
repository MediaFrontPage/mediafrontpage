<html>
	<body>
		<div id="SICKBEARD" class="panel">
              <br />
              <br />
              <a href="http://www.sickbeard.com/" title="Go to SickBeard's home page"><h3>Sickbeard</h3></a>
                <table>
                  <tr>
                    <td colspan="2"><p>Enter the details where MediaFrontPage will find SickBeard.</p></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard IP:</p></td>
                    <td align="left"><input name="IP" title="Insert your SickBeard IP Address" size="20" value="<?php echo $config->get('IP','SICKBEARD')?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard Port:</p></td>
                    <td align="left"><input name="PORT" title="Insert your SickBeard Port" size="4" value="<?php echo $config->get('PORT','SICKBEARD')?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard Username:</p></td>
                    <td align="left"><input name="USERNAME" title="Insert your SickBeard Username" size="20" value="<?php echo $config->get('USERNAME','SICKBEARD')?>" /></td>
                  </tr>
                  <tr>
                    <td align="right"><p>SickBeard Password:</p></td>
                    <td align="left"><input name="PASSWORD" title="Insert your SickBeard Password" size="20" type="password" value="<?php echo $config->get('PASSWORD','SICKBEARD')?>" /></td>
                  </tr>
                </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SICKBEARD');" />
            </div>
	</body>
</html>
