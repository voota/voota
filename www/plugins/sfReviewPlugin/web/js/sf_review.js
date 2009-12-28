function re_loading( box ){
	$("#"+box).html("<img src='/images/spinner.gif' alt='cargando' />");
}

function loadReviewBox(url, t, e, v,  box) {
	re_loading( box );

	var aUrl = url +'?t='+(t?t:'')+'&e='+e+'&v='+v+'&b='+box+'';
	jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#'+box).html(data);},url:aUrl});
	return false;
}
