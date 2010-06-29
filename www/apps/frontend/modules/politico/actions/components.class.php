<?php

class politicoComponents extends sfComponents
{
	public function executeTags(){
		$c = new Criteria();
  		$sf_user = sfContext::getInstance()->getUser();
		
		$c->addJoin(EtiquetaPoliticoPeer::ETIQUETA_ID, EtiquetaPeer::ID);
  		if ($sf_user->isAuthenticated()){
			$c->addJoin(EtiquetaSfGuardUserPeer::ETIQUETA_ID, EtiquetaPeer::ID, Criteria::LEFT_JOIN);
		}

		$c->add(EtiquetaPoliticoPeer::POLITICO_ID, $politicoId);
		
		$this->etiquetas = EtiquetaPeer::doSelect( $c );
	}
	
}
