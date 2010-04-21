<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('SfReview') ?>

<div id="docbox">
<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#edit_doc').click(function(){
	    $('#ed_box').show();
			re_loading( 'ed_box' );
			jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#ed_box').html(data);},url:'<?php echo url_for('propuesta/editDoc?id='.$propuesta->getId())?>'});
			return false;
	  });
  });
  //-->
</script>

    <?php if($propuesta->getDoc() || ($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId())): ?>
      <p>
        <?php echo __('Documento')?>:
        <span id="fileName"> 
          <?php if($propuesta->getDoc()):?>
      	    <a class="document"  href="<?php echo S3Voota::getImagesUrl().'/docs/'.$propuesta->getDoc() ?>"><?php echo $propuesta->getDoc() ?></a> (<?php echo ByteSize( $propuesta->getDocSize() ) ?>)
          <?php else: ?>
      	    <?php echo __('ninguno')?>
          <?php endif ?>
        </span>
        <?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
        	<a href="#" id="edit_doc"><?php echo __('Hacer cambios')?></a>
        <?php endif ?>
      </p>
	  	<div id="ed_box" style="display: none"></div>
    <?php endif ?>

</div>