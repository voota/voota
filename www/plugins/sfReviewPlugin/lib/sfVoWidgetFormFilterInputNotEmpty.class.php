<?php

/*
 * This file is part of the symfony package.
 * (c) Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Sergio Viteri <sergio@voota.es>
 * @version    SVN: $Id: sfReviewRouting.class.php 13346 2009-09-09 12:10:17Z Sergio $
 */
class sfVoWidgetFormFilterInputNotEmpty extends sfWidgetFormFilterInput {
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('with_empty', true);
    $this->addOption('empty_label', 'is empty');
    $this->addOption('with_not_empty', true);
    $this->addOption('not_empty_label', 'is not empty');
    $this->addOption('template', '%input%<br />%empty_checkbox% %empty_label% %not_empty_checkbox% %not_empty_label%');
  }
	  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $values = array_merge(array('text' => '', 'is_empty' => false, 'is_not_empty' => false), is_array($value) ? $value : array());

    return strtr($this->getOption('template'), array(
      '%input%'          => $this->renderTag('input', array_merge(array('type' => 'text', 'id' => $this->generateId($name), 'name' => $name.'[text]', 'value' => $values['text']), $attributes)),
      '%empty_checkbox%' => $this->getOption('with_empty') ? $this->renderTag('input', array('type' => 'checkbox', 'name' => $name.'[is_empty]', 'checked' => $values['is_empty'] ? 'checked' : '')) : '',
      '%empty_label%'    => $this->getOption('with_empty') ? $this->renderContentTag('label', $this->getOption('empty_label'), array('for' => $this->generateId($name.'[is_empty]'))) : '',
      '%not_empty_checkbox%' => $this->getOption('with_not_empty') ? $this->renderTag('input', array('type' => 'checkbox', 'name' => $name.'[is_not_empty]', 'checked' => $values['is_not_empty'] ? 'checked' : '')) : '',
      '%not_empty_label%'    => $this->getOption('with_not_empty') ? $this->renderContentTag('label', $this->getOption('not_empty_label'), array('for' => $this->generateId($name.'[is_not_empty]'))) : '',
    ));
  }
  
}