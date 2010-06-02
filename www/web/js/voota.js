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

function cargarSelectorPartido(partidos, favoritos) {	
  // $("#partido_selector").change(function(){
  //  partidoSelector = document.getElementById('partido_selector');
  //  changeParam("p", partidoSelector.value);
  // });
  
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

function facebookConnect_PHCallback(){
	sf_fb.gotoLoginPage();
}

function facebookConnect_promptPermission(permission, callbackFuncName) {
  FB.ensureInit(function() {
    FB.Facebook.apiClient.users_hasAppPermission(permission,
     function(result) {
        if (result == 0) {
          FB.Connect.showPermissionDialog(permission, callbackFuncName);
        }
        else {
        	callbackFuncName(1);
        }
    });
  });
}

function facebookConnect_callback(){
  facebookConnect_promptPermission("publish_stream", facebookConnect_PHCallback);
}

function facebookConnect(){
	jQuery(function(){sf_fb.requireSession(null, facebookConnect_callback)});
	return false;
}

function facebookConnect_autoLogin() {
  FB.Connect.ifUserConnected(facebookConnect_callback);
}

function facebookConnect_linkLogout() {
  FB.Connect.ifUserConnected(function(){
    $('#logout').click(function(){
      logout_url = $(this).attr('href');
      FB.Connect.logoutAndRedirect(logout_url);
      return false;
    })
  });
}

function facebookConnect_loadUserName() {
  FB.ensureInit(function() {
    FB.Connect.ifUserConnected(function() {
      if ($('#profile_nombre').attr('value') == "") {
        uid = FB.Connect.get_loggedInUser()
        FB.Facebook.apiClient.users_getInfo(uid, ['first_name', 'last_name'], function(result){
          $('#profile_nombre').attr('value', result[0]['first_name']);
          $('#profile_apellidos').attr('value', result[0]['last_name']);
        }); 
      }
    });
  });
}

function facebookConnect_disconnect_logout(url, logout_url) {
  re_loading('facebook-connect');
	$.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    $('#facebook-connect').html(data);
	    FB.Connect.logoutAndRedirect(logout_url);
	  }
	});
}

function facebookConnect_disconnect(url) {
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

function facebookConnect_loadPreferences(url, box){
  re_loading( box );
	jQuery.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    jQuery('#'+box).html(data);
	    FB.XFBML.Host.parseDomTree();
	  }
	});
	
	return false;
}

function facebookConnect_associate(url, box) {
	jQuery(function(){ sf_fb.requireSession(null, function(){
	  facebookConnect_loadPreferences(url, box);
	}) });
	return false;
}

function loadAjax(url, box){
  re_loading( box );
	jQuery.ajax({
	  type     : 'POST',
	  dataType : 'html',
	  url      : url,
	  success  : function(data, textStatus) {
	    jQuery('#'+box).html(data);
	    FB.XFBML.Host.parseDomTree();
	  }
	});
	
	return false;
}

function close_sync_tip(url) {
	  re_loading( 'lo_fb_conn' );
	jQuery.ajax({
		  type     : 'POST',
		  dataType : 'html',
		  url      : url,
		  success  : function(data, textStatus) {
		    jQuery('#lo_fb_conn').html(data);
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

$.fn.reviews_pagination = function(options) {
  if(!options) options = {};
  defaults = {
    summaryTemplate: '<p>Mostrando <strong class="reviews_count"></strong> comentarios de <strong class="reviews_total"></strong></p>',
    buttonText: 'más',
    data: { page: 1 }
  };
  var opts = $.extend(true, {}, defaults, options);
  
  return $(this).each(function(){
    var area = $(this);
    var summary = $(opts.summaryTemplate);
    var spinner = $('<img src="/images/spinner.gif" alt="cargando..." style="display:none" />');
    var button = $('<button id="reviews_more">' + opts.buttonText + '</button>')
    var buttonContainer = $('<p></p>').append(button).append(spinner);
    
    $(this).parent().append(buttonContainer);
    $(this).parent().append(summary);

    var updateSummaryCounters = function() {
      var count = area.find('li.review').size();
      summary.find('.reviews_count').html(count);
      summary.find('.reviews_total').html(opts.total);
      if (count >= opts.total) { button.remove(); }
    }
    updateSummaryCounters();

    button.click(function(){
      spinner.show();
      $.ajax({
			  type: 'POST',
			  dataType: 'html',
			  data: opts.data,
			  success: function(result, textStatus) {
			    spinner.hide();
			    area.append(result);
			    opts.data.page = opts.data.page + 1;
			    updateSummaryCounters();
			    FB.XFBML.Host.parseDomTree()
			  },
				url: opts.url
			});
    });
  });
}