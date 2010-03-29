<div id="<?php echo "mv_up_".$entity->getId()?>">
    <span style="float:left; margin:0px 25px 0px 0px;">
        <?php if($review && $review->getValue() == 1):?>+<?php endif ?>
        <a href="#" id="<?php echo "qv_up_".$entity->getId()?>">
        	<?php echo image_tag($review && $review->getValue() == 1?'icoMiniUp.png':'icoMiniUp_dis.png', 'title="'. __('Votar a favor') .'" alt="'. __('yeah') .'"') ?>
		</a>
    </span>
    <span style="float:left">
        <?php if($review && $review->getValue() == -1):?>-<?php endif ?>
        <a href="#" id="<?php echo "qv_down_".$entity->getId()?>">
        	<?php echo image_tag($review && $review->getValue() == -1?'icoMiniDown.png':'icoMiniDown_dis.png', 'title="'. __('Votar en contra') .'" alt="'. __('buu') .'"') ?>
		</a>
    </span>
</div>

<script type="text/javascript">
<!--//
  $(document).ready(function(){
	function vote(v){
    	<?php if($sf_user->isAuthenticated()):?>
        	jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){
                            		jQuery('#<?php echo "mv_up_".$entity->getId()?>').html(data);
                            	},url:'<?php echo url_for('sfReviewFront/quickvote?t='. $entity->getType() .'&e='. $entity->getId() .'&v=') ?>'+v});
		<?php else: ?>
 	    	$("#sfr_dialog").dialog('open');
        <?php endif ?>
        return false;
	}
    $("#<?php echo "qv_up_".$entity->getId()?>").click(function(){ return vote(1);});          
	$("#<?php echo "qv_down_".$entity->getId()?>").click(function(){ return vote(-1);});
  });
//-->
</script>
