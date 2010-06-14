<?php

/**
 * Etiqueta form base class.
 *
 * @method Etiqueta getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEtiquetaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'texto'                       => new sfWidgetFormInputText(),
      'etiqueta_sf_guard_user_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'etiqueta_politico_list'      => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Politico')),
      'etiqueta_partido_list'       => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Partido')),
      'etiqueta_propuesta_list'     => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Propuesta')),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorPropelChoice(array('model' => 'Etiqueta', 'column' => 'id', 'required' => false)),
      'texto'                       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'etiqueta_sf_guard_user_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'etiqueta_politico_list'      => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Politico', 'required' => false)),
      'etiqueta_partido_list'       => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Partido', 'required' => false)),
      'etiqueta_propuesta_list'     => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Propuesta', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('etiqueta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Etiqueta';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['etiqueta_sf_guard_user_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaSfGuardUsers() as $obj)
      {
        $values[] = $obj->getSfGuardUserId();
      }

      $this->setDefault('etiqueta_sf_guard_user_list', $values);
    }

    if (isset($this->widgetSchema['etiqueta_politico_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPoliticos() as $obj)
      {
        $values[] = $obj->getPoliticoId();
      }

      $this->setDefault('etiqueta_politico_list', $values);
    }

    if (isset($this->widgetSchema['etiqueta_partido_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPartidos() as $obj)
      {
        $values[] = $obj->getPartidoId();
      }

      $this->setDefault('etiqueta_partido_list', $values);
    }

    if (isset($this->widgetSchema['etiqueta_propuesta_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPropuestas() as $obj)
      {
        $values[] = $obj->getPropuestaId();
      }

      $this->setDefault('etiqueta_propuesta_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEtiquetaSfGuardUserList($con);
    $this->saveEtiquetaPoliticoList($con);
    $this->saveEtiquetaPartidoList($con);
    $this->saveEtiquetaPropuestaList($con);
  }

  public function saveEtiquetaSfGuardUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_sf_guard_user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaSfGuardUserPeer::ETIQUETA_ID, $this->object->getPrimaryKey());
    EtiquetaSfGuardUserPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_sf_guard_user_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaSfGuardUser();
        $obj->setEtiquetaId($this->object->getPrimaryKey());
        $obj->setSfGuardUserId($value);
        $obj->save();
      }
    }
  }

  public function saveEtiquetaPoliticoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_politico_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPoliticoPeer::ETIQUETA_ID, $this->object->getPrimaryKey());
    EtiquetaPoliticoPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_politico_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPolitico();
        $obj->setEtiquetaId($this->object->getPrimaryKey());
        $obj->setPoliticoId($value);
        $obj->save();
      }
    }
  }

  public function saveEtiquetaPartidoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_partido_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPartidoPeer::ETIQUETA_ID, $this->object->getPrimaryKey());
    EtiquetaPartidoPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_partido_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPartido();
        $obj->setEtiquetaId($this->object->getPrimaryKey());
        $obj->setPartidoId($value);
        $obj->save();
      }
    }
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
    $c->add(EtiquetaPropuestaPeer::ETIQUETA_ID, $this->object->getPrimaryKey());
    EtiquetaPropuestaPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_propuesta_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPropuesta();
        $obj->setEtiquetaId($this->object->getPrimaryKey());
        $obj->setPropuestaId($value);
        $obj->save();
      }
    }
  }

}
