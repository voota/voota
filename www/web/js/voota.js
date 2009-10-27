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
function politicoReady( id, mode, box ){
	loadReviewBox(1, id, -1, mode, box);
}

function loadReviewBox(t, e, v, mode, box) {
	var aUrl = '/es/review/'+ mode +'?t='+t+'&e='+e+'&v='+v+'&b='+box+'';
	//alert(aUrl);
	jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#'+box).html(data);},url:aUrl}); return false;
}


function changeInstitucion( institucion ){
	return changeParam("i", institucion);
}