<?php

/**
 * Base class that represents a row from the 'imagen' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Jan 13 09:57:19 2010
 *
 * @package    lib.model.om
 */
abstract class BaseImagen extends BaseObject  implements Persistent {


  const PEER = 'ImagenPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ImagenPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the tipo field.
	 * @var        string
	 */
	protected $tipo;

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
	 * The value for the opinion_id field.
	 * @var        int
	 */
	protected $opinion_id;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        Partido
	 */
	protected $aPartido;

	/**
	 * @var        Politico
	 */
	protected $aPolitico;

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

	/**
	 * Initializes internal state of BaseImagen object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [tipo] column value.
	 * 
	 * @return     string
	 */
	public function getTipo()
	{
		return $this->tipo;
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
	 * Get the [opinion_id] column value.
	 * 
	 * @return     int
	 */
	public function getOpinionId()
	{
		return $this->opinion_id;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
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
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Imagen The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ImagenPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [tipo] column.
	 * 
	 * @param      string $v new value
	 * @return     Imagen The current object (for fluent API support)
	 */
	public function setTipo($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tipo !== $v) {
			$this->tipo = $v;
			$this->modifiedColumns[] = ImagenPeer::TIPO;
		}

		return $this;
	} // setTipo()

	/**
	 * Set the value of [partido_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Imagen The current object (for fluent API support)
	 */
	public function setPartidoId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->partido_id !== $v) {
			$this->partido_id = $v;
			$this->modifiedColumns[] = ImagenPeer::PARTIDO_ID;
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
	 * @return     Imagen The current object (for fluent API support)
	 */
	public function setPoliticoId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->politico_id !== $v) {
			$this->politico_id = $v;
			$this->modifiedColumns[] = ImagenPeer::POLITICO_ID;
		}

		if ($this->aPolitico !== null && $this->aPolitico->getId() !== $v) {
			$this->aPolitico = null;
		}

		return $this;
	} // setPoliticoId()

	/**
	 * Set the value of [opinion_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Imagen The current object (for fluent API support)
	 */
	public function setOpinionId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->opinion_id !== $v) {
			$this->opinion_id = $v;
			$this->modifiedColumns[] = ImagenPeer::OPINION_ID;
		}

		return $this;
	} // setOpinionId()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Imagen The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
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

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = ImagenPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

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
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array())) {
				return false;
			}

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

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->tipo = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->partido_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->politico_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->opinion_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = ImagenPeer::NUM_COLUMNS - ImagenPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Imagen object", $e);
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

		if ($this->aPartido !== null && $this->partido_id !== $this->aPartido->getId()) {
			$this->aPartido = null;
		}
		if ($this->aPolitico !== null && $this->politico_id !== $this->aPolitico->getId()) {
			$this->aPolitico = null;
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
			$con = Propel::getConnection(ImagenPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = ImagenPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPartido = null;
			$this->aPolitico = null;
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

    foreach (sfMixer::getCallables('BaseImagen:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ImagenPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			ImagenPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseImagen:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
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

    foreach (sfMixer::getCallables('BaseImagen:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(ImagenPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ImagenPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseImagen:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			ImagenPeer::addInstanceToPool($this);
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

			if ($this->aPartido !== null) {
				if ($this->aPartido->isModified() || $this->aPartido->isNew()) {
					$affectedRows += $this->aPartido->save($con);
				}
				$this->setPartido($this->aPartido);
			}

			if ($this->aPolitico !== null) {
				if ($this->aPolitico->isModified() || ($this->aPolitico->getCulture() && $this->aPolitico->getCurrentPoliticoI18n()->isModified()) || $this->aPolitico->isNew()) {
					$affectedRows += $this->aPolitico->save($con);
				}
				$this->setPolitico($this->aPolitico);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = ImagenPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ImagenPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ImagenPeer::doUpdate($this, $con);
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


			if (($retval = ImagenPeer::doValidate($this, $columns)) !== true) {
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
		$pos = ImagenPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getId();
				break;
			case 1:
				return $this->getTipo();
				break;
			case 2:
				return $this->getPartidoId();
				break;
			case 3:
				return $this->getPoliticoId();
				break;
			case 4:
				return $this->getOpinionId();
				break;
			case 5:
				return $this->getCreatedAt();
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
		$keys = ImagenPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTipo(),
			$keys[2] => $this->getPartidoId(),
			$keys[3] => $this->getPoliticoId(),
			$keys[4] => $this->getOpinionId(),
			$keys[5] => $this->getCreatedAt(),
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
		$pos = ImagenPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setId($value);
				break;
			case 1:
				$this->setTipo($value);
				break;
			case 2:
				$this->setPartidoId($value);
				break;
			case 3:
				$this->setPoliticoId($value);
				break;
			case 4:
				$this->setOpinionId($value);
				break;
			case 5:
				$this->setCreatedAt($value);
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
		$keys = ImagenPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTipo($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPartidoId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPoliticoId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOpinionId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ImagenPeer::DATABASE_NAME);

		if ($this->isColumnModified(ImagenPeer::ID)) $criteria->add(ImagenPeer::ID, $this->id);
		if ($this->isColumnModified(ImagenPeer::TIPO)) $criteria->add(ImagenPeer::TIPO, $this->tipo);
		if ($this->isColumnModified(ImagenPeer::PARTIDO_ID)) $criteria->add(ImagenPeer::PARTIDO_ID, $this->partido_id);
		if ($this->isColumnModified(ImagenPeer::POLITICO_ID)) $criteria->add(ImagenPeer::POLITICO_ID, $this->politico_id);
		if ($this->isColumnModified(ImagenPeer::OPINION_ID)) $criteria->add(ImagenPeer::OPINION_ID, $this->opinion_id);
		if ($this->isColumnModified(ImagenPeer::CREATED_AT)) $criteria->add(ImagenPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(ImagenPeer::DATABASE_NAME);

		$criteria->add(ImagenPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Imagen (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTipo($this->tipo);

		$copyObj->setPartidoId($this->partido_id);

		$copyObj->setPoliticoId($this->politico_id);

		$copyObj->setOpinionId($this->opinion_id);

		$copyObj->setCreatedAt($this->created_at);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Imagen Clone of current object.
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
	 * @return     ImagenPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ImagenPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Partido object.
	 *
	 * @param      Partido $v
	 * @return     Imagen The current object (for fluent API support)
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
			$v->addImagen($this);
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
			$c = new Criteria(PartidoPeer::DATABASE_NAME);
			$c->add(PartidoPeer::ID, $this->partido_id);
			$this->aPartido = PartidoPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPartido->addImagens($this);
			 */
		}
		return $this->aPartido;
	}

	/**
	 * Declares an association between this object and a Politico object.
	 *
	 * @param      Politico $v
	 * @return     Imagen The current object (for fluent API support)
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
			$v->addImagen($this);
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
			$c = new Criteria(PoliticoPeer::DATABASE_NAME);
			$c->add(PoliticoPeer::ID, $this->politico_id);
			$this->aPolitico = PoliticoPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPolitico->addImagens($this);
			 */
		}
		return $this->aPolitico;
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

			$this->aPartido = null;
			$this->aPolitico = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseImagen:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseImagen::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseImagen
