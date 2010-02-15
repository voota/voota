<?php

/**
 * SfReviewModeration filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfReviewModerationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'changed'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'prev_status'      => new sfWidgetFormFilterInput(),
      'reason_id'        => new sfWidgetFormPropelChoice(array('model' => 'SfReviewReason', 'add_empty' => true)),
      'sf_review_id'     => new sfWidgetFormPropelChoice(array('model' => 'SfReview', 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'changed'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'prev_status'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'reason_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReviewReason', 'column' => 'id')),
      'sf_review_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SfReview', 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('sf_review_moderation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfReviewModeration';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'changed'          => 'Date',
      'prev_status'      => 'Number',
      'reason_id'        => 'ForeignKey',
      'sf_review_id'     => 'ForeignKey',
      'sf_guard_user_id' => 'Number',
    );
  }
}
