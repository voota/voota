function re_loading( box ){
	$("#"+box).html("<img src='/images/spinner.gif' alt='cargando' />");
}

function loadReviewBox(url, t, e, v,  box) {
	re_loading( box );

	var aUrl = url +'?t='+(t?t:'')+'&e='+e+'&v='+v+'&b='+box+'';
  $('#sfrc_'+e).show();
	jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#'+box).html(data);},url:aUrl});
	return false;
}

function sendReviewForm(form, url, box) {
	re_loading( box );

	var aUrl = url;
	jQuery.ajax({type:'POST',dataType:'html',data:jQuery(form).serialize(),success:function(data, textStatus){jQuery('#'+box).html(data);},url:aUrl});

	return false;
}


function setCounter(counter, field, maxLength){
	var str = $(field).val();
  	str = str.replace(/\n/g,"oo");
  	var charLength = str.length;
  	
  	if((maxLength - charLength) < 0) {
  		$(counter).attr('style', 'color:red;');
  	}
  	else if((maxLength - charLength) < 40) {
  		$(counter).attr('style', 'color:orange;');
  	}
  	else {
  		$(counter).attr('style', '');
  	}
  	$(counter).html(maxLength - charLength);
}

var gform = "sf-review-form-sf_review";
var gurl = "";
var gbox = "sf_review";

function stream_callback (post_id, exception) {
	sendReviewForm(gform, gurl, gbox);
}

function facebookPublishStory(story_attrs) {
  FB.api('/me/feed', 'post', story_attrs, function(response) {
    if (!response || response.error) {
      alert('Hubo un problema al intentar publicar en el muro.');
    }
  });
}