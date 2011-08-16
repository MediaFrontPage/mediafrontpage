<html>
	<body>
		<div id="MODS" class="panel">
              <h3>CSS Modifications:</h3>
              <p align="justify" style="width: 500px;">These are 'user created' CSS modifications submitted by some of our users. These change mainly the look and colours of MediaFrontPage. If you want to contribute your own modification, submit it to us on the <a href="http://forum.xbmc.org/showthread.php?t=83304" target="_blank">MediaFrontPage Support Thread</a>.</p>
              <table style="max-height:300px;">
                <tr align="center">
                  <td><img class="widget" src="media/examples/lightheme.jpg" height="100px" /></td>
                  <td><img class="widget" src="media/examples/hernadito.jpg" height="100px" /></td>
                  <td><img class="widget" src="media/examples/black_modern_glass.jpg" height="100px" /></td>
                </tr>
                <tr>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="lighttheme" <?php echo ($config->get('ENABLED','MODS') == "lighttheme")?'CHECKED':'';?> />
                    <p>Light Theme</p>
                  </td>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="hernandito" <?php echo ($config->get('ENABLED','MODS') == "hernandito")?'CHECKED':'';   ?>>
                    <p>Hernandito's Theme</p>
                  </td>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="black_modern_glass" <?php echo ($config->get('ENABLED','MODS') == "black_modern_glass")?'CHECKED':'';?> />
                    <p>Black Modern Glass Theme</p>
                  </td>
                </tr>
                <tr>
                  <td><img class="widget" src="media/examples/minimal-posters.jpg" height="100px" /></td>
                  <td><img class="widget" src="media/examples/minimal-banners.jpg" height="100px" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="comingepisodes-minimal-poster" <?php echo ($config->get('ENABLED','MODS') == "comingepisodes-minimal-poster")?'CHECKED':'';?> />
                    <p>Minimal Posters</p>
                  </td>
                  <td align="center">
                    <input type="radio" name="ENABLED" value="comingepisodes-minimal-banner" <?php echo ($config->get('ENABLED','MODS') == "comingepisodes-minimal-banner")?'CHECKED':'';?> />
                    <p>Minimal Banners</p>
                  </td>
                  <td>
                    <input type="radio" name="ENABLED" value="" <?php echo ($config->get('ENABLED','MODS') == "")?'CHECKED':'';   ?> />
                    <p>OFF</p>
                  </td>
                </tr>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('MODS');" />
            </div>
	</body>
</html>
