<?php if ($pager->haveToPaginate()): ?>
  <?php # echo link_to('&laquo;', 'politico/ranking?page='.$pager->getFirstPage()) ?>
 <?php echo link_to('&lt;&lt;Anterior', $url ."$page_var=".$pager->getPreviousPage(), array('class'  => 'numerosPag')) ?>
  
  <?php if ($pager->getPage() > 3): ?>
    <?php echo link_to($pager->getFirstPage(), $url ."$page_var=".$pager->getFirstPage(), array('class'  => 'numerosPag')) ?>
    ...
  <?php endif ?>
  <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
    <?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url . "$page_var=".$page, array('class'  => 'numerosPag')) ?>
    <?php if ($page != $pager->getCurrentMaxLink()): ?> <?php endif ?>
  <?php endforeach ?>
    <?php if ($pager->getLastPage() != $pager->getCurrentMaxLink()): ?>
    ...
    <?php echo link_to($pager->getLastPage(), $url . "$page_var=".$pager->getLastPage(), array('class'  => 'numerosPag')) ?>
    <?php endif ?>
    
  <?php echo link_to('Siguiente&gt;&gt;', $url . "$page_var=".$pager->getNextPage(), array('class'  => 'numerosPag')) ?>
  <?php # echo link_to('&raquo;', 'politico/ranking?page='.$pager->getLastPage()) ?>
<?php endif ?>