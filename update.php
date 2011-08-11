<?php
//@author: Gustavo Hoirisch
function unzip($file, $extractDir = 'update'){
  //check if ZIP extension is loaded
  if (!extension_loaded('zip')) {
    try{
      dl('zip.so');
    } catch(Exception $e){
      //echo 'Could not load extension ZIP';
      echo false; return false;
    }
  }
  // Unzip the file 
  $zip = new ZipArchive;
  if (!$zip) {
    //echo "<br />Could not make ZipArchive object.";
    echo false; return false;
  }
  if($zip->open("$file") != "true") {
    //echo "<br />Could not open $file.";
    echo false;return false;
  }
  $zip->extractTo($extractDir);
  $zip->close();
  //echo "<p>Unzipped file to: <b>".$extractDir.'</b></p>';  
  echo true;return true;
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

//Deletes directories and it's contents. If $remove is true, it will delete the directory otherwise, only it's contents.
function rrmdir($dir, $remove = true) { 
  if (is_dir($dir)) { 
    $objects = scandir($dir); 
    foreach ($objects as $object) { 
      if ($object != "." && $object != "..") { 
        if (filetype($dir."/".$object) == "dir"){
          if(rrmdir($dir."/".$object)){
            return true;
          } else {
            return false;
          }
        } else {
          if(unlink($dir."/".$object)){
            //echo '<tr><td>'.$dir."/".$object.' deleted successfully </td><td><font color="green">OK</font></td></tr>';
            return true;
          } else {
            echo '<tr><td>Could not delete file '.$dir."/".$object.'</td><td><font color="red">ERROR</font></td></tr>';
            return false;
          }
        }
      } 
    }
    reset($objects);
    if($remove){
      if(!rmdir($dir)){
        return false;
      }
    }
    return true;
  } 
}

function download($file_name = "update.zip"){
  $url = 'https://nodeload.github.com/gugahoi/mediafrontpage/zipball/master';
  $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
  $ch = curl_init();
  //Opening $file_zip to save the download
  $fp = fopen("$file_name", "w"); 
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
    //echo "<br />cURL error number:" .curl_errno($ch);
    //echo "<br />cURL error:" . curl_error($ch);
    curl_close($ch);
    echo false;
  }
  curl_close($ch);
  echo true;
}

function updateVersion(){
  require_once 'lib/class.settings.php';require_once 'lib/class.github.php';
  $github = new GitHub('gugahoi','mediafrontpage');
  $commit = $github->getCommits();
  $commitNo = $commit['0']['sha'];
  $config = new ConfigMagik('config.ini', true, true);
  try{
    $config->set('version', $commitNo, 'ADVANCED');
    echo true;
  } catch (Exception $e){
    echo false;
  }
}

if(!empty($_GET)){
  if(isset($_GET['download']) && $_GET['download']){
    download();
  }
  if(isset($_GET['unzip']) && $_GET['unzip']){
    unzip($file_zip, 'update');
  }
  if(isset($_GET['update']) && $_GET['update']){
    updateVersion();
  }
  if(isset($_GET['remove']) && $_GET['remove'] != false){
    rrmdir($_GET['remove']);
  }
} else {
  $url = 'https://nodeload.github.com/gugahoi/mediafrontpage/zipball/master';
  ?>
<html>
  <head>
    <title>UPDATING</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/update.js"></script>
    <link href="css/front.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/widget.css">
    <link rel="stylesheet" type="text/css" href="css/static_widget.css">
    <script>
      function toggle(id){
        if (document.getElementById(id).style.display == "none"){
          document.getElementById(id).style.display = "inline-block";
        } else {
          document.getElementById(id).style.display = "none";
        }
	    }
    </script>
  </head>
  <body>
    <center>
      <div style="width:90%; height:100%; overflow: auto;" class="widget">
        <div class="widget-head">
          <h3>MediaFrontPage Auto-Update</h3>
        </div>
        
        <table align="left">
          <tr>
            <td>Downloading latest version</td>
            <td><img id="dl" src="media/pwait.gif" height="15px" /></td>
          </tr>
          <tr>
            <td>Unziping archive</td>
            <td></td>
          </tr>
          <tr>
            <td>Backing up old files</td>
            <td></td>
          </tr>
          <tr>
            <td>Updating</td>
            <td></td>
          </tr>
          <tr>
            <td>Cleaning up backup</td>
            <td></td>
          </tr>
          <tr>
            <td>Cleaning up leftovers</td>
            <td></td>
          </tr>
        </table>
        <div id="result"></div>
      </div>
    </center>
  </body>
</html>
<?php
}
?>