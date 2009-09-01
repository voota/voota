<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__).'/../lib/politicoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/politicoGeneratorHelper.class.php';

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class politicoActions extends autoPoliticoActions
{
	
	public function executeEdit(sfWebRequest $request) {
		$imageFileName = getcwd().'/uploads/politicos/'.$this->getRoute()->getObject()->getImagen();
		if (file_exists($imageFileName)){
			$img = new sfImage( $imageFileName );
			$img->voota( $imageFileName );
		}
		
		parent::executeEdit( $request );
	}
}
