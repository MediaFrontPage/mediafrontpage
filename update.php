<?php
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
}

function getNew(){
  require_once 'lib/class.github.php';
  $git = new GitHub('gugahoi');
  
  echo '<pre>';print_r($git->getDownload());echo '</pre>';
}

function getGit(){
  ignore_user_abort();
/*
  if(!is_dir('.git') || !is_readable('.git')){
    echo 'Not a git installation. Creating one now.';
    $output = shell_exec('git clone git://github.com/gugahoi/mediafrontpage.git '.$_SERVER);    
  } else {
    echo 'Pulling repo';
    $output = shell_exec('git pull');
    echo "<pre>$output</pre>";
  }
*/
}

function download($url){
  if (!extension_loaded('zip')) {
    try{
      dl('zip.so');
    } catch(Exception $e){
      echo 'Could not load extension ZIP';
      exit;
    }
  }
  
  if(file_exists('update')){
    unlink('update');
    echo 'Deleted leftover update from previous update<br>';
  }
  if(file_exists('update.zip')){
    unlink('update.zip');
    echo 'Deleted leftover ZIP from previous update<br>';
  }
  $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
  $file_zip = "update.zip";
  $file_txt = "update";

  echo "Starting";

  // make the cURL request to $url
	$ch = curl_init();
	//Opening $file_zip to save the download
	$fp = fopen("$file_zip", "w"); 
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
  //No headers
	curl_setopt($ch, CURLOPT_HEADER,0); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	
	$page = curl_exec($ch);
	
	//In case the download failed
	if (!$page) {
	  echo "<br />cURL error number:" .curl_errno($ch);
	  echo "<br />cURL error:" . curl_error($ch);
  	curl_close($ch);
	  exit;
	}
	curl_close($ch);
	
	echo "<br>Downloaded file: $url";
	echo "<br>Saved as file: $file_zip";
	echo "<br>About to unzip ...";
	
	// Unzip the file 
	$zip = new ZipArchive;
	if (!$zip) {
	  echo "<br>Could not make ZipArchive object.";
	  exit;
	}
	if($zip->open("$file_zip") != "true") {
	  echo "<br>Could not open $file_zip. Code: ";
	}
	$zip->extractTo("$file_txt");
	$zip->close();
	echo "<br>Unzipped file to: $file_txt<br><br>";	
	$name = '';
	if ($handle = opendir('update')) {
    //echo "Directory handle: $handle\n";
    //echo "Files:\n";

    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
      if(strstr($file,'mediafrontpage')){
        $name = $file;
      }
    }

    closedir($handle);
  }
}
download('https://nodeload.github.com/DejaVu77/mediafrontpage/zipball/561e9ea2e21dbb4c126877ccf1a9c95860bad79b');
?>
