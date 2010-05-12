<?php use_helper('I18N') ?>

<h2><?php echo __('Lista oficial del partido')?> <span class="versus">vs</span> <?php echo __('Lo que dice la calle') ?></h2>
<p><?php echo __('Lista electoral %nombre%', array('%nombre%' => 'CiU elecciones Parlament de Catalunya 2010')) // TODO: Sustituir nombre ?></p>

<div class="selector-convocatoria">
  <ul>
    <?php // TODO: Eliminar datos de ejemplo e integrar; ver eleccion/showSuccess a modo de ejemplo ?>
  	<li>Parlament</li>
  	<li><a href="#">Barcelona</a></li>
  	<li><a href="#">Tarragona</a></li>
  	<li><a href="#">Lleida</a></li>
  	<li><a href="#">Girona</a></li>
  </ul>
</div>

<table>
  <thead>
    <tr>
      <th class="name"><?php echo __('Lista oficial del partido (%nombre%)', array('%nombre%' => 'CiU')) // TODO: Sustituir nombre ?></th>
      <th class="name"><?php echo __('Lo que dice la calle') ?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
        <?php // TODO: Cambiar enlaces y añadir flechita; ver cualquier rankingSuccess.php ?>
        <a href="#" title="<?php echo __('Ordenar por votos positivos: Los más votados primero / los menos votados primero') ?>"><?php echo __('Votos +') ?></a>
        <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
        <?php // if (strpos($order, 'p') === 0): ?>
      		<?php // echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php // endif ?>
      </th>
      <th class="negative-votes">
        <?php // TODO: Cambiar enlaces y añadir flechita; ver cualquier rankingSuccess.php ?>
        <a href="#" title="<?php echo __('Ordenar por votos negativos: Los más votados primero / los menos votados primero') ?>"><?php echo __('Votos -') ?></a>
        <?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
        <?php // if (strpos($order, 'n') === 0): ?>
      		<?php // echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php // endif ?>
      </th>
    </tr>
  </thead>
  
  <tbody>
    <tr>
      <td class="name"></td>
      <td class="name"></td>
      <td class="voto"></td>
      <td class="positive-votes"></td>
      <td class="negative-votes"></td>
    </tr>
  </tbody>
</table>