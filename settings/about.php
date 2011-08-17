<html>
	<body>
		<div id="ABOUT" class="panel">
              <table cellpadding="5px">
                <tr>
                  <img src="media/mfp.png" />
                </tr>
                <tr>
                  <td colspan="2">
                    <p align="justify" style="width: 500px;padding-bottom: 20px;">
                      MediaFrontPage is a HTPC Web Program Organiser. Your HTPC utilises a number of different programs to do certain tasks, what MediaFrontPage does is creates it user specific web page that will be your nerve centre for everything you will need. It was originally created by <a href="http://forum.xbmc.org/member.php?u=24286">Nick8888</a> and has had a fair share of contributors. If you'd like to contribute please consider making a donation or come and join us developing this great tool.
                    </p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                      <input type="hidden" name="cmd" value="_s-xclick">
                      <input type="hidden" name="hosted_button_id" value="D2R8MBBL7EFRY">
                      <input type="image" src="../media/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
                      <img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
                    </form>
                  </td>
                </tr>
                <tr align="left">
                  <td>Homepage</td><td><a href="http://mediafrontpage.net/">http://mediafrontpage.net/</a></td>
                </tr>
                <tr align="left">
                  <td>Forum</td><td><a href="http://forum.xbmc.org/showthread.php?t=83304">http://forum.xbmc.org/showthread.php?t=83304</a></td>
                </tr>
                <tr align="left">
                  <td>Source</td><td><a href="https://github.com/MediaFrontPage/mediafrontpage">https://github.com/MediaFrontPage/mediafrontpage</a></td>
                </tr>
                <tr align="left">
                  <td>Bug Tracker</td><td><a href="http://mediafrontpage.lighthouseapp.com">http://mediafrontpage.lighthouseapp.com</a></td>
                </tr>
                <tr align="left">
                  <td>Last Updated</td>
                  <td>
                  <?php
                    $github = new GitHub('gugahoi','mediafrontpage');
                    $date   = $github->getInfo();
                    echo $date['pushed_at'];
                  ?>
                  </td>
                </tr>
                <tr align="left">
                  <td>
                    <?php
                      $commit = $github->getCommits();
                      $commitNo = $commit['0']['sha'];
                      $currentVersion = $config->get('version','ADVANCED');
                      echo "Version </td><td><a href='https://github.com/gugahoi/mediafrontpage/commit/".$currentVersion."' target='_blank'>".$currentVersion.'</a>';
                      if($commitNo != $currentVersion){
                        echo "\t<a href='#' onclick='updateVersion();' title='".$commitNo." - Description: ".$commit['0']['commit']['message']."'>***UPDATE Available***</a>";
                      }
                    ?>
                  </td>
                </tr>
              </table>
            </div>
	</body>
</html>