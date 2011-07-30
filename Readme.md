#MediaFrontPage

MediaFrontPage is a HTPC Web Program Organiser.
Your HTPC utilises a number of different programs to do certain tasks. What MediaFrontPage does is creates a user specific web page that will be your nerve centre for everything you will need.

![preview thumb](http://img715.imageshack.us/img715/1564/screenshot20101118at120.png)

MediaFrontPage can make use of, but is not limited to, the following projects:

* Sick Beard
* CouchPotato
* SabNZBd+
* SubSonic
* Transmission (WebGUI)
* uTorrent (WebGUI)
* XBMC (WebGUI)
* JSON
* JQUERY

## Dependencies

MediaFrontPage requires an Apache/PHP Webserver to be running on the machine or network and must have PHP Curl configured correctly.

## Bugs

This project is always being updated by like minded individuals and bugs will exist. If you find a bug, please report it at [XBMC Support Thread] (http://forum.xbmc.org/showthread.php?t=8330), and include as much information as possible.

## Install
###Ubuntu Commandline/XBMCLive

1 - SSH or Telnet into you computer - or simply press CTRL F2 and login with you user details.

2 - Clone the Git to the required directory, XBMCLive and Ubuntu = /var/www.

sudo git clone git://github.com/MediaFrontPage/mediafrontpage.git "/var/www"

3 - Ensure file permissions allow web server to write to MFP's folder. CHMOD recursively.

sudo chmod 777 /var/www/ -R

4 - Browse to MFP and you shall be greeted with a server check to confirm all dependencies are met. If so, you will be allowed to continue to MFP's settings page to configure it according to your setup.

5 - Done!

Optional
--------
A.1 - Sickbeard image cache to speed up image loading times.

a) Create a folder named sbpcache 
 
sudo mkdir /var/www/sbpcache

b) Give MFP write permissions to the Cache folder

sudo chmod 777 /var/www/sbpcache

## List of available Widgets 5th May 2011

* XBMC Control
* XBMC Library
* Coming Episodes
* Hard Drive Status
* Now Playing
* RSS Feed
* SabNZBd Status
* NZB Search
* TrakT Recommendations
* Transmission
* uTorrent
* JDownloader (WIP)

There is an Example widget inside the Widget folder that gives an idea on how to create your own.