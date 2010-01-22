<?php use_helper('Date') ?>

<div class="box box-profile">
  <div class="box-inner">
    <h3><?php echo __('Datos básicos') ?></h3>
    <p>
      <?php echo __('En Voota desde el %1%', array('%1%' => format_date( $user->getCreatedAt() ))) ?>
      <?php /* ?>
      <br />
      <?php echo __('Socio número') ?>: 4567V
      <br />
      <?php echo __('Función en Voota') ?>: Socio
      <a href="http://blog.voota.es/es/socios/">?</a>
      <?php */ ?>
    </p>
    <h3><?php echo __('Donaciones') ?></h3>
    <p><?php echo __('Voota se mantiene gracias a <a href="http://blog.voota.es/es/socios/">las donaciones</a>') ?></p>
    <p><button><?php echo __('¿Hacer una donación?') ?></button></p>
    <script type="text/javascript" charset="utf-8">
      $(document).ready(function() {
        $('#sidebar button').click(function() {
          window.location = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10999422';
        })
      })
    </script>
  </div>
</div>