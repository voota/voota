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

class TagManager {	
  	public static function removeTag($id, $e, $type){  	
  		$user = sfContext::getInstance()->getUser();

  		if($user->isAuthenticated() && $id){			
	  		if ($type == Politico::NUM_ENTITY){
		  	$etiqueta = EtiquetaPoliticoPeer::retrieveByPK($id, $e, $user->getCulture(), $user->getGuardUser()->getId());
	  		}
	  		else if ($type == Partido::NUM_ENTITY){
		  	$etiqueta = EtiquetaPartidoPeer::retrieveByPK($id, $e, $user->getCulture(), $user->getGuardUser()->getId());
	  				
	  		}
	  		else if ($type == Propuesta::NUM_ENTITY){
		  	$etiqueta = EtiquetaPropuestaPeer::retrieveByPK($id, $e, $user->getCulture(), $user->getGuardUser()->getId());
	  				
	  		}
		  	$etiqueta->delete();
  		}
  	}
  	
  	public static function newTag($entity, $texto){
  		$user = sfContext::getInstance()->getUser();
  		
  	  	if ($user->isAuthenticated() && $texto){
	  		$tags = preg_split ("/[\s,]+/", $texto);
	  		foreach ($tags as $tag){
		  		$c = new Criteria();
		  		$c->add(EtiquetaPeer::TEXTO, $tag);
		  		$c->add(EtiquetaPeer::CULTURE, $user->getCulture());
		  		$etiqueta = EtiquetaPeer::doSelectOne( $c );
		  		if (!$etiqueta){
				  	$etiqueta = new Etiqueta();
				  	$etiqueta->setTexto( $tag );
				  	$etiqueta->setCulture( $user->getCulture() );
				  	$etiqueta->save();
		  		}
	  		
	  			if ($entity->getType() == Politico::NUM_ENTITY){
			  	  	$c->add(EtiquetaPoliticoPeer::ETIQUETA_ID, $etiqueta->getId());
		  			$c->add(EtiquetaPoliticoPeer::CULTURE, $user->getCulture());
			  		$c->add(EtiquetaPoliticoPeer::POLITICO_ID, $entity->getId());
			  		$c->add(EtiquetaPoliticoPeer::SF_GUARD_USER_ID, $user->getGuardUser()->getId());
			  		$etiquetaPolitico = EtiquetaPoliticoPeer::doSelectOne( $c );
			  		if (!$etiquetaPolitico){
			  			$etiquetaPolitico = new EtiquetaPolitico();
			  			$etiquetaPolitico->setPoliticoId($entity->getId());
			  			$etiquetaPolitico->setEtiquetaId($etiqueta->getId());
				  		$etiquetaPolitico->setCulture( $user->getCulture() );
				  		$etiquetaPolitico->setFecha( time() );
			  			$etiquetaPolitico->setSfGuardUserId($user->getGuardUser()->getId());
			  			$etiquetaPolitico->save();
			  		}
			  		else {			  			
				  		$etiquetaPolitico->setFecha( time() );
			  			$etiquetaPolitico->save();
			  		}
	  			}
	  			elseif ($entity->getType() == Partido::NUM_ENTITY){
			  	  	$c->add(EtiquetaPartidoPeer::ETIQUETA_ID, $etiqueta->getId());
		  			$c->add(EtiquetaPartidoPeer::CULTURE, $user->getCulture());
			  		$c->add(EtiquetaPartidoPeer::PARTIDO_ID, $entity->getId());
			  		$c->add(EtiquetaPartidoPeer::SF_GUARD_USER_ID, $user->getGuardUser()->getId());
			  		$etiquetaPartido = EtiquetaPartidoPeer::doSelectOne( $c );
			  		if (!$etiquetaPartido){
			  			$etiquetaPartido = new EtiquetaPartido();
			  			$etiquetaPartido->setPartidoId($entity->getId());
			  			$etiquetaPartido->setEtiquetaId($etiqueta->getId());
				  		$etiquetaPartido->setCulture( $user->getCulture() );
				  		$etiquetaPartido->setFecha( time() );
			  			$etiquetaPartido->setSfGuardUserId($user->getGuardUser()->getId());
			  			$etiquetaPartido->save();
			  		}
			  		else {			  			
				  		$etiquetaPartido->setFecha( time() );
			  			$etiquetaPartido->save();
			  		}
	  			}
	  			elseif ($entity->getType() == Propuesta::NUM_ENTITY){
			  	  	$c->add(EtiquetaPropuestaPeer::ETIQUETA_ID, $etiqueta->getId());
		  			$c->add(EtiquetaPropuestaPeer::CULTURE, $user->getCulture());
			  		$c->add(EtiquetaPropuestaPeer::PROPUESTA_ID, $entity->getId());
			  		$c->add(EtiquetaPropuestaPeer::SF_GUARD_USER_ID, $user->getGuardUser()->getId());
			  		$etiquetaPropuesta = EtiquetaPropuestaPeer::doSelectOne( $c );
			  		if (!$etiquetaPropuesta){
			  			$etiquetaPropuesta = new EtiquetaPropuesta();
			  			$etiquetaPropuesta->setPropuestaId($entity->getId());
			  			$etiquetaPropuesta->setEtiquetaId($etiqueta->getId());
				  		$etiquetaPropuesta->setCulture( $user->getCulture() );
				  		$etiquetaPropuesta->setFecha( time() );
			  			$etiquetaPropuesta->setSfGuardUserId($user->getGuardUser()->getId());
			  			$etiquetaPropuesta->save();
			  		}
			  		else {			  			
				  		$etiquetaPropuesta->setFecha( time() );
			  			$etiquetaPropuesta->save();
			  		}
	  			}
	  		}
  		}
  	}
  	
  	public static function getTagsByLoggedUser($entity)
  	{
  		$user = sfContext::getInstance()->getUser();
  		
  		$query = '';
  		if ($user->isAuthenticated()){
	  		$query = "SELECT e.*, count(*) count FROM etiqueta e";  	
	  		if ($entity->getType() == Politico::NUM_ENTITY){
	  			$query .= " LEFT JOIN etiqueta_politico ep ON (ep.etiqueta_id = e.id)";
	  		}
	  		else if ($entity->getType() == Partido::NUM_ENTITY){
	  			$query .= " LEFT JOIN etiqueta_partido ep ON (ep.etiqueta_id = e.id)";
	  				
	  		}
	  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
	  			$query .= " LEFT JOIN etiqueta_propuesta ep ON (ep.etiqueta_id = e.id)";
	  				
	  		}
	  		
	  		if ($entity->getType() == Politico::NUM_ENTITY){
	  			$query .= " WHERE ep.politico_id = ?";  				
	  		}
	  		else if ($entity->getType() == Partido::NUM_ENTITY){
	  			$query .= " WHERE ep.partido_id = ?";
	  		}  		
	  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
	  			$query .= " WHERE ep.propuesta_id = ?";
	  		}  		 	
	  		if ($entity->getType() == Politico::NUM_ENTITY){
	  			$query .= " AND e.id IN (SELECT etiqueta_id FROM etiqueta_politico WHERE sf_guard_user_id = ?)"; 
	  		}
	  		else if ($entity->getType() == Partido::NUM_ENTITY){
	  			$query .= " AND e.id IN (SELECT etiqueta_id FROM etiqueta_partido WHERE sf_guard_user_id = ?)"; 	  				
	  		}
	  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
	  			$query .= " AND e.id IN (SELECT etiqueta_id FROM etiqueta_propuesta WHERE sf_guard_user_id = ?)"; 	  				
	  		}
	  		$query .= " AND e.culture = ?";			
	  		$query .= " GROUP BY e.id";				
	  		$query .= " ORDER BY ep.fecha DESC, count DESC";
  		}
  		else {
  			return array();
  		}
  		
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$statement->bindValue(1, $entity->getId());
		$statement->bindValue(2, $user->getGuardUser()->getId());
		$statement->bindValue(3, $user->getCulture());
		//$statement->bindValue(3, $entity->getId());
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_CLASS, 'Etiqueta');
  	}
  	
  	public static function getTags($entity, $page = 1)
  	{
  		$user = sfContext::getInstance()->getUser();
  		
  		$query = "SELECT e.*, count(*) count FROM etiqueta e";  	
  		#$query .= " INNER JOIN etiqueta_sf_guard_user eu ON (eu.etiqueta_id = e.id)";
  		if ($entity->getType() == Politico::NUM_ENTITY){
  			$query .= " INNER JOIN etiqueta_politico ep ON (ep.etiqueta_id = e.id)";
  		}
  		else if ($entity->getType() == Partido::NUM_ENTITY){
  			$query .= " INNER JOIN etiqueta_partido ep ON (ep.etiqueta_id = e.id)";
  		}
  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
  			$query .= " INNER JOIN etiqueta_propuesta ep ON (ep.etiqueta_id = e.id)";
  		}
  		if ($entity->getType() == Politico::NUM_ENTITY){
  			$query .= " WHERE ep.politico_id = ?";
  		}  		
  		else if ($entity->getType() == Partido::NUM_ENTITY){
  			$query .= " WHERE ep.partido_id = ?";
  		}  		
  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
  			$query .= " WHERE ep.propuesta_id = ?";
  		}  		
  		if ($user->isAuthenticated()){
	  		if ($entity->getType() == Politico::NUM_ENTITY){
	  			$query .= " AND e.id NOT IN (SELECT etiqueta_id FROM etiqueta_politico WHERE sf_guard_user_id = ?)"; 
	  		}
	  		else if ($entity->getType() == Partido::NUM_ENTITY){
	  			$query .= " AND e.id NOT IN (SELECT etiqueta_id FROM etiqueta_partido WHERE sf_guard_user_id = ?)"; 				
	  		}
	  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
	  			$query .= " AND e.id NOT IN (SELECT etiqueta_id FROM etiqueta_propuesta WHERE sf_guard_user_id = ?)"; 				
	  		}	  		
   		}
	  	$query .= " AND e.culture = ?";			
  		$query .= " GROUP BY e.id";	
	  	$query .= " ORDER BY count DESC, ep.fecha DESC";
	  			
	  	$pager = new sfQueryPager('Etiqueta', 5);
	  	$pager->setQuery($query);
		$values = array();
		$values[] = $entity->getId();
  		if ($user->isAuthenticated()){
			$values[] = $user->getGuardUser()->getId();
  		}
		$values[] =  $user->getCulture();
	  	$pager->setValues($values);
		$pager->setPage( $page );
		$pager->init();		    
	  	
		return $pager;
 	}  	
}