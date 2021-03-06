/*
 *      Copyright (C) 2005-2010 Team XBMC
 *      http://www.xbmc.org
 *
 *  This Program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2, or (at your option)
 *  any later version.
 *
 *  This Program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with XBMC; see the file COPYING.  If not, write to
 *  the Free Software Foundation, 675 Mass Ave, Cambridge, MA 02139, USA.
 *  http://www.gnu.org/copyleft/gpl.html
 *
 */

/* Global Paths */

var JSON_RPC = 'jsonrpc';
var DEFAULT_ALBUM_COVER = 'images/DefaultAlbumCover.png';
var DEFAULT_VIDEO_COVER = 'images/DefaultVideo.png';

/* Prototypes */

String.prototype.startsWith = function(prefix) {
	return this.indexOf(prefix) === 0;
}

String.prototype.endsWith = function(suffix) {
	return this.match(suffix + "$") == suffix;
}

function durationToString(duration) {
	if (!duration) {
		return '00:00';
	}
	minutes = Math.floor(duration / 60);
	hours = Math.floor(minutes / 60);
	minutes = minutes % 60;
	seconds = duration % 60;
	var result = '';
	if (hours) {
		result += (hours < 10 ? '0' + hours : hours) + ':';
	}
	result += (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds);
	return result;
}

function applyDeviceFixes() {
	document.addEventListener('touchmove', function(e){ e.preventDefault(); });
}

var commsErrorTimeout;

function displayCommunicationError(m) {
	clearTimeout(commsErrorTimeout);
	var message = m||'Connection to server lost';
	$('#commsErrorPanel').html(message).show();
	commsErrorTimeout = setTimeout('hideCommunicationError()', 5000);
}

function hideCommunicationError() {
	$('#commsErrorPanel').hide();
}
