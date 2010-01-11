<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('Form') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>

<div id="content">
  <?php if (!$sf_user->isAuthenticated()): ?>
    <div class="balloon">
      <div class="balloon-inner">
        <h3><?php echo __('¡Hey! %1% está usando Voota.', array('%1%' => $user)) ?></h3>
        <p><?php echo __('Tú también puedes tener tu propio perfil aquí y compartir tus opiniones sobre los políticos de España.') ?></p>
        <?php echo form_tag('@sf_guard_signin', 'method=get') ?>
          <p>
            <?php echo __('¿Te animas? No tardas nada en registrarte:') ?>
    	      <?php echo submit_tag(__('Registrarte en Voota')) ?>
          </p>
        </form>
      </div>
    </div>
  <?php endif ?>

  <div class="profile">
    <h2>
      <?php echo $user ?>
      <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() == $user->getId()): ?>
        <?php echo link_to(__('Hacer cambios en tu perfil'), "@usuario_edit"); ?>
      <?php endif ?>
    </h2>
    <div title="<?php echo $user ?>" class="photo">
    	<?php if($user->getProfile()->getImagen() != ''):?>
      		<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_'.( $user->getProfile()->getImagen()), array('alt' => $user->getProfile()->getNombre().' ' .  $user->getProfile()->getApellidos())) ?>
      	<?php endif ?>
    </div>
    <div title="info" class="description">
      <p><?php echo getAutolink($user->getProfile()->getPresentacion())?></p>

      <?php if (count($user->getEnlaces()) > 0): ?>
        <div class="links">
          <p><?php echo __('Más sobre %1%:', array('%1%' => $user))?></p>
          <ul>
            <?php foreach ($user->getEnlaces() as $enlace): ?>
            	<?php if ($enlace->getUrl() != ''): ?>
	              <li><?php echo link_to(toShownUrl( $enlace->getUrl() ), toUrl( $enlace->getUrl() ))?></li>
            	<?php endif ?>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>
    </div>
  </div>

  <div class="comments">
    <?php if ($reviews->getNbResults() > 0): ?>
      <h2><?php echo __("%1% ha comentado sobre &hellip; (%2% votos)", array('%1%' => $user->getProfile()->getNombre(), '%2%' => $reviews->getNbResults())) ?></h2>
        <table>
          <?php foreach ($reviews->getResults() as $review): ?>
			<?php include_component_slot('profileReview', array('review' => $review)) ?>
          <?php endforeach ?>
        </table>
        <div id="more_reviews">
		  <?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
		      <?php echo jq_form_remote_tag(array(
		    	'update'   => "more_reviews",
		    	'url'      => "@profile_more_comments",
  	  			'before' => "re_loading('more_reviews')"
		      ),
		        array('id' => "frm_more_reviews"
		      )) ?>
			  <?php echo input_hidden_tag('username', $user->getProfile()->getVanity())?>
			  <?php echo input_hidden_tag('page', isset($page)?$page:'1')?>
			  <?php echo submit_tag(__('más')) ?>
			</form>
		  <?php endif ?>
        </div>
    <?php else: ?>
      <h2><?php echo __("%1% aún no se ha animado a comentar&hellip;", array('%1%' => $user->getProfile()->getNombre())) ?></h2>
    <?php endif ?>
  </div>

</div>