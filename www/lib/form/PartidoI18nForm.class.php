<?php

/**
 * PartidoI18n form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PartidoI18nForm extends BasePartidoI18nForm
{
  public function configure()
  {
	$this->widgetSchema['presentacion'] = new sfWidgetFormTextarea(array());
    $this->validatorSchema['presentacion'] = new sfValidatorString(array('required' => false)); 
  }
}
