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
	public static function paint () {
		if (!isset($_GET['s']) ||
		    !eregi('^[a-z\^]{1,5}$', $_GET['s'])) {
		  die('bad ticker ' . $_GET['s']);
		}
		
		if (!isset($_GET['y']) ||
		    !is_numeric($_GET['y']) ||
		    $_GET['y'] > 5 ||
		    $_GET['y'] < 0) {
		  die('bad year ' . $_GET['y']);
		}
		
		//////////////////////////////////////////////////////////////////////////////
		// load and process data from Yahoo! ichart csv source
		//
		$m  = date('n') - 1;
		$d  = date('d');
		$y2 = date('Y');
		$y1 = $y2 - $_GET['y'];
		
		// data sample:
		//   0        1     2     3     4     5        6
		//   Date,Open,High,Low,Close,Volume,Adj. Close*
		//   5-Nov-04,29.21,29.36,29.03,29.31,95337696,29.31
		//
		$url = "http://ichart.finance.yahoo.com/table.csv?s=" . $_GET['s'] . "&a=$m&b=$d&c=$y1&d=$m&e=$d&f=$y2&g=d&ignore=.csv";
		if (!$data = @file($url)) {
		  die('error fetching stock data; verify ticker symbol');
		}
		
		//////////////////////////////////////////////////////////////////////////////
		// build sparkline using standard flow:
		//   construct, set, render, output
		//
		//require_once('../lib/Sparkline_Line.php');
		
		$sparkline = new Sparkline_Line();
		$sparkline->SetDebugLevel(DEBUG_NONE);
		//$sparkline->SetDebugLevel(DEBUG_ERROR | DEBUG_WARNING | DEBUG_STATS | DEBUG_CALLS, '../log.txt');
		
		if (isset($_GET['b'])) {
		  $sparkline->SetColorHtml('background', '#e0e0e0');
		  $sparkline->SetColorBackground('background');
		}
		
		$data = array_reverse($data);
		$i = 0;
		while (list(, $v) = each($data)) {
		  $elements = explode(',', $v);
		  if (ereg('^[0-9\.]+$', trim($elements[6]))) {
		    $sparkline->SetData($i, $elements[6]);
		    $i++;
		  }
		}
		
		$sparkline->SetYMin(0);
		
		if (isset($_GET['m']) &&
		    $_GET['m'] == '0') {
		  $sparkline->Render(100, 15);
		} else {
		  $sparkline->SetLineSize(6); // for renderresampled, linesize is on virtual image
		  $sparkline->RenderResampled(100, 15);
		}
		
		$sparkline->Output();				
	}
}
