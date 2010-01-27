<?php

/**
 * SfReviewModeration form base class.
 *
 * @method SfReviewModeration getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSfReviewModerationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'changed'          => new sfWidgetFormDateTime(),
      'prev_status'      => new sfWidgetFormInputText(),
      'reason_id'        => new sfWidgetFormPropelChoice(array('model' => 'SfReviewReason', 'add_empty' => true)),
      'sf_review_id'     => new sfWidgetFormPropelChoice(array('model' => 'SfReview', 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'SfReviewModeration', 'column' => 'id', 'required' => false)),
      'changed'          => new sfValidatorDateTime(array('required' => false)),
      'prev_status'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'reason_id'        => new sfValidatorPropelChoice(array('model' => 'SfReviewReason', 'column' => 'id', 'required' => false)),
      'sf_review_id'     => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id', 'required' => false)),
      'sf_guard_user_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
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
