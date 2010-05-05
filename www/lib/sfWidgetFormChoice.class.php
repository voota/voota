<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormChoice represents a choice widget.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormChoice.class.php 23994 2009-11-15 22:55:24Z bschussek $
 */
class sfWidgetFormChoiceDelete extends sfWidgetFormChoice
{
	protected function configure($options = array(), $attributes = array()) {
		$this->addRequiredOption('model_id');
		
		$this->addOption('parent_id', null);
		$this->addOption('name', null);
		$this->addOption('module', 'politico');
		
		parent::configure($options, $attributes);
	}
	
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $field = parent::render($name, $value, $attributes, $errors);
    $name = " ".$this->getOption('name')." ";
    $module = $this->getOption('module');
 
    $link = '<a href="'.sfContext::getInstance()->getController()->genUrl("$module/deleteInstitucion").'?idm='.$this->getOption('parent_id').'&idi='.$this->getOption('model_id').'" onclick="if (confirm(\'sure?\')) { return true; };return false;"><img src="/sfPropelPlugin/images/delete.png" alt="borrar" /></a>';
    
    return  (!$this->getOption('name')?$field:'') . $name . ($this->getOption('name')?$link:'');
  }
}
