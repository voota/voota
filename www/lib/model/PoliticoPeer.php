<?php

class PoliticoPeer extends BasePoliticoPeer
{
	static public function retrieveForAutoSelect($q, $limit)
	{
	  	$criteria = new Criteria();
		$pieces = explode(" ", $q);
		$criterions = array();
		$idx = 0;
		
		foreach ($pieces as $piece){			
			sfContext::getInstance()->getLogger()->debug("A SEARCH PIECE $piece");
			$criterions[$idx] = $criteria->getNewCriterion(PoliticoPeer::APELLIDOS, '%'.$piece.'%', Criteria::LIKE);
		  	$criterions[$idx]->addOr($criteria->getNewCriterion(PoliticoPeer::NOMBRE, '%'.$piece.'%', Criteria::LIKE));
		  	$criteria->addAnd( $criterions[$idx] );
		  	$idx++;	
		}
	
	  $criteria->addAscendingOrderByColumn(PoliticoPeer::APELLIDOS);
	  $criteria->setLimit($limit);
	 
	  $instituciones = array();
	  foreach (PoliticoPeer::doSelect($criteria) as $politico)
	  {
	    $politicos[$politico->getId()] = (string) $politico;
	  }
	 
	  return $politicos;
	}
	
	
}
