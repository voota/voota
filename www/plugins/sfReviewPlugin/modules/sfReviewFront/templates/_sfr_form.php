<?php use_helper('I18N') ?>
	
<?php if($redirect): ?>
<script type="text/javascript">
<!--
$(document).ready(function(){
	ejem('<?php echo url_for( $redirect );?>', '');
});
//-->
</script>
<?php else: ?>

<script type="text/javascript">
  <!--//
  $(document).ready(function() {
	  //controls character input/counter
	  $('#<?php echo "sf-review-text_$reviewBox" ?>').keyup(function() {
		  setCounter('#<?php echo "sf-review-counter_$reviewBox" ?>', this, 280);
	  });
	  setCounter('#<?php echo "sf-review-counter_$reviewBox" ?>', '#<?php echo "sf-review-text_$reviewBox" ?>', 280);  
	  subscribeHint('#<?php echo "sf-review-text_$reviewBox" ?>', 'blur');
	  $('#<?php echo "sf-review-form-$reviewBox" ?>').submit(function() {
		  removeHint('#<?php echo "sf-review-text_$reviewBox" ?>', 'blur');
      <?php include_component_slot('sendStmt', array('reviewBox' => $reviewBox, 'reviewType' => $reviewType, 'reviewEntityId' => $reviewEntityId, 'reviewId' => $reviewId)) ?>
		  return false;
	  });
  });
  //-->
</script>

<form action="#" id="<?php echo "sf-review-form-$reviewBox" ?>">
	<input type="hidden" id="t" name="t" value="<?php echo $reviewType ?>" />
	<input type="hidden" id="e" name="e" value="<?php echo $reviewEntityId ?>" />
	<input type="hidden" id="b" name="b" value="<?php echo $reviewBox ?>" />
	<input type="hidden" id="i" name="i" value="<?php echo $reviewId ?>" />

	<?php if ($reviewId != ''): ?>
		<h5>
		  <strong><?php echo __('Tu voto')?>:</strong> <?php echo $reviewValue == 1?__('A favor'):__('En contra')?>
		  <br />
		  <span class="sf-review-action">
		    <?php echo jq_link_to_remote(__('Dejarlo como estaba'), array(
				    'update'   => $reviewBox?$reviewBox:'sf_review',
				    'url'    => "@sf_review_init?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
				)) ?>
		  </span>
		</h5>
	<?php endif?>
	<div class="sf-review-hands">
    <div class="sf-review-positive">
			<input type="radio" name="v" value="1" id="v-<?php echo $reviewId ?>-positive" <?php if ($reviewValue==1 || $reviewValue==0): echo 'checked="checked"'; endif ?> />
		  <label for="v-<?php echo $reviewId ?>-positive">
		  	<img alt="yeah" src="/images/icoMiniUp.png" width="16" height="18" />
  		  <br />
		    <?php echo __('A favor, yeah')?>
		  </label>
		</div>

		<div class="sf-review-negative">
			<input type="radio" name="v" value="-1" id="v-<?php echo $reviewId ?>-negative" <?php if ($reviewValue==-1): echo 'checked="checked"'; endif ?> />
			<label for="v-<?php echo $reviewId ?>-negative">
		  	<img alt="buu" src="/images/icoMiniDown.png" width="16" height="18" />
		    <br />
		    <?php echo __('En contra, buu')?>
		  </label>
		</div>
	</div>

  <p id="sf-review-body">
    <textarea id="<?php echo "sf-review-text_$reviewBox" ?>" name="review_text" class="sf-review-text sfr" title="<?php echo __('¿Algo que comentar? Es el mejor momento :-)') ?>"><?php echo $reviewText ?></textarea>
  </p>
  
  <p id="<?php echo "sf-review-counter_$reviewBox" ?>" class="sf-review-counter"></p>

  <div class="sf-review-submit">
  	<input type="submit" value="<?php echo __('Enviar')?>" id="<?php echo ($reviewBox?$reviewBox:'sf_review').'_button' ?>"  />    
    <?php if ($reviewId != ''): ?>
  	  <?php if (!isset($cf) || !$cf): ?>
  	    <span class="sf-review-remove">
  				<?php echo jq_link_to_remote(__('Eliminar opinión'), array(
  			    'update'   => $reviewBox?$reviewBox:'sf_review',
  			    'url'    => "@sf_review_delete?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
  				)) ?>
  			</span>
  	  <?php else: ?>
  	  	<span class="sf-review-remove">
  	  	  <?php echo __('¿Seguro?') ?>
  	  	  <span>
    	  	  <?php echo jq_link_to_remote(__('Sí'), array(
    			    'update'   => $reviewBox?$reviewBox:'sf_review',
    			    'url'    => "@sf_review_delete?i=$reviewId&e=$reviewEntityId&t=$reviewType&cf=1".($reviewBox==''?'':"&b=$reviewBox"),		    		
    	  				'before' => "re_loading('".($reviewBox?$reviewBox:'sf_review')."')"
    			  )) ?>
  			  </span>
  			  <span>
  			    <?php echo jq_link_to_remote(__('No'), array(
  			      'update'   => $reviewBox?$reviewBox:'sf_review',
  			      'url'    => "@sf_review_form?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),	
  			)) ?>
  			  </span>
  			</span>
  		<?php endif ?>
    <?php endif ?>
  </div>
  
  <div class="sf-review-opciones">
    <div id="opciones">
      <?php if ($sf_user->getProfile()->getFacebookUid()): ?>
        <div>
		  <?php echo fbCheckbox($reviewBox, $reviewToFb, $reviewId, $reviewType, $sf_user)?>
          <label for="<?php echo "sf-review-fb-publish-$reviewBox" ?>">
            <?php echo __('Publicar en tu Facebook') ?>
            <img src="/images/icoFacebook.png" width="16" height="16" alt="Facebook" />
          </label>
        </div>
      <?php else: ?>
  	    <input type="hidden" name="fb_publish" value="0" id="<?php echo "sf-review-fb-publish-$reviewBox" ?>" />
      <?php endif ?>
        <div>
		  <?php echo twCheckbox($reviewBox, $reviewToFb, $reviewId, $reviewType, $sf_user)?>
          <label for="<?php echo "sf-review-tw-publish-$reviewBox" ?>">
            <?php echo __('Publicar en tu Twitter') ?>
            <img src="/images/icoTwitter.png" width="16" height="16" alt="Twitter" />
          </label>
        </div>
      <?php /* ?>
      <div>
        <?php // TODO: Esto estaría mejor en un helper que calculase si debe estar 'checked' o no. También hace falta refactorizar ?>
        <?php $fb_checked = false ?>
        <?php if ($reviewId != ''): ?>
    			<?php if ($reviewToFb): ?>
  		    	<?php $fb_checked = true ?>
  		    <?php endif ?>
    		<?php elseif ($sf_user->getProfile()->getFacebookUid()): ?>
  		    <?php if ($sf_user->getProfile()->getFbPublishVotos() && $reviewType): ?>
  		    	<?php $fb_checked = true ?>
  		    <?php elseif ($sf_user->getProfile()->getFbPublishVotosOtros() && !$reviewType): ?>
  		    	<?php $fb_checked = true ?>
  		    <?php endif ?>
    		<?php endif ?>

        <input type="checkbox" name="fb_publish" value="1" id="<?php echo "sf-review-fb-publish-$reviewBox" ?>" <?php echo $fb_checked ? 'checked="checked"' : '' ?> />
        <label for="<?php echo "sf-review-fb-publish-$reviewBox" ?>">
          <?php echo __('Publicar en tu Facebook') ?>
          <img src="/images/icoFacebook.png" width="16" height="16" alt="Facebook" />
        </label>
      </div>
      <?php */ ?>
      <div>
		  <?php echo anonCheckbox($reviewBox, $anonReview, $reviewId, $sf_user)?>        
        <label for="<?php echo "sf-review-anon-publish-$reviewBox" ?>"><?php echo __('Vooto anónimo') ?></label>
      </div>
    </div>
  </div>
  
</form>

<?php endif //Si no redirect ?>
