<?php

namespace app\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Model\StackTestResultPass as ChildStackTestResultPass;
use App\Model\StackTestResultPassQuery as ChildStackTestResultPassQuery;
use App\Model\Target as ChildTarget;
use App\Model\TargetQuery as ChildTargetQuery;
use App\Model\TargetType as ChildTargetType;
use App\Model\TargetTypeQuery as ChildTargetTypeQuery;
use App\Model\Map\TargetTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class TargetType implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Model\\Map\\TargetTypeTableMap';

    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id_target_type field.
     * @var        int
     */
    protected $id_target_type;

    /**
     * The value for the target_type_class field.
     * @var        string
     */
    protected $target_type_class;

    /**
     * The value for the target_type_name field.
     * @var        string
     */
    protected $target_type_name;

    /**
     * The value for the target_type_description field.
     * @var        string
     */
    protected $target_type_description;

    /**
     * The value for the target_type_active field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $target_type_active;

    /**
     * The value for the created_at field.
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        \DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildStackTestResultPass[] Collection to store aggregation of ChildStackTestResultPass objects.
     */
    protected $collStackTestResultPasses;
    protected $collStackTestResultPassesPartial;

    /**
     * @var        ObjectCollection|ChildTarget[] Collection to store aggregation of ChildTarget objects.
     */
    protected $collTargets;
    protected $collTargetsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStackTestResultPass[]
     */
    protected $stackTestResultPassesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTarget[]
     */
    protected $targetsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->target_type_active = false;
    }

    /**
     * Initializes internal state of App\Model\Base\TargetType object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>TargetType</code> instance.  If
     * <code>obj</code> is an instance of <code>TargetType</code>, delegates to
     * <code>equals(TargetType)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|TargetType The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id_target_type] column value.
     *
     * @return int
     */
    public function getIdTargetType()
    {
        return $this->id_target_type;
    }

    /**
     * Get the [target_type_class] column value.
     *
     * @return string
     */
    public function getTargetTypeClass()
    {
        return $this->target_type_class;
    }

    /**
     * Get the [target_type_name] column value.
     *
     * @return string
     */
    public function getTargetTypeName()
    {
        return $this->target_type_name;
    }

    /**
     * Get the [target_type_description] column value.
     *
     * @return string
     */
    public function getTargetTypeDescription()
    {
        return $this->target_type_description;
    }

    /**
     * Get the [target_type_active] column value.
     *
     * @return boolean
     */
    public function getTargetTypeActive()
    {
        return $this->target_type_active;
    }

    /**
     * Get the [target_type_active] column value.
     *
     * @return boolean
     */
    public function isTargetTypeActive()
    {
        return $this->getTargetTypeActive();
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *                       If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *                       If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->target_type_active !== false) {
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
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TargetTypeTableMap::translateFieldName('IdTargetType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_target_type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TargetTypeTableMap::translateFieldName('TargetTypeClass', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_type_class = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TargetTypeTableMap::translateFieldName('TargetTypeName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_type_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TargetTypeTableMap::translateFieldName('TargetTypeDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_type_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TargetTypeTableMap::translateFieldName('TargetTypeActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_type_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TargetTypeTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TargetTypeTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = TargetTypeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Model\\TargetType'), 0, $e);
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
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Set the value of [id_target_type] column.
     *
     * @param  int                         $v new value
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setIdTargetType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_target_type !== $v) {
            $this->id_target_type = $v;
            $this->modifiedColumns[TargetTypeTableMap::COL_ID_TARGET_TYPE] = true;
        }

        return $this;
    } // setIdTargetType()

    /**
     * Set the value of [target_type_class] column.
     *
     * @param  string                      $v new value
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setTargetTypeClass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->target_type_class !== $v) {
            $this->target_type_class = $v;
            $this->modifiedColumns[TargetTypeTableMap::COL_TARGET_TYPE_CLASS] = true;
        }

        return $this;
    } // setTargetTypeClass()

    /**
     * Set the value of [target_type_name] column.
     *
     * @param  string                      $v new value
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setTargetTypeName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->target_type_name !== $v) {
            $this->target_type_name = $v;
            $this->modifiedColumns[TargetTypeTableMap::COL_TARGET_TYPE_NAME] = true;
        }

        return $this;
    } // setTargetTypeName()

    /**
     * Set the value of [target_type_description] column.
     *
     * @param  string                      $v new value
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setTargetTypeDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->target_type_description !== $v) {
            $this->target_type_description = $v;
            $this->modifiedColumns[TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION] = true;
        }

        return $this;
    } // setTargetTypeDescription()

    /**
     * Sets the value of the [target_type_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string      $v The new value
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setTargetTypeActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->target_type_active !== $v) {
            $this->target_type_active = $v;
            $this->modifiedColumns[TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE] = true;
        }

        return $this;
    } // setTargetTypeActive()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                       $v string, integer (timestamp), or \DateTime value.
     *                                        Empty strings are treated as NULL.
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[TargetTypeTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                       $v string, integer (timestamp), or \DateTime value.
     *                                        Empty strings are treated as NULL.
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[TargetTypeTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param  boolean             $deep (optional) Whether to also de-associated any related objects.
     * @param  ConnectionInterface $con  (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException     - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TargetTypeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTargetTypeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collStackTestResultPasses = null;

            $this->collTargets = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param  ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TargetType::setDeleted()
     * @see TargetType::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTypeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTargetTypeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param  ConnectionInterface $con
     * @return int                 The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTypeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(TargetTypeTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(TargetTypeTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TargetTypeTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TargetTypeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param  ConnectionInterface $con
     * @return int                 The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->stackTestResultPassesScheduledForDeletion !== null) {
                if (!$this->stackTestResultPassesScheduledForDeletion->isEmpty()) {
                    \App\Model\StackTestResultPassQuery::create()
                        ->filterByPrimaryKeys($this->stackTestResultPassesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stackTestResultPassesScheduledForDeletion = null;
                }
            }

            if ($this->collStackTestResultPasses !== null) {
                foreach ($this->collStackTestResultPasses as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->targetsScheduledForDeletion !== null) {
                if (!$this->targetsScheduledForDeletion->isEmpty()) {
                    \App\Model\TargetQuery::create()
                        ->filterByPrimaryKeys($this->targetsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->targetsScheduledForDeletion = null;
                }
            }

            if ($this->collTargets !== null) {
                foreach ($this->collTargets as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TargetTypeTableMap::COL_ID_TARGET_TYPE] = true;
        if (null !== $this->id_target_type) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TargetTypeTableMap::COL_ID_TARGET_TYPE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TargetTypeTableMap::COL_ID_TARGET_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'ID_TARGET_TYPE';
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TYPE_CLASS';
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TYPE_NAME';
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TYPE_DESCRIPTION';
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TYPE_ACTIVE';
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO target_type (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_TARGET_TYPE':
                        $stmt->bindValue($identifier, $this->id_target_type, PDO::PARAM_INT);
                        break;
                    case 'TARGET_TYPE_CLASS':
                        $stmt->bindValue($identifier, $this->target_type_class, PDO::PARAM_STR);
                        break;
                    case 'TARGET_TYPE_NAME':
                        $stmt->bindValue($identifier, $this->target_type_name, PDO::PARAM_STR);
                        break;
                    case 'TARGET_TYPE_DESCRIPTION':
                        $stmt->bindValue($identifier, $this->target_type_description, PDO::PARAM_STR);
                        break;
                    case 'TARGET_TYPE_ACTIVE':
                        $stmt->bindValue($identifier, (int) $this->target_type_active, PDO::PARAM_INT);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdTargetType($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param  string $name name
     * @param  string $type The type of fieldname the $name is of:
     *                      one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                      TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                      Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed  Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TargetTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int   $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdTargetType();
                break;
            case 1:
                return $this->getTargetTypeClass();
                break;
            case 2:
                return $this->getTargetTypeName();
                break;
            case 3:
                return $this->getTargetTypeDescription();
                break;
            case 4:
                return $this->getTargetTypeActive();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
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
     * @param string  $keyType                (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                                        TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                                        Defaults to TableMap::TYPE_PHPNAME.
     * @param boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array   $alreadyDumpedObjects   List of objects to skip to avoid recursion
     * @param boolean $includeForeignObjects  (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['TargetType'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TargetType'][$this->getPrimaryKey()] = true;
        $keys = TargetTypeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTargetType(),
            $keys[1] => $this->getTargetTypeClass(),
            $keys[2] => $this->getTargetTypeName(),
            $keys[3] => $this->getTargetTypeDescription(),
            $keys[4] => $this->getTargetTypeActive(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collStackTestResultPasses) {
                $result['StackTestResultPasses'] = $this->collStackTestResultPasses->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTargets) {
                $result['Targets'] = $this->collTargets->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string                      $name
     * @param  mixed                       $value field value
     * @param  string                      $type  The type of fieldname the $name is of:
     *                                            one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                                            Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Model\TargetType
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TargetTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int                         $pos   position in xml schema
     * @param  mixed                       $value field value
     * @return $this|\App\Model\TargetType
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTargetType($value);
                break;
            case 1:
                $this->setTargetTypeClass($value);
                break;
            case 2:
                $this->setTargetTypeName($value);
                break;
            case 3:
                $this->setTargetTypeDescription($value);
                break;
            case 4:
                $this->setTargetTypeActive($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param  array  $arr     An array to populate the object from.
     * @param  string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TargetTypeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdTargetType($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTargetTypeClass($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTargetTypeName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTargetTypeDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTargetTypeActive($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed  $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data   The source data to import from
     *
     * @return $this|\App\Model\TargetType The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TargetTypeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TargetTypeTableMap::COL_ID_TARGET_TYPE)) {
            $criteria->add(TargetTypeTableMap::COL_ID_TARGET_TYPE, $this->id_target_type);
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_CLASS)) {
            $criteria->add(TargetTypeTableMap::COL_TARGET_TYPE_CLASS, $this->target_type_class);
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_NAME)) {
            $criteria->add(TargetTypeTableMap::COL_TARGET_TYPE_NAME, $this->target_type_name);
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION)) {
            $criteria->add(TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION, $this->target_type_description);
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE)) {
            $criteria->add(TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE, $this->target_type_active);
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_CREATED_AT)) {
            $criteria->add(TargetTypeTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TargetTypeTableMap::COL_UPDATED_AT)) {
            $criteria->add(TargetTypeTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(TargetTypeTableMap::DATABASE_NAME);
        $criteria->add(TargetTypeTableMap::COL_ID_TARGET_TYPE, $this->id_target_type);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdTargetType();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdTargetType();
    }

    /**
     * Generic method to set the primary key (id_target_type column).
     *
     * @param  int  $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTargetType($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdTargetType();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  object          $copyObj  An object of \App\Model\TargetType (or compatible) type.
     * @param  boolean         $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param  boolean         $makeNew  Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTargetTypeClass($this->getTargetTypeClass());
        $copyObj->setTargetTypeName($this->getTargetTypeName());
        $copyObj->setTargetTypeDescription($this->getTargetTypeDescription());
        $copyObj->setTargetTypeActive($this->getTargetTypeActive());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getStackTestResultPasses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStackTestResultPass($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTargets() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTarget($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTargetType(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean               $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Model\TargetType Clone of current object.
     * @throws PropelException
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param  string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('StackTestResultPass' == $relationName) {
            return $this->initStackTestResultPasses();
        }
        if ('Target' == $relationName) {
            return $this->initTargets();
        }
    }

    /**
     * Clears out the collStackTestResultPasses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStackTestResultPasses()
     */
    public function clearStackTestResultPasses()
    {
        $this->collStackTestResultPasses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStackTestResultPasses collection loaded partially.
     */
    public function resetPartialStackTestResultPasses($v = true)
    {
        $this->collStackTestResultPassesPartial = $v;
    }

    /**
     * Initializes the collStackTestResultPasses collection.
     *
     * By default this just sets the collStackTestResultPasses collection to an empty array (like clearcollStackTestResultPasses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                  the collection even if it is not empty
     *
     * @return void
     */
    public function initStackTestResultPasses($overrideExisting = true)
    {
        if (null !== $this->collStackTestResultPasses && !$overrideExisting) {
            return;
        }
        $this->collStackTestResultPasses = new ObjectCollection();
        $this->collStackTestResultPasses->setModel('\App\Model\StackTestResultPass');
    }

    /**
     * Gets an array of ChildStackTestResultPass objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTargetType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param  Criteria                                    $criteria optional Criteria object to narrow the query
     * @param  ConnectionInterface                         $con      optional connection object
     * @return ObjectCollection|ChildStackTestResultPass[] List of ChildStackTestResultPass objects
     * @throws PropelException
     */
    public function getStackTestResultPasses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultPassesPartial && !$this->isNew();
        if (null === $this->collStackTestResultPasses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultPasses) {
                // return empty collection
                $this->initStackTestResultPasses();
            } else {
                $collStackTestResultPasses = ChildStackTestResultPassQuery::create(null, $criteria)
                    ->filterByTargetType($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStackTestResultPassesPartial && count($collStackTestResultPasses)) {
                        $this->initStackTestResultPasses(false);

                        foreach ($collStackTestResultPasses as $obj) {
                            if (false == $this->collStackTestResultPasses->contains($obj)) {
                                $this->collStackTestResultPasses->append($obj);
                            }
                        }

                        $this->collStackTestResultPassesPartial = true;
                    }

                    return $collStackTestResultPasses;
                }

                if ($partial && $this->collStackTestResultPasses) {
                    foreach ($this->collStackTestResultPasses as $obj) {
                        if ($obj->isNew()) {
                            $collStackTestResultPasses[] = $obj;
                        }
                    }
                }

                $this->collStackTestResultPasses = $collStackTestResultPasses;
                $this->collStackTestResultPassesPartial = false;
            }
        }

        return $this->collStackTestResultPasses;
    }

    /**
     * Sets a collection of ChildStackTestResultPass objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection            $stackTestResultPasses A Propel collection.
     * @param  ConnectionInterface   $con                   Optional connection object
     * @return $this|ChildTargetType The current object (for fluent API support)
     */
    public function setStackTestResultPasses(Collection $stackTestResultPasses, ConnectionInterface $con = null)
    {
        /** @var ChildStackTestResultPass[] $stackTestResultPassesToDelete */
        $stackTestResultPassesToDelete = $this->getStackTestResultPasses(new Criteria(), $con)->diff($stackTestResultPasses);


        $this->stackTestResultPassesScheduledForDeletion = $stackTestResultPassesToDelete;

        foreach ($stackTestResultPassesToDelete as $stackTestResultPassRemoved) {
            $stackTestResultPassRemoved->setTargetType(null);
        }

        $this->collStackTestResultPasses = null;
        foreach ($stackTestResultPasses as $stackTestResultPass) {
            $this->addStackTestResultPass($stackTestResultPass);
        }

        $this->collStackTestResultPasses = $stackTestResultPasses;
        $this->collStackTestResultPassesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StackTestResultPass objects.
     *
     * @param  Criteria            $criteria
     * @param  boolean             $distinct
     * @param  ConnectionInterface $con
     * @return int                 Count of related StackTestResultPass objects.
     * @throws PropelException
     */
    public function countStackTestResultPasses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultPassesPartial && !$this->isNew();
        if (null === $this->collStackTestResultPasses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultPasses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStackTestResultPasses());
            }

            $query = ChildStackTestResultPassQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTargetType($this)
                ->count($con);
        }

        return count($this->collStackTestResultPasses);
    }

    /**
     * Method called to associate a ChildStackTestResultPass object to this object
     * through the ChildStackTestResultPass foreign key attribute.
     *
     * @param  ChildStackTestResultPass    $l ChildStackTestResultPass
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function addStackTestResultPass(ChildStackTestResultPass $l)
    {
        if ($this->collStackTestResultPasses === null) {
            $this->initStackTestResultPasses();
            $this->collStackTestResultPassesPartial = true;
        }

        if (!$this->collStackTestResultPasses->contains($l)) {
            $this->doAddStackTestResultPass($l);
        }

        return $this;
    }

    /**
     * @param ChildStackTestResultPass $stackTestResultPass The ChildStackTestResultPass object to add.
     */
    protected function doAddStackTestResultPass(ChildStackTestResultPass $stackTestResultPass)
    {
        $this->collStackTestResultPasses[]= $stackTestResultPass;
        $stackTestResultPass->setTargetType($this);
    }

    /**
     * @param  ChildStackTestResultPass $stackTestResultPass The ChildStackTestResultPass object to remove.
     * @return $this|ChildTargetType    The current object (for fluent API support)
     */
    public function removeStackTestResultPass(ChildStackTestResultPass $stackTestResultPass)
    {
        if ($this->getStackTestResultPasses()->contains($stackTestResultPass)) {
            $pos = $this->collStackTestResultPasses->search($stackTestResultPass);
            $this->collStackTestResultPasses->remove($pos);
            if (null === $this->stackTestResultPassesScheduledForDeletion) {
                $this->stackTestResultPassesScheduledForDeletion = clone $this->collStackTestResultPasses;
                $this->stackTestResultPassesScheduledForDeletion->clear();
            }
            $this->stackTestResultPassesScheduledForDeletion[]= clone $stackTestResultPass;
            $stackTestResultPass->setTargetType(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TargetType is new, it will return
     * an empty collection; or if this TargetType has previously
     * been saved, it will retrieve related StackTestResultPasses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TargetType.
     *
     * @param  Criteria                                    $criteria     optional Criteria object to narrow the query
     * @param  ConnectionInterface                         $con          optional connection object
     * @param  string                                      $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStackTestResultPass[] List of ChildStackTestResultPass objects
     */
    public function getStackTestResultPassesJoinTarget(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStackTestResultPassQuery::create(null, $criteria);
        $query->joinWith('Target', $joinBehavior);

        return $this->getStackTestResultPasses($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TargetType is new, it will return
     * an empty collection; or if this TargetType has previously
     * been saved, it will retrieve related StackTestResultPasses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TargetType.
     *
     * @param  Criteria                                    $criteria     optional Criteria object to narrow the query
     * @param  ConnectionInterface                         $con          optional connection object
     * @param  string                                      $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStackTestResultPass[] List of ChildStackTestResultPass objects
     */
    public function getStackTestResultPassesJoinTargetGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStackTestResultPassQuery::create(null, $criteria);
        $query->joinWith('TargetGroup', $joinBehavior);

        return $this->getStackTestResultPasses($query, $con);
    }

    /**
     * Clears out the collTargets collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTargets()
     */
    public function clearTargets()
    {
        $this->collTargets = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTargets collection loaded partially.
     */
    public function resetPartialTargets($v = true)
    {
        $this->collTargetsPartial = $v;
    }

    /**
     * Initializes the collTargets collection.
     *
     * By default this just sets the collTargets collection to an empty array (like clearcollTargets());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                  the collection even if it is not empty
     *
     * @return void
     */
    public function initTargets($overrideExisting = true)
    {
        if (null !== $this->collTargets && !$overrideExisting) {
            return;
        }
        $this->collTargets = new ObjectCollection();
        $this->collTargets->setModel('\App\Model\Target');
    }

    /**
     * Gets an array of ChildTarget objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTargetType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param  Criteria                       $criteria optional Criteria object to narrow the query
     * @param  ConnectionInterface            $con      optional connection object
     * @return ObjectCollection|ChildTarget[] List of ChildTarget objects
     * @throws PropelException
     */
    public function getTargets(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTargetsPartial && !$this->isNew();
        if (null === $this->collTargets || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTargets) {
                // return empty collection
                $this->initTargets();
            } else {
                $collTargets = ChildTargetQuery::create(null, $criteria)
                    ->filterByTargetType($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTargetsPartial && count($collTargets)) {
                        $this->initTargets(false);

                        foreach ($collTargets as $obj) {
                            if (false == $this->collTargets->contains($obj)) {
                                $this->collTargets->append($obj);
                            }
                        }

                        $this->collTargetsPartial = true;
                    }

                    return $collTargets;
                }

                if ($partial && $this->collTargets) {
                    foreach ($this->collTargets as $obj) {
                        if ($obj->isNew()) {
                            $collTargets[] = $obj;
                        }
                    }
                }

                $this->collTargets = $collTargets;
                $this->collTargetsPartial = false;
            }
        }

        return $this->collTargets;
    }

    /**
     * Sets a collection of ChildTarget objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection            $targets A Propel collection.
     * @param  ConnectionInterface   $con     Optional connection object
     * @return $this|ChildTargetType The current object (for fluent API support)
     */
    public function setTargets(Collection $targets, ConnectionInterface $con = null)
    {
        /** @var ChildTarget[] $targetsToDelete */
        $targetsToDelete = $this->getTargets(new Criteria(), $con)->diff($targets);


        $this->targetsScheduledForDeletion = $targetsToDelete;

        foreach ($targetsToDelete as $targetRemoved) {
            $targetRemoved->setTargetType(null);
        }

        $this->collTargets = null;
        foreach ($targets as $target) {
            $this->addTarget($target);
        }

        $this->collTargets = $targets;
        $this->collTargetsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Target objects.
     *
     * @param  Criteria            $criteria
     * @param  boolean             $distinct
     * @param  ConnectionInterface $con
     * @return int                 Count of related Target objects.
     * @throws PropelException
     */
    public function countTargets(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTargetsPartial && !$this->isNew();
        if (null === $this->collTargets || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTargets) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTargets());
            }

            $query = ChildTargetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTargetType($this)
                ->count($con);
        }

        return count($this->collTargets);
    }

    /**
     * Method called to associate a ChildTarget object to this object
     * through the ChildTarget foreign key attribute.
     *
     * @param  ChildTarget                 $l ChildTarget
     * @return $this|\App\Model\TargetType The current object (for fluent API support)
     */
    public function addTarget(ChildTarget $l)
    {
        if ($this->collTargets === null) {
            $this->initTargets();
            $this->collTargetsPartial = true;
        }

        if (!$this->collTargets->contains($l)) {
            $this->doAddTarget($l);
        }

        return $this;
    }

    /**
     * @param ChildTarget $target The ChildTarget object to add.
     */
    protected function doAddTarget(ChildTarget $target)
    {
        $this->collTargets[]= $target;
        $target->setTargetType($this);
    }

    /**
     * @param  ChildTarget           $target The ChildTarget object to remove.
     * @return $this|ChildTargetType The current object (for fluent API support)
     */
    public function removeTarget(ChildTarget $target)
    {
        if ($this->getTargets()->contains($target)) {
            $pos = $this->collTargets->search($target);
            $this->collTargets->remove($pos);
            if (null === $this->targetsScheduledForDeletion) {
                $this->targetsScheduledForDeletion = clone $this->collTargets;
                $this->targetsScheduledForDeletion->clear();
            }
            $this->targetsScheduledForDeletion[]= clone $target;
            $target->setTargetType(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TargetType is new, it will return
     * an empty collection; or if this TargetType has previously
     * been saved, it will retrieve related Targets from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TargetType.
     *
     * @param  Criteria                       $criteria     optional Criteria object to narrow the query
     * @param  ConnectionInterface            $con          optional connection object
     * @param  string                         $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTarget[] List of ChildTarget objects
     */
    public function getTargetsJoinTargetGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTargetQuery::create(null, $criteria);
        $query->joinWith('TargetGroup', $joinBehavior);

        return $this->getTargets($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_target_type = null;
        $this->target_type_class = null;
        $this->target_type_name = null;
        $this->target_type_description = null;
        $this->target_type_active = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collStackTestResultPasses) {
                foreach ($this->collStackTestResultPasses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTargets) {
                foreach ($this->collTargets as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collStackTestResultPasses = null;
        $this->collTargets = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'target_type_name' column
     */
    public function __toString()
    {
        return (string) $this->getTargetTypeName();
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return $this|ChildTargetType The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TargetTypeTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }

    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
