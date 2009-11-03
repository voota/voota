<?php
class sfVoForm extends sfForm
{
	public static function getMessages() {
		return array();
	}
	public static function getEmailMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('"%value%" no es una dirección de email válida.', array(), 'messages')
		);
	}
	public static function getStringMessages() {
		return array(
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es obligatorio.', array(), 'messages'),
			'min_length' => sfContext::getInstance()->getI18N()->__('"%value%" es demasiado corto (%min_length% caracteres mínimo).', array(), 'messages'),
			'max_length' => sfContext::getInstance()->getI18N()->__('"%value%"  es demasiado largo (%max_length% caracteres máximo).', array(), 'messages'),
		);
	}
	public static function getUniqueMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('Este nombre ya está siendo utilizado.', array(), 'messages')
		);
	}
	public static function getDateMessages() {
		return array(
			'min' => sfContext::getInstance()->getI18N()->__('La fecha es posterior a hoy.', array(), 'messages'),
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es obligatorio.', array(), 'messages'),
			'invalid' => sfContext::getInstance()->getI18N()->__('Esta fecha no es válida.', array(), 'messages'),
		);
	}
	public static function getCompareMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('La contraseña no es igual las dos veces.', array(), 'messages')
		);
	}
	public static function getUserMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('El email o la contraseña no son válidos.', array(), 'messages')
		);
	}
	
}