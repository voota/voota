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
class fixVanitiesCounterTask extends sfBaseTask
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
    $this->name             = 'fixVanitiesCounter';
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
    	# Los que acaban en -
    	if (preg_match("/(.*)([\-]+)$/is", $vanity, $matches, PREG_OFFSET_CAPTURE)) {
    	
   			if ($matches[2][0] != ''){
   				
   				#echo "politico:$vanity (".$matches[0][0].", ".$matches[1][0].", ".$matches[2][0].", ".$matches[3][0].")";
   				
   				
			    $vanityUrl = SfVoUtil::encodeVanity($matches[1][0]) ;
			    #echo "($vanityUrl)";
			    	
				$c2 = new Criteria();
				$c2->add(PoliticoPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
				$c2->add(PoliticoPeer::ID, $politico->getId(), Criteria::NOT_EQUAL);
				$politicosLikeMe = PoliticoPeer::doSelect( $c2 );
				$counter = 0;
				foreach ($politicosLikeMe as $politicoLikeMe){
					$counter++;
				}
				//$profile->setVanity( "$vanityUrl". ($counter==0?'':"-$counter") );
   				#echo "->". "$vanityUrl". ($counter==0?'':"-$counter") ."\n";
   				//if ($counter != 0){
   					echo "politico:$vanity (".$matches[0][0].", ".$matches[1][0].", ".$matches[2][0].")";
   					#echo "politico:$vanity (".$matches[0][0].", ".$matches[1][0].", ".$matches[2][0].", ".$matches[3][0].")";
   					echo "->". "$vanityUrl". ($counter==0?'':"-$counter") ."\n";
   					$politico->setVanity("$vanityUrl". ($counter==0?'':"-$counter") ."\n");
   					$politico->save();
   				//}
   			}
    	}
    	# Los que acaban en --n
    	if (preg_match("/(.*)--([0-9]*)$/is", $vanity, $matches, PREG_OFFSET_CAPTURE)) {
    	
   			if ($matches[2][0] != '' /*&& ($matches[3][0] == '' || ($matches[3][0] != '' && strlen($matches[2][0]) > 1))*/){
   				
   				#echo "politico:$vanity (".$matches[0][0].", ".$matches[1][0].", ".$matches[2][0].", ".$matches[3][0].")";
   				
   				
			    $vanityUrl = SfVoUtil::encodeVanity($matches[1][0]) ;
			    #echo "($vanityUrl)";
			    	
				$c2 = new Criteria();
				$c2->add(PoliticoPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
				$c2->add(PoliticoPeer::ID, $politico->getId(), Criteria::NOT_EQUAL);
				$politicosLikeMe = PoliticoPeer::doSelect( $c2 );
				$counter = 0;
				foreach ($politicosLikeMe as $politicoLikeMe){
					$counter++;
				}
				//$profile->setVanity( "$vanityUrl". ($counter==0?'':"-$counter") );
   				#echo "->". "$vanityUrl". ($counter==0?'':"-$counter") ."\n";
   					echo "politico:$vanity (".$matches[0][0].", ".$matches[1][0].", ".$matches[2][0].")";
   					#echo "politico:$vanity (".$matches[0][0].", ".$matches[1][0].", ".$matches[2][0].", ".$matches[3][0].")";
   					echo "->". "$vanityUrl". ($counter==0?'':"-$counter") ."\n";
   					$politico->setVanity("$vanityUrl". ($counter==0?'':"-$counter") ."\n");
   					$politico->save();
   			}
    	}
    		
    }
  }
}
