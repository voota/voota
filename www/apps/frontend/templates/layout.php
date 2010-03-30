<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('sfFacebookConnect'); ?>
<?php use_helper('VoUser'); ?>

<?php echo "<?xml version='1.0' encoding='utf-8' ?>" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php if ($sf_request->getParameter('sf_culture')): ?>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang="<?php echo $sf_request->getParameter('sf_culture') ?>" lang="<?php echo $sf_request->getParameter('sf_culture') ?>">
<?php else: ?>
<html xmlns='http://www.w3.org/1999/xhtml'>
<?php endif ?>
<head>
  <?php include_title() ?>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta content='chrome=1' http-equiv='X-UA-Compatible' />
  <link rel="shortcut icon" href="/favicon.ico" />
  <style>
    <?php if (strstr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit")): ?>
      input[type=submit], input[type=button], button { padding: 3px 10px 3px 10px; line-height: 13px; }
    <?php elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Gecko")): ?>
      input[type=submit], input[type=button], button { padding: 0 10px 1px 10px; line-height: 13px; }
    <?php elseif (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")): ?>
      input[type=submit], input[type=button], button { padding: 3px 10px 0 10px; line-height: 12px; }
      .search button { margin-top: 1px; }
    <?php endif ?>
  </style>
</head>

<body id="<?php echo $sf_context->getModuleName()."-". $sf_context->getActionName() ?>"> 
  <?php 
    slot('fb_connect');
    include_facebook_connect_script();
    end_slot();
  ?>
  <script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
	    $('#fbc_button').click(function(){
	    	return facebookConnect();
	    });
      <?php if ($sf_user->getFlash('logToFB')):  ?>  
		    publishFaceBook("<?php __('He comenzado a compartir mis opiniones sobre políticos de España en Voota')?>", null, [{'text':'<?php echo __('Ir a Voota') ?>', 'href':'http://voota.es'}], '<?php echo __('Vamos a publicar esto en Facebook, ¿que te parece') ?>');
	    <?php endif ?>	    
	  });
    <?php if( $sf_request->getAttribute("ie6") ):?>
	  	$("#ie6 .close a").click(function(){
	  		$('#ie6').remove();
	  		return false;
	    });
	<?php endif ?>
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
  	      <p><?php echo vo_facebook_connect_button(); ?></p>
  	      <?php /* ?>
  	      <script type="text/javascript" charset="utf-8">
  	        $(document).ready(function(){
  	          facebookConnect_autoLogin();
  	        })
  	      </script>
  	      <?php */ ?>
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
            ·
            <?php echo link_to(__('salir'), '@sf_guard_signout', array('id' => 'logout')) ?>
          </p>
        <?php end_slot('logged') ?>

        <?php include_slot($sf_user->isAuthenticated()?'logged':'not_logged') ?>
      </div>

      <?php if ($sf_context->getModuleName() != "home"): ?>
        <div id="search">
          <form method="get" action="<?php echo url_for('@search')?>">
            <fieldset>
              <input type="text" name="q" id="q" value="<?php echo $sf_params->get('q') ?>" />
      	      <button type="submit"><?php echo __('Buscar') ?></button>
            </fieldset>
          </form>
        </div>
      <?php endif ?>
      
      <?php if( $sf_request->getAttribute("ie6") ):?>
        <div id="ie6">
          <h3><?php echo __('Aviso a los amantes del vintage')?></h3>
          <p><?php echo __('Nos han saltado las alarmas diciéndonos que estás usando Internet Explorer 6, auténtica reliquia del año 2001. Por desgracia este navegador que usas no soporta lo que se denomina “estándares web”, que es algo que te ayuda a visualizar como es debido las páginas que visitas cuando estás en Internet.')?></p>

          <p><?php echo __('¿Nuestra recomendación? Que actualizes tu navegador (es gratis). Te damos algunas ideas: <a href="http://www.getfirefox.com/">Firefox</a>, <a href="http://www.google.com/chrome">Chrome</a>, <a href="http://www.opera.com/">Opera</a>... O la última versión de <a href="http://www.microsoft.com/spain/windows/internet-explorer/">Explorer</a>, claro.')?></p>
          <p class="close"><a href="#"><?php echo __('Cerrar')?></a></p>
        </div>
      <?php endif ?>
      
      <?php include_slot('header-extra') ?>
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
      <a href="<?php echo __('http://creativecommons.org/licenses/by-sa/3.0/deed.es') ?>"><img src="/images/icoCc.gif" alt="Creative Commons" width="34" height="34" longdesc="Creative Commons" /></a>
      <?php echo __('Voota y <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es">Creative Commons</a> son amigos de toda la vida')?>
    </p>
    <p class="nav-links">
      <?php echo link_to(__('Quiénes somos'), '@about', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Blog'), 'http://blog.voota.es/'. $sf_user->getCulture('es'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Socios'), 'http://blog.voota.es/es/socios/', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Financiación'), 'http://blog.voota.es/es/financiacion-voota', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Twitter'), __('http://twitter.com/Voota'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Facebook'), __('http://www.facebook.com/Voota'), array('class' => "enlacesPie")) ?>
      <a href="#" onclick="UserVoice.Popin.show(uservoiceOptions);return false;"><?php echo __('Sugerencias')?></a>
      <?php echo link_to(__('Contactar'), '@contact', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array('class' => "enlacesPie")) ?>
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

  <script type="text/javascript" charset="utf-8">
    $(function(){ 
			$('input[title!=""], textarea[title!=""]').hint();
		});
  </script>

  <?php if (has_slot('fb_connect')): ?>
    <?php include_slot('fb_connect') ?>
  <?php endif; ?>

  <!-- GOOGLE ANALYTICS -->
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-10529881-1");
      pageTracker._trackPageview();
    } catch(err) {}
  </script><!-- FIN GOOGLE ANALYTICS -->
  
  <script type="text/javascript">
var uservoiceOptions = {
  /* required */
  key: 'voota',
  host: 'voota.uservoice.com', 
  forum: '42379',
  showTab: true,  
  /* optional */
  alignment: 'left',
  background_color:'#3366FF', 
  text_color: 'white',
  hover_color: '#06C',
  lang: 'es'
};

function _loadUserVoice() {
  var s = document.createElement('script');
  s.setAttribute('type', 'text/javascript');
  s.setAttribute('src', ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js");
  document.getElementsByTagName('head')[0].appendChild(s);
}
_loadSuper = window.onload;
window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
</script>

</body>
</html>
