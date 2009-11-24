<?php

/**
 * SfGuardUserProfile form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class SfGuardUserProfileForm extends BaseSfGuardUserProfileForm
{
  public function configure()
  {
    $years = range(1920,date('Y'));
  	$this->widgetSchema['fecha_nacimiento'] = new sfWidgetFormJQueryDate(array(
    						'culture' => 'es'
    						, 'format' => '%day%/%month%/%year%'
    						, 'years' => array_combine($years, $years)
    						));
  }
}
