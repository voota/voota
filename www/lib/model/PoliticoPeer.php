<?php

class PoliticoPeer extends BasePoliticoPeer
{
	static public function retrieveForAutoSelect($q, $limit)
	{
	  $criteria = new Criteria();
  	  $criterion = $criteria->getNewCriterion(PoliticoPeer::APELLIDOS, '%'.$q.'%', Criteria::LIKE);
	  $criterion->addOr($criteria->getNewCriterion(PoliticoPeer::NOMBRE, '%'.$q.'%', Criteria::LIKE));
	  $criteria->add( $criterion );	
	
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
