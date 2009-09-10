<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SfReview filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfReviewFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'               => new sfWidgetFormFilterInput(),
      'sf_guard_user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'sf_review_type_id'   => new sfWidgetFormPropelChoice(array('model' => 'SfReviewType', 'add_empty' => true)),
      'sf_review_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SfReviewStatus', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'value'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sf_guard_user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'sf_review_type_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReviewType', 'column' => 'id')),
      'sf_review_status_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReviewStatus', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_review_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReview';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'value'               => 'Number',
      'sf_guard_user_id'    => 'ForeignKey',
      'sf_review_type_id'   => 'ForeignKey',
      'sf_review_status_id' => 'ForeignKey',
    );
  }
}
