<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>


<div class="profile">
  <h2>
    Mandar un mensaje a <a href="#"><?php echo $user ?></a>
    <?php if($user->getProfile() && $user->getProfile()->getImagen() && $user->getProfile()->getImagen() != '' ): ?>
      <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($user->getProfile()->getImagen()), 'alt="Foto '. $user->getProfile()->getNombre().' ' . $user->getProfile()->getApellidos() .'"') ?>
    <?php endif ?>
  </h2>
  <form action="#" method="post" accept-charset="utf-8">
    <p><label for="body">¿Qué le decimos?</label></p>
    <p><textarea id="body"></textarea></p>
    <p class="submit"><input type="submit" value="Enviar" /></p>
  </form>
</div>