<?php

/**
 * Enlace form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EnlaceForm extends BaseEnlaceForm
{
  protected static $tipos_enlace = array(
  		'1' => '11870', 
    	'2' => 'blog',
    	'3' => 'bloglines',
    	'4' => 'dailymotion',
    	'5' => 'delicious',
    	'6' => 'facebook',
    	'7' => 'flickr',
    	'8' => 'google reader',
    	'9' => 'linkedin',
    	'10' => 'picasa',
    	'11' => 'twitter',
    	'12' => 'web personal',
    	'13' => 'wikipedia',
    	'14' => 'xing',
    	'15' => 'youtube'
  );


	
  public function configure()
  {
	$this->widgetSchema['politico_id'] = 
		new sfWidgetFormPropelChoice(array(
			'model'     => 'Politico',
			'add_empty' => false,
			'order_by' => array('Nombre', 'asc'),
		));

		
    $this->widgetSchema['tipo'] = new sfWidgetFormSelect(array('choices' => self::$tipos_enlace));
    $this->widgetSchema['culture'] = new sfWidgetFormInput(array(), array('style' => "width: 20px;"));
    
    $this->validatorSchema['culture'] = new sfValidatorString(array('required' => false, "max_length" => 2));  
  }
}
