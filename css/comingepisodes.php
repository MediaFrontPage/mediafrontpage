<?php
require_once "../config.php";
header("Content-type: text/css"); 


?><?php
// Banner 1 
// Poster 2
// Default 3

if ( $ceview == "1" )
{ 
			 echo ( "
			 
			 	div#header, #MainMenu, #SubMenu, .h2footer, .footer, .plotInfo, img.ep_summaryTrigger {
		display: none !important; \n
		visibility: hidden !important; \n
}

	div.ep_summary { 
		display: block !important; \n
		visibility: visible; \n !important; \n
		color: #666; \n !important; \n
		font-size: 12px !important; \n
}
	#comingepisodeswrapper, #insideWrapper  {
		/* max-height: 250px; \n */

	/* set max-width for using this widget on either side otherwise you can't see everything */
		/* max-width: 400px; \n */
}

	/* Remove border from images --needed for all 3 views */
    /* fix possible alignment issues */
    div.tvshowDiv > table tr td { width: 100%; \n }
	div.tvshowDiv > table tr th img, td > a > img{
		border:0 !important; \n
		margin:0 !important; \n
}



/* START - specific to LIST view */
	table#showListTable {
		width: 100% !important; \n
}

	/* fix list alignment problem */
		table#showListTable > tbody > tr > td, table#showListTable > thead > tr > th {
		text-align: left; \n
		padding-left: 10px; \n
}

	/* make it so that the tv show doesn't word wrap */
		table#showListTable > tbody > tr > td a {
		white-space:nowrap; \n
}
/* END - specific to LIST view */



/* START - specific to icon views */

	/* make the tv show w/icons look more like a title bar */
	div.tvshowDiv > table tr th {
		background-color: #333 !important; \n
		border-bottom: 1px solid #333 !important; \n
		background-color: transparent !important; \n
}

	/* centre align the tv show title */
	div.tvshowDiv > table tr th > span.tvshowTitle a{
		text-align: center !important; \n
		/* float: left !important; \n */
		padding: 3px 0px 4px !important; \n
		font-size: 16px !important; \n
		text-decoration: underline; \n
}

	/* right align the icons for the show */
	div.tvshowDiv > table tr th span.tvshowTitleIcons{
		text-align: right !important; \n
		float: right !important; \n
}

	div.tvshowDiv > table tr th span.tvshowTitleIcons img{
		height: 16px; \n
		width: 16px; \n
		padding: 2px 2px 0px !important; \n
}
	/* remove the Next Episode: / Airs: */
	div.tvshowDiv > table tr td > span.title {
		display: none!important; \n
}

	/* remove the styling for the th that holds the banner image */
	div.tvshowDiv > table > tbody > tr > th.nobg {
		border:0 !important; \n
		background:none !important; \n
		height: 1px !important; \n
		text-align:center; \n
}

	.bannerThumb {
		height: 70px !important; \n
		width: 100% !important; \n
		padding-bottom: 2px; \n
        box-shadow: 3px 3px 3px #000; \n
}

	.posterThumb {
		width: 102px !important; \n
		height: 150px !important; \n
		padding: 0px 5px 5px 0px; \n
		float:left; \n
}

	/* adjust the ep #x## - title */
	div.tvshowDiv > table > tbody > tr > td.next_episode {
		text-align: left !important; \n
		font-size: 15px; \n
		font-weight: bold; \n
		display: hidden; \n
		padding-top: 3px; \n
		padding-bottom: 3px; \n
}

	/* adjust the ep summary/air text */
	div.tvshowDiv > table > tbody > tr > td span {
		display: inline; \n
		visibility: visible; \n
		color: #666; \n
}

	/* crude hack to get rid of the [] for the quality and add spacing after tvshow */
	div.tvshowDiv > table > tbody > tr > td {
		text-align: left !important; \n
		visibility: hidden; \n
		padding-bottom: 10px; \n
}

	/* use the line breaks as visual seperation of elements */
	br { 
	
	/* seperate each block by some spacing */
		display: inline; \n

	/* merge the airdate with summary */
		display: none; \n /* looks best for all 3 views */
}

	#main #wComingEpisodes.widget .widget-content {
		max-height:96%; \n
	
	/* show vertical scrollbar only on overflow */
		overflow-x:hidden; \n
		overflow-y:hidden; \n
}

	/* not sure what this is for, pulled it from comingepisodes.css */
	#wComingEpisodes h1, #wComingEpisodes iframe {
		display     : none !important; \n
		visibility  : hidden; \n
		height      : 0px; \n
}
	a.highslide img.bannerThumb, a.highslide img.posterThumb {
		border: 1px solid #fff; \n
}
div#comingepisodes_widget{
	height: 100%; \n
}

	#main #wComingEpisodes.widget .widget-content {
		max-height:46%; \n
}
	/* centre align the tv show title */
	div.tvshowDiv > table tr th > span.tvshowTitle a{
		display: none; \n
		visibility: hidden; \n

}
	div.tvshowDiv > table tr th span.tvshowTitleIcons img{
		display: none !important; \n
		padding: none !important; \n
}
	.bannerThumb {
		height: 70px !important; \n
		width: 100% !important; \n
		max-width: 300px; \n
}

	/* adjust the ep #x## - title */
	div.tvshowDiv > table > tbody > tr > td.next_episode {
		display: none; \n
		padding-top: none; \n
		padding-bottom: none; \n
}
	/* crude hack to get rid of the [] for the quality and add spacing after tvshow */
	div.tvshowDiv > table > tbody > tr > td {
		display: none; \n
		visibility: hidden; \n
		padding-bottom: 0px; \n
}
	/* not sure what this is for, pulled it from comingepisodes.css */
	#wComingEpisodes h1 {
		display: inline !important; \n
		visibility: visible !important; \n
		height: 10px !important; \n
}
	div#comingepisodes_widget{
		height: 50%; \n
		overflow: hidden; \n
}


			 
			 " );
    }
	
	if ( $ceview == "2" )
{ 
			 echo ( "

			 	div#header, #MainMenu, #SubMenu, .h2footer, .footer, .plotInfo, img.ep_summaryTrigger {
		display: none !important; \n
		visibility: hidden !important; \n
}

	div.ep_summary { 
		display: block !important; \n
		visibility: visible; \n !important; \n
		color: #666; \n !important; \n
		font-size: 12px !important; \n
}
	#comingepisodeswrapper, #insideWrapper  {
		/* max-height: 250px; \n */

	/* set max-width for using this widget on either side otherwise you can't see everything */
		/* max-width: 400px; \n */
}

	/* Remove border from images --needed for all 3 views */
    /* fix possible alignment issues */
    div.tvshowDiv > table tr td { width: 100%; \n }
	div.tvshowDiv > table tr th img, td > a > img{
		border:0 !important; \n
		margin:0 !important; \n
}



/* START - specific to LIST view */
	table#showListTable {
		width: 100% !important; \n
}

	/* fix list alignment problem */
		table#showListTable > tbody > tr > td, table#showListTable > thead > tr > th {
		text-align: left; \n
		padding-left: 10px; \n
}

	/* make it so that the tv show doesn't word wrap */
		table#showListTable > tbody > tr > td a {
		white-space:nowrap; \n
}
/* END - specific to LIST view */



/* START - specific to icon views */

	/* make the tv show w/icons look more like a title bar */
	div.tvshowDiv > table tr th {
		background-color: #333 !important; \n
		border-bottom: 1px solid #333 !important; \n
		background-color: transparent !important; \n
}

	/* centre align the tv show title */
	div.tvshowDiv > table tr th > span.tvshowTitle a{
		text-align: center !important; \n
		/* float: left !important; \n */
		padding: 3px 0px 4px !important; \n
		font-size: 16px !important; \n
		text-decoration: underline; \n
}

	/* right align the icons for the show */
	div.tvshowDiv > table tr th span.tvshowTitleIcons{
		text-align: right !important; \n
		float: right !important; \n
}

	div.tvshowDiv > table tr th span.tvshowTitleIcons img{
		height: 16px; \n
		width: 16px; \n
		padding: 2px 2px 0px !important; \n
}
	/* remove the Next Episode: / Airs: */
	div.tvshowDiv > table tr td > span.title {
		display: none!important; \n
}

	/* remove the styling for the th that holds the banner image */
	div.tvshowDiv > table > tbody > tr > th.nobg {
		border:0 !important; \n
		background:none !important; \n
		height: 1px !important; \n
		text-align:center; \n
}

	.bannerThumb {
		height: 70px !important; \n
		width: 100% !important; \n
		padding-bottom: 2px; \n
        box-shadow: 3px 3px 3px #000; \n
}

	.posterThumb {
		width: 102px !important; \n
		height: 150px !important; \n
		padding: 0px 5px 5px 0px; \n
		float:left; \n
}

	/* adjust the ep #x## - title */
	div.tvshowDiv > table > tbody > tr > td.next_episode {
		text-align: left !important; \n
		font-size: 15px; \n
		font-weight: bold; \n
		display: hidden; \n
		padding-top: 3px; \n
		padding-bottom: 3px; \n
}

	/* adjust the ep summary/air text */
	div.tvshowDiv > table > tbody > tr > td span {
		display: inline; \n
		visibility: visible; \n
		color: #666; \n
}

	/* crude hack to get rid of the [] for the quality and add spacing after tvshow */
	div.tvshowDiv > table > tbody > tr > td {
		text-align: left !important; \n
		visibility: hidden; \n
		padding-bottom: 10px; \n
}

	/* use the line breaks as visual seperation of elements */
	br { 
	
	/* seperate each block by some spacing */
		display: inline; \n

	/* merge the airdate with summary */
		display: none; \n /* looks best for all 3 views */
}

	#main #wComingEpisodes.widget .widget-content {
		max-height:96%; \n
	
	/* show vertical scrollbar only on overflow */
		overflow-x:hidden; \n
		overflow-y:hidden; \n
}

	/* not sure what this is for, pulled it from comingepisodes.css */
	#wComingEpisodes h1, #wComingEpisodes iframe {
		display     : none !important; \n
		visibility  : hidden; \n
		height      : 0px; \n
}
	a.highslide img.bannerThumb, a.highslide img.posterThumb {
		border: 1px solid #fff; \n
}
div#comingepisodes_widget{
	height: 100%; \n
}

	#main #wComingEpisodes.widget .widget-content {
		max-height:46%; \n
}
	/* centre align the tv show title */
	div.tvshowDiv > table tr th > span.tvshowTitle a{
		display: none; \n
}

	/* right align the icons for the show */
	div.tvshowDiv > table tr th span.tvshowTitleIcons{
		display: none; \n
		visibility: hidden; \n
}
	.posterThumb {
		width: 60px !important; \n
		height: 100px !important; \n
		padding: 0px; \n
		float:left; \n
}
	/* adjust the ep #x## - title */
	div.tvshowDiv > table > tbody > tr > td.next_episode {
		display: inline; \n
		padding-top: none; \n
		padding-bottom: none; \n
		font-size: smaller; \n
}
	/* crude hack to get rid of the [] for the quality and add spacing after tvshow */
	div.tvshowDiv > table > tbody > tr > td {
		display: none; \n
		visibility: hidden; \n
		padding-bottom: 0px; \n
}
		/* not sure what this is for, pulled it from comingepisodes.css */
	#wComingEpisodes h1 {
		display     : inline !important; \n
		visibility	: visible !important; \n
		height      : 0px; \n
}

	div#comingepisodes_widget {
	height: 50% !important; \n
	overflow: hidden; \n
}


			 
			 " );
    }
	
if ( $ceview == "3" )
{ 
			 echo ( "

			 	div#header, #MainMenu, #SubMenu, .h2footer, .footer, .plotInfo, img.ep_summaryTrigger {
		display: none !important; \n
		visibility: hidden !important; \n
}

	div.ep_summary { 
		display: block !important; \n
		visibility: visible; \n !important; \n
		color: #666; \n !important; \n
		font-size: 12px !important; \n
}
	#comingepisodeswrapper, #insideWrapper  {
		/* max-height: 250px; \n */

	/* set max-width for using this widget on either side otherwise you can't see everything */
		/* max-width: 400px; \n */
}

	/* Remove border from images --needed for all 3 views */
    /* fix possible alignment issues */
    div.tvshowDiv > table tr td { width: 100%; \n }
	div.tvshowDiv > table tr th img, td > a > img{
		border:0 !important; \n
		margin:0 !important; \n
}



/* START - specific to LIST view */
	table#showListTable {
		width: 100% !important; \n
}

	/* fix list alignment problem */
		table#showListTable > tbody > tr > td, table#showListTable > thead > tr > th {
		text-align: left; \n
		padding-left: 10px; \n
}

	/* make it so that the tv show doesn't word wrap */
		table#showListTable > tbody > tr > td a {
		white-space:nowrap; \n
}
/* END - specific to LIST view */



/* START - specific to icon views */

	/* make the tv show w/icons look more like a title bar */
	div.tvshowDiv > table tr th {
		background-color: #333 !important; \n
		border-bottom: 1px solid #333 !important; \n
		background-color: transparent !important; \n
}

	/* centre align the tv show title */
	div.tvshowDiv > table tr th > span.tvshowTitle a{
		text-align: center !important; \n
		/* float: left !important; \n */
		padding: 3px 0px 4px !important; \n
		font-size: 16px !important; \n
		text-decoration: underline; \n
}

	/* right align the icons for the show */
	div.tvshowDiv > table tr th span.tvshowTitleIcons{
		text-align: right !important; \n
		float: right !important; \n
}

	div.tvshowDiv > table tr th span.tvshowTitleIcons img{
		height: 16px; \n
		width: 16px; \n
		padding: 2px 2px 0px !important; \n
}
	/* remove the Next Episode: / Airs: */
	div.tvshowDiv > table tr td > span.title {
		display: none!important; \n
}

	/* remove the styling for the th that holds the banner image */
	div.tvshowDiv > table > tbody > tr > th.nobg {
		border:0 !important; \n
		background:none !important; \n
		height: 1px !important; \n
		text-align:center; \n
}

	.bannerThumb {
		height: 70px !important; \n
		width: 100% !important; \n
		padding-bottom: 2px; \n
        box-shadow: 3px 3px 3px #000; \n
}

	.posterThumb {
		width: 102px !important; \n
		height: 150px !important; \n
		padding: 0px 5px 5px 0px; \n
		float:left; \n
}

	/* adjust the ep #x## - title */
	div.tvshowDiv > table > tbody > tr > td.next_episode {
		text-align: left !important; \n
		font-size: 15px; \n
		font-weight: bold; \n
		display: hidden; \n
		padding-top: 3px; \n
		padding-bottom: 3px; \n
}

	/* adjust the ep summary/air text */
	div.tvshowDiv > table > tbody > tr > td span {
		display: inline; \n
		visibility: visible; \n
		color: #666; \n
}

	/* crude hack to get rid of the [] for the quality and add spacing after tvshow */
	div.tvshowDiv > table > tbody > tr > td {
		text-align: left !important; \n
		visibility: hidden; \n
		padding-bottom: 10px; \n
}

	/* use the line breaks as visual seperation of elements */
	br { 
	
	/* seperate each block by some spacing */
		display: inline; \n

	/* merge the airdate with summary */
		display: none; \n /* looks best for all 3 views */
}

	#main #wComingEpisodes.widget .widget-content {
		max-height:96%; \n
	
	/* show vertical scrollbar only on overflow */
		overflow-x:hidden; \n
		overflow-y:hidden; \n
}

	/* not sure what this is for, pulled it from comingepisodes.css */
	#wComingEpisodes h1, #wComingEpisodes iframe {
		display     : none !important; \n
		visibility  : hidden; \n
		height      : 0px; \n
}
	a.highslide img.bannerThumb, a.highslide img.posterThumb {
		border: 1px solid #fff; \n
}
div#comingepisodes_widget{
	height: 100%; \n
}




" );
    }
	?>