var scroll_top = function(){

	if(window.pageYOffset){
		return window.pageYOffset;
	 }
	 else {
		return  Math.max(document.body.scrollTop,document.documentElement.scrollTop);
	 }
}

function loadReviewBox(t, e, v) {
	centerPopup();
	loadPopup();
	jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#sf_review').html(data);},url:'/review/form?t='+t+'&e='+e+'&v='+v+''}); return false;
}

function politicoReady() {
	$("#popupContactClose").click(function(){
		disablePopup();
	});

	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});
}



function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupStatus = 1;
	}
}

function disablePopup(){
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		popupStatus = 0;
	}
}


function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();

	//centering
	$("#popupContact").css({
		"position": "absolute",
		"top": scroll_top() + windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
}