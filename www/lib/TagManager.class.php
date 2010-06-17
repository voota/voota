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
  	public static function removeTag($id){  	
  		$user = sfContext::getInstance()->getUser();

  		if($user->isAuthenticated() && $id){		  	
		  	$etiqueta = EtiquetaSfGuardUserPeer::retrieveByPK($id, $user->getGuardUser()->getId());
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
		  		$etiqueta = EtiquetaPeer::doSelectOne( $c );
		  		if (!$etiqueta){
				  	$etiqueta = new Etiqueta();
				  	$etiqueta->setTexto( $tag );
				  	$etiqueta->save();
		  		}
		  		$c = new Criteria();
		  		$c->add(EtiquetaSfGuardUserPeer::ETIQUETA_ID, $etiqueta->getId());
		  		$c->add(EtiquetaSfGuardUserPeer::SF_GUARD_USER_ID, $user->getGuardUser()->getId());
		  		$etiquetaUsuario = EtiquetaSfGuardUserPeer::doSelectOne( $c );
		  		if (!$etiquetaUsuario){
		  			$etiquetaUsuario = new EtiquetaSfGuardUser();
		  			$etiquetaUsuario->setSfGuardUserId($user->getGuardUser()->getId());
		  			$etiquetaUsuario->setEtiquetaId($etiqueta->getId());
		  			$etiquetaUsuario->setFecha( time() );
		  			$etiquetaUsuario->save();
		  		}
	  		
	  			if ($entity->getType() == Politico::NUM_ENTITY){
			  	  	$c->add(EtiquetaPoliticoPeer::ETIQUETA_ID, $etiqueta->getId());
			  		$c->add(EtiquetaPoliticoPeer::POLITICO_ID, $entity->getId());
			  		$etiquetaPolitico = EtiquetaPoliticoPeer::doSelectOne( $c );
			  		if (!$etiquetaPolitico){
			  			$etiquetaPolitico = new EtiquetaPolitico();
			  			$etiquetaPolitico->setPoliticoId($entity->getId());
			  			$etiquetaPolitico->setEtiquetaId($etiqueta->getId());
			  			$etiquetaPolitico->save();
			  		}
	  			}
	  			elseif ($entity->getType() == Partido::NUM_ENTITY){
			  	  	$c->add(EtiquetaPartidoPeer::ETIQUETA_ID, $etiqueta->getId());
			  		$c->add(EtiquetaPartidoPeer::PARTIDO_ID, $entity->getId());
			  		$etiquetaPartido = EtiquetaPartidoPeer::doSelectOne( $c );
			  		if (!$etiquetaPartido){
			  			$etiquetaPartido = new EtiquetaPartido();
			  			$etiquetaPartido->setPartidoId($entity->getId());
			  			$etiquetaPartido->setEtiquetaId($etiqueta->getId());
			  			$etiquetaPartido->save();
			  		}
	  			}
	  			elseif ($entity->getType() == Propuesta::NUM_ENTITY){
			  	  	$c->add(EtiquetaPropuestaPeer::ETIQUETA_ID, $etiqueta->getId());
			  		$c->add(EtiquetaPropuestaPeer::PROPUESTA_ID, $entity->getId());
			  		$etiquetaPropuesta = EtiquetaPropuestaPeer::doSelectOne( $c );
			  		if (!$etiquetaPropuesta){
			  			$etiquetaPropuesta = new EtiquetaPropuesta();
			  			$etiquetaPropuesta->setPropuestaId($entity->getId());
			  			$etiquetaPropuesta->setEtiquetaId($etiqueta->getId());
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
	  			$query .= " INNER JOIN etiqueta_politico ep ON (ep.etiqueta_id = e.id)";
	  		}
	  		else if ($entity->getType() == Partido::NUM_ENTITY){
	  			$query .= " INNER JOIN etiqueta_partido ep ON (ep.etiqueta_id = e.id)";
	  				
	  		}
	  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
	  			$query .= " INNER JOIN etiqueta_propuesta ep ON (ep.etiqueta_id = e.id)";
	  				
	  		}
  			$query .= " INNER JOIN etiqueta_sf_guard_user eu ON (eu.etiqueta_id = e.id)";
	  		
	  		if ($entity->getType() == Politico::NUM_ENTITY){
	  			$query .= " WHERE ep.politico_id = ?";  				
	  		}
	  		else if ($entity->getType() == Partido::NUM_ENTITY){
	  			$query .= " WHERE ep.partido_id = ?";
	  		}  		
	  		else if ($entity->getType() == Propuesta::NUM_ENTITY){
	  			$query .= " WHERE ep.propuesta_id = ?";
	  		}  		
	  		$query .= " AND e.id IN (SELECT etiqueta_id FROM etiqueta_sf_guard_user WHERE sf_guard_user_id = ?)";  				
	  		$query .= " GROUP BY e.id";				
	  		$query .= " ORDER BY eu.fecha DESC, count DESC";
  		}
  		else {
  			return array();
  		}
  		
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$statement->bindValue(1, $entity->getId());
		$statement->bindValue(2, $user->getGuardUser()->getId());
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_CLASS, 'Etiqueta');
  	}
  	
  	public static function getTags($entity, $page = 1)
  	{
  		$user = sfContext::getInstance()->getUser();
  		
  		$query = "SELECT e.*, count(*) count FROM etiqueta e";  	
  		$query .= " INNER JOIN etiqueta_sf_guard_user eu ON (eu.etiqueta_id = e.id)";
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
  			$query .= " AND e.id NOT IN (SELECT etiqueta_id FROM etiqueta_sf_guard_user WHERE sf_guard_user_id = ?)";
   		}
  		$query .= " GROUP BY e.id";	
	  	$query .= " ORDER BY count DESC, eu.fecha DESC";
	  			
	  	$pager = new sfQueryPager('Etiqueta', 5);
	  	$pager->setQuery($query);
		$values = array();
		$values[] = $entity->getId();
  		if ($user->isAuthenticated()){
			$values[] = $user->getGuardUser()->getId();
  		}
	  	$pager->setValues($values);
		$pager->setPage( $page );
		$pager->init();		    
	  	
		return $pager;
 	}  	
}