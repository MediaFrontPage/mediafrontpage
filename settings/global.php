<html>
	<body>
		<div id="GLOBAL" class="panel"><br><br>
              <h3>Global Settings</h3>
                <table>
                  <tr>
                    <td colspan="2"><p align="justify" style="width: 500px;">Use Global Settings if all your programs are installed to one computer and/or if you use the same Username and Password throughout. Changing a setting for that particular program overrides this page.</p></td>
                  </tr>
                  <tr>
                    <td align="right"><p>Global URL:</p></td>
                    <td align="left"><p><input type="checkbox"  title="Tick to Enable" name="ENABLED" <?php echo ($config->get('ENABLED','GLOBAL')=="true")?'CHECKED':'';?>></td>
                  </tr>
                  <tr>
                    <td align="right"><p>Global IP:</p></td>
                    <td align="left"><p><input name="URL" size="20" title="Insert IP Address or Network Name" value="<?php echo $config->get('URL','GLOBAL')?>"></td>
                  </tr>
                  <tr>
                    <td align="right"><p>Global Authentication:</p></td>
                    <td align="left"><p><input type="checkbox" title="Tick to Enable" name="AUTHENTICATION" <?php echo ($config->get('AUTHENTICATION','GLOBAL') == "true")?'CHECKED':'';?>></p></td>
                  </tr>
                  <tr>
                    <td align="right"><p>Global Username:</p></td>
                    <td align="left"><input name="USERNAME" title="Insert your Global Username" size="20" value="<?php echo $config->get('USERNAME','GLOBAL')?>"></td>
                  </tr>
                  <tr>
                    <td align="right"><p>Global Password:</p></td>
                    <td align="left"><input type="password" title="Insert your Global Password" name="PASSWORD" size="20" value="<?php echo $config->get('PASSWORD','GLOBAL')?>"></td>
                  </tr>
                </table>
              <input type="button" title="Save these Settings" value="Save" class="ui-button ui-widget ui-state-default ui-corner-all" onClick="updateSettings('GLOBAL');" />
        </div>
	</body>
</html>
