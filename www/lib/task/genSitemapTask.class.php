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
 * @subpackage Sitemap
 * @author     Sergio Viteri
 */
class genSitemapTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      new sfCommandOption('culture', null, sfCommandOption::PARAMETER_REQUIRED, 'The culture', 'es'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'genSitemap';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [fixNames|INFO] task does things.
Call it with:

  [php symfony genSitemap|INFO]
EOF;
  }

  const DEST = "/var/www/voota/www/web";
  const MAX_URLS = 50000;
  var $files = array();
  var $index = false;
  const cultures = false;
  
  private function writeToIndex($url, $culture){
  	$lf = "\n";
  	
    if (!$this->index){
  		$this->index = array();
  		$this->index['handle']  = fopen(self::DEST . "/sitemapindex-$culture.xml", "w");
  		fwrite($this->index['handle'],  "<?xml version=\"1.0\" encoding=\"UTF-8\"?>$lf");
  		fwrite($this->index['handle'],  "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">$lf");
  	}
  	
  	fwrite($this->index['handle'],  "<sitemap>$lf");
  	fwrite($this->index['handle'],  "<loc>$url</loc>$lf");
  	fwrite($this->index['handle'],  "<lastmod>".date('c')."</lastmod>$lf");
  	fwrite($this->index['handle'],  "</sitemap>$lf");
  }
  
  private function writeToSitemap($file, $url, $culture){
  	$lf = "\n";
  	$url = str_replace("http://symfony/", "http://voota.".$this->cultures[$culture]."/", $url);
  	
  	if (isset($this->files[$file])){
  		$aFile = $this->files[$file];
  		if (($aFile['count'] % self::MAX_URLS) == 0){
  			fwrite($aFile['handle'],  "</urlset>$lf");
  			$aFile['part']++;
  			$aFile['count'] = 0;
  			fclose($aFile['handle']);
  			$this->writeToIndex($aFile['url'], $culture);
  			$aFile['handle']  = fopen(self::DEST . "/$file-".$aFile['part'].".xml", "w");
  			$aFile['url']  = "http://voota.".$this->cultures[$culture]."/$file-".$aFile['part'].".xml.gz";
  			$this->files[$file] = $aFile;
  			fwrite($aFile['handle'],  "<?xml version=\"1.0\" encoding=\"UTF-8\"?>$lf");
  			fwrite($aFile['handle'],  "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">$lf");
  		}
  	}
  	if (!isset($this->files[$file])){
  		$aFile = array();
  		$aFile['handle']  = fopen(self::DEST . "/$file.xml", "w");
  		$aFile['url']  = "http://voota.".$this->cultures[$culture]."/$file.xml.gz";
  		$aFile['count'] = 0;
  		$aFile['part'] = 0;
  		$this->files[$file] = $aFile;
  		fwrite($aFile['handle'],  "<?xml version=\"1.0\" encoding=\"UTF-8\"?>$lf");
  		fwrite($aFile['handle'],  "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">$lf");
  	}
	
 	fwrite($aFile['handle'],  "<url>$lf"); 		
 	fwrite($aFile['handle'],  "<loc>$url</loc>$lf");
 	fwrite($aFile['handle'],  "<lastmod>".date('c')."</lastmod>$lf");
 	fwrite($aFile['handle'],  "<changefreq>weekly</changefreq>$lf");
 	fwrite($aFile['handle'],  "<priority>0.5</priority>$lf");
 	fwrite($aFile['handle'],  "</url>$lf");
 	$aFile['count']++;
  	$this->files[$file] = $aFile;
  }
  
  private function closeAll($culture){
  	$lf = "\n";
  	
  	foreach ($this->files as $name => $aFile){
 		fwrite($aFile['handle'],  "</urlset>$lf");
  		fclose($aFile['handle']);
  		$this->writeToIndex($aFile['url'], $culture);
  	}
   	
    if ($this->index){
 		fwrite($this->index['handle'],  "</sitemapindex>$lf");
  		fclose($this->index['handle']);
    }
  }
  
  protected function execute($arguments = array(), $options = array())
  {
  	$sfContext = sfContext::createInstance($this->configuration);
  	$controller = $sfContext->getController();
  	$this->cultures = array('ca' => 'cat', 'es' => 'es');
  	$culture = $options['culture'];
  	
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
    
    //foreach($this->cultures as $culture => $ext){
    	$sfContext->getUser()->setCulture( $culture );
    	
	    // **************** HOME **********************
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@homepage", true), $culture);
	    
	    // **************** Ultimas opiniones **********************
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_politicos_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_partidos_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_propuestas_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_otras_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_feed_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_politicos_feed_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_partidos_feed_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_propuestas_feed_$culture", true), $culture);
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@ultimas_opiniones_otras_feed_$culture", true), $culture);
	    
	    // **************** varias **********************
	    $this->writeToSitemap("voota-$culture", $controller->genUrl("@about", true), $culture);
		$this->writeToSitemap("voota-$culture", $controller->genUrl("@rules", true), $culture);
		$this->writeToSitemap("voota-$culture", $controller->genUrl("@search", true), $culture);
		$this->writeToSitemap("voota-$culture", $controller->genUrl("@contact", true), $culture);
    	
	    // **************** Fichas POLITICOS **********************
	    $c = new Criteria();
	    //$c->setLimit(5);
	    $politicos = PoliticoPeer::doSelect( $c );
	    foreach ($politicos as $politico){
	    	$this->writeToSitemap("politico-$culture", $controller->genUrl("politico/show?id=".$politico->getVanity(), true), $culture);
	    }
	    
	    // **************** Fichas PARTIDOS **********************
	    $c = new Criteria();
	    $c->add(PartidoPeer::IS_ACTIVE, true);
	    $partidos = PartidoPeer::doSelect( $c );
	    foreach ($partidos as $partido){
	    	$this->writeToSitemap("partido-$culture", $controller->genUrl("partido/show?id=".$partido->getAbreviatura(), true), $culture);
	    }
	    
	    // **************** Fichas PROPUESTAS **********************
	    $c = new Criteria();
	    $c->add(PropuestaPeer::IS_ACTIVE, true);
	    $c->add(PropuestaPeer::CULTURE, $culture);
	    $propuestas = PropuestaPeer::doSelect( $c );
	    foreach ($propuestas as $propuesta){
	    	$this->writeToSitemap("propuesta-$culture", $controller->genUrl("propuesta/show?id=".$propuesta->getVanity(), true), $culture);
	    }
	    
	    // **************** Fichas USUARIOS **********************
	    $c = new Criteria();
	    $c->add(SfGuardUserPeer::IS_ACTIVE, true);
	    $usuarios = SfGuardUserPeer::doSelect( $c );
	    foreach ($usuarios as $usuario){
	    	$this->writeToSitemap("usuario-$culture", $controller->genUrl("perfil/show?username=".$usuario->getProfile()->getVanity(), true), $culture);
	    }
	    
	    // **************** feeds POLITICOS **********************
	    $c = new Criteria();
	    //$c->setLimit(5);
	    $politicos = PoliticoPeer::doSelect( $c );
	    foreach ($politicos as $politico){
	    	$this->writeToSitemap("politico-feed-$culture", $controller->genUrl("politico/show?id=".$politico->getVanity(), true), $culture);
	    }
	    // **************** feeds PARTIDOS **********************
	    $c = new Criteria();
	    $c->add(PartidoPeer::IS_ACTIVE, true);
	    $partidos = PartidoPeer::doSelect( $c );
	    foreach ($partidos as $partido){
	    	$this->writeToSitemap("partido-feed-$culture", $controller->genUrl("partido/feed?id=".$partido->getAbreviatura(), true), $culture);
	    }
	    
	    // **************** feeds PROPUESTAS **********************
	    $c = new Criteria();
	    $c->add(PropuestaPeer::IS_ACTIVE, true);
	    $c->add(PropuestaPeer::CULTURE, $culture);
	    $propuestas = PropuestaPeer::doSelect( $c );
	    foreach ($propuestas as $propuesta){
	    	$this->writeToSitemap("propuesta-feed-$culture", $controller->genUrl("propuesta/feed?id=".$propuesta->getVanity(), true), $culture);
	    }
	    
	    // **************** feeds USUARIOS **********************
	    $c = new Criteria();
	    $c->add(SfGuardUserPeer::IS_ACTIVE, true);
	    $usuarios = SfGuardUserPeer::doSelect( $c );
	    foreach ($usuarios as $usuario){
	    	$this->writeToSitemap("usuario-feed-$culture", $controller->genUrl("perfil/feed?username=".$usuario->getProfile()->getVanity(), true), $culture);
	    }
	    
	    // **************** ranking PROPUESTAS **********************
	    $this->writeToSitemap("propuesta-ranking-$culture", $controller->genUrl("propuesta/ranking", true), $culture);	    
  		$pager = EntityManager::getPropuestas($culture);
	    $idx = 1;
  		while ($idx < $pager->getLastPage()){
  			$idx++;
		    $this->writeToSitemap("propuesta-ranking-$culture", $controller->genUrl("propuesta/ranking?page=$idx", true), $culture);
   		}

	    // **************** ranking POLITICOS **********************
	    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking", true), $culture);	    
  		$pager = EntityManager::getPoliticos(false, false, $culture);
	    $idx = 1;
  		while ($idx < $pager->getLastPage()){
  			$idx++;
		    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?page=$idx", true), $culture);
   		}
	    # ranking de polis filtrados por partido
	    $c = new Criteria();
	    $c->add(PartidoPeer::IS_ACTIVE, true);
	    $partidos = PartidoPeer::doSelect( $c );
	    foreach ($partidos as $partido){
		    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?partido=".$partido->getAbreviatura(), true), $culture);	    
	  		$pager = EntityManager::getPoliticos($partido->getAbreviatura(), false, $culture);
		    $idx = 1;
	  		while ($idx < $pager->getLastPage()){
	  			$idx++;
			    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?partido=".$partido->getAbreviatura() ."&page=$idx", true), $culture);
	   		}
	   		
	    	# ranking de polis filtrados por partido e insti
	    	$c = new Criteria();
   			$c->add(InstitucionPeer::IS_ACTIVE, true);
   			$c->addJoin(PoliticoInstitucionPeer::INSTITUCION_ID, InstitucionPeer::ID);
   			$c->addJoin(PoliticoPeer::ID, PoliticoInstitucionPeer::POLITICO_ID);
   			$c->add(PoliticoPeer::PARTIDO_ID, $partido->getId());
   			$instis = InstitucionPeer::doSelect($c);
	   		foreach ($instis as $insti){
			    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?partido=".$partido->getAbreviatura()."&institucion=".$insti->getVanity(), true), $culture);	    
		  		$pager = EntityManager::getPoliticos($partido->getAbreviatura(), $insti->getVanity(), $culture);
			    $idx = 1;
		  		while ($idx < $pager->getLastPage()){
		  			$idx++;
				    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?partido=".$partido->getAbreviatura()."&institucion=".$insti->getVanity() ."&page=$idx", true), $culture);
		   		}
	   		}
	    }

	    # ranking de polis filtrados por insti
   		$c = new Criteria();
   		$c->add(InstitucionPeer::IS_ACTIVE, true);
   		$instis = InstitucionPeer::doSelect($c);
   		foreach ($instis as $insti){
		    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?partido=all&institucion=".$insti->getVanity(), true), $culture);	    
	  		$pager = EntityManager::getPoliticos(false, $insti->getVanity(), $culture);
		    $idx = 1;
	  		while ($idx < $pager->getLastPage()){
	  			$idx++;
			    $this->writeToSitemap("politico-ranking-$culture", $controller->genUrl("politico/ranking?partido=all&institucion=".$insti->getVanity() ."&page=$idx", true), $culture);
	   		}
   		}

	    // **************** ranking PARTIDOS **********************
	    $this->writeToSitemap("partido-ranking-$culture", $controller->genUrl("partido/ranking", true), $culture);	    
  		$pager = EntityManager::getPartidos(false, $culture);
	    $idx = 1;
  		while ($idx < $pager->getLastPage()){
  			$idx++;
		    $this->writeToSitemap("partido-ranking-$culture", $controller->genUrl("partido/ranking?page=$idx", true), $culture);
   		}
   		$c = new Criteria();
   		$c->add(InstitucionPeer::IS_ACTIVE, true);
   		$instis = InstitucionPeer::doSelect($c);
   		foreach ($instis as $insti){
			$this->writeToSitemap("partido-ranking-$culture", $controller->genUrl("partido/ranking?institucion=".$insti->getVanity(), true), $culture);
	  		$pager = EntityManager::getPartidos($insti->getVanity(), $culture);
		    $idx = 1;
	  		while ($idx < $pager->getLastPage()){
	  			$idx++;
			    $this->writeToSitemap("partido-ranking-$culture", $controller->genUrl("partido/ranking?institucion=".$insti->getVanity()."&page=$idx", true), $culture);
	   		}
   		}
    	
	    // **************** elecciones **********************
	    $c = new Criteria();
	    $convocatorias = ConvocatoriaPeer::doSelect( $c );
	    foreach ($convocatorias as $convocatoria){
	    	$this->writeToSitemap("elecciones-$culture", $controller->genUrl('eleccion/show?vanity='.$convocatoria->getEleccion()->getVanity().'&convocatoria=' . $convocatoria->getNombre(), true), $culture);
	    	$used = array();
	    	foreach ($convocatoria->getListasJoinGeo() as $geoLista){
	    		if (!in_array($geoLista->getGeo(), $used)){
	    			$used[] = $geoLista->getGeo();
	    			$this->writeToSitemap("elecciones-$culture", $controller->genUrl('eleccion/show?geo='.$geoLista->getGeo()->getNombre().'&vanity='.$convocatoria->getEleccion()->getVanity().'&convocatoria=' . $convocatoria->getNombre(), true), $culture);
	    		}
	    		$this->writeToSitemap("elecciones-$culture", $controller->genUrl('lista/show?partido='.$geoLista->getPartido()->getAbreviatura().'&geo='.$geoLista->getGeo()->getNombre().'&vanity='.$convocatoria->getEleccion()->getVanity().'&convocatoria=' . $convocatoria->getNombre(), true), $culture);
	    		
	    	}
	    }
    //}
    
    $this->closeAll($culture);
  }
}
