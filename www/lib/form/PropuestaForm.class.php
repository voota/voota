<?php

/**
 * Propuesta form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class PropuestaForm extends BasePropuestaForm
{
  public function configure()
  {
    $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea(array(), array('style' => "width: 500px; height:200px"));
  }
}
