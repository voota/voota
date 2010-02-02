<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('VoUser'); ?>
<?php use_helper('Date') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#f').change(function(){
		  $('#filterForm').submit();
	  });
  });
  //-->
</script>

<div id="content">
  
  <div id="sidebar">
    <?php include_partial('boxProfile', array('user' => $user)) ?>
  </div>
  
  <?php if (!$sf_user->isAuthenticated()): ?>
    <div class="balloon">
      <div class="balloon-inner">
        <h3><?php echo __('¡Hey! %1% está usando Voota.', array('%1%' => fullName($user))) ?></h3>
        <p><?php echo __('Tú también puedes tener tu propio perfil aquí y compartir tus opiniones sobre los políticos de España.') ?></p>
        <form action="<?php echo url_for("@sf_guard_signin") ?>" method="get">
          <p>
            <?php echo __('¿Te animas? No tardas nada en registrarte:') ?>
          		<input type="submit" value="<?php echo __('Registrarte en Voota') ?>" />
          </p>
        </form>
      </div>
    </div>
  <?php endif ?>

  <div class="profile">
    <h2>
      <?php echo fullName($user) ?>
      <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() == $user->getId()): ?>
        <?php echo link_to(__('Hacer cambios en tu perfil'), "@usuario_edit"); ?>
      <?php endif ?>
    </h2>
    <div title="<?php echo fullNameForAttr($user) ?>" class="photo">
      <?php echo getAvatarFull($user); ?>
    </div>
    <div title="info" class="description">
      <p><?php echo getAutolink($user->getProfile()->getPresentacion())?></p>

      <?php if (count($user->getEnlaces()) > 0): ?>
        <div class="links">
          <p><?php echo __('Más sobre %1%:', array('%1%' => $user))?></p>
          <ul>
            <?php foreach ($user->getEnlaces() as $enlace): ?>
            	<?php if ($enlace->getUrl() != ''): ?>
	              <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl() ))?></li>
            	<?php endif ?>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>

      <p class="contact">
        <?php echo link_to(__('Mandar un mensaje a').' '.fullName($user), '@usuario_contact?username='.$user->getProfile()->getVanity()); ?>
        <img src="/images/email.png" alt="contactar" />
      </p>
    </div>
  </div>
  
  <div class="comments">
    <form action="<?php echo url_for('@usuario?username='.$user->getProfile()->getVanity()) ?>" id="filterForm">
    <p class="filter">
      <label for="f"><?php echo __('Filtrar comentarios por:')?></label>
      <br />
      	<select id="f" name="f">
      		<option value="all" <?php echo $f!="all"?'':'selected="selected"'?>><?php echo __('Todos los comentarios') ?></option>
      		<option value="<?php echo Politico::NUM_ENTITY ?>" <?php echo $f!=Politico::NUM_ENTITY?'':'selected="selected"'?>><?php echo __('Por políticos') ?></option>
      		<option value="<?php echo Partido::NUM_ENTITY ?>" <?php echo $f!=Partido::NUM_ENTITY?'':'selected="selected"'?>><?php echo __('Por partidos') ?></option>
      		<option value=".0" <?php echo $f!=".0"?'':'selected="selected"'?>><?php echo __('Por respuestas a otros comentarios') ?></option>
      	</select>
    </p>
    </form>

    <?php if ($reviews->getNbResults() > 0): ?>
      <h2><?php echo __("%1% ha comentado sobre &hellip; (%2% votos)", array('%1%' => fullName($user), '%2%' => $reviews->getNbResults())) ?></h2>
        <table>
          <?php foreach ($reviews->getResults() as $review): ?>
			      <?php include_component_slot('profileReview', array('review' => $review)) ?>
          <?php endforeach ?>
        </table>
        <div id="more_reviews">
    		  <?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
  		      <?php echo jq_form_remote_tag(
  		        array('update'   => "more_reviews",
  		    	        'url'      => "@profile_more_comments",
    	  			      'before'   => "re_loading('more_reviews')"),
  		        array('id' => "frm_more_reviews"))
  		      ?>
        		  <div><input type="hidden" name="username" value="<?php echo $user->getProfile()->getVanity()?>" /></div>
            	<div><input type="hidden" name="page" value="<?php echo isset($page)?$page:'1' ?>" /></div>
            	<div><input type="submit" value="<?php echo __('más') ?>" /></div>
    			  </form>
    		  <?php endif ?>
        </div>
    <?php else: ?>
      <h2><?php echo __("%1% aún no se ha animado a comentar&hellip;", array('%1%' => fullName($user))) ?></h2>
    <?php endif ?>
  </div>
</div>