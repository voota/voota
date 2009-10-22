<?php
class sfVoForm extends sfForm
{
	static $messages = array(
	);
	static $messagesEmail = array(
		'invalid' => '"%value%" no es una dirección de email válida.',
	);
	static $messagesString = array(
		'required' => 'Este campo es obligatorio.',
		'min_length' => '"%value%" es demasiado corto (%min_length% caracteres mínimo).',
		'max_length' => '"%value%"  es demasiado largo (%max_length% caracteres máximo).',
	);
	static $messagesUnique = array(
        'invalid'       => 'Este nombre ya está siendo utilizado',
    ) ;
	
	static $messagesDate = array (
		'min'=>'start date greater today.',
		'required'=> 'Este campo es obligatorio.',
		'invalid'=>'Esta fecha no es válida.'
	);
	static $messagesCompare = array(
		'invalid' => 'La contraseña no es igual las dos veces.',
	);
	
}