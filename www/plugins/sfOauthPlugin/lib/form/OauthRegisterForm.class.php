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
  protected static $tipos = array('W' => 'Web', 'M' => 'Móvil', 'O' => 'Otros');
  
  public function configure()
  {
  	
    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array()),
      'email'   => new sfWidgetFormInputText(array()),
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
	  'callback_uri'   => new sfValidatorUrl(array('required' => true)),    
	  'application_uri'   => new sfValidatorUrl(array('required' => true)),    
	  'application_title'   => new sfValidatorString(array('required' => true)),    
	  'application_descr'   => new sfValidatorString(array('required' => true)),    
	  'application_notes'   => new sfValidatorString(array('required' => true)),    
	  'application_type'   => new sfValidatorString(array('required' => true)),    
	  'application_commercial'   => new sfValidatorString(array('required' => true)), 
	));
       

    $uniqValidator = new sfValidatorAnd(array(
    	new sfValidatorPropelUniqueUpdater(array('model'=>'sfGuardUser', 'column'=>array('username')), sfVoForm::getUniqueMessages()    ),
    	new sfValidatorPropelUniqueUpdater(array('model'=>'sfGuardUserProfile', 'column'=>array('vanity')), sfVoForm::getUniqueMessages()    )
    ));
       
    $this->validatorSchema->setPostValidator($uniqValidator);
  }
}