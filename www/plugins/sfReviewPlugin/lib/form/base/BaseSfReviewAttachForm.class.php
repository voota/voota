<?php

/**
 * SfReviewAttach form base class.
 *
 * @method SfReviewAttach getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseSfReviewAttachForm extends BaseFormPropel
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
