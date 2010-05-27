<?php

class PoliticoRankingPeer extends PoliticoPeer
{

	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(PoliticoRankingPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			PoliticoRankingPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return VoBasePeer::doSelect($criteria, $con, 'politico_ranking');
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return PoliticoRankingPeer::populateObjects(PoliticoRankingPeer::doSelectStmt($criteria, $con));
	}
	
	
	

	
}
