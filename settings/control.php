<html>
	<body>
		<div id="CONTROL" class="panel">
              <h3>Control Widget</h3>
              <p align="justify" style="width: 500px;">These commands are JSON API controls that directly communicate with the computer that MediaFrontPage is installed on. A few options are available. Will be added here soon.</p>
              <table id="table_control">
                <tr>
                  <td>title</td>
                  <td>URL</td>
                </tr>
                <?php
                $x = $config->get('CONTROL');
                foreach ($x as $title=>$url){
                  echo "<tr>
                          <td>
                            <input size='20' name='title' value='".urldecode(str_ireplace('_', ' ', $title))."'/>
                          </td>
                          <td>
                            <input size='40' name='VALUE' value='$url'/>
                          </td>
                        </tr>";
                }
                ?>
              </table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('control', 20, 40);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('control');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('CONTROL');" />
            </div>
	</body>
</html>
