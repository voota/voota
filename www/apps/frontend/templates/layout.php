<?php use_helper('I18N') ?>
<?php use_helper('Form') ?>
<?php echo "<?xml version='1.0' encoding='utf-8' ?>" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <?php include_title() ?>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="shortcut icon" href="/favicon.ico" />
</head>

<body id="<?php echo $sf_context->getModuleName()."-". $sf_context->getActionName() ?>"> 

  <!-- HEADER -->
  <div id="header">
    <div id="header-inner">
      <h1 id="logo"><a href="<?php echo url_for('@homepage') ?>">Voota</a></h1>
      <h2 id="slogan"><?php echo __('Tú tienes la última palabra')?></h2>

      <p id="user-links">
        <?php slot('not_logged') ?>
  	      <?php echo link_to(__('Acceso usuarios'), 'sfGuardAuth/signin') ?>
        <?php end_slot('not_logged') ?>

        <?php slot('logged') ?>
          <?php if($sf_user->getProfile() && $sf_user->getProfile()->getImagen() &&  $sf_user->getProfile()->getImagen() != '' ): ?>
  	        <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($sf_user->getProfile()->getImagen()), 'alt="Foto '. $sf_user->getProfile()->getNombre().' ' . $sf_user->getProfile()->getApellidos() .'"') ?>
          <?php endif ?>

          <?php echo link_to($sf_user->isAuthenticated()?($sf_user->getProfile()->getNombre(). " " .$sf_user->getProfile()->getApellidos()):'', '@usuario_edit') ?>
          ·
          <?php echo link_to(__('salir'), '@sf_guard_signout') ?>
        <?php end_slot('logged') ?>

        <?php include_slot($sf_user->isAuthenticated()?'logged':'not_logged') ?>
      </p>

      <?php if ($sf_context->getModuleName() != "home"): ?>
        <div id="search">
          <?php echo form_tag('@search') ?>
    	      <?php echo input_tag('q', $sf_params->get('q')) ?>
    	      <?php echo submit_tag('Buscar', array('class' => 'button')) ?>
          </form>
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
      <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es"><img src="/images/icoCc.gif" alt="Creative Commons" width="34" height="34" longdesc="Creative Commons" /></a>
      <?php echo __('Voota y <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.es">Creative Commons</a> son amigos de toda la vida')?>
    </p>
    <p class="nav-links">
      <?php echo link_to(__('Quiénes somos'), '@about', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Blog'), 'http://blog.voota.es/'. $sf_user->getCulture('es'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Socios'), 'http://blog.voota.es/es/socios/', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Financiación'), 'http://blog.voota.es/es/financiacion-voota', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Twitter'), __('http://twitter.com/Voota'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Facebook'), __('http://www.facebook.com/Voota'), array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Contactar'), '@contact', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array('class' => "enlacesPie")) ?>
    </p>

    <p class="lang-links">
      <?php slot('langLink_ca') ?>
      	català
      	<?php echo link_to('Español', '@homepage?sf_culture=es&l=es', array('class' => "enlacesPie")) ?>
      <?php end_slot('langLink_ca') ?>

      <?php slot('langLink_es') ?>
      	<?php echo link_to('Català', '@homepage?sf_culture=ca&l=ca', array('class' => "enlacesPie")) ?>
      	español
      <?php end_slot('langLink_es') ?>

      <?php include_slot( "langLink_".$sf_user->getCulture('es') ); ?>
    </p>

    <p class="copyright">Voota.es <?php echo date('Y')?></p>
  </div><!-- FIN FOOTER -->

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

</body>
</html>