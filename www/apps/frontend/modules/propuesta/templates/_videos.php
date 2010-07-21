<?php use_helper('VoFormat') ?>

<?php if($propuesta->getUrlVideo1()): ?>
<ul class="videos">
  <li>
    <p><?php echo __('La opinión del %name%:', array('%name%' => $propuesta->getPartidoRelatedByPartidoVideo1Id() )) ?></p>
    <div class="thumb">
      <a href="<?php echo $propuesta->getUrlVideo1() ?>">
        <img src="<?php echo getYoutubeImageUrl( $propuesta->getUrlVideo1() )?>" alt="<?php echo __('La opinión del %name%:', array('%name%' => $propuesta->getPartidoRelatedByPartidoVideo1Id()))  ?>" />
      </a>
    </div>
    <p>(<a href="<?php echo $propuesta->getUrlVideo1() ?>">YouTube</a>)</p>
  </li>
  <li>
    <p><?php echo __('La opinión del %name%:', array('%name%' => $propuesta->getPartidoRelatedByPartidoVideo2Id())) ?></p>
    <div class="thumb">
      <a href="<?php echo $propuesta->getUrlVideo2() ?>">
        <img src="<?php echo getYoutubeImageUrl( $propuesta->getUrlVideo2() )?>" alt="<?php echo __('La opinión del %name%:', array('%name%' => $propuesta->getPartidoRelatedByPartidoVideo2Id())) ?>" />
      </a>
    </div>
    <p>(<a href="<?php echo $propuesta->getUrlVideo2() ?>">YouTube</a>)</p>
  </li>
</ul>
<?php endif ?>