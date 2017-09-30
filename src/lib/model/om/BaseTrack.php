<?php

/**
 * Base class that represents a row from the 'track' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseTrack extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TrackPeer
	 */
	protected static $peer;


	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;


	/**
	 * The value for the composer field.
	 * @var        string
	 */
	protected $composer;


	/**
	 * The value for the original_filename field.
	 * @var        string
	 */
	protected $original_filename;


	/**
	 * The value for the converted_filename field.
	 * @var        string
	 */
	protected $converted_filename;


	/**
	 * The value for the original_file_md5 field.
	 * @var        string
	 */
	protected $original_file_md5;


	/**
	 * The value for the is_metadata_complete field.
	 * @var        boolean
	 */
	protected $is_metadata_complete;


	/**
	 * The value for the is_enabled field.
	 * @var        boolean
	 */
	protected $is_enabled;


	/**
	 * The value for the created_at field.
	 * @var        int
	 */
	protected $created_at;


	/**
	 * The value for the updated_at field.
	 * @var        int
	 */
	protected $updated_at;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * Collection to store aggregation of collPlaylistHasTracks.
	 * @var        array
	 */
	protected $collPlaylistHasTracks;

	/**
	 * The criteria used to select the current contents of collPlaylistHasTracks.
	 * @var        Criteria
	 */
	protected $lastPlaylistHasTrackCriteria = null;

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
	 * Get the [title] column value.
	 * 
	 * @return     string
	 */
	public function getTitle()
	{

		return $this->title;
	}

	/**
	 * Get the [composer] column value.
	 * 
	 * @return     string
	 */
	public function getComposer()
	{

		return $this->composer;
	}

	/**
	 * Get the [original_filename] column value.
	 * 
	 * @return     string
	 */
	public function getOriginalFilename()
	{

		return $this->original_filename;
	}

	/**
	 * Get the [converted_filename] column value.
	 * 
	 * @return     string
	 */
	public function getConvertedFilename()
	{

		return $this->converted_filename;
	}

	/**
	 * Get the [original_file_md5] column value.
	 * 
	 * @return     string
	 */
	public function getOriginalFileMd5()
	{

		return $this->original_file_md5;
	}

	/**
	 * Get the [is_metadata_complete] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsMetadataComplete()
	{

		return $this->is_metadata_complete;
	}

	/**
	 * Get the [is_enabled] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsEnabled()
	{

		return $this->is_enabled;
	}

	/**
	 * Get the [optionally formatted] [created_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	/**
	 * Get the [optionally formatted] [updated_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
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
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitle($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = TrackPeer::TITLE;
		}

	} // setTitle()

	/**
	 * Set the value of [composer] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setComposer($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->composer !== $v) {
			$this->composer = $v;
			$this->modifiedColumns[] = TrackPeer::COMPOSER;
		}

	} // setComposer()

	/**
	 * Set the value of [original_filename] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOriginalFilename($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->original_filename !== $v) {
			$this->original_filename = $v;
			$this->modifiedColumns[] = TrackPeer::ORIGINAL_FILENAME;
		}

	} // setOriginalFilename()

	/**
	 * Set the value of [converted_filename] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setConvertedFilename($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->converted_filename !== $v) {
			$this->converted_filename = $v;
			$this->modifiedColumns[] = TrackPeer::CONVERTED_FILENAME;
		}

	} // setConvertedFilename()

	/**
	 * Set the value of [original_file_md5] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setOriginalFileMd5($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->original_file_md5 !== $v) {
			$this->original_file_md5 = $v;
			$this->modifiedColumns[] = TrackPeer::ORIGINAL_FILE_MD5;
		}

	} // setOriginalFileMd5()

	/**
	 * Set the value of [is_metadata_complete] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsMetadataComplete($v)
	{

		if ($this->is_metadata_complete !== $v) {
			$this->is_metadata_complete = $v;
			$this->modifiedColumns[] = TrackPeer::IS_METADATA_COMPLETE;
		}

	} // setIsMetadataComplete()

	/**
	 * Set the value of [is_enabled] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsEnabled($v)
	{

		if ($this->is_enabled !== $v) {
			$this->is_enabled = $v;
			$this->modifiedColumns[] = TrackPeer::IS_ENABLED;
		}

	} // setIsEnabled()

	/**
	 * Set the value of [created_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = TrackPeer::CREATED_AT;
		}

	} // setCreatedAt()

	/**
	 * Set the value of [updated_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = TrackPeer::UPDATED_AT;
		}

	} // setUpdatedAt()

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TrackPeer::ID;
		}

	} // setId()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (1-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      ResultSet $rs The ResultSet class with cursor advanced to desired record pos.
	 * @param      int $startcol 1-based offset column which indicates which restultset column to start with.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->title = $rs->getString($startcol + 0);

			$this->composer = $rs->getString($startcol + 1);

			$this->original_filename = $rs->getString($startcol + 2);

			$this->converted_filename = $rs->getString($startcol + 3);

			$this->original_file_md5 = $rs->getString($startcol + 4);

			$this->is_metadata_complete = $rs->getBoolean($startcol + 5);

			$this->is_enabled = $rs->getBoolean($startcol + 6);

			$this->created_at = $rs->getTimestamp($startcol + 7, null);

			$this->updated_at = $rs->getTimestamp($startcol + 8, null);

			$this->id = $rs->getInt($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = TrackPeer::NUM_COLUMNS - TrackPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Track object", $e);
		}
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      Connection $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTrack:delete:pre') as $callable)
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
			$con = Propel::getConnection(TrackPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TrackPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTrack:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	/**
	 * Stores the object in the database.  If the object is new,
	 * it inserts it; otherwise an update is performed.  This method
	 * wraps the doSave() worker method in a transaction.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTrack:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(TrackPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TrackPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TrackPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTrack:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave($con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TrackPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TrackPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPlaylistHasTracks !== null) {
				foreach($this->collPlaylistHasTracks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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


			if (($retval = TrackPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPlaylistHasTracks !== null) {
					foreach($this->collPlaylistHasTracks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TrackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
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
				return $this->getTitle();
				break;
			case 1:
				return $this->getComposer();
				break;
			case 2:
				return $this->getOriginalFilename();
				break;
			case 3:
				return $this->getConvertedFilename();
				break;
			case 4:
				return $this->getOriginalFileMd5();
				break;
			case 5:
				return $this->getIsMetadataComplete();
				break;
			case 6:
				return $this->getIsEnabled();
				break;
			case 7:
				return $this->getCreatedAt();
				break;
			case 8:
				return $this->getUpdatedAt();
				break;
			case 9:
				return $this->getId();
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
	 * @param      string $keyType One of the class type constants TYPE_PHPNAME,
	 *                        TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TrackPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getTitle(),
			$keys[1] => $this->getComposer(),
			$keys[2] => $this->getOriginalFilename(),
			$keys[3] => $this->getConvertedFilename(),
			$keys[4] => $this->getOriginalFileMd5(),
			$keys[5] => $this->getIsMetadataComplete(),
			$keys[6] => $this->getIsEnabled(),
			$keys[7] => $this->getCreatedAt(),
			$keys[8] => $this->getUpdatedAt(),
			$keys[9] => $this->getId(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TrackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTitle($value);
				break;
			case 1:
				$this->setComposer($value);
				break;
			case 2:
				$this->setOriginalFilename($value);
				break;
			case 3:
				$this->setConvertedFilename($value);
				break;
			case 4:
				$this->setOriginalFileMd5($value);
				break;
			case 5:
				$this->setIsMetadataComplete($value);
				break;
			case 6:
				$this->setIsEnabled($value);
				break;
			case 7:
				$this->setCreatedAt($value);
				break;
			case 8:
				$this->setUpdatedAt($value);
				break;
			case 9:
				$this->setId($value);
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
	 * of the class type constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME,
	 * TYPE_NUM. The default key type is the column's phpname (e.g. 'authorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TrackPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setTitle($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setComposer($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOriginalFilename($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setConvertedFilename($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOriginalFileMd5($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsMetadataComplete($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsEnabled($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setId($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TrackPeer::DATABASE_NAME);

		if ($this->isColumnModified(TrackPeer::TITLE)) $criteria->add(TrackPeer::TITLE, $this->title);
		if ($this->isColumnModified(TrackPeer::COMPOSER)) $criteria->add(TrackPeer::COMPOSER, $this->composer);
		if ($this->isColumnModified(TrackPeer::ORIGINAL_FILENAME)) $criteria->add(TrackPeer::ORIGINAL_FILENAME, $this->original_filename);
		if ($this->isColumnModified(TrackPeer::CONVERTED_FILENAME)) $criteria->add(TrackPeer::CONVERTED_FILENAME, $this->converted_filename);
		if ($this->isColumnModified(TrackPeer::ORIGINAL_FILE_MD5)) $criteria->add(TrackPeer::ORIGINAL_FILE_MD5, $this->original_file_md5);
		if ($this->isColumnModified(TrackPeer::IS_METADATA_COMPLETE)) $criteria->add(TrackPeer::IS_METADATA_COMPLETE, $this->is_metadata_complete);
		if ($this->isColumnModified(TrackPeer::IS_ENABLED)) $criteria->add(TrackPeer::IS_ENABLED, $this->is_enabled);
		if ($this->isColumnModified(TrackPeer::CREATED_AT)) $criteria->add(TrackPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TrackPeer::UPDATED_AT)) $criteria->add(TrackPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(TrackPeer::ID)) $criteria->add(TrackPeer::ID, $this->id);

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
		$criteria = new Criteria(TrackPeer::DATABASE_NAME);

		$criteria->add(TrackPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Track (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitle($this->title);

		$copyObj->setComposer($this->composer);

		$copyObj->setOriginalFilename($this->original_filename);

		$copyObj->setConvertedFilename($this->converted_filename);

		$copyObj->setOriginalFileMd5($this->original_file_md5);

		$copyObj->setIsMetadataComplete($this->is_metadata_complete);

		$copyObj->setIsEnabled($this->is_enabled);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPlaylistHasTracks() as $relObj) {
				$copyObj->addPlaylistHasTrack($relObj->copy($deepCopy));
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

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
	 * @return     Track Clone of current object.
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
	 * @return     TrackPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TrackPeer();
		}
		return self::$peer;
	}

	/**
	 * Temporary storage of collPlaylistHasTracks to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPlaylistHasTracks()
	{
		if ($this->collPlaylistHasTracks === null) {
			$this->collPlaylistHasTracks = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Track has previously
	 * been saved, it will retrieve related PlaylistHasTracks from storage.
	 * If this Track is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPlaylistHasTracks($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPlaylistHasTracks === null) {
			if ($this->isNew()) {
			   $this->collPlaylistHasTracks = array();
			} else {

				$criteria->add(PlaylistHasTrackPeer::TRACK_ID, $this->getId());

				PlaylistHasTrackPeer::addSelectColumns($criteria);
				$this->collPlaylistHasTracks = PlaylistHasTrackPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PlaylistHasTrackPeer::TRACK_ID, $this->getId());

				PlaylistHasTrackPeer::addSelectColumns($criteria);
				if (!isset($this->lastPlaylistHasTrackCriteria) || !$this->lastPlaylistHasTrackCriteria->equals($criteria)) {
					$this->collPlaylistHasTracks = PlaylistHasTrackPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPlaylistHasTrackCriteria = $criteria;
		return $this->collPlaylistHasTracks;
	}

	/**
	 * Returns the number of related PlaylistHasTracks.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPlaylistHasTracks($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PlaylistHasTrackPeer::TRACK_ID, $this->getId());

		return PlaylistHasTrackPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PlaylistHasTrack object to this object
	 * through the PlaylistHasTrack foreign key attribute
	 *
	 * @param      PlaylistHasTrack $l PlaylistHasTrack
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPlaylistHasTrack(PlaylistHasTrack $l)
	{
		$this->collPlaylistHasTracks[] = $l;
		$l->setTrack($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Track is new, it will return
	 * an empty collection; or if this Track has previously
	 * been saved, it will retrieve related PlaylistHasTracks from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Track.
	 */
	public function getPlaylistHasTracksJoinPlaylist($criteria = null, $con = null)
	{
		// include the Peer class
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPlaylistHasTracks === null) {
			if ($this->isNew()) {
				$this->collPlaylistHasTracks = array();
			} else {

				$criteria->add(PlaylistHasTrackPeer::TRACK_ID, $this->getId());

				$this->collPlaylistHasTracks = PlaylistHasTrackPeer::doSelectJoinPlaylist($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PlaylistHasTrackPeer::TRACK_ID, $this->getId());

			if (!isset($this->lastPlaylistHasTrackCriteria) || !$this->lastPlaylistHasTrackCriteria->equals($criteria)) {
				$this->collPlaylistHasTracks = PlaylistHasTrackPeer::doSelectJoinPlaylist($criteria, $con);
			}
		}
		$this->lastPlaylistHasTrackCriteria = $criteria;

		return $this->collPlaylistHasTracks;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTrack:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTrack::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseTrack
