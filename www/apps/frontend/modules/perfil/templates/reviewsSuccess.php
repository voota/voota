<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
     
      <h2><?php echo __('Comentarios y vootos que has hecho hasta ahora (en total, %1%)', array('%1%' => $reviews->getNbResults()))?></h2>
      <p class="next-step-msg"><?php echo link_to(__('Tus preferencias'), "@usuario_edit"); ?></p>
      <p class="next-step-msg"><?php echo link_to(__('Echa un vistazo a cómo otros usuarios ven tu perfil'), "@usuario?username=".$sf_user->getGuardUser()->getProfile()->getVanity()); ?></p>
      
      <div id="content">
        <p class="filter">
          <label for="filter"><?php echo __('Filtrar comentarios por:')?></label>
          <br />
          <select name="filter" id="filter">
            <option value="todos"><?php echo __('Todos los comentarios')?></option>
            <option value="partidos">Por partidos</option>
            <option value="partidos">Por respuestas a otros comentarios</option>
          </select>
        </p>
        
        <div class="comments">
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
                <a href="#">Hacer cambios</a>
              </td>
<?php endforeach ?>

            </tr>
          </table>
        </div>
      </div>
