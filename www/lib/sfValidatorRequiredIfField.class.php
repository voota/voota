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
class sfValidatorRequiredIfField extends sfValidatorSchema
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * left_field:         The left field name
   *  * right_field:        The right field name
   *  * throw_global_error: Whether to throw a global error (false by default) or an error tied to the left field
   *
   * @param string $leftField   The left field name
   * @param string $rightField  The right field name
   * @param array  $options     An array of options
   * @param array  $messages    An array of error messages
   *
   * @see sfValidatorBase
   */
  public function __construct($leftField, $rightField, $options = array(), $messages = array())
  {
    $this->addOption('left_field', $leftField);
    $this->addOption('right_field', $rightField);

    $this->addOption('throw_global_error', false);

    parent::__construct(null, $options, $messages);
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {
    if (is_null($values))
    {
      $values = array();
    }

    if (!is_array($values))
    {
      throw new InvalidArgumentException('You must pass an array parameter to the clean() method');
    }

    $leftValue  = isset($values[$this->getOption('left_field')]) ? $values[$this->getOption('left_field')] : null;
    $rightValue = isset($values[$this->getOption('right_field')]) ? $values[$this->getOption('right_field')] : null;

    $valid = true;
    if ($rightValue != '' && $leftValue == ''){
    	$valid = false;
    }

    if (!$valid)
    {
      $error = new sfValidatorError($this, 'required', array());
      if ($this->getOption('throw_global_error'))
      {
        throw $error;
      }

      throw new sfValidatorErrorSchema($this, array($this->getOption('left_field') => $error));
    }

    return $values;
  }

  /**
   * @see sfValidatorBase
   */
  public function asString($indent = 0)
  {
    $options = $this->getOptionsWithoutDefaults();
    $messages = $this->getMessagesWithoutDefaults();
    unset($options['left_field'], $options['operator'], $options['right_field']);

    $arguments = '';
    if ($options || $messages)
    {
      $arguments = sprintf('(%s%s)',
        $options ? sfYamlInline::dump($options) : ($messages ? '{}' : ''),
        $messages ? ', '.sfYamlInline::dump($messages) : ''
      );
    }

    return sprintf('%s%s %s%s %s',
      str_repeat(' ', $indent),
      $this->getOption('left_field'),
      $this->getOption('operator'),
      $arguments,
      $this->getOption('right_field')
    );
  }
}
