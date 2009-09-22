<?php

/**
 * SfReviewTypeEntity form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewTypeEntityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sf_review_type_id' => new sfWidgetFormInputHidden(),
      'entity_id'         => new sfWidgetFormInputHidden(),
      'date'              => new sfWidgetFormInputHidden(),
      'sum'               => new sfWidgetFormInput(),
      'score'             => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'sf_review_type_id' => new sfValidatorPropelChoice(array('model' => 'SfReviewType', 'column' => 'id', 'required' => false)),
      'entity_id'         => new sfValidatorPropelChoice(array('model' => 'SfReviewTypeEntity', 'column' => 'entity_id', 'required' => false)),
      'date'              => new sfValidatorPropelChoice(array('model' => 'SfReviewTypeEntity', 'column' => 'date', 'required' => false)),
      'sum'               => new sfValidatorNumber(),
      'score'             => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('sf_review_type_entity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewTypeEntity';
  }


}
