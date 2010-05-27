<?php

class VoBasePeer extends BasePeer
{

	/**
	 * Executes query build by createSelectSql() and returns the resultset statement.
	 *
	 * @param      Criteria $criteria A Criteria.
	 * @param      PropelPDO $con A PropelPDO connection to use.
	 * @return     PDOStatement The resultset.
	 * @throws     PropelException
	 * @see        createSelectSql()
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null, $forceIndex = false)
	{
		$dbMap = Propel::getDatabaseMap($criteria->getDbName());
		$db = Propel::getDB($criteria->getDbName());

		if ($con === null) {
			$con = Propel::getConnection($criteria->getDbName(), Propel::CONNECTION_READ);
		}

		$stmt = null;

		if ($criteria->isUseTransaction()) $con->beginTransaction();

		try {

			$params = array();
			$sql = self::createSelectSql($criteria, $params, $forceIndex);

			$stmt = $con->prepare($sql);

			self::populateStmtValues($stmt, $params, $dbMap, $db);

			$stmt->execute();

			if ($criteria->isUseTransaction()) $con->commit();

		} catch (Exception $e) {
			if ($stmt) $stmt = null; // close
			if ($criteria->isUseTransaction()) $con->rollBack();
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException($e);
		}

		return $stmt;
	}
	
	public static function createSelectSql(Criteria $criteria, &$params, $forceIndex = false)
	{
		$db = Propel::getDB($criteria->getDbName());
		$dbMap = Propel::getDatabaseMap($criteria->getDbName());

		// redundant definition $selectModifiers = array();
		$selectClause = array();
		$fromClause = array();
		$joinClause = array();
		$joinTables = array();
		$whereClause = array();
		$orderByClause = array();
		// redundant definition $groupByClause = array();

		$orderBy = $criteria->getOrderByColumns();
		$groupBy = $criteria->getGroupByColumns();
		$ignoreCase = $criteria->isIgnoreCase();
		$select = $criteria->getSelectColumns();
		$aliases = $criteria->getAsColumns();

		// simple copy
		$selectModifiers = $criteria->getSelectModifiers();

		// get selected columns
		foreach ($select as $columnName) {

			// expect every column to be of "table.column" formation
			// it could be a function:  e.g. MAX(books.price)

			$tableName = null;

			$selectClause[] = $columnName; // the full column name: e.g. MAX(books.price)

			$parenPos = strrpos($columnName, '(');
			$dotPos = strrpos($columnName, '.', ($parenPos !== false ? $parenPos : 0));

			// [HL] I think we really only want to worry about adding stuff to
			// the fromClause if this function has a TABLE.COLUMN in it at all.
			// e.g. COUNT(*) should not need this treatment -- or there needs to
			// be special treatment for '*'
			if ($dotPos !== false) {

				if ($parenPos === false) { // table.column
					$tableName = substr($columnName, 0, $dotPos);
				} else { // FUNC(table.column)
					$tableName = substr($columnName, $parenPos + 1, $dotPos - ($parenPos + 1));
					// functions may contain qualifiers so only take the last
					// word as the table name.
					// COUNT(DISTINCT books.price)
					$lastSpace = strpos($tableName, ' ');
					if ($lastSpace !== false) { // COUNT(DISTINCT books.price)
						$tableName = substr($tableName, $lastSpace + 1);
					}
				}
				$tableName2 = $criteria->getTableForAlias($tableName);
				if ($tableName2 !== null) {
					$fromClause[] = $tableName2 . ' ' . $tableName;
				} else {
					$fromClause[] = $tableName;
				}

			} // if $dotPost !== null
		}

		// set the aliases
		foreach ($aliases as $alias => $col) {
			$selectClause[] = $col . " AS " . $alias;
		}

		// add the criteria to WHERE clause
		// this will also add the table names to the FROM clause if they are not already
		// invluded via a LEFT JOIN
		foreach ($criteria->keys() as $key) {

			$criterion = $criteria->getCriterion($key);
			$someCriteria = $criterion->getAttachedCriterion();
			$someCriteriaLength = count($someCriteria);
			$table = null;
			for ($i=0; $i < $someCriteriaLength; $i++) {
				$tableName = $someCriteria[$i]->getTable();
				
				$table = $criteria->getTableForAlias($tableName);
				if ($table !== null) {
					$fromClause[] = $table . ' ' . $tableName;
				} else {
					$fromClause[] = $tableName;
					$table = $tableName;
				}

				$ignoreCase =
				(($criteria->isIgnoreCase()
				|| $someCriteria[$i]->isIgnoreCase())
				&& (strpos($dbMap->getTable($table)->getColumn($someCriteria[$i]->getColumn())->getType(), "VARCHAR") !== false)
				);

				$someCriteria[$i]->setIgnoreCase($ignoreCase);
			}

			$criterion->setDB($db);

			$sb = "";
			$criterion->appendPsTo($sb, $params);
			$whereClause[] = $sb;
		}

		// Handle joins
		// joins with a null join type will be added to the FROM clause and the condition added to the WHERE clause.
		// joins of a specified type: the LEFT side will be added to the fromClause and the RIGHT to the joinClause
		foreach ((array) $criteria->getJoins() as $join) { 
			// The join might have been established using an alias name
			$leftTable = $join->getLeftTableName();
			$leftTableAlias = '';
			if ($realTable = $criteria->getTableForAlias($leftTable)) {
				$leftTableAlias = " $leftTable";
				$leftTable = $realTable;
			}

			$rightTable = $join->getRightTableName();
			$rightTableAlias = '';
			if ($realTable = $criteria->getTableForAlias($rightTable)) {
				$rightTableAlias = " $rightTable";
				$rightTable = $realTable;
			}

			// determine if casing is relevant.
			if ($ignoreCase = $criteria->isIgnoreCase()) {
				$leftColType = $dbMap->getTable($leftTable)->getColumn($join->getLeftColumnName())->getType();
				$rightColType = $dbMap->getTable($rightTable)->getColumn($join->getRightColumnName())->getType();
				$ignoreCase = ($leftColType == 'string' || $rightColType == 'string');
			}

			// build the condition
			$condition = '';
			foreach ($join->getConditions() as $index => $conditionDesc)
			{
				if ($ignoreCase) {
					$condition .= $db->ignoreCase($conditionDesc['left']) . $conditionDesc['operator'] . $db->ignoreCase($conditionDesc['right']);
				} else {
					$condition .= implode($conditionDesc);
				}
				if ($index + 1 < $join->countConditions()) {
					$condition .= ' AND ';
				}
			}

			// add 'em to the queues..
			if ($joinType = $join->getJoinType()) {
			  // real join
				if (!$fromClause) {
					$fromClause[] = $leftTable . $leftTableAlias;
				}
				$joinTables[] = $rightTable . $rightTableAlias;
				$joinClause[] = $join->getJoinType() . ' ' . $rightTable . $rightTableAlias . " ON ($condition)";
			} else {
			  // implicit join, translates to a where
				$fromClause[] = $leftTable . $leftTableAlias;
				$fromClause[] = $rightTable . $rightTableAlias;
				$whereClause[] = $condition;
			}
		}

		// Unique from clause elements
		$fromClause = array_unique($fromClause);
		$fromClause = array_diff($fromClause, array(''));
		
		// tables should not exist in both the from and join clauses
		if ($joinTables && $fromClause) {
			foreach ($fromClause as $fi => $ftable) {
				if (in_array($ftable, $joinTables)) {
					unset($fromClause[$fi]);
				}
			}
		}

		// Add the GROUP BY columns
		$groupByClause = $groupBy;

		$having = $criteria->getHaving();
		$havingString = null;
		if ($having !== null) {
			$sb = "";
			$having->appendPsTo($sb, $params);
			$havingString = $sb;
		}

		if (!empty($orderBy)) {

			foreach ($orderBy as $orderByColumn) {

				// Add function expression as-is.

				if (strpos($orderByColumn, '(') !== false) {
					$orderByClause[] = $orderByColumn;
					continue;
				}

				// Split orderByColumn (i.e. "table.column DESC")

				$dotPos = strrpos($orderByColumn, '.');

				if ($dotPos !== false) {
					$tableName = substr($orderByColumn, 0, $dotPos);
					$columnName = substr($orderByColumn, $dotPos+1);
				}
				else {
					$tableName = '';
					$columnName = $orderByColumn;
				}

				$spacePos = strpos($columnName, ' ');

				if ($spacePos !== false) {
					$direction = substr($columnName, $spacePos);
					$columnName = substr($columnName, 0, $spacePos);
				}
				else {
					$direction = '';
				}

				$tableAlias = $tableName;
				if ($aliasTableName = $criteria->getTableForAlias($tableName)) {
					$tableName = $aliasTableName;
				}

				$columnAlias = $columnName;
				if ($asColumnName = $criteria->getColumnForAs($columnName)) {
					$columnName = $asColumnName;
				}

				$column = $tableName ? $dbMap->getTable($tableName)->getColumn($columnName) : null;

				if ($criteria->isIgnoreCase() && $column && $column->isText()) {
					$orderByClause[] = $db->ignoreCaseInOrderBy("$tableAlias.$columnAlias") . $direction;
					$selectClause[] = $db->ignoreCaseInOrderBy("$tableAlias.$columnAlias");
				} else {
					$orderByClause[] = $orderByColumn;
				}
			}
		}

		if (empty($fromClause) && $criteria->getPrimaryTableName()) {
			$fromClause[] = $criteria->getPrimaryTableName();
		}

		// from / join tables quoten if it is necessary
		if ($db->useQuoteIdentifier()) {
			$fromClause = array_map(array($db, 'quoteIdentifierTable'), $fromClause);
			
			// FORCE INDEX para orden necesario para Voota en rankingpoliticos 
			if ($forceIndex){
				$fromClause[0] .= " force INDEX ($forceIndex)";
			}
			
			$joinClause = $joinClause ? $joinClause : array_map(array($db, 'quoteIdentifierTable'), $joinClause);
		}

		// build from-clause
		$from = '';
		if (!empty($joinClause) && count($fromClause) > 1) {
			$from .= implode(" CROSS JOIN ", $fromClause);
		} else {
			$from .= implode(", ", $fromClause);
		}
		
		$from .= $joinClause ? ' ' . implode(' ', $joinClause) : '';

		// Build the SQL from the arrays we compiled
		$sql =  "SELECT "
		.($selectModifiers ? implode(" ", $selectModifiers) . " " : "")
		.implode(", ", $selectClause)
		." FROM "  . $from
		.($whereClause ? " WHERE ".implode(" AND ", $whereClause) : "")
		.($groupByClause ? " GROUP BY ".implode(",", $groupByClause) : "")
		.($havingString ? " HAVING ".$havingString : "")
		.($orderByClause ? " ORDER BY ".implode(",", $orderByClause) : "");

		// APPLY OFFSET & LIMIT to the query.
		if ($criteria->getLimit() || $criteria->getOffset()) {
			$db->applyLimit($sql, $criteria->getOffset(), $criteria->getLimit());
		}

		return $sql;
	}
	
		/**
	 * Executes a COUNT query using either a simple SQL rewrite or, for more complex queries, a
	 * sub-select of the SQL created by createSelectSql() and returns the statement.
	 *
	 * @param      Criteria $criteria A Criteria.
	 * @param      PropelPDO $con A PropelPDO connection to use.
	 * @return     PDOStatement The resultset statement.
	 * @throws     PropelException
	 * @see        createSelectSql()
	 */
	public static function doCount(Criteria $criteria, PropelPDO $con = null)
	{
		$dbMap = Propel::getDatabaseMap($criteria->getDbName());
		$db = Propel::getDB($criteria->getDbName());

		if ($con === null) {
			$con = Propel::getConnection($criteria->getDbName(), Propel::CONNECTION_READ);
		}

		$stmt = null;

		if ($criteria->isUseTransaction()) $con->beginTransaction();

		$needsComplexCount = ($criteria->getGroupByColumns() || $criteria->getOffset()
								|| $criteria->getLimit() || $criteria->getHaving() || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers()));

		try {

			$params = array();

			if ($needsComplexCount) {
				$selectSql = self::createSelectSql($criteria, $params);
				$sql = 'SELECT COUNT(*) FROM (' . $selectSql . ') AS propelmatch4cnt';
			} else {
				// Replace SELECT columns with COUNT(*)
				$criteria->clearSelectColumns()->addSelectColumn('COUNT(*)');
				$sql = self::createSelectSql($criteria, $params);
			}

			$stmt = $con->prepare($sql);
			self::populateStmtValues($stmt, $params, $dbMap, $db);
			$stmt->execute();

			if ($criteria->isUseTransaction()) $con->commit();

		} catch (Exception $e) {
			if ($stmt) $stmt = null; // close
			if ($criteria->isUseTransaction()) $con->rollBack();
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException($e);
		}

		return $stmt;
	}
	
}