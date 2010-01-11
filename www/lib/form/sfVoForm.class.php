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
class sfVoForm extends sfForm
{
	public static function getFormNotValidMessage() {
		return sfContext::getInstance()->getI18N()->__('Por favor, revisa lo siguiente antes de seguir.', array(), 'notices');
	}
	public static function getMissingPasswordMessage() {
		return sfContext::getInstance()->getI18N()->__('Para cambiar tu contraseña dinos cuál es la que tenías antes.', array(), 'notices');
	}
	public static function getFormSavesMessage() {
		return sfContext::getInstance()->getI18N()->__('Genial, todo guardado como es debido.', array(), 'notices');
	}
	
	public static function getMessages() {
		return array();
	}
	public static function getEmailMessages() {
		return array(
		'required' => sfContext::getInstance()->getI18N()->__('Este campo es necesario. A veces tenemos que hacerlo.', array(), 'notices'),
		'invalid' => sfContext::getInstance()->getI18N()->__('Esto no parece una dirección de email.', array(), 'notices')
		);
	}
	public static function getRequiredMessages() {
		return array(
		'required' => sfContext::getInstance()->getI18N()->__('Este campo es necesario. A veces tenemos que hacerlo.', array(), 'notices'),
		);
	}
	public static function getStringMessages() {
		return array(
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es necesario. A veces tenemos que hacerlo.', array(), 'notices'),
			'min_length' => sfContext::getInstance()->getI18N()->__('El texto es demasiado corto (%min_length% caracteres mínimo).', array(), 'notices'),
			'max_length' => sfContext::getInstance()->getI18N()->__('El texto es demasiado largo (%max_length% caracteres máximo).', array(), 'notices'),
		);
	}
	public static function getPasswordMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('La contraseña no es válida.', array(), 'notices'),
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es necesario. A veces tenemos que hacerlo.', array(), 'notices'),
			'min_length' => sfContext::getInstance()->getI18N()->__('El texto es demasiado corto (%min_length% caracteres mínimo).', array(), 'notices'),
			'max_length' => sfContext::getInstance()->getI18N()->__('El texto es demasiado largo (%max_length% caracteres máximo).', array(), 'notices'),
		);
	}
	public static function getUniqueMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('Demasiado lento, vaquero. Alguien se anticipó y cogió ya este nombre.', array(), 'notices')
		);
	}
	public static function getUniqueEmailMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('¡Alto ahí los clics! Parece que ya estás registrado en Voota con este email.%1% ¿Qué tal si intentas entrar por donde pone "Ya estás registrado"?', array('%1%' => '<br>'), 'notices')
		);
	}
	public static function getDateMessages() {
		return array(
			'min' => sfContext::getInstance()->getI18N()->__('De momento no navegamos al futuro! Esta fecha es posterior a hoy!', array(), 'notices'),
			'required' => sfContext::getInstance()->getI18N()->__('Este campo es necesario. A veces tenemos que hacerlo.', array(), 'notices'),
			'invalid' => sfContext::getInstance()->getI18N()->__('Ponc! Fecha no válida.', array(), 'notices'),
		);
	}
	public static function getCompareMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('La contraseña no es la misma en ambos campos.', array(), 'notices')
		);
	}
	public static function getUserMessages() {
		return array(
			'invalid' => sfContext::getInstance()->getI18N()->__('El email o la contraseña no son válidos.', array(), 'notices')
		);
	}
	public static function getImageMessages() {
		return array(
			'max_size' => sfContext::getInstance()->getI18N()->__('Imagen demasiado grande. No más de %max_size%b.', array(), 'notices'),
			'mime_types' => sfContext::getInstance()->getI18N()->__('Formato de imagen no válido.', array(), 'notices'),
			'extension' => sfContext::getInstance()->getI18N()->__('Formato de imagen no válido.', array(), 'notices')
    		);
	}
	public static function getUrlMessages() {
		return array(
		'invalid' => sfContext::getInstance()->getI18N()->__('El enlace no es válido (Ejemplo: Voota.es).', array(), 'notices')
		);
	}
	
}