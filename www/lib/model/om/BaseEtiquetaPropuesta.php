<?php

/**
 * Base class that represents a row from the 'etiqueta_propuesta' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue Jun 29 14:16:48 2010
 *
 * @package    lib.model.om
 */
abstract class BaseEtiquetaPropuesta extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EtiquetaPropuestaPeer
	 */
	protected static $peer;

	/**
	 * The value for the etiqueta_id field.
	 * @var        int
	 */
	protected $etiqueta_id;

	/**
	 * The value for the propuesta_id field.
	 * @var        int
	 */
	protected $propuesta_id;

	/**
	 * The value for the culture field.
	 * @var        string
	 */
	protected $culture;

	/**
	 * The value for the sf_guard_user_id field.
	 * @var        int
	 */
	protected $sf_guard_user_id;

	/**
	 * The value for the fecha field.
	 * @var        string
	 */
	protected $fecha;

	/**
	 * @var        Etiqueta
	 */
	protected $aEtiqueta;

	/**
	 * @var        Propuesta
	 */
	protected $aPropuesta;

	/**
	 * @var        sfGuardUser
	 */
	protected $asfGuardUser;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'EtiquetaPropuestaPeer';

	/**
	 * Get the [etiqueta_id] column value.
	 * 
	 * @return     int
	 */
	public function getEtiquetaId()
	{
		return $this->etiqueta_id;
	}

	/**
	 * Get the [propuesta_id] column value.
	 * 
	 * @return     int
	 */
	public function getPropuestaId()
	{
		return $this->propuesta_id;
	}

	/**
	 * Get the [culture] column value.
	 * 
	 * @return     string
	 */
	public function getCulture()
	{
		return $this->culture;
	}

	/**
	 * Get the [sf_guard_user_id] column value.
	 * 
	 * @return     int
	 */
	public function getSfGuardUserId()
	{
		return $this->sf_guard_user_id;
	}

	/**
	 * Get the [optionally formatted] temporal [fecha] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getFecha($format = 'Y-m-d H:i:s')
	{
		if ($this->fecha === null) {
			return null;
		}


		if ($this->fecha === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->fecha);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->fecha, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [etiqueta_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 */
	public function setEtiquetaId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->etiqueta_id !== $v) {
			$this->etiqueta_id = $v;
			$this->modifiedColumns[] = EtiquetaPropuestaPeer::ETIQUETA_ID;
		}

		if ($this->aEtiqueta !== null && $this->aEtiqueta->getId() !== $v) {
			$this->aEtiqueta = null;
		}

		return $this;
	} // setEtiquetaId()

	/**
	 * Set the value of [propuesta_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 */
	public function setPropuestaId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->propuesta_id !== $v) {
			$this->propuesta_id = $v;
			$this->modifiedColumns[] = EtiquetaPropuestaPeer::PROPUESTA_ID;
		}

		if ($this->aPropuesta !== null && $this->aPropuesta->getId() !== $v) {
			$this->aPropuesta = null;
		}

		return $this;
	} // setPropuestaId()

	/**
	 * Set the value of [culture] column.
	 * 
	 * @param      string $v new value
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 */
	public function setCulture($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->culture !== $v) {
			$this->culture = $v;
			$this->modifiedColumns[] = EtiquetaPropuestaPeer::CULTURE;
		}

		return $this;
	} // setCulture()

	/**
	 * Set the value of [sf_guard_user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 */
	public function setSfGuardUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sf_guard_user_id !== $v) {
			$this->sf_guard_user_id = $v;
			$this->modifiedColumns[] = EtiquetaPropuestaPeer::SF_GUARD_USER_ID;
		}

		if ($this->asfGuardUser !== null && $this->asfGuardUser->getId() !== $v) {
			$this->asfGuardUser = null;
		}

		return $this;
	} // setSfGuardUserId()

	/**
	 * Sets the value of [fecha] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 */
	public function setFecha($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->fecha !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->fecha !== null && $tmpDt = new DateTime($this->fecha)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->fecha = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = EtiquetaPropuestaPeer::FECHA;
			}
		} // if either are not null

		return $this;
	} // setFecha()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->etiqueta_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->propuesta_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->culture = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->sf_guard_user_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->fecha = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 5; // 5 = EtiquetaPropuestaPeer::NUM_COLUMNS - EtiquetaPropuestaPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating EtiquetaPropuesta object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aEtiqueta !== null && $this->etiqueta_id !== $this->aEtiqueta->getId()) {
			$this->aEtiqueta = null;
		}
		if ($this->aPropuesta !== null && $this->propuesta_id !== $this->aPropuesta->getId()) {
			$this->aPropuesta = null;
		}
		if ($this->asfGuardUser !== null && $this->sf_guard_user_id !== $this->asfGuardUser->getId()) {
			$this->asfGuardUser = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EtiquetaPropuestaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EtiquetaPropuestaPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aEtiqueta = null;
			$this->aPropuesta = null;
			$this->asfGuardUser = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EtiquetaPropuestaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEtiquetaPropuesta:delete:pre') as $callable)
			{
			  if ($ret = call_user_func($callable, $this, $con))
			  {
			    return;
			  }
			}

			if ($ret) {
				EtiquetaPropuestaPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEtiquetaPropuesta:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EtiquetaPropuestaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEtiquetaPropuesta:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEtiquetaPropuesta:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EtiquetaPropuestaPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aEtiqueta !== null) {
				if ($this->aEtiqueta->isModified() || $this->aEtiqueta->isNew()) {
					$affectedRows += $this->aEtiqueta->save($con);
				}
				$this->setEtiqueta($this->aEtiqueta);
			}

			if ($this->aPropuesta !== null) {
				if ($this->aPropuesta->isModified() || $this->aPropuesta->isNew()) {
					$affectedRows += $this->aPropuesta->save($con);
				}
				$this->setPropuesta($this->aPropuesta);
			}

			if ($this->asfGuardUser !== null) {
				if ($this->asfGuardUser->isModified() || $this->asfGuardUser->isNew()) {
					$affectedRows += $this->asfGuardUser->save($con);
				}
				$this->setsfGuardUser($this->asfGuardUser);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EtiquetaPropuestaPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += EtiquetaPropuestaPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aEtiqueta !== null) {
				if (!$this->aEtiqueta->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aEtiqueta->getValidationFailures());
				}
			}

			if ($this->aPropuesta !== null) {
				if (!$this->aPropuesta->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPropuesta->getValidationFailures());
				}
			}

			if ($this->asfGuardUser !== null) {
				if (!$this->asfGuardUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardUser->getValidationFailures());
				}
			}


			if (($retval = EtiquetaPropuestaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EtiquetaPropuestaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getEtiquetaId();
				break;
			case 1:
				return $this->getPropuestaId();
				break;
			case 2:
				return $this->getCulture();
				break;
			case 3:
				return $this->getSfGuardUserId();
				break;
			case 4:
				return $this->getFecha();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = EtiquetaPropuestaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getEtiquetaId(),
			$keys[1] => $this->getPropuestaId(),
			$keys[2] => $this->getCulture(),
			$keys[3] => $this->getSfGuardUserId(),
			$keys[4] => $this->getFecha(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EtiquetaPropuestaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setEtiquetaId($value);
				break;
			case 1:
				$this->setPropuestaId($value);
				break;
			case 2:
				$this->setCulture($value);
				break;
			case 3:
				$this->setSfGuardUserId($value);
				break;
			case 4:
				$this->setFecha($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EtiquetaPropuestaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setEtiquetaId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPropuestaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCulture($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSfGuardUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFecha($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EtiquetaPropuestaPeer::DATABASE_NAME);

		if ($this->isColumnModified(EtiquetaPropuestaPeer::ETIQUETA_ID)) $criteria->add(EtiquetaPropuestaPeer::ETIQUETA_ID, $this->etiqueta_id);
		if ($this->isColumnModified(EtiquetaPropuestaPeer::PROPUESTA_ID)) $criteria->add(EtiquetaPropuestaPeer::PROPUESTA_ID, $this->propuesta_id);
		if ($this->isColumnModified(EtiquetaPropuestaPeer::CULTURE)) $criteria->add(EtiquetaPropuestaPeer::CULTURE, $this->culture);
		if ($this->isColumnModified(EtiquetaPropuestaPeer::SF_GUARD_USER_ID)) $criteria->add(EtiquetaPropuestaPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);
		if ($this->isColumnModified(EtiquetaPropuestaPeer::FECHA)) $criteria->add(EtiquetaPropuestaPeer::FECHA, $this->fecha);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(EtiquetaPropuestaPeer::DATABASE_NAME);

		$criteria->add(EtiquetaPropuestaPeer::ETIQUETA_ID, $this->etiqueta_id);
		$criteria->add(EtiquetaPropuestaPeer::PROPUESTA_ID, $this->propuesta_id);
		$criteria->add(EtiquetaPropuestaPeer::CULTURE, $this->culture);
		$criteria->add(EtiquetaPropuestaPeer::SF_GUARD_USER_ID, $this->sf_guard_user_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getEtiquetaId();

		$pks[1] = $this->getPropuestaId();

		$pks[2] = $this->getCulture();

		$pks[3] = $this->getSfGuardUserId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setEtiquetaId($keys[0]);

		$this->setPropuestaId($keys[1]);

		$this->setCulture($keys[2]);

		$this->setSfGuardUserId($keys[3]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of EtiquetaPropuesta (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setEtiquetaId($this->etiqueta_id);

		$copyObj->setPropuestaId($this->propuesta_id);

		$copyObj->setCulture($this->culture);

		$copyObj->setSfGuardUserId($this->sf_guard_user_id);

		$copyObj->setFecha($this->fecha);


		$copyObj->setNew(true);

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     EtiquetaPropuesta Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     EtiquetaPropuestaPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EtiquetaPropuestaPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Etiqueta object.
	 *
	 * @param      Etiqueta $v
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setEtiqueta(Etiqueta $v = null)
	{
		if ($v === null) {
			$this->setEtiquetaId(NULL);
		} else {
			$this->setEtiquetaId($v->getId());
		}

		$this->aEtiqueta = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Etiqueta object, it will not be re-added.
		if ($v !== null) {
			$v->addEtiquetaPropuesta($this);
		}

		return $this;
	}


	/**
	 * Get the associated Etiqueta object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Etiqueta The associated Etiqueta object.
	 * @throws     PropelException
	 */
	public function getEtiqueta(PropelPDO $con = null)
	{
		if ($this->aEtiqueta === null && ($this->etiqueta_id !== null)) {
			$this->aEtiqueta = EtiquetaPeer::retrieveByPk($this->etiqueta_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aEtiqueta->addEtiquetaPropuestas($this);
			 */
		}
		return $this->aEtiqueta;
	}

	/**
	 * Declares an association between this object and a Propuesta object.
	 *
	 * @param      Propuesta $v
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPropuesta(Propuesta $v = null)
	{
		if ($v === null) {
			$this->setPropuestaId(NULL);
		} else {
			$this->setPropuestaId($v->getId());
		}

		$this->aPropuesta = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Propuesta object, it will not be re-added.
		if ($v !== null) {
			$v->addEtiquetaPropuesta($this);
		}

		return $this;
	}


	/**
	 * Get the associated Propuesta object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Propuesta The associated Propuesta object.
	 * @throws     PropelException
	 */
	public function getPropuesta(PropelPDO $con = null)
	{
		if ($this->aPropuesta === null && ($this->propuesta_id !== null)) {
			$this->aPropuesta = PropuestaPeer::retrieveByPk($this->propuesta_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPropuesta->addEtiquetaPropuestas($this);
			 */
		}
		return $this->aPropuesta;
	}

	/**
	 * Declares an association between this object and a sfGuardUser object.
	 *
	 * @param      sfGuardUser $v
	 * @return     EtiquetaPropuesta The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setsfGuardUser(sfGuardUser $v = null)
	{
		if ($v === null) {
			$this->setSfGuardUserId(NULL);
		} else {
			$this->setSfGuardUserId($v->getId());
		}

		$this->asfGuardUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the sfGuardUser object, it will not be re-added.
		if ($v !== null) {
			$v->addEtiquetaPropuesta($this);
		}

		return $this;
	}


	/**
	 * Get the associated sfGuardUser object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     sfGuardUser The associated sfGuardUser object.
	 * @throws     PropelException
	 */
	public function getsfGuardUser(PropelPDO $con = null)
	{
		if ($this->asfGuardUser === null && ($this->sf_guard_user_id !== null)) {
			$this->asfGuardUser = sfGuardUserPeer::retrieveByPk($this->sf_guard_user_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->asfGuardUser->addEtiquetaPropuestas($this);
			 */
		}
		return $this->asfGuardUser;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aEtiqueta = null;
			$this->aPropuesta = null;
			$this->asfGuardUser = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseEtiquetaPropuesta:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEtiquetaPropuesta::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEtiquetaPropuesta
