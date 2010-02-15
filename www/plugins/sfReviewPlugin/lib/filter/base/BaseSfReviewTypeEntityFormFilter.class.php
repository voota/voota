<?php

/**
 * SfReviewTypeEntity filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfReviewTypeEntityFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sum'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'sum'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
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
      'value'             => 'Number',
      'sum'               => 'Number',
    );
  }
}
