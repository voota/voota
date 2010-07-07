<?php

/**
 * SfReview form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SfReviewForm extends BaseSfReviewForm
{
  public function configure()
  {
  	unset(
  		$this['entity_id']
  		, $this['value']
  		, $this['sf_review_type_id']
  	);
  }
}
