function thumb_up() {
	document.theForm.v[0].checked = true;
	document.theForm.submit();
	
	return false;
}
function thumb_down() {
	document.theForm.v[1].checked = true;
	document.theForm.submit();
	
	return false;
}
function changeParam(param, value){
	var separator = "?";
	var dest = "" + document.location; 
	if(dest.indexOf("?") != -1){
		separator = "&";
	}
	
	document.location = document.location + separator + param + '=' + value;
	
	return false;
}
function rankingReady() {	
	$("#partido_selector").change(function(){
		partidoSelector = document.getElementById('partido_selector');
		
		changeParam("p", partidoSelector.value);
	});}

// mode: init/form
function politicoReady( url, id, box ){
	loadReviewBox(url, 1, id, -1, box);
}

function showHidePass( fieldName ){
	var field = document.getElementById( fieldName );
	if ( field.type == "password" ){
		field.type = "text";
	}
	else {
		field.type = "password";
	}
}
function showScoreHelp(){
	$("#help_dialog").dialog('open');
}



