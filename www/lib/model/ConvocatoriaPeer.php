<?php

require 'lib/model/om/BaseConvocatoriaPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'convocatoria' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May  4 14:41:20 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ConvocatoriaPeer extends BaseConvocatoriaPeer {

	static public function retrieveForAutoSelect($q, $limit)
	{
	  	$criteria = new Criteria();
		$pieces = explode(" ", $q);
		$criterions = array();
		$idx = 0;
		$criteria->addJoin(ConvocatoriaPeer::ELECCION_ID, EleccionI18nPeer::ID);
		
		foreach ($pieces as $piece){			
			sfContext::getInstance()->getLogger()->debug("A SEARCH PIECE $piece");
			$criterions[$idx] = $criteria->getNewCriterion(EleccionI18nPeer::NOMBRE_CORTO, '%'.$piece.'%', Criteria::LIKE);
		  	$criteria->addAnd( $criterions[$idx] );
		  	$idx++;	
		}
	
	  $criteria->addAscendingOrderByColumn(EleccionI18nPeer::NOMBRE_CORTO);
	  $criteria->setLimit($limit);
	 
	  $convocatorias = array();
	  foreach (ConvocatoriaPeer::doSelect($criteria) as $convocatoria)
	  {
	    $convocatorias[$convocatoria->getId()] = (string) $convocatoria;
	  }
	 
	  return $convocatorias;
	}
} // ConvocatoriaPeer
