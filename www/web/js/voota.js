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
        	callbackFuncName();
        }
    });
  });
}

function facebookConnect_callback(){
  facebookConnect_promptPermission("publish_stream", facebookConnect_PHCallback);
}

function facebookConnect(){
	jQuery(function(){sf_fb.requireSession('', facebookConnect_callback)});
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

function facebookConnect_loadPreferences() {
  FB.ensureInit(function() {
    FB.Connect.ifUserConnected(function() {
      // Enviar UID y sustituir #facebook_connect con el template devuelto
      uid = FB.Connect.get_loggedInUser();
    });
  });
}

function facebookConnect_disconnect() {
  // Enviar petición Ajax indicando desconexión y sustituir #facebook_connect con el template devuelto
}