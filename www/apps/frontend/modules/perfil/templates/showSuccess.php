<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>

<div id="content">
  <?php if ($sf_user->isAuthenticated()): ?>
    <div class="balloon">
      <div class="balloon-inner">
        <h3>¡Hey! David Luquin está usando Voota.</h3>
        <p><?php echo __('Tú también puedes tener tu propio perfil aquí y compartir tus opiniones sobre los políticos de España.') ?></p>
        <p>
          <?php echo __('¿Te animas? No tardas nada en registrarte:') ?>
          <input type="button" name="signup" value="Registrarte en Voota" id="signup" />
        </p>
      </div>
    </div>
  <?php endif ?>

  <div class="profile">
    <h2><?php echo "David Luquin" ?></h2>
    <div title="<?php echo 'David Luquin' ?>" class="photo">
      <img src="/images/proto/usuario.jpg" title="<?php echo 'David Luquin' ?>" alt="<?php echo 'David Luquin' ?>" />
    </div>
    <div title="info" class="description">
      <p>Nació en el seno de una familia de padre aragonés y madre catalana. Su padre, perteneciente al cuerpo de Carabineros durante la República y la Guerra Civil, pasó a ser guardia civil tras desaparecer los carabineros en 1940.</p>
    </div>
  </div>

  <div class="comments">
    <?php if (count($reviews) > 0): ?>
      <h2><?php echo "David" ?> <?php echo __("ha comentado en&hellip;") ?></h2>
        <table>
          <?php foreach ($reviews->getResults() as $review): ?>
            <tr>
              <td class="photo">    
    	          <?php if( $review->getsfGuardUser()->getProfile()->getImagen() ): ?>
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
      <h2><?php echo "Carlos" ?> <?php echo __("aún no se ha animado a comentar&hellip;") ?></h2>
    <?php endif ?>
  </div>

</div>