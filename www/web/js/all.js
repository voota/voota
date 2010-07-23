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

function facebookNotifyLoginToBackend(url) {
	document.location = url;
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
	    facebookParseXFBML();
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

jQuery.fn.tooltip_propuesta = function() {
  if (!($.browser.msie && parseInt($.browser.version) < 8)) {
    $(this).each(function(){
      var title = '<strong>' + $(this).attr('title').split('|')[0] + '</strong>';
      var date = $(this).attr('title').split('|')[1];
      var body = $(this).attr('title').split('|')[2];
      $(this).qtip({
        content: '<p>' + title + '</p><p>' + date + '</p><p>' + body + '</p>',
        position: {
          corner: { tooltip: 'leftTop', target: 'rightTop' },
          adjust: { screen: true, scroll: false, resize: false }
        },
        style: { name: 'light' }
      });
      $(this).attr('title', '');
    });
  }
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
        corner: { tooltip: 'bottomMiddle', target: 'topMiddle' },
        adjust: { screen: true, scroll: false, resize: false }
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

function formatSummaryTemplate(string) {
  string = string.replace('{count}', '<strong class="reviews_count"></strong>');
  string = string.replace('{total}', '<strong class="reviews_total"></strong>');
  return '<p>' + string + '</p>';
}

$.fn.reviews_pagination = function(options) {
  if(!options) options = {};
  defaults = {
    summaryTemplate: formatSummaryTemplate('Mostrando {count} comentarios de {total}'),
    buttonText: 'más',
    data: { page: 1 }
  };
  var opts = $.extend(true, {}, defaults, options);
  
  return $(this).each(function(){
    var area = $(this);
    var summary = $(opts.summaryTemplate);
    var spinner = $('<img src="/images/spinner-mini.gif" alt="..." style="display:none" />');
    var button = $('<button id="reviews_more">' + opts.buttonText + '</button>')
    var buttonContainer = $('<p></p>').append(button).append(spinner);
    
    $(this).parent().append(buttonContainer);
    $(this).parent().append(summary);

    var updateSummaryCounters = function() {
      var count = area.children('li.review').size();
      summary.find('.reviews_count').html(count + ' ');
      summary.find('.reviews_total').html(opts.total);
      if (count >= opts.total) { button.remove(); }
    }
    updateSummaryCounters();

    button.click(function(){
      spinner.show();
	    opts.data.page = opts.data.page + 1;
      $.ajax({
			  type: 'POST',
			  dataType: 'html',
			  data: opts.data,
			  success: function(result, textStatus) {
			    spinner.hide();
			    area.append(result);
			    updateSummaryCounters();
			    facebookParseXFBML();
			  },
				url: opts.url
			});
    });
  });
}

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
/**
* @author Remy Sharp
* @url http://remysharp.com/2007/01/25/jquery-tutorial-text-box-hints/
*/
function removeHint(f, blurClass){
	var $input = $(f),
    title = $input.attr('title'),
    $form = $(f).closest('form'),
    $win = $(window);
	
    if ($input.val() === title && $input.hasClass(blurClass)) {
    	$input.val('').removeClass(blurClass);
    }	
    
    return false;
}

function subscribeHint(f, blurClass){
    // get jQuery version of 'this'
    var $input = $(f),
    
    // capture the rest of the variable to allow for reuse
      title = $input.attr('title'),
      $form = $(f).closest('form'),
      $win = $(window);

    function remove() {
    	removeHint(f, blurClass);
    }

    // only apply logic if the element has the attribute
    if (title) { 
      // on blur, set value to title attr if text is blank
      $input.blur(function () {
        if ($input.val() === '') {
            $input.val('tal');
          $input.val(title).addClass(blurClass);
        }
      }).focus(remove).blur(); // now change all inputs to title
      
      // clear the pre-defined text when form is submitted
      $form.submit(remove);
      $win.unload(remove); // handles Firefox's autocomplete
    }
}

(function ($) {
	$.fn.hint = function (blurClass) {
	  if (!blurClass) { 
	    blurClass = 'blur';
	  }
	    
	  return this.each(function () {
		  subscribeHint(this, blurClass);
	  });
	};
})(jQuery);
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('"6t 6u";(j($){$(31).3A(j(){R i;$(2g).1M(\'3K 3D\',j(r){1S(i=0;i<$.19.g.O.Q;i++){R T=$.19.g.O[i];c(T&&T.V&&T.V.1b&&T.8.k.17!==\'28\'&&T.d.h.2q(\':2c\')&&(T.8.k.1g.3D&&r.17===\'3D\'||T.8.k.1g.3K&&r.17===\'3K\')){T.2f(r,H)}}});$(31).1M(\'5d.g\',j(r){c($(r.s).52(\'12.g\').Q===0){R h=$(\'.6x\'),T=h.g(\'T\');c(h.2q(\':2c\')&&T&&T.V&&!T.V.22&&$(r.s).2o(T.d.s).Q>1){T.D(r)}}})});j 2D(w){c(!w){B p}A.x=5w(w).3k(/5m/i,\'1j\').5o(/M|25|1j/i)[0].2F();A.y=5w(w).3k(/5m/i,\'1j\').5o(/K|26|1j/i)[0].2F();A.1q={M:0,K:0};A.2y=(w.2H(0).6L(/^(t|b)/)>-1)?\'y\':\'x\';A.1x=j(){B(A.2y===\'y\')?A.y+A.x:A.x+A.y}}j 42(w,o,F){R 1N={5B:[[0,0],[o,F],[o,0]],6a:[[0,0],[o,0],[0,F]],5K:[[0,F],[o,0],[o,F]],5N:[[0,0],[0,F],[o,F]],6z:[[0,F],[o/2,0],[o,F]],6v:[[0,0],[o,0],[o/2,F]],6w:[[0,0],[o,F/2],[0,F]],6J:[[o,0],[o,F],[0,F/2]]};1N.6M=1N.5B;1N.6A=1N.6a;1N.6B=1N.5K;1N.6D=1N.5N;B 1N[w]}j 4d(E){R 2j;c($(\'<1e />\').1p(0).1D){2j={3M:[E,E],4p:[0,E],4h:[E,0],3Q:[0,0]}}C c($.15.1d){2j={3M:[-2z,2z,0],4p:[-2z,2z,-E],4h:[2z,5H,0],3Q:[2z,5H,-E]}}B 2j}j 2G(e,49){R 2U,i;2U=$.2r(H,{},e);1S(i 5R 2U){c(49===H&&(/(f|1f)/i).1Y(i)){3r 2U[i]}C c(!49&&(/(o|J|f|U|1f|4v)/i).1Y(i)){3r 2U[i]}}B 2U}j 45(e){c(P e.f!==\'18\'){e.f={w:e.f}}c(P e.f.N!==\'18\'){e.f.N={o:e.f.N,F:e.f.N}}c(P e.J!==\'18\'){e.J={o:e.J}}c(P e.o!==\'18\'){e.o={2Z:e.o}}c(P e.o.1H===\'1x\'){e.o.1H=1y(e.o.1H.3k(/([0-9]+)/i,"$1"),10)}c(P e.o.2b===\'1x\'){e.o.2b=1y(e.o.2b.3k(/([0-9]+)/i,"$1"),10)}c(P e.f.N.x===\'2n\'){e.f.N.o=e.f.N.x;3r e.f.N.x}c(P e.f.N.y===\'2n\'){e.f.N.F=e.f.N.y;3r e.f.N.y}B e}j 4e(){R 7,i,3z,2v,1F,1P;7=A;3z=[H,{}];1S(i=0;i<35.Q;i++){3z.51(35[i])}2v=[$.2r.4a($,3z)];6G(P 2v[0].20===\'1x\'){2v.5O(45($.19.g.3c[2v[0].20]))}2v.5O(H,{1f:{h:\'g-\'+(35[0].20||\'39\')}},$.19.g.3c.39);1F=$.2r.4a($,2v);1P=($.15.1d)?1:0;1F.f.N.o+=1P;1F.f.N.F+=1P;c(1F.f.N.o%2>0){1F.f.N.o+=1}c(1F.f.N.F%2>0){1F.f.N.F+=1}c(1F.f.w===H){c(7.8.k.w.h===\'1j\'&&7.8.k.w.s===\'1j\'){1F.f.w=p}C{1F.f.w=7.8.k.w.h}}B 1F}j 4b(1e,X,E,I){R 1l=1e.1p(0).1D(\'2d\');1l.5G=I;1l.5U();1l.3y(X[0],X[1],E,0,1t.6N*2,p);1l.5Y()}j 5v(){R 7,i,o,E,I,X,1O,N,4L,2s,3e,3g,43,4M,4o;7=A;7.d.1u.1J(\'.g-3g, .g-3e\').3W();o=7.8.e.J.o;E=7.8.e.J.E;I=7.8.e.J.I||7.8.e.f.I;X=4d(E);1O={};1S(i 5R X){1O[i]=\'<12 1R="\'+i+\'" e="\'+((/6n/).1Y(i)?\'M\':\'25\')+\':0; \'+\'k:34; F:\'+E+\'1a; o:\'+E+\'1a; 2u:1G; 2S-F:0.1B; 2Y-N:1B">\';c($(\'<1e />\').1p(0).1D){1O[i]+=\'<1e F="\'+E+\'" o="\'+E+\'" e="4i-3o: K"></1e>\'}C c($.15.1d){N=E*2+3;1O[i]+=\'<v:3y 5j="p" 3q="\'+I+\'" 6s="\'+X[i][0]+\'" 6r="\'+X[i][1]+\'" \'+\'e="o:\'+N+\'1a; F:\'+N+\'1a; 2p-K:\'+((/26/).1Y(i)?-2:-1)+\'1a; \'+\'2p-M:\'+((/6k/).1Y(i)?X[i][2]-3.5:-1)+\'1a; \'+\'4i-3o:K; 27:5c-4J; 3F:1z(#2L#3L)"></v:3y>\'}1O[i]+=\'</12>\'}4L=7.3d().o-(1t.1H(o,E)*2);2s=\'<12 1K="g-2s" e="F:\'+E+\'1a; o:\'+4L+\'1a; \'+\'2u:1G; 1s-I:\'+I+\'; 2S-F:0.1B; 2Y-N:1B;">\';3e=\'<12 1K="g-3e" 4y="4g" e="F:\'+E+\'1a; \'+\'2p-M:\'+E+\'1a; 2S-F:0.1B; 2Y-N:1B; 2x:0;">\'+1O.3M+1O.4p+2s;7.d.1u.3v(3e);3g=\'<12 1K="g-3g" 4y="4g" e="F:\'+E+\'1a; \'+\'2p-M:\'+E+\'1a; 2S-F:0.1B; 2Y-N:1B; 2x:0;">\'+1O.4h+1O.3Q+2s;7.d.1u.5s(3g);c($(\'<1e />\').1p(0).1D){7.d.1u.1J(\'1e\').1I(j(){43=X[$(A).3N(\'[1R]:1U\').W(\'1R\')];4b.S(7,$(A),43,E,I)})}C c($.15.1d){7.d.h.5s(\'<v:3T e="3F:1z(#2L#3L);"></v:3T>\')}4M=1t.1H(E,(E+(o-E)));4o=1t.1H(o-E,0);7.d.1w.G({J:\'6C 3s \'+I,6I:4o+\'1a \'+4M+\'1a\'})}j 44(1e,X,I){R 1l=1e.1p(0).1D(\'2d\');1l.5G=I;1l.5U();1l.6o(X[0][0],X[0][1]);1l.5Q(X[1][0],X[1][1]);1l.5Q(X[2][0],X[2][1]);1l.5Y()}j 4Q(w){R 7,1P,23,41,40,3S;7=A;c(7.8.e.f.w===p||!7.d.f){B}c(!w){w=2T 2D(7.d.f.W(\'1R\'))}1P=23=($.15.1d)?1:0;7.d.f.G(w[w.2y],0);c(w.2y===\'y\'){c($.15.1d){c(1y($.15.2X.2H(0),10)===6){23=w.y===\'K\'?-3:1}C{23=w.y===\'K\'?1:2}}c(w.x===\'1j\'){7.d.f.G({M:\'50%\',6K:-(7.8.e.f.N.o/2)})}C c(w.x===\'M\'){7.d.f.G({M:7.8.e.J.E-1P})}C{7.d.f.G({25:7.8.e.J.E+1P})}c(w.y===\'K\'){7.d.f.G({K:-23})}C{7.d.f.G({26:23})}}C{c($.15.1d){23=(1y($.15.2X.2H(0),10)===6)?1:(w.x===\'M\'?1:2)}c(w.y===\'1j\'){7.d.f.G({K:\'50%\',4f:-(7.8.e.f.N.F/2)})}C c(w.y===\'K\'){7.d.f.G({K:7.8.e.J.E-1P})}C{7.d.f.G({26:7.8.e.J.E+1P})}c(w.x===\'M\'){7.d.f.G({M:-23})}C{7.d.f.G({25:23})}}41=\'2x-\'+w[w.2y];40=7.8.e.f.N[w.2y===\'x\'?\'o\':\'F\'];7.d.h.G(\'2x\',0).G(41,40);c($.15.1d&&1y($.15.2X.2H(0),6)===6){3S=1y(7.d.f.G(\'2p-K\'),10)||0;3S+=1y(7.d.u.G(\'2p-K\'),10)||0;7.d.f.G({4f:3S})}}j 4w(w){R 7,I,X,3I,2l,f;7=A;c(7.d.f!==1A){7.d.f.3W()}I=7.8.e.f.I||7.8.e.J.I;c(7.8.e.f.w===p){B}C c(!w){w=2T 2D(7.8.e.f.w)}X=42(w.1x(),7.8.e.f.N.o,7.8.e.f.N.F);7.d.f=\'<12 1K="\'+7.8.e.1f.f+\'" 4y="4g" 1R="\'+w.1x()+\'" e="k:34; \'+\'F:\'+7.8.e.f.N.F+\'1a; o:\'+7.8.e.f.N.o+\'1a; \'+\'2p:0 6e; 2S-F:0.1B; 2Y-N:1B;"></12>\';7.d.h.3v(7.d.f);c($(\'<1e />\').1p(0).1D){f=\'<1e F="\'+7.8.e.f.N.F+\'" o="\'+7.8.e.f.N.o+\'"></1e>\'}C c($.15.1d){3I=7.8.e.f.N.o+\',\'+7.8.e.f.N.F;2l=\'m\'+X[0][0]+\',\'+X[0][1];2l+=\' l\'+X[1][0]+\',\'+X[1][1];2l+=\' \'+X[2][0]+\',\'+X[2][1];2l+=\' 6i\';f=\'<v:3P 3q="\'+I+\'" 5j="p" 6p="H" 2l="\'+2l+\'" 3I="\'+3I+\'" \'+\'e="o:\'+7.8.e.f.N.o+\'1a; F:\'+7.8.e.f.N.F+\'1a; \'+\'2S-F:0.1B; 27:5c-4J; 3F:1z(#2L#3L); \'+\'4i-3o:\'+(w.y===\'K\'?\'26\':\'K\')+\'"></v:3P>\';f+=\'<v:3T e="3F:1z(#2L#3L);"></v:3T>\';7.d.1w.G(\'k\',\'4S\')}7.d.f=7.d.h.1J(\'.\'+7.8.e.1f.f).6E(0);7.d.f.2k(f);c($(\'<1e  />\').1p(0).1D){44.S(7,7.d.f.1J(\'1e:1U\'),X,I)}c(w.y===\'K\'&&$.15.1d&&1y($.15.2X.2H(0),10)===6){7.d.f.G({4f:-4})}4Q.S(7,w)}j 5x(){R 7=A;c(7.d.U!==1A){7.d.U.3W()}7.d.h.W(\'3p-6F\',\'g-\'+7.Y+\'-U\');7.d.U=$(\'<12 Y="g-\'+7.Y+\'-U" 1K="\'+7.8.e.1f.U+\'"></12>\').G(2G(7.8.e.U,H)).G({29:($.15.1d)?1:0}).4X(7.d.1w);c(7.8.u.U.1k){7.5W.S(7,7.8.u.U.1k)}c(7.8.u.U.1h!==p&&P 7.8.u.U.1h===\'1x\'){7.d.1h=$(\'<a 1K="\'+7.8.e.1f.1h+\'" 4W="1h" e="6H:25; k: 4S"></a>\').G(2G(7.8.e.1h,H)).2k(7.8.u.U.1h).4X(7.d.U).4V(j(r){c(!7.V.22){7.D(r)}})}}j 5i(){R 7,3h,2m,3t;7=A;3h=7.8.q.L.s;2m=7.8.D.L.s;c(7.8.D.3i){2m=2m.2o(7.d.h)}3t=[\'4V\',\'6h\',\'6l\',\'6j\',\'4R\',\'4T\',\'5d\',\'6m\',\'36\'];j 3w(r){c(7.V.22===H){B}2a(7.1E.1V);7.1E.1V=4D(j(){$(3t).1I(j(){2m.1Q(A+\'.g-1V\');7.d.u.1Q(A+\'.g-1V\')});7.D(r)},7.8.D.2V)}c(7.8.D.3i===H){7.d.h.1M(\'36.g\',j(){c(7.V.22===H){B}2a(7.1E.D)})}j 4C(r){c(7.V.22===H){B}c(7.8.D.L.r===\'1V\'){$(3t).1I(j(){2m.1M(A+\'.g-1V\',3w);7.d.u.1M(A+\'.g-1V\',3w)});3w()}2a(7.1E.q);2a(7.1E.D);c(7.8.q.2V>0){7.1E.q=4D(j(){7.q(r)},7.8.q.2V)}C{7.q(r)}}j 4E(r){c(7.V.22===H){B}c(7.8.D.3i===H&&(/1L(6q|6y)/i).1Y(7.8.D.L.r)&&$(r.70).52(\'12.g[Y^="g"]\').Q>0){r.7L();r.7K();2a(7.1E.D);B p}2a(7.1E.q);2a(7.1E.D);7.d.h.3R(H,H);7.1E.D=4D(j(){7.D(r)},7.8.D.2V)}c(7.8.k.s===\'1L\'&&7.8.k.17!==\'28\'){3h.1M(\'4R.g\',j(r){7.1v.1L={M:r.3Y,K:r.4x};c(7.V.22===p&&7.8.k.1g.1L===H&&7.8.k.17!==\'28\'&&7.d.h.G(\'27\')!==\'3a\'){7.2f(r)}})}c((7.8.q.L.s.2o(7.8.D.L.s).Q===1&&7.8.q.L.r===7.8.D.L.r&&7.8.D.L.r!==\'1V\')||7.8.D.L.r===\'4H\'){7.1v.2I=0;3h.1M(7.8.q.L.r+\'.g\',j(r){c(7.1v.2I===0){4C(r)}C{4E(r)}})}C{3h.1M(7.8.q.L.r+\'.g\',4C);c(7.8.D.L.r!==\'1V\'){2m.1M(7.8.D.L.r+\'.g\',4E)}}c((/(3i|34)/).1Y(7.8.k.17)){7.d.h.1M(\'36.g\',7.2E)}}j 21(){R 7,2k,2t;7=A;2t=7.3d();2k=\'<7J 1K="g-21" 7I="0" 7M="-1" 4G="7N:p" \'+\'e="27:4J; k:34; z-3x:-1; 5n:7R(2B=\\\'0\\\'); J: 1B 3s 4l; \'+\'F:\'+2t.F+\'1a; o:\'+2t.o+\'1a" />\';7.d.21=7.d.1u.3v(2k).2w(\'.g-21:1U\')}j 4c(){R 7,u,1z,Z,2A;7=A;7.5J.S(7);7.V.1b=2;7.d.h=\'<12 g="\'+7.Y+\'" Y="g-\'+7.Y+\'" 4W="h" \'+\'3p-7Q="g-\'+7.Y+\'-u" 1K="g \'+(7.8.e.1f.h||7.8.e)+\'" \'+\'e="27:3a; -7P-J-E:0; -7O-J-E:0; J-E:0; k:\'+7.8.k.17+\';"> \'+\'  <12 1K="g-1u" e="k:4S; 2u:1G; 1k-3o:M;"> \'+\'    <12 1K="g-1w" e="2u:1G;"> \'+\'       <12 Y="g-\'+7.Y+\'-u" 1K="g-u \'+7.8.e.1f.u+\'"></12> \'+\'</12></12></12>\';7.d.h=$(7.d.h);7.d.h.5P(7.8.k.3U);7.d.h.Z(\'g\',{3j:0,O:[7]});7.d.1u=7.d.h.2w(\'12:1U\');7.d.1w=7.d.1u.2w(\'12:1U\');7.d.u=7.d.1w.2w(\'12:1U\').G(2G(7.8.e));c($.15.1d){7.d.1u.2o(7.d.u).G({29:1})}c(7.8.D.L.r===\'4H\'){7.d.h.W(\'4H\',H)}c(P 7.8.e.o.2Z===\'2n\'){7.4s()}c($(\'<1e />\').1p(0).1D||$.15.1d){c(7.8.e.J.E>0){5v.S(7)}C{7.d.1w.G({J:7.8.e.J.o+\'1a 3s \'+7.8.e.J.I})}c(7.8.e.f.w!==p){4w.S(7)}}C{7.d.1w.G({J:7.8.e.J.o+\'1a 3s \'+7.8.e.J.I});7.8.e.J.E=0;7.8.e.f.w=p}c((P 7.8.u.1k===\'1x\'&&7.8.u.1k.Q>0)||(7.8.u.1k.48&&7.8.u.1k.Q>0)){u=7.8.u.1k}C{u=\' \'}c(7.8.u.U.1k!==p){5x.S(7)}7.4U(u,p);5i.S(7);c(7.8.q.3A===H){7.q()}c(7.8.u.1z!==p){1z=7.8.u.1z;Z=7.8.u.Z;2A=7.8.u.2A||\'1p\';7.5Z(1z,Z,2A)}7.V.1b=H;7.4Z.S(7)}j 5k(s,8,Y){R 7=A;7.Y=Y;7.8=8;7.V={4t:p,1b:p,22:p,3Z:p};7.d={s:s.5l(7.8.e.1f.s),h:1A,1u:1A,u:1A,1w:1A,U:1A,1h:1A,f:1A,21:1A};7.1v={W:p,1L:{},2I:0,2u:{M:p,K:p}};7.1E={};$.2r(7,7.8.T,{q:j(r){R 1c,1W;c(!7.V.1b){B p}c(7.d.h.G(\'27\')!==\'3a\'){B 7}7.d.h.3R(H,p);1c=7.5p.S(7,r);c(1c===p){B 7}j 2M(){7.d.h.W(\'3p-1G\',H);c(7.8.k.17!==\'28\'){7.2E()}7.5r.S(7,r);c($.15.1d){R 4B=7.d.h.1p(0).e;4B.4z(\'5n\');4B.4z(\'2B\')}C{7.d.h.G({2B:\'\'})}}7.1v.2I=1;c(7.8.k.17!==\'28\'){7.2f(r,(7.8.q.11.Q>0&&7.1b!==2))}c(P 7.8.q.1W===\'18\'){1W=$(7.8.q.1W)}C c(7.8.q.1W===H){1W=$(\'12.g\').5S(7.d.h)}c(1W){1W.1I(j(){c($(A).g(\'T\').V.1b===H){$(A).g(\'T\').D()}})}c(P 7.8.q.11.17===\'j\'){7.8.q.11.17.S(7.d.h,7.8.q.11.Q);7.d.h.5f(j(){2M();$(A).5g()})}C{4m(7.8.q.11.17.2F()){1X\'3u\':7.d.h.7H(7.8.q.11.Q,2M);1C;1X\'5h\':7.d.h.7G(7.8.q.11.Q,j(){2M();c(7.8.k.17!==\'28\'){7.2f(r,H)}});1C;1X\'5q\':7.d.h.q(7.8.q.11.Q,2M);1C;2L:7.d.h.q(1A,2M);1C}7.d.h.5l(7.8.e.1f.3O)}B 7},D:j(r){R 1c;c(!7.V.1b){B p}C c(7.d.h.G(\'27\')===\'3a\'){B 7}2a(7.1E.q);7.d.h.3R(H,p);1c=7.5t.S(7,r);c(1c===p){B 7}j 2K(){7.d.h.W(\'3p-1G\',H);c($.15.1d){7.d.h.1p(0).e.4z(\'2B\')}C{7.d.h.G({2B:\'\'})}7.5A.S(7,r)}7.1v.2I=0;c(P 7.8.D.11.17===\'j\'){7.8.D.11.17.S(7.d.h,7.8.D.11.Q);7.d.h.5f(j(){2K();$(A).5g()})}C{4m(7.8.D.11.17.2F()){1X\'3u\':7.d.h.7z(7.8.D.11.Q,2K);1C;1X\'5h\':7.d.h.7y(7.8.D.11.Q,2K);1C;1X\'5q\':7.d.h.D(7.8.D.11.Q,2K);1C;2L:7.d.h.D(1A,2K);1C}7.d.h.7x(7.8.e.1f.3O)}B 7},2I:j(r,38){R 5e=/7w|2n/.1Y(P 38)?38:!7.d.h.2q(\':2c\');7[5e?\'q\':\'D\'](r);B 7},2f:j(r,4r){c(!7.V.1b){B p}R 24=8.k,s=$(24.s),2Q=7.d.h.47(),2P=7.d.h.4P(),1m,1n,k,1o=24.w.h,2R=24.w.s,1c,14,i,4k,2h,4j={M:j(){R 3m=$(2g).3G(),3l=$(2g).o()+$(2g).3G(),2J=1o.x===\'1j\'?2Q/2:2Q,2N=1o.x===\'1j\'?1m/2:1m,2O=(1o.x===\'1j\'?1:2)*7.8.e.J.E,1q=-2*24.1g.x,3n=k.M+2Q,1i;c(3n>3l){1i=1q-2J-2N+2O;c(k.M+1i>3m||3m-(k.M+1i)<3n-3l){B{1g:1i,f:\'25\'}}}c(k.M<3m){1i=1q+2J+2N-2O;c(3n+1i<3l||3n+1i-3l<3m-k.M){B{1g:1i,f:\'M\'}}}B{1g:0,f:1o.x}},K:j(){R 30=$(2g).3H(),33=$(2g).F()+$(2g).3H(),2J=1o.y===\'1j\'?2P/2:2P,2N=1o.y===\'1j\'?1n/2:1n,2O=(1o.y===\'1j\'?1:2)*7.8.e.J.E,1q=-2*24.1g.y,32=k.K+2P,1i;c(32>33){1i=1q-2J-2N+2O;c(k.K+1i>30||30-(k.K+1i)<32-33){B{1g:1i,f:\'26\'}}}c(k.K<30){1i=1q+2J+2N-2O;c(32+1i<33||32+1i-33<30-k.K){B{1g:1i,f:\'K\'}}}B{1g:0,f:1o.y}}};c(r&&8.k.s===\'1L\'){2R={x:\'M\',y:\'K\'};1m=1n=0;c(!r.3Y){k=7.1v.1L}C{k={K:r.4x,M:r.3Y}}}C{c(s[0]===31){1m=s.o();1n=s.F();k={K:0,M:0}}C c(s[0]===2g){1m=s.o();1n=s.F();k={K:s.3H(),M:s.3G()}}C c(s.2q(\'7A\')){14=7.8.k.s.W(\'14\').7B(\',\');1S(i=0;i<14.Q;i++){14[i]=1y(14[i],10)}4k=7.8.k.s.3N(\'7F\').W(\'20\');2h=$(\'4K[7E="#\'+4k+\'"]:1U\').1q();k={M:1t.3J(2h.M+14[0]),K:1t.3J(2h.K+14[1])};4m(7.8.k.s.W(\'3P\').2F()){1X\'7T\':1m=1t.55(1t.54(14[2]-14[0]));1n=1t.55(1t.54(14[3]-14[1]));1C;1X\'7C\':1m=14[2]+1;1n=14[2]+1;1C;1X\'7S\':1m=14[0];1n=14[1];1S(i=0;i<14.Q;i++){c(i%2===0){c(14[i]>1m){1m=14[i]}c(14[i]<14[0]){k.M=1t.3J(2h.M+14[i])}}C{c(14[i]>1n){1n=14[i]}c(14[i]<14[1]){k.K=1t.3J(2h.K+14[i])}}}1m=1m-(k.M-2h.M);1n=1n-(k.K-2h.K);1C}1m-=2;1n-=2}C{1m=s.47();1n=s.4P();c(!7.d.h.2q(\':2c\')){7.d.h.G({M:\'-81\'}).q()}c(7.d.h.4n()[0]===31.5b){k=s.1q()}C{k=s.k();k.K+=s.4n().3H();k.M+=s.4n().3G()}}k.M+=2R.x===\'25\'?1m:2R.x===\'1j\'?1m/2:0;k.K+=2R.y===\'26\'?1n:2R.y===\'1j\'?1n/2:0}k.M+=24.1g.x+(1o.x===\'25\'?-2Q:1o.x===\'1j\'?-2Q/2:0);k.K+=24.1g.y+(1o.y===\'26\'?-2P:1o.y===\'1j\'?-2P/2:0);c(7.8.e.J.E>0){c(1o.x===\'M\'){k.M-=7.8.e.J.E}C c(1o.x===\'25\'){k.M+=7.8.e.J.E}c(1o.y===\'K\'){k.K-=7.8.e.J.E}C c(1o.y===\'26\'){k.K+=7.8.e.J.E}}c(24.1g.63){(j(){R 2W={x:0,y:0},2i={x:4j.M(),y:4j.K()},f=2T 2D(8.e.f.w);c(7.d.f&&f){c(2i.y.1g!==0){k.K+=2i.y.1g;f.y=2W.y=2i.y.f}c(2i.x.1g!==0){k.M+=2i.x.1g;f.x=2W.x=2i.x.f}7.1v.2u={M:2W.x===p,K:2W.y===p};c(7.d.f.W(\'1R\')!==f.1x()){4w.S(7,f)}}}())}c(!7.d.21&&$.15.1d&&1y($.15.2X.2H(0),10)===6){21.S(7)}1c=7.5u.S(7,r);c(1c===p){B 7}c(8.k.s!==\'1L\'&&4r===H){7.V.4t=H;7.d.h.3R().4r(k,7V,\'80\',j(){7.V.4t=p})}C{7.d.h.G(k)}7.5z.S(7,r);B 7},4s:j(1r){c(!7.V.1b||(1r&&P 1r!==\'2n\')){B p}R 1G=7.d.1w.7W().2o(7.d.f).2o(7.d.1h),29=7.d.1u.2o(7.d.1w.2w()),h=7.d.h,1H=7.8.e.o.1H,2b=7.8.e.o.2b;c(!1r){c(P 7.8.e.o.2Z===\'2n\'){1r=7.8.e.o.2Z}C{7.d.h.G({o:\'6e\'});1G.D();h.o(1r);c($.15.1d){29.G({29:\'\'})}1r=7.3d().o;c(!7.8.e.o.2Z){1r=1t.2b(1t.1H(1r,2b),1H)}}}c(1r%2){1r+=1}7.d.h.o(1r);1G.q();c(7.8.e.J.E){7.d.h.1J(\'.g-2s\').1I(j(i){$(A).o(1r-(7.8.e.J.E*2))})}c($.15.1d){29.G({29:1});7.d.1u.o(1r);c(7.d.21){7.d.21.o(1r).F(7.3d.F)}}B 7},7Y:j(20){R f,2j,1l,w,X;c(!7.V.1b||P 20!==\'1x\'||!$.19.g.3c[20]){B p}7.8.e=4e.S(7,$.19.g.3c[20],7.8.4v.e);7.d.u.G(2G(7.8.e));c(7.8.u.U.1k!==p){7.d.U.G(2G(7.8.e.U,H))}7.d.1w.G({7U:7.8.e.J.I});c(7.8.e.f.w!==p){c($(\'<1e />\').1p(0).1D){f=7.d.h.1J(\'.g-f 1e:1U\');1l=f.1p(0).1D(\'2d\');1l.5I(0,0,3C,3C);w=f.3N(\'12[1R]:1U\').W(\'1R\');X=42(w,7.8.e.f.N.o,7.8.e.f.N.F);44.S(7,f,X,7.8.e.f.I||7.8.e.J.I)}C c($.15.1d){f=7.d.h.1J(\'.g-f [5C="3P"]\');f.W(\'3q\',7.8.e.f.I||7.8.e.J.I)}}c(7.8.e.J.E>0){7.d.h.1J(\'.g-2s\').G({7X:7.8.e.J.I});c($(\'<1e />\').1p(0).1D){2j=4d(7.8.e.J.E);7.d.h.1J(\'.g-1u 1e\').1I(j(){1l=$(A).1p(0).1D(\'2d\');1l.5I(0,0,3C,3C);w=$(A).3N(\'12[1R]:1U\').W(\'1R\');4b.S(7,$(A),2j[w],7.8.e.J.E,7.8.e.J.I)})}C c($.15.1d){7.d.h.1J(\'.g-1u [5C="3y"]\').1I(j(){$(A).W(\'3q\',7.8.e.J.I)})}}B 7},4U:j(u,5F){R 3b,37,4I;j 4F(){7.4s();c(5F!==p){c(7.8.k.17!==\'28\'){7.2f(7.d.h.2q(\':2c\'),H)}c(7.8.e.f.w!==p){4Q.S(7)}}}c(!u){B p}3b=7.59.S(7,u);c(P 3b===\'1x\'){u=3b}C c(3b===p){B}c(7.V.1b){c($.15.1d){7.d.1w.2w().G({29:\'7Z\'})}c(u.48&&u.Q>0){u.5V(H).5P(7.d.u).q()}C{7.d.u.2k(u)}37=7.d.u.1J(\'4K[6O=p]\');c(37.Q>0){4I=0;37.1I(j(i){$(\'<4K 4G="\'+$(A).W(\'4G\')+\'" />\').7D(j(){c(++4I===37.Q){4F()}})})}C{4F()}}C{7.8.u.1k=u}7.58.S(7);B 7},5Z:j(1z,Z,2A){R 1c;j 4O(u){7.6g.S(7);7.4U(u)}c(!7.V.1b){B p}1c=7.5a.S(7);c(1c===p){B 7}c(2A===\'60\'){$.60(1z,Z,4O)}C{$.1p(1z,Z,4O)}B 7},5W:j(u){R 1c;c(!7.V.1b||!u){B p}1c=7.64.S(7);c(1c===p){B 7}c(7.d.1h){7.d.1h=7.d.1h.5V(H)}7.d.U.2k(u);c(7.d.1h){7.d.U.3v(7.d.1h)}7.65.S(7);B 7},2E:j(r){R 4A,3E,3B,1c;c(!7.V.1b||7.8.k.17===\'28\'){B p}4A=1y(7.d.h.G(\'z-3x\'),10);3E=7u+$(\'12.g[Y^="g"]\').Q-1;c(!7.V.3Z&&4A!==3E){1c=7.5D.S(7,r);c(1c===p){B 7}$(\'12.g[Y^="g"]\').5S(7.d.h).1I(j(){c($(A).g(\'T\').V.1b===H){3B=1y($(A).G(\'z-3x\'),10);c(P 3B===\'2n\'&&3B>-1){$(A).G({68:1y($(A).G(\'z-3x\'),10)-1})}$(A).g(\'T\').V.3Z=p}});7.d.h.G({68:3E});7.V.3Z=H;7.5E.S(7,r)}B 7},3X:j(38){7.V.22=38?H:p;B 7},3f:j(){R i,1c,O,4N=7.d.s.Z(\'46\'+7.1v.W[0]);1c=7.61.S(7);c(1c===p){B 7}c(7.V.1b){7.8.q.L.s.1Q(\'4R.g\',7.2f);7.8.q.L.s.1Q(\'4T.g\',7.D);7.8.q.L.s.1Q(7.8.q.L.r+\'.g\');7.8.D.L.s.1Q(7.8.D.L.r+\'.g\');7.d.h.1Q(7.8.D.L.r+\'.g\');7.d.h.1Q(\'36.g\',7.2E);7.d.h.3W()}C{7.8.q.L.s.1Q(7.8.q.L.r+\'.g-\'+7.Y+\'-4u\')}c(P 7.d.s.Z(\'g\')===\'18\'){O=7.d.s.Z(\'g\').O;c(P O===\'18\'&&O.Q>0){1S(i=0;i<O.Q-1;i++){c(O[i].Y===7.Y){O.5X(i,1)}}}}$.19.g.O.5X(7.Y,1);c(P O===\'18\'&&O.Q>0){7.d.s.Z(\'g\').3j=O.Q-1}C{7.d.s.73(\'g\')}c(4N){7.d.s.W(7.1v.W[0],4N)}7.62.S(7);B 7.d.s},72:j(){R q,1q;c(!7.V.1b){B p}q=(7.d.h.G(\'27\')!==\'3a\')?p:H;c(q){7.d.h.G({3V:\'1G\'}).q()}1q=7.d.h.1q();c(q){7.d.h.G({3V:\'2c\'}).D()}B 1q},3d:j(){R q,2t;c(!7.V.1b){B p}q=(!7.d.h.2q(\':2c\'))?H:p;c(q){7.d.h.G({3V:\'1G\'}).q()}2t={F:7.d.h.4P(),o:7.d.h.47()};c(q){7.d.h.G({3V:\'2c\'}).D()}B 2t}})}$.19.g=j(8,4q){R i,Y,O,1Z,2e,1T,16,T;c(P 8===\'1x\'){c($(A).Z(\'g\')){c(8===\'T\'){B $(A).Z(\'g\').O[$(A).Z(\'g\').3j]}C c(8===\'O\'){B $(A).Z(\'g\').O}}C{B $(A)}}C{c(!8){8={}}c(P 8.u!==\'18\'||(8.u.48&&8.u.Q>0)){8.u={1k:8.u}}c(P 8.u.U!==\'18\'){8.u.U={1k:8.u.U}}c(P 8.k!==\'18\'){8.k={w:8.k}}c(P 8.k.w!==\'18\'){8.k.w={s:8.k.w,h:8.k.w}}c(P 8.q!==\'18\'){8.q={L:8.q}}c(P 8.q.L!==\'18\'){8.q.L={r:8.q.L}}c(P 8.q.11!==\'18\'){8.q.11={17:8.q.11}}c(P 8.D!==\'18\'){8.D={L:8.D}}c(P 8.D.L!==\'18\'){8.D.L={r:8.D.L}}c(P 8.D.11!==\'18\'){8.D.11={17:8.D.11}}c(P 8.e!==\'18\'){8.e={20:8.e}}8.e=45(8.e);1Z=$.2r(H,{},$.19.g.39,8);1Z.e=4e.S({8:1Z},1Z.e);1Z.4v=$.2r(H,{},8)}B $(A).1I(j(){R 7=$(A),u=p;c(P 8===\'1x\'){1T=8.2F();O=$(A).g(\'O\');c(P O===\'18\'){c(4q===H&&1T===\'3f\'){1S(i=O.Q-1;i>-1;i--){c(\'18\'===P O[i]){O[i].3f()}}}C{c(4q!==H){O=[$(A).g(\'T\')]}1S(i=0;i<O.Q;i++){c(1T===\'3f\'){O[i].3f()}C c(O[i].V.1b===H){c(1T===\'q\'){O[i].q()}C c(1T===\'D\'){O[i].D()}C c(1T===\'2E\'){O[i].2E()}C c(1T===\'3X\'){O[i].3X(H)}C c(1T===\'71\'){O[i].3X(p)}C c(1T===\'7v\'){O[i].2f()}}}}}}C{16=$.2r(H,{},1Z);16.D.11.Q=1Z.D.11.Q;16.q.11.Q=1Z.q.11.Q;c(16.k.3U===p){16.k.3U=$(31.5b)}c(16.k.s===p){16.k.s=$(A)}c(16.q.L.s===p){16.q.L.s=$(A)}c(16.D.L.s===p){16.D.L.s=$(A)}16.k.w.h=2T 2D(16.k.w.h);16.k.w.s=2T 2D(16.k.w.s);c(!16.u.1k.Q){$([\'U\',\'6f\']).1I(j(i,W){R 2C=7.W(W);c(2C&&2C.Q){u=[W,2C];7.Z(\'46\'+W,2C).74(W);16.u.1k=2C.3k(/\\n/75,\'<78 />\');B p}})}Y=$.19.g.O.Q;1S(i=0;i<Y;i++){c(P $.19.g.O[i]===\'56\'){Y=i;1C}}2e=2T 5k($(A),16,Y);$.19.g.O[Y]=2e;2e.1v.W=u;c(P $(A).Z(\'g\')===\'18\'&&$(A).Z(\'g\')){c(P $(A).W(\'g\')===\'56\'){$(A).Z(\'g\').3j=$(A).Z(\'g\').O.Q}$(A).Z(\'g\').O.51(2e)}C{$(A).Z(\'g\',{3j:0,O:[2e]})}c(16.u.5y===p&&16.q.L.r!==p&&16.q.3A!==H){16.q.L.s.1M(16.q.L.r+\'.g-\'+Y+\'-4u\',{g:Y},j(r){T=$.19.g.O[r.Z.g];T.8.q.L.s.1Q(T.8.q.L.r+\'.g-\'+r.Z.g+\'-4u\');T.1v.1L={M:r.3Y,K:r.4x};4c.S(T);T.8.q.L.s.77(T.8.q.L.r)})}C{2e.1v.1L={M:16.q.L.s.1q().M,K:16.q.L.s.1q().K};4c.S(2e)}}})};$.19.g.O=[];$.19.g.19={W:$.19.W};$.19.W=j(W){R T=$(A).g(\'T\');B(35.Q===1&&(/U|6f/i).1Y(W)&&T.V&&T.V.1b===H)?$(A).Z(\'46\'+T.1v.W[0]):$.19.g.19.W.4a(A,35)};$.19.g.39={u:{5y:p,1k:p,1z:p,Z:1A,U:{1k:p,1h:p}},k:{s:p,w:{s:\'3Q\',h:\'3M\'},1g:{x:0,y:0,1L:H,63:p,3D:H,3K:H},17:\'34\',3U:p},q:{L:{s:p,r:\'36\'},11:{17:\'3u\',Q:5T},2V:76,1W:p,3A:p},D:{L:{s:p,r:\'4T\'},11:{17:\'3u\',Q:5T},2V:0,3i:p},T:{5J:j(){},4Z:j(){},5u:j(){},5z:j(){},5p:j(){},5r:j(){},5t:j(){},5A:j(){},59:j(){},58:j(){},5a:j(){},6g:j(){},64:j(){},65:j(){},61:j(){},62:j(){},5D:j(){},5E:j(){}}};$.19.g.3c={39:{1s:\'66\',I:\'#6Z\',2u:\'1G\',6Y:\'M\',o:{2b:0,1H:6S},2x:\'6R 6Q\',J:{o:1,E:0,I:\'#6P\'},f:{w:p,I:p,N:{o:13,F:13},2B:1},U:{1s:\'#6T\',6U:\'6X\',2x:\'6W 6V\'},1h:{79:\'7a\'},1f:{s:\'\',f:\'g-f\',U:\'g-U\',1h:\'g-1h\',u:\'g-u\',3O:\'g-3O\'}},5L:{J:{o:3,E:0,I:\'#7o\'},U:{1s:\'#7n\',I:\'#5M\'},1s:\'#7m\',I:\'#5M\',1f:{h:\'g-5L\'}},6c:{J:{o:3,E:0,I:\'#7p\'},U:{1s:\'#7q\',I:\'#6d\'},1s:\'66\',I:\'#6d\',1f:{h:\'g-6c\'}},69:{J:{o:3,E:0,I:\'#7t\'},U:{1s:\'#7s\',I:\'#67\'},1s:\'#7r\',I:\'#67\',1f:{h:\'g-69\'}},4l:{J:{o:3,E:0,I:\'#7l\'},U:{1s:\'#7k\',I:\'#6b\'},1s:\'#7e\',I:\'#6b\',1f:{h:\'g-4l\'}},4Y:{J:{o:3,E:0,I:\'#7d\'},U:{1s:\'#7c\',I:\'#53\'},1s:\'#7b\',I:\'#53\',1f:{h:\'g-4Y\'}},57:{J:{o:3,E:0,I:\'#7f\'},U:{1s:\'#7g\',I:\'#7j\'},1s:\'#7i\',I:\'#7h\',1f:{h:\'g-57\'}}}}(82));',62,499,'|||||||self|options||||if|elements|style|tip|qtip|tooltip||function|position||||width|false|show|event|target||content||corner||||this|return|else|hide|radius|height|css|true|color|border|top|when|left|size|interfaces|typeof|length|var|call|api|title|status|attr|coordinates|id|data||effect|div||coords|browser|config|type|object|fn|px|rendered|returned|msie|canvas|classes|adjust|button|adj|center|text|context|targetWidth|targetHeight|my|get|offset|newWidth|background|Math|wrapper|cache|contentWrapper|string|parseInt|url|null|1px|break|getContext|timers|finalStyle|hidden|max|each|find|class|mouse|bind|tips|containers|ieAdjust|unbind|rel|for|command|first|inactive|solo|case|test|opts|name|bgiframe|disabled|positionAdjust|posOptions|right|bottom|display|static|zoom|clearTimeout|min|visible||obj|updatePosition|window|imagePos|adapted|borders|html|path|hideTarget|number|add|margin|is|extend|betweenCorners|dimensions|overflow|styleExtend|children|padding|precedance|90|method|opacity|val|Corner|focus|toLowerCase|jQueryStyle|charAt|toggle|myOffset|afterHide|default|afterShow|atOffset|borderAdjust|elemHeight|elemWidth|at|line|new|styleObj|delay|adjusted|version|font|value|topEdge|document|pBottom|bottomEdge|absolute|arguments|mouseover|images|state|defaults|none|parsedContent|styles|getDimensions|borderTop|destroy|borderBottom|showTarget|fixed|current|replace|rightEdge|leftEdge|pRight|align|aria|fillcolor|delete|solid|inactiveEvents|fade|prepend|inactiveMethod|index|arc|styleArray|ready|elemIndex|300|scroll|newIndex|behavior|scrollLeft|scrollTop|coordsize|floor|resize|VML|topLeft|parent|active|shape|bottomRight|stop|newMargin|image|container|visiblity|remove|disable|pageX|focused|paddingSize|paddingCorner|calculateTip|borderCoord|drawTip|sanitizeStyle|old|outerWidth|jquery|sub|apply|drawBorder|construct|calculateBorders|buildStyle|marginTop|ltr|bottomLeft|vertical|adapt|mapName|red|switch|offsetParent|vertWidth|topRight|blanket|animate|updateWidth|animated|create|user|createTip|pageY|dir|removeAttribute|curIndex|ieStyle|showMethod|setTimeout|hideMethod|afterLoad|src|unfocus|loadedImages|block|img|betweenWidth|sideWidth|oldattr|setupContent|outerHeight|positionTip|mousemove|relative|mouseout|updateContent|click|role|prependTo|green|onRender||push|parents|58792E|abs|ceil|undefined|blue|onContentUpdate|beforeContentUpdate|beforeContentLoad|body|inline|mouseenter|condition|queue|dequeue|slide|assignEvents|stroked|QTip|addClass|middle|filter|match|beforeShow|grow|onShow|append|beforeHide|beforePositionUpdate|createBorder|String|createTitle|prerender|onPositionUpdate|onHide|bottomright|nodeName|beforeFocus|onFocus|reposition|fillStyle|270|clearRect|beforeRender|topright|cream|A27D35|topleft|unshift|appendTo|lineTo|in|not|100|beginPath|clone|updateTitle|splice|fill|loadContent|post|beforeDestroy|onDestroy|screen|beforeTitleUpdate|onTitleUpdate|white|f3f3f3|zIndex|dark|bottomleft|9C2F2F|light|454545|auto|alt|onContentLoad|dblclick|xe|mouseup|Right|mousedown|mouseleave|Left|moveTo|filled|out|endangle|startangle|use|strict|bottomcenter|rightcenter|qtipSelector|leave|topcenter|righttop|leftbottom|0px|rightbottom|eq|labelledby|while|float|borderWidth|leftcenter|marginLeft|search|lefttop|PI|complete|d3d3d3|9px|5px|250|e1e1e1|fontWeight|12px|7px|bold|textAlign|111|relatedTarget|enable|getPosition|removeData|removeAttr|gi|140|trigger|br|cursor|pointer|CDE6AC|b9db8c|A9DB66|F79992|ADD9ED|D0E9F5|4D9FBF|E5F6FE|5E99BD|f28279|CE6F6F|FBF7AA|F0DE7D|F9E98E|E2E2E2|f1f1f1|505050|404040|303030|15000|update|boolean|removeClass|slideUp|fadeOut|area|split|circle|load|usemap|map|slideDown|fadeIn|frameborder|iframe|preventDefault|stopPropagation|tabindex|javascript|webkit|moz|describedby|alpha|poly|rect|borderColor|200|siblings|backgroundColor|updateStyle|normal|swing|10000000em|jQuery'.split('|'),0,{}))

JS={extend:function(a,b){b=b||{};for(var c in b){if(a[c]===b[c])continue;a[c]=b[c]}return a},makeFunction:function(){return function(){return this.initialize?(this.initialize.apply(this,arguments)||this):this}},makeBridge:function(a){var b=function(){};b.prototype=a.prototype;return new b},bind:function(){var a=JS.array(arguments),b=a.shift(),c=a.shift()||null;return function(){return b.apply(c,a.concat(JS.array(arguments)))}},callsSuper:function(a){return a.SUPER===undefined?a.SUPER=/\bcallSuper\b/.test(a.toString()):a.SUPER},mask:function(a){var b=a.toString().replace(/callSuper/g,'super');a.toString=function(){return b};return a},array:function(a){if(!a)return[];if(a.toArray)return a.toArray();var b=a.length,c=[];while(b--)c[b]=a[b];return c},indexOf:function(a,b){for(var c=0,d=a.length;c<d;c++){if(a[c]===b)return c}return-1},isFn:function(a){return a instanceof Function},isType:function(a,b){if(!a||!b)return false;return(b instanceof Function&&a instanceof b)||(typeof b==='string'&&typeof a===b)||(a.isA&&a.isA(b))},ignore:function(a,b){return/^(include|extend)$/.test(a)&&typeof b==='object'}};JS.Module=JS.makeFunction();JS.extend(JS.Module.prototype,{END_WITHOUT_DOT:/([^\.])$/,initialize:function(a,b,c){this.__mod__=this;this.__inc__=[];this.__fns__={};this.__dep__=[];this.__mct__={};if(typeof a==='string'){this.__nom__=this.displayName=a}else{this.__nom__=this.displayName='';c=b;b=a}c=c||{};this.__res__=c._1||null;if(b)this.include(b,false);if(JS.Module.__chainq__)JS.Module.__chainq__.push(this)},setName:function(a){this.__nom__=this.displayName=a||'';for(var b in this.__mod__.__fns__)this.__name__(b);if(a&&this.__meta__)this.__meta__.setName(a+'.')},__name__:function(a){if(!this.__nom__)return;var b=this.__mod__.__fns__[a]||{};a=this.__nom__.replace(this.END_WITHOUT_DOT,'$1#')+a;if(JS.isFn(b.setName))return b.setName(a);if(JS.isFn(b))b.displayName=a},define:function(a,b,c,d){var f=(d||{})._0||this;this.__fns__[a]=b;this.__name__(a);if(JS.Module._0&&f&&JS.isFn(b))JS.Module._0(a,f);if(c!==false)this.resolve()},instanceMethod:function(a){var b=this.lookup(a).pop();return JS.isFn(b)?b:null},instanceMethods:function(a,b){var c=this.__mod__,b=b||[],d=c.ancestors(),f=d.length,e;for(e in c.__fns__){if(c.__fns__.hasOwnProperty(e)&&JS.isFn(c.__fns__[e])&&JS.indexOf(b,e)===-1)b.push(e)}if(a===false)return b;while(f--)d[f].instanceMethods(false,b);return b},include:function(a,b,c){b=(b!==false);if(!a)return b?this.resolve():this.uncache();c=c||{};if(a.__mod__)a=a.__mod__;var d=a.include,f=a.extend,e=c._4||this,g,h,i,j;if(a.__inc__&&a.__fns__){this.__inc__.push(a);a.__dep__.push(this);if(c._2)a.extended&&a.extended(c._2);else a.included&&a.included(e)}else{if(c._5){for(h in a){if(JS.ignore(h,a[h]))continue;this.define(h,a[h],false,{_0:e||c._2||this})}}else{if(typeof d==='object'||JS.isType(d,JS.Module)){g=[].concat(d);for(i=0,j=g.length;i<j;i++)e.include(g[i],b,c)}if(typeof f==='object'||JS.isType(f,JS.Module)){g=[].concat(f);for(i=0,j=g.length;i<j;i++)e.extend(g[i],false);e.extend()}c._5=true;return e.include(a,b,c)}}b?this.resolve():this.uncache()},includes:function(a){var b=this.__mod__,c=b.__inc__.length;if(Object===a||b===a||b.__res__===a.prototype)return true;while(c--){if(b.__inc__[c].includes(a))return true}return false},match:function(a){return a.isA&&a.isA(this)},ancestors:function(a){var b=this.__mod__,c=(a===undefined),d=(b.__res__||{}).klass,f=(d&&b.__res__===d.prototype)?d:b,e,g;if(c&&b.__anc__)return b.__anc__.slice();a=a||[];for(e=0,g=b.__inc__.length;e<g;e++)b.__inc__[e].ancestors(a);if(JS.indexOf(a,f)===-1)a.push(f);if(c)b.__anc__=a.slice();return a},lookup:function(a){var b=this.__mod__,c=b.__mct__;if(c[a])return c[a].slice();var d=b.ancestors(),f=[],e,g,h;for(e=0,g=d.length;e<g;e++){h=d[e].__mod__.__fns__[a];if(h)f.push(h)}c[a]=f.slice();return f},make:function(a,b){if(!JS.isFn(b)||!JS.callsSuper(b))return b;var c=this;return function(){return c.chain(this,a,arguments)}},chain:JS.mask(function(c,d,f){var e=this.lookup(d),g=e.length-1,h=c.callSuper,i=JS.array(f),j;c.callSuper=function(){var a=arguments.length;while(a--)i[a]=arguments[a];g-=1;var b=e[g].apply(c,i);g+=1;return b};j=e.pop().apply(c,i);h?c.callSuper=h:delete c.callSuper;return j}),resolve:function(a){var b=this.__mod__,a=a||b,c=a.__res__,d,f,e,g;if(a===b){b.uncache(false);d=b.__dep__.length;while(d--)b.__dep__[d].resolve()}if(!c)return;for(d=0,f=b.__inc__.length;d<f;d++)b.__inc__[d].resolve(a);for(e in b.__fns__){g=a.make(e,b.__fns__[e]);if(c[e]!==g)c[e]=g}},uncache:function(a){var b=this.__mod__,c=b.__dep__.length;b.__anc__=null;b.__mct__={};if(a===false)return;while(c--)b.__dep__[c].uncache()}});JS.Class=JS.makeFunction();JS.extend(JS.Class.prototype=JS.makeBridge(JS.Module),{initialize:function(a,b,c){if(typeof a==='string'){this.__nom__=this.displayName=a}else{this.__nom__=this.displayName='';c=b;b=a}var d=JS.extend(JS.makeFunction(),this);d.klass=d.constructor=this.klass;if(!JS.isFn(b)){c=b;b=Object}d.inherit(b);d.include(c,false);d.resolve();do{b.inherited&&b.inherited(d)}while(b=b.superclass);return d},inherit:function(a){this.superclass=a;if(this.__eigen__&&a.__eigen__)this.extend(a.__eigen__(),true);this.subclasses=[];(a.subclasses||[]).push(this);var b=this.prototype=JS.makeBridge(a);b.klass=b.constructor=this;this.__mod__=new JS.Module(this.__nom__,{},{_1:this.prototype});this.include(JS.Kernel,false);if(a!==Object)this.include(a.__mod__||new JS.Module(a.prototype,{_1:a.prototype}),false)},include:function(a,b,c){if(!a)return;var d=this.__mod__,c=c||{};c._4=this;return d.include(a,b,c)},define:function(a,b,c,d){var f=this.__mod__;d=d||{};d._0=this;f.define(a,b,c,d)}});JS.Module=new JS.Class('Module',JS.Module.prototype);JS.Class=new JS.Class('Class',JS.Module,JS.Class.prototype);JS.Module.klass=JS.Module.constructor=JS.Class.klass=JS.Class.constructor=JS.Class;JS.extend(JS.Module,{_3:[],__chainq__:[],methodAdded:function(a,b){this._3.push([a,b])},_0:function(a,b){var c=this._3,d=c.length;while(d--)c[d][0].call(c[d][1]||null,a,b)}});JS.Kernel=JS.extend(new JS.Module('Kernel',{__eigen__:function(){if(this.__meta__)return this.__meta__;var a=this.__nom__,b=this.klass.__nom__,c=a||(b?'#<'+b+'>':''),d=this.__meta__=new JS.Module(c?c+'.':'',{},{_1:this});d.include(this.klass.__mod__,false);return d},equals:function(a){return this===a},extend:function(a,b){return this.__eigen__().include(a,b,{_2:this})},hash:function(){return this.__hashcode__=this.__hashcode__||JS.Kernel.getHashCode()},isA:function(a){return this.__eigen__().includes(a)},method:function(a){var b=this,c=b.__mcache__=b.__mcache__||{};if((c[a]||{}).fn===b[a])return c[a].bd;return(c[a]={fn:b[a],bd:JS.bind(b[a],b)}).bd},methods:function(){return this.__eigen__().instanceMethods(true)},tap:function(a,b){a.call(b||null,this);return this}}),{__hashIndex__:0,getHashCode:function(){this.__hashIndex__+=1;return(Math.floor(new Date().getTime()/1000)+this.__hashIndex__).toString(16)}});JS.Module.include(JS.Kernel);JS.extend(JS.Module,JS.Kernel.__fns__);JS.Class.include(JS.Kernel);JS.extend(JS.Class,JS.Kernel.__fns__);JS.Interface=new JS.Class({initialize:function(d){this.test=function(a,b){var c=d.length;while(c--){if(!JS.isFn(a[d[c]]))return b?d[c]:false}return true}},extend:{ensure:function(){var a=JS.array(arguments),b=a.shift(),c,d;while(c=a.shift()){d=c.test(b,true);if(d!==true)throw new Error('object does not implement '+d+'()');}}}});JS.Singleton=new JS.Class({initialize:function(a,b,c){return new(new JS.Class(a,b,c))}});
// Copyright 2006 Google Inc.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
document.createElement("canvas").getContext||(function(){var s=Math,j=s.round,F=s.sin,G=s.cos,V=s.abs,W=s.sqrt,k=10,v=k/2;function X(){return this.context_||(this.context_=new H(this))}var L=Array.prototype.slice;function Y(b,a){var c=L.call(arguments,2);return function(){return b.apply(a,c.concat(L.call(arguments)))}}var M={init:function(b){if(/MSIE/.test(navigator.userAgent)&&!window.opera){var a=b||document;a.createElement("canvas");a.attachEvent("onreadystatechange",Y(this.init_,this,a))}},init_:function(b){b.namespaces.g_vml_||
b.namespaces.add("g_vml_","urn:schemas-microsoft-com:vml","#default#VML");b.namespaces.g_o_||b.namespaces.add("g_o_","urn:schemas-microsoft-com:office:office","#default#VML");if(!b.styleSheets.ex_canvas_){var a=b.createStyleSheet();a.owningElement.id="ex_canvas_";a.cssText="canvas{display:inline-block;overflow:hidden;text-align:left;width:300px;height:150px}g_vml_\\:*{behavior:url(#default#VML)}g_o_\\:*{behavior:url(#default#VML)}"}var c=b.getElementsByTagName("canvas"),d=0;for(;d<c.length;d++)this.initElement(c[d])},
initElement:function(b){if(!b.getContext){b.getContext=X;b.innerHTML="";b.attachEvent("onpropertychange",Z);b.attachEvent("onresize",$);var a=b.attributes;if(a.width&&a.width.specified)b.style.width=a.width.nodeValue+"px";else b.width=b.clientWidth;if(a.height&&a.height.specified)b.style.height=a.height.nodeValue+"px";else b.height=b.clientHeight}return b}};function Z(b){var a=b.srcElement;switch(b.propertyName){case "width":a.style.width=a.attributes.width.nodeValue+"px";a.getContext().clearRect();
break;case "height":a.style.height=a.attributes.height.nodeValue+"px";a.getContext().clearRect();break}}function $(b){var a=b.srcElement;if(a.firstChild){a.firstChild.style.width=a.clientWidth+"px";a.firstChild.style.height=a.clientHeight+"px"}}M.init();var N=[],B=0;for(;B<16;B++){var C=0;for(;C<16;C++)N[B*16+C]=B.toString(16)+C.toString(16)}function I(){return[[1,0,0],[0,1,0],[0,0,1]]}function y(b,a){var c=I(),d=0;for(;d<3;d++){var f=0;for(;f<3;f++){var h=0,g=0;for(;g<3;g++)h+=b[d][g]*a[g][f];c[d][f]=
h}}return c}function O(b,a){a.fillStyle=b.fillStyle;a.lineCap=b.lineCap;a.lineJoin=b.lineJoin;a.lineWidth=b.lineWidth;a.miterLimit=b.miterLimit;a.shadowBlur=b.shadowBlur;a.shadowColor=b.shadowColor;a.shadowOffsetX=b.shadowOffsetX;a.shadowOffsetY=b.shadowOffsetY;a.strokeStyle=b.strokeStyle;a.globalAlpha=b.globalAlpha;a.arcScaleX_=b.arcScaleX_;a.arcScaleY_=b.arcScaleY_;a.lineScale_=b.lineScale_}function P(b){var a,c=1;b=String(b);if(b.substring(0,3)=="rgb"){var d=b.indexOf("(",3),f=b.indexOf(")",d+
1),h=b.substring(d+1,f).split(",");a="#";var g=0;for(;g<3;g++)a+=N[Number(h[g])];if(h.length==4&&b.substr(3,1)=="a")c=h[3]}else a=b;return{color:a,alpha:c}}function aa(b){switch(b){case "butt":return"flat";case "round":return"round";case "square":default:return"square"}}function H(b){this.m_=I();this.mStack_=[];this.aStack_=[];this.currentPath_=[];this.fillStyle=this.strokeStyle="#000";this.lineWidth=1;this.lineJoin="miter";this.lineCap="butt";this.miterLimit=k*1;this.globalAlpha=1;this.canvas=b;
var a=b.ownerDocument.createElement("div");a.style.width=b.clientWidth+"px";a.style.height=b.clientHeight+"px";a.style.overflow="hidden";a.style.position="absolute";b.appendChild(a);this.element_=a;this.lineScale_=this.arcScaleY_=this.arcScaleX_=1}var i=H.prototype;i.clearRect=function(){this.element_.innerHTML=""};i.beginPath=function(){this.currentPath_=[]};i.moveTo=function(b,a){var c=this.getCoords_(b,a);this.currentPath_.push({type:"moveTo",x:c.x,y:c.y});this.currentX_=c.x;this.currentY_=c.y};
i.lineTo=function(b,a){var c=this.getCoords_(b,a);this.currentPath_.push({type:"lineTo",x:c.x,y:c.y});this.currentX_=c.x;this.currentY_=c.y};i.bezierCurveTo=function(b,a,c,d,f,h){var g=this.getCoords_(f,h),l=this.getCoords_(b,a),e=this.getCoords_(c,d);Q(this,l,e,g)};function Q(b,a,c,d){b.currentPath_.push({type:"bezierCurveTo",cp1x:a.x,cp1y:a.y,cp2x:c.x,cp2y:c.y,x:d.x,y:d.y});b.currentX_=d.x;b.currentY_=d.y}i.quadraticCurveTo=function(b,a,c,d){var f=this.getCoords_(b,a),h=this.getCoords_(c,d),g={x:this.currentX_+
0.6666666666666666*(f.x-this.currentX_),y:this.currentY_+0.6666666666666666*(f.y-this.currentY_)};Q(this,g,{x:g.x+(h.x-this.currentX_)/3,y:g.y+(h.y-this.currentY_)/3},h)};i.arc=function(b,a,c,d,f,h){c*=k;var g=h?"at":"wa",l=b+G(d)*c-v,e=a+F(d)*c-v,m=b+G(f)*c-v,r=a+F(f)*c-v;if(l==m&&!h)l+=0.125;var n=this.getCoords_(b,a),o=this.getCoords_(l,e),q=this.getCoords_(m,r);this.currentPath_.push({type:g,x:n.x,y:n.y,radius:c,xStart:o.x,yStart:o.y,xEnd:q.x,yEnd:q.y})};i.rect=function(b,a,c,d){this.moveTo(b,
a);this.lineTo(b+c,a);this.lineTo(b+c,a+d);this.lineTo(b,a+d);this.closePath()};i.strokeRect=function(b,a,c,d){var f=this.currentPath_;this.beginPath();this.moveTo(b,a);this.lineTo(b+c,a);this.lineTo(b+c,a+d);this.lineTo(b,a+d);this.closePath();this.stroke();this.currentPath_=f};i.fillRect=function(b,a,c,d){var f=this.currentPath_;this.beginPath();this.moveTo(b,a);this.lineTo(b+c,a);this.lineTo(b+c,a+d);this.lineTo(b,a+d);this.closePath();this.fill();this.currentPath_=f};i.createLinearGradient=function(b,
a,c,d){var f=new D("gradient");f.x0_=b;f.y0_=a;f.x1_=c;f.y1_=d;return f};i.createRadialGradient=function(b,a,c,d,f,h){var g=new D("gradientradial");g.x0_=b;g.y0_=a;g.r0_=c;g.x1_=d;g.y1_=f;g.r1_=h;return g};i.drawImage=function(b){var a,c,d,f,h,g,l,e,m=b.runtimeStyle.width,r=b.runtimeStyle.height;b.runtimeStyle.width="auto";b.runtimeStyle.height="auto";var n=b.width,o=b.height;b.runtimeStyle.width=m;b.runtimeStyle.height=r;if(arguments.length==3){a=arguments[1];c=arguments[2];h=g=0;l=d=n;e=f=o}else if(arguments.length==
5){a=arguments[1];c=arguments[2];d=arguments[3];f=arguments[4];h=g=0;l=n;e=o}else if(arguments.length==9){h=arguments[1];g=arguments[2];l=arguments[3];e=arguments[4];a=arguments[5];c=arguments[6];d=arguments[7];f=arguments[8]}else throw Error("Invalid number of arguments");var q=this.getCoords_(a,c),t=[];t.push(" <g_vml_:group",' coordsize="',k*10,",",k*10,'"',' coordorigin="0,0"',' style="width:',10,"px;height:",10,"px;position:absolute;");if(this.m_[0][0]!=1||this.m_[0][1]){var E=[];E.push("M11=",
this.m_[0][0],",","M12=",this.m_[1][0],",","M21=",this.m_[0][1],",","M22=",this.m_[1][1],",","Dx=",j(q.x/k),",","Dy=",j(q.y/k),"");var p=q,z=this.getCoords_(a+d,c),w=this.getCoords_(a,c+f),x=this.getCoords_(a+d,c+f);p.x=s.max(p.x,z.x,w.x,x.x);p.y=s.max(p.y,z.y,w.y,x.y);t.push("padding:0 ",j(p.x/k),"px ",j(p.y/k),"px 0;filter:progid:DXImageTransform.Microsoft.Matrix(",E.join(""),", sizingmethod='clip');")}else t.push("top:",j(q.y/k),"px;left:",j(q.x/k),"px;");t.push(' ">','<g_vml_:image src="',b.src,
'"',' style="width:',k*d,"px;"," height:",k*f,'px;"',' cropleft="',h/n,'"',' croptop="',g/o,'"',' cropright="',(n-h-l)/n,'"',' cropbottom="',(o-g-e)/o,'"'," />","</g_vml_:group>");this.element_.insertAdjacentHTML("BeforeEnd",t.join(""))};i.stroke=function(b){var a=[],c=P(b?this.fillStyle:this.strokeStyle),d=c.color,f=c.alpha*this.globalAlpha;a.push("<g_vml_:shape",' filled="',!!b,'"',' style="position:absolute;width:',10,"px;height:",10,'px;"',' coordorigin="0 0" coordsize="',k*10," ",k*10,'"',' stroked="',
!b,'"',' path="');var h={x:null,y:null},g={x:null,y:null},l=0;for(;l<this.currentPath_.length;l++){var e=this.currentPath_[l];switch(e.type){case "moveTo":a.push(" m ",j(e.x),",",j(e.y));break;case "lineTo":a.push(" l ",j(e.x),",",j(e.y));break;case "close":a.push(" x ");e=null;break;case "bezierCurveTo":a.push(" c ",j(e.cp1x),",",j(e.cp1y),",",j(e.cp2x),",",j(e.cp2y),",",j(e.x),",",j(e.y));break;case "at":case "wa":a.push(" ",e.type," ",j(e.x-this.arcScaleX_*e.radius),",",j(e.y-this.arcScaleY_*e.radius),
" ",j(e.x+this.arcScaleX_*e.radius),",",j(e.y+this.arcScaleY_*e.radius)," ",j(e.xStart),",",j(e.yStart)," ",j(e.xEnd),",",j(e.yEnd));break}if(e){if(h.x==null||e.x<h.x)h.x=e.x;if(g.x==null||e.x>g.x)g.x=e.x;if(h.y==null||e.y<h.y)h.y=e.y;if(g.y==null||e.y>g.y)g.y=e.y}}a.push(' ">');if(b)if(typeof this.fillStyle=="object"){var m=this.fillStyle,r=0,n={x:0,y:0},o=0,q=1;if(m.type_=="gradient"){var t=m.x1_/this.arcScaleX_,E=m.y1_/this.arcScaleY_,p=this.getCoords_(m.x0_/this.arcScaleX_,m.y0_/this.arcScaleY_),
z=this.getCoords_(t,E);r=Math.atan2(z.x-p.x,z.y-p.y)*180/Math.PI;if(r<0)r+=360;if(r<1.0E-6)r=0}else{var p=this.getCoords_(m.x0_,m.y0_),w=g.x-h.x,x=g.y-h.y;n={x:(p.x-h.x)/w,y:(p.y-h.y)/x};w/=this.arcScaleX_*k;x/=this.arcScaleY_*k;var R=s.max(w,x);o=2*m.r0_/R;q=2*m.r1_/R-o}var u=m.colors_;u.sort(function(ba,ca){return ba.offset-ca.offset});var J=u.length,da=u[0].color,ea=u[J-1].color,fa=u[0].alpha*this.globalAlpha,ga=u[J-1].alpha*this.globalAlpha,S=[],l=0;for(;l<J;l++){var T=u[l];S.push(T.offset*q+
o+" "+T.color)}a.push('<g_vml_:fill type="',m.type_,'"',' method="none" focus="100%"',' color="',da,'"',' color2="',ea,'"',' colors="',S.join(","),'"',' opacity="',ga,'"',' g_o_:opacity2="',fa,'"',' angle="',r,'"',' focusposition="',n.x,",",n.y,'" />')}else a.push('<g_vml_:fill color="',d,'" opacity="',f,'" />');else{var K=this.lineScale_*this.lineWidth;if(K<1)f*=K;a.push("<g_vml_:stroke",' opacity="',f,'"',' joinstyle="',this.lineJoin,'"',' miterlimit="',this.miterLimit,'"',' endcap="',aa(this.lineCap),
'"',' weight="',K,'px"',' color="',d,'" />')}a.push("</g_vml_:shape>");this.element_.insertAdjacentHTML("beforeEnd",a.join(""))};i.fill=function(){this.stroke(true)};i.closePath=function(){this.currentPath_.push({type:"close"})};i.getCoords_=function(b,a){var c=this.m_;return{x:k*(b*c[0][0]+a*c[1][0]+c[2][0])-v,y:k*(b*c[0][1]+a*c[1][1]+c[2][1])-v}};i.save=function(){var b={};O(this,b);this.aStack_.push(b);this.mStack_.push(this.m_);this.m_=y(I(),this.m_)};i.restore=function(){O(this.aStack_.pop(),
this);this.m_=this.mStack_.pop()};function ha(b){var a=0;for(;a<3;a++){var c=0;for(;c<2;c++)if(!isFinite(b[a][c])||isNaN(b[a][c]))return false}return true}function A(b,a,c){if(!!ha(a)){b.m_=a;if(c)b.lineScale_=W(V(a[0][0]*a[1][1]-a[0][1]*a[1][0]))}}i.translate=function(b,a){A(this,y([[1,0,0],[0,1,0],[b,a,1]],this.m_),false)};i.rotate=function(b){var a=G(b),c=F(b);A(this,y([[a,c,0],[-c,a,0],[0,0,1]],this.m_),false)};i.scale=function(b,a){this.arcScaleX_*=b;this.arcScaleY_*=a;A(this,y([[b,0,0],[0,a,
0],[0,0,1]],this.m_),true)};i.transform=function(b,a,c,d,f,h){A(this,y([[b,a,0],[c,d,0],[f,h,1]],this.m_),true)};i.setTransform=function(b,a,c,d,f,h){A(this,[[b,a,0],[c,d,0],[f,h,1]],true)};i.clip=function(){};i.arcTo=function(){};i.createPattern=function(){return new U};function D(b){this.type_=b;this.r1_=this.y1_=this.x1_=this.r0_=this.y0_=this.x0_=0;this.colors_=[]}D.prototype.addColorStop=function(b,a){a=P(a);this.colors_.push({offset:b,color:a.color,alpha:a.alpha})};function U(){}G_vmlCanvasManager=
M;CanvasRenderingContext2D=H;CanvasGradient=D;CanvasPattern=U})();

Bluff = {
  // This is the version of Bluff you are using.
  VERSION: '0.3.6',
  
  array: function(list) {
    if (list.length === undefined) return [list];
    var ary = [], i = list.length;
    while (i--) ary[i] = list[i];
    return ary;
  },
  
  array_new: function(length, filler) {
    var ary = [];
    while (length--) ary.push(filler);
    return ary;
  },
  
  each: function(list, block, context) {
    for (var i = 0, n = list.length; i < n; i++) {
      block.call(context || null, list[i], i);
    }
  },
  
  index: function(list, needle) {
    for (var i = 0, n = list.length; i < n; i++) {
      if (list[i] === needle) return i;
    }
    return -1;
  },
  
  keys: function(object) {
    var ary = [], key;
    for (key in object) ary.push(key);
    return ary;
  },
  
  map: function(list, block, context) {
    var results = [];
    this.each(list, function(item) {
      results.push(block.call(context || null, item));
    });
    return results;
  },
  
  reverse_each: function(list, block, context) {
    var i = list.length;
    while (i--) block.call(context || null, list[i], i);
  },
  
  sum: function(list) {
    var sum = 0, i = list.length;
    while (i--) sum += list[i];
    return sum;
  },
  
  Mini: {}
};

Bluff.Base = new JS.Class({
  extend: {
    // Draw extra lines showing where the margins and text centers are
    DEBUG: false,
    
    // Used for navigating the array of data to plot
    DATA_LABEL_INDEX: 0,
    DATA_VALUES_INDEX: 1,
    DATA_COLOR_INDEX: 2,
    
    // Space around text elements. Mostly used for vertical spacing
    LEGEND_MARGIN: 20,
    TITLE_MARGIN: 20,
    LABEL_MARGIN: 10,
    DEFAULT_MARGIN: 20,
    
    DEFAULT_TARGET_WIDTH:  800,
    
    THOUSAND_SEPARATOR: ','
  },
  
  // Blank space above the graph
  top_margin: null,
  
  // Blank space below the graph
  bottom_margin: null,
  
  // Blank space to the right of the graph
  right_margin: null,
  
  // Blank space to the left of the graph
  left_margin: null,
  
  // Blank space below the title
  title_margin: null,
  
  // Blank space below the legend
  legend_margin: null,
  
  // A hash of names for the individual columns, where the key is the array
  // index for the column this label represents.
  //
  // Not all columns need to be named.
  //
  // Example: {0: 2005, 3: 2006, 5: 2007, 7: 2008}
  labels: null,
  
  // Used internally for spacing.
  //
  // By default, labels are centered over the point they represent.
  center_labels_over_point: null,
  
  // Used internally for horizontal graph types.
  has_left_labels: null,
  
  // A label for the bottom of the graph
  x_axis_label: null,
  
  // A label for the left side of the graph
  y_axis_label: null,
  
  // x_axis_increment: null,
  
  // Manually set increment of the horizontal marking lines
  y_axis_increment: null,
  
  // Get or set the list of colors that will be used to draw the bars or lines.
  colors: null,
  
  // The large title of the graph displayed at the top
  title: null,
  
  // Font used for titles, labels, etc.
  font: null,
  
  font_color: null,
  
  // Prevent drawing of line markers
  hide_line_markers: null,
  
  // Prevent drawing of the legend
  hide_legend: null,
  
  // Prevent drawing of the title
  hide_title: null,
  
  // Prevent drawing of line numbers
  hide_line_numbers: null,
  
  // Message shown when there is no data. Fits up to 20 characters. Defaults
  // to "No Data."
  no_data_message: null,
  
  // The font size of the large title at the top of the graph
  title_font_size: null,
  
  // Optionally set the size of the font. Based on an 800x600px graph.
  // Default is 20.
  //
  // Will be scaled down if graph is smaller than 800px wide.
  legend_font_size: null,
  
  // The font size of the labels around the graph
  marker_font_size: null,
  
  // The color of the auxiliary lines
  marker_color: null,
  
  // The number of horizontal lines shown for reference
  marker_count: null,
  
  // You can manually set a minimum value instead of having the values
  // guessed for you.
  //
  // Set it after you have given all your data to the graph object.
  minimum_value: null,
  
  // You can manually set a maximum value, such as a percentage-based graph
  // that always goes to 100.
  //
  // If you use this, you must set it after you have given all your data to
  // the graph object.
  maximum_value: null,
  
  // Set to false if you don't want the data to be sorted with largest avg
  // values at the back.
  sort: null,
  
  // Experimental
  additional_line_values: null,
  
  // Experimental
  stacked: null,
  
  // Optionally set the size of the colored box by each item in the legend.
  // Default is 20.0
  //
  // Will be scaled down if graph is smaller than 800px wide.
  legend_box_size: null,
  
  // Set to true to enable tooltip displays
  tooltips: false,
  
  // If one numerical argument is given, the graph is drawn at 4/3 ratio
  // according to the given width (800 results in 800x600, 400 gives 400x300,
  // etc.).
  //
  // Or, send a geometry string for other ratios ('800x400', '400x225').
  initialize: function(renderer, target_width) {
    this._d = new Bluff.Renderer(renderer);
    target_width = target_width || this.klass.DEFAULT_TARGET_WIDTH;
    
    var geo;
    
    if (typeof target_width !== 'number') {
      geo = target_width.split('x');
      this._columns = parseFloat(geo[0]);
      this._rows = parseFloat(geo[1]);
    } else {
      this._columns = parseFloat(target_width);
      this._rows = this._columns * 0.75;
    }
    
    this.initialize_ivars();
    
    this._reset_themes();
    this.theme_keynote();
  },
  
  // Set instance variables for this object.
  //
  // Subclasses can override this, call super, then set values separately.
  //
  // This makes it possible to set defaults in a subclass but still allow
  // developers to change this values in their program.
  initialize_ivars: function() {
    // Internal for calculations
    this._raw_columns = 800;
    this._raw_rows = 800 * (this._rows/this._columns);
    this._column_count = 0;
    this.marker_count = null;
    this.maximum_value = this.minimum_value = null;
    this._has_data = false;
    this._data = [];
    this.labels = {};
    this._labels_seen = {};
    this.sort = true;
    this.title = null;
    
    this._scale = this._columns / this._raw_columns;
    
    this.marker_font_size = 21.0;
    this.legend_font_size = 20.0;
    this.title_font_size = 36.0;
    
    this.top_margin = this.bottom_margin =
    this.left_margin = this.right_margin = this.klass.DEFAULT_MARGIN;
    
    this.legend_margin = this.klass.LEGEND_MARGIN;
    this.title_margin = this.klass.TITLE_MARGIN;
    
    this.legend_box_size = 20.0;
    
    this.no_data_message = "No Data";
    
    this.hide_line_markers = this.hide_legend = this.hide_title = this.hide_line_numbers = false;
    this.center_labels_over_point = true;
    this.has_left_labels = false;
    
    this.additional_line_values = [];
    this._additional_line_colors = [];
    this._theme_options = {};
    
    this.x_axis_label = this.y_axis_label = null;
    this.y_axis_increment = null;
    this.stacked = null;
    this._norm_data = null;
  },
  
  // Sets the top, bottom, left and right margins to +margin+.
  set_margins: function(margin) {
    this.top_margin = this.left_margin = this.right_margin = this.bottom_margin = margin;
  },
  
  // Sets the font for graph text to the font at +font_path+.
  set_font: function(font_path) {
    this.font = font_path;
    this._d.font = this.font;
  },
  
  // Add a color to the list of available colors for lines.
  //
  // Example:
  //  add_color('#c0e9d3')
  add_color: function(colorname) {
    this.colors.push(colorname);
  },
  
  // Replace the entire color list with a new array of colors. Also
  // aliased as the colors= setter method.
  //
  // If you specify fewer colors than the number of datasets you intend
  // to draw, 'increment_color' will cycle through the array, reusing
  // colors as needed.
  //
  // Note that (as with the 'set_theme' method), you should set up the color
  // list before you send your data (via the 'data' method). Calls to the
  // 'data' method made prior to this call will use whatever color scheme
  // was in place at the time data was called.
  //
  // Example:
  //  replace_colors ['#cc99cc', '#d9e043', '#34d8a2']
  replace_colors: function(color_list) {
    this.colors = color_list || [];
    this._color_index = 0;
  },
  
  // You can set a theme manually. Assign a hash to this method before you
  // send your data.
  //
  //  graph.set_theme({
  //    colors: ['orange', 'purple', 'green', 'white', 'red'],
  //    marker_color: 'blue',
  //    background_colors: ['black', 'grey']
  //  })
  //
  // background_image: 'squirrel.png' is also possible.
  //
  // (Or hopefully something better looking than that.)
  //
  set_theme: function(options) {
    this._reset_themes();
    
    this._theme_options = {
      colors: ['black', 'white'],
      additional_line_colors: [],
      marker_color: 'white',
      font_color: 'black',
      background_colors: null,
      background_image: null
    };
    for (var key in options) this._theme_options[key] = options[key];
    
    this.colors = this._theme_options.colors;
    this.marker_color = this._theme_options.marker_color;
    this.font_color = this._theme_options.font_color || this.marker_color;
    this._additional_line_colors = this._theme_options.additional_line_colors;
    
    this._render_background();
  },
  
  // A color scheme similar to the popular presentation software.
  theme_keynote: function() {
    // Colors
    this._blue = '#6886B4';
    this._yellow = '#FDD84E';
    this._green = '#72AE6E';
    this._red = '#D1695E';
    this._purple = '#8A6EAF';
    this._orange = '#EFAA43';
    this._white = 'white';
    this.colors = [this._yellow, this._blue, this._green, this._red, this._purple, this._orange, this._white];
    
    this.set_theme({
      colors: this.colors,
      marker_color: 'white',
      font_color: 'white',
      background_colors: ['black', '#4a465a']
    });
  },
  
  // A color scheme plucked from the colors on the popular usability blog.
  theme_37signals: function() {
    // Colors
    this._green = '#339933';
    this._purple = '#cc99cc';
    this._blue = '#336699';
    this._yellow = '#FFF804';
    this._red = '#ff0000';
    this._orange = '#cf5910';
    this._black = 'black';
    this.colors = [this._yellow, this._blue, this._green, this._red, this._purple, this._orange, this._black];
    
    this.set_theme({
      colors: this.colors,
      marker_color: 'black',
      font_color: 'black',
      background_colors: ['#d1edf5', 'white']
    });
  },
  
  // A color scheme from the colors used on the 2005 Rails keynote
  // presentation at RubyConf.
  theme_rails_keynote: function() {
    // Colors
    this._green = '#00ff00';
    this._grey = '#333333';
    this._orange = '#ff5d00';
    this._red = '#f61100';
    this._white = 'white';
    this._light_grey = '#999999';
    this._black = 'black';
    this.colors = [this._green, this._grey, this._orange, this._red, this._white, this._light_grey, this._black];
    
    this.set_theme({
      colors: this.colors,
      marker_color: 'white',
      font_color: 'white',
      background_colors: ['#0083a3', '#0083a3']
    });
  },
  
  // A color scheme similar to that used on the popular podcast site.
  theme_odeo: function() {
    // Colors
    this._grey = '#202020';
    this._white = 'white';
    this._dark_pink = '#a21764';
    this._green = '#8ab438';
    this._light_grey = '#999999';
    this._dark_blue = '#3a5b87';
    this._black = 'black';
    this.colors = [this._grey, this._white, this._dark_blue, this._dark_pink, this._green, this._light_grey, this._black];
    
    this.set_theme({
      colors: this.colors,
      marker_color: 'white',
      font_color: 'white',
      background_colors: ['#ff47a4', '#ff1f81']
    });
  },
  
  // A pastel theme
  theme_pastel: function() {
    // Colors
    this.colors = [
                    '#a9dada', // blue
                    '#aedaa9', // green
                    '#daaea9', // peach
                    '#dadaa9', // yellow
                    '#a9a9da', // dk purple
                    '#daaeda', // purple
                    '#dadada' // grey
                  ];
    
    this.set_theme({
      colors: this.colors,
      marker_color: '#aea9a9', // Grey
      font_color: 'black',
      background_colors: 'white'
    });
  },
  
  // A greyscale theme
  theme_greyscale: function() {
    // Colors
    this.colors = [
                    '#282828', // 
                    '#383838', // 
                    '#686868', // 
                    '#989898', // 
                    '#c8c8c8', // 
                    '#e8e8e8' // 
                  ];
    
    this.set_theme({
      colors: this.colors,
      marker_color: '#aea9a9', // Grey
      font_color: 'black',
      background_colors: 'white'
    });
  },
  
  // Parameters are an array where the first element is the name of the dataset
  // and the value is an array of values to plot.
  //
  // Can be called multiple times with different datasets for a multi-valued
  // graph.
  //
  // If the color argument is nil, the next color from the default theme will
  // be used.
  //
  // NOTE: If you want to use a preset theme, you must set it before calling
  // data().
  //
  // Example:
  //   data("Bart S.", [95, 45, 78, 89, 88, 76], '#ffcc00')
  data: function(name, data_points, color) {
    data_points = (data_points === undefined) ? [] : data_points;
    color = color || null;
    
    data_points = Bluff.array(data_points); // make sure it's an array
    this._data.push([name, data_points, (color || this._increment_color())]);
    // Set column count if this is larger than previous counts
    this._column_count = (data_points.length > this._column_count) ? data_points.length : this._column_count;
    
    // Pre-normalize
    Bluff.each(data_points, function(data_point, index) {
      if (data_point === undefined) return;
      
      // Setup max/min so spread starts at the low end of the data points
      if (this.maximum_value === null && this.minimum_value === null)
        this.maximum_value = this.minimum_value = data_point;
      
      // TODO Doesn't work with stacked bar graphs
      // Original: @maximum_value = _larger_than_max?(data_point, index) ? max(data_point, index) : @maximum_value
      this.maximum_value = this._larger_than_max(data_point) ? data_point : this.maximum_value;
      if (this.maximum_value >= 0) this._has_data = true;
      
      this.minimum_value = this._less_than_min(data_point) ? data_point : this.minimum_value;
      if (this.minimum_value < 0) this._has_data = true;
    }, this);
  },
  
  // Overridden by subclasses to do the actual plotting of the graph.
  //
  // Subclasses should start by calling super() for this method.
  draw: function() {
    if (this.stacked) this._make_stacked();
    this._setup_drawing();
    
    this._debug(function() {
      // Outer margin
      this._d.rectangle(this.left_margin, this.top_margin,
                        this._raw_columns - this.right_margin, this._raw_rows - this.bottom_margin);
      // Graph area box
      this._d.rectangle(this._graph_left, this._graph_top, this._graph_right, this._graph_bottom);
    });
  },
  
  clear: function() {
    this._render_background();
  },
  
  // Calculates size of drawable area and draws the decorations.
  //
  // * line markers
  // * legend
  // * title
  _setup_drawing: function() {
    // Maybe should be done in one of the following functions for more granularity.
    if (!this._has_data) return this._draw_no_data();
    
    this._normalize();
    this._setup_graph_measurements();
    if (this.sort) this._sort_norm_data();
    
    this._draw_legend();
    this._draw_line_markers();
    this._draw_axis_labels();
    this._draw_title();
  },
  
  // Make copy of data with values scaled between 0-100
  _normalize: function(force) {
    if (this._norm_data === null || force === true) {
      this._norm_data = [];
      if (!this._has_data) return;
      
      this._calculate_spread();
      
      Bluff.each(this._data, function(data_row) {
        var norm_data_points = [];
        Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point) {
          if (data_point === null || data_point === undefined)
            norm_data_points.push(null);
          else
            norm_data_points.push((data_point - this.minimum_value) / this._spread);
        }, this);
        this._norm_data.push([data_row[this.klass.DATA_LABEL_INDEX], norm_data_points, data_row[this.klass.DATA_COLOR_INDEX]]);
      }, this);
    }
  },
  
  _calculate_spread: function() {
    this._spread = this.maximum_value - this.minimum_value;
    this._spread = this._spread > 0 ? this._spread : 1;
    this._significant_digits = 100/Math.pow(10,Math.round(Math.LOG10E*Math.log(this._spread)));
  },
  
  // Calculates size of drawable area, general font dimensions, etc.
  _setup_graph_measurements: function() {
    this._marker_caps_height = this.hide_line_markers ? 0 :
      this._calculate_caps_height(this.marker_font_size);
    this._title_caps_height = this.hide_title ? 0 :
      this._calculate_caps_height(this.title_font_size);
    this._legend_caps_height = this.hide_legend ? 0 :
      this._calculate_caps_height(this.legend_font_size);
    
    var longest_label,
        longest_left_label_width,
        line_number_width,
        last_label,
        extra_room_for_long_label,
        x_axis_label_height,
        key;
    
    if (this.hide_line_markers) {
      this._graph_left = this.left_margin;
      this._graph_right_margin = this.right_margin;
      this._graph_bottom_margin = this.bottom_margin;
    } else {
      longest_left_label_width = 0;
      if (this.has_left_labels) {
        longest_label = '';
        for (key in this.labels) {
          longest_label = longest_label.length > this.labels[key].length
              ? longest_label
              : this.labels[key];
        }
        longest_left_label_width = this._calculate_width(this.marker_font_size, longest_label) * 1.25;
      } else {
        longest_left_label_width = this._calculate_width(this.marker_font_size, this._label(this.maximum_value));
      }
      
      // Shift graph if left line numbers are hidden
      line_number_width = this.hide_line_numbers && !this.has_left_labels ?
      0.0 :
        longest_left_label_width + this.klass.LABEL_MARGIN * 2;
      
      this._graph_left = this.left_margin +
        line_number_width +
        (this.y_axis_label === null ? 0.0 : this._marker_caps_height + this.klass.LABEL_MARGIN * 2);
      
      // Make space for half the width of the rightmost column label.
      // Might be greater than the number of columns if between-style bar markers are used.
      last_label = -Infinity;
      for (key in this.labels)
        last_label = last_label > Number(key) ? last_label : Number(key);
      last_label = Math.round(last_label);
      extra_room_for_long_label = (last_label >= (this._column_count-1) && this.center_labels_over_point) ?
      this._calculate_width(this.marker_font_size, this.labels[last_label]) / 2 :
        0;
      this._graph_right_margin  = this.right_margin + extra_room_for_long_label;
      
      this._graph_bottom_margin = this.bottom_margin +
        this._marker_caps_height + this.klass.LABEL_MARGIN;
    }
    
    this._graph_right = this._raw_columns - this._graph_right_margin;
    this._graph_width = this._raw_columns - this._graph_left - this._graph_right_margin;
    
    // When hide_title, leave a title_margin space for aesthetics.
    // Same with hide_legend
    this._graph_top = this.top_margin +
      (this.hide_title  ? this.title_margin  : this._title_caps_height  + this.title_margin ) +
      (this.hide_legend ? this.legend_margin : this._legend_caps_height + this.legend_margin);
    
    x_axis_label_height = (this.x_axis_label === null) ? 0.0 :
      this._marker_caps_height + this.klass.LABEL_MARGIN;
    this._graph_bottom = this._raw_rows - this._graph_bottom_margin - x_axis_label_height;
    this._graph_height = this._graph_bottom - this._graph_top;
  },
  
  // Draw the optional labels for the x axis and y axis.
  _draw_axis_labels: function() {
    if (this.x_axis_label) {
      // X Axis
      // Centered vertically and horizontally by setting the
      // height to 1.0 and the width to the width of the graph.
      var x_axis_label_y_coordinate = this._graph_bottom + this.klass.LABEL_MARGIN * 2 + this._marker_caps_height;
      
      // TODO Center between graph area
      this._d.fill = this.font_color;
      if (this.font) this._d.font = this.font;
      this._d.stroke = 'transparent';
      this._d.pointsize = this._scale_fontsize(this.marker_font_size);
      this._d.gravity = 'north';
      this._d.annotate_scaled(
                              this._raw_columns, 1.0,
                              0.0, x_axis_label_y_coordinate,
                              this.x_axis_label, this._scale);
      this._debug(function() {
        this._d.line(0.0, x_axis_label_y_coordinate, this._raw_columns, x_axis_label_y_coordinate);
      });
    }
    
    // TODO Y label (not generally possible in browsers)
  },
  
  // Draws horizontal background lines and labels
  _draw_line_markers: function() {
    if (this.hide_line_markers) return;
    
    if (this.y_axis_increment === null) {
      // Try to use a number of horizontal lines that will come out even.
      //
      // TODO Do the same for larger numbers...100, 75, 50, 25
      if (this.marker_count === null) {
        Bluff.each([3,4,5,6,7], function(lines) {
          if (!this.marker_count && this._spread % lines === 0)
            this.marker_count = lines;
        }, this);
        this.marker_count = this.marker_count || 4;
      }
      this._increment = (this._spread > 0) ? this._significant(this._spread / this.marker_count) : 1;
    } else {
      // TODO Make this work for negative values
      this.maximum_value = Math.max(Math.ceil(this.maximum_value), this.y_axis_increment);
      this.minimum_value = Math.floor(this.minimum_value);
      this._calculate_spread();
      this._normalize(true);
      
      this.marker_count = Math.round(this._spread / this.y_axis_increment);
      this._increment = this.y_axis_increment;
    }
    this._increment_scaled = this._graph_height / (this._spread / this._increment);
    
    // Draw horizontal line markers and annotate with numbers
    var index, n, y, marker_label;
    for (index = 0, n = this.marker_count; index <= n; index++) {
      y = this._graph_top + this._graph_height - index * this._increment_scaled;
      
      this._d.stroke = this.marker_color;
      this._d.stroke_width = 1;
      this._d.line(this._graph_left, y, this._graph_right, y);
      
      marker_label = index * this._increment + this.minimum_value;
      
      if (!this.hide_line_numbers) {
        this._d.fill = this.font_color;
        if (this.font) this._d.font = this.font;
        this._d.font_weight = 'normal';
        this._d.stroke = 'transparent';
        this._d.pointsize = this._scale_fontsize(this.marker_font_size);
        this._d.gravity = 'east';
        
        // Vertically center with 1.0 for the height
        this._d.annotate_scaled(this._graph_left - this.klass.LABEL_MARGIN,
                                1.0, 0.0, y,
                                this._label(marker_label), this._scale);
      }
    }
  },
  
  _center: function(size) {
    return (this._raw_columns - size) / 2;
  },
  
  // Draws a legend with the names of the datasets matched to the colors used
  // to draw them.
  _draw_legend: function() {
    if (this.hide_legend) return;
    
    this._legend_labels = Bluff.map(this._data, function(item) {
      return item[this.klass.DATA_LABEL_INDEX];
    }, this);
    
    var legend_square_width = this.legend_box_size; // small square with color of this item
    
    // May fix legend drawing problem at small sizes
    if (this.font) this._d.font = this.font;
    this._d.pointsize = this.legend_font_size;
    
    var label_widths = [[]]; // Used to calculate line wrap
    Bluff.each(this._legend_labels, function(label) {
      var last = label_widths.length - 1;
      var metrics = this._d.get_type_metrics(label);
      var label_width = metrics.width + legend_square_width * 2.7;
      label_widths[last].push(label_width);
      
      if (Bluff.sum(label_widths[last]) > (this._raw_columns * 0.9))
        label_widths.push([label_widths[last].pop()]);
    }, this);
    
    var current_x_offset = this._center(Bluff.sum(label_widths[0]));
    var current_y_offset = this.hide_title ?
    this.top_margin + this.title_margin :
      this.top_margin + this.title_margin + this._title_caps_height;
    
    this._debug(function() {
      this._d.stroke_width = 1;
      this._d.line(0, current_y_offset, this._raw_columns, current_y_offset);
    });
    
    Bluff.each(this._legend_labels, function(legend_label, index) {
      
      // Draw label
      this._d.fill = this.font_color;
      if (this.font) this._d.font = this.font;
      this._d.pointsize = this._scale_fontsize(this.legend_font_size);
      this._d.stroke = 'transparent';
      this._d.font_weight = 'normal';
      this._d.gravity = 'west';
      this._d.annotate_scaled(this._raw_columns, 1.0,
                              current_x_offset + (legend_square_width * 1.7), current_y_offset,
                              legend_label, this._scale);
      
      // Now draw box with color of this dataset
      this._d.stroke = 'transparent';
      this._d.fill = this._data[index][this.klass.DATA_COLOR_INDEX];
      this._d.rectangle(current_x_offset,
                        current_y_offset - legend_square_width / 2.0,
                        current_x_offset + legend_square_width,
                        current_y_offset + legend_square_width / 2.0);
      
      this._d.pointsize = this.legend_font_size;
      var metrics = this._d.get_type_metrics(legend_label);
      var current_string_offset = metrics.width + (legend_square_width * 2.7),
          line_height;
      
      // Handle wrapping
      label_widths[0].shift();
      if (label_widths[0].length == 0) {
        this._debug(function() {
          this._d.line(0.0, current_y_offset, this._raw_columns, current_y_offset);
        });
        
        label_widths.shift();
        if (label_widths.length > 0) current_x_offset = this._center(Bluff.sum(label_widths[0]));
        line_height = Math.max(this._legend_caps_height, legend_square_width) + this.legend_margin;
        if (label_widths.length > 0) {
          // Wrap to next line and shrink available graph dimensions
          current_y_offset += line_height;
          this._graph_top += line_height;
          this._graph_height = this._graph_bottom - this._graph_top;
        }
      } else {
        current_x_offset += current_string_offset;
      }
    }, this);
    this._color_index = 0;
  },
  
  // Draws a title on the graph.
  _draw_title: function() {
    if (this.hide_title || !this.title) return;
    
    this._d.fill = this.font_color;
    if (this.font) this._d.font = this.font;
    this._d.pointsize = this._scale_fontsize(this.title_font_size);
    this._d.font_weight = 'bold';
    this._d.gravity = 'north';
    this._d.annotate_scaled(this._raw_columns, 1.0,
                            0, this.top_margin,
                            this.title, this._scale);
  },
  
  // Draws column labels below graph, centered over x_offset
  //--
  // TODO Allow WestGravity as an option
  _draw_label: function(x_offset, index) {
    if (this.hide_line_markers) return;
    
    var y_offset;
    
    if (this.labels[index] && !this._labels_seen[index]) {
      y_offset = this._graph_bottom + this.klass.LABEL_MARGIN;
      
      this._d.fill = this.font_color;
      if (this.font) this._d.font = this.font;
      this._d.stroke = 'transparent';
      this._d.font_weight = 'normal';
      this._d.pointsize = this._scale_fontsize(this.marker_font_size);
      this._d.gravity = 'north';
      this._d.annotate_scaled(1.0, 1.0,
                              x_offset, y_offset,
                              this.labels[index], this._scale);
      this._labels_seen[index] = true;
      
      this._debug(function() {
        this._d.stroke_width = 1;
        this._d.line(0.0, y_offset, this._raw_columns, y_offset);
      });
    }
  },
  
  // Creates a mouse hover target rectangle for tooltip displays
  _draw_tooltip: function(left, top, width, height, name, color, data) {
    if (!this.tooltips) return;
    this._d.tooltip(left, top, width, height, name, color, data);
  },
  
  // Shows an error message because you have no data.
  _draw_no_data: function() {
    this._d.fill = this.font_color;
    if (this.font) this._d.font = this.font;
    this._d.stroke = 'transparent';
    this._d.font_weight = 'normal';
    this._d.pointsize = this._scale_fontsize(80);
    this._d.gravity = 'center';
    this._d.annotate_scaled(this._raw_columns, this._raw_rows/2,
                            0, 10,
                            this.no_data_message, this._scale);
  },
  
  // Finds the best background to render based on the provided theme options.
  _render_background: function() {
    var colors = this._theme_options.background_colors;
    switch (true) {
      case colors instanceof Array:
        this._render_gradiated_background.apply(this, colors);
        break;
      case typeof colors === 'string':
        this._render_solid_background(colors);
        break;
      default:
        this._render_image_background(this._theme_options.background_image);
        break;
    }
  },
  
  // Make a new image at the current size with a solid +color+.
  _render_solid_background: function(color) {
    this._d.render_solid_background(this._columns, this._rows, color);
  },
  
  // Use with a theme definition method to draw a gradiated background.
  _render_gradiated_background: function(top_color, bottom_color) {
    this._d.render_gradiated_background(this._columns, this._rows, top_color, bottom_color);
  },
  
  // Use with a theme to use an image (800x600 original) background.
  _render_image_background: function(image_path) {
    // TODO
  },
  
  // Resets everything to defaults (except data).
  _reset_themes: function() {
    this._color_index = 0;
    this._labels_seen = {};
    this._theme_options = {};
    this._d.scale(this._scale, this._scale);
  },
  
  _scale_value: function(value) {
    return this._scale * value;
  },
  
  // Return a comparable fontsize for the current graph.
  _scale_fontsize: function(value) {
    var new_fontsize = value * this._scale;
    return new_fontsize;
  },
  
  _clip_value_if_greater_than: function(value, max_value) {
    return (value > max_value) ? max_value : value;
  },
  
  // Overridden by subclasses such as stacked bar.
  _larger_than_max: function(data_point, index) {
    return data_point > this.maximum_value;
  },
  
  _less_than_min: function(data_point, index) {
    return data_point < this.minimum_value;
  },
  
  // Overridden by subclasses that need it.
  _max: function(data_point, index) {
    return data_point;
  },
  
  // Overridden by subclasses that need it.
  _min: function(data_point, index) {
    return data_point;
  },
  
  _significant: function(inc) {
    if (inc == 0) return 1.0;
    var factor = 1.0;
    while (inc < 10) {
      inc *= 10;
      factor /= 10;
    }
    
    while (inc > 100) {
      inc /= 10;
      factor *= 10;
    }
    
    return Math.floor(inc) * factor;
  },
  
  // Sort with largest overall summed value at front of array so it shows up
  // correctly in the drawn graph.
  _sort_norm_data: function() {
    var sums = this._sums, index = this.klass.DATA_VALUES_INDEX;
    
    this._norm_data.sort(function(a,b) {
      return sums(b[index]) - sums(a[index]);
    });
    
    this._data.sort(function(a,b) {
      return sums(b[index]) - sums(a[index]);
    });
  },
  
  _sums: function(data_set) {
    var total_sum = 0;
    Bluff.each(data_set, function(num) { total_sum += (num || 0) });
    return total_sum;
  },
  
  _make_stacked: function() {
    var stacked_values = [], i = this._column_count;
    while (i--) stacked_values[i] = 0;
    Bluff.each(this._data, function(value_set) {
      Bluff.each(value_set[this.klass.DATA_VALUES_INDEX], function(value, index) {
        stacked_values[index] += value;
      }, this);
      value_set[this.klass.DATA_VALUES_INDEX] = Bluff.array(stacked_values);
    }, this);
  },
  
  // Takes a block and draws it if DEBUG is true.
  //
  // Example:
  //   debug { @d.rectangle x1, y1, x2, y2 }
  _debug: function(block) {
    if (this.klass.DEBUG) {
      this._d.fill = 'transparent';
      this._d.stroke = 'turquoise';
      block.call(this);
    }
  },
  
  // Returns the next color in your color list.
  _increment_color: function() {
    if (this._color_index < this.colors.length) {
      this._color_index += 1;
    } else {
      // Start over
      this._color_index = 0;
    }
    // Return pre-incremented index element.
    var offset = (this._color_index == 0) ? this.colors.length : this._color_index;
    return this.colors[offset - 1];
  },
  
  // Return a formatted string representing a number value that should be
  // printed as a label.
  _label: function(value) {
    var sep   = this.klass.THOUSAND_SEPARATOR,
        label = (this._spread % this.marker_count == 0 || this.y_axis_increment !== null)
        ? String(Math.round(value))
        : String(Math.floor(value * this._significant_digits)/this._significant_digits);
    
    var parts = label.split('.');
    parts[0] = parts[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1' + sep);
    return parts.join('.');
  },
  
  // Returns the height of the capital letter 'X' for the current font and
  // size.
  //
  // Not scaled since it deals with dimensions that the regular scaling will
  // handle.
  _calculate_caps_height: function(font_size) {
    return this._d.caps_height(font_size);
  },
  
  // Returns the width of a string at this pointsize.
  //
  // Not scaled since it deals with dimensions that the regular 
  // scaling will handle.
  _calculate_width: function(font_size, text) {
    return this._d.text_width(font_size, text);
  }
});


Bluff.Area = new JS.Class(Bluff.Base, {
  
  draw: function() {
    this.callSuper();
    
    if (!this._has_data) return;
    
    this._x_increment = this._graph_width / (this._column_count - 1);
    this._d.stroke = 'transparent';
    
    Bluff.each(this._norm_data, function(data_row) {
      var poly_points = [],
          prev_x = 0.0,
          prev_y = 0.0;
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, index) {
        // Use incremented x and scaled y
        var new_x = this._graph_left + (this._x_increment * index);
        var new_y = this._graph_top + (this._graph_height - data_point * this._graph_height);
        
        if (prev_x > 0 && prev_y > 0) {
          poly_points.push(new_x);
          poly_points.push(new_y);
          
          // this._d.polyline(prev_x, prev_y, new_x, new_y);
        } else {
          poly_points.push(this._graph_left);
          poly_points.push(this._graph_bottom - 1);
          poly_points.push(new_x);
          poly_points.push(new_y);
          
          // this._d.polyline(this._graph_left, this._graph_bottom, new_x, new_y);
        }
        
        this._draw_label(new_x, index);
        
        prev_x = new_x;
        prev_y = new_y;
      }, this);
      
      // Add closing points, draw polygon
      poly_points.push(this._graph_right);
      poly_points.push(this._graph_bottom - 1);
      poly_points.push(this._graph_left);
      poly_points.push(this._graph_bottom - 1);
      
      this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
      this._d.polyline(poly_points);
      
    }, this);
  }
});


//	This class perfoms the y coordinats conversion for the bar class.
//
//	There are three cases: 
//
//    1. Bars all go from zero in positive direction
//		2. Bars all go from zero to negative direction	
//		3. Bars either go from zero to positive or from zero to negative
//
Bluff.BarConversion = new JS.Class({
	mode:           null,
	zero:           null,
	graph_top:      null,
	graph_height:   null,
	minimum_value:  null,
	spread:         null,
	
	getLeftYRightYscaled: function(data_point, result) {
	  var val;
		switch (this.mode) {
		  case 1: // Case one
			  // minimum value >= 0 ( only positiv values )
        result[0] = this.graph_top + this.graph_height*(1 - data_point) + 1;
    		result[1] = this.graph_top + this.graph_height - 1;
    		break;
		  case 2:  // Case two
			  // only negativ values
     		result[0] = this.graph_top + 1;
    		result[1] = this.graph_top + this.graph_height*(1 - data_point) - 1;
    		break;
		  case 3: // Case three
			  // positiv and negativ values
      	val = data_point-this.minimum_value/this.spread;
      	if ( data_point >= this.zero ) {
      		result[0] = this.graph_top + this.graph_height*(1 - (val-this.zero)) + 1;
	      	result[1] = this.graph_top + this.graph_height*(1 - this.zero) - 1;
      	} else {
				  result[0] = this.graph_top + this.graph_height*(1 - (val-this.zero)) + 1;
	      	result[1] = this.graph_top + this.graph_height*(1 - this.zero) - 1;
      	}
      	break;
		  default:
			  result[0] = 0.0;
			  result[1] = 0.0;
		}				
	}	
  
});


Bluff.Bar = new JS.Class(Bluff.Base, {
  
  // Spacing factor applied between bars
  bar_spacing: 0.9,
  
  draw: function() {
    // Labels will be centered over the left of the bar if
    // there are more labels than columns. This is basically the same 
    // as where it would be for a line graph.
    this.center_labels_over_point = (Bluff.keys(this.labels).length > this._column_count);
    
    this.callSuper();
    if (!this._has_data) return;
    
    this._draw_bars();
  },
  
  _draw_bars: function() {
    this._bar_width = this._graph_width / (this._column_count * this._data.length);
    var padding = (this._bar_width * (1 - this.bar_spacing)) / 2;
    
    this._d.stroke_opacity = 0.0;
    
    // Setup the BarConversion Object
    var conversion = new Bluff.BarConversion();
    conversion.graph_height = this._graph_height;
    conversion.graph_top = this._graph_top;
    
    // Set up the right mode [1,2,3] see BarConversion for further explanation
    if (this.minimum_value >= 0) {
      // all bars go from zero to positiv
      conversion.mode = 1;
    } else {
      // all bars go from 0 to negativ
      if (this.maximum_value <= 0) {
        conversion.mode = 2;
      } else {
        // bars either go from zero to negativ or to positiv
        conversion.mode = 3;
        conversion.spread = this._spread;
        conversion.minimum_value = this.minimum_value;
        conversion.zero = -this.minimum_value/this._spread;
      }
    }
    
    // iterate over all normalised data
    Bluff.each(this._norm_data, function(data_row, row_index) {
      var raw_data = this._data[row_index][this.klass.DATA_VALUES_INDEX];
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, point_index) {
        // Use incremented x and scaled y
        // x
        var left_x = this._graph_left + (this._bar_width * (row_index + point_index + ((this._data.length - 1) * point_index))) + padding;
        var right_x = left_x + this._bar_width * this.bar_spacing;
        // y
        var conv = [];
        conversion.getLeftYRightYscaled(data_point, conv);
        
        // create new bar
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.rectangle(left_x, conv[0], right_x, conv[1]);
        
        // create tooltip target
        this._draw_tooltip(left_x, conv[0],
                           right_x - left_x, conv[1] - conv[0],
                           data_row[this.klass.DATA_LABEL_INDEX],
                           data_row[this.klass.DATA_COLOR_INDEX],
                           raw_data[point_index]);
        
        // Calculate center based on bar_width and current row
        var label_center = this._graph_left + 
                          (this._data.length * this._bar_width * point_index) + 
                          (this._data.length * this._bar_width / 2.0);
        // Subtract half a bar width to center left if requested
        this._draw_label(label_center - (this.center_labels_over_point ? this._bar_width / 2.0 : 0.0), point_index);
      }, this);
      
    }, this);
    
    // Draw the last label if requested
    if (this.center_labels_over_point) this._draw_label(this._graph_right, this._column_count);
  }
});


// Here's how to make a Line graph:
//
//   g = new Bluff.Line('canvasId');
//   g.title = "A Line Graph";
//   g.data('Fries', [20, 23, 19, 8]);
//   g.data('Hamburgers', [50, 19, 99, 29]);
//   g.draw();
//
// There are also other options described below, such as #baseline_value, #baseline_color, #hide_dots, and #hide_lines.

Bluff.Line = new JS.Class(Bluff.Base, {
  // Draw a dashed line at the given value
  baseline_value: null,
	
  // Color of the baseline
  baseline_color: null,
  
  // Dimensions of lines and dots; calculated based on dataset size if left unspecified
  line_width: null,
  dot_radius: null,
  
  // Hide parts of the graph to fit more datapoints, or for a different appearance.
  hide_dots: null,
  hide_lines: null,
  
  // Call with target pixel width of graph (800, 400, 300), and/or 'false' to omit lines (points only).
  //
  //  g = new Bluff.Line('canvasId', 400) // 400px wide with lines
  //
  //  g = new Bluff.Line('canvasId', 400, false) // 400px wide, no lines (for backwards compatibility)
  //
  //  g = new Bluff.Line('canvasId', false) // Defaults to 800px wide, no lines (for backwards compatibility)
  // 
  // The preferred way is to call hide_dots or hide_lines instead.
  initialize: function(renderer) {
    if (arguments.length > 3) throw 'Wrong number of arguments';
    if (arguments.length === 1 || (typeof arguments[1] !== 'number' && typeof arguments[1] !== 'string'))
      this.callSuper(renderer, null);
    else
      this.callSuper();
    
    this.hide_dots = this.hide_lines = false;
    this.baseline_color = 'red';
    this.baseline_value = null;
  },
  
  draw: function() {
    this.callSuper();
    
    if (!this._has_data) return;
    
    // Check to see if more than one datapoint was given. NaN can result otherwise.
    this.x_increment = (this._column_count > 1) ? (this._graph_width / (this._column_count - 1)) : this._graph_width;
    
    var level;
    
    if (this._norm_baseline !== undefined) {
      level = this._graph_top + (this._graph_height - this._norm_baseline * this._graph_height);
      this._d.push();
      this._d.stroke = this.baseline_color;
      this._d.fill_opacity = 0.0;
      // this._d.stroke_dasharray(10, 20);
      this._d.stroke_width = 3.0;
      this._d.line(this._graph_left, level, this._graph_left + this._graph_width, level);
      this._d.pop();
    }
    
    Bluff.each(this._norm_data, function(data_row, row_index) {
      var prev_x = null, prev_y = null;
      var raw_data = this._data[row_index][this.klass.DATA_VALUES_INDEX];
      
      this._one_point = this._contains_one_point_only(data_row);
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, index) {
        var new_x = this._graph_left + (this.x_increment * index);
        if (typeof data_point !== 'number') return;
        
        this._draw_label(new_x, index);
        
        var new_y = this._graph_top + (this._graph_height - data_point * this._graph_height);
        
        // Reset each time to avoid thin-line errors
        this._d.stroke = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.stroke_opacity = 1.0;
        this._d.stroke_width = this.line_width ||
          this._clip_value_if_greater_than(this._columns / (this._norm_data[0][this.klass.DATA_VALUES_INDEX].length * 6), 3.0);
        
        var circle_radius = this.dot_radius ||
          this._clip_value_if_greater_than(this._columns / (this._norm_data[0][this.klass.DATA_VALUES_INDEX].length * 2), 7.0);
        
        if (!this.hide_lines && prev_x !== null && prev_y !== null) {
          this._d.line(prev_x, prev_y, new_x, new_y);
        } else if (this._one_point) {
          // Show a circle if there's just one point
          this._d.circle(new_x, new_y, new_x - circle_radius, new_y);
        }
        
        if (!this.hide_dots) this._d.circle(new_x, new_y, new_x - circle_radius, new_y);
        
        this._draw_tooltip(new_x - circle_radius, new_y - circle_radius,
                           2 * circle_radius, 2 *circle_radius,
                           data_row[this.klass.DATA_LABEL_INDEX],
                           data_row[this.klass.DATA_COLOR_INDEX],
                           raw_data[index]);
        
        prev_x = new_x;
        prev_y = new_y;
      }, this);
    }, this);
  },
  
  _normalize: function() {
    this.maximum_value = Math.max(this.maximum_value, this.baseline_value);
    this.callSuper();
    if (this.baseline_value !== null) this._norm_baseline = this.baseline_value / this.maximum_value;
  },
  
  _contains_one_point_only: function(data_row) {
    // Spin through data to determine if there is just one value present.
    var count = 0;
    Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point) {
      if (data_point !== undefined) count += 1;
    });
    return count === 1;
  }
});


// Graph with dots and labels along a vertical access
// see: 'Creating More Effective Graphs' by Robbins

Bluff.Dot = new JS.Class(Bluff.Base, {
  
  draw: function() {
    this.has_left_labels = true;
    this.callSuper();
    
    if (!this._has_data) return;
    
    // Setup spacing.
    //
    var spacing_factor = 1.0;
    
    this._items_width = this._graph_height / this._column_count;
    this._item_width = this._items_width * spacing_factor / this._norm_data.length;
    this._d.stroke_opacity = 0.0;
    var height = Bluff.array_new(this._column_count, 0),
        length = Bluff.array_new(this._column_count, this._graph_left),
        padding = (this._items_width * (1 - spacing_factor)) / 2;
    
    Bluff.each(this._norm_data, function(data_row, row_index) {
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, point_index) {
        
        var x_pos = this._graph_left + (data_point * this._graph_width) - Math.round(this._item_width/6.0);
        var y_pos = this._graph_top + (this._items_width * point_index) + padding + Math.round(this._item_width/2.0);
        
        if (row_index === 0) {
          this._d.stroke = this.marker_color;
          this._d.stroke_width = 1.0;
          this._d.opacity = 0.1;
          this._d.line(this._graph_left, y_pos, this._graph_left + this._graph_width, y_pos);
        }
        
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.stroke = 'transparent';
        this._d.circle(x_pos, y_pos, x_pos + Math.round(this._item_width/3.0), y_pos);
        
        // Calculate center based on item_width and current row
        var label_center = this._graph_top + (this._items_width * point_index + this._items_width / 2) + padding;
        this._draw_label(label_center, point_index);
      }, this);
      
    }, this);
  },
  
  // Instead of base class version, draws vertical background lines and label
  _draw_line_markers: function() {
    
    if (this.hide_line_markers) return;
    
    this._d.stroke_antialias = false;
    
    // Draw horizontal line markers and annotate with numbers
    this._d.stroke_width = 1;
    var number_of_lines = 5;
    
    // TODO Round maximum marker value to a round number like 100, 0.1, 0.5, etc.
    var increment = this._significant(this.maximum_value / number_of_lines);
    for (var index = 0; index <= number_of_lines; index++) {
      
      var line_diff    = (this._graph_right - this._graph_left) / number_of_lines,
          x            = this._graph_right - (line_diff * index) - 1,
          diff         = index - number_of_lines,
          marker_label = Math.abs(diff) * increment;
      
      this._d.stroke = this.marker_color;
      this._d.line(x, this._graph_bottom, x, this._graph_bottom + 0.5 * this.klass.LABEL_MARGIN);
      
      if (!this.hide_line_numbers) {
        this._d.fill      = this.font_color;
        if (this.font) this._d.font = this.font;
        this._d.stroke    = 'transparent';
        this._d.pointsize = this._scale_fontsize(this.marker_font_size);
        this._d.gravity   = 'center';
        // TODO Center text over line
        this._d.annotate_scaled(0, 0, // Width of box to draw text in
                                x, this._graph_bottom + (this.klass.LABEL_MARGIN * 2.0), // Coordinates of text
                                marker_label, this._scale);
      }
      this._d.stroke_antialias = true;
    }
  },
  
  // Draw on the Y axis instead of the X
  _draw_label: function(y_offset, index) {
    if (this.labels[index] && !this._labels_seen[index]) {
      this._d.fill             = this.font_color;
      if (this.font) this._d.font = this.font;
      this._d.stroke           = 'transparent';
      this._d.font_weight      = 'normal';
      this._d.pointsize        = this._scale_fontsize(this.marker_font_size);
      this._d.gravity          = 'east';
      this._d.annotate_scaled(1, 1,
                              this._graph_left - this.klass.LABEL_MARGIN * 2.0, y_offset,
                              this.labels[index], this._scale);
      this._labels_seen[index] = true;
    }
  }
});


// Experimental!!! See also the Spider graph.
Bluff.Net = new JS.Class(Bluff.Base, {
  
  // Hide parts of the graph to fit more datapoints, or for a different appearance.
  hide_dots: null,
  
  //Dimensions of lines and dots; calculated based on dataset size if left unspecified
  line_width: null,
  dot_radius: null,
  
  initialize: function() {
    this.callSuper();
    
    this.hide_dots = false;
    this.hide_line_numbers = true;
  },
  
  draw: function() {
    
    this.callSuper();
    
    if (!this._has_data) return;
    
    this._radius = this._graph_height / 2.0;
    this._center_x = this._graph_left + (this._graph_width / 2.0);
    this._center_y = this._graph_top + (this._graph_height / 2.0) - 10; // Move graph up a bit
    
    this._x_increment = this._graph_width / (this._column_count - 1);
    var circle_radius = this.dot_radius ||
      this._clip_value_if_greater_than(this._columns / (this._norm_data[0][this.klass.DATA_VALUES_INDEX].length * 2.5), 7.0);
    
    this._d.stroke_opacity = 1.0;
    this._d.stroke_width = this.line_width ||
      this._clip_value_if_greater_than(this._columns / (this._norm_data[0][this.klass.DATA_VALUES_INDEX].length * 4), 3.0);
    
    var level;
    
    if (this._norm_baseline !== undefined) {
      level = this._graph_top + (this._graph_height - this._norm_baseline * this._graph_height);
      this._d.push();
      this._d.stroke_color  = this.baseline_color;
      this._d.fill_opacity = 0.0;
      // this._d.stroke_dasharray(10, 20);
      this._d.stroke_width = 5;
      this._d.line(this._graph_left, level, this._graph_left + this._graph_width, level);
      this._d.pop();
    }
    
    Bluff.each(this._norm_data, function(data_row) {
      var prev_x = null, prev_y = null;
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, index) {
        if (data_point === undefined) return;
        
        var rad_pos = index * Math.PI * 2 / this._column_count,
            point_distance = data_point * this._radius,
            start_x = this._center_x + Math.sin(rad_pos) * point_distance,
            start_y = this._center_y - Math.cos(rad_pos) * point_distance,
            
            next_index = (index + 1 < data_row[this.klass.DATA_VALUES_INDEX].length) ? index + 1 : 0,
            
            next_rad_pos = next_index * Math.PI * 2 / this._column_count,
            next_point_distance = data_row[this.klass.DATA_VALUES_INDEX][next_index] * this._radius,
            end_x = this._center_x + Math.sin(next_rad_pos) * next_point_distance,
            end_y = this._center_y - Math.cos(next_rad_pos) * next_point_distance;
        
        this._d.stroke = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.line(start_x, start_y, end_x, end_y);
        
        if (!this.hide_dots) this._d.circle(start_x, start_y, start_x - circle_radius, start_y);
      }, this);
      
    }, this);
  },
  
  // the lines connecting in the center, with the first line vertical
  _draw_line_markers: function() {
    if (this.hide_line_markers) return;
    
    // have to do this here (AGAIN)... see draw() in this class
    // because this funtion is called before the @radius, @center_x and @center_y are set
    this._radius = this._graph_height / 2.0;
    this._center_x = this._graph_left + (this._graph_width / 2.0);
    this._center_y = this._graph_top + (this._graph_height / 2.0) - 10; // Move graph up a bit
    
    var rad_pos, marker_label;
    
    for (var index = 0, n = this._column_count; index < n; index++) {
      rad_pos = index * Math.PI * 2 / this._column_count;
      
      // Draw horizontal line markers and annotate with numbers
      this._d.stroke = this.marker_color;
      this._d.stroke_width = 1;
      
      this._d.line(this._center_x, this._center_y, this._center_x + Math.sin(rad_pos) * this._radius, this._center_y - Math.cos(rad_pos) * this._radius);
      
      marker_label = labels[index] ? labels[index] : '000';
      
      this._draw_label(this._center_x, this._center_y, rad_pos * 360 / (2 * Math.PI), this._radius, marker_label);
    }
  },
  
  _draw_label: function(center_x, center_y, angle, radius, amount) {
    var r_offset = 1.1,
        x_offset = center_x, // + 15 // The label points need to be tweaked slightly
        y_offset = center_y, // + 0  // This one doesn't though
        rad_pos = angle * Math.PI / 180,
        x = x_offset + (radius * r_offset * Math.sin(rad_pos)),
        y = y_offset - (radius * r_offset * Math.cos(rad_pos));
    
    // Draw label
    this._d.fill = this.marker_color;
    if (this.font) this._d.font = this.font;
    this._d.pointsize = this._scale_fontsize(20);
    this._d.stroke = 'transparent';
    this._d.font_weight = 'bold';
    this._d.gravity = 'center';
    this._d.annotate_scaled(0, 0, x, y, amount, this._scale);
  }
});


// Here's how to make a Pie graph:
//
//   g = new Bluff.Pie('canvasId');
//   g.title = "Visual Pie Graph Test";
//   g.data('Fries', 20);
//   g.data('Hamburgers', 50);
//   g.draw();
//
// To control where the pie chart starts creating slices, use #zero_degree.

Bluff.Pie = new JS.Class(Bluff.Base, {
  extend: {
    TEXT_OFFSET_PERCENTAGE: 0.08
  },
  
  // Can be used to make the pie start cutting slices at the top (-90.0)
  // or at another angle. Default is 0.0, which starts at 3 o'clock.
  zero_degreee: null,
  
  // Do not show labels for slices that are less than this percent. Use 0 to always show all labels.
  hide_labels_less_than: null,
  
  initialize_ivars: function() {
    this.callSuper();
    this.zero_degree = 0.0;
    this.hide_labels_less_than = 0.0;
  },
  
  draw: function() {
    this.hide_line_markers = true;
    
    this.callSuper();
    
    if (!this._has_data) return;
    
    var diameter = this._graph_height,
        radius = (Math.min(this._graph_width, this._graph_height) / 2.0) * 0.8,
        top_x = this._graph_left + (this._graph_width - diameter) / 2.0,
        center_x = this._graph_left + (this._graph_width / 2.0),
        center_y = this._graph_top + (this._graph_height / 2.0) - 10, // Move graph up a bit
        total_sum = this._sums_for_pie(),
        prev_degrees = this.zero_degree,
        index = this.klass.DATA_VALUES_INDEX;
    
    // Use full data since we can easily calculate percentages
    if (this.sort) this._data.sort(function(a,b) { return a[index][0] - b[index][0]; });
    Bluff.each(this._data, function(data_row, i) {
      if (data_row[this.klass.DATA_VALUES_INDEX][0] > 0) {
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        
        var current_degrees = (data_row[this.klass.DATA_VALUES_INDEX][0] / total_sum) * 360;
        
        // Gruff uses ellipse() here, but canvas doesn't seem to support it.
        // circle() is fine for our purposes here.
        this._d.circle(center_x, center_y,
                    center_x + radius, center_y,
                    prev_degrees, prev_degrees + current_degrees + 0.5); // <= +0.5 'fudge factor' gets rid of the ugly gaps
        
        var half_angle = prev_degrees + ((prev_degrees + current_degrees) - prev_degrees) / 2,
            label_val = Math.round((data_row[this.klass.DATA_VALUES_INDEX][0] / total_sum) * 100.0),
            label_string;
        
        if (label_val >= this.hide_labels_less_than) {
          label_string = this._label(data_row[this.klass.DATA_VALUES_INDEX][0]);
          this._draw_label(center_x, center_y, half_angle,
                            radius + (radius * this.klass.TEXT_OFFSET_PERCENTAGE),
                            label_string);
        }
        
        prev_degrees += current_degrees;
      }
    }, this);
    
    // TODO debug a circle where the text is drawn...
  },
  
  // Labels are drawn around a slightly wider ellipse to give room for 
  // labels on the left and right.
  _draw_label: function(center_x, center_y, angle, radius, amount) {
    // TODO Don't use so many hard-coded numbers
    var r_offset = 20.0,      // The distance out from the center of the pie to get point
        x_offset = center_x,  // + 15.0 # The label points need to be tweaked slightly
        y_offset = center_y,  // This one doesn't though
        radius_offset = radius + r_offset,
        ellipse_factor = radius_offset * 0.15,
        x = x_offset + ((radius_offset + ellipse_factor) * Math.cos(angle * Math.PI/180)),
        y = y_offset + (radius_offset * Math.sin(angle * Math.PI/180));
    
    // Draw label
    this._d.fill = this.font_color;
    if (this.font) this._d.font = this.font;
    this._d.pointsize = this._scale_fontsize(this.marker_font_size);
    this._d.font_weight = 'bold';
    this._d.gravity = 'center';
    this._d.annotate_scaled(0,0, x,y, amount, this._scale);
  },
  
  _sums_for_pie: function() {
    var total_sum = 0;
    Bluff.each(this._data, function(data_row) {
      total_sum += data_row[this.klass.DATA_VALUES_INDEX][0];
    }, this);
    return total_sum;
  }
});


// Graph with individual horizontal bars instead of vertical bars.

Bluff.SideBar = new JS.Class(Bluff.Base, {
  
  // Spacing factor applied between bars
  bar_spacing: 0.9,
  
  draw: function() {
    this.has_left_labels = true;
    this.callSuper();
    
    if (!this._has_data) return;
    
    this._bars_width       = this._graph_height / this._column_count;
    this._bar_width        = this._bars_width * this.bar_spacing / this._norm_data.length;
    this._d.stroke_opacity = 0.0;
    var height = Bluff.array_new(this._column_count, 0),
        length = Bluff.array_new(this._column_count, this._graph_left),
        padding = (this._bars_width * (1 - this.bar_spacing)) / 2;
    
    Bluff.each(this._norm_data, function(data_row, row_index) {
      var raw_data = this._data[row_index][this.klass.DATA_VALUES_INDEX];
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, point_index) {
        
        // Using the original calcs from the stacked bar chart
        // to get the difference between
        // part of the bart chart we wish to stack.
        var temp1      = this._graph_left + (this._graph_width - data_point * this._graph_width - height[point_index]),
            temp2      = this._graph_left + this._graph_width - height[point_index],
            difference = temp2 - temp1,
        
            left_x     = length[point_index] - 1,
            left_y     = this._graph_top + (this._bars_width * point_index) + (this._bar_width * row_index) + padding,
            right_x    = left_x + difference,
            right_y    = left_y + this._bar_width;
        
        height[point_index] += (data_point * this._graph_width);
        
        this._d.stroke = 'transparent';
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.rectangle(left_x, left_y, right_x, right_y);
        
        this._draw_tooltip(left_x, left_y,
                           right_x - left_x, right_y - left_y,
                           data_row[this.klass.DATA_LABEL_INDEX],
                           data_row[this.klass.DATA_COLOR_INDEX],
                           raw_data[point_index]);
        
        // Calculate center based on bar_width and current row
        var label_center = this._graph_top + (this._bars_width * point_index + this._bars_width / 2);
        this._draw_label(label_center, point_index);
      }, this)
      
    }, this);
  },
  
  // Instead of base class version, draws vertical background lines and label
  _draw_line_markers: function() {
    
    if (this.hide_line_markers) return;
    
    this._d.stroke_antialias = false;
    
    // Draw horizontal line markers and annotate with numbers
    this._d.stroke_width = 1;
    var number_of_lines = 5;
    
    // TODO Round maximum marker value to a round number like 100, 0.1, 0.5, etc.
    var increment = this._significant(this.maximum_value / number_of_lines),
        line_diff, x, diff, marker_label;
    for (var index = 0; index <= number_of_lines; index++) {
      
      line_diff    = (this._graph_right - this._graph_left) / number_of_lines;
      x            = this._graph_right - (line_diff * index) - 1;
      diff         = index - number_of_lines;
      marker_label = Math.abs(diff) * increment;
      
      this._d.stroke = this.marker_color;
      this._d.line(x, this._graph_bottom, x, this._graph_top);
      
      if (!this.hide_line_numbers) {
        this._d.fill      = this.font_color;
        if (this.font) this._d.font = this.font;
        this._d.stroke    = 'transparent';
        this._d.pointsize = this._scale_fontsize(this.marker_font_size);
        this._d.gravity   = 'center';
        // TODO Center text over line
        this._d.annotate_scaled(
                          0, 0, // Width of box to draw text in
                          x, this._graph_bottom + (this.klass.LABEL_MARGIN * 2.0), // Coordinates of text
                          marker_label, this._scale);
      }
    }
  },
  
  // Draw on the Y axis instead of the X
  _draw_label: function(y_offset, index) {
    if (this.labels[index] && !this._labels_seen[index]) {
      this._d.fill             = this.font_color;
      if (this.font) this._d.font = this.font;
      this._d.stroke           = 'transparent';
      this._d.font_weight      = 'normal';
      this._d.pointsize        = this._scale_fontsize(this.marker_font_size);
      this._d.gravity          = 'east';
      this._d.annotate_scaled(1, 1,
                              this._graph_left - this.klass.LABEL_MARGIN * 2.0, y_offset,
                              this.labels[index], this._scale);
      this._labels_seen[index] = true;
    }
  }
});


// Experimental!!! See also the Net graph.
//
// Submitted by Kevin Clark http://glu.ttono.us/
Bluff.Spider = new JS.Class(Bluff.Base, {
  
  // Hide all text
  hide_text: null,
  hide_axes: null,
  transparent_background: null,
  
  initialize: function(renderer, max_value, target_width) {
    this.callSuper(renderer, target_width);
    this._max_value = max_value;
    this.hide_legend = true;
  },
  
  draw: function() {
    this.hide_line_markers = true;
    
    this.callSuper();
    
    if (!this._has_data) return;
    
    // Setup basic positioning
    var diameter = this._graph_height,
        radius = this._graph_height / 2.0,
        top_x = this._graph_left + (this._graph_width - diameter) / 2.0,
        center_x = this._graph_left + (this._graph_width / 2.0),
        center_y = this._graph_top + (this._graph_height / 2.0) - 25; // Move graph up a bit
    
    this._unit_length = radius / this._max_value;
    
    var total_sum = this._sums_for_spider(),
        prev_degrees = 0.0,
        additive_angle = (2 * Math.PI) / this._data.length,
        
        current_angle = 0.0;
    
    // Draw axes
    if (!this.hide_axes) this._draw_axes(center_x, center_y, radius, additive_angle);
    
    // Draw polygon
    this._draw_polygon(center_x, center_y, additive_angle);
  },
  
  _normalize_points: function(value) {
    return value * this._unit_length;
  },
  
  _draw_label: function(center_x, center_y, angle, radius, amount) {
    var r_offset = 50,            // The distance out from the center of the pie to get point
        x_offset = center_x,      // The label points need to be tweaked slightly
        y_offset = center_y + 0,  // This one doesn't though
        x = x_offset + ((radius + r_offset) * Math.cos(angle)),
        y = y_offset + ((radius + r_offset) * Math.sin(angle));
    
    // Draw label
    this._d.fill = this.marker_color;
    if (this.font) this._d.font = this.font;
    this._d.pointsize = this._scale_fontsize(this.legend_font_size);
    this._d.stroke = 'transparent';
    this._d.font_weight = 'bold';
    this._d.gravity = 'center';
    this._d.annotate_scaled(0, 0,
                            x, y,
                            amount, this._scale);
  },
  
  _draw_axes: function(center_x, center_y, radius, additive_angle, line_color) {
    if (this.hide_axes) return;
    
    var current_angle = 0.0;
    
    Bluff.each(this._data, function(data_row) {
      this._d.stroke = line_color || data_row[this.klass.DATA_COLOR_INDEX];
      this._d.stroke_width = 5.0;
      
      var x_offset = radius * Math.cos(current_angle);
      var y_offset = radius * Math.sin(current_angle);
      
      this._d.line(center_x, center_y,
                   center_x + x_offset,
                   center_y + y_offset);
      
      if (!this.hide_text) this._draw_label(center_x, center_y, current_angle, radius, data_row[this.klass.DATA_LABEL_INDEX]);
      
      current_angle += additive_angle;
    }, this);
  },
  
  _draw_polygon: function(center_x, center_y, additive_angle, color) {
    var points = [],
        current_angle = 0.0;
    Bluff.each(this._data, function(data_row) {
      points.push(center_x + this._normalize_points(data_row[this.klass.DATA_VALUES_INDEX][0]) * Math.cos(current_angle));
      points.push(center_y + this._normalize_points(data_row[this.klass.DATA_VALUES_INDEX][0]) * Math.sin(current_angle));
      current_angle += additive_angle;
    }, this);
    
    this._d.stroke_width = 1.0;
    this._d.stroke = color || this.marker_color;
    this._d.fill = color || this.marker_color;
    this._d.fill_opacity = 0.4;
    this._d.polyline(points);
  },
  
  _sums_for_spider: function() {
    var sum = 0.0;
    Bluff.each(this._data, function(data_row) {
      sum += data_row[this.klass.DATA_VALUES_INDEX][0];
    }, this);
    return sum;
  }
});


// Used by StackedBar and child classes.
Bluff.Base.StackedMixin = new JS.Module({
  // Get sum of each stack
  _get_maximum_by_stack: function() {
    var max_hash = {};
    Bluff.each(this._data, function(data_set) {
      Bluff.each(data_set[this.klass.DATA_VALUES_INDEX], function(data_point, i) {
        if (!max_hash[i]) max_hash[i] = 0.0;
        max_hash[i] += data_point;
      }, this);
    }, this);
    
    // this.maximum_value = 0;
    for (var key in max_hash) {
      if (max_hash[key] > this.maximum_value) this.maximum_value = max_hash[key];
    }
    this.minimum_value = 0;
  }
});


Bluff.StackedArea = new JS.Class(Bluff.Base, {
  include: Bluff.Base.StackedMixin,
  last_series_goes_on_bottom: null,
  
  draw: function() {
    this._get_maximum_by_stack();
    this.callSuper();
    
    if (!this._has_data) return;
    
    this._x_increment = this._graph_width / (this._column_count - 1);
    this._d.stroke = 'transparent';
    
    var height = Bluff.array_new(this._column_count, 0);
    
    var data_points = null;
    var iterator = this.last_series_goes_on_bottom ? 'reverse_each' : 'each';
    Bluff[iterator](this._norm_data, function(data_row) {
      var prev_data_points = data_points;
      data_points = [];
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, index) {
        // Use incremented x and scaled y
        var new_x = this._graph_left + (this._x_increment * index);
        var new_y = this._graph_top + (this._graph_height - data_point * this._graph_height - height[index]);
        
        height[index] += (data_point * this._graph_height);
        
        data_points.push(new_x);
        data_points.push(new_y);
        
        this._draw_label(new_x, index);
      }, this);
      
      var poly_points, i, n;
      
      if (prev_data_points) {
        poly_points = Bluff.array(data_points);
        for (i = prev_data_points.length/2 - 1; i >= 0; i--) {
          poly_points.push(prev_data_points[2*i]);
          poly_points.push(prev_data_points[2*i+1]);
        }
        poly_points.push(data_points[0]);
        poly_points.push(data_points[1]);
      } else {
        poly_points = Bluff.array(data_points);
        poly_points.push(this._graph_right);
        poly_points.push(this._graph_bottom - 1);
        poly_points.push(this._graph_left);
        poly_points.push(this._graph_bottom - 1);
        poly_points.push(data_points[0]);
        poly_points.push(data_points[1]);
      }
      this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
      this._d.polyline(poly_points);
    }, this);
  }
});


Bluff.StackedBar = new JS.Class(Bluff.Base, {
  include: Bluff.Base.StackedMixin,
  
  // Spacing factor applied between bars
  bar_spacing: 0.9,
  
  // Draws a bar graph, but multiple sets are stacked on top of each other.
  draw: function() {
    this._get_maximum_by_stack();
    this.callSuper();
    if (!this._has_data) return;
    
    this._bar_width = this._graph_width / this._column_count;
    var padding = (this._bar_width * (1 - this.bar_spacing)) / 2;
    
    this._d.stroke_opacity = 0.0;
    
    var height = Bluff.array_new(this._column_count, 0);
    
    Bluff.each(this._norm_data, function(data_row, row_index) {
      var raw_data = this._data[row_index][this.klass.DATA_VALUES_INDEX];
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, point_index) {
        // Calculate center based on bar_width and current row
        var label_center = this._graph_left + (this._bar_width * point_index) + (this._bar_width * this.bar_spacing / 2.0);
        this._draw_label(label_center, point_index);
        
        if (data_point == 0) return;
        // Use incremented x and scaled y
        var left_x = this._graph_left + (this._bar_width * point_index) + padding;
        var left_y = this._graph_top + (this._graph_height -
                                        data_point * this._graph_height - 
                                        height[point_index]) + 1;
        var right_x = left_x + this._bar_width * this.bar_spacing;
        var right_y = this._graph_top + this._graph_height - height[point_index] - 1;
        
        // update the total height of the current stacked bar
        height[point_index] += (data_point * this._graph_height);
        
        this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
        this._d.rectangle(left_x, left_y, right_x, right_y);
        
        this._draw_tooltip(left_x, left_y,
                           right_x - left_x, right_y - left_y,
                           data_row[this.klass.DATA_LABEL_INDEX],
                           data_row[this.klass.DATA_COLOR_INDEX],
                           raw_data[point_index]);
      }, this);
    }, this);
  }
});


// A special bar graph that shows a single dataset as a set of
// stacked bars. The bottom bar shows the running total and 
// the top bar shows the new value being added to the array.

Bluff.AccumulatorBar = new JS.Class(Bluff.StackedBar, {
  
  draw: function() {
    if (this._data.length !== 1) throw 'Incorrect number of datasets';
    
    var accumulator_array = [],
        index = 0,
        increment_array = [];
    
    Bluff.each(this._data[0][this.klass.DATA_VALUES_INDEX], function(value) {
      var max = -Infinity;
      Bluff.each(increment_array, function(x) { max = Math.max(max, x); });
      
      increment_array.push((index > 0) ? (value + max) : value);
      accumulator_array.push(increment_array[index] - value);
      index += 1;
    }, this);
    
    this.data("Accumulator", accumulator_array);
    
    this.callSuper();
  }
});


// New gruff graph type added to enable sideways stacking bar charts 
// (basically looks like a x/y flip of a standard stacking bar chart)
//
// alun.eyre@googlemail.com

Bluff.SideStackedBar = new JS.Class(Bluff.SideBar, {
  include: Bluff.Base.StackedMixin,
  
  // Spacing factor applied between bars
  bar_spacing: 0.9,
  
  draw: function() {
    this.has_left_labels = true;
    this._get_maximum_by_stack();
    this.callSuper();
    
    if (!this._has_data) return;
    
    this._bar_width = this._graph_height / this._column_count;
    var height = Bluff.array_new(this._column_count, 0),
        length = Bluff.array_new(this._column_count, this._graph_left),
        padding = (this._bar_width * (1 - this.bar_spacing)) / 2;

    Bluff.each(this._norm_data, function(data_row, row_index) {
      this._d.fill = data_row[this.klass.DATA_COLOR_INDEX];
      var raw_data = this._data[row_index][this.klass.DATA_VALUES_INDEX];
      
      Bluff.each(data_row[this.klass.DATA_VALUES_INDEX], function(data_point, point_index) {
        
    	  // using the original calcs from the stacked bar chart to get the difference between
    	  // part of the bart chart we wish to stack.
    	  var temp1 = this._graph_left + (this._graph_width -
                                            data_point * this._graph_width - 
                                            height[point_index]) + 1;
    	  var temp2 = this._graph_left + this._graph_width - height[point_index] - 1;
    	  var difference = temp2 - temp1;
        
    	  var left_x = length[point_index], //+ 1
            left_y = this._graph_top + (this._bar_width * point_index) + padding,
    	      right_x = left_x + difference,
            right_y = left_y + this._bar_width * this.bar_spacing;
    	  length[point_index] += difference;
        height[point_index] += (data_point * this._graph_width - 2);
        
        this._d.rectangle(left_x, left_y, right_x, right_y);
        
        this._draw_tooltip(left_x, left_y,
                           right_x - left_x, right_y - left_y,
                           data_row[this.klass.DATA_LABEL_INDEX],
                           data_row[this.klass.DATA_COLOR_INDEX],
                           raw_data[point_index]);
        
        // Calculate center based on bar_width and current row
        var label_center = this._graph_top + (this._bar_width * point_index) + (this._bar_width * this.bar_spacing / 2.0);
        this._draw_label(label_center, point_index);
      }, this);
    }, this);
  },
  
  _larger_than_max: function(data_point, index) {
    index = index || 0;
    return this._max(data_point, index) > this.maximum_value;
  },
  
  _max: function(data_point, index) {
    var sum = 0;
    Bluff.each(this._data, function(item) {
      sum += item[this.klass.DATA_VALUES_INDEX][index];
    }, this);
    return sum;
  }
});


Bluff.Mini.Legend = new JS.Module({
  
  hide_mini_legend: false,
  
  // The canvas needs to be bigger so we can put the legend beneath it.
  _expand_canvas_for_vertical_legend: function() {
    if (this.hide_mini_legend) return;
    
    this._original_rows = this._raw_rows;
    this._rows += this._data.length * this._calculate_caps_height(this._scale_fontsize(this.legend_font_size)) * 1.7;
    this._render_background();
  },
  
  // Draw the legend beneath the existing graph.
  _draw_vertical_legend: function() {
    if (this.hide_mini_legend) return;
    
    this._legend_labels = Bluff.map(this._data, function(item) {
      return item[this.klass.DATA_LABEL_INDEX];
    }, this);
    
    var legend_square_width = 40.0, // small square with color of this item
        legend_square_margin = 10.0,
        legend_left_margin = 100.0,
        legend_top_margin = 40.0;
    
    // May fix legend drawing problem at small sizes
    if (this.font) this._d.font = this.font;
    this._d.pointsize = this.legend_font_size;
    
    var current_x_offset = legend_left_margin,
        current_y_offset = this._original_rows + legend_top_margin;
    
    this._debug(function() {
      this._d.line(0.0, current_y_offset, this._raw_columns, current_y_offset);
    });
    
    Bluff.each(this._legend_labels, function(legend_label, index) {
      
      // Draw label
      this._d.fill = this.font_color;
      if (this.font) this._d.font = this.font;
      this._d.pointsize = this._scale_fontsize(this.legend_font_size);
      this._d.stroke = 'transparent';
      this._d.font_weight = 'normal';
      this._d.gravity = 'west';
      this._d.annotate_scaled(this._raw_columns, 1.0,
                        current_x_offset + (legend_square_width * 1.7), current_y_offset, 
                        this._truncate_legend_label(legend_label), this._scale);
      
      // Now draw box with color of this dataset
      this._d.stroke = 'transparent';
      this._d.fill = this._data[index][this.klass.DATA_COLOR_INDEX];
      this._d.rectangle(current_x_offset, 
                        current_y_offset - legend_square_width / 2.0, 
                        current_x_offset + legend_square_width, 
                        current_y_offset + legend_square_width / 2.0);
      
      current_y_offset += this._calculate_caps_height(this.legend_font_size) * 1.7;
    }, this);
    this._color_index = 0;
  },
  
  // Shorten long labels so they will fit on the canvas.
  _truncate_legend_label: function(label) {
    var truncated_label = String(label);
    while (this._calculate_width(this._scale_fontsize(this.legend_font_size), truncated_label) > (this._columns - this.legend_left_margin - this.right_margin) && (truncated_label.length > 1))
      truncated_label = truncated_label.substr(0, truncated_label.length-1);
    return truncated_label + (truncated_label.length < String(label).length ? "..." : '');
  }
});


// Makes a small bar graph suitable for display at 200px or even smaller.
//
Bluff.Mini.Bar = new JS.Class(Bluff.Bar, {
  include: Bluff.Mini.Legend,
  
  initialize_ivars: function() {
    this.callSuper();
    
    this.hide_legend = true;
    this.hide_title = true;
    this.hide_line_numbers = true;
    
    this.marker_font_size = 50.0;
    this.minimum_value = 0.0;
    this.maximum_value = 0.0;
    this.legend_font_size = 60.0;
  },
  
  draw: function() {
    this._expand_canvas_for_vertical_legend();
    
    this.callSuper();
    
    this._draw_vertical_legend();
  }
});


// Makes a small pie graph suitable for display at 200px or even smaller.
//
Bluff.Mini.Pie = new JS.Class(Bluff.Pie, {
  include: Bluff.Mini.Legend,
  
  initialize_ivars: function() {
    this.callSuper();
    
    this.hide_legend = true;
    this.hide_title = true;
    this.hide_line_numbers = true;
    
    this.marker_font_size = 60.0;
    this.legend_font_size = 60.0;
  },
  
  draw: function() {
    this._expand_canvas_for_vertical_legend();
    
    this.callSuper();
    
    this._draw_vertical_legend();
  }
});


// Makes a small pie graph suitable for display at 200px or even smaller.
//
Bluff.Mini.SideBar = new JS.Class(Bluff.SideBar, {
  include: Bluff.Mini.Legend,
  
  initialize_ivars: function() {
    this.callSuper();
    this.hide_legend = true;
    this.hide_title = true;
    this.hide_line_numbers = true;
    
    this.marker_font_size = 50.0;
    this.legend_font_size = 50.0;
  },
  
  draw: function() {
    this._expand_canvas_for_vertical_legend();
    
    this.callSuper();
    
    this._draw_vertical_legend();
  }
});


Bluff.Renderer = new JS.Class({
  extend: {
    WRAPPER_CLASS:  'bluff-wrapper',
    TEXT_CLASS:     'bluff-text',
    TARGET_CLASS:   'bluff-tooltip-target'
  },

  font:     'Arial, Helvetica, Verdana, sans-serif',
  gravity:  'north',
  
  initialize: function(canvasId) {
    this._canvas = document.getElementById(canvasId);
    this._ctx = this._canvas.getContext('2d');
  },
  
  scale: function(sx, sy) {
    this._sx = sx;
    this._sy = sy || sx;
  },
  
  caps_height: function(font_size) {
    var X = this._sized_text(font_size, 'X'),
        height = this._element_size(X).height;
    this._remove_node(X);
    return height;
  },
  
  text_width: function(font_size, text) {
    var element = this._sized_text(font_size, text);
    var width = this._element_size(element).width;
    this._remove_node(element);
    return width;
  },
  
  get_type_metrics: function(text) {
    var node = this._sized_text(this.pointsize, text);
    document.body.appendChild(node);
    var size = this._element_size(node);
    this._remove_node(node);
    return size;
  },
  
  clear: function(width, height) {
    this._canvas.width = width;
    this._canvas.height = height;
    this._ctx.clearRect(0, 0, width, height);
    var wrapper = this._text_container(), children = wrapper.childNodes, i = children.length;
    wrapper.style.width = width + 'px';
    wrapper.style.height = height + 'px';
    while (i--) {
      if (children[i].tagName.toLowerCase() !== 'canvas')
        this._remove_node(children[i]);
    }
  },
  
  push: function() {
    this._ctx.save();
  },
  
  pop: function() {
    this._ctx.restore();
  },
  
  render_gradiated_background: function(width, height, top_color, bottom_color) {
    this.clear(width, height);
    var gradient = this._ctx.createLinearGradient(0,0, 0,height);
    gradient.addColorStop(0, top_color);
    gradient.addColorStop(1, bottom_color);
    this._ctx.fillStyle = gradient;
    this._ctx.fillRect(0, 0, width, height);
  },
  
  render_solid_background: function(width, height, color) {
    this.clear(width, height);
    this._ctx.fillStyle = color;
    this._ctx.fillRect(0, 0, width, height);
  },
  
  annotate_scaled: function(width, height, x, y, text, scale) {
    var scaled_width = (width * scale) >= 1 ? (width * scale) : 1;
    var scaled_height = (height * scale) >= 1 ? (height * scale) : 1;
    var text = this._sized_text(this.pointsize, text);
    text.style.color = this.fill;
    text.style.fontWeight = this.font_weight;
    text.style.textAlign = 'center';
    text.style.left = (this._sx * x + this._left_adjustment(text, scaled_width)) + 'px';
    text.style.top = (this._sy * y + this._top_adjustment(text, scaled_height)) + 'px';
  },
  
  tooltip: function(left, top, width, height, name, color, data) {
    if (width < 0) left += width;
    if (height < 0) top += height;
    
    var wrapper = this._canvas.parentNode,
        target = document.createElement('div');
    target.className = this.klass.TARGET_CLASS;
    target.style.position = 'absolute';
    target.style.left = (this._sx * left - 3) + 'px';
    target.style.top = (this._sy * top - 3) + 'px';
    target.style.width = (this._sx * Math.abs(width) + 5) + 'px';
    target.style.height = (this._sy * Math.abs(height) + 5) + 'px';
    target.style.fontSize = 0;
    target.style.overflow = 'hidden';
    
    Bluff.Event.observe(target, 'mouseover', function(node) {
      Bluff.Tooltip.show(name, color, data);
    });
    Bluff.Event.observe(target, 'mouseout', function(node) {
      Bluff.Tooltip.hide();
    });
    
    wrapper.appendChild(target);
  },
  
  circle: function(origin_x, origin_y, perim_x, perim_y, arc_start, arc_end) {
    var radius = Math.sqrt(Math.pow(perim_x - origin_x, 2) + Math.pow(perim_y - origin_y, 2));
    this._ctx.fillStyle = this.fill;
    this._ctx.beginPath();
    var alpha = (arc_start || 0) * Math.PI/180;
    var beta = (arc_end || 360) * Math.PI/180;
    if (arc_start !== undefined && arc_end !== undefined) {
      this._ctx.moveTo(this._sx * (origin_x + radius * Math.cos(beta)), this._sy * (origin_y + radius * Math.sin(beta)));
      this._ctx.lineTo(this._sx * origin_x, this._sy * origin_y);
      this._ctx.lineTo(this._sx * (origin_x + radius * Math.cos(alpha)), this._sy * (origin_y + radius * Math.sin(alpha)));
    }
    this._ctx.arc(this._sx * origin_x, this._sy * origin_y, this._sx * radius, alpha, beta, false);
    this._ctx.fill();
  },
  
  line: function(sx, sy, ex, ey) {
    this._ctx.strokeStyle = this.stroke;
    this._ctx.lineWidth = this.stroke_width;
    this._ctx.beginPath();
    this._ctx.moveTo(this._sx * sx, this._sy * sy);
    this._ctx.lineTo(this._sx * ex, this._sy * ey);
    this._ctx.stroke();
  },
  
  polyline: function(points) {
    this._ctx.fillStyle = this.fill;
    this._ctx.globalAlpha = this.fill_opacity || 1;
    try { this._ctx.strokeStyle = this.stroke; } catch (e) {}
    var x = points.shift(), y = points.shift();
    this._ctx.beginPath();
    this._ctx.moveTo(this._sx * x, this._sy * y);
    while (points.length > 0) {
      x = points.shift(); y = points.shift();
      this._ctx.lineTo(this._sx * x, this._sy * y);
    }
    this._ctx.fill();
  },
  
  rectangle: function(ax, ay, bx, by) {
    var temp;
    if (ax > bx) { temp = ax; ax = bx; bx = temp; }
    if (ay > by) { temp = ay; ay = by; by = temp; }
    try {
      this._ctx.fillStyle = this.fill;
      this._ctx.fillRect(this._sx * ax, this._sy * ay, this._sx * (bx-ax), this._sy * (by-ay));
    } catch (e) {}
    try {
      this._ctx.strokeStyle = this.stroke;
      if (this.stroke !== 'transparent')
        this._ctx.strokeRect(this._sx * ax, this._sy * ay, this._sx * (bx-ax), this._sy * (by-ay));
    } catch (e) {}
  },
  
  _left_adjustment: function(node, width) {
    var w = this._element_size(node).width;
    switch (this.gravity) {
      case 'west':    return 0;
      case 'east':    return width - w;
      case 'north': case 'south': case 'center':
        return (width - w) / 2;
    }
  },
  
  _top_adjustment: function(node, height) {
    var h = this._element_size(node).height;
    switch (this.gravity) {
      case 'north':   return 0;
      case 'south':   return height - h;
      case 'west': case 'east': case 'center':
        return (height - h) / 2;
    }
  },
  
  _text_container: function() {
    var wrapper = this._canvas.parentNode;
    if (wrapper.className === this.klass.WRAPPER_CLASS) return wrapper;
    wrapper = document.createElement('div');
    wrapper.className = this.klass.WRAPPER_CLASS;
    
    wrapper.style.position = 'relative';
    wrapper.style.border = 'none';
    wrapper.style.padding = '0 0 0 0';
    
    this._canvas.parentNode.insertBefore(wrapper, this._canvas);
    wrapper.appendChild(this._canvas);
    return wrapper;
  },
  
  _sized_text: function(size, content) {
    var text = this._text_node(content);
    text.style.fontFamily = this.font;
    text.style.fontSize = (typeof size === 'number') ? size + 'px' : size;
    return text;
  },
  
  _text_node: function(content) {
    var div = document.createElement('div');
    div.className = this.klass.TEXT_CLASS;
    div.style.position = 'absolute';
    div.appendChild(document.createTextNode(content));
    this._text_container().appendChild(div);
    return div;
  },
  
  _remove_node: function(node) {
    node.parentNode.removeChild(node);
    if (node.className === this.klass.TARGET_CLASS)
      Bluff.Event.stopObserving(node);
  },
  
  _element_size: function(element) {
    var display = element.style.display;
    return (display && display !== 'none')
        ? {width: element.offsetWidth, height: element.offsetHeight}
        : {width: element.clientWidth, height: element.clientHeight};
  }
});


// DOM event module, adapted from Prototype
// Copyright (c) 2005-2008 Sam Stephenson

Bluff.Event = {
  _cache: [],
  
  _isIE: (window.attachEvent && navigator.userAgent.indexOf('Opera') === -1),
  
  observe: function(element, eventName, callback, scope) {
    var handlers = Bluff.map(this._handlersFor(element, eventName),
                      function(entry) { return entry._handler });
    if (Bluff.index(handlers, callback) !== -1) return;
    
    var responder = function(event) {
      callback.call(scope || null, element, Bluff.Event._extend(event));
    };
    this._cache.push({_node: element, _name: eventName,
                      _handler: callback, _responder: responder});
    
    if (element.addEventListener)
      element.addEventListener(eventName, responder, false);
    else
      element.attachEvent('on' + eventName, responder);
  },
  
  stopObserving: function(element) {
    var handlers = element ? this._handlersFor(element) : this._cache;
    Bluff.each(handlers, function(entry) {
      if (entry._node.removeEventListener)
        entry._node.removeEventListener(entry._name, entry._responder, false);
      else
        entry._node.detachEvent('on' + entry._name, entry._responder);
    });
  },
  
  _handlersFor: function(element, eventName) {
    var results = [];
    Bluff.each(this._cache, function(entry) {
      if (element && entry._node !== element) return;
      if (eventName && entry._name !== eventName) return;
      results.push(entry);
    });
    return results;
  },
  
  _extend: function(event) {
    if (!this._isIE) return event;
    if (!event) return false;
    if (event._extendedByBluff) return event;
    event._extendedByBluff = true;
    
    var pointer = this._pointer(event);
    event.target = event.srcElement;
    event.pageX = pointer.x;
    event.pageY = pointer.y;
    
    return event;
  },
  
  _pointer: function(event) {
    var docElement = document.documentElement,
        body = document.body || { scrollLeft: 0, scrollTop: 0 };
    return {
      x: event.pageX || (event.clientX +
                        (docElement.scrollLeft || body.scrollLeft) -
                        (docElement.clientLeft || 0)),
      y: event.pageY || (event.clientY +
                        (docElement.scrollTop || body.scrollTop) -
                        (docElement.clientTop || 0))
    };
  }
};

if (Bluff.Event._isIE)
  window.attachEvent('onunload', function() {
    Bluff.Event.stopObserving();
    Bluff.Event._cache = null;
  });

if (navigator.userAgent.indexOf('AppleWebKit/') > -1)
  window.addEventListener('unload', function() {}, false);


Bluff.Tooltip = new JS.Singleton({
  LEFT_OFFSET:  20,
  TOP_OFFSET:   -6,
  DATA_LENGTH:  8,
  
  CLASS_NAME:   'bluff-tooltip',
  
  setup: function() {
    this._tip = document.createElement('div');
    this._tip.className = this.CLASS_NAME;
    this._tip.style.position = 'absolute';
    this.hide();
    document.body.appendChild(this._tip);
    
    Bluff.Event.observe(document.body, 'mousemove', function(body, event) {
      this._tip.style.left = (event.pageX + this.LEFT_OFFSET) + 'px';
      this._tip.style.top = (event.pageY + this.TOP_OFFSET) + 'px';
    }, this);
  },
  
  show: function(name, color, data) {
    data = Number(String(data).substr(0, this.DATA_LENGTH));
    this._tip.innerHTML = '<span class="color" style="background: ' + color + ';">&nbsp;</span> ' +
                          '<span class="label">' + name + '</span> ' +
                          '<span class="data">' + data + '</span>';
    this._tip.style.display = '';
  },
  
  hide: function() {
    this._tip.style.display = 'none';
  }
});

Bluff.Event.observe(window, 'load', Bluff.Tooltip.method('setup'));


Bluff.TableReader = new JS.Class({
  
  NUMBER_FORMAT: /\-?(0|[1-9]\d*)(\.\d+)?(e[\+\-]?\d+)?/i,
  
  initialize: function(table, transpose) {
    this._table = (typeof table === 'string')
        ? document.getElementById(table)
        : table;
    this._swap = !!transpose;
  },
  
  // Get array of data series from the table
  get_data: function() {
    if (!this._data) this._read();
    return this._data;
  },
  
  // Get set of axis labels to use for the graph
  get_labels: function() {
    if (!this._labels) this._read();
    return this._labels;
  },
  
  // Get the title from the table's caption
  get_title: function() {
    return this._title;
  },
  
  // Return series number i
  get_series: function(i) {
    if (this._data[i]) return this._data[i];
    return this._data[i] = {points: []};
  },
  
  // Gather data by reading from the table
  _read: function() {
    this._row = this._col = 0;
    this._row_offset = this._col_offset = 0;
    this._data = [];
    this._labels = {};
    this._row_headings = [];
    this._col_headings = [];
    
    this._walk(this._table);
    
    if ((this._row_headings.length > 1 && this._col_headings.length === 1) ||
        this._row_headings.length < this._col_headings.length) {
      if (!this._swap) this._transpose();
    } else {
      if (this._swap) this._transpose();
    }
    
    Bluff.each(this._col_headings, function(heading, i) {
      this.get_series(i - this._col_offset).name = heading;
    }, this);
    
    Bluff.each(this._row_headings, function(heading, i) {
      this._labels[i - this._row_offset] = heading;
    }, this);
  },
  
  // Walk the table's DOM tree
  _walk: function(node) {
    this._visit(node);
    var i, children = node.childNodes, n = children.length;
    for (i = 0; i < n; i++) this._walk(children[i]);
  },
  
  // Read a single DOM node from the table
  _visit: function(node) {
    if (!node.tagName) return;
    var content = this._strip_tags(node.innerHTML), x, y;
    switch (node.tagName.toUpperCase()) {
    
      case 'TR':
        if (!this._has_data) this._row_offset = this._row;
        this._row += 1;
        this._col = 0;
        break;
      
      case 'TD':
        if (!this._has_data) this._col_offset = this._col;
        this._has_data = true;
        this._col += 1;
        content = content.match(this.NUMBER_FORMAT);
        if (content === null) {
          this.get_series(x).points[y] = null;
        } else {
          x = this._col - this._col_offset - 1;
          y = this._row - this._row_offset - 1;
          this.get_series(x).points[y] = parseFloat(content[0]);
        }
        break;
      
      case 'TH':
        this._col += 1;
        if (this._col === 1 && this._row === 1)
          this._row_headings[0] = this._col_headings[0] = content;
        else if (node.scope === "row" || this._col === 1)
          this._row_headings[this._row - 1] = content;
        else
          this._col_headings[this._col - 1] = content;
        break;
      
      case 'CAPTION':
        this._title = content;
        break;
    }
  },
  
  // Transpose data in memory
  _transpose: function() {
    var data = this._data, tmp;
    this._data = [];
    
    Bluff.each(data, function(row, i) {
      Bluff.each(row.points, function(point, p) {
        this.get_series(p).points[i] = point;
      }, this);
    }, this);
    
    tmp = this._row_headings;
    this._row_headings = this._col_headings;
    this._col_headings = tmp;
    
    tmp = this._row_offset;
    this._row_offset = this._col_offset;
    this._col_offset = tmp;
  },
  
  // Remove HTML from a string
  _strip_tags: function(string) {
    return string.replace(/<\/?[^>]+>/gi, '');
  },
  
  extend: {
    Mixin: new JS.Module({
      data_from_table: function(table, transpose) {
        var reader    = new Bluff.TableReader(table, transpose),
            data_rows = reader.get_data();
        
        Bluff.each(data_rows, function(row) {
          this.data(row.name, row.points);
        }, this);
        
        this.labels = reader.get_labels();
        this.title  = reader.get_title() || this.title;
      }
    })
  }
});

Bluff.Base.include(Bluff.TableReader.Mixin);
Bluff.Tooltip.show = function(name, color, data) {
  data = Number(String(data).substr(0, this.DATA_LENGTH));
  this._tip.innerHTML = '<span class="color" style="background: ' + color + ';">&nbsp;</span> ' +
                        '<span class="data">' + data + '</span>' +
                        ' <span class="label">' + name + '</span> ';
  this._tip.style.display = '';
}
