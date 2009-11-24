<?php if ($pager->haveToPaginate()): ?>
  <?php # echo link_to('&laquo;', 'politico/ranking?page='.$pager->getFirstPage()) ?>
 <?php echo link_to(__('&laquo;Anterior'), $url ."$page_var=".$pager->getPreviousPage() . (isset($order)?"&o=$order":''), array('class'  => 'numerosPag')) ?>
  
  <?php if ($pager->getPage() > 3): ?>
    <?php echo link_to($pager->getFirstPage(), $url ."$page_var=".$pager->getFirstPage() . (isset($order)?"&o=$order":''), array('class'  => 'numerosPag')) ?>
  <?php if ($pager->getPage() > 4): ?>
    ...
  <?php endif ?>
  <?php endif ?>
  <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
    <?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url . "$page_var=".$page . (isset($order)?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    <?php if ($page != $pager->getCurrentMaxLink()): ?> <?php endif ?>
  <?php endforeach ?>
    <?php if ($pager->getLastPage() != $pager->getCurrentMaxLink()): ?>
    <?php if ($pager->getLastPage() != $pager->getCurrentMaxLink()+1): ?>
    ...
    <?php endif ?>
    <?php echo link_to($pager->getLastPage(), $url . "$page_var=".$pager->getLastPage() . (isset($order)?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    <?php endif ?>
  <?php echo link_to(__('Siguiente&raquo;'), $url . "$page_var=".$pager->getNextPage() . (isset($order)?"&o=$order":''), array('class'  => 'numerosPag')) ?>
  <?php # echo link_to('&raquo;', 'politico/ranking?page='.$pager->getLastPage()) ?>
<?php endif ?>