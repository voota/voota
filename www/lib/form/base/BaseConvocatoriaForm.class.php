<?php

/**
 * Convocatoria form base class.
 *
 * @method Convocatoria getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseConvocatoriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'eleccion_id'      => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => false)),
      'nombre'           => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDate(),
      'created_at'       => new sfWidgetFormDateTime(),
      'imagen'           => new sfWidgetFormInputText(),
      'closed_at'        => new sfWidgetFormDateTime(),
      'total_escanyos'   => new sfWidgetFormInputText(),
      'min_sumu'         => new sfWidgetFormInputText(),
      'min_sumd'         => new sfWidgetFormInputText(),
      'lista_calle_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Partido')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id', 'required' => false)),
      'eleccion_id'      => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id')),
      'nombre'           => new sfValidatorString(array('max_length' => 45)),
      'fecha'            => new sfValidatorDate(),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'imagen'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'closed_at'        => new sfValidatorDateTime(array('required' => false)),
      'total_escanyos'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'min_sumu'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'min_sumd'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'lista_calle_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Partido', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Convocatoria', 'column' => array('eleccion_id', 'nombre')))
    );

    $this->widgetSchema->setNameFormat('convocatoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convocatoria';
  }

  public function getI18nModelName()
  {
    return 'ConvocatoriaI18n';
  }

  public function getI18nFormClass()
  {
    return 'ConvocatoriaI18nForm';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['lista_calle_list']))
    {
      $values = array();
      foreach ($this->object->getListaCalles() as $obj)
      {
        $values[] = $obj->getPartidoId();
      }

      $this->setDefault('lista_calle_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveListaCalleList($con);
  }

  public function saveListaCalleList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['lista_calle_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ListaCallePeer::CONVOCATORIA_ID, $this->object->getPrimaryKey());
    ListaCallePeer::doDelete($c, $con);

    $values = $this->getValue('lista_calle_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ListaCalle();
        $obj->setConvocatoriaId($this->object->getPrimaryKey());
        $obj->setPartidoId($value);
        $obj->save();
      }
    }
  }

}
