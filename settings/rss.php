<html>
	<body>
		<div id="RSS" class="panel">
              <h3>RSS Feeds</h3>
              <p align="justify" style="width: 500px;">We also added an RSS Feed from the most popular NZB Sites so you can instantly grab an NZB from their Feeds and load it straight to SabNZBd+ with no other user intervention. The default/shown RSS is the first one on this list.</p>
              <table id="table_rss">
                <tr>
                  <td>title</td>
                  <td>URL</td>
                </tr>
                <?php
                 $x = $config->get('RSS');
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
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="ADD" onclick="addRowToTable('rss', 20, 40);" />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="REMOVE" onclick="removeRowToTable('rss');" />
              <br />
              <br />
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateAlternative('RSS');" />
            </div>
	</body>
</html>
