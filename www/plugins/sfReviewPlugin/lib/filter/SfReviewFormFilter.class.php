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
class SfReviewFormFilter extends BaseSfReviewFormFilter
{
  public function configure()
  {
    $this->widgetSchema['text'] = new sfVoWidgetFormFilterInputNotEmpty();
  }
  
  protected function addTextCriteria(Criteria $criteria, $field, $values)
  {
    $colname = $this->getColname($field);
    
    if (is_array($values) && isset($values['is_not_empty']) && $values['is_not_empty'])
    {
      $criterion = $criteria->getNewCriterion($colname, '', Criteria::NOT_EQUAL);
      $criteria->add($criterion);
    }
    else
    {
  		parent::addTextCriteria($criteria, $field, $values);
    }
  }
  
}
