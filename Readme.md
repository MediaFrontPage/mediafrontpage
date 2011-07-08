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

## CSS Skins Available
###Original
![preview thumb](http://img638.imageshack.us/img638/3479/originalls.jpg)

###Light Theme
![preview thumb](http://img8.imageshack.us/img8/3285/lighttheme.jpg)

###Hernandito (XBMC Member Hernandito)
![preview thumb](http://img21.imageshack.us/img21/9685/herandito.jpg)

###DPickles (XBMC Member DPickles)
![preview thumb](http://img198.imageshack.us/img198/2333/dpickles.jpg)

###Black Glass Modern (XBMC Member DejaVu)
![preview thumb](http://img135.imageshack.us/img135/7222/blackmodernglass.jpg)

## Dependencies

MediaFrontPage requires aa Apache/PHP Webserver to be running on the machine or network and must have PHP Curl configured correctly.


## Bugs

This project is always being updated by like minded individuals and bugs will exist. If you find a bug, please report it at [XBMC Support Thread] (http://forum.xbmc.org/showthread.php?t=8330), and include as much information as possible.

## Install
###Ubuntu Commandline/XBMCLive

1 - SSH or Telnet into XBMCLive - or simply press CTRL F2 and login with you user details.

2 - Clone the Git to the required directory, XBMCLive = /var/www.

sudo git clone git://github.com/gugahoi/mediafrontpage.git "/var/www"

3 - Open default-config.php with gedit or nano and edit appropriately

sudo nano /var/www/default-config.php

4 - Rename default-config.php to config.php

sudo mv /var/www/default-config.php /var/www/config.php

5 - Rename default-layout.php to layout.php

sudo mv /var/www/default-layout.php /var/www/layout.php

6 - Ensure file permissions allow web server to write to layout.php eg use chmod

sudo chmod 777 /var/www/layout.php

7 - Install PHP-Curl

sudo apt-get install php5-curl


Optional
--------
8 - Sickbeard image cache to speed up image loading times.

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
* TrakT Last Watched
* Transmission
* uTorrent
* JDownloader (WIP)

There is an Example widget inside the Widget folder that gives an idea on how to create your own.