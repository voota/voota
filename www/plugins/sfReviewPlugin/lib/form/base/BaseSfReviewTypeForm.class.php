<?php

/**
 * SfReviewType form base class.
 *
 * @method SfReviewType getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfReviewTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'model'      => new sfWidgetFormInputText(),
      'module'     => new sfWidgetFormInputText(),
      'max_value'  => new sfWidgetFormInputText(),
      'culturized' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'SfReviewType', 'column' => 'id', 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'model'      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'module'     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'max_value'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'culturized' => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sf_review_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewType';
  }


}
