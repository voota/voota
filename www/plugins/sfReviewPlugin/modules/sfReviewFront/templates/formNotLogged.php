<?php use_helper('I18N') ?>

<div class="note">
  <h3><?php echo __('Ejem. Para votar necesitas tener una cuenta en Voota.')?></h3>

  <p>
    <?php echo __('Si no tienes cuenta aun, este es el mejor momento. Luego volveremos por aquí.')?>
    <?php echo __('¿Vamos a ello?')?>
  </p>
  
  <form action="<?php echo url_for('sfReviewFront/form');?>" id="<?php echo "sf-review-form-$reviewBox" ?>" method="post">
    <fieldset>
  	  <input type="hidden" id="t" name="t" value="<?php echo $reviewType ?>" />
  	  <input type="hidden" id="e" name="e" value="<?php echo $reviewEntityId ?>" />
  	  <input type="hidden" id="b" name="b" value="<?php echo $reviewBox ?>" />
  	  <input type="hidden" id="v" name="v" value="<?php echo $reviewValue ?>" />
      <input type="hidden" id="nl" name="nl" value="1" />
  	  <div class="submit"><input type="submit" value="<?php echo __('Hacer login o crear una cuenta')?>" class="login_or_register" /></div>
  	</fieldset>
  </form>
</div>