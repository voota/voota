<?php

/**
 * SfReview form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class SfReviewForm extends BaseSfReviewForm
{
  public function configure()
  { 
    unset(
    	$this['entity_id']
    	, $this['value']
    	, $this['sf_guard_user_id']
    	, $this['sf_review_type_id']
    	, $this['created_at']
    	, $this['cookie']
    	, $this['ip_address']
    	, $this['text']
    	, $this['modified_at']
    	, $this['sf_review_id']
    	, $this['balance']
    	, $this['is_active']
	);
  }
}
