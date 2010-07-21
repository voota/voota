<?php

/**
 * Propuesta form base class.
 *
 * @method Propuesta getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePropuestaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'titulo'                  => new sfWidgetFormInputText(),
      'descripcion'             => new sfWidgetFormInputText(),
      'culture'                 => new sfWidgetFormInputText(),
      'imagen'                  => new sfWidgetFormInputText(),
      'doc'                     => new sfWidgetFormInputText(),
      'doc_size'                => new sfWidgetFormInputText(),
      'sf_guard_user_id'        => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'sumu'                    => new sfWidgetFormInputText(),
      'sumd'                    => new sfWidgetFormInputText(),
      'is_active'               => new sfWidgetFormInputCheckbox(),
      'created_at'              => new sfWidgetFormDateTime(),
      'modified_at'             => new sfWidgetFormDateTime(),
      'vanity'                  => new sfWidgetFormInputText(),
      'url_video_1'             => new sfWidgetFormInputText(),
      'partido_video1_id'       => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'url_video_2'             => new sfWidgetFormInputText(),
      'partido_video2_id'       => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'etiqueta_propuesta_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Etiqueta')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'Propuesta', 'column' => 'id', 'required' => false)),
      'titulo'                  => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'descripcion'             => new sfValidatorString(array('max_length' => 600, 'required' => false)),
      'culture'                 => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'imagen'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'doc'                     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'doc_size'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'sf_guard_user_id'        => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'sumu'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'sumd'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'is_active'               => new sfValidatorBoolean(),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'modified_at'             => new sfValidatorDateTime(array('required' => false)),
      'vanity'                  => new sfValidatorString(array('max_length' => 150)),
      'url_video_1'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'partido_video1_id'       => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'url_video_2'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'partido_video2_id'       => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'etiqueta_propuesta_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Etiqueta', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Propuesta', 'column' => array('vanity'))),
        new sfValidatorPropelUnique(array('model' => 'Propuesta', 'column' => array('titulo'))),
      ))
    );

    $this->widgetSchema->setNameFormat('propuesta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Propuesta';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['etiqueta_propuesta_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPropuestas() as $obj)
      {
        $values[] = $obj->getEtiquetaId();
      }

      $this->setDefault('etiqueta_propuesta_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEtiquetaPropuestaList($con);
  }

  public function saveEtiquetaPropuestaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_propuesta_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPropuestaPeer::PROPUESTA_ID, $this->object->getPrimaryKey());
    EtiquetaPropuestaPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_propuesta_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPropuesta();
        $obj->setPropuestaId($this->object->getPrimaryKey());
        $obj->setEtiquetaId($value);
        $obj->save();
      }
    }
  }

}
