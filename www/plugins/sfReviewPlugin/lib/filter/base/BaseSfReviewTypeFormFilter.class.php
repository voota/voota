<?php

/**
 * SfReviewType filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfReviewTypeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(),
      'model'      => new sfWidgetFormFilterInput(),
      'module'     => new sfWidgetFormFilterInput(),
      'max_value'  => new sfWidgetFormFilterInput(),
      'culturized' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'model'      => new sfValidatorPass(array('required' => false)),
      'module'     => new sfValidatorPass(array('required' => false)),
      'max_value'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'culturized' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('sf_review_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewType';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'model'      => 'Text',
      'module'     => 'Text',
      'max_value'  => 'Number',
      'culturized' => 'Boolean',
    );
  }
}
