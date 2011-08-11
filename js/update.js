$(document).ready(function() {
  ajaxRequest('download=true');
});

function ajaxRequest(params){
	//alert(params);
	$.ajax({
		type: 'GET',
		url: "update.php?" + params,
		success: function(data) { // successful request; do something with the data
			if(data == 1){
			  $("img#dl").attr('src','media/green-tick.png');
			} else {
			  $("img#dl").attr('src','media/red-cross.png');
			}
		},
		error: function() { // failed request; give feedback to user
			alert("Ajax error.");
		}
	});
}