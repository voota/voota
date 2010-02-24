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
class apiActions extends sfActions{
  const PAGE_SIZE = 20;
  
  public function executeApi(sfWebRequest $request){
  	$data = RestUtils::processRequest();
  	$res = "";
  	
	switch($data->getMethod()) {
		case 'get':
			$method = $request->getParameter('method', 'most_recently_voted');
			$res = $this->$method( $data );
			break;
	}
	
	RestUtils::sendResponse(200, json_encode($res), 'application/json');
  }
  
  private function most_recently_voted( $data ){
  	$c = new Criteria();
  	$pager = new sfPropelPager('Politico', self::PAGE_SIZE);
   	$pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    
    $entities = array();
    foreach ($pager->getResults() as $politico){
    	$entities[] = new Entity( $politico ); 	
    }
  	
  	return $entities;
  }
  
  public function executePoliticos(sfWebRequest $request) {
	$data = RestUtils::processRequest();
	
	switch($data->getMethod())
	{
		// this is a request for all users, not one in particular
		case 'get':
			$user_list = array('nombre' => $this->getUser()->getProfile()->getNombre(), 'dos' => 'Antonio'); // assume this returns an array
	
			/*if($data->getHttpAccept() == 'json')
			{*/
				RestUtils::sendResponse(200, json_encode($user_list), 'application/json');
			/*}*/
			/*
			else if ($data->getHttpAccept() == 'xml')
			{
				// using the XML_SERIALIZER Pear Package
				$options = array
				(
					'indent' => '     ',
					'addDecl' => false,
					'rootName' => $fc->getAction(),
					XML_SERIALIZER_OPTION_RETURN_RESULT => true
				);
				$serializer = new XML_Serializer($options);
	
				RestUtils::sendResponse(200, $serializer->serialize($user_list), 'application/xml');
			}
			*/
			break;
		// new user create
		case 'post':
			/*
			$user = new User();
			$user->setFirstName($data->getData()->first_name);  // just for example, this should be done cleaner
			// and so on...
			$user->save();
	
			// just send the new ID as the body
			RestUtils::sendResponse(201, $user->getId());
			*/
	}
  	die;
  }
}
