<?php
class sfVoForm extends sfForm
{
	public static function getFormNotValidMessage() {
		return sfContext::getInstance()->getI18N()->__('Me temo que ha habido un problema con los campos del formulario, ¿puedes revisar los campos en rojo?', array(), 'notices');
	}
	public static function getMissingPasswordMessage() {
		return sfContext::getInstance()->getI18N()->__('Para cambiar la contraseña tienes que escribir la antigua.', array(), 'notices');
	}
	public static function getFormSavesMessage() {
		return sfContext::getInstance()->getI18N()->__('Tus cambios se han guardado correctamente.', array(), 'notices');
	}
	
	public static function getMessages() {
		return array();
	}
	public static function getEmailMessages() {
		return array(
		'required' => sfContext::getInstance()->getI18N()->__('Este campo es obligatorio.', array(), 'notices'),
		'invalid' => sfContext::getInstance()->getI18N()->__('"%value%" no es una dirección de email válida.', array(), 'notices')
		);
	}
	public static function getStringMessages() {
		return array(
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es obligatorio.', array(), 'notices'),
			'min_length' => sfContext::getInstance()->getI18N()->__('El texto es demasiado corto (%min_length% caracteres mínimo).', array(), 'notices'),
			'max_length' => sfContext::getInstance()->getI18N()->__('El texto es demasiado largo (%max_length% caracteres máximo).', array(), 'notices'),
		);
	}
	public static function getUniqueMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('Este nombre ya está siendo utilizado.', array(), 'notices')
		);
	}
	public static function getDateMessages() {
		return array(
			'min' => sfContext::getInstance()->getI18N()->__('La fecha es posterior a hoy.', array(), 'notices'),
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es obligatorio.', array(), 'notices'),
			'invalid' => sfContext::getInstance()->getI18N()->__('Esta fecha no es válida.', array(), 'notices'),
		);
	}
	public static function getCompareMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('La contraseña no es igual las dos veces.', array(), 'notices')
		);
	}
	public static function getUserMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('El email o la contraseña no son válidos.', array(), 'notices')
		);
	}
	
}