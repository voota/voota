<?php use_helper('I18N') ?>

<h2>Contacta con Voota</h2>
<p class="success-msg">Gracias por tu mensaje</p>

<div id="content">
  <p class="next-step-msg"><?php echo __('¿Que hacemos ahora?') ?> <?php echo __('Tú dirás.') ?></p>
  <p class="next-step-msg"><?php echo __('¿Nos vamos a la')?> <?php echo link_to("home de Voota", "@homepage") ?>?</p>
  <p class="next-step-msg"><?php echo __('¿Una vuelta por el')?> <?php echo link_to(__("ranking de políticos"), "politico/ranking") ?> <?php echo __('quizás?') ?></p>
</div>

<div id="sidebar">
  <div class="box box-contact">
    <div class="box-inner">
      <ul>
        <li class="blog"><a href="<?php echo __('http://blog.voota.es/') ?>"><?php echo __('Nuestro blog') ?></a></li>
        <li class="twitter"><a href="<?php echo __('http://twitter.com/Voota') ?>"><?php echo __('Voota en Twitter') ?></a></li>
        <li class="facebook"><a href="<?php echo __('http://www.facebook.com/Voota') ?>"><?php echo __('Voota en Facebook') ?></a></li>
      </ul>
    </div>
  </div>
</div>
