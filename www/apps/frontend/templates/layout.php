<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo $sf_user->getCulture() ?>" xmlns:fb="http://www.facebook.com/2008/fbml">

<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoUser'); ?>

<head>
  <?php include_title() ?>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/ui-voota/jquery-ui-1.8.custom.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/screen.css?<?php echo sfConfig::get('sf_ml') ?>" />  
  <style type="text/css">
    <?php if (strstr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit")): ?>
      input[type=submit], input[type=button], button { padding: 3px 10px 3px 10px; line-height: 13px; }
    <?php elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Gecko")): ?>
      input[type=submit], input[type=button], button { padding: 1px 10px 1px 10px; line-height: 13px; }
    <?php elseif (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")): ?>
      input[type=submit], input[type=button], button { padding: 3px 10px 0 10px; line-height: 12px; }
      .search button { margin-top: 1px; }
    <?php endif ?>
  </style>

  <!--[if lt IE 9]>
    <script type="text/javascript" src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
  <![endif]-->
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script type="text/javascript" src="http://connect.facebook.net/es_ES/all.js"></script>
  
  <?php if (sfConfig::get('sf_merged')):  ?>
    <script type="text/javascript" src="/js/all.js?<?php echo sfConfig::get('sf_ml') ?>"></script>
  <?php else: ?>
    <script type="text/javascript" src="/js/voota.js?<?php echo sfConfig::get('sf_ml') ?>"></script>
    <script type="text/javascript" src="/sfReviewPlugin/js/sf_review.js?<?php echo sfConfig::get('sf_ml') ?>"></script>
    <script type="text/javascript" src="/sfReviewPlugin/js/jquery.hint.js"></script>
    <script type="text/javascript" src="/js/jquery.qtip-1.0.min.js"></script>
    <script type="text/javascript" src="/js/bluff/js-class.js"></script>
    <script type="text/javascript" src="/js/bluff/excanvas.js"></script>
    <script type="text/javascript" src="/js/bluff/bluff.js"></script>
    <script type="text/javascript" src="/js/bluff/custom.js"></script>
  <?php endif ?>
  <script type="text/javascript" src="/js/ajaxupload.js"></script>

  <?php if($sf_request->getAttribute('rssFeed')): ?>
  <link rel="alternate" type="application/rss+xml" title="<?php echo $sf_request->getAttribute('rssTitle')?>" href="<?php echo url_for($sf_request->getAttribute('rssFeed')) ?>" />
  <?php endif ?>

  <?php if ($sf_context->getModuleName() == 'home' && $sf_context->getActionName() == 'index'):?>
  	<link rel="image_src" href="http://images.voota.es/shots/s-home-<?php echo $sf_user->getCulture('es')?>.jpg" />
  <?php endif ?>
  <?php if ($sf_context->getModuleName() == 'politico' && $sf_context->getActionName() == 'ranking'):?>
  	<link rel="image_src" href="http://images.voota.es/shots/s-ranking-polit-<?php echo $sf_user->getCulture('es')?>.jpg" />
  <?php endif ?>
  <?php if ($sf_context->getModuleName() == 'partido' && $sf_context->getActionName() == 'ranking'):?>
  	<link rel="image_src" href="http://images.voota.es/shots/s-ranking-part-<?php echo $sf_user->getCulture('es')?>.jpg" />
  <?php endif ?>
<script type="text/javascript">
	var bkHost = (("https:" == document.location.protocol) ? "https://static-ssl." : "http://static.");
	document.write(
	unescape("%3Cscript src='" +
	bkHost + "blueknow.com/bk.js' " +
	"type='text/javascript'%3E%3C/script%3E")
	);
</script>
  
</head>

<body id="<?php echo $sf_context->getModuleName()."-". $sf_context->getActionName() ?>"> 
  <div id="fb-root"></div>
  <script type="text/javascript">
    FB.init({appId  : '<?php echo sfConfig::get('app_facebook_api_id_'.$sf_user->getCulture()) ?>', status : true, cookie : true, xfbml  : true});
    FB.Event.subscribe('auth.login', function(response){
      window.location = '<?php echo url_for('sfGuardAuth/signin?op=fbc') ?>';
    });    
  </script>

  <script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
      <?php if ($sf_user->getFlash('logToFB')):  ?>  
	      publishFaceBook("<?php echo __('He comenzado a compartir mis opiniones sobre políticos de España en Voota')?>", null, [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}], '<?php echo __('Vamos a publicar esto en Facebook, ¿que te parece?') ?>');
      <?php endif ?>
      
      $('#logout').click(function(){
        FB.getLoginStatus(function(response) {
          if (response.session) { FB.logout(); }
        });
      });

      <?php if( $sf_request->getAttribute("ie6") ):?>
  	  	$("#ie6 .close a").click(function(){
  	  		$('#ie6').remove();
  	  		return false;
  	    });
  	  <?php endif ?>
    });
    //]]>
  </script>
 
  <!-- HEADER -->
  <div id="header">
    <div id="header-inner">
      <h1 id="logo"><a href="<?php echo url_for('@homepage') ?>">Voota</a></h1>
      <h2 id="slogan"><?php echo __('Tú tienes la última palabra')?></h2>

      <div id="user-links">
        <?php slot('not_logged') ?>
          <p><?php echo link_to(__('Login/Registrarse'), 'sfGuardAuth/signin') ?> </p>
  	      <p>
  	        <a href="#" onclick="javascript:facebookLogin('<?php echo url_for('sfGuardAuth/signin?op=fbc') ?>')" class="facebook-button"><span><?php echo __('Entrar con Facebook') ?></span></a>
  	      </p>
        <?php end_slot('not_logged') ?>

        <?php slot('logged') ?>
          <p>
            <?php if ($sf_context->getModuleName()."-". $sf_context->getActionName() != "sfGuardAuth-signin"): ?>
              <?php if($sf_user->getProfile() && $sf_user->getProfile()->getFbTip() && !$sf_user->getProfile()->getFacebookUid()): ?>
              <span id="lo_fb_conn">
            	  <strong><?php echo __('Tip:')?> </strong>
            	    <?php echo vo_facebook_connect_associate_button(__('Sincronizar tu cuenta en Voota con Facebook'), 'lo_fb_conn'); ?>
                <span class="close">(<a href="#" onclick="close_sync_tip('<?php echo url_for('sfGuardAuth/removeTip')?>'); return false"><?php echo __('Cerrar') ?></a>)</span>
              </span>
              <?php endif ?>
              <?php if($sf_user->getProfile() && $sf_user->getProfile()->getFbTip() && $sf_user->getProfile()->getFacebookUid() && !SfVoUtil::isCanonicalVootaUser($sf_user->getGuardUser())): ?>
              <span id="lo_fb_conn">
            	  <strong><?php echo __('Tip:')?> </strong>
            	  	<a href="<?php echo url_for('sfGuardAuth/signin?op=fb')?>"><?php echo __('¿Ya tenías cuenta en Voota? Sincronizar con tu Facebook') ?></a>
                <span class="close">(<a href="#" onclick="close_sync_tip('<?php echo url_for('sfGuardAuth/removeTip')?>'); return false"><?php echo __('Cerrar') ?></a>)</span>
              </span>
              <?php endif ?>
            <?php endif ?>

            <?php echo getAvatar( $sf_user->getGuardUser() )?>

            <?php echo link_to($sf_user->isAuthenticated()?fullName( $sf_user ):'', '@usuario_votos') ?>
            <span class="separator">·</span>
            <?php echo link_to(__('salir'), '@sf_guard_signout', array('id' => 'logout')) ?>
          </p>
        <?php end_slot('logged') ?>

        <?php include_slot($sf_user->isAuthenticated()?'logged':'not_logged') ?>

      </div>

      <div class="search">
        <form method="get" action="<?php echo url_for('@search')?>">
          <fieldset>
            <input type="text" name="q" id="q" value="<?php echo $sf_request->getAttribute('q') ?>" />
    	      <button type="submit"><?php echo __('Buscar') ?></button>
          </fieldset>
        </form>
      </div>
      
      <?php if( $sf_request->getAttribute("ie6") ):?>
        <div id="ie6">
          <h3><?php echo __('Aviso a los amantes del vintage')?></h3>
          <p><?php echo __('Nos han saltado las alarmas diciéndonos que estás usando Internet Explorer 6, auténtica reliquia del año 2001. Por desgracia este navegador que usas no soporta lo que se denomina “estándares web”, que es algo que te ayuda a visualizar como es debido las páginas que visitas cuando estás en Internet.')?></p>

          <p><?php echo __('¿Nuestra recomendación? Que actualizes tu navegador (es gratis). Te damos algunas ideas: <a href="http://www.getfirefox.com/">Firefox</a>, <a href="http://www.google.com/chrome">Chrome</a>, <a href="http://www.opera.com/">Opera</a>... O la última versión de <a href="http://www.microsoft.com/spain/windows/internet-explorer/">Explorer</a>, claro.')?></p>
          <p class="close"><a href="#"><?php echo __('Cerrar')?></a></p>
        </div>
      <?php endif ?>
      
      <?php include_slot('header-extra') ?>

      <?php include_slot('menu') ?>
	  
    </div>
  </div><!-- FIN HEADER -->

  <!-- MAIN -->
  <div id="main">
    <div id="main-inner">
      <?php echo $sf_content ?>
    </div>
  </div><!-- FIN MAIN -->

  <!-- FOOTER -->
  <div id="footer">
    <p class="license">
      <a href="<?php echo __('http://creativecommons.org/licenses/by-sa/3.0/deed.es') ?>"><img src="/images/icoCc.png" alt="Creative Commons" width="34" height="34" /></a>
      <?php echo __('Voota y <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es">Creative Commons</a> son amigos de toda la vida')?>
    </p>
    <p class="nav-links">
      <?php echo link_to(__('Quiénes somos'), '@about', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Blog'), __('http://blog.voota.es/'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Socios'), 'http://blog.voota.es/es/socios/', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Financiación'), 'http://blog.voota.es/es/financiacion-voota', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Twitter'), __('http://twitter.com/Voota'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Facebook'), __('http://www.facebook.com/Voota'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Sugerencias'), $sf_user->getCulture() == 'ca'?'http://vootacat.uservoice.com':'http://voota.uservoice.com', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Contactar'), '@contact', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('API'), 'http://trac.voota.org/wiki/API', array('class' => "enlacesPie")) ?>
    </p>
    <p class="nav-links">
      <?php echo link_to(__('Ranking políticos'), 'politico/ranking', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Ranking partidos'), 'partido/ranking', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Ranking propuestas'), 'propuesta/ranking', array('class' => "enlacesPie")) ?>
    </p>
    <p class="lang-links">
      <?php slot('langLink_ca') ?>
      	Català
      	<?php echo link_to('Español', changeCulture('es'), array('class' => "enlacesPie")) ?>
      <?php end_slot('langLink_ca') ?>

      <?php slot('langLink_es') ?>
      	<?php echo link_to('Català', changeCulture('ca'), array('class' => "enlacesPie")) ?>
      	Español
      <?php end_slot('langLink_es') ?>

      <?php include_slot( "langLink_".$sf_user->getCulture('es') ); ?>
    </p>

  </div><!-- FIN FOOTER -->

  <script type="text/javascript">
    $(document).ready(function(){ 
			$('input[title!=""], textarea[title!=""]').hint();
		});
		$(document).bind('resize scroll', function(){
		  $('.qtip').hide();
		});
  </script>
 
  <!-- GOOGLE ANALYTICS -->
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo sfConfig::get("sf_ga_account_".$sf_user->getCulture()) ?>']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
  <!-- FIN GOOGLE ANALYTICS -->
  
  <script type="text/javascript">
    // var uservoiceOptions = {
    //   /* required */
    //   key: "<?php echo $sf_user->getCulture() == 'ca'?'vootacat':'voota'?>",
    //   host: "<?php echo $sf_user->getCulture() == 'ca'?'vootacat.uservoice.com':'voota.uservoice.com'?>", 
    //   forum: '42379',
    //   showTab: true,  
    //   /* optional */
    //   alignment: 'right',
    //   background_color:'#3366FF', 
    //   text_color: 'white',
    //   hover_color: '#06C',
    //   lang: 'es'
    // };
    // 
    // function _loadUserVoice() {
    //   var s = document.createElement('script');
    //   s.setAttribute('type', 'text/javascript');
    //   s.setAttribute('src', ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js");
    //   document.getElementsByTagName('head')[0].appendChild(s);
    // }
    // 
    // $(window).load(function(){
    //   _loadUserVoice();
    // });
  </script>

</body>
</html>
