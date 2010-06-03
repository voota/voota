<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoUser') ?>

<script type="text/javascript">
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
  <?php echo __('Mandar un mensaje a'); ?> <?php echo link_to(fullName($user), "@usuario?username=".$user->getProfile()->getVanity()); ?>
  <?php echo getAvatar($user); ?>
</h2>

<div id="content">
  <form action="#" method="post">
    <p class="label"><label for="mensaje_cuerpo">¿Qué le decimos?</label></p>
    <p class="textarea">
      	<?php echo $form['mensaje']->renderError() ?>
      	<?php echo $form['mensaje']->render( array('rows' => 8, 'cols' => 40) ) ?>
    </p>
    <p class="counter" id="cuerpo_counter"></p>
    <p class="submit"><input type="submit" value="Enviar" /></p>
  </form>
</div>