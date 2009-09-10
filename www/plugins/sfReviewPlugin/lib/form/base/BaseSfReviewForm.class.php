<?php

/**
 * SfReview form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'value'               => new sfWidgetFormInput(),
      'sf_guard_user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'sf_review_type_id'   => new sfWidgetFormPropelChoice(array('model' => 'SfReviewType', 'add_empty' => false)),
      'sf_review_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SfReviewStatus', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id', 'required' => false)),
      'value'               => new sfValidatorInteger(array('required' => false)),
      'sf_guard_user_id'    => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'sf_review_type_id'   => new sfValidatorPropelChoice(array('model' => 'SfReviewType', 'column' => 'id')),
      'sf_review_status_id' => new sfValidatorPropelChoice(array('model' => 'SfReviewStatus', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_review[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReview';
  }


}
