<?php use_helper('VoPager') ?>

<?php $n_entity = nextEntity($pager, $id, $s_next);
if(($p_entity = prevEntity($pager, $id, $s_prev)) || $n_entity): ?>
  <p class="politico-pagination politico-pagination-<?php echo $position ?>">
    <?php if($p_entity): ?>
    	<a href="<?php echo url_for($p_entity->getModule().'/show?id='.$p_entity->getVanity().($s_prev==''?'':'&s='.$s_prev)) ?>"><?php 
    	echo $p_entity->getType() != Politico::NUM_ENTITY?$p_entity->getType() != Partido::NUM_ENTITY?__('&laquo; Propuesta anterior'):__('&laquo; Partido anterior'):__('&laquo; Político anterior') ?></a>
    <?php endif ?>
    <span><?php echo __('<strong>%actual%</strong> de %total%', array('%actual%' => currentIndex($pager, $id), '%total%' => numberFormat($pager->getNbResults(), 'es_ES'))) ?></span>
    
    <?php if($n_entity): ?>
    	<a href="<?php echo url_for($n_entity->getModule().'/show?id='.$n_entity->getVanity().($s_next==''?'':'&s='.$s_next)) ?>"><?php 
    	echo $n_entity->getType() != Politico::NUM_ENTITY?$n_entity->getType() != Partido::NUM_ENTITY?__('Propuesta siguiente &raquo;'):__('Partido siguiente &raquo;'):__('Político siguiente &raquo;') ?></a>
    <?php endif ?>
    <?php $anEntity = $p_entity?$p_entity:$n_entity ?>
    <a class="back" href="<?php echo url_for(($p_entity?$p_entity->getModule():$n_entity->getModule()).'/ranking'.rankingParams($anEntity->getType())) ?>"><?php 
    echo $anEntity->getType() != Politico::NUM_ENTITY?$anEntity->getType() != Partido::NUM_ENTITY?__('Listado de propuestas %filtro% %orden%',array('%filtro%' => filteredBy($anEntity->getType()), '%orden%' => orderedBy($anEntity->getType()))):__('Listado de partidos %filtro% %orden%',array('%filtro%' => filteredBy($anEntity->getType()), '%orden%' => orderedBy($anEntity->getType()))):__('Listado de políticos %filtro% %orden%',array('%filtro%' => filteredBy($anEntity->getType()), '%orden%' => orderedBy($anEntity->getType()))) 
    	 
    	?></a>
  </p>
<?php endif ?>