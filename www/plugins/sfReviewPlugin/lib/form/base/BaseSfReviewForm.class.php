<?php

/**
 * SfReview form base class.
 *
 * @method SfReview getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfReviewForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'entity_id'           => new sfWidgetFormInputText(),
      'value'               => new sfWidgetFormInputText(),
      'sf_guard_user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'sf_review_type_id'   => new sfWidgetFormPropelChoice(array('model' => 'SfReviewType', 'add_empty' => true)),
      'sf_review_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SfReviewStatus', 'add_empty' => false)),
      'created_at'          => new sfWidgetFormDateTime(),
      'cookie'              => new sfWidgetFormInputText(),
      'ip_address'          => new sfWidgetFormInputText(),
      'text'                => new sfWidgetFormInputText(),
      'modified_at'         => new sfWidgetFormDateTime(),
      'culture'             => new sfWidgetFormInputText(),
      'sf_review_id'        => new sfWidgetFormPropelChoice(array('model' => 'SfReview', 'add_empty' => true)),
      'balance'             => new sfWidgetFormInputText(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'to_fb'               => new sfWidgetFormInputCheckbox(),
      'source'              => new sfWidgetFormInputText(),
      'anonymous'           => new sfWidgetFormInputCheckbox(),
      'to_tw'               => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id', 'required' => false)),
      'entity_id'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'value'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'sf_guard_user_id'    => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'sf_review_type_id'   => new sfValidatorPropelChoice(array('model' => 'SfReviewType', 'column' => 'id', 'required' => false)),
      'sf_review_status_id' => new sfValidatorPropelChoice(array('model' => 'SfReviewStatus', 'column' => 'id')),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'cookie'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'ip_address'          => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'text'                => new sfValidatorString(array('max_length' => 420, 'required' => false)),
      'modified_at'         => new sfValidatorDateTime(array('required' => false)),
      'culture'             => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'sf_review_id'        => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id', 'required' => false)),
      'balance'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'is_active'           => new sfValidatorBoolean(),
      'to_fb'               => new sfValidatorBoolean(),
      'source'              => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'anonymous'           => new sfValidatorBoolean(),
      'to_tw'               => new sfValidatorBoolean(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SfReview', 'column' => array('entity_id', 'sf_guard_user_id', 'sf_review_type_id')))
    );

    $this->widgetSchema->setNameFormat('sf_review[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReview';
  }


}
