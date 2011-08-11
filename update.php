<?php
//@author: Gustavo Hoirisch

function updateVersion(){
  require_once 'lib/class.settings.php';require_once 'lib/class.github.php';
  $github = new GitHub('gugahoi','mediafrontpage');
  $commit = $github->getCommits();
  $commitNo = $commit['0']['sha'];
  $config = new ConfigMagik('config.ini', true, true);
  echo "<p>Updating commit number from: ".$config->get('version', 'ADVANCED')." -> ".$commitNo;
  try{
    $config->set('version', $commitNo, 'ADVANCED');
    echo "  <font color='green'>OK</font></p>";
  } catch (Exception $e){
    echo "  <font color='red'>ERROR</font></p>";
  }
}

function getNew(){
  require_once 'lib/class.github.php';
  $git = new GitHub('gugahoi');
  echo '<pre>';print_r($git->getDownload());echo '</pre>';
}

function download($url = 'https://nodeload.github.com/gugahoi/mediafrontpage/zipball/master'){
  echo '<html><head>';
  echo '<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>';
  echo '<link href="css/front.css" rel="stylesheet" type="text/css">';
  echo '<link rel="stylesheet" type="text/css" href="css/widget.css">';
  echo '<link rel="stylesheet" type="text/css" href="css/static_widget.css">';
  echo '<script>
  			function toggle(id){
          if (document.getElementById(id).style.display == "none"){
            document.getElementById(id).style.display = "inline-block";
          }else {
            document.getElementById(id).style.display = "none";
          }
				}
        </script>';
  echo '</head><body><center>';
  $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
  $file_zip = "update.zip";
  echo '<div style="width:90%; height:100%; overflow: scroll;" class="widget">
          <div class="widget-head">
            <h3>MediaFrontPage Auto-Update</h3>
          </div>';
      
  echo "Starting";

  $ch = curl_init();
  //Opening $file_zip to save the download
  $fp = fopen("$file_zip", "w"); 
  curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
  // set the cURL request to $url
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  //No headers
  curl_setopt($ch, CURLOPT_HEADER,0); 
  //Follow redirects
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
  //timeout set to 30 seconds. File must finish downloading in this time.
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_FILE, $fp);
  //execute request
  $page = curl_exec($ch);
  
  //In case the download failed
  if (!$page) {
    echo "<br />cURL error number:" .curl_errno($ch);
    echo "<br />cURL error:" . curl_error($ch);
    curl_close($ch);
    exit;
  }
  curl_close($ch);
  
  echo "<br>Downloaded file from: $url";
  echo "<br>Saved as file: $file_zip";
  echo "<br>Starting unzip ...";
  
  if(!unzip($file_zip, 'update')){
    echo 'Unzip failed';
    exit;
  }
  
  $name = '';
  //Getting the name of the file. It should be the only file in the UPDATE directory for now.
  //In the future I'd like to rename the update according to the PUSHED TIME or DOWNLOADED TIME.
  if ($handle = opendir('update')) {
    while (false !== ($file = readdir($handle))) {
      if(strstr($file,'mediafrontpage')){
        $name = $file;
      }
    }
    closedir($handle);
  }

  $successful = true;
  echo '<p><button type="button" onclick="toggle(\'old\');">Old stuff</button>';
  echo '<div id="old" style="display: none;"><table>';
  $updateContents = scandir('./');
  foreach($updateContents as $number=>$fileName){
    if($fileName != 'update' && $fileName != 'config.ini' && $fileName != 'layout.php' && $fileName != '..' && $fileName != '.' && $fileName != '.git' && $fileName != '.gitignore' && $fileName != 'tmp'){
      if(is_dir($fileName)){
        rename($fileName, 'tmp/'.$fileName);
      } else {
        if(rename($fileName, 'tmp/'.$fileName)){
          echo '<tr><td>'.$fileName.' moved successfully </td><td><font color="green">OK</font></td></tr>';
        } else {
          echo '<tr><td>Could not move file '.$fileName.'</td><td><font color="red">ERROR</font></td></tr>';
          $successful = false;
        }
      }
    }
  }
  echo '</table></div></p>';

  if($successful){
    echo '<p><button type="button" onclick="toggle(\'new\');">New stuff</button>';
    echo '<div id="new" style="display: none;"><table>';
    $updateContents = scandir('update/'.$name);
    foreach($updateContents as $number=>$fileName){
      if($fileName != 'update' && $fileName != 'config.ini' && $fileName != 'layout.php' && $fileName != '..' && $fileName != '.' && $fileName != '.git' && $fileName != '.gitignore' && $fileName != 'tmp'){
        if(is_dir($fileName)){
          if(rename('update/'.$name.'/'.$fileName, './'.$fileName)){
            echo '<tr><td>DIR: '.$fileName.' moved successfully </td><td><font color="green">OK</font></td></tr>';
          } else {
            echo '<tr><td>Could not move dir '.$fileName.'</td><td><font color="red">ERROR</font></td></tr>';
          }
        } else {
          if(rename('update/'.$name.'/'.$fileName, './'.$fileName)){
            echo '<tr><td>'.$fileName.' moved successfully </td><td><font color="green">OK</font></td></tr>';
          } else {
            echo '<tr><td>Could not move file '.$fileName.'</td><td><font color="red">ERROR</font></td></tr>';
            $successful = false;
          }
        }
      }
    }
  }
  echo '</table></div></p>';
  
  //If the renaming went through smoothly, need to clean up the downloaded and backed up files. Otherwise, 
  //move the files back and tell user to update manually.
  if($successful){
    echo "<p><font size='20' color='green'>UPDATE SUCCESSFULL</font></p>";
    $dir = scandir('update/');
    echo "<p><button onclick=\"toggle(\'update\');\">Cleaning up UPDATE</button><div id='update' style='display: none;'><table>";
    foreach($dir as $number=>$fileName){
      if($fileName != '..' && $fileName != '.'){
        if(is_dir($fileName)){
          rrmdir('update/'.$fileName);
        //} else {
        //if(unlink('update/'.$fileName)){
        //    echo '<tr><td>'.$fileName.' deleted successfully </td><td><font color="green">OK</font></td></tr>';
        //  } else {
        //    echo '<tr><td>Could not delete file '.$fileName.'</td><td><font color="red">ERROR</font></td></tr>';
        //  }
        }
      }
    }
    echo '</table></div></p>';
    $dir = scandir('tmp/');
    echo "<p><button onclick=\"toggle(\'tmp\');\">Cleaning up TMP</button><div id='tmp' style='display: none;'><table>";
    foreach($dir as $number=>$fileName){
      if($fileName != '..' && $fileName != '.'){
        if(is_dir($fileName)){
          rrmdir('tmp/'.$fileName);
        } else {
        if(unlink('tmp/'.$fileName)){
          echo '<tr><td>'.$fileName.' deleted successfully </td><td><font color="green">OK</font></td></tr>';
          } else {
            echo '<tr><td>Could not delete file '.$fileName.'</td><td><font color="red">ERROR</font></td></tr>';
          }
        }
      }
    }
    echo '</table>';
    echo '</table></div></p>';
    updateVersion();
  } else {
    echo "<p><font size='20' color='red'>UPDATE FAILED</font></p>";
    $dir = scandir('tmp/');
    echo "<p>Moving things back</p><table>";
    foreach($dir as $number=>$fileName){
      if($fileName != '..' && $fileName != '.'){
        if(rename('tmp/'.$fileName, './'.$fileName)){
          echo '<tr><td>'.$fileName.' moved successfully </td><td><font color="green">OK</font></td></tr>';
        } else {
          echo '<tr><td>Could not move file '.$fileName.'</td><td><font color="red">ERROR</font></td></tr>';
        }
      }
    }
    echo '</table>'; 
  }
  echo '</div></center></body></html>';
}

function unzip($file, $extractDir = 'update'){
  //check if ZIP extension is loaded
  if (!extension_loaded('zip')) {
    try{
      dl('zip.so');
    } catch(Exception $e){
      echo 'Could not load extension ZIP';
      exit;
    }
  }
  // Unzip the file 
  $zip = new ZipArchive;
  if (!$zip) {
    echo "<br />Could not make ZipArchive object.";
    return false;
  }
  if($zip->open("$file") != "true") {
    echo "<br />Could not open $file.";
    return false;
  }
  $zip->extractTo($extractDir);
  $zip->close();
  echo "<p>Unzipped file to: <b>".$extractDir.'</b></p>';  
  return true;
}

/*
/Function to clean up some leftover files. If files other than 'update' folder and 'update.zip'
/are to be deleted, than the $extra variable and be used. If multiple files are to be deleted use
/$extra as an array.
/
/return: false if nothing is deleted, a string with the deleted files otherwise.
*/
function cleanUp($extra = ''){
  $return_value = '';
  if(file_exists('update')){
    if(@unlink('update')){
      $return_value .= '<br /><b>update</b> folder deleted';
    }
  }
  if(file_exists('update.zip')){
    if(@unlink('update.zip')){
      $return_value .= '<br /><b>update.zip</b> deleted';
    }
  }
  if($extra !== ''){
    if(is_array($extra)){
      foreach($extra as $x){
        if(@unlink($x)){
          $return_value = '<br /><b>'.$x.'</b> deleted';
        }
      }
    } else {
      if(@unlink($extra)){
        $return_value = '<br /><b>'.$extra.'</b> deleted';
      }
    }
  }
  if($return_value === ''){
    return false;
  } else {
    return $return_value;
  }
}

//Deletes directories and it's contents. 
function rrmdir($dir) { 
  if (is_dir($dir)) { 
    $objects = scandir($dir); 
    foreach ($objects as $object) { 
      if ($object != "." && $object != "..") { 
        if (filetype($dir."/".$object) == "dir"){
          rrmdir($dir."/".$object);
        } else {
          if(unlink($dir."/".$object)){
            echo '<tr><td>'.$dir."/".$object.' deleted successfully </td><td><font color="green">OK</font></td></tr>';
          } else {
            echo '<tr><td>Could not delete file '.$dir."/".$object.'</td><td><font color="red">ERROR</font></td></tr>';
          }
        }
      } 
    } 
    reset($objects); 
    rmdir($dir); 
  } 
}
download();
?>
