<?php
//@author: Gustavo Hoirisch
if(isset($_GET['update']) && $_GET['update']){
  updateVersion();
}

function updateVersion(){
	require_once 'lib/class.settings.php';require_once 'lib/class.github.php';
  $github = new GitHub('gugahoi','mediafrontpage');
  $commit = $github->getCommits();
  $commitNo = $commit['0']['sha'];
  $config = new ConfigMagik('config.ini', true, true);
	try{
  	$config->set('version', $commitNo, 'ADVANCED');
  } catch (Exception $e){
    echo false; exit;
  }
  echo true;
  exit;
}

function getNew(){
  require_once 'lib/class.github.php';
  $git = new GitHub('gugahoi');
  echo '<pre>';print_r($git->getDownload());echo '</pre>';
}

function download($url = 'https://nodeload.github.com/gugahoi/mediafrontpage/zipball/master'){
  cleanUp();
  
  $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
  $file_zip = "update.zip";

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
  //timeout set to 30 seconds. FIle must finish downloading in this time.
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
  
  $updateContents = scandir('update/'.$name);
  foreach($updateContents as $number=>$fileName){
    try{
      rename('update/'.$name.'/'.$fileName, $fileName);
    } catch(Exception $e) {
      echo 'Could not move file '.$fileName;
    }
  }
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
	echo "<br />Unzipped file to: <b>".$extractDir.'</b>';	
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
download();
?>
