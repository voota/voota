<?php use_helper('I18N') ?>

<h2>
  <img src="/images/lista-oficial.png" alt="<?php echo __('Lista oficial del partido')?>" />
  <?php echo __('Lista oficial del partido')?>
  <span class="versus">vs</span>
  <img src="/images/lista-calle.png" alt="<?php echo __('Lo que dice la calle')?>" />
  <?php echo __('Lo que dice la calle') ?>
</h2>

<p class="summary"><?php echo __('Lista electoral %nombre%', array('%nombre%' => 'CiU elecciones Parlament de Catalunya 2010')) // TODO: Sustituir nombre ?></p>

<div class="selector-convocatoria">
  <ul>
    <?php // TODO: Eliminar datos de ejemplo e integrar; ver eleccion/showSuccess a modo de ejemplo ?>
  	<li><span>Parlament</span></li>
  	<li><a href="#">Barcelona</a></li>
  	<li><a href="#">Tarragona</a></li>
  	<li><a href="#">Lleida</a></li>
  	<li><a href="#">Girona</a></li>
  </ul>
</div>

<table>
  <thead>
    <tr>
      <th class="politico" colspan="3"><?php echo __('Lista oficial del partido (%nombre%)', array('%nombre%' => 'CiU')) // TODO: Sustituir nombre ?></th>
      <th class="politico" colspan="3"><?php echo __('Lo que dice la calle') ?></th>
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
    <?php // TODO: Sustituir por foreach político en lista ?>
    <?php for ($i = 1; $i <= 20; $i++): ?>
      <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' // TODO: Cambiar índice por el que corresponda ?>">
        <td class="position"><?php echo $i // TODO: Sustituir contador por apropiado para foreach ?>.</td>
        <td class="photo"><a href="#"><img src="/images/proto/politico.png" /><?php // TODO: Sustituir por imagen de político en b/n ?></a></td>
        <td class="name"><a href="#">Esperanza Aguirre Gil de Biedma<?php // TODO: Sustituir por nombre político ?></a></td>
        <td class="position"><?php echo $i // TODO: Sustituir contador por apropiado para foreach ?>.</td>
        <td class="photo"><a href="#"><img src="/images/proto/politico.png" /><?php // TODO: Sustituir por imagen de político en color ?></a></td>
        <td class="name"><a href="#">José Luis Rodríguez Zapatero<?php // TODO: Sustituir por nombre político ?></a></td>
        <td class="voto">
          <?php // TODO: Descomentar ?>
          <?php // include_component_slot('quickvote', array('entity' => $politico)) ?>
        </td>
        <td class="positive-votes">89</td>
        <td class="negative-votes">33</td>
      </tr>
    <?php endfor; ?>
  </tbody>
</table>