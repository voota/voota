<?php

/**
 * SfReviewStatus form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewStatusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInput(),
      'published' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'SfReviewStatus', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'published' => new sfValidatorInteger(),
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