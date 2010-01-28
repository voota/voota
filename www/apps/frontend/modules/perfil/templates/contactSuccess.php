<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript" charset="utf-8">
  <!--//
  $(document).ready(function() {
    //controls character input/counter
    $('#mensaje_cuerpo').keyup(function() {
  	  setCounter('#cuerpo_counter', this, 280);
    });
    setCounter('#cuerpo_counter', '#mensaje_cuerpo', 280);
  });
  //-->
</script>

<h2>
  <?php echo __('Mandar un mensaje a'); ?> <?php echo link_to($user, "@usuario?username=".$user->getProfile()->getVanity()); ?>
  <?php if($user->getProfile() && $user->getProfile()->getImagen() && $user->getProfile()->getImagen() != '' ): ?>
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($user->getProfile()->getImagen()), 'alt="'. $user->getProfile()->getNombre().' ' . $user->getProfile()->getApellidos() .'"') ?>
  <?php endif ?>
</h2>

<div id="content">
  <form action="#" method="post" accept-charset="utf-8">
    <p class="label"><label for="mensaje_cuerpo">¿Qué le decimos?</label></p>
    <p class="textarea">
      	<?php echo $form['mensaje']->renderError() ?>
      	<?php echo $form['mensaje']->render( array('rows' => 8, 'cols' => 40) ) ?>
    </p>
    <p class="counter" id="cuerpo_counter"></p>
    <p class="submit"><input type="submit" value="Enviar" /></p>
  </form>
</div>