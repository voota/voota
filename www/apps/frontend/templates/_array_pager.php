<?php use_helper('VoFormat') ?>


<?php $last = intval($total / 15) ?>
<?php if ($last > 1): ?>
  <?php if ($page > 1): ?>
	 <?php echo link_to(
	 				__('&laquo;Anterior'), 
	 				$url .
	 					($page == 2?'':(!preg_match("/\?/",$url)?'?':'&'). "page=".($page-1)) 
	 					. ((isset($order) && $order != 'pd')?(!preg_match("/\?/",$url) && ($page-1) == 1?'?':'&')."o=$order":'')
	 				, array('class'  => 'numerosPag')
	 ) ?>
  <?php endif ?>
  
  <?php if ($page > 3): ?>
    <?php echo link_to(1, $url . ((isset($order) && $order != 'pd')?(!preg_match("/\?/",$url)?'?':'&')."o=$order":''), array('class'  => 'numerosPag')) ?>
  <?php if ($page > 4): ?>
    ...
  <?php endif ?>
  <?php endif ?>
  <?php $links = getLinks($last, $page); foreach ($links as $aPage): ?>
    <?php echo ($aPage == $page) ? $page : link_to(
    	$aPage
    	, $url .
    		($aPage == 1?'':(!preg_match("/\?/",$url)?'?':'&'). "page=".$aPage) . 
    		((isset($order) && $order != 'pd')?(!preg_match("/\?/",$url) && $aPage == 1?'?':'&')."o=$order":'')
    	, array('class'  => 'numerosPag')
    ) ?>
    <?php if ($aPage != $links[count($links)-1]): ?> <?php endif ?>
  <?php endforeach ?>
    <?php if ($last != $links[count($links)-1]): ?>
    <?php if ($last != $links[count($links)-1]+1): ?>
    ...
    <?php endif ?>
    	<?php echo link_to($last, $url . (!preg_match("/\?/",$url)?'?':'&'). "page=$last" . ((isset($order) && $order != 'pd')?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    <?php endif ?>
    <?php if($last > $page):?>
  		<?php echo link_to(__('Siguiente&raquo;'), $url . (!preg_match("/\?/",$url)?'?':'&'). "page=". ($page+1) . ((isset($order) && $order != 'pd')?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    <?php endif ?>
<?php endif ?>