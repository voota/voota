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
class fixVanitiesTask extends sfBaseTask
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
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'fixVanities';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [updateImages|INFO] task does things.
Call it with:

  [php symfony updateImages|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $c = new Criteria();
    //$c->add(PoliticoPeer::ID, 1, Criteria::EQUAL);
    $politicos = PoliticoPeer::doSelect( $c );
    foreach ($politicos as $politico){
    		
    		$vanity = $politico->getVanity();
    		if ($vanity != ($new = SfVoUtil::fixVanityChars($vanity))){
				while (preg_match("/(.*)-$/is", $new, $m, PREG_OFFSET_CAPTURE)) {
					$new = $m[1][0];
				}
    			$c2 = new Criteria();
		    	$c2->add(PoliticoPeer::VANITY, "$new%", Criteria::LIKE);
		    	$c2->add(PoliticoPeer::ID, $politico->getId(), Criteria::NOT_EQUAL);
		    	$politicosLikeMe = PoliticoPeer::doSelect( $c2 );
		    	$counter = 0;
    			foreach ($politicosLikeMe as $politicoLikeMe){
    				$aVanity = str_replace("-", "\-", $new);
    			
    				if (preg_match(SfVoUtil::voDecode("/^$new\-([0-9]*)$/is"), SfVoUtil::voDecode($politicoLikeMe->getVanity()), $matches)) {
    					if ($counter < (1 + $matches[1])){
    						$counter = 1 + $matches[1];	
    					}
    					else {
    						$counter++;
    					}
    				}
    				else {
    					$counter++;
    				}
    			}
    			$new = "$new". ($counter==0?'':"-$counter");
    			echo "politico:$vanity ";    			
    			echo "cambia a:$new\n";
    			$politico->setVanity( $new );
    			$politico->save();
    		}
    		
    }
    $usuarios = SfGuardUserPeer::doSelect( $c );
    foreach ($usuarios as $usuario){
    		
    		$vanity = $usuario->getProfile()->getVanity();
    		if ($vanity != SfVoUtil::fixVanityChars($vanity)){
    			echo "usuario:$vanity ($usuario)\n";
    			
	    		$usuario->getProfile()->setVanity(SfVoUtil::fixVanityChars($vanity));
	    		$usuario->getProfile()->save();
    		}
    }
    $partidos = PartidoPeer::doSelect( $c );
    foreach ($partidos as $partido){
    		
    		$vanity = $partido->getAbreviatura();
    		if ($vanity != SfVoUtil::fixVanityChars($vanity)){
    			echo "partido:$vanity\n";
    		}
    }
    
    // Instituciones
    $instituciones = InstitucionI18nPeer::doSelect( $c );
    foreach ($instituciones as $institucion){
    		
    		$vanity = $institucion->getVanity();
    		if ($vanity != ($new = SfVoUtil::fixVanityChars($vanity))){
    			echo "institucion:$vanity\n";
    			$institucion->setVanity( $new );
    			$institucion->save();
    			echo "cambia a:$new\n";
    		}
    }
  }
}
