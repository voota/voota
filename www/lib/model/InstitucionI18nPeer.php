<?php

class InstitucionI18nPeer extends BaseInstitucionI18nPeer
{
	static public function retrieveForAutoSelect($q, $limit)
	{
	  $criteria = new Criteria();
	  $criteria->add(InstitucionI18nPeer::NOMBRE, '%'.$q.'%', Criteria::LIKE);
	  $criteria->addAscendingOrderByColumn(InstitucionI18nPeer::NOMBRE);
	  $criteria->setLimit($limit);
	 
	  $instituciones = array();
	  foreach (InstitucionI18nPeer::doSelect($criteria) as $institucion)
	  {
	    $instituciones[$institucion->getId()] = (string) $institucion->getNombre();
	  }
	 
	  return $instituciones;
	}
}
