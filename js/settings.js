$(document).ready(function() {
	var $panels = $('#slider .scrollContainer > div');
	var $container = $('#slider .scrollContainer'); // if false, we'll float all the panels left and fix the width 
	// of the container
	var horizontal = true; // float the panels left if we're going horizontal
	if (horizontal) {
		$panels.css({
			'float': 'left',
			'position': 'relative' // IE fix to ensure overflow is hidden
		}); // calculate a new width for the container (so it holds all panels)
		$container.css('width', $panels[0].offsetWidth * $panels.length);
	} // collect the scroll object, at the same time apply the hidden overflow
	// to remove the default scrollbars that will appear
	var $scroll = $('#slider .scroll').css('overflow', 'hidden'); // handle nav selection


	function selectNav() {
		$(this).parents('ul:first').find('a').removeClass('selected').end().end().addClass('selected');
	}
	$('#slider .navigation').find('a').click(selectNav); // go find the navigation link that has this target and select the nav


	function trigger(data) {
		var el = $('#slider .navigation').find('a[href$="' + data.id + '"]').get(0);
		selectNav.call(el);
	}
	if (window.location.hash) {
		trigger({
			id: window.location.hash.substr(1)
		});
	} else {
		$('ul.navigation a:first').click();
	} // offset is used to move to *exactly* the right place, since I'm using
	// padding on my example, I need to subtract the amount of padding to
	// the offset.  Try removing this to get a good idea of the effect
	var offset = parseInt((horizontal ? $container.css('paddingTop') : $container.css('paddingLeft')) || 0) * -1;
	var scrollOptions = {
		target: $scroll,
		// the element that has the overflow
		// can be a selector which will be relative to the target
		items: $panels,
		navigation: '.navigation a',
		// allow the scroll effect to run both directions
		axis: 'xy',
		onAfter: trigger,
		// our final callback
		offset: offset,
		// duration of the sliding effect
		duration: 500,
		// easing - can be used with the easing plugin: 
		// http://gsgd.co.uk/sandbox/jquery/easing/
		easing: 'swing'
	}; // apply serialScroll to the slider - we chose this plugin because it 
	// supports// the indexed next and previous scroll along with hooking 
	// in to our navigation.
	$('#slider').serialScroll(scrollOptions); // now apply localScroll to hook any other arbitrary links to trigger 
	// the effect
	$.localScroll(scrollOptions); // finally, if the URL has a hash, move the slider in to position, 
	// setting the duration to 1 because I don't want it to scroll in the
	// very first page load.  We don't always need this, but it ensures
	// the positioning is absolutely spot on when the pages loads.
	scrollOptions.duration = 1;
	$.localScroll.hash(scrollOptions);
});

function updateSettings(section) {
	var contents = document.getElementById(section).getElementsByTagName('input'); //$("#result").html(contents);
	var params = 'section=' + section;
	for (i = 0; i < contents.length; i++) { //alert(contents[i].name+'='+contents[i].value);
		var value = contents[i].value;
		if (contents[i].type == 'checkbox') {
			if (contents[i].value == 'on') {
				value = 'true';
			} else {
				value = 'false';
			}
			params = params + '&' + contents[i].name + '=' + value;
		} else if (contents[i].type == 'radio') {
			var name = contents[i].name;
			while (contents[i].type == 'radio') {
				if (contents[i].checked && contents[i].name == name) { //alert(contents[i].name+' '+contents[i].value);
					value = contents[i].value;
					params = params + '&' + contents[i].name + '=' + encodeURIComponent(value);
				}
				i++;
			}
			i--;
		} else if (contents[i].name != '') {
			params = params + '&' + contents[i].name + '=' + encodeURIComponent(value);
		}
	} 
	ajaxRequest(params);
}

function updateAlternative(section) {
	var contents = document.getElementById(section).getElementsByTagName('input');
	var params = 'section=' + section;
	for (i = 0; i < contents.length; i++) {
		if (contents[i].name == 'TITLE' && contents[i].value !='') {
			params = params + '&' + escape(contents[i++].value) + '=' + encodeURIComponent(contents[i].value);
		}
	}
	ajaxRequest(params);
}

function ajaxRequest(params){
	//alert(params);
	$.ajax({
		type: 'GET',
		url: "settings.php?" + params,
		success: function(data) { // successful request; do something with the data
			if(data == 1){
				alert('Settings saved.');
			} else {
				alert("An error occured please try again or contact the developers.\n Error: "+data);
			}
		},
		error: function() { // failed request; give feedback to user
			alert("Error saving settings.");
		}
	});
}

function addRowToTable(section, size1, size2) {
	var tbl = document.getElementById('table_' + section);
	var lastRow = tbl.rows.length; // if there's no header row in the table, then iteration = lastRow + 1
	var iteration = lastRow;
	var row = tbl.insertRow(lastRow); // left cell
	var cellLeft = row.insertCell(0);
	var el = document.createElement('input');
	el.type = 'text';
	el.name = 'TITLE';
	el.size = size1;
	cellLeft.appendChild(el); // select cell
	var cellRightSel = row.insertCell(1);
	var sel = document.createElement('input');
	sel.name = 'VALUE';
	sel.type = 'text';
	sel.size = size2;
	cellRightSel.appendChild(sel);
}
function removeRowToTable(section) {
	var tbl = document.getElementById('table_' + section);
	var lastRow = tbl.rows.length;
	if (lastRow > 1) tbl.deleteRow(lastRow - 1);
}
function saveAll() {
	var i = 0;
	while (i < tabs.length) {
		updateSettings(tabs[i]);
		alert(tabs[i] + ' saved');
		i++;
	}
}
