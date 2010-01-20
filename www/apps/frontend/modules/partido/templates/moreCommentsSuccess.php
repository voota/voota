<?php use_helper('I18N') ?>
<?php include_partial('reviews', array('pager' => $pager, 'partido' => $partido, 'review_type' => __('positiva'), 't' => $t, $t==1?'pageU':'pageD' => $t==1?$pageU:$pageD)) ?>
