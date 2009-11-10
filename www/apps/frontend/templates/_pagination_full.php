<?php if ($pager->haveToPaginate()): ?>
  <?php # echo link_to('&laquo;', 'politico/ranking?page='.$pager->getFirstPage()) ?>
 <?php echo link_to('&laquo;Anterior', $url ."$page_var=".$pager->getPreviousPage() . ($order?"&o=$order":''), array('class'  => 'numerosPag')) ?>
  
  <?php if ($pager->getPage() > 3): ?>
    <?php echo link_to($pager->getFirstPage(), $url ."$page_var=".$pager->getFirstPage() . ($order?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    ...
  <?php endif ?>
  <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
    <?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url . "$page_var=".$page . ($order?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    <?php if ($page != $pager->getCurrentMaxLink()): ?> <?php endif ?>
  <?php endforeach ?>
    <?php if ($pager->getLastPage() != $pager->getCurrentMaxLink()): ?>
    ...
    <?php echo link_to($pager->getLastPage(), $url . "$page_var=".$pager->getLastPage() . ($order?"&o=$order":''), array('class'  => 'numerosPag')) ?>
    <?php endif ?>
    
  <?php echo link_to('Siguiente&raquo;', $url . "$page_var=".$pager->getNextPage() . ($order?"&o=$order":''), array('class'  => 'numerosPag')) ?>
  <?php # echo link_to('&raquo;', 'politico/ranking?page='.$pager->getLastPage()) ?>
<?php endif ?>