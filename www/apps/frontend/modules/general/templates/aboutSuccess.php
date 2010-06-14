<?php use_helper('I18N') ?>

<h2><?php echo __('¿Quiénes somos? Algunos datos sobre Voota')?></h2>

<div id="content">
  <div class="description">
    <h3>
      <?php echo __('Somos una asociación sin ánimo de lucro. Nuestro objetivo es fomentar la participación ciudadana en la política del momento.') ?> 
      <?php echo link_to('Voota.es', "@homepage")?> <?php echo __('es la web donde pretendemos que todos puedan informarse y publicar sus opiniones sobre políticos y partidos.')?>
    </h3>
  </div>

  <div class="founders">
    <h3><?php echo __('Equipo fundador de Voota')?></h3>

    <ul>
      <?php include_partial('socioabout', array('socio' => $users[2])) ?>
      <?php include_partial('socioabout', array('socio' => $users[1])) ?>
      <?php include_partial('socioabout', array('socio' => $users[5])) ?>
      <?php include_partial('socioabout', array('socio' => $users[22])) ?>
    </ul>
  </div>

  <div class="others">
    <h3><?php echo __('Otra gente muy implicada en el proyecto')?></h3>

    <ul>
      <?php include_partial('socioabout', array('socio' => $users[4])) ?>
      <?php //include_partial('socioabout', array('socio' => $users[7])) ?>
      <?php include_partial('socioabout', array('socio' => $users[31])) ?>
      <?php include_partial('socioabout', array('socio' => $users[180])) ?>
    </ul>
  </div>

  <div class="social-data">
    <h3><?php echo __('Y, finalmente, nuestros datos sociales')?></h3>

    <p>
      <?php echo __('Asociación Voota,')?><br />
      <?php echo __('CIF: G85756625,')?><br />
      <?php echo __('Domicilio social en C/ Conde de Aranda 20, 2º Izq. 28001 Madrid')?><br />
    </p>
  </div>

</div>

<div id="sidebar">
  <div class="voota">
    <h3><?php echo __('Más sobre Voota')?></h3>

    <ul>
      <li><a href="http://blog.voota.es/es/wp-content/uploads/2009/10/estatutos-voota-web.pdf"><?php echo __('Estatutos')?></a></li>
      <li><a href="http://blog.voota.es/es/socios/"><?php echo __('Socios')?></a></li>
      <li><a href="http://blog.voota.es/es/financiacion-voota/"><?php echo __('Financiación')?></a></li>
      <li><a href="http://blog.voota.es/es/junta-directiva/"><?php echo __('Junta directiva')?></a></li>
    </ul>
  </div>

  <div class="social">
    <h3><?php echo __('Más sobre nosotros en&hellip;')?></h3>

    <ul>
      <li><a href="<?php echo __('http://www.facebook.com/Voota') ?>">Facebook</a></li>
      <li><a href="<?php echo __('http://twitter.com/Voota') ?>">Twitter</a></li>
      <li><a href="<?php echo __('http://www.flickr.com/photos/voota') ?>">Flickr</a></li>
    </ul>
  </div>

  <div class="history">
    <h3><?php echo __('Algunos Hitos de Voota')?></h3>

    <dl>
      <dt><?php echo __('Febrero 2010')?></dt>
      <dd><?php echo __('Voota alcanza la friolera de 20 socios. Al mismo tiempo, ya se empieza a notar en la web la realidad que hay en la calle.')?></dd>
      
      <dt><?php echo __('Noviembre 2009')?> </dt>
      <dd><?php echo __('Una primera versión de la web, muy reducida, ve la luz.')?></dd>
      
      <dt><?php echo __('Septiembre 2009')?></dt>
      <dd>
        <?php echo __('El proyecto se presenta en sociedad. Varios Blogs y medios digitales se hacen eco de la noticia')?>
        (<?php echo link_to('Geekets', "http://www.geekets.com/2009/09/04/voota-haz-catarsis-con-tus-politicos")?>  
        <?php echo __('y')?> 
        <?php echo link_to('Ricard Espelt', __('http://www.theplateishot.com/en/voota-tu-tienes-la-ultima-palabra/'))?>  
        <?php echo __('y varios más')?>).
      </dd>
      
      <dt><?php echo __('Julio 2009')?></dt>
      <dd><?php echo __('Voota se constituye como asociación sin ánimo de lucro.')?></dd>
      
      <dt><?php echo __('Junio 2009')?></dt>
      <dd><?php echo __('Dos meses más tarde se lo cuentan a Juan Leal. Y más de lo mismo: Idea genial. María Ayuso también se apunta para llevar la gestión.')?></dd>
      
      <dt><?php echo __('Abril 2009')?></dt>
      <dd><?php echo __('François comenta la idea con su amigo Sergio Viteri, que lo ve con buenos ojos.')?></dd>
    </dl>
  </div>

</div>