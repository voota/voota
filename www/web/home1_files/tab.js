if(!UserVoice){var UserVoice={};}
UserVoice.Util={sslAssetHost:"https://cdn.uservoice.com",assetHost:"http://cdn.uservoice.com",getAssetHost:function(){return("https:"==document.location.protocol)?this.sslAssetHost:this.assetHost;},render:function(template,params){return template.replace(/\#{([^{}]*)}/g,function(a,b){var r=params[b];return typeof r==='string'||typeof r==='number'?r:a;})},toQueryString:function(params){var pairs=[];for(key in params){if(params[key]!=null&&params[key]!=''){pairs.push([key,params[key]].join('='));}}
return pairs.join('&');},isIE:function(test){if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)){if(typeof test==="function"){return test(new Number(RegExp.$1));}else{return true;}}else{return false;}},isQuirksMode:function(){return document.compatMode&&document.compatMode=="BackCompat";},includeCss:function(css){var styleElement=document.createElement('style');styleElement.setAttribute('type','text/css');styleElement.setAttribute('media','screen');if(styleElement.styleSheet){styleElement.styleSheet.cssText=css;}else{styleElement.appendChild(document.createTextNode(css));}
document.getElementsByTagName('head')[0].appendChild(styleElement);}}
UserVoice.Page={getDimensions:function(){var de=document.documentElement;var width=window.innerWidth||self.innerWidth||(de&&de.clientWidth)||document.body.clientWidth;var height=window.innerHeight||self.innerHeight||(de&&de.clientHeight)||document.body.clientHeight;return{width:width,height:height};}}
UserVoice.Dialog={preload:function(id_or_html){if(!this.preloaded){var element=document.getElementById(id_or_html);var html=(element==null)?id_or_html:element.innerHTML;this.setContent(html);this.preloaded=true;}},show:function(id_or_html){if(!this.preloaded){this.preload(id_or_html);}
this.Overlay.show();this.setPosition();UserVoice.Element.addClassName(this.htmlElement(),'dialog-open');this.element().style.display='block';this.preloaded=false;this.element().focus();},close:function(){var change=UserVoice.needsConfirm;if(change){var answer=confirm(change);if(!answer){return}}
this.element().style.display='none';UserVoice.Element.removeClassName(this.htmlElement(),'dialog-open');this.Overlay.hide();UserVoice.onClose();},id:'uservoice-dialog',css_template:"\
    #uservoice-dialog {\
      z-index: 100003;\
      display: block;\
      text-align: left;\
      margin: -2em auto 0 auto;\
      position: fixed; \
    }\
    \
    #uservoice-overlay {\
      position: fixed;\
      z-index:100002;\
      width: 100%;\
      height: 100%;\
      left: 0;\
      top: 0;\
      background-color: #000;\
      opacity: 0.7;\
    }\
    \
    #uservoice-overlay p {\
      padding: 5px;\
      color: #ddd;\
      font: bold 14px arial, sans-serif;\
      margin: 0;\
      letter-spacing: -1px;\
    }\
    \
    #uservoice-dialog #uservoice-dialog-close {\
      position: absolute;\
      height: 48px;\
      width: 48px;\
      top: -11px;\
      right: -12px;\
      color: #06c;\
      cursor: pointer;\
      background-position: 0 0;\
      background-repeat: no-repeat;\
      background-color: transparent;\
    }\
    \
    html.dialog-open object,\
    html.dialog-open embed {\
      visibility: hidden;\
    }\
    a#uservoice-dialog-close { background-image: url(#{background_image_url}); }"+(UserVoice.Util.isIE()?"\
    #uservoice-overlay {\
      filter: alpha(opacity=70);\
    }":"")+((UserVoice.Util.isIE()&&(UserVoice.Util.isIE(function(v){return v<7})||(UserVoice.Util.isIE(function(v){return v>=7})&&UserVoice.Util.isQuirksMode())))?"\
    #uservoice-overlay,\
    #uservoice-dialog {\
      position: absolute;\
    }\
    \
    .dialog-open,\
    .dialog-open body {\
      overflow: hidden;\
    }\
    \
    .dialog-open body {\
      height: 100%;\
    }\
    #uservoice-overlay {\
      width: 100%;\
    }\
    \
    #uservoice-dialog #uservoice-dialog-close {\
      background: none;\
      filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='https://uservoice.com/images/icons/close.png');\
    }\
    .dialog-open select {\
      visibility: hidden;\
    }\
    .dialog-open #uservoice-dialog select {\
      visibility: visible;\
    }":""),element:function(){if(!document.getElementById(this.id)){var dummy=document.createElement('div');dummy.innerHTML='<div id="'+this.id+'" class="uservoice-component" style="display:none;">'+'<a href="#close" onclick="UserVoice.Dialog.close(); return false;" id="'+this.id+'-close" title="Close Dialog"><span style="display: none;">Close Dialog</span></a>'+'<div id="'+this.id+'-content"></div></div>';if(document.getElementById('uservoice-feedback')){document.getElementById('uservoice-feedback').insertBefore(dummy.firstChild,document.getElementById('uservoice-feedback').firstChild.nextSibling);}else{document.body.insertBefore(dummy.firstChild,document.body.firstChild);}}
return document.getElementById(this.id);},setContent:function(html){this.element()
if(typeof(Prototype)!='undefined'){document.getElementById(this.id+"-content").innerHTML=html.stripScripts();setTimeout(function(){html.evalScripts()},100);}else{document.getElementById(this.id+"-content").innerHTML=html;}},setPosition:function(){var dialogDimensions=UserVoice.Element.getDimensions(this.element());var pageDimensions=UserVoice.Page.getDimensions();var els=this.element().style;els.width='auto';els.height='auto';els.left=((pageDimensions.width-dialogDimensions.width)/2)+"px";var computedHeight=((pageDimensions.height-dialogDimensions.height)/2);els.top=Math.max(computedHeight,55)+"px";},htmlElement:function(){return document.getElementsByTagName('html')[0];}}
UserVoice.Dialog.Overlay={show:function(){this.element().style.display='block';},hide:function(){this.element().style.display='none';},id:'uservoice-overlay',element:function(){if(!document.getElementById(this.id)){var dummy=document.createElement('div');dummy.innerHTML='<div id="'+this.id+'" class="uservoice-component" onclick="UserVoice.Dialog.close(); return false;" style="display:none;"></div>';document.body.insertBefore(dummy.firstChild,document.body.firstChild);}
return document.getElementById(this.id);}}
UserVoice.Element={getDimensions:function(element){var display=element.display;if(display!='none'&&display!=null){return{width:element.offsetWidth,height:element.offsetHeight};}
var els=element.style;var originalVisibility=els.visibility;var originalPosition=els.position;var originalDisplay=els.display;els.visibility='hidden';els.position='absolute';els.display='block';var originalWidth=element.clientWidth;var originalHeight=element.clientHeight;els.display=originalDisplay;els.position=originalPosition;els.visibility=originalVisibility;return{width:originalWidth,height:originalHeight};},hasClassName:function(element,className){var elementClassName=element.className;return(elementClassName.length>0&&(elementClassName==className||new RegExp("(^|\\s)"+className+"(\\s|$)").test(elementClassName)));},addClassName:function(element,className){if(!this.hasClassName(element,className)){element.className+=(element.className?' ':'')+className;}
return element;},removeClassName:function(element,className){element.className=element.className.replace(new RegExp("(^|\\s+)"+className+"(\\s+|$)"),' ');return element;}}
UserVoice.needsConfirm=false;UserVoice.onClose=function(){};UserVoice.Util.includeCss(UserVoice.Util.render(UserVoice.Dialog.css_template,{background_image_url:UserVoice.Util.getAssetHost()+'/images/icons/close.png'}));if(!UserVoice){var UserVoice={};}
UserVoice.Logger={_log:function(message){if(typeof console!=="undefined"&&typeof console.log!=="undefined"){try{console.log(message);}catch(e){}}},warning:function(message){this._log("UserVoice WARNING: "+message);},error:function(message){this._log("UserVoice ERROR: "+message);alert("UserVoice ERROR: "+message);}};UserVoice.Util={sslAssetHost:"https://cdn.uservoice.com",assetHost:"http://cdn.uservoice.com",getAssetHost:function(){return("https:"==document.location.protocol)?this.sslAssetHost:this.assetHost;},render:function(template,params){return template.replace(/\#{([^{}]*)}/g,function(a,b){var r=params[b];return typeof r==='string'||typeof r==='number'?r:a;})},toQueryString:function(params){var pairs=[];for(key in params){if(params[key]!=null&&params[key]!=''&&typeof params[key]!='function'){pairs.push([key,params[key]].join('='));}}
return pairs.join('&');},isIE:function(test){if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)){if(typeof test==="function"){return test(new Number(RegExp.$1));}else{return true;}}else{return false;}},isQuirksMode:function(){return document.compatMode&&document.compatMode=="BackCompat";},includeCss:function(css){var styleElement=document.createElement('style');styleElement.setAttribute('type','text/css');styleElement.setAttribute('media','screen');if(styleElement.styleSheet){styleElement.styleSheet.cssText=css;}else{styleElement.appendChild(document.createTextNode(css));}
document.getElementsByTagName('head')[0].appendChild(styleElement);}}
UserVoice.Popin={content_template:'<iframe id="uservoice_dialog_iframe" src="#{url}/widgets/#{dialog}.html?#{query}" frameborder="0" scrolling="no" allowtransparency="true" width="#{width}" height="#{height}" style="height: #{height}; width: #{width};"></iframe>',opened_url_template:'#{url}/widgets/#{dialog}.html?#{query}#opened',setup:function(options){this.setupOptions(options);},setupOptions:function(options){if(typeof(options)==='undefined'){return;}
if(options.key==null&&options.host==null){UserVoice.Logger.error("'host' must be set.");UserVoice.Logger.error("'key' must be set.");}else if(options.key==null){UserVoice.Logger.warning("'key' must be set for the widget to work with SSL.")}
if(options.forum==null){UserVoice.Logger.error("'forum' must be set.");}
if(!options.params){options.params={};}
this.options=options;},preload:function(options){this.setupOptions(options);UserVoice.Dialog.preload(UserVoice.Util.render(this.content_template,this.getContext()));},show:function(options){this.setupOptions(options);UserVoice.Dialog.show(UserVoice.Util.render(this.content_template,this.getContext()));try{var iframeElement=document.getElementById("uservoice_dialog_iframe").contentWindow;iframeElement.location=UserVoice.Util.render(this.opened_url_template,this.getContext());}catch(e){UserVoice.Logger.warning("Error sending the 'open' notification");UserVoice.Logger.warning(e);}},getContext:function(){var context={dialog:'popin',width:'350px',height:'530px',lang:'en'};for(attr in this.options){context[attr]=this.options[attr]};context.url=this.url();context.params.lang=this.options.lang;context.params.referer=this.getReferer();context.query=UserVoice.Util.toQueryString(context.params);return context;},getReferer:function(){var referer=window.location.href;if(referer.indexOf('?')!=-1){referer=referer.substring(0,referer.indexOf('?'));}
return referer;},url:function(){if("https:"==document.location.protocol&&this.options.key!=null){var url='https://'+this.options.key+'.uservoice.com/forums/'+this.options.forum;}else{var url='http://'+this.options.host+'/forums/'+this.options.forum;}
return url;}}
UserVoice.Tab={id:"uservoice-feedback-tab",css_template:"\
    body a#uservoice-feedback-tab,\
    body a#uservoice-feedback-tab:link {\
      background-position: 2px 50% !important;\
      position: fixed !important;\
      top: 45% !important;\
      display: block !important;\
      width: 25px !important;\
      height: 98px !important;\
      margin: -45px 0 0 0 !important;\
      padding: 0 !important;\
      z-index: 100001 !important;\
      background-position: 2px 50% !important;\
      background-repeat: no-repeat !important;\
      text-indent: -9000px;\
    }\
    \
    body a#uservoice-feedback-tab:hover {\
      cursor: pointer;\
    }\
    \
    a##{id} { \
      #{alignment}: 0; \
      background-repeat: no-repeat; \
      background-color: #{background_color}; \
      background-image: url(#{text_url}); \
      border: outset 1px #{background_color}; \
      border-#{alignment}: none; \
    }\
    \
    a##{id}:hover { \
      background-color: #{hover_color}; \
      border: outset 1px #{hover_color}; \
      border-#{alignment}: none; \
    }"+((UserVoice.Util.isIE()&&(UserVoice.Util.isIE(function(v){return v<7})||(UserVoice.Util.isIE(function(v){return v>=7})&&UserVoice.Util.isQuirksMode())))?"\
    body a#uservoice-feedback-tab,\
    body a#uservoice-feedback-tab:link {\
      position: absolute !important;\
      background-image: none !important;\
    }\
    a##{id} { filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='#{text_url}'); }":""),show:function(options){this.setupOptions(options||{});UserVoice.Popin.setup(options);var html='<a id="'+this.id+'"';if(!this.options.no_dialog){html+='" onclick="UserVoice.Popin.show(); return false;"';if(this.options.preload){html+='" onmouseover="UserVoice.Popin.preload();"';}}
html+=' href="'+UserVoice.Popin.url()+'">'+(this.options.tab_string[this.options.lang]?this.options.tab_string[this.options.lang]:'Open Feedback Dialog')+'</a>';var tab=document.createElement('div');tab.setAttribute('id','uservoice-feedback');tab.innerHTML=html;document.body.insertBefore(tab,document.body.firstChild);if(!this.options.no_styles){UserVoice.Util.includeCss(UserVoice.Util.render(this.css_template,this.options));}},onKeyDown:function(e){if(!e)e=window.event;key=e.keycode?e.keycode:e.which;if(key==13){UserVoice.Popin.show();return false;}},setupOptions:function(options){this.options={alignment:'left',background_color:'#f00',text_color:'white',hover_color:'#06C',lang:'en',no_styles:false,no_dialog:false,preload:true}
for(attr in options){this.options[attr]=options[attr];}
this.options.tab_string={cn:"反馈",de:"Feedback",es:"Sugerencias",fi:"Palaute",fr:"Commentaires",ja:"フィードバック",nl:"Feedback",no_NB:"Feedback",pt_BR:"Comentário",tr:"Geribildirim"};this.options.text_url=UserVoice.Util.getAssetHost()+'/images/widgets/'+(this.options.tab_string[this.options.lang]?this.options.lang:'en')+'/feedback_tab_'+this.options.text_color+'.png';this.options.id=this.id;}}
if(typeof(uservoiceOptions)!=='undefined'&&uservoiceOptions.showTab==true){UserVoice.Tab.show(uservoiceOptions);}