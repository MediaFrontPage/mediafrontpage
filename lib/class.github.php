<?PHP
/**
* @desc GitHub API stuff
* @author Gustavo Hoirisch
* @date Jul 31 2011
*/
class GitHub{
	var $URL     = 'https://api.github.com/';
	var $REPO    = null;
	var $USER    = null;
	var $ACTION  = null;
	var $SECTION = null;
	var $LAST    = null;

	function GitHub($user = 'MediaFrontPage', $repo = 'mediafrontpage'){
	  $this->USER = $user;
	  $this->REPO = $repo;
	}
	
	//return info about a Repository as specified in GitHub's page in array form
	function getInfo(){
	  return $this->request($this->URL.'repos/'.$this->USER.'/'.$this->REPO);
	}
	
	//return info about commit tree as specified in GitHub's page in array form
	function getCommits(){
	  return $this->request($this->URL.'repos/'.$this->USER.'/'.$this->REPO.'/commits');
	}
	
	function getDownload($id = ''){
	  if($id!==''){
	    $id = '/'.$id;
	  }
	  return $this->request($this->URL.'repos/'.$this->USER.'/'.$this->REPO.'/downloads'.$id);
	}
	
	//creates a cURL request to the API.
	function request($url){
	  $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  $results = json_decode(curl_exec($ch), true);
		curl_close($ch);
		return $results;
	}
}
//**************EXAMPLE USAGE***************//
//$g = new GitHub();                        //
//$info = $g->getInfo();                    //
//$commit = $g->getCommits();               //
//echo '<pre>';print_r($info);echo '</pre>';//
//echo $commit['0']['sha'];                 //
//******************************************//
/*
$g = new GitHub();                        
$info = $g->getInfo();                    
$commit = $g->getCommits();               
echo '<pre>';print_r($info);echo '</pre>';
echo '<pre>';print_r($commit);echo '</pre>';
*/
?>