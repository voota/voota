<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('Form') ?>
<?php use_helper('SfReview') ?>

<div id="content">
  <?php if (!$sf_user->isAuthenticated()): ?>
    <div class="balloon">
      <div class="balloon-inner">
        <h3><?php echo __('¡Hey! %1% está usando Voota.', array('%1%' => $user)) ?></h3>
        <p><?php echo __('Tú también puedes tener tu propio perfil aquí y compartir tus opiniones sobre los políticos de España.') ?></p>
        <p>
          <?php echo __('¿Te animas? No tardas nada en registrarte:') ?>
          <?php echo form_tag('@sf_guard_signin', 'method=get') ?>
    	      <?php echo submit_tag(__('Registrarte en Voota')) ?>
          </form>
        </p>
        <p></p>
      </div>
    </div>
  <?php endif ?>

  <div class="profile">
    <h2><?php echo $user ?></h2>
    <div title="<?php echo $user ?>" class="photo">
      <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_'.( $user->getProfile()->getImagen()), array('alt' => $user->getProfile()->getNombre().' ' .  $user->getProfile()->getApellidos())) ?>
    </div>
    <div title="info" class="description">
      <p><?php echo getAutolink($user->getProfile()->getPresentacion())?></p>
    </div>
  </div>

  <div class="comments">
    <?php if ($reviews->getNbResults() > 0): ?>
      <h2><?php echo __("%1% ha comentado en&hellip;", array('%1%' => $user->getProfile()->getNombre())) ?></h2>
        <table>
          <?php foreach ($reviews->getResults() as $review): ?>
            <tr>
              <td class="photo">    
    	          <?php if( $review->getSfReviewType() && $review->getSfReviewType()->getId() == 1 ): ?>
    	            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $review->getsfGuardUser()->getProfile()->getImagen()), array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
    	          <?php else: ?>
    	            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
    	          <?php endif ?>
              </td>
              <td class="name">
                <?php echo $review->getSfGuardUser()?> (Usuario), <?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?>
              </td>
              <td class="vote">
              	<?php if($review->getValue() == 1): ?>
              		<?php echo image_tag('icoUp.gif', 'yeah') ?>
              	<?php else: ?>
              		<?php echo image_tag('icoDown.gif', 'buu') ?>
              	<?php endif ?>
              </td>
              <td class="body">
                <?php echo review_text( $review ) ?>
              </td>
              <td class="actions">
                <a href="#">Ir a su comentario</a>
              </td>
            </tr>
          <?php endforeach ?>
        </table>
    <?php else: ?>
      <h2><?php echo __("%1% aún no se ha animado a comentar&hellip;", array('%1%' => $user->getProfile()->getNombre())) ?></h2>
    <?php endif ?>
  </div>

</div>