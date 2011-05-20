<?php
						/*Programs Section*/
//**************************************************************************//
//Titles are self explanatory. Do not include http://						//
//																			//
//Need to add the option for reverse proxies								//
//																			//
//$JDOWNLOADER_REMOTEPORT	-> port from RemoteControl Plugin				//
//$JDOWNLOADER_WEBPORT		-> port from Web plugin							//
//																			//
//																			//
//If most or all programs live in the same machine set	$GLOBAL_MACHINE		//
//to true and put all the info in the global variables. If one or two 		//
//programs live in a different computer, then insert the info in the 		//
//respective section and leave the ones that have the same info as GLOBAL 	//
//empty. If USERNAME/PASSWORD are the same for all programs set 			//
//$GLOBAL_USER_PASS	to true and put you global username and password.		//
//																			//
//																			//
//Variables that are always required										//
//All PORTS																	//
//All API's																	//
//**************************************************************************//
$GLOBAL_MACHINE			= false;
$GLOBAL_USER_PASS		= false;
$GLOBAL_IP				= '';
$GLOBAL_USER			= '';
$GLOBAL_PASS			= '';

/* XBMC Section*/
$XBMC_IP 				= '';
$XBMC_PORT 				= '';
$XBMC_USERNAME 			= '';
$XBMC_PASS 				= '';

/* SickBeard Section*/
$SICKBEARD_IP 			= '';
$SICKBEARD_PORT 		= '';
$SICKBEARD_USERNAME 	= '';
$SICKBEARD_PASS 		= '';

/* SABNZBD Section*/
$SABNZBD_IP 			= '';
$SABNZBD_PORT 			= '';
$SABNZBD_USERNAME 		= '';
$SABNZBD_PASS 			= '';
$SABNZBD_API			= '';

/* CouchPotato Section*/
$COUCHPOTATO_IP 		= '';
$COUCHPOTATO_PORT 		= '';
$COUCHPOTATO_USERNAME 	= '';
$COUCHPOTATO_PASS 		= '';

/* uTorrent Section*/
$uTorrent_IP 			= '';
$uTorrent_PORT 			= '';
$uTorrent_USERNAME 		= '';
$uTorrent_PASS 			= '';

/* jDownloader Section*/
$JDOWNLOADER_IP 		= '';
$JDOWNLOADER_REMOTEPORT	= '';
$JDOWNLOADER_WEBPORT	= '';
$JDOWNLOADER_USERNAME 	= '';
$JDOWNLOADER_PASS 		= '';

/* Transmission Section*/
$TRANSMISSION_IP 		= '';
$TRANSMISSION_PORT		= '';
$TRANSMISSION_USERNAME 	= '';
$TRANSMISSION_PASS 		= '';

							/*SEARCH WIDGET*/
//**************************************************************************//
//$NZBSU_API	->	http://nzb.su/profile									//		
//$NZB_DL		->	http://nzb.su/rss where it says "Add this				// 
//													string to your feed URL //
//													to allow NZB downloads	//
//													without logging in:"	//
//																			//
//$NZBMATRIX_API	->	http://nzbmatrix.com/account.php					//
//$preferredSearch	->	Set to 1 for NZBMatrix and 2 for nzb.su				//
//$preferredCategories 	->	Check README for a list of options. 			//
//							Make sure the option is for the appropriate site//
//																			//
//$trakt_api	->	http://trakt.tv/settings/api							//
//**************************************************************************//
$preferredSearch 	= '2';
$preferredCategories= '0';
//---------------------//
$NZBMATRIX_USERNAME	= '';
$NZBMATRIX_API		= '';
//---------------------//
$NZBSU_API 			= '';
$NZB_DL 			= '';
//---------------------//
$trakt_api 			= '';

							// NavBar Section //
//**************************************************************************//
//To open inline on MFP														//
//$navlink["Example"] = "http://example.com/";								//
//																			//
//To open in a blank page													//
//$navlink_blank["New Page"] = "http://google.com";							//
//																			//
//To populate the DropDown list												//
//$navselect["Title"] = "http://google.com";								//
//																			//
//																			//
//							SubMenu											//
//To open inline on MFP														//
//$subnavlink["Google"] = "http://google.com";								//
//																			//
//To open in a blank page													//
//$subnavlink_blank["Google"] = "http://google.com";						//
//																			//
//						EXAMPLES											//
//$navlink["TV Headend"] = "/tvheadend";									//
//$navlink["Transmission"] = "http://localhost:9091/transmission/web/";		//
//$navlink["uTorrent"] = "http://localhost:8081/gui/";						//
//$navlink["jDownloader"] = "http://localhost:8765/";						//
//**************************************************************************//
$navlink;
$navlink["XBMC"] 		= "http://localhost:8080";
$navlink["Sickbeard"] 	= "/sickbeard";
$navlink["Couch Potato"]= "/couchpotato";
$navlink["Sabnzbd"] 	= "/sabnzbd";

							// Control Section	//
//**************************************************************************//
//Options:																	//
//cmd 																		//
//xbmcsend																	//
//json																		//
// Optionally add 															//
//'host' => 'localhost', 													//
//'port' => 9777 to connect to a different machine.							//
//INCOMPLETE INFO --->>	NEED TO COMPLETE THIS!								//
//**************************************************************************//
$shortcut;
$shortcut["Shutdown XBMC"]				= array("cmd" => 'shutdown');
$shortcut["Update XBMC Video Library"] 	= array("cmd" => 'vidscan');
$shortcut["Clean XBMC Video Library"] 	= array("xbmcsend" => 'CleanLibrary(video)'); 
$shortcut["Update XBMC Audio Library"] 	= array("json" => '{"jsonrpc": "2.0", "method": "AudioLibrary.ScanForContent", "id" : 1 }');
$shortcut["MediaFrontPage Forum"] 		= "http://forum.xbmc.org/showthread.php?t=83304&goto=newpost";

						//	Hard Drive Section	//
//**************************************************************************//
//$drive["USB"] 	= "/Volumes/USB_NAME"; 	applies for Mac OS				//
//$drive["Sata 1"] 	= "/media/sata1/";		applies for Linux OS			//
//$drive["Sata 2"] 	= "/media/sata2/";		applies for Linux OS			//
//$drive["C Drive"] = "C:";					applies for Windows OS			//
//$drive["D Drive"] = "D:";					applies for Windows OS			//
//**************************************************************************//
$drive;
$drive["/"] = "/";


							// RSS Section //
//**************************************************************************//
//Ensure sabnzbd > config > index sites is set. 							//
//Supports cat, pp, script, priority as per the sabnzbd api.				//
//**************************************************************************//
$rssfeeds["NZBMatrix - TV Shows (DivX)"]    = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=6"	, "cat" => "tv");
$rssfeeds["NZBMatrix - TV Shows (HD x264)"] = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=41"	, "cat" => "tv");
$rssfeeds["NZBMatrix - Movies (DivX)"]      = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=2"	, "cat" => "movies");
$rssfeeds["NZBMatrix - Movies (HD x264)"]   = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=42"	, "cat" => "movies");
$rssfeeds["NZBMatrix - Music (MP3)"]        = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=22"	, "cat" => "music");
$rssfeeds["NZBMatrix - Music (Lossless)"]   = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=23"	, "cat" => "music");
$rssfeeds["NZBMatrix - Sports"]             = array("url" => "http://rss.nzbmatrix.com/rss.php?subcat=7"	, "cat" => "sports");
$rssfeeds["MediaFrontPage on Github"]       = array("url" => "https://github.com/MediaFrontPage/mediafrontpage/commits/master.atom", "type" => "atom");

						// Custom Stylesheet Section //
//**************************************************************************//
//To have MFP use a different CSS use this:									//
//																			//
//$customStyleSheet = "css/lighttheme.css";									//
//$customStyleSheet = "css/comingepisodes-minimal-banner.css";				//
//**************************************************************************//

						/*	Message Section	*/
//**************************************************************************//
//If there is only one XBMC instace, this can be ignored as the widget will //
//use the same info as the one set on the XBMC Section						//
//Otherwise add them like this:												//
//$xbmcMessages['Title']  = "http://localhost:8080/";						//
//$xbmcMessages['EXAMPLE'] = "http://USERNAME:PASSWORD@IP:PORT/";			//
//**************************************************************************//
$xbmcMessages;


							// Security	//
//**************************************************************************//
// Only set the $mfpsecured variable to true if you have secured			//
// MediaFrontPage with a password via .htaccess or some other method		//
// use at your own risk as this can create a security vulnerability in		//
// the wControl widget.														//
//**************************************************************************//
$mfpsecured = false;

// Alternativly you can set a unique key here. //
$mfpapikey = '';

						//Example of XBMC mysql connections//
//**********************************************************************************//
//$xbmcdbconn = array(																//
//		'video' => array(															//
//			'dns' => 'mysql:host=hostname;dbname=videos',							//
//			'username' => '',														//
//			'password' => '',														//
//			'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")	//
//		),																			//
//		'music' => array(															//
//			'dns' => 'mysql:host=hostname;dbname=music',							//
//			'username' => 'username',												//
//			'password' => 'password',												//
//			'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")	//
//		),																			//
//	);																				//
//**********************************************************************************//


//*****************************//
//IGNORE FROM THIS PART ONWARDS//
//*****************************//
if($GLOBAL_MACHINE)
{
	//XBMC Global Settings//
	if(empty($XBMC_IP) && !empty($XBMC_PORT)){
		$XBMC_IP = $GLOBAL_IP;
	}
	if($GLOBAL_USER_PASS && empty($XBMC_USERNAME) && empty($XBMC_PASS)){
		$XBMC_USERNAME = $GLOBAL_USER;
		$XBMC_PASS	   = $GLOBAL_PASS;
	}
	//SickBeard Global Settings//
	if(empty($SICKBEARD_IP) && !empty($SICKBEARD_PORT)){
		$SICKBEARD_IP = $GLOBAL_IP;		
	}
	if($GLOBAL_USER_PASS && empty($SICKBEARD_USERNAME) && empty($SICKBEARD_PASS)){
		$SICKBEARD_USERNAME = $GLOBAL_USER;
		$SICKBEARD_PASS = $GLOBAL_PASS;
	}
	//SabNZBd+ Global Settings//
	if(empty($SABNZBD_IP) && !empty($SABNZBD_PORT)){
		$SABNZBD_IP = $GLOBAL_IP;
	}
	if($GLOBAL_USER_PASS && empty($SABNZBD_USERNAME)||empty($SABNZBD_PASS)){
		$SABNZBD_USERNAME = $GLOBAL_USER;
		$SABNZBD_PASS	=	$GLOBAL_PASS;
	}
	//CouchPotato Global Settings//
	if(empty($COUCHPOTATO_IP) && !empty($COUCHPOTATO_PORT)){
		$COUCHPOTATO_IP = $GLOBAL_IP;
	}
	if($GLOBAL_USER_PASS && empty($COUCHPOTATO_USERNAME)||empty($COUCHPOTATO_PASS)){
		$COUCHPOTATO_USERNAME = $GLOBAL_USER;
		$COUCHPOTATO_PASS	=	$GLOBAL_PASS;
	}
	//uTorrent Global Settings//
	if(empty($uTorrent_IP) && !empty($uTorrent_PORT)){
		$uTorrent_IP = $GLOBAL_IP;
	}
	if($GLOBAL_USER_PASS && empty($uTorrent_USERNAME)||empty($uTorrent_PASS)){
		$uTorrent_USERNAME = $GLOBAL_USER;
		$uTorrent_PASS	=	$GLOBAL_PASS;
	}
	//jDownloader Global Settings//
	if(empty($JDOWNLOADER_IP) && !empty($JDOWNLOADER_WEBPORT)){
		$JDOWNLOADER_IP = $GLOBAL_IP;
	}
	if($GLOBAL_USER_PASS && empty($JDOWNLOADER_USERNAME)||empty($JDOWNLOADER_PASS)){
		$JDOWNLOADER_USERNAME = $GLOBAL_USER;
		$JDOWNLOADER_PASS	=	$GLOBAL_PASS;
	}
	//Transmission Global Settings//
	if(empty($TRANSMISSION_IP) && !empty($TRANSMISSION_PORT)){
		$TRANSMISSION_IP = $GLOBAL_IP;
	}
	if($GLOBAL_USER_PASS && empty($TRANSMISSION_USERNAME)||empty($TRANSMISSION_PASS)){
		$TRANSMISSION_USERNAME = $GLOBAL_USER;
		$TRANSMISSION_PASS	=	$GLOBAL_PASS;
	}
}
$xbmclogin				= (!empty($XBMC_USERNAME)&&!empty($XBMC_PASS))?"$XBMC_USERNAME:$XBMC_PASS@":"";
$xbmcjsonservice 		= "http://$xbmclogin"."$XBMC_IP:$XBMC_PORT/jsonrpc";
$xbmcimgpath 			= "http://$xbmclogin"."$XBMC_IP:$XBMC_PORT/vfs/";
$sickbeardlogin			= (!empty($SICKBEARD_USERNAME)&&!empty($SICKBEARD_PASS))?"$SICKBEARD_USERNAME:$SICKBEARD_PASS@":"";
$sickbeardcomingepisodes= "http://$sickbeardlogin"."$SICKBEARD_IP:$SICKBEARD_PORT/comingEpisodes/";
$sickbeardurl 			= "http://$sickbeardlogin"."$SICKBEARD_USERNAME:$SICKBEARD_PASS@$SICKBEARD_IP:$SICKBEARD_PORT/home/";
$SABNZBDlogin			= (!empty($SABNZBD_USERNAME)&&!empty($SABNZBD_PASS))?"$SABNZBD_USERNAME:$SABNZBD_PASS@":"";
$saburl 				= "http://$SABNZBDlogin"."$SABNZBD_IP:$SABNZBD_PORT/";
$COUCHPOTATOlogin		= (!empty($COUCHPOTATO_USERNAME)&&!empty($COUCHPOTATO_PASS))?"$COUCHPOTATO_USERNAME:$COUCHPOTATO_PASS@":"";
$cp_url 				= "http://$COUCHPOTATOlogin"."$COUCHPOTATO_IP:$COUCHPOTATO_PORT/";
$uTorrentlogin			= (!empty($uTorrent_USERNAME)&&!empty($uTorrent_PASS))?"$uTorrent_USERNAME:$uTorrent_PASS@":"";
$utorrent_url 			= "http://$uTorrentlogin"."$uTorrent_IP:$uTorrent_PORT/";
$JDOWNLOADERlogin		= (!empty($JDOWNLOADER_USERNAME)&&!empty($JDOWNLOADER_PASS))?"$JDOWNLOADER_USERNAME:$JDOWNLOADER_PASS@":"";
$jd_url 				= "http://$JDOWNLOADERlogin"."$JDOWNLOADER_IP:$JDOWNLOADER_REMOTEPORT/";
$jd_weburl				= "http://$JDOWNLOADER_IP:$JDOWNLOADER_WEBPORT/";
$TRANSMISSIONlogin		= (!empty($TRANSMISSION_USERNAME)&&!empty($TRANSMISSION_PASS))?"$TRANSMISSION_USERNAME:$TRANSMISSION_PASS@":"";
$transmission_url 		= "http://$TRANSMISSION_IP:$TRANSMISSION_PORT/transmission/rpc";	
$transmission_web 		= "http://$TRANSMISSIONlogin"."$TRANSMISSION_IP:$TRANSMISSION_PORT/transmission/web/";	
$transmission_admin		= $TRANSMISSION_USERNAME;
$transmission_pass 		= $TRANSMISSION_PASS;	
$nzbusername 			= $NZBMATRIX_USERNAME;
$nzbapi 				= $NZBMATRIX_API;
$nzbsuapi 				= $NZBSU_API;
$nzbsudl				= $NZB_DL;
?>

