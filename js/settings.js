$(function () {
	// Dock initialize
	$('#dock').Fisheye(
	{
		maxWidth: 40,
		items: 'a',
		itemsText: 'span',
		container: '.dock-container',
		itemWidth: 30,
		proximity: 100,
		halign : 'center'
	}
	);
});


// this is a bit of a hack here
// just list the tab content divs here
var tabs = ["global","XBMC", "SICKBEARD", "COUCHPOTATO", "SABNZBD", "TRANSMISSION", "UTORRENT", "JDOWNLOADER", "Search_Widget", "Trakt_Widget", "Security", "Mods", "NavBar_Section", "HardDrive_Widget", "Message_Widget", "RSS_Widget", "Control_Widget"];

function showTab( tab ){

  // first make sure all the tabs are hidden
  for(i=0; i < tabs.length; i++){
    var obj = document.getElementById(tabs[i]);
    obj.style.display = "none";
  }
    
  // show the tab we're interested in
  var obj = document.getElementById(tab);
  obj.style.display = "block";
  document.getElementById('result').innerHTML = '';


}

function updateSettings(section){
  var contents = document.getElementById(section).getElementsByTagName('input');
  //$("#result").html(contents);
  var params = 'section='+section; 
  for(i=0;i<contents.length;i++){
    //alert(contents[i].name+'='+contents[i].value);
    var value = contents[i].value;
    if(contents[i].type == 'checkbox'){
      if(contents[i].value == 'on'){
        value = 'true';
      } else {
        value = 'false';
      }
      params = params+'&'+contents[i].name+'='+value;
    }
    else if(contents[i].type == 'radio'){
      var name = contents[i].name;
      while(contents[i].type == 'radio'){
        if(contents[i].checked && contents[i].name == name){
          //alert(contents[i].name+' '+contents[i].value);
          value = contents[i].value;
          params = params+'&'+contents[i].name+'='+encodeURIComponent(value);
        }
        i++;
      }
      i--;
    }
    else if(contents[i].name != ''){
      params = params+'&'+contents[i].name+'='+encodeURIComponent(value);
    }
  }
  //alert(params);
    $.ajax(
    {
        type: 'GET',
        url: "settings.php?"+params,
        beforeSend: function ()
        {
            // this is where we append a loading image
               $("#result").html('Saving');
        },
        success: function (data)
        {
            // successful request; do something with the data
            $("#result").html(data);
               //$("#result").html('Saved');
        },
        error: function ()
        {
            // failed request; give feedback to user
            alert("Sorry, but I couldn't create an XMLHttpRequest");
        }
    });
}

function updateAlternative(section){
  var contents = document.getElementById(section).getElementsByTagName('input');
  var params = 'section='+section; 
  for(i=0;i<contents.length;i++){
    if(contents[i].name=='TITLE'){
      params = params + '&' + escape(contents[i++].value) + '=' + encodeURIComponent(contents[i].value);
    }
    //var value = contents[i].value;
  }
  //alert(params);
  $.ajax(
  {
      type: 'GET',
      url: "settings.php?"+params,
      beforeSend: function ()
      {
          // this is where we append a loading image
             $("#result").html('Saving');
      },
      success: function (data)
      {
          // successful request; do something with the data
          $("#result").html(data);
             //$("#result").html('Saved');
      },
      error: function ()
      {
          // failed request; give feedback to user
          alert("Sorry, but I couldn't create an XMLHttpRequest");
      }
  });
}

function addRowToTable(section, size1, size2)
{
  var tbl = document.getElementById('table_'+section);
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
      
  // left cell
  var cellLeft = row.insertCell(0);
  var el = document.createElement('input');
  el.type = 'text';
  el.name = 'TITLE';
  el.size = size1;
  
  cellLeft.appendChild(el);
  
  // select cell
  var cellRightSel = row.insertCell(1);
  var sel = document.createElement('input');
  sel.name = 'VALUE';
  sel.type = 'text';
  sel.size = size2;
  cellRightSel.appendChild(sel);
}

function removeRowToTable(section){
  var tbl = document.getElementById('table_'+section);
  var lastRow = tbl.rows.length;
  if (lastRow > 2) tbl.deleteRow(lastRow - 1);
}

function saveAll(){
  var i=0;
  while(i < tabs.length){
    updateSettings(tabs[i]);
    alert(tabs[i]+' saved');
    i++;
  }
}
