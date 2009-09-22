<?php

/**
 * SfReviewModeration form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewModerationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'changed'          => new sfWidgetFormDateTime(),
      'prev_status'      => new sfWidgetFormInput(),
      'reason_id'        => new sfWidgetFormPropelChoice(array('model' => 'SfReviewReason', 'add_empty' => true)),
      'sf_review_id'     => new sfWidgetFormPropelChoice(array('model' => 'SfReview', 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'SfReviewModeration', 'column' => 'id', 'required' => false)),
      'changed'          => new sfValidatorDateTime(array('required' => false)),
      'prev_status'      => new sfValidatorInteger(array('required' => false)),
      'reason_id'        => new sfValidatorPropelChoice(array('model' => 'SfReviewReason', 'column' => 'id', 'required' => false)),
      'sf_review_id'     => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id', 'required' => false)),
      'sf_guard_user_id' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_review_moderation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewModeration';
  }


}
