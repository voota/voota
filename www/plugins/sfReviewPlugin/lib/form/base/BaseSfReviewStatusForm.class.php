<?php

/**
 * SfReviewStatus form base class.
 *
 * @method SfReviewStatus getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSfReviewStatusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInputText(),
      'published' => new sfWidgetFormInputCheckbox(),
      'offensive' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'SfReviewStatus', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'published' => new sfValidatorBoolean(),
      'offensive' => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('sf_review_status[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewStatus';
  }


}
