<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$tests = array(
  'ábcd' => array('length' => 10, 'ext' => '', 'fullWords' => false),
  'ábcd2' => array('length' => 1, 'ext' => '', 'fullWords' => false),
  'ábcd3' => array('length' => 2, 'ext' => '', 'fullWords' => false),
  'ábcd4' => array('length' => 3, 'ext' => '', 'fullWords' => false),
  'aácd5' => array('length' => 1, 'ext' => '', 'fullWords' => false),
  'aácd5' => array('length' => 2, 'ext' => '', 'fullWords' => false),
);

foreach ($tests as $string => $attributes)
{
  echo "$string (".$attributes['length']."): [".SfVoUtil::cutToLength($string, $attributes['length'], $attributes['ext'], $attributes['fullWords'])."]\n";
}
