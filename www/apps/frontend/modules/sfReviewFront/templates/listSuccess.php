<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#filterForm_f, #filterForm_text').change(function(){
      $(this).closest('form').submit();
    });
  });
</script>

<h2 class="title"><?php echo __('Todos los vootos sobre partidos, políticos y propuestas') ?></h2>
<h3 class="title"><?php echo __('Ya hay %politicos_count% sobre políticos, %partidos_count% sobre partidos y %propuestas_count% sobre propuestas', array('%politicos_count%' => 1230, '%partidos_count%' => 2345, '%propuestas_count%' => 1223)) ?></h3>

<div id="content">
  <?php if ($reviewsPager->getPage() == 1):?>		
  	<form id="filterForm" method="get">
  	  <p>
  	    <label for="filterForm_f<?php echo $value ?>"><?php echo __("Filtrar Vootos:") ?></label>
  	    <select id="filterForm_f<?php echo $value ?>" name="f">
  	      <option value=""><?php echo __("Todos los vootos") ?></option>
  	      <option value="politicos"><?php echo __("Sólo vootos sobre políticos") ?></option>
  	      <option value="partidos"><?php echo __("Sólo vootos sobre partidos") ?></option>
  	      <option value="propuestas"><?php echo __("Sólo vootos sobre propuestas") ?></option>
  	    </select>
  	    <input id="filterForm_text" type="checkbox" /><label for="filterForm_text"><?php echo __('Sólo vootos con texto') ?></label>
  	  </p>
  	</form>
  <?php endif ?>

  <?php if(!isset($lastReviewsPager) || $lastReviewsPager->getNbResults() > 0): ?>
  	<?php if(isset($lastReviewsPager)): ?>
  		<ol class="reviews-list">
  		  <?php foreach($lastReviewsPager->getResults() as $review): ?>
  		    <?php include_partial('reviewForList', array('review' => $review, 'reviewable' =>  true, 'listValue' => str_replace  ('-', '_', $value ))) ?>
  		  <?php endforeach ?>
  		</ol>
  	<?php endif ?>
  	<?php if ($reviewsPager->getNbResults() > 0): ?>
  	  <ol class="reviews-list">
    	  <?php foreach($reviewsPager->getResults() as $review): ?>
    		  <?php include_partial('reviewForList', array('review' => $review, 'reviewable' =>  true, 'listValue' => str_replace  ('-', '_', $value ))) ?>
    		<?php endforeach ?>
  	  </ol>
  	<?php endif ?>
  <?php else: ?>
  	<p><?php echo __('Aún no hay ninguna opinión que mostrar')?></p>
  <?php endif ?>


  <div id="<?php echo "more_fr_${value}_".$reviewsPager->getPage()?>">
    <?php if ($reviewsPager->haveToPaginate() && $reviewsPager->getLastPage() > $reviewsPager->getPage()): ?>
        <?php echo jq_form_remote_tag(array(
      	'update'   => "more_fr_${value}_".$reviewsPager->getPage(),
      	'url'      => "sfReviewFront/filteredList",
        	'before'   => "re_loading( 'more_fr_". $value ."_". $reviewsPager->getPage() ."' )",
          'complete'	   => "FB.XFBML.Host.parseDomTree()"
  		),
          array('id' => "frm_fr_${value}_"
        )) ?>
        <input type="hidden" id="value" name="value" value="<?php echo $value ?>" />
        <input type="hidden" id="value" name="sfReviewType" value="<?php echo $sfReviewType ?>" />
        <input type="hidden" id="page" name="page" value="<?php echo $reviewsPager->getPage()+1 ?>" />      
        <input type="hidden" id="f" name="filter" value="<?php echo $filter ?>" />      
  	  <center><input type="submit" value="<?php echo __('más') ?>" /></center>
  	</form>
    <?php endif ?>
  </div>
</div>

<div id="sidebar">
  <div id="ultimos-usuarios">
    <h3><?php echo __('Últimos en llegar a Voota') ?></h3>
    <ol>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
      <li>
        <img src="/images/proto/usuario.jpg" alt="nombre usuario" />
        <a href="#">John Doe</a>
      </li>
    </ol>
  </div>
</div>