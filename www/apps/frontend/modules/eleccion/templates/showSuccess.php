<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('img.politico').each(function(){
      $(this).qtip({
        content: $(this),
        position: {
          corner: {
            tooltip: 'bottomMiddle',
            target: 'topMiddle'
          }
        },
        hide: { fixed: true, delay: 100, effect: { type: 'fade' } },
        style: {
          border: {
            width: 1
          },
          padding: 10,
          tip: true
        }
      })
    });
  });
</script>

<h2 id="name"><?php echo $eleccion->getNombre(); ?></h2>

<div id="content">
  <div title="<?php echo $eleccion->getNombre() ?>" id="photo">
	  <img src="/images/proto/eleccion.png" alt="<?php echo __('Imagen de %nombre%', array('%nombre%' => $eleccion->getNombre())) ?>" />
  </div>
    
  <div title="info" id="description">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
  </div><!-- end of description -->

  <div id="selector_convocatoria">
    <ul>
      <li>Parlament</li>
      <li><a href="#">Barcelona</a></li>
      <li><a href="#">Tarragona</a></li>
      <li><a href="#">Lleida</a></li>
      <li><a href="#">Girona</a></li>
    </ul>
  </div>

  <table id="resultados">
    <thead>
      <tr>
        <td class="partido"><?php echo __('Lista') ?></td>
        <td colspan="2"><?php echo __('Escaños según los votos positivos en Voota') ?></td>
      </tr>
    </thead>
    <tbody>
      <?php for ($i = 1; $i <= 10; $i++): // TODO: Iterar por partidos ?>
        <tr>
          <td class="partido"><a href="#">PdI</a></td>
          <td class="escanos">35</td>
          <td class="politicos">
            <?php for ($j = 1; $j <= rand(3, 20); $j++): // TODO: Iterar por políticos ?>
              <img class="politico" id="politico_<?php echo "{$i}_{$j}" // TODO: Usar id de político ?>" src="/images/proto/politico.png" alt="<?php echo 'Nombre del político' // TODO: Sustituir por nombre del político ?>" />
            <?php endfor ?>
          </td>
        </tr>
      <?php endfor ?>
    </tbody>
    <tfoot>
      <tr>
        <td class="partido"><?php echo __('Mayoría') ?></td>
        <td class="escanos"><?php echo 72 // TODO: Total escaños ?></td>
      </tr>
    </tfoot>
  </table>

</div><!-- end of content -->

<?php // TODO: Sustituir enlaces ?>
<?php //if(count($activeEnlaces) > 0): ?>
  <div id="external-links">  
    <h3><?php echo __('Enlaces externos')?></h3>
    <ul>
      <?php for ($i = 1; $i <= 5; $i++): // TODO: Iterar por enlaces ?>
	      <li><a href="#">seisdeagosto.com/indica</a></li>
      <?php endfor ?>
    </ul>
  </div>
<?php //endif ?>