<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormTextarea represents a textarea HTML tag.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormTextarea.class.php 9046 2008-05-19 08:13:51Z FabianLange $
 */
class sfWidgetFormTextareaCounter extends sfWidgetFormTextarea
{
  public function __construct($options = array(), $attributes = array())
  {
    $this->addOption('max_size', '50');

    parent::__construct($options, $attributes);
  }
  /**
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->setAttribute('rows', 4);
    $this->setAttribute('cols', 30);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
  	$maxSize = $this->getOption('max_size');
  	$atts = $this->fixFormId(array_merge(array('name' => $name), $attributes));
  	//var_dump($atts);
  	$id = $atts['id'];
  	$ret = "
<script type=\"text/javascript\">
  <!--//
  $(document).ready(function() {
	  $('#$id').keyup(function() {
		  setCounter('#".$id."_counter', this, $maxSize);
	  });
	  setCounter('#".$id."_counter', '#$id', $maxSize);

  });
  
  //-->
</script>
	";
  	$ret .= $this->renderContentTag('textarea', self::escapeOnce($value), array_merge(array('name' => $name), $attributes));
  	$ret .= '<p id="'.$id.'_counter" class="counter">'.'</p>';
    return $ret;
  }
}
