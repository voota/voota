<?php

/**
 * SfReviewTypeEntity form base class.
 *
 * @method SfReviewTypeEntity getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSfReviewTypeEntityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sf_review_type_id' => new sfWidgetFormInputHidden(),
      'entity_id'         => new sfWidgetFormInputHidden(),
      'date'              => new sfWidgetFormInputHidden(),
      'value'             => new sfWidgetFormInputHidden(),
      'sum'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'sf_review_type_id' => new sfValidatorPropelChoice(array('model' => 'SfReviewType', 'column' => 'id', 'required' => false)),
      'entity_id'         => new sfValidatorPropelChoice(array('model' => 'SfReviewTypeEntity', 'column' => 'entity_id', 'required' => false)),
      'date'              => new sfValidatorPropelChoice(array('model' => 'SfReviewTypeEntity', 'column' => 'date', 'required' => false)),
      'value'             => new sfValidatorPropelChoice(array('model' => 'SfReviewTypeEntity', 'column' => 'value', 'required' => false)),
      'sum'               => new sfValidatorNumber(),
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
