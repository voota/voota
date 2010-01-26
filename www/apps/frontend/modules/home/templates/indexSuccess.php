<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
	    <?php include_component_slot('sparkline', array('politico' => $politico)) ?>
	  <?php endforeach ?>
    <?php if(count($politicosMasVotadosUltimamente) < 6):?>
    	<?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
	  		<?php include_component_slot('sparkline', array('politico' => $politico)) ?>
    	<?php endforeach?>
	  <?php endif ?>
    <?php foreach($topPoliticos as $politico): ?>
  		<?php include_component_slot('sparkline', array('id' => "sparkline_t_".$politico->getId(), 'politico' => $politico)) ?>
	  <?php endforeach?>
  });
  //-->
</script>

<?php slot('header-extra') ?>
  <div id="contact-links">
    <ul>
      <li class="blog"><a href="<?php echo __('http://blog.voota.es/es') ?>"><?php echo __('Voota tiene un blog') ?></a></li>
      <li class="twitter"><a href="<?php echo __('http://twitter.com/Voota') ?>"><?php echo __('Voota en Twitter') ?></a></li>
      <li class="facebook"><a href="<?php echo __('http://www.facebook.com/Voota') ?>"><?php echo __('Voota en Facebook') ?></a></li>
    </ul>
  </div>
<?php end_slot('logged') ?>

<div class="block">
  <div class="block-inner">
    <div id="summary">
      <?php if ($sf_user->isAuthenticated()): ?>
        <h2><?php echo __('Hola %1%, nos alegra verte por aquí :)', array('%1%' => $sf_user->getGuardUser())); ?></h2>
        <h3><?php echo __('La última vez que estuviste por aquí visitaste:') ?></h3>
        <div id="politicians-latest-visited" class="list-mini">
          <ul>
            <li>
        	    <div class="avatar"><img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" /></div>
        	    <h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
              <p class="votes">
          		  <span title="Evolución del número de votos positivos por mes (último punto = mes
         actual)" id="sparkline_238"></span>
        		    <span class="votes-count"></span>
        	    </p>
            </li>
            <li>
        	    <div class="avatar"><img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" /></div>
        	    <h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
              <p class="votes">
          		  <span title="Evolución del número de votos positivos por mes (último punto = mes
         actual)" id="sparkline_239"></span>
        		    <span class="votes-count"></span>
        	    </p>
            </li>
            <li>
        	    <div class="avatar"><img alt="Foto de José Luis Rodríguez Zapatero" src="http://imagesvoota.s3.amazonaws.com/politicos/cc_s_p_238.jpg" /></div>
        	    <h4 class="name"><a href="/frontend_dev.php/es/politico/Rodr%C3%ADguez-Zapatero">José Luis Rodríguez Zapatero (PSOE)</a></h4>
              <p class="votes">
          		  <span title="Evolución del número de votos positivos por mes (último punto = mes
         actual)" id="sparkline_240"></span>
        		    <span class="votes-count"></span>
        	    </p>
            </li>
          </ul>
        </div>
      <?php else: ?>
        <ul>
          <li><h2><?php echo __('Comparte opiniones sobre políticos de España.') ?></h2></li>
          <li><h2><?php echo __('De momento llevamos %1% opiniones, de %4% personas, sobre %5% políticos.', array(
          					'%1%' => format_number($totalUpReviews+$totalDownReviews, 'es_ES'),
          					//'%2%' => format_number($totalUpReviews, 'es_ES'),
          					//'%3%' => format_number($totalDownReviews, 'es_ES'),
                  			'%4%' => format_number($totalUsers, 'es_ES'),
                  			'%5%' => format_number($totalPoliticos, 'es_ES'),
          				)) ?></h2></li>
          <li>
            <h2><?php echo __('Los políticos más votados de hoy:') ?></h2>
            <div id="politicians-most-voted" class="list-mini">
                <ul>
                  <?php foreach($politicosMasVotadosUltimamente as $politico): ?>
        	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
        	        <?php endforeach?>
                  <?php if(count($politicosMasVotadosUltimamente) < 6):?>
            	      <?php foreach($politicosMasVotadosUltimamenteCont as $politico): ?>
          	  			  <?php include_partial('politico_li', array('id' => "sparkline_".$politico->getId(), 'politico' => $politico, 'showVotes' => false)) ?>
                    <?php endforeach?>
                  <?php endif ?>
                </ul>
            </div>
          </li>
        </ul>
      <?php endif ?>
      <div class="search">
        <form method="get" action="<?php echo url_for('@search')?>">
          <p><label for="q_1"><?php echo __('¡Buusca!')?></label></p>
          <p>
            <input type="text" name="q" id="q_1" value="<?php echo $sf_params->get('q') ?>" />
            <br />
            <span class="hints"><?php echo __('Político, partido, institución o usuario') ?></span>
          </p>
          <p><input type="submit" value="<?php echo __('Buscar') ?>" class="button" /></p>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ($sf_user->isAuthenticated()): // TODO: Si el usuario está autentificado, o si es un usuario que vuelve al site ?>
  <div class="block">
    <div class="block-inner">
      <div id="latest-comments-votes">
        <div class="positive-reviews">
          <h3>
            <?php echo __('Comentarios positivos más votados') ?>
            <img src="/images/icoUp.gif" alt="yeah!" />
          </h3>
          <ol>
            <li class="review" id="sf_review_c_m28"> 
            	<div class="review-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="review-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
                <span class="review-years">· 32 años</span>
              </h4> 
              <p class="review-about">Sobre <a href="#">Mariano Rajoy Prey (PP)</a></p>
              <p class="review-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p class="add-subreview"> 
              	<a href="#" onclick="document.getElementById('subreviews_box17').className = 'subreviews shown';return loadReviewBox('/frontend_dev.php/es/review/form', null,  17,  0, 'sf_review_c17' )">Opinar sobre este comentario</a> 
          		  (Lleva 3 <img alt="A favor, yeah" src="/images/icoMiniUp.png" /> y 4 <img alt="En contra, buu" src="/images/icoMiniDown.png" />)
              </p>
        	  </li>
      		</ol>
        </div>
        <div class="negative-reviews">
          <h3>
            <?php echo __('Comentarios negativos más votados') ?>
            <img src="/images/icoDown.gif" alt="boo!" />
          </h3>
          <ol>
            <li class="review" id="sf_review_c_m28"> 
            	<div class="review-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="review-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
                <span class="review-years">· 32 años</span>
              </h4> 
              <p class="review-about">Sobre <a href="#">Mariano Rajoy Prey (PP)</a></p>
              <p class="review-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p class="add-subreview"> 
              	<a href="#" onclick="document.getElementById('subreviews_box17').className = 'subreviews shown';return loadReviewBox('/frontend_dev.php/es/review/form', null,  17,  0, 'sf_review_c17' )">Opinar sobre este comentario</a> 
          		  (Lleva 3 <img alt="A favor, yeah" src="/images/icoMiniUp.png" /> y 4 <img alt="En contra, buu" src="/images/icoMiniDown.png" />)
              </p>
        	  </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <div class="block">
    <div class="block-inner">
      <div id="latest-comments-on-comments">
        <h3><?php echo __('Últimos comentarios en los que tú comentaste') ?></h3>
        <div class="column">
          <ol>
            <li class="review" id="sf_review_c_m28"> 
            	<div class="review-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="review-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
                <span class="review-years">· 32 años</span>
              </h4> 
              <p class="review-about">Sobre <a href="#">Mariano Rajoy Prey (PP)</a></p>
              <p class="review-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p class="add-subreview"> 
              	<a href="#" onclick="document.getElementById('subreviews_box17').className = 'subreviews shown';return loadReviewBox('/frontend_dev.php/es/review/form', null,  17,  0, 'sf_review_c17' )">Opinar sobre este comentario</a> 
          		  (Lleva 3 <img alt="A favor, yeah" src="/images/icoMiniUp.png" /> y 4 <img alt="En contra, buu" src="/images/icoMiniDown.png" />)
              </p>
        	  </li>
        	  <li class="review" id="sf_review_c_m28"> 
            	<div class="review-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="review-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
                <span class="review-years">· 32 años</span>
              </h4> 
              <p class="review-about">Sobre <a href="#">Mariano Rajoy Prey (PP)</a></p>
              <p class="review-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p class="add-subreview"> 
              	<a href="#" onclick="document.getElementById('subreviews_box17').className = 'subreviews shown';return loadReviewBox('/frontend_dev.php/es/review/form', null,  17,  0, 'sf_review_c17' )">Opinar sobre este comentario</a> 
          		  (Lleva 3 <img alt="A favor, yeah" src="/images/icoMiniUp.png" /> y 4 <img alt="En contra, buu" src="/images/icoMiniDown.png" />)
              </p>
        	  </li>
          </ol>
        </div><!-- end of column -->
        <div class="column last">
          <ol>
            <li class="review" id="sf_review_c_m28"> 
            	<div class="review-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="review-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
                <span class="review-years">· 32 años</span>
              </h4> 
              <p class="review-about">Sobre <a href="#">Mariano Rajoy Prey (PP)</a></p>
              <p class="review-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p class="add-subreview"> 
              	<a href="#" onclick="document.getElementById('subreviews_box17').className = 'subreviews shown';return loadReviewBox('/frontend_dev.php/es/review/form', null,  17,  0, 'sf_review_c17' )">Opinar sobre este comentario</a> 
          		  (Lleva 3 <img alt="A favor, yeah" src="/images/icoMiniUp.png" /> y 4 <img alt="En contra, buu" src="/images/icoMiniDown.png" />)
              </p>
        	  </li>
        	  <li class="review" id="sf_review_c_m28"> 
            	<div class="review-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="review-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
                <span class="review-years">· 32 años</span>
              </h4> 
              <p class="review-about">Sobre <a href="#">Mariano Rajoy Prey (PP)</a></p>
              <p class="review-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p class="add-subreview"> 
              	<a href="#" onclick="document.getElementById('subreviews_box17').className = 'subreviews shown';return loadReviewBox('/frontend_dev.php/es/review/form', null,  17,  0, 'sf_review_c17' )">Opinar sobre este comentario</a> 
          		  (Lleva 3 <img alt="A favor, yeah" src="/images/icoMiniUp.png" /> y 4 <img alt="En contra, buu" src="/images/icoMiniDown.png" />)
              </p>
        	  </li>
          </ol>
        </div><!-- end of column -->
      </div>
    </div>
  </div>
<?php endif ?>

<div class="block">
  <div class="block-inner">
    <div id="rankings">
      <div id="politicians-top5" class="list-mini">
        <h3><?php echo __('Top 5 políticos')?></h3>
        <ol>
          <?php foreach($topPoliticos as $politico): ?>
	  			  <?php include_partial('politico_top', array('id' => "sparkline_t_".$politico->getId(), 'politico' => $politico, 'showVotes' => true)) ?>
	      <?php endforeach?>
        </ol>
        <p class="ranking-link"><strong><?php echo link_to(__('Ranking general de políticos'), 'politico/ranking')?></strong></p>
      </div>

      <div id="political-groups" class="list-mini">
        <h3><?php echo __('Top 5 partidos')?></h3>
        <ol>
          <?php foreach($partidosMasVotados as $partido): ?>
	  	  	<?php include_partial('partido_top', array('partido' => $partido)) ?>
	      <?php endforeach?>
        </ol>
        <p class="ranking-link"><strong><?php echo link_to(__('Ranking de partidos'), 'partido/ranking')?></strong></p>
      </div>

      <div id="institutions" class="list-mini">
        <h3><?php echo __('Instituciones en Voota')?></h3>
        <ol>
          <?php foreach($institucionesMasVotadas as $institucion): ?>
	  	  	<?php include_partial('institucion_top', array('institucion' => $institucion)) ?>
	      <?php endforeach?>
        </ol>
        <p class="ranking-link"><strong><?php echo link_to(__('Listado de instituciones'), 'politico/ranking')?></strong></p>
      </div>
    </div>
  </div>
</div>

<?php if ($sf_user->isAuthenticated()): ?>
  <div class="block">
    <div class="block-inner">
      <div id="latest-profile-visitors">
        <h3><?php echo __('Quién ha visto tu perfil últimamente') ?></h3>
        <div class="column first">
          <ol>
            <li class="user">
            	<div class="user-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="user-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
              </h4>
            </li>
            <li class="user">
            	<div class="user-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="user-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
              </h4>
            </li>
          </ol>
        </div>
        <div class="column">
          <ol>
            <li class="user">
            	<div class="user-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="user-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
              </h4>
            </li>
            <li class="user">
            	<div class="user-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="user-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
              </h4>
            </li>
          </ol>
        </div>
        <div class="column">
          <ol>
            <li class="user">
            	<div class="user-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="user-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
              </h4>
            </li>
            <li class="user">
            	<div class="user-avatar"> 
                <img alt="Carlos Paramio" width="36" height="36" src="http://imagesvoota.s3.amazonaws.com/usuarios/cc_s_Carlos-Paramio-0017.jpg" />
              </div> 
              <h4 class="user-name"> 
                <a href="/frontend_dev.php/Carlos-Paramio">Carlos Paramio</a>
              </h4>
            </li>
          </ol>
        </div>
      </div>      
    </div>
  </div>
<?php endif ?>

<div class="block last">
  <div class="block-inner">
    <?php if (!$sf_user->isAuthenticated()): ?>
      <p class="signup"><?php echo link_to(__('¿Te gusta Voota? Registrarse en un plis'), '@sf_guard_signin')?></p>    
    <?php endif ?>

    <div class="search">
      <form method="get" action="<?php echo url_for('@search')?>">
        <p><label for="q_1"><?php echo __('¡Buusca!')?></label></p>
        <p>
          <input type="text" name="q" id="q_2" value="<?php echo $sf_params->get('q') ?>" />
          <br />
          <span class="hints"><?php echo __('Político, partido, institución o usuario') ?></span>
        </p>
        <p><input type="submit" value="<?php echo __('Buscar') ?>" class="button" /></p>
      </form>
    </div>
  </div>
</div>