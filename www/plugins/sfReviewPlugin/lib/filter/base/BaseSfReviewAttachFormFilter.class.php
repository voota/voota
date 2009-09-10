<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SfReviewAttach filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewAttachFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sf_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SfReview', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'sf_review_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReview', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_review_attach_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewAttach';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'sf_review_id' => 'ForeignKey',
    );
  }
}
