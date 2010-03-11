<?php use_helper('VoPager') ?>

  <p class="politico-pagination">
    <?php if($entity = prevEntity($pager, $id, $s_prev)): ?>
    	<a href="<?php echo url_for('politico/show?id='.$entity->getVanity().($s_prev==''?'':'&s='.$s_prev)) ?>"><?php echo __('&laquo; Político anterior') ?></a>
    <?php endif ?>
    <span><?php echo __('<strong>%actual%</strong> de %total%', array('%actual%' => currentIndex($pager, $id), '%total%' => numberFormat($pager->getNbResults(), 'es_ES'))) ?></span>
    
    <?php if($n_entity = nextEntity($pager, $id, $s_next)): ?>
    	<a href="<?php echo url_for('politico/show?id='.$n_entity->getVanity().'&s='.$s_next) ?>"><?php echo __('Político siguiente &raquo;') ?></a>
    <?php endif ?>
    <a class="back" href="<?php echo url_for('politico/ranking'.rankingParams()) ?>"><?php echo __('Listado de políticos %filtro% %orden%', 
    	array(
    		'%filtro%' => filteredBy()
    		, '%orden%' => orderedBy()
    	)
    	) ?></a>
  </p>
