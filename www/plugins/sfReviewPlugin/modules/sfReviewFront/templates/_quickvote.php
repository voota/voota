<?php use_helper('I18N') ?>

<div id="<?php echo "mv_up_".$entity->getId()?>">
    <div class="quickvote_hand left_hand">
        <?php if($review && $review->getValue() == 1):?>+<?php endif ?>
        <a href="#" id="<?php echo "qv_up_".$entity->getId()?>">
        	<?php echo image_tag($review && $review->getValue() == 1?'icoMiniUp.png':'icoMiniUp_dis.png', 'title="'. ($review && $review->getValue() == 1?__('Eliminar voto'):__('Votar a favor')) .'" alt="'. __('yeah') .'"') ?>
		</a>
    </div>
    <div class="quickvote_hand">
        <?php if($review && $review->getValue() == -1):?>-<?php endif ?>
        <a href="#" id="<?php echo "qv_down_".$entity->getId()?>">
        	<?php echo image_tag($review && $review->getValue() == -1?'icoMiniDown.png':'icoMiniDown_dis.png', 'title="'. ($review && $review->getValue() == -1?__('Eliminar voto'):__('Votar en contra')) .'" alt="'. __('buu') .'"') ?>
		</a>
    </div>

	<script type="text/javascript">
	<!--//
	  $(document).ready(function(){
	    $("#<?php echo "qv_up_".$entity->getId()?>").click(function(){ 
		  	<?php if($sf_user->isAuthenticated()):?>
		  	  jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#<?php echo "mv_up_".$entity->getId()?>').html(data);},url:'<?php echo url_for('sfReviewFront/quickvote?t='. $entity->getType() .'&e='. $entity->getId() .'&rm=1&v=1&rzt='.time()) ?>'});
			<?php else: ?>
		     	ejem('<?php echo url_for('sfGuardAuth/signin');?>', '');
		    <?php endif ?>
		    return false;
	    });          
		$("#<?php echo "qv_down_".$entity->getId()?>").click(function(){
		  	<?php if($sf_user->isAuthenticated()):?>
		  	  jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#<?php echo "mv_up_".$entity->getId()?>').html(data);},url:'<?php echo url_for('sfReviewFront/quickvote?t='. $entity->getType() .'&e='. $entity->getId() .'&rm=1&v=-1&rzt='.time()) ?>'});
			<?php else: ?>
		     	ejem('<?php echo url_for('sfGuardAuth/signin');?>', '');
		    <?php endif ?>
		    return false;
		});
	  });
	//-->
	</script>
</div>
