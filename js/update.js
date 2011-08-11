var success = '';
$(document).ready(function() {
  ajaxRequest('download=true', 'dl');
  if(success){
    alert('yes!');
  }
});

function ajaxRequest(params, id){
	//alert(params);
	$.ajax({
		type: 'GET',
		url: "update.php?" + params,
		success: function(data) { // successful request; do something with the data
			if(data == 1){
			  $("img#"+id).attr('src','media/green-tick.png');
			  success = true;
			} else {
			  $("img#"+id).attr('src','media/red-cross.png');
			  success = false;
			}
		},
		error: function() { // failed request; give feedback to user
			alert("Ajax error.");
		},
	});
	
	return $.ajax().responseText;
	//document.getElementById('result').innerHTML = JSON.stringify(result);;
}