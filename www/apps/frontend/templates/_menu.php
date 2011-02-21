<?php use_helper('Number') ?>

<ul id="main-nav">
    <li<?php echo $tab=='pol'?' class="active"':''?>>
      <a href="<?php echo url_for('politico/ranking')?>"><?php echo __('Políticos') ?></a>
      <br />
      <span class="count"><?php echo format_number(SfVoCounter::countPoliticos(), 'es_ES') ?></span>
    </li>
    <li<?php echo $tab=='par'?' class="active"':''?>>
      <a href="<?php echo url_for('partido/ranking')?>"><?php echo __('Partidos') ?></a>
      <br />
      <span class="count"><?php echo format_number(SfVoCounter::countPartidos(), 'es_ES') ?></span>
    </li>
    <li<?php echo $tab=='pro'?' class="active"':''?>>
      <a href="<?php echo url_for('propuesta/ranking')?>"><?php echo __('Propuestas') ?></a>
      <br />
      <span class="count"><?php echo format_number(SfVoCounter::countPropuestas(), 'es_ES') ?></span>
    </li>
    <li<?php echo $tab=='opi'?' class="active"':''?>>
      <a href="<?php echo url_for('sfReviewFront/list')?>"><?php echo __('Opiniones') ?></a>
      <br />
      <span class="count"><?php echo format_number(SfVoCounter::countReviews(), 'es_ES') ?></span>
    </li>
    <li<?php echo $tab=='ele'?' class="active"':''?>>
      <a href="<?php echo url_for('eleccion/list')?>"><?php echo __('Elecciones') ?></a>
      <br />
      <span class="count"><?php echo format_number(SfVoCounter::countElecciones(), 'es_ES') ?></span>
	</li>
</ul>