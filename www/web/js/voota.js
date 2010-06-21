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

// mode: init/form
function politicoReady( url, id, box ){
	return loadReviewBox(url, 1, id, -1, box);
}

function showHidePass( fieldName ){
	var field = document.getElementById( fieldName );
	var showLabel = document.getElementById( 'show_pass_label' );
	var hideLabel = document.getElementById( 'hide_pass_label' );
	
	if ( field.type == "password" ){
		changeInputType(field, 'text');

		showLabel.className="hidden";
		hideLabel.className="shown";
	}
	else {
		changeInputType(field, 'password');

		showLabel.className="shown";
		hideLabel.className="hidden";
	}
	
	return false;
}

function changeInputType(oldObject, oType) {
	  var newObject = document.createElement('input');
	  newObject.type = oType;
	  if(oldObject.size) newObject.size = oldObject.size;
	  if(oldObject.value) newObject.value = oldObject.value;
	  if(oldObject.name) newObject.name = oldObject.name;
	  if(oldObject.id) newObject.id = oldObject.id;
	  if(oldObject.className) newObject.className = oldObject.className;
	  if(oldObject.className) newObject.autocomplete = oldObject.autocomplete;
	  oldObject.parentNode.replaceChild(newObject,oldObject);
	  return newObject;
}

function showScoreHelp(){
	$("#help-dialog").dialog('open');
}

function institutions_to_long() {
	document.getElementById('institutions-long').className = 'shown';
	document.getElementById('institutions-short').className = 'hidden';
	return false;
}

function institutions_to_short() {
	document.getElementById('institutions-long').className = 'hidden';
	document.getElementById('institutions-short').className = 'shown';
	return false;
}

// Facebook
function facebookParseXFBML(selector) {
  FB.XFBML.parse(selector);
}

function facebookRequirePermission(options) {
  FB.api(
    {
      method: 'users.hasAppPermission',
      ext_perm: options.permission
    },
    function(response) {
      if (response == 1) {
        options.success();
      } else {
        options.error();
      }
    }
  );
}

function facebookRequireLogin(options) {
  FB.getLoginStatus(function(response) {
    if (response.session) {
      options.success();
    } else {
      FB.login(function(response) {
        facebookRequireLogin(options);
      }, {perms:'publish_stream'});
    }
  });
  return false;
}

function facebookNotifyLoginToBackend() {
	$.post('/user/login', { op: 'fb' });
}

function facebookLogin() {
  facebookRequireLogin({
    success: function() {
      facebookNotifyLoginToBackend();
    }
  });
  return false;
}

function facebookLoadUserName() {
  if ($('#profile_nombre').attr('value') == "") {
    FB.getLoginStatus(function(response) {
      if (response.session) {
        FB.api('/me', function(response) {
          $('#profile_nombre').attr('value', response.first_name).removeClass('blur');
          $('#profile_apellidos').attr('value', response.last_name).removeClass('blur');
        }); 
      }
    });
  }
}

function facebookLogoutAndRedirect(url, logout_url) {
  re_loading('facebook-connect');
	$.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    $('#facebook-connect').html(data);
	    FB.logout();
	    window.location = logout_url;
	  }
	});
}

function facebookDisconnectAccount(url) {
  re_loading('facebook-connect');
	$.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    $('#facebook-connect').html(data);
	  }
	});
}

function facebookLoadPreferences(url, box) {
  re_loading(box);
	$.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    $('#' + box).html(data);
	    facebookParseXFBML('#' + box);
	  }
	});
	return false;
}

function facebookAssociate(url, box) {
	$(function() {
	  facebookRequireLogin({
      success: function() {
	      facebookLoadPreferences(url, box);
      }
	  })
	});
	return false;
}

function loadAjax(url, box){
  re_loading(box);
	$.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    $('#'+box).html(data);
	    facebookParseXFBML();
	  }
	});
	
	return false;
}

function close_sync_tip(url) {
	re_loading('lo_fb_conn');
	$.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    $('#lo_fb_conn').html(data);
	  }
	});
	
  //$('#lo_fb_conn').remove();
}

function sparkline(id, label, data) {
  try {
    var g = new Bluff.Line(id, '100x15');
    g.set_theme({
        colors: ['blue'],
        font_color: 'black',
        background_colors: ['white', 'white']
    });
    g.line_width = 1;
    g.tooltips = true;
    g.dot_radius = 15;
    g.hide_mini_legend = true;
    g.hide_legend = true;
    g.hide_line_markers = true;
    g.hide_line_numbers = true;
    g.hide_title = true;
    g.set_font('Georgia');
    g.data(label, data);
    g.draw();
  } catch(err) { }
}

jQuery.fn.tooltip_politico_elecciones = function() {
  $(this).each(function(){
    img = $('<div>').append($(this).clone()).remove().html();
    nombre = $(this).data('nombre');
    url = $(this).data('url');
    positive_votes = $(this).data('positive_votes');
    negative_votes = $(this).data('negative_votes');
    $(this).qtip({
      content: '<div class="tooltip-politico">' + 
                 '<div class="nombre"><a href="' + url + '">' + nombre + '</a></div>' +
                 '<div class="photo">' + img + '</div>' +
                 '<div class="positive_votes">' + positive_votes + '</div>' +
                 '<div class="negative_votes">' + negative_votes + '</div>' +
               '</div>',
      position: {
        corner: { tooltip: 'bottomMiddle', target: 'topMiddle' }
      },
      hide: { fixed: true, delay: 100, effect: { type: 'fade' } },
      style: {
        border: { width: 1, color: '#809DB9' },
        padding: 10,
        tip: true
      }
    });
  });
}