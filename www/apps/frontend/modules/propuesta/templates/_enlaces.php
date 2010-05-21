<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('SfReview') ?>

<script type="text/javascript" charset="utf-8">
  <!--//
	$(document).ready(function() {
		  $('#edit_enlaces').click(function(){
				re_loading( 'ee_box' );
				jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#ee_box').html(data);},url:'<?php echo url_for('propuesta/editEnlaces?id='.$propuesta->getId()) ?>'});
				return false;
		  });
  });
  //-->
</script>

<?php if(count($activeEnlaces) > 0 || ($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId())): ?>
  <div id="external-links">
    <h3><?php echo __('Enlaces externos', array('%1%' => $propuesta->getTitulo()))?></h3>
    <?php if(count($activeEnlaces) > 0): ?>
      <ul>
        <?php foreach($activeEnlaces as $enlace): ?>
  	      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
        <?php endforeach ?>
      </ul>
    <?php else: ?>
  	  <p><?php echo __('ninguno')?></p>
    <?php endif ?>
    <?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
		  <div id="ee_box"><a href="#" id="edit_enlaces"><?php echo __('Hacer cambios')?></a></div> 
    <?php endif ?>
  </div>
<?php endif ?>
