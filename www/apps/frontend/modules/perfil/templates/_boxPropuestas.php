<?php use_helper('Date') ?>

<div class="box box-propuestas">
  <div class="box-inner">
    <h3><?php echo __('Propuestas políticas') ?></h3>
    <p>
      <?php echo __('Dar de alta propuestas políticas para que el resto de la comunidad opine sobre ellas.') ?>
      <br />
      <?php echo link_to(__('¡Ya llevamos %count%!', array('%count%' => $propuestasCount)), 'propuesta/ranking') ?>
    </p>
    <p><?php echo __('¿Te animas?') ?></p>
    <p><button><?php echo __('Proponer propuesta') ?></button></p>
    <script type="text/javascript" charset="utf-8">
      $(document).ready(function() {
        $('.box-propuestas button').click(function() {
          window.location = '<?php echo url_for('propuesta/new')?>';
        })
      })
    </script>
  </div>
</div>