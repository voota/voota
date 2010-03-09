<?php if(true): // TODO: Si se viene del ranking general o del top5 de la home, pero no del buscador o de políticos más votados de la semana ?>
  <p class="politico-pagination">
    <a href="#"><?php echo __('&laquo; Político anterior') ?></a>
    <span><?php echo __('<strong>%actual%</strong> de %total%', array('%actual%' => 4, '%total%' => 133)) ?></span>
    <a href="#"><?php echo __('Político siguiente &raquo;') ?></a>
    <a class="back" href="#"><?php echo __('Listado de políticos (%filtro%) %orden%', array('%filtro%' => 'PP, Madrid', '%orden%' => 'por votos negativos')) ?></a>
  </p>
<?php endif ?>