<?php

/**
 * Geo form base class.
 *
 * @method Geo getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseGeoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInputText(),
      'geo_id'           => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'codigo'           => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'lista_calle_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Convocatoria')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id', 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 150)),
      'geo_id'           => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id', 'required' => false)),
      'codigo'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'lista_calle_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Convocatoria', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('geo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Geo';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['lista_calle_list']))
    {
      $values = array();
      foreach ($this->object->getListaCalles() as $obj)
      {
        $values[] = $obj->getConvocatoriaId();
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
    $c->add(ListaCallePeer::GEO_ID, $this->object->getPrimaryKey());
    ListaCallePeer::doDelete($c, $con);

    $values = $this->getValue('lista_calle_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ListaCalle();
        $obj->setGeoId($this->object->getPrimaryKey());
        $obj->setConvocatoriaId($value);
        $obj->save();
      }
    }
  }

}
