<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * pager funcitnos
 *
 * @package    Voota
 * @subpackage helper
 * @author     Sergio Viteri
 * @version    SVN: $Id: NumberHelper.php
 */
use_helper('Number');

function numberFormat( $number, $culture = 'es_ES' ) {
  	return format_number( $number );
}

function currentIndex( $pager, $id ) {
	$ret = false;
	$idx = 0;
	foreach ($pager->getResults() as $entity){
		$idx++;
		if ($entity->getId() == $id){
			$ret = ($pager->getPage()-1)*$pager->getMaxPerPage() + $idx;
		}
	}
  	return $ret;
}
function prevEntity( $pager, $id, &$page = 0 ) {
	$ret = false;
	$prev = false;
	$idx = 0;
	foreach ($pager->getResults() as $entity){
		if ($entity->getId() == $id){
			$ret = $prev;
		}
		$prev = $entity;
	}
	if (!$ret && $entity && $pager->getPage() > 1){
		$page = -1;
		$pager->setPage($pager->getPage()-1);
		$pager->init();
		$pager->setCursor( $pager->getLastIndice() );
		$ret = $pager->getCurrent();
		$pager->setPage($pager->getPage()+1);
		$pager->init();
	}
  	return $ret;
}
function nextEntity( $pager, $id, &$page = 0 ) {
	$ret = false;
	$next = false;
	$flag = false;
	foreach ($pager->getResults() as $entity){
		if ($flag){
			$ret = $entity;
			$flag = false;
		}
		if ($entity->getId() == $id){
			$flag = true;
		}
	}
	if (!$ret && $flag && $pager->getPage() < $pager->getLastPage()){
		$page = 1;
		$pager->setPage($pager->getPage()+1);
		$pager->init();
		$ret = $pager->getResults();
		$ret = $ret[0];
		$pager->setPage($pager->getPage()-1);
		$pager->init();
	}
  	return $ret;
}
function filteredBy( ) {
	$ret = '';
	$filter = sfcontext::getInstance()->getUser()->getAttribute('filter', false);
	if ($filter){
		$ret .= $filter['partido']=='0'||$filter['partido']=='all'?'':$filter['partido'];
		$ret .= ($ret && $filter['institucion']!='0')?', ':'';
		$ret .= $filter['institucion']=='0'?'':$filter['institucion'];
		if ($ret)
			$ret = "($ret)";
	}
	return $ret;
}
function orderedBy( ) {
	$ret = '';
	$filter = sfcontext::getInstance()->getUser()->getAttribute('filter', false);
	if ($filter){
		switch($filter['order']){
			case 'pa':
				$ret = __('votos positivos ascendente');
				break;
			case 'na':
				$ret = __('votos negativos ascendente');
				break;
			case 'nd':
				$ret = __('votos negativos descendente');
				break;
			case 'pd':
			default:
				$ret = __('votos positivos descendente');
		}
	}
	
	return $ret;
}
function rankingParams( ) {
	$ret = '';
	$filter = sfcontext::getInstance()->getUser()->getAttribute('filter', false);
	
	if ($filter['partido'] != '0' && $filter['partido'] != 'all'){
		$ret .= '?partido='.$filter['partido'];
	}
	if ($filter['institucion'] != '0' && $filter['institucion'] != 'all'){
		if (!$ret)
			$ret = '?partido=all';
		$ret .= ($ret?'&':'?').'institucion='.$filter['institucion'];
	}
	if ($filter['order'] != ''){
		$ret .= ($ret?'&':'?').'o='.$filter['order'];
	}
	return $ret;
}