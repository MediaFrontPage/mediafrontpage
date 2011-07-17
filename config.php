<?php
// inlclude the class-file
require_once('class.ConfigMagik.php');

// create new ConfigMagik-Object
// Needed alternate paths for ajax based widgets to load appropriately
$found = false;
$path = 'config.ini';
while(!$found){	
	if(file_exists($path)){ 
		$found = true;
		$Config = new ConfigMagik( $path, true, true);
		//echo '<script>alert("'.$path.'");</script>';
	}
	else{ $path= '../'.$path; }
}
//echo '<pre>';print_r($Config); echo '</pre>';
//**************************************************************************************************************//
//  __  __          _           ___                  _    ___                     ___              __           //
// |  /  | ___  __| |(*) __ _ | __| _ _  ___  _ __ | |_ | _  __ _  __ _  ___   / __| ___  _ __  / _|(*) __ _  //
// | |/| |/ -_)/ _` || |/ _` || _| | '_|/ _ | '  |  _||  _// _` |/ _` |/ -_)  |(__ / _ | '  |  _|| |/ _` | //
// |_|  |_|___|__,_||_|__,_||_|  |_|  ___/|_||_||_|  |_|  __,_|__, |___|  ___|___/|_||_||_|  |_|__, | //
//                                                                  ___/ |                               ___/ | //
//**************************************************************************************************************//

                              /*Programs Section*/

//***********************************************************************************//
//     Titles are self explanatory. Do not include http://                           //
//                                                                                   //
//     Need to add the option for reverse proxies(eg.: /xbmc)                        //
//                                                                                   //
//     $JDOWNLOADER_REMOTEPORT -> port from RemoteControl Plugin                     //
//     $JDOWNLOADER_WEBPORT    -> port from Web plugin                               //
//                                                                                   //
//                                                                                   //
//     If most or all programs live in the same machine set $GLOBAL_MACHINE          //
//     to true and put all the info in the global variables. If one or two           //
//     programs live in a different computer, then insert the info in the            //
//     respective section and leave the ones that have the same info as GLOBAL       //
//     empty. If USERNAME/PASSWORD are the same for all programs set                 //
//     $GLOBAL_USER_PASS     to true and put you global username and password.       //
//                                                                                   //
//                                                                                   //
//     Variables that are always required                                            //
//     All PORTS                                                                     //
//     All API's                                                                     //
//***********************************************************************************//

     $GLOBAL_MACHINE      = filter_var($Config->get('ENABLED','GLOBAL'), FILTER_VALIDATE_BOOLEAN);
     $GLOBAL_USER_PASS    = filter_var($Config->get('AUTHENTICATION','GLOBAL'), FILTER_VALIDATE_BOOLEAN);
     $GLOBAL_IP           = $Config->get('URL','GLOBAL');
     $GLOBAL_USER         = $Config->get('USERNAME','GLOBAL');;
     $GLOBAL_PASS         = $Config->get('PASSWORD','GLOBAL');;

     $REVERSE_PROXY       = filter_var($Config->get('ENABLED','WEBROOT'), FILTER_VALIDATE_BOOLEAN);
     $XBMC_WEBROOT        = $Config->get('XBMC','WEBROOT');
     $SICKBEARD_WEBROOT   = $Config->get('SICKBEARD','WEBROOT');
     $COUCHPOTATO_WEBROOT = $Config->get('COUCHPOTATO','WEBROOT');
     $SABNZBD_WEBROOT     = $Config->get('SABNZBD','WEBROOT');
     $UTORRENT_WEBROOT    = $Config->get('UTORRENT','WEBROOT');
     $JDOWNLOADER_WEBROOT = $Config->get('JDOWNLOADER','WEBROOT');
     $TRANSMISSION_WEBROOT= $Config->get('TRANSMISSION','WEBROOT');

/* XBMC Section*/

     $XBMC_IP             = $Config->get('IP','XBMC');
     $XBMC_PORT           = $Config->get('PORT','XBMC');
     $XBMC_USERNAME       = $Config->get('USERNAME','XBMC');
     $XBMC_PASS           = $Config->get('PASSWORD','XBMC');
          
/* SickBeard Section*/

     $SICKBEARD_IP        = $Config->get('IP','SICKBEARD');
     $SICKBEARD_PORT      = $Config->get('PORT','SICKBEARD');
     $SICKBEARD_USERNAME  = $Config->get('USERNAME','SICKBEARD');
     $SICKBEARD_PASS      = $Config->get('PASSWORD','SICKBEARD');

/* SABNZBD Section*/

     $SABNZBD_IP          = $Config->get('IP','SABNZBD');
     $SABNZBD_PORT        = $Config->get('PORT','SABNZBD');
     $SABNZBD_USERNAME    = $Config->get('USERNAME','SABNZBD');
     $SABNZBD_PASS        = $Config->get('PASSWORD','SABNZBD');
     $SABNZBD_API         = $Config->get('API','SABNZBD');

/* CouchPotato Section*/

     $COUCHPOTATO_IP      = $Config->get('IP','COUCHPOTATO');
     $COUCHPOTATO_PORT    = $Config->get('PORT','COUCHPOTATO');
     $COUCHPOTATO_USERNAME= $Config->get('USERNAME','COUCHPOTATO');
     $COUCHPOTATO_PASS    = $Config->get('PASSWORD','COUCHPOTATO');

/* uTorrent Section*/

     $uTORRENT_IP         = $Config->get('IP','UTORRENT');
     $uTORRENT_PORT       = $Config->get('PORT','UTORRENT');
     $uTORRENT_USERNAME   = $Config->get('USERNAME','UTORRENT');
     $uTORRENT_PASS       = $Config->get('PASSWORD','UTORRENT');

/* jDownloader Section*/

     $JDOWNLOADER_IP         = $Config->get('IP','JDOWNLOADER');
     $JDOWNLOADER_REMOTEPORT = $Config->get('REMOTE_PORT','JDOWNLOADER');
     $JDOWNLOADER_WEBPORT    = $Config->get('WEB_PORT','JDOWNLOADER');
     $JDOWNLOADER_USERNAME   = $Config->get('USERNAME','JDOWNLOADER');
     $JDOWNLOADER_PASS       = $Config->get('PASSWORD','JDOWNLOADER');

/* Transmission Section*/

     $TRANSMISSION_IP        = $Config->get('IP','TRANSMISSION');
     $TRANSMISSION_PORT      = $Config->get('PORT','TRANSMISSION');
     $TRANSMISSION_USERNAME  = $Config->get('USERNAME','TRANSMISSION');
     $TRANSMISSION_PASS      = $Config->get('PASSWORD','TRANSMISSION');
/*Builtin Authentication*/

     $AUTH_ON                = filter_var($Config->get('PASSWORD_PROTECTED','SECURITY'), FILTER_VALIDATE_BOOLEAN);;
     $AUTH_USERNAME          = $Config->get('USERNAME','SECURITY');
     $AUTH_PASS              = $Config->get('PASSWORD','SECURITY');

                              /*SEARCH WIDGET*/

//***********************************************************************************//
//     $NZBSU_API   ->     http://nzb.su/profile                                     //
//     $NZB_DL      ->     http://nzb.su/rss where it says "Add this string to your  // 
//                                                  feed URL to allow NZB downloads  //
//                                                  without logging in:"             //
//                                                                                   //
//     $NZBMATRIX_API       -> http://nzbmatrix.com/account.php                      //
//     $preferredSearch     ->     Set to 1 for NZBMatrix and 2 for nzb.su           //
//     $preferredCategories -> Check README for a list of options.                   //
//                          Make sure the option is for the appropriate site         //
//                                                                                   //
//     $trakt_api     ->     http://trakt.tv/settings/api                            //
//***********************************************************************************//

     $preferredSearch       = $Config->get('preferred_site','SEARCH');
     $preferredCategories   = $Config->get('preferred_categories','SEARCH');
     $NZBMATRIX_USERNAME    = $Config->get('NZBMATRIX_USERNAME','SEARCH');
     $NZBMATRIX_API         = $Config->get('NZBMATRIX_API','SEARCH');
     $NZBSU_API             = $Config->get('NZBSU_API','SEARCH');
     $NZB_DL                = $Config->get('NZB_DL','SEARCH');
     $TRAKT_API             = $Config->get('TRAKT_API','TRAKT');
     $TRAKT_USERNAME        = $Config->get('TRAKT_USERNAME','TRAKT');
     $TRAKT_PASSWORD        = $Config->get('TRAKT_PASSWORD','TRAKT');

                              // NavBar Section //

//***********************************************************************************//
//     To open inline on MFP                                                         //
//          $navlink["Example"] = "http://example.com/";                             //
//                                                                                   //
//     To open in a blank page                                                       //
//          $navlink_blank["New Page"] = "http://google.com";                        //
//                                                                                   //
//     To populate the DropDown list                                                 //
//          $navselect["Title"] = "http://google.com";                               //
//                                                                                   //
//     SubMenu                                                                       //
//     =======                                                                       //
//     To open inline on MFP                                                         //
//          $subnavlink["Google"] = "http://google.com";                             //
//                                                                                   //
//     To open in a blank page                                                       //
//          $subnavlink_blank["Google"] = "http://google.com";                       //
//                                                                                   //
//     Examples                                                                      //
//     ========                                                                      //
//     $navlink["TV Headend"]   = "/tvheadend";                                      //
//     $navlink["Transmission"] = "http://localhost:9091/transmission/web/";         //
//     $navlink["uTorrent"]     = "http://localhost:8081/gui/";                      //
//     $navlink["jDownloader"]  = "http://localhost:8765/";                          //
//***********************************************************************************//


          $navlink;
          $x = $Config->get('NAVBAR');
          if(!empty($x)){
              foreach ($x as $k=>$e){
                  $k = str_ireplace('_', ' ', $k);
                  $navlink["$k"]         = "$e";
		          }
		      }

          $subnavlink;
          $x = $Config->get('SUBNAV');
          if(!empty($x)){
            foreach ($x as $k=>$e){
              if(isset($k) && $k != ''){
                $k = str_ireplace('_', ' ', $k);
                $subnavlink["$k"]         = "$e";
              }
		        }
		      }

                              // Control Section //

//***********************************************************************************//
//     Options:                                                                      //
//     =======                                                                       //
//          cmd                                                                      //
//          xbmcsend                                                                 //
//          json                                                                     //
//                                                                                   //
//      Optionally Add                                                               //
//      ==============                                                               //
//          'host' => 'localhost',                                                   //
//          'port' => 9777 to connect to a different machine.                        //
//          URL's can be used to link to various websites                            //
//                                                                                   //
//               INCOMPLETE INFO --->>     NEED TO COMPLETE THIS!                    //
//***********************************************************************************//

/*
          $shortcut;
          $shortcut["Shutdown XBMC"]         = array("cmd" => 'shutdown');
          $shortcut["Update Video Library"]  = array("cmd" => 'vidscan');
          $shortcut["Clean Video Library"]   = array("xbmcsend" => 'CleanLibrary(video)'); 
          $shortcut["Update Audio Library"]  = array("json" => '{"jsonrpc": "2.0", "method": "AudioLibrary.ScanForContent", "id" : 1 }');
          $shortcut["MediaFrontPage Forum"]  = "http://forum.xbmc.org/showthread.php?t=83304&goto=newpost";
*/
					
          $shortcut;
          $x = $Config->get('CONTROL');
          $array;
          if(!empty($x)){
              foreach ($x as $k => $e){
                  parse_str($e, $array);
                  $k = str_ireplace('_', ' ', $k);
                  $shortcut[urldecode($k)] = $array;
		          }
          }
					

                              // Hard Drive Section //

//***********************************************************************************//
//      Adding your drives to MFP is different, depending on the OS your using       //
//                                                                                   //
//          Examples                                                                 //
//          ========                                                                 //
//          $drive["USB"]     = "/Volumes/USB_NAME";      applies for Mac OS         //
//          $drive["Sata 1"]  = "/media/sata1/";          applies for Linux OS       //
//          $drive["Sata 2"]  = "/media/sata2/";          applies for Linux OS       //
//          $drive["C Drive"] = "C:";                     applies for Windows OS     //
//          $drive["D Drive"] = "D:";                     applies for Windows OS     //
//***********************************************************************************//

          $drive;
          $x = $Config->get('HDD');
          if(!empty($x)){
              foreach ($x as $k=>$e){
                  $k = str_ireplace('_', ' ', $k);
                  $drive["$k"] = "$e";
		      		}
          }
                              // RSS Section //

//***********************************************************************************//
//     Ensure only RSS Feed URL's are used.                                          //
//     Ensure SabNZBd > Config > Index sites is set.                                 //
//     Supports cat, pp, script, priority as per the sabnzbd api.                    //
//***********************************************************************************//

/*
          $rssfeeds["MediaFrontPage on Github"]       = array("url" => "https://github.com/MediaFrontPage/mediafrontpage/commits/master.atom", "type" => "atom");
          $rssfeeds["NZBMatrix - TV Shows (DivX)"]    = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=6"     , "cat" => "tv");
          $rssfeeds["NZBMatrix - TV Shows (HD x264)"] = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=41"     , "cat" => "tv");
          $rssfeeds["NZBMatrix - Movies (DivX)"]      = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=2"     , "cat" => "movies");
          $rssfeeds["NZBMatrix - Movies (HD x264)"]   = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=42"     , "cat" => "movies");
          $rssfeeds["NZBMatrix - Music (MP3)"]        = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=22"     , "cat" => "music");
          $rssfeeds["NZBMatrix - Music (Lossless)"]   = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=23"     , "cat" => "music");
          $rssfeeds["NZBMatrix - Sports"]             = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=7"     , "cat" => "sports");
*/
          $rssfeeds;
          $x = $Config->get('RSS');
          if(!empty($x)){
              foreach ($x as $k => $e){
              		parse_str($e, $array);
              		/*
									$cat = (!empty($array['cat']))?$array['cat']:'';
              		$pp = (!empty($array['pp']))?$array['pp']:'';
              		$script = (!empty($array['script']))?$array['script']:'';
              		$priority = (!empty($array['priority']))?$array['priority']:'';
              		$type = (!empty($array['type']))?$array['type']:'';
              		*/
                  $k = str_ireplace('_', ' ', $k);
                  $rssfeeds[urldecode($k)] = $array;
		      		}
          }


                              // Custom Stylesheet Section //

//***********************************************************************************//
//     To have MFP use a different CSS use this.                                     //
//     Simply remove the // from the beginning of any line.                          //
//     Feel free to create your own and submit them for adding.                      //
//***********************************************************************************//

//$customStyleSheet = "css/lighttheme.css";
//$customStyleSheet = "css/comingepisodes-minimal-banner.css";
//$customStyleSheet = "css/comingepisodes-minimal-poster.css";
//$customStyleSheet = "css/black_velvet.css";
//$customStyleSheet = "css/hernandito.css";
         $customStyleSheet = 'css/'.$Config->get('ENABLED','MODS').'.css';

                              // Message Section //

//***********************************************************************************//
//     If there is only one XBMC instance, this can be ignored as the widget will    //
//     use the same info as the one set on the XBMC Section                          //
//     Otherwise add them like this:                                                 //
//          $xbmcMessages['Title']   = "http://localhost:8080/";                     //
//          $xbmcMessages['EXAMPLE'] = "http://USERNAME:PASSWORD@IP:PORT/";          //
//***********************************************************************************//
          
          $xbmcMessages;
          $x = $Config->get('MESSAGE');
          if(!empty($x)){
              foreach ($x as $k=>$e){
                  $k = str_ireplace('_', ' ', $k);
                  $xbmcMessages["$k"] = "$e";
		      		}
          }

                              // Security //

//***********************************************************************************//
//      Only set the $mfpsecured variable to true if you have secured                //
//      MediaFrontPage with a password via .htaccess or some other method            //
//      use at your own risk as this can create a security vulnerability in          //
//      the wControl widget.                                                         //
//***********************************************************************************//

     $mfpsecured = filter_var($Config->get('mfpsecured','SECURITY'), FILTER_VALIDATE_BOOLEAN);

// Alternatively you can set a unique key here. //
     $mfpapikey = $Config->get('mfpapikey','SECURITY');

                 //XBMC MySQL Connections EXPERIMENTAL!//
                            //DO NOT USE YET//
//***********************************************************************************//
//     Set this if you use a centralised MySQL Database.                             //
//     Further information about this is available on the XBMC Forum and MFP Thread  //
//***********************************************************************************//
//                                                                                   //
//$xbmcdbconn = array(                                                               //
//          'video' => array(                                                        //
//               'dns' => 'mysql:host=hostname;dbname=videos',                       //
//               'username' => '',                                                   //
//               'password' => '',                                                   //
//               'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")//
//          ),                                                                       //
//          'music' => array(                                                        //
//               'dns' => 'mysql:host=hostname;dbname=music',                        //
//               'username' => 'username',                                           //
//               'password' => 'password',                                           //
//               'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")//
//          ),                                                                       //
//     );                                                                            //
//***********************************************************************************//

//*****************************//
//          THE END!!!!        //
//*****************************//

//*****************************//
//IGNORE FROM THIS PART ONWARDS//
//*****************************//
if($GLOBAL_MACHINE)
{
     //XBMC Global Settings//
     if(empty($XBMC_IP) && !empty($XBMC_PORT)){
          $XBMC_IP = $GLOBAL_IP;
     }
     //SickBeard Global Settings//
     if(empty($SICKBEARD_IP) && !empty($SICKBEARD_PORT)){
          $SICKBEARD_IP = $GLOBAL_IP;          
     }
     //SabNZBd+ Global Settings//
     if(empty($SABNZBD_IP) && !empty($SABNZBD_PORT)){
          $SABNZBD_IP = $GLOBAL_IP;
     }
     //CouchPotato Global Settings//
     if(empty($COUCHPOTATO_IP) && !empty($COUCHPOTATO_PORT)){
          $COUCHPOTATO_IP = $GLOBAL_IP;
     }
     //uTorrent Global Settings//
     if(empty($uTORRENT_IP) && !empty($uTORRENT_PORT)){
          $uTORRENT_IP = $GLOBAL_IP;
     }
     //jDownloader Global Settings//
     if(empty($JDOWNLOADER_IP) && !empty($JDOWNLOADER_WEBPORT)){
          $JDOWNLOADER_IP = $GLOBAL_IP;
     }
     //Transmission Global Settings//
     if(empty($TRANSMISSION_IP) && !empty($TRANSMISSION_PORT)){
          $TRANSMISSION_IP = $GLOBAL_IP;
     }
}
//Authentication Global Settings//
if(empty($AUTH_USERNAME)||empty($AUTH_PASS)){
  $AUTH_USERNAME = $GLOBAL_USER;
  $AUTH_PASS     = $GLOBAL_PASS;
}
if($GLOBAL_USER_PASS){
  if(empty($XBMC_USERNAME) && empty($XBMC_PASS)){
    $XBMC_USERNAME = $GLOBAL_USER;
    $XBMC_PASS     = $GLOBAL_PASS;
  }
  if(empty($TRANSMISSION_USERNAME) && empty($TRANSMISSION_PASS)){
    $TRANSMISSION_USERNAME = $GLOBAL_USER;
    $TRANSMISSION_PASS     = $GLOBAL_PASS;
  }
  if(empty($JDOWNLOADER_USERNAME) && empty($JDOWNLOADER_PASS)){
    $JDOWNLOADER_USERNAME = $GLOBAL_USER;
    $JDOWNLOADER_PASS     = $GLOBAL_PASS;
  }
  if(empty($uTORRENT_USERNAME) && empty($uTORRENT_PASS)){
    $uTORRENT_USERNAME = $GLOBAL_USER;
    $uTORRENT_PASS     = $GLOBAL_PASS;
  }
  if(empty($COUCHPOTATO_USERNAME)||empty($COUCHPOTATO_PASS)){
    $COUCHPOTATO_USERNAME = $GLOBAL_USER;
    $COUCHPOTATO_PASS     = $GLOBAL_PASS;
  }

  if(empty($SABNZBD_USERNAME) && empty($SABNZBD_PASS)){
    $SABNZBD_USERNAME = $GLOBAL_USER;
    $SABNZBD_PASS     = $GLOBAL_PASS;
  }
  if(empty($SICKBEARD_USERNAME) && empty($SICKBEARD_PASS)){
    $SICKBEARD_USERNAME = $GLOBAL_USER;
    $SICKBEARD_PASS     = $GLOBAL_PASS;
  }
}





$xbmclogin              = (!empty($XBMC_USERNAME)&&!empty($XBMC_PASS))?"$XBMC_USERNAME:$XBMC_PASS@":"";
$sickbeardlogin         = (!empty($SICKBEARD_USERNAME)&&!empty($SICKBEARD_PASS))?"$SICKBEARD_USERNAME:$SICKBEARD_PASS@":"";
$SABNZBDlogin           = (!empty($SABNZBD_USERNAME)&&!empty($SABNZBD_PASS))?"$SABNZBD_USERNAME:$SABNZBD_PASS@":"";
$COUCHPOTATOlogin       = (!empty($COUCHPOTATO_USERNAME)&&!empty($COUCHPOTATO_PASS))?"$COUCHPOTATO_USERNAME:$COUCHPOTATO_PASS@":"";
$uTorrentlogin          = (!empty($uTORRENT_USERNAME)&&!empty($uTORRENT_PASS))?"$uTORRENT_USERNAME:$uTORRENT_PASS@":"";
$TRANSMISSIONlogin      = (!empty($TRANSMISSION_USERNAME)&&!empty($TRANSMISSION_PASS))?"$TRANSMISSION_USERNAME:$TRANSMISSION_PASS@":"";
$JDOWNLOADERlogin       = (!empty($JDOWNLOADER_USERNAME)&&!empty($JDOWNLOADER_PASS))?"$JDOWNLOADER_USERNAME:$JDOWNLOADER_PASS@":"";

$transmission_admin     = $TRANSMISSION_USERNAME;
$transmission_pass      = $TRANSMISSION_PASS;     
$nzbusername            = $NZBMATRIX_USERNAME;
$nzbapi                 = $NZBMATRIX_API;
$nzbsuapi               = $NZBSU_API;
$nzbsudl                = $NZB_DL;
$sabapikey              = $SABNZBD_API;
$trakt_api              = $TRAKT_API;
$trakt_username         = $TRAKT_USERNAME;
$trakt_password         = $TRAKT_PASSWORD;
$authsecured            = $AUTH_ON;
$authusername           = $AUTH_USERNAME;
$authpassword           = $AUTH_PASS;

//   Reverse Proxy section    //
if($REVERSE_PROXY){
	if(!empty($XBMC_WEBROOT)){
		$xbmcjsonservice = 'http://'.$xbmclogin.$GLOBAL_IP.'/'.$XBMC_WEBROOT.'/jsonrpc';
		$xbmcimgpath     = 'http://'.$xbmclogin.$GLOBAL_IP.'/'.$XBMC_WEBROOT.'/vfs/';
	}
	if(!empty($SICKBEARD_WEBROOT)){
		$sickbeardcomingepisodes = 'http://'.$sickbeardlogin.$GLOBAL_IP.'/'.$SICKBEARD_WEBROOT.'/comingEpisodes';
		$sickbeardurl = 'http://'.$sickbeardlogin.$GLOBAL_IP.'/'.$SICKBEARD_WEBROOT.'/home/';
	}
	if(!empty($COUCHPOTATO_WEBROOT)){
		$cp_url = 'http://'.$COUCHPOTATOlogin.$GLOBAL_IP.'/'.$COUCHPOTATO_WEBROOT.'/';
	}
	if(!empty($UTORRENT_WEBROOT)){
		$utorrent_url = 'http://'.$uTorrentlogin.$UTORRENT_IP.'/'.$UTORRENT_WEBROOT.'/';
	}
	if(!empty($SABNZBD_WEBROOT)){
		$saburl = 'http://'.$SABNZBDlogin.$GLOBAL_IP.'/'.$SABNZBD_WEBROOT.'/';
	}
	if(!empty($TRANSMISSION_WEBROOT)){
		$transmission_url = 'http://'.$GLOBAL_IP.'/'.$TRANSMISSION_WEBROOT.'/rpc/';
		$transmission_web = 'http://'.$GLOBAL_IP.'/'.$TRANSMISSION_WEBROOT;
	}
	if(!empty($JDOWNLOADER_WEBROOT)){
		$jd_weburl = 'http://'.$JDOWNLOADERlogin.$GLOBAL_IP.'/'.$JDOWNLOADER_WEBROOT.'/';
	}
} else {
   $xbmcjsonservice        = "http://$xbmclogin"."$XBMC_IP:$XBMC_PORT/jsonrpc";
   $xbmcimgpath            = "http://$xbmclogin"."$XBMC_IP:$XBMC_PORT/vfs/";
   $sickbeardcomingepisodes= "http://$sickbeardlogin"."$SICKBEARD_IP:$SICKBEARD_PORT/comingEpisodes/";
   $sickbeardurl           = "http://$sickbeardlogin"."$SICKBEARD_IP:$SICKBEARD_PORT/home/";
   $saburl                 = "http://$SABNZBDlogin"."$SABNZBD_IP:$SABNZBD_PORT/";
   $cp_url                 = "http://$COUCHPOTATOlogin"."$COUCHPOTATO_IP:$COUCHPOTATO_PORT/";
   $utorrent_url           = "http://$uTorrentlogin"."$uTORRENT_IP:$uTORRENT_PORT/gui/";
   $jd_url                 = "http://$JDOWNLOADERlogin"."$JDOWNLOADER_IP:$JDOWNLOADER_REMOTEPORT/";
   $jd_weburl              = "http://$JDOWNLOADER_IP:$JDOWNLOADER_WEBPORT/";
   $transmission_url       = "http://$TRANSMISSION_IP:$TRANSMISSION_PORT/transmission/rpc";     
   $transmission_web       = "http://$TRANSMISSIONlogin"."$TRANSMISSION_IP:$TRANSMISSION_PORT/transmission/web/";     
}
if ($authsecured && session_id()=='') session_start();
?>	