<?php use_helper('I18N') ?>

<?php echo "<?xml version='1.0' encoding='utf-8' ?>" ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <title><?php echo __('Voota. Tú tienes la última palabra') ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="<?php echo __('Voota. Tú tienes la última palabra') ?>" />
<meta name="robots" content="All" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="shortcut icon" href="/favicon.ico" />
  <script type="text/javascript" src="/sfJqueryReloadedPlugin/js/jquery-1.3.2.min.js"></script>
  <script type="text/javascript" src="/sfReviewPlugin/js/sf_review.js"></script>
  <script type="text/javascript" src="/js/voota.js"></script>
  <script type="text/javascript" src="/sfJqueryReloadedPlugin/js/jquery-ui-1.7.2.custom.min.js"></script>
  <link rel="stylesheet" type="text/css" media="screen" href="/css/ui-lightness/jquery-ui-1.7.2.custom.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/sfReviewPlugin/css/sf_review.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/css/screen.css" />
</head>

<body id="error">

  <!-- HEADER -->
  <div id="header">
    <div id="header-inner">
      <h1 id="logo"><a href="/es"><?php echo __('Voota') ?></a></h1>
      <h2 id="slogan"><?php echo __('Tú tienes la última palabra') ?></h2>
    </div>
  </div><!-- FIN HEADER -->

  <!-- MAIN -->
  <div id="main">
    <div id="main-inner">
      <h2><?php echo __('¡Clonk! Página no encontrada') ?></h2>
      <p id="message"><?php echo __('Parece ser que ya no tenemos disponible la página que intentas visitar. A lo mejor nunca ha existido. Lo único que podemos ofrecerte en este momento es un humilde enlace a la ') ?><?php echo link_to(__('página de inicio de Voota'), '@homepage') ?></p>
      <p id="hands">
        <img src="/images/404.gif" alt="404" />
      </p>
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
      <?php echo link_to(__('Contactar'), '@contact', array('class' => "enlacesPie")) ?>
      <?php echo link_to(__('Aviso legal'), __('http://blog.voota.es/es/aviso-legal'), array('class' => "enlacesPie")) ?>    
    </p>

    <p class="copyright">Voota.es 2009</p>
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