<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorPropelUnique validates that the uniqueness of a column.
 *
 * Warning: sfValidatorPropelUnique is susceptible to race conditions.
 * To avoid this issue, wrap the validation process and the model saving
 * inside a transaction.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorPropelUnique.class.php 13249 2008-11-22 16:10:11Z fabien $
 */
class sfValidatorPasswordValid extends sfValidatorString
{
  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    if (!sfContext::getInstance()->getUser()->checkPassword( $value )) {
	    throw new sfValidatorError($this, 'invalid', array());
	}

    return $value;
  }
	

}
