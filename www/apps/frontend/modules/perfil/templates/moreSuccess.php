
        <table>
          <?php foreach ($reviews->getResults() as $review): ?>
			<?php include_component_slot('profileReview', array('review' => $review)) ?>
          <?php endforeach ?>
        </table>
        <div id="more_reviews_<?php echo $page?>">
		  <?php if ($reviews->haveToPaginate() && $reviews->getLastPage() > $reviews->getPage()): ?>
		      <?php echo jq_form_remote_tag(array(
		    	'update'   => "more_reviews_$page",
		    	'url'      => "@profile_more_comments",
  	  			'before' => "re_loading('more_reviews_$page')"
				),
		        array('id' => "frm_more_reviews"
		      )) ?>
			  <?php echo input_hidden_tag('username', $user->getProfile()->getVanity())?>
			  <?php echo input_hidden_tag('page', $page)?>
			  <?php echo submit_tag(__('más')) ?>
			</form>
		  <?php endif ?>
        </div>
        