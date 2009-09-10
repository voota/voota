<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SfReviewPolitico filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewPoliticoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'politico_id' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'politico_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Politico', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_review_politico_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewPolitico';
  }

  public function getFields()
  {
    return array(
      'id'          => 'ForeignKey',
      'politico_id' => 'ForeignKey',
    );
  }
}
