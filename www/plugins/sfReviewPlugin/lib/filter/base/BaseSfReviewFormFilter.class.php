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
      'entity_id'           => new sfWidgetFormFilterInput(),
      'value'               => new sfWidgetFormFilterInput(),
      'sf_guard_user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'sf_review_type_id'   => new sfWidgetFormPropelChoice(array('model' => 'SfReviewType', 'add_empty' => true)),
      'sf_review_status_id' => new sfWidgetFormPropelChoice(array('model' => 'SfReviewStatus', 'add_empty' => true)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'cookie'              => new sfWidgetFormFilterInput(),
      'ip_address'          => new sfWidgetFormFilterInput(),
      'text'                => new sfWidgetFormFilterInput(),
      'modified_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'entity_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'value'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sf_guard_user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'sf_review_type_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReviewType', 'column' => 'id')),
      'sf_review_status_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReviewStatus', 'column' => 'id')),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cookie'              => new sfValidatorPass(array('required' => false)),
      'ip_address'          => new sfValidatorPass(array('required' => false)),
      'text'                => new sfValidatorPass(array('required' => false)),
      'modified_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
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
      'entity_id'           => 'Number',
      'value'               => 'Number',
      'sf_guard_user_id'    => 'ForeignKey',
      'sf_review_type_id'   => 'ForeignKey',
      'sf_review_status_id' => 'ForeignKey',
      'created_at'          => 'Date',
      'cookie'              => 'Text',
      'ip_address'          => 'Text',
      'text'                => 'Text',
      'modified_at'         => 'Date',
    );
  }
}
