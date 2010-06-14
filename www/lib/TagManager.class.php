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
  			$query .= " INNER JOIN etiqueta_sf_guard_user eu ON (eu.etiqueta_id = e.id)";
	  		
	  		if ($entity->getType() == Politico::NUM_ENTITY){
	  			$query .= " WHERE ep.politico_id = ?";  				
	  		}
	  		$query .= " AND eu.sf_guard_user_id = ?";  				
	  		$query .= " GROUP BY e.id";
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
  	public static function getTags($entity)
  	{
  		$user = sfContext::getInstance()->getUser();
  		
  		$query = "SELECT e.*, count(*) count FROM etiqueta e";  	
  		if ($entity->getType() == Politico::NUM_ENTITY){
  			$query .= " INNER JOIN etiqueta_politico ep ON (ep.etiqueta_id = e.id)";
  				
  		}
  		if ($user->isAuthenticated()){
  			$query .= " LEFT JOIN etiqueta_sf_guard_user eu ON (eu.etiqueta_id = e.id)";
   		}
  		if ($entity->getType() == Politico::NUM_ENTITY){
  			$query .= " WHERE ep.politico_id = ?";
  		}  		
  		if ($user->isAuthenticated()){
  			$query .= " AND eu.sf_guard_user_id != ?";
   		}
  		$query .= " GROUP BY e.id";
	  			
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);		
		//echo $query;die;
		$statement->bindValue(1, $entity->getId());
  		if ($user->isAuthenticated()){
			$statement->bindValue(2, $user->getGuardUser()->getId());
  		}
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_CLASS, 'Etiqueta');
 	}  	
}