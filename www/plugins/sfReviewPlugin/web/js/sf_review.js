function re_loading( box ){
	$("#"+box).html("<img src='/images/spinner.gif' alt='cargando' />");
}

function loadReviewBox(url, t, e, v,  box, options) {
	re_loading( box );

	var aUrl = url +'?nl=1&t='+(t?t:'')+'&e='+e+'&v='+v+'&b='+box+'';
	if (options) {
		for (var i in options) {
			aUrl += '&' + i + '=' + options[i];
		}
	}

  	$('#sfrc_'+e).show();
	jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#'+box).html(data);},url:aUrl});
	return false;
}

function sendReviewForm(form, url, box) {
	var aUrl = url;
	var data = $(form).serialize();
	re_loading(box);
	jQuery.ajax({type:'POST',dataType:'html',data:data,success:function(data, textStatus){jQuery('#'+box).html(data);},url:aUrl});

	return false;
}


function setCounter(counter, field, maxLength){
	var str = $(field).val();
	var charLength = 0
  	//str = str.replace(/\n/g,"oo");
	try {
		charLength = str.length;
	}
	catch (e){
	}
  	
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

function sendReviewFormFB(form, text, url, box, attachment, action_links, tip) {
	gform = form; gurl = url; gbox = box;

	if (form.fb_publish.checked){
	    facebookConnect_promptPermission("publish_stream", function(perms) {
	    	if (perms) {
	    		publishFaceBook( text, attachment, action_links, tip );
	    	}
	    	else {
	    		sendReviewForm(form, url, box);
	    	}
		});
	}
	else {
		sendReviewForm(form, url, box);
	}
	
	return false;
}

function publishFaceBook(msg, attachment, action_links, tip) {
	  FB.ensureInit(function () {
		  FB.Connect.streamPublish(
				  msg, attachment, action_links, null
				  , ''
				  , stream_callback
				  , true
		  );
	  });
}

function ejem( url, ub ) {
    var form = document.createElement("form");
    form.setAttribute("method", 'post');
    form.setAttribute("action", url);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "dialog");
    hiddenField.setAttribute("value", "1");
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "url_back");
    hiddenField.setAttribute("value", ub);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();
}

function subvote(boxId, id, page, url){
	var options = new Array();
	if (typeof $(".reviews" ).tabs !== 'undefined'){
		options['tab'] = $( ".reviews" ).tabs( "option", "selected" );
	}
	if (page) {
		options['page'] = page;
	}
	$('#sf_review_sr_c' + boxId).slideDown();
  	document.getElementById('subreviews_box' + boxId).className = 'subreviews shown';

	return loadReviewBox(url, null,  id,  0, 'sfrc' + boxId, options );
}

function facebookPublishStory(story_attrs) {
  FB.api('/me/feed', 'post', story_attrs, function(response) {
    if (!response || response.error) {
      alert('Hubo un problema al intentar publicar en el muro.');
    }
  });
}

function sfr_refresh(){
	document.location.reload();
}