<?php
if(isset($_GET['update']) && $_GET['update']){
  updateVersion();
}

function updateVersion(){
	require_once 'lib/class.settings.php';
  require_once 'lib/github/Autoloader.php';
	Github_Autoloader::register();
  $github = new Github_Client();
  $commits = $github->getCommitApi()->getBranchCommits('gugahoi', 'mediafrontpage', 'master');
  $id = $commits['0']['parents']['0']['id'];
  $config = new ConfigMagik('config.ini', true, true);
	try{
  	$config->set('version', $id, 'ADVANCED');
  } catch (Exception $e){
    echo false; exit;
  }
  echo true; exit;
}
?>
