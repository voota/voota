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
  protected static $sino = array('1' => 'Sí', '0' => 'No');
  public function configure()
  {
    $years = range(1920,date('Y'));
  	$this->widgetSchema['fecha_nacimiento'] = new sfWidgetFormJQueryDate(array(
    						'culture' => 'es'
    						, 'format' => '%day%/%month%/%year%'
    						, 'years' => array_combine($years, $years)
    						));
    						
  	$this->widgetSchema['mails_comentarios'] = new sfWidgetFormSelect(array('choices' => self::$sino));
  	$this->widgetSchema['mails_noticias'] = new sfWidgetFormSelect(array('choices' => self::$sino));
    $this->widgetSchema['mails_contacto'] = new sfWidgetFormSelect(array('choices' => self::$sino));
    $this->widgetSchema['mails_seguidor'] = new sfWidgetFormSelect(array('choices' => self::$sino));
    

    unset(
    	$this['created_at']
    	, $this['imagen']
    	, $this['codigo'],
      $this['fb_publish_votos'],
      $this['fb_publish_votos_otros'],
      $this['fb_publish_cambios_perfil'],
      $this['fb_tip'],
      $this['anonymous'],
      $this['tw_publish_votos'],
      $this['tw_publish_votos_otros'],
      $this['tw_publish_cambios_perfil'],
      $this['tw_oauth_token'],
      $this['tw_oauth_token_secret'],
      $this['username'],
      $this['facebook_uid'],
      $this['email'],
      $this['email_hash']
	);
  }
  
  
}
