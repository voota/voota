<?php use_helper('I18N') ?>
<?php use_helper('SfReview') ?>
     
<h2><?php echo __('Comentarios y vootos que has hecho hasta ahora (en total, %1%)', array('%1%' => $reviews->getNbResults()))?></h2>
<p class="next-step-msg"><?php echo link_to(__('Tus preferencias'), "@usuario_edit"); ?></p>
<p class="next-step-msg"><?php echo link_to(__('Echa un vistazo a cómo otros usuarios ven tu perfil'), "@usuario?username=".$sf_user->getGuardUser()->getProfile()->getVanity()); ?></p>

<div id="content">
<?php /* ?>
  <p class="filter">
    <label for="filter"><?php echo __('Filtrar comentarios por:')?></label>
    <br />
    <select name="filter" id="filter">
      <option value="todos"><?php echo __('Todos los comentarios')?></option>
      <option value="partidos">Por partidos</option>
      <option value="partidos">Por respuestas a otros comentarios</option>
    </select>
  </p>
<?php */ ?>
  
  <div class="comments">
    <table>        
      <?php foreach ($reviews->getResults() as $review): ?>
      	<?php include_component_slot('profileReview', array('review' => $review)) ?>
      <?php endforeach ?>
    </table>

    <p>
      <?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
        <button type="button" id="more_reviews"><?php echo __('más') ?></button>
        <img class="spinner" style="display: none" src='/images/spinner.gif' alt='cargando' />
        <script type="text/javascript" charset="utf-8">      
          var next_page = 1;
          $('#more_reviews').click(function(){
            $.ajax({
              url: '/frontend_dev.php/es/user/more',
              data: { page : next_page, username : '<?php echo $user->getProfile()->getVanity() ?>' },
              success: function(data) { next_page += 1; $('.comments table').append(data); },
              beforeSend: function() { $('.spinner').show(); },
              complete: function() { $('.spinner').hide(); }
            });
          });
        </script>
      <?php endif ?>
    </p>
  </div>
</div>
