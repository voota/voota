<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2 class="name">
  <?php echo $partido->getNombre(); ?>
  <?php //include_partial('sparkline_box', array('partido' => $partido)) ?>
  
  <span class="rank">
    18 <?php echo __('votos positivos') ?> 
  </span>
</h2>

<div id="content">
  <div title="<?php echo $partido->getNombre() ?>" class="photo">
    <img src="/images/proto/logo_partido.png" />
    <div class="vote">
      <h3><?php echo __('Voota sobre')?> <?php echo $partido->getNombre(); ?></h3>
      <div id="sf_review1"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
    </div>
  </div>
    
  <div title="info" class="description">
    <div title="biografia" class="bio">
      <?php //echo formatBio( $partido->getBio() ) ?>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
  </div><!-- end of description -->

  <div class="reviews">
    <div class="positive-reviews">
  	  <h3>56 positivos (77%)</h3>

  	  <?php //include_partial('reviews', array('lastPager' => $lastPositives, 'pager' => $positives, 'politico' => $politico, 'reviewType' => __('positiva'), 't' => 1, 'pageU' => $pageU)) ?>
    </div>
	        
    <div class="negative-reviews">
	    <h3>16 negativos (23%)</h3>
	
  	  <?php //include_partial('reviews', array('lastPager' => $lastNegatives, 'pager' => $negatives, 'politico' => $politico, 'reviewType' => __('negativa'), 't' => -1, 'pageD' => $pageU)) ?>
    </div>
  </div>

  <div class="vote">
    <h3><?php echo __('Voota sobre %1%', array('%1%' => $partido->getNombre()))?></h3>
    <div id="sf_review2"><?php echo image_tag('spinner.gif', 'alt="' . __('cargando') . '"') ?></div>
  </div>

</div><!-- end of content -->

<div id="sidebar">
  <?php if(count($activeEnlaces) > 0): ?>
    <div class="links">
      <h3><?php echo __('Enlaces externos')?></h3>
      <ul>
        <?php foreach($activeEnlaces as $enlace): ?>
		      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
        <?php endforeach ?>
      </ul>
    </div>
	<?php endif ?>

  <div id="google-ads">
    <?php // if (!$sf_user->isAuthenticated()) include_partial('google_ads') ?>
  </div><!-- end of google-ads -->

</div><!-- end of sidebar -->