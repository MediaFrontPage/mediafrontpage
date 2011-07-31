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
?>
