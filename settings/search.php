<html>
	<body>
		<div id="SEARCH" class="panel">
              <h3>Search Widget</h3>
							<table>
								<tr>
									<td colspan="2"><p>Here you can specify your prefered Search criteria.</p></td>
								</tr><tr>
									<td align="right"><p>Preferred Index Site:</p></td>
									<td align="left">
									  <p>
									    <input type="radio" title="Defaults to NZBMatrix" name="preferred_site" value="1" <?php echo ($config->get('preferred_site','SEARCH')=="1")?'CHECKED':'';?> />NZB Matrix 
									    <input type="radio" title="Defaults to NZB.SU" name="preferred_site" value="2" <?php echo ($config->get('preferred_site','SEARCH')=="2")?'CHECKED':'';?> />NZB.SU
									  </p>
									</td>
								</tr>
								<tr>
									<td align="right"><p>Preferred Category:</p></td>
									<td align="left"><input name="preferred_categories" title="This denotes which Category you want to search by default from your Preferred Provider." size="20" value="<?php echo $config->get('preferred_categories','SEARCH')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>NZB Matrix Username:</p></td>
									<td align="left"><input name="NZBMATRIX_USERNAME" title="Insert your NZBMatrix Username" size="20" value="<?php echo $config->get('NZBMATRIX_USERNAME','SEARCH')?>" /></td>
								</tr>
								<tr>
									<td align="right"><p>NZB Matrix API:</p></td>
									<td align="left"><input name="NZBMATRIX_API" title="Insert your NZBMatrix API" type="password" size="40" value="<?php echo $config->get('NZBMATRIX_API','SEARCH')?>" /><a href="http://nzbmatrix.com/account.php" target="_blank" title="go to Account page"><img src="../media/question.png" height="20px"></a></td>
								</tr>
								<tr>
									<td align="right"><p>NZB.SU API:</p></td>
									<td align="left"><Input name="NZBSU_API" title="Insert your NZB.SU API" type="password" size="40" value="<?php echo $config->get('NZBSU_API','SEARCH')?>" /><a href="http://nzb.su/profile" target="_blank" title="go to profile page"><img src="../media/question.png" height="20px"></a></td>
								</tr>
								<tr>
				          <td align="right"><p>NZB.SU Download Code:</p></td>
									<td align="left"><input name="NZB_DL" title="Insert your NZB.SU Download Code" type="password" size="40" value="<?php echo $config->get('NZB_DL','SEARCH')?>" /><a href="http://nzb.su/rss" target="_blank" title="go to rss profile page"><img src="../media/question.png" height="20px"></a></td>
								</tr>
							</table>
              <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all" value="Save" onclick="updateSettings('SEARCH');" />
            </div>
	</body>
</html>
