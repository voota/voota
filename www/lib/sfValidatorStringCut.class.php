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
class sfValidatorStringCut extends sfValidatorString
{

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    $clean = (string) $value;

    $length = function_exists('mb_strlen') ? mb_strlen($clean, $this->getCharset()) : strlen($clean);

    if ($this->hasOption('max_length') && $length > $this->getOption('max_length'))
    {
      $clean = substr($clean, 0, $length); 
    }

    if ($this->hasOption('min_length') && $length < $this->getOption('min_length'))
    {
      throw new sfValidatorError($this, 'min_length', array('value' => $value, 'min_length' => $this->getOption('min_length')));
    }

    return $clean;
  }
}
