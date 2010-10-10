<?php

/**
 * Base class that represents a row from the 'lista_calle' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Sun Oct 10 23:35:40 2010
 *
 * @package    lib.model.om
 */
abstract class BaseListaCalle extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ListaCallePeer
	 */
	protected static $peer;

	/**
	 * The value for the convocatoria_id field.
	 * @var        int
	 */
	protected $convocatoria_id;

	/**
	 * The value for the partido_id field.
	 * @var        int
	 */
	protected $partido_id;

	/**
	 * The value for the politico_id field.
	 * @var        int
	 */
	protected $politico_id;

	/**
	 * The value for the circunscripcion_id field.
	 * @var        int
	 */
	protected $circunscripcion_id;

	/**
	 * The value for the sumu field.
	 * @var        int
	 */
	protected $sumu;

	/**
	 * The value for the sumd field.
	 * @var        int
	 */
	protected $sumd;

	/**
	 * @var        Convocatoria
	 */
	protected $aConvocatoria;

	/**
	 * @var        Partido
	 */
	protected $aPartido;

	/**
	 * @var        Politico
	 */
	protected $aPolitico;

	/**
	 * @var        Circunscripcion
	 */
	protected $aCircunscripcion;

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
	
	const PEER = 'ListaCallePeer';

	/**
	 * Get the [convocatoria_id] column value.
	 * 
	 * @return     int
	 */
	public function getConvocatoriaId()
	{
		return $this->convocatoria_id;
	}

	/**
	 * Get the [partido_id] column value.
	 * 
	 * @return     int
	 */
	public function getPartidoId()
	{
		return $this->partido_id;
	}

	/**
	 * Get the [politico_id] column value.
	 * 
	 * @return     int
	 */
	public function getPoliticoId()
	{
		return $this->politico_id;
	}

	/**
	 * Get the [circunscripcion_id] column value.
	 * 
	 * @return     int
	 */
	public function getCircunscripcionId()
	{
		return $this->circunscripcion_id;
	}

	/**
	 * Get the [sumu] column value.
	 * 
	 * @return     int
	 */
	public function getSumu()
	{
		return $this->sumu;
	}

	/**
	 * Get the [sumd] column value.
	 * 
	 * @return     int
	 */
	public function getSumd()
	{
		return $this->sumd;
	}

	/**
	 * Set the value of [convocatoria_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ListaCalle The current object (for fluent API support)
	 */
	public function setConvocatoriaId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->convocatoria_id !== $v) {
			$this->convocatoria_id = $v;
			$this->modifiedColumns[] = ListaCallePeer::CONVOCATORIA_ID;
		}

		if ($this->aConvocatoria !== null && $this->aConvocatoria->getId() !== $v) {
			$this->aConvocatoria = null;
		}

		return $this;
	} // setConvocatoriaId()

	/**
	 * Set the value of [partido_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ListaCalle The current object (for fluent API support)
	 */
	public function setPartidoId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->partido_id !== $v) {
			$this->partido_id = $v;
			$this->modifiedColumns[] = ListaCallePeer::PARTIDO_ID;
		}

		if ($this->aPartido !== null && $this->aPartido->getId() !== $v) {
			$this->aPartido = null;
		}

		return $this;
	} // setPartidoId()

	/**
	 * Set the value of [politico_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ListaCalle The current object (for fluent API support)
	 */
	public function setPoliticoId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->politico_id !== $v) {
			$this->politico_id = $v;
			$this->modifiedColumns[] = ListaCallePeer::POLITICO_ID;
		}

		if ($this->aPolitico !== null && $this->aPolitico->getId() !== $v) {
			$this->aPolitico = null;
		}

		return $this;
	} // setPoliticoId()

	/**
	 * Set the value of [circunscripcion_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ListaCalle The current object (for fluent API support)
	 */
	public function setCircunscripcionId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->circunscripcion_id !== $v) {
			$this->circunscripcion_id = $v;
			$this->modifiedColumns[] = ListaCallePeer::CIRCUNSCRIPCION_ID;
		}

		if ($this->aCircunscripcion !== null && $this->aCircunscripcion->getId() !== $v) {
			$this->aCircunscripcion = null;
		}

		return $this;
	} // setCircunscripcionId()

	/**
	 * Set the value of [sumu] column.
	 * 
	 * @param      int $v new value
	 * @return     ListaCalle The current object (for fluent API support)
	 */
	public function setSumu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sumu !== $v) {
			$this->sumu = $v;
			$this->modifiedColumns[] = ListaCallePeer::SUMU;
		}

		return $this;
	} // setSumu()

	/**
	 * Set the value of [sumd] column.
	 * 
	 * @param      int $v new value
	 * @return     ListaCalle The current object (for fluent API support)
	 */
	public function setSumd($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sumd !== $v) {
			$this->sumd = $v;
			$this->modifiedColumns[] = ListaCallePeer::SUMD;
		}

		return $this;
	} // setSumd()

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

			$this->convocatoria_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->partido_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->politico_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->circunscripcion_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->sumu = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->sumd = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = ListaCallePeer::NUM_COLUMNS - ListaCallePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating ListaCalle object", $e);
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

		if ($this->aConvocatoria !== null && $this->convocatoria_id !== $this->aConvocatoria->getId()) {
			$this->aConvocatoria = null;
		}
		if ($this->aPartido !== null && $this->partido_id !== $this->aPartido->getId()) {
			$this->aPartido = null;
		}
		if ($this->aPolitico !== null && $this->politico_id !== $this->aPolitico->getId()) {
			$this->aPolitico = null;
		}
		if ($this->aCircunscripcion !== null && $this->circunscripcion_id !== $this->aCircunscripcion->getId()) {
			$this->aCircunscripcion = null;
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
			$con = Propel::getConnection(ListaCallePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = ListaCallePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aConvocatoria = null;
			$this->aPartido = null;
			$this->aPolitico = null;
			$this->aCircunscripcion = null;
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
			$con = Propel::getConnection(ListaCallePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseListaCalle:delete:pre') as $callable)
			{
			  if ($ret = call_user_func($callable, $this, $con))
			  {
			    return;
			  }
			}

			if ($ret) {
				ListaCallePeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseListaCalle:delete:post') as $callable)
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
			$con = Propel::getConnection(ListaCallePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseListaCalle:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseListaCalle:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				ListaCallePeer::addInstanceToPool($this);
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

			if ($this->aConvocatoria !== null) {
				if ($this->aConvocatoria->isModified() || $this->aConvocatoria->isNew()) {
					$affectedRows += $this->aConvocatoria->save($con);
				}
				$this->setConvocatoria($this->aConvocatoria);
			}

			if ($this->aPartido !== null) {
				if ($this->aPartido->isModified() || $this->aPartido->isNew()) {
					$affectedRows += $this->aPartido->save($con);
				}
				$this->setPartido($this->aPartido);
			}

			if ($this->aPolitico !== null) {
				if ($this->aPolitico->isModified() || $this->aPolitico->isNew()) {
					$affectedRows += $this->aPolitico->save($con);
				}
				$this->setPolitico($this->aPolitico);
			}

			if ($this->aCircunscripcion !== null) {
				if ($this->aCircunscripcion->isModified() || $this->aCircunscripcion->isNew()) {
					$affectedRows += $this->aCircunscripcion->save($con);
				}
				$this->setCircunscripcion($this->aCircunscripcion);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ListaCallePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += ListaCallePeer::doUpdate($this, $con);
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

			if ($this->aConvocatoria !== null) {
				if (!$this->aConvocatoria->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aConvocatoria->getValidationFailures());
				}
			}

			if ($this->aPartido !== null) {
				if (!$this->aPartido->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPartido->getValidationFailures());
				}
			}

			if ($this->aPolitico !== null) {
				if (!$this->aPolitico->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPolitico->getValidationFailures());
				}
			}

			if ($this->aCircunscripcion !== null) {
				if (!$this->aCircunscripcion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCircunscripcion->getValidationFailures());
				}
			}


			if (($retval = ListaCallePeer::doValidate($this, $columns)) !== true) {
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
		$pos = ListaCallePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getConvocatoriaId();
				break;
			case 1:
				return $this->getPartidoId();
				break;
			case 2:
				return $this->getPoliticoId();
				break;
			case 3:
				return $this->getCircunscripcionId();
				break;
			case 4:
				return $this->getSumu();
				break;
			case 5:
				return $this->getSumd();
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
		$keys = ListaCallePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getConvocatoriaId(),
			$keys[1] => $this->getPartidoId(),
			$keys[2] => $this->getPoliticoId(),
			$keys[3] => $this->getCircunscripcionId(),
			$keys[4] => $this->getSumu(),
			$keys[5] => $this->getSumd(),
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
		$pos = ListaCallePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setConvocatoriaId($value);
				break;
			case 1:
				$this->setPartidoId($value);
				break;
			case 2:
				$this->setPoliticoId($value);
				break;
			case 3:
				$this->setCircunscripcionId($value);
				break;
			case 4:
				$this->setSumu($value);
				break;
			case 5:
				$this->setSumd($value);
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
		$keys = ListaCallePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setConvocatoriaId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPartidoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPoliticoId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCircunscripcionId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSumu($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSumd($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ListaCallePeer::DATABASE_NAME);

		if ($this->isColumnModified(ListaCallePeer::CONVOCATORIA_ID)) $criteria->add(ListaCallePeer::CONVOCATORIA_ID, $this->convocatoria_id);
		if ($this->isColumnModified(ListaCallePeer::PARTIDO_ID)) $criteria->add(ListaCallePeer::PARTIDO_ID, $this->partido_id);
		if ($this->isColumnModified(ListaCallePeer::POLITICO_ID)) $criteria->add(ListaCallePeer::POLITICO_ID, $this->politico_id);
		if ($this->isColumnModified(ListaCallePeer::CIRCUNSCRIPCION_ID)) $criteria->add(ListaCallePeer::CIRCUNSCRIPCION_ID, $this->circunscripcion_id);
		if ($this->isColumnModified(ListaCallePeer::SUMU)) $criteria->add(ListaCallePeer::SUMU, $this->sumu);
		if ($this->isColumnModified(ListaCallePeer::SUMD)) $criteria->add(ListaCallePeer::SUMD, $this->sumd);

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
		$criteria = new Criteria(ListaCallePeer::DATABASE_NAME);

		$criteria->add(ListaCallePeer::CONVOCATORIA_ID, $this->convocatoria_id);
		$criteria->add(ListaCallePeer::PARTIDO_ID, $this->partido_id);
		$criteria->add(ListaCallePeer::POLITICO_ID, $this->politico_id);
		$criteria->add(ListaCallePeer::CIRCUNSCRIPCION_ID, $this->circunscripcion_id);

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

		$pks[0] = $this->getConvocatoriaId();

		$pks[1] = $this->getPartidoId();

		$pks[2] = $this->getPoliticoId();

		$pks[3] = $this->getCircunscripcionId();

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

		$this->setConvocatoriaId($keys[0]);

		$this->setPartidoId($keys[1]);

		$this->setPoliticoId($keys[2]);

		$this->setCircunscripcionId($keys[3]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ListaCalle (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setConvocatoriaId($this->convocatoria_id);

		$copyObj->setPartidoId($this->partido_id);

		$copyObj->setPoliticoId($this->politico_id);

		$copyObj->setCircunscripcionId($this->circunscripcion_id);

		$copyObj->setSumu($this->sumu);

		$copyObj->setSumd($this->sumd);


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
	 * @return     ListaCalle Clone of current object.
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
	 * @return     ListaCallePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ListaCallePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Convocatoria object.
	 *
	 * @param      Convocatoria $v
	 * @return     ListaCalle The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setConvocatoria(Convocatoria $v = null)
	{
		if ($v === null) {
			$this->setConvocatoriaId(NULL);
		} else {
			$this->setConvocatoriaId($v->getId());
		}

		$this->aConvocatoria = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Convocatoria object, it will not be re-added.
		if ($v !== null) {
			$v->addListaCalle($this);
		}

		return $this;
	}


	/**
	 * Get the associated Convocatoria object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Convocatoria The associated Convocatoria object.
	 * @throws     PropelException
	 */
	public function getConvocatoria(PropelPDO $con = null)
	{
		if ($this->aConvocatoria === null && ($this->convocatoria_id !== null)) {
			$this->aConvocatoria = ConvocatoriaPeer::retrieveByPk($this->convocatoria_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aConvocatoria->addListaCalles($this);
			 */
		}
		return $this->aConvocatoria;
	}

	/**
	 * Declares an association between this object and a Partido object.
	 *
	 * @param      Partido $v
	 * @return     ListaCalle The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPartido(Partido $v = null)
	{
		if ($v === null) {
			$this->setPartidoId(NULL);
		} else {
			$this->setPartidoId($v->getId());
		}

		$this->aPartido = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Partido object, it will not be re-added.
		if ($v !== null) {
			$v->addListaCalle($this);
		}

		return $this;
	}


	/**
	 * Get the associated Partido object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Partido The associated Partido object.
	 * @throws     PropelException
	 */
	public function getPartido(PropelPDO $con = null)
	{
		if ($this->aPartido === null && ($this->partido_id !== null)) {
			$this->aPartido = PartidoPeer::retrieveByPk($this->partido_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPartido->addListaCalles($this);
			 */
		}
		return $this->aPartido;
	}

	/**
	 * Declares an association between this object and a Politico object.
	 *
	 * @param      Politico $v
	 * @return     ListaCalle The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPolitico(Politico $v = null)
	{
		if ($v === null) {
			$this->setPoliticoId(NULL);
		} else {
			$this->setPoliticoId($v->getId());
		}

		$this->aPolitico = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Politico object, it will not be re-added.
		if ($v !== null) {
			$v->addListaCalle($this);
		}

		return $this;
	}


	/**
	 * Get the associated Politico object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Politico The associated Politico object.
	 * @throws     PropelException
	 */
	public function getPolitico(PropelPDO $con = null)
	{
		if ($this->aPolitico === null && ($this->politico_id !== null)) {
			$this->aPolitico = PoliticoPeer::retrieveByPk($this->politico_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPolitico->addListaCalles($this);
			 */
		}
		return $this->aPolitico;
	}

	/**
	 * Declares an association between this object and a Circunscripcion object.
	 *
	 * @param      Circunscripcion $v
	 * @return     ListaCalle The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setCircunscripcion(Circunscripcion $v = null)
	{
		if ($v === null) {
			$this->setCircunscripcionId(NULL);
		} else {
			$this->setCircunscripcionId($v->getId());
		}

		$this->aCircunscripcion = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Circunscripcion object, it will not be re-added.
		if ($v !== null) {
			$v->addListaCalle($this);
		}

		return $this;
	}


	/**
	 * Get the associated Circunscripcion object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Circunscripcion The associated Circunscripcion object.
	 * @throws     PropelException
	 */
	public function getCircunscripcion(PropelPDO $con = null)
	{
		if ($this->aCircunscripcion === null && ($this->circunscripcion_id !== null)) {
			$this->aCircunscripcion = CircunscripcionPeer::retrieveByPk($this->circunscripcion_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aCircunscripcion->addListaCalles($this);
			 */
		}
		return $this->aCircunscripcion;
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

			$this->aConvocatoria = null;
			$this->aPartido = null;
			$this->aPolitico = null;
			$this->aCircunscripcion = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseListaCalle:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseListaCalle::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseListaCalle
