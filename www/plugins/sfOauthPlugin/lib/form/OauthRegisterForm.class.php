<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class OauthRegisterForm extends sfGuardUserAdminForm
{
  protected static $tipos = array('Web' => 'Web', 'Mobile' => 'Móvil', 'Others' => 'Otros');
  
  public function configure()
  {  	
  	$nameWidget = new sfWidgetFormInputText(array());
  	$nameWidget->setDefault(sfContext::getInstance()->getUser());
  	$emailWidget = new sfWidgetFormInputText(array());
  	$emailWidget->setDefault(sfContext::getInstance()->getUser()->getGuardUser()->getUsername());
  	
    $this->setWidgets(array(
      'name'   => $nameWidget,
      'email'   => $emailWidget,
    	    'callback_uri' => new sfWidgetFormInputText(array()),
		    'application_uri' => new sfWidgetFormInputText(array()),
		    'application_title' => new sfWidgetFormInputText(array()),
		    'application_descr' => new sfWidgetFormTextarea(array()),
		    'application_notes' => new sfWidgetFormTextarea(array()),
		    'application_type' => new sfWidgetFormSelect(array('choices' => self::$tipos)),
		    'application_commercial' => new sfWidgetFormInputCheckbox(array()),
    ));
    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->setValidators(array(
	  'name'   => new sfValidatorString(array('required' => true)),    
	  'email'   => new sfValidatorEmail(array('required' => true)),    
	  'callback_uri'   => new sfValidatorString(array('required' => false)),    
	  'application_uri'   => new sfValidatorUrl(array('required' => false)),    
	  'application_title'   => new sfValidatorString(array('required' => false)),    
	  'application_descr'   => new sfValidatorString(array('required' => false)),    
	  'application_notes'   => new sfValidatorString(array('required' => false)),    
	  'application_type'   => new sfValidatorString(array('required' => false)),    
	  'application_commercial'   => new sfValidatorString(array('required' => false)), 
	));
       
    $this->widgetSchema->setNameFormat('application[%s]');    
  }
}