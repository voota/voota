<?php

/**
 * SfReviewType form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInput(),
      'model'     => new sfWidgetFormInput(),
      'module'    => new sfWidgetFormInput(),
      'max_value' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'SfReviewType', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'model'     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'module'    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'max_value' => new sfValidatorInteger(array('required' => false)),
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
