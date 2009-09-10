<?php

/**
 * SfReviewAttach form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewAttachForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'sf_review_id' => new sfWidgetFormPropelChoice(array('model' => 'SfReview', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'SfReviewAttach', 'column' => 'id', 'required' => false)),
      'sf_review_id' => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_review_attach[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewAttach';
  }


}
