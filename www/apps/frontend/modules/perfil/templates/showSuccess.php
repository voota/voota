<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('VoSmartJS') ?>
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
      <?php if ($politico = isPolitico($user)): ?>
        <p><?php echo link_to(__('Su página de político en Voota'), "politico/show?id=".$politico->getVanity()) // TODO: Enlazar con página de político ?></p>
      <?php endif ?>

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

	  <?php if ($user->getProfile()->getMailsContacto() && SfVoUtil::isEmail( $user->getUsername() )):?>
      <p class="contact">
        <?php echo link_to(__('Mandar un mensaje a').' '.fullName($user), '@usuario_contact?username='.$user->getProfile()->getVanity()); ?>
      </p>
	  <?php endif ?>
    </div>
  </div>

  <h2><?php echo __('Las propuestas de %nombre% (%1%)', array('%nombre%' => $user, '%1%' => 2)) // TODO: Contar propuestas ?></h2>
  <div class="propuestas">
    <ol>
      <?php include_partial('propuesta') // TODO: Incluir una vez por propuesta, pasándole la propuesta ?>
      <?php include_partial('propuesta') // TODO: Incluir una vez por propuesta, pasándole la propuesta ?>
    </ol>
  </div>
    
  <h2><?php echo __('Los comentarios de %nombre% (%1%)', array('%nombre%' => $user, '%1%' => $reviews->getNbResults()))?></h2>
	<div class="comments reviews">
   	<?php include_component_slot('review_list_by_user', array( 'page' => 1, 'sfReviewType' => $sfReviewType, 'filter' => $text, 'user' => $user, 'userId' => $user->getId() )) ?>
	</div>
<?php /* ?>
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
      <h2><?php echo format_number_choice("[0]0|[1]%1% ha comentado sobre &hellip; (%2% voto)|(1,+Inf]%1% ha comentado sobre &hellip; (%2% votos)", array('%1%' => fullName($user), '%2%' => $reviews->getNbResults()), $reviews->getNbResults()) ?></h2>
      
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

<?php */ ?>
</div>