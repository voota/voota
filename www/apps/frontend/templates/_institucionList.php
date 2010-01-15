<?php function map_to_name_and_vanity($i) { return array($i->getNombreCorto(), $i->getVanity()); } ?>
<?php $instituciones = array_map("map_to_name_and_vanity", $instituciones); ?>
<?php array_unshift($instituciones, array(__('Todas las instituciones'), '0')); ?>
<?php $instituciones_en_grupos = array_chunk($instituciones, 6); ?>
<div id="institutions-list">
  <ol>
    <li class="column first">
      [<?php echo ($partido == 'all' ? __('Todos los partidos') : $partido); ?>] en:
    </li>
    <?php foreach($instituciones_en_grupos as $grupo): ?>
    <li class="column">
      <ol>
        <?php foreach($grupo as $i): ?>
        <li>
          <?php $active = ($i[1] == $institucion ? array('class' => 'active') : null) ?>
          <?php $url = ($i[1] == '0' ? "politico/ranking?partido=$partido" : "politico/ranking?partido=$partido&institucion=$i[1]"); ?>
          <?php echo link_to($i[0], $url, $active) ?>
        </li>
        <?php endforeach ?>
      </ol>
    </li>
    <?php endforeach ?>
  </ol>
</div>