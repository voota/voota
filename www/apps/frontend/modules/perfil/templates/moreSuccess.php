<?php foreach ($reviews->getResults() as $review): ?>
	<?php include_component_slot('profileReview', array('review' => $review)) ?>
<?php endforeach ?>

<?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
	<div id="<?php echo "more_reviews_". $reviews->getPage() ?>">
    		  <?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
  		      <?php echo jq_form_remote_tag(
  		        array('update'   => "more_reviews_". $reviews->getPage(),
  		    	        'url'      => "@profile_more_comments",
    	  			      'before'   => "$('#frm_more_reviews". $reviews->getPage()."').hide();re_loading('more_reviews_". $reviews->getPage() ."');"),
  		        array('id' => "frm_more_reviews". $reviews->getPage()))
  		      ?>
        		  <div><input type="hidden" name="username" value="<?php echo $user->getProfile()->getVanity()?>" /></div>
            	<div><input type="hidden" name="page" value="<?php echo isset($page)?$page:'1' ?>" /></div>
            	<div><input type="submit" value="<?php echo __('más') ?>" /></div>
    			  </form>
    		  <?php endif ?>
	</div>
<?php endif ?>