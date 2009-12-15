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
class VoSparkline {	
	public static function paintPolitico( $id ) {
		$c = new Criteria();
  		$c->add(SfReviewTypeEntityPeer::ENTITY_ID, $id);
  		$c->add(SfReviewTypeEntityPeer::VALUE, 1);
  		$c->addAscendingOrderByColumn(SfReviewTypeEntityPeer::DATE);
  		$elements = SfReviewTypeEntityPeer::doSelect( $c );
		
		$sparkline = new Sparkline_Line();
		$sparkline->SetDebugLevel(DEBUG_NONE);
		$sparkline->SetColorHtml('background', '#e0e0e0');
		$sparkline->SetColorBackground('background');
		
		$i = 0;
		foreach ($elements as $element) {
			$i++;
			$sparkline->SetData($i, $element->getSum());
		}
		$sparkline->SetYMin(0);
		
		$sparkline->SetLineSize(4);
	  	$sparkline->RenderResampled(100, 15);
		
		$sparkline->Output();				
	}
}
