<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SfReviewTypeEntity filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewTypeEntityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sum'               => new sfWidgetFormFilterInput(),
      'score'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'sum'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'score'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('sf_review_type_entity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewTypeEntity';
  }

  public function getFields()
  {
    return array(
      'sf_review_type_id' => 'ForeignKey',
      'entity_id'         => 'Number',
      'date'              => 'Date',
      'sum'               => 'Number',
      'score'             => 'Number',
    );
  }
}
