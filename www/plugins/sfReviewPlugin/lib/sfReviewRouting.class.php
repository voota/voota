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
class sfReviewRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();

    // preprend our routes
	$r->prependRoute('sf_review_init', new sfRoute('/review/init', array('module' => 'sfReviewFront', 'action' => 'init')));
	$r->prependRoute('sf_review_form', new sfRoute('/review/form', array('module' => 'sfReviewFront', 'action' => 'form')));
	$r->prependRoute('sf_review_preview', new sfRoute('/review/preview', array('module' => 'sfReviewFront', 'action' => 'preview')));
	$r->prependRoute('sf_review_send', new sfRoute('/review/send', array('module' => 'sfReviewFront', 'action' => 'send')));
	$r->prependRoute('sf_review_delete', new sfRoute('/review/delete', array('module' => 'sfReviewFront', 'action' => 'delete')));
  }
  
  static public function addRouteForAdminType(sfEvent $event)
  {
  	$class = (class_exists('Doctrine'))?'sfDoctrineRouteCollection':'sfPropelRouteCollection';
    $event->getSubject()->prependRoute('sf_review_type', new $class(array(
      'name'                 => 'sf_review_type',
      'model'                => 'SfReviewType',
      'module'               => 'sfReviewType',
      'prefix_path'          => 'sf_review_type',
      'with_wildcard_routes' => true,
      'requirements'         => array(),
    )));
  }
  
  static public function addRouteForAdminStatus(sfEvent $event)
  {
  	$class = (class_exists('Doctrine'))?'sfDoctrineRouteCollection':'sfPropelRouteCollection';
    $event->getSubject()->prependRoute('sf_review_status', new $class(array(
      'name'                 => 'sf_review_status',
      'model'                => 'SfReviewStatus',
      'module'               => 'sfReviewStatus',
      'prefix_path'          => 'sf_review_status',
      'with_wildcard_routes' => true,
      'requirements'         => array(),
    )));
  }
  
  static public function addRouteForAdmin(sfEvent $event)
  {
  	$class = (class_exists('Doctrine'))?'sfDoctrineRouteCollection':'sfPropelRouteCollection';
    $event->getSubject()->prependRoute('sf_review', new $class(array(
      'name'                 => 'sf_review',
      'model'                => 'SfReview',
      'module'               => 'sfReview',
      'prefix_path'          => 'sf_review',
      'with_wildcard_routes' => true,
      'requirements'         => array(),
    )));
  }
  
  
}
