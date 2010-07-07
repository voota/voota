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
  		, $this['created_at']
  		, $this['cookie']
  		, $this['ip_address']
  		, $this['text']
  		, $this['modified_at']
  		, $this['sf_review_id']
  		, $this['balance']
  		, $this['is_active']
  		, $this['to_fb']
  		, $this['source']
  		, $this['sf_review_type_id']
  	);
  }
}
