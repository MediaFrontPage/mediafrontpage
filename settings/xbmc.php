<html>
	<body>
		<div id="XBMC" class="panel">
              <br />
              <br />
              <a href="http://www.xbmc.org/" title="Go to XBMC's home page"><h3>XBMC</h3></a>
              <table>
                <tr>
                  <td colspan="2">
                    <p align="justify">To connect to XBMC, you need to enable these settings under Network Settings in XBMC.</p>
                    <p align="justify" style="padding-left:20px;">
                      &ndash; Allow control of XBMC via HTTP<br />
                      &ndash; Allow programs on this system to control XBMC<br />
                      &ndash; Allow programs on other systems to control XBMC.
                    </p>
                  </td>
                </tr>
                <tr>            
                  <td align="right"><p>XBMC IP:</p></td>
                  <td align="left"><input name="IP" title="Insert your XBMC IP Address" size="20" value="<?php echo $config->get('IP','XBMC')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC Port:</p></td>
                  <td align="left"><input name="PORT" title="Insert your XBMC Port" size="4" value="<?php echo $config->get('PORT','XBMC')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC Username:</p></td>
                  <td align="left"><input name="USERNAME" title="Insert your XBMC Username" size="20" value="<?php echo $config->get('USERNAME','XBMC')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC Password:</p></td>
                  <td align="left"><input type="password" title="Insert your XBMC Password" name="PASSWORD" size="20" value="<?php echo $config->get('PASSWORD','XBMC')?>" /></td>
                </tr>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('XBMC');" />
            </div>
	</body>
</html>
