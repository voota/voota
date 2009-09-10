<?php

/**
 * SfReviewPolitico form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewPoliticoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'politico_id' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'SfReview', 'column' => 'id', 'required' => false)),
      'politico_id' => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_review_politico[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewPolitico';
  }


}
