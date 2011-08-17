<html>
	<body>
		<div id="WEBROOT" class="panel">
              <table>
                <tr>
                  <td colspan="2"><p align="justify" style="width: 500px;">Reverse Proxy changes your programs locations from http://serverip:port to http://serverip/programs. These also need to be edited within some of the programs you use. Further information on this is available from <a href="http://mediafrontpage.lighthouseapp.com/projects/76089/apache-configuration-hints" target="_blank">MediaFrontPage's Development Site</a>.</p></td>
                </tr>                
                <tr>
                  <td align="right"><p>Reverse Proxy:</p></td>
                  <td align="left"><p><input type="checkbox" title="Tick To Enable" name="ENABLED" <?php echo ($config->get('ENABLED','WEBROOT')=="true")?'CHECKED':'';?> /></p></td>
                </tr>
                <tr>
                  <td align="right"><p>XBMC:</p></td>
                  <td align="left"><input name="XBMC" size="20" title="XBMC's IP Address" value="<?php echo $config->get('XBMC','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Sickbeard:</p></td>
                  <td align="left"><input name="SICKBEARD" size="20" title="Sickbeard's IP Address" value="<?php echo $config->get('SICKBEARD','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Couch Potato:</p></td>
                  <td align="left"><input name="COUCHPOTATO" size="20" title="CouchPotato's IP Address" value="<?php echo $config->get('COUCHPOTATO','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>SabNZBd+:</p></td>
                  <td align="left"><input name="SABNZBD" size="20" title="SabNZBd+'s IP Address" value="<?php echo $config->get('SABNZBD','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>jDownloader:</p></td>
                  <td align="left"><input name="JDOWNLOADER" size="20" title="jDownloaders's IP Address" value="<?php echo $config->get('JDOWNLOADER','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Transmission:</p></td>
                  <td align="left"><input name="TRANSMISSION" size="20" title="Transmission's IP Address" value="<?php echo $config->get('TRANSMISSION','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>uTorrent:</p></td>
                  <td align="left"><input name="UTORRENT" size="20" title="uTorrent's IP Address" value="<?php echo $config->get('UTORRENT','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>Headphones:</p></td>
                  <td align="left"><input name="HEADPHONES" size="20" title="HeadPhones's IP Address" value="<?php echo $config->get('HEADPHONES','WEBROOT')?>" /></td>
                </tr>
                <tr>
                  <td align="right"><p>SubSonic:</p></td>
                  <td align="left"><input name="SUBSONIC" size="20" title="SubSonic's IP Address" value="<?php echo $config->get('SUBSONIC','WEBROOT')?>" /></td>
                </tr>              
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Back" onClick="history.go(-1)">
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('WEBROOT');" />
            </div>
	</body>
</html>
