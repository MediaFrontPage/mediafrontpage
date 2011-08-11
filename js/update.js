var count = 0;
$(document).ready(function() {
  ajaxRequest('download=true', 'dl');
});

function ajaxRequest(params, id){
	//alert(params);
	$.ajax({
		type: 'GET',
		url: "update.php?" + params,
		success: function(data) { // successful request; do something with the data
			if(data == 1){
			  $("img#"+id).attr('src','media/green-tick.png');
			  callNext(count);
			  count++;
			} else {
			  $("img#"+id).attr('src','media/red-cross.png');
			  document.getElementById('result').innerHTML = '<font color="red"> An ERROR occurred </font>'+data;
			}
		},
		error: function() { // failed request; give feedback to user
			alert("Ajax error.");
		},
	});
	//document.getElementById('result').innerHTML = JSON.stringify(result);
}

function callNext(i){
  if(i == 0){
    $("#zip").html('<img id="unzip" src="media/pwait.gif" height="15px" />');
    ajaxRequest('unzip=true','unzip');
  } else if(i == 1){
    $("#backup").html('<img id="bp" src="media/pwait.gif" height="15px" />');
    ajaxRequest('move=true&src=.&dst=tmp','bp');  
  } else if(i == 2){
    $("#update").html('<img id="up" src="media/pwait.gif" height="15px" />');
    moveUpdate('moveupdate=true','up');
  } else if(i == 3){
    $("#clean-back").html('<img id="cb" src="media/pwait.gif" height="15px" />');
    ajaxRequest('cleanup=true&dir=tmp','cb');
  } else if(i == 4){
    $("#clean-left").html('<img id="cu" src="media/pwait.gif" height="15px" />');
    ajaxRequest('cleanup=true&dir=update','cu');
  } else {
    alert('Finished');
  }
}

function moveUpdate(params, id){
	//alert(params);
	$.ajax({
		type: 'GET',
		url: "tmp/update.php?" + params,
		success: function(data) { // successful request; do something with the data
			if(data == 1){
			  $("img#"+id).attr('src','media/green-tick.png');
			  callNext(count);
			  count++;
			} else {
			  $("img#"+id).attr('src','media/red-cross.png');
			  document.getElementById('result').innerHTML = '<font color="red"> An ERROR occurred </font>'+data;
			}
		},
		error: function() { // failed request; give feedback to user
			alert("Ajax error.");
		},
	});
	//document.getElementById('result').innerHTML = JSON.stringify(result);
}
