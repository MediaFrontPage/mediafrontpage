<?php
//@author: Gustavo Hoirisch
function unzip($file = 'update.zip', $extractDir = 'update'){
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

function moveDir($src, $dst, $update = true){
  $src = $src.'/';
  $dst = $dst.'/';
  $updateContents = scandir($src);
  foreach($updateContents as $number=>$fileName){
    if($fileName != 'update' && $fileName != 'config.ini' && $fileName != 'layout.php' && $fileName != '..' && $fileName != '.' && $fileName != '.git' && $fileName != '.gitignore' && $fileName != 'tmp' && $fileName != 'update'){
      if(!rename($src.$fileName, $dst.$fileName)){
        echo false;return false;
      }
    }
  }
  if($update){
    if(moveUpdate()){
      echo true; return true;
    }
    else {
      echo false; return false;
    }
  }
  echo true; return true;
}

function moveUpdate(){
  $name = '';
  if ($handle = opendir('update')) {
    while (false !== ($file = readdir($handle))) {
      if(strstr($file,'mediafrontpage')){
        $name = $file;
      }
    }
    closedir($handle);
  }
  if($name != ''){
    if(moveDir('update/'.$name, '.', false)){
      echo true; return true;
    }
  }
  echo true; return false;
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
    unzip();
  }
  if(isset($_GET['update']) && $_GET['update']){
    updateVersion();
  }
  if(isset($_GET['remove']) && $_GET['remove'] != false){
    rrmdir($_GET['remove']);
  }
  if(isset($_GET['move']) && $_GET['move']){
    if(isset($_GET['src']) && isset($_GET['dst'])){
      moveDir($_GET['src'], $_GET['dst']);
    } else {
      echo false; return false;
    }
  }
  if(isset($_GET['cleanup']) && $_GET['cleanup']){
    if(isset($_GET['dir']) && $_GET['dir'] != ''){
      rrmdir($_GET['dir']);
    } else {
      echo false; return false;
    }
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
            <td><div id="zip"></div></td>
          </tr>
          <tr>
            <td>Backing up old files</td>
            <td><div id="backup"></div></td>
          </tr>
          <tr>
            <td>Updating</td>
            <td><div id="update"></td>
          </tr>
          <tr>
            <td>Cleaning up backup</td>
            <td><div id="clean-back"></div></td>
          </tr>
          <tr>
            <td>Cleaning up leftovers</td>
            <td><div id="clean-left"></div></td>
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