<?php

class VoBasePeer extends BasePeer
{
  
	/**
	 * Method to create an SQL query based on values in a Criteria.
	 *
	 * This method creates only prepared statement SQL (using ? where values
	 * will go).  The second parameter ($params) stores the values that need
	 * to be set before the statement is executed.  The reason we do it this way
	 * is to let the PDO layer handle all escaping & value formatting.
	 *
	 * @param      Criteria $criteria Criteria for the SELECT query.
	 * @param      array &$params Parameters that are to be replaced in prepared statement.
	 * @return     string
	 * @throws     PropelException Trouble creating the query string.
	 */
	public static function createSelectSql(Criteria $criteria, &$params)
	{
		echo 1; die;
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
	
}