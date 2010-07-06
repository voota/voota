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
    
    <div id="rss">
      <?php // TODO: Poner URL del feed RSS del usuario ?>
      <a href="#"><?php echo __('RSS de %name%', array('%name%' => $user)) ?></a>
    </div>
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
    <div title="<?php echo secureString(fullNameForAttr($user)) ?>" class="photo">
      <?php echo getAvatarFull($user); ?>
    </div>
    <div title="info" class="description">
      <p><?php echo getAutolink($user->getProfile()->getPresentacion())?></p>
      <?php if ($politico = isPolitico($user)): ?>
        <p><?php echo link_to(__('Su página de político en Voota'), "politico/show?id=".$politico->getVanity()) ?></p>
      <?php endif ?>

      <?php if (count($enlaces) > 0): ?>
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
        <img src="/images/email.png" width="16" height="16" alt="email" />
        <?php echo link_to(__('Mandar un mensaje a').' '.fullName($user), '@usuario_contact?username='.$user->getProfile()->getVanity()); ?>
      </p>
	  <?php endif ?>
    </div>
  </div>

  <div class="propuestas">
    <?php if(count($propuestas) > 0): ?> 
  	  <h2><?php echo __('Las propuestas de %nombre% (%1%)', array('%nombre%' => $user, '%1%' => count($propuestas))) ?></h2>
	    <ol>
	    	<?php foreach ($propuestas as $propuesta):?>
		      <?php include_partial('propuesta', array('propuesta' => $propuesta)) // TODO: Incluir una vez por propuesta, pasándole la propuesta ?>
	    	<?php endforeach ?>
	    </ol>
    <?php endif ?>
  </div>
  
	<div class="comments reviews">
    <h2 id="profile_comments_header"><?php echo __('Los comentarios de %nombre% (%1%)', array('%nombre%' => $user, '%1%' => $reviewsPager->getNbResults()))?></h2>
   	<?php include_component_slot('review_list_by_user', array( 'page' => 1, 'sfReviewType' => $sfReviewType, 'filter' => $text, 'user' => $user, 'userId' => $user->getId() )) ?>
	</div>
</div>