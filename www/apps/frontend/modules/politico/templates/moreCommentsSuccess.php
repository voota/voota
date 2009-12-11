<?php use_helper('I18N') ?>
<?php include_partial('reviews', array('pager' => $pager, 'politico' => $politico, 'review_type' => __('positiva'), 't' => $t, $t==1?'pageU':'pageD' => $t==1?$pageU:$pageD)) ?>
