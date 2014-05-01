<?php

namespace Base;

use \Channel as ChildChannel;
use \ChannelQuery as ChildChannelQuery;
use \Trigger as ChildTrigger;
use \TriggerQuery as ChildTriggerQuery;
use \TriggerType as ChildTriggerType;
use \TriggerTypeQuery as ChildTriggerTypeQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\TriggerTypeTableMap;
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

abstract class TriggerType implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TriggerTypeTableMap';


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
     * The value for the id_trigger_type field.
     * @var        int
     */
    protected $id_trigger_type;

    /**
     * The value for the channel_id field.
     * @var        int
     */
    protected $channel_id;

    /**
     * The value for the trigger_type_class field.
     * @var        string
     */
    protected $trigger_type_class;

    /**
     * The value for the trigger_type_name field.
     * @var        string
     */
    protected $trigger_type_name;

    /**
     * The value for the trigger_type_description field.
     * @var        string
     */
    protected $trigger_type_description;

    /**
     * The value for the trigger_type_active field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $trigger_type_active;

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
     * @var        ChildChannel
     */
    protected $aChannel;

    /**
     * @var        ObjectCollection|ChildTrigger[] Collection to store aggregation of ChildTrigger objects.
     */
    protected $collTriggers;
    protected $collTriggersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrigger[]
     */
    protected $triggersScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->trigger_type_active = false;
    }

    /**
     * Initializes internal state of Base\TriggerType object.
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
     * Compares this with another <code>TriggerType</code> instance.  If
     * <code>obj</code> is an instance of <code>TriggerType</code>, delegates to
     * <code>equals(TriggerType)</code>.  Otherwise, returns <code>false</code>.
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

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey())  {
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
     * @return $this|TriggerType The current object, for fluid interface
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
     * Get the [id_trigger_type] column value.
     *
     * @return   int
     */
    public function getIdTriggerType()
    {
        return $this->id_trigger_type;
    }

    /**
     * Get the [channel_id] column value.
     *
     * @return   int
     */
    public function getChannelId()
    {
        return $this->channel_id;
    }

    /**
     * Get the [trigger_type_class] column value.
     *
     * @return   string
     */
    public function getTriggerTypeClass()
    {
        return $this->trigger_type_class;
    }

    /**
     * Get the [trigger_type_name] column value.
     *
     * @return   string
     */
    public function getTriggerTypeName()
    {
        return $this->trigger_type_name;
    }

    /**
     * Get the [trigger_type_description] column value.
     *
     * @return   string
     */
    public function getTriggerTypeDescription()
    {
        return $this->trigger_type_description;
    }

    /**
     * Get the [trigger_type_active] column value.
     *
     * @return   boolean
     */
    public function getTriggerTypeActive()
    {
        return $this->trigger_type_active;
    }

    /**
     * Get the [trigger_type_active] column value.
     *
     * @return   boolean
     */
    public function isTriggerTypeActive()
    {
        return $this->getTriggerTypeActive();
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
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
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
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
     * Set the value of [id_trigger_type] column.
     *
     * @param      int $v new value
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setIdTriggerType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_trigger_type !== $v) {
            $this->id_trigger_type = $v;
            $this->modifiedColumns[TriggerTypeTableMap::COL_ID_TRIGGER_TYPE] = true;
        }

        return $this;
    } // setIdTriggerType()

    /**
     * Set the value of [channel_id] column.
     *
     * @param      int $v new value
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setChannelId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->channel_id !== $v) {
            $this->channel_id = $v;
            $this->modifiedColumns[TriggerTypeTableMap::COL_CHANNEL_ID] = true;
        }

        if ($this->aChannel !== null && $this->aChannel->getIdChannel() !== $v) {
            $this->aChannel = null;
        }

        return $this;
    } // setChannelId()

    /**
     * Set the value of [trigger_type_class] column.
     *
     * @param      string $v new value
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setTriggerTypeClass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_type_class !== $v) {
            $this->trigger_type_class = $v;
            $this->modifiedColumns[TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS] = true;
        }

        return $this;
    } // setTriggerTypeClass()

    /**
     * Set the value of [trigger_type_name] column.
     *
     * @param      string $v new value
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setTriggerTypeName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_type_name !== $v) {
            $this->trigger_type_name = $v;
            $this->modifiedColumns[TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME] = true;
        }

        return $this;
    } // setTriggerTypeName()

    /**
     * Set the value of [trigger_type_description] column.
     *
     * @param      string $v new value
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setTriggerTypeDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_type_description !== $v) {
            $this->trigger_type_description = $v;
            $this->modifiedColumns[TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION] = true;
        }

        return $this;
    } // setTriggerTypeDescription()

    /**
     * Sets the value of the [trigger_type_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setTriggerTypeActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->trigger_type_active !== $v) {
            $this->trigger_type_active = $v;
            $this->modifiedColumns[TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE] = true;
        }

        return $this;
    } // setTriggerTypeActive()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[TriggerTypeTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\TriggerType The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[TriggerTypeTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

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
            if ($this->trigger_type_active !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TriggerTypeTableMap::translateFieldName('IdTriggerType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_trigger_type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TriggerTypeTableMap::translateFieldName('ChannelId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TriggerTypeTableMap::translateFieldName('TriggerTypeClass', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_type_class = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TriggerTypeTableMap::translateFieldName('TriggerTypeName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_type_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TriggerTypeTableMap::translateFieldName('TriggerTypeDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_type_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TriggerTypeTableMap::translateFieldName('TriggerTypeActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_type_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TriggerTypeTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TriggerTypeTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = TriggerTypeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\TriggerType'), 0, $e);
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
        if ($this->aChannel !== null && $this->channel_id !== $this->aChannel->getIdChannel()) {
            $this->aChannel = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
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
            $con = Propel::getServiceContainer()->getReadConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTriggerTypeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aChannel = null;
            $this->collTriggers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TriggerType::setDeleted()
     * @see TriggerType::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTriggerTypeQuery::create()
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
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(TriggerTypeTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(TriggerTypeTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TriggerTypeTableMap::COL_UPDATED_AT)) {
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
                TriggerTypeTableMap::addInstanceToPool($this);
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
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aChannel !== null) {
                if ($this->aChannel->isModified() || $this->aChannel->isNew()) {
                    $affectedRows += $this->aChannel->save($con);
                }
                $this->setChannel($this->aChannel);
            }

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

            if ($this->triggersScheduledForDeletion !== null) {
                if (!$this->triggersScheduledForDeletion->isEmpty()) {
                    \TriggerQuery::create()
                        ->filterByPrimaryKeys($this->triggersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->triggersScheduledForDeletion = null;
                }
            }

            if ($this->collTriggers !== null) {
                foreach ($this->collTriggers as $referrerFK) {
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
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TriggerTypeTableMap::COL_ID_TRIGGER_TYPE] = true;
        if (null !== $this->id_trigger_type) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TriggerTypeTableMap::COL_ID_TRIGGER_TYPE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'ID_TRIGGER_TYPE';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_CHANNEL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CHANNEL_ID';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_TYPE_CLASS';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_TYPE_NAME';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_TYPE_DESCRIPTION';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_TYPE_ACTIVE';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO ""trigger_type (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_TRIGGER_TYPE':
                        $stmt->bindValue($identifier, $this->id_trigger_type, PDO::PARAM_INT);
                        break;
                    case 'CHANNEL_ID':
                        $stmt->bindValue($identifier, $this->channel_id, PDO::PARAM_INT);
                        break;
                    case 'TRIGGER_TYPE_CLASS':
                        $stmt->bindValue($identifier, $this->trigger_type_class, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_TYPE_NAME':
                        $stmt->bindValue($identifier, $this->trigger_type_name, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_TYPE_DESCRIPTION':
                        $stmt->bindValue($identifier, $this->trigger_type_description, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_TYPE_ACTIVE':
                        $stmt->bindValue($identifier, (int) $this->trigger_type_active, PDO::PARAM_INT);
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
        $this->setIdTriggerType($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
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
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TriggerTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdTriggerType();
                break;
            case 1:
                return $this->getChannelId();
                break;
            case 2:
                return $this->getTriggerTypeClass();
                break;
            case 3:
                return $this->getTriggerTypeName();
                break;
            case 4:
                return $this->getTriggerTypeDescription();
                break;
            case 5:
                return $this->getTriggerTypeActive();
                break;
            case 6:
                return $this->getCreatedAt();
                break;
            case 7:
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['TriggerType'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TriggerType'][$this->getPrimaryKey()] = true;
        $keys = TriggerTypeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTriggerType(),
            $keys[1] => $this->getChannelId(),
            $keys[2] => $this->getTriggerTypeClass(),
            $keys[3] => $this->getTriggerTypeName(),
            $keys[4] => $this->getTriggerTypeDescription(),
            $keys[5] => $this->getTriggerTypeActive(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aChannel) {
                $result['Channel'] = $this->aChannel->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTriggers) {
                $result['Triggers'] = $this->collTriggers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return     $this|\TriggerType
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TriggerTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return     $this|\TriggerType
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTriggerType($value);
                break;
            case 1:
                $this->setChannelId($value);
                break;
            case 2:
                $this->setTriggerTypeClass($value);
                break;
            case 3:
                $this->setTriggerTypeName($value);
                break;
            case 4:
                $this->setTriggerTypeDescription($value);
                break;
            case 5:
                $this->setTriggerTypeActive($value);
                break;
            case 6:
                $this->setCreatedAt($value);
                break;
            case 7:
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
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TriggerTypeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdTriggerType($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setChannelId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTriggerTypeClass($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTriggerTypeName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTriggerTypeDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTriggerTypeActive($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCreatedAt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUpdatedAt($arr[$keys[7]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return $this|\TriggerType The current object, for fluid interface
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
        $criteria = new Criteria(TriggerTypeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE)) {
            $criteria->add(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $this->id_trigger_type);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_CHANNEL_ID)) {
            $criteria->add(TriggerTypeTableMap::COL_CHANNEL_ID, $this->channel_id);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS)) {
            $criteria->add(TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS, $this->trigger_type_class);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME)) {
            $criteria->add(TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME, $this->trigger_type_name);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION)) {
            $criteria->add(TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION, $this->trigger_type_description);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE)) {
            $criteria->add(TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE, $this->trigger_type_active);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_CREATED_AT)) {
            $criteria->add(TriggerTypeTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TriggerTypeTableMap::COL_UPDATED_AT)) {
            $criteria->add(TriggerTypeTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = new Criteria(TriggerTypeTableMap::DATABASE_NAME);
        $criteria->add(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $this->id_trigger_type);

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
        $validPk = null !== $this->getIdTriggerType();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } else if ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getIdTriggerType();
    }

    /**
     * Generic method to set the primary key (id_trigger_type column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTriggerType($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdTriggerType();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \TriggerType (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setChannelId($this->getChannelId());
        $copyObj->setTriggerTypeClass($this->getTriggerTypeClass());
        $copyObj->setTriggerTypeName($this->getTriggerTypeName());
        $copyObj->setTriggerTypeDescription($this->getTriggerTypeDescription());
        $copyObj->setTriggerTypeActive($this->getTriggerTypeActive());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTriggers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTrigger($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTriggerType(NULL); // this is a auto-increment column, so set to default value
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
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \TriggerType Clone of current object.
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
     * Declares an association between this object and a ChildChannel object.
     *
     * @param                  ChildChannel $v
     * @return                 $this|\TriggerType The current object (for fluent API support)
     * @throws PropelException
     */
    public function setChannel(ChildChannel $v = null)
    {
        if ($v === null) {
            $this->setChannelId(NULL);
        } else {
            $this->setChannelId($v->getIdChannel());
        }

        $this->aChannel = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildChannel object, it will not be re-added.
        if ($v !== null) {
            $v->addTriggerType($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildChannel object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildChannel The associated ChildChannel object.
     * @throws PropelException
     */
    public function getChannel(ConnectionInterface $con = null)
    {
        if ($this->aChannel === null && ($this->channel_id !== null)) {
            $this->aChannel = ChildChannelQuery::create()->findPk($this->channel_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aChannel->addTriggerTypes($this);
             */
        }

        return $this->aChannel;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Trigger' == $relationName) {
            return $this->initTriggers();
        }
    }

    /**
     * Clears out the collTriggers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTriggers()
     */
    public function clearTriggers()
    {
        $this->collTriggers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTriggers collection loaded partially.
     */
    public function resetPartialTriggers($v = true)
    {
        $this->collTriggersPartial = $v;
    }

    /**
     * Initializes the collTriggers collection.
     *
     * By default this just sets the collTriggers collection to an empty array (like clearcollTriggers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTriggers($overrideExisting = true)
    {
        if (null !== $this->collTriggers && !$overrideExisting) {
            return;
        }
        $this->collTriggers = new ObjectCollection();
        $this->collTriggers->setModel('\Trigger');
    }

    /**
     * Gets an array of ChildTrigger objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTriggerType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTrigger[] List of ChildTrigger objects
     * @throws PropelException
     */
    public function getTriggers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggersPartial && !$this->isNew();
        if (null === $this->collTriggers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTriggers) {
                // return empty collection
                $this->initTriggers();
            } else {
                $collTriggers = ChildTriggerQuery::create(null, $criteria)
                    ->filterByTriggerType($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTriggersPartial && count($collTriggers)) {
                        $this->initTriggers(false);

                        foreach ($collTriggers as $obj) {
                            if (false == $this->collTriggers->contains($obj)) {
                                $this->collTriggers->append($obj);
                            }
                        }

                        $this->collTriggersPartial = true;
                    }

                    $collTriggers->rewind();

                    return $collTriggers;
                }

                if ($partial && $this->collTriggers) {
                    foreach ($this->collTriggers as $obj) {
                        if ($obj->isNew()) {
                            $collTriggers[] = $obj;
                        }
                    }
                }

                $this->collTriggers = $collTriggers;
                $this->collTriggersPartial = false;
            }
        }

        return $this->collTriggers;
    }

    /**
     * Sets a collection of ChildTrigger objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $triggers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTriggerType The current object (for fluent API support)
     */
    public function setTriggers(Collection $triggers, ConnectionInterface $con = null)
    {
        /** @var ChildTrigger[] $triggersToDelete */
        $triggersToDelete = $this->getTriggers(new Criteria(), $con)->diff($triggers);


        $this->triggersScheduledForDeletion = $triggersToDelete;

        foreach ($triggersToDelete as $triggerRemoved) {
            $triggerRemoved->setTriggerType(null);
        }

        $this->collTriggers = null;
        foreach ($triggers as $trigger) {
            $this->addTrigger($trigger);
        }

        $this->collTriggers = $triggers;
        $this->collTriggersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Trigger objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Trigger objects.
     * @throws PropelException
     */
    public function countTriggers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggersPartial && !$this->isNew();
        if (null === $this->collTriggers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTriggers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTriggers());
            }

            $query = ChildTriggerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTriggerType($this)
                ->count($con);
        }

        return count($this->collTriggers);
    }

    /**
     * Method called to associate a ChildTrigger object to this object
     * through the ChildTrigger foreign key attribute.
     *
     * @param    ChildTrigger $l ChildTrigger
     * @return   $this|\TriggerType The current object (for fluent API support)
     */
    public function addTrigger(ChildTrigger $l)
    {
        if ($this->collTriggers === null) {
            $this->initTriggers();
            $this->collTriggersPartial = true;
        }

        if (!$this->collTriggers->contains($l)) {
            $this->doAddTrigger($l);
        }

        return $this;
    }

    /**
     * @param ChildTrigger $trigger The ChildTrigger object to add.
     */
    protected function doAddTrigger(ChildTrigger $trigger)
    {
        $this->collTriggers[]= $trigger;
        $trigger->setTriggerType($this);
    }

    /**
     * @param  ChildTrigger $trigger The ChildTrigger object to remove.
     * @return $this|ChildTriggerType The current object (for fluent API support)
     */
    public function removeTrigger(ChildTrigger $trigger)
    {
        if ($this->getTriggers()->contains($trigger)) {
            $pos = $this->collTriggers->search($trigger);
            $this->collTriggers->remove($pos);
            if (null === $this->triggersScheduledForDeletion) {
                $this->triggersScheduledForDeletion = clone $this->collTriggers;
                $this->triggersScheduledForDeletion->clear();
            }
            $this->triggersScheduledForDeletion[]= clone $trigger;
            $trigger->setTriggerType(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TriggerType is new, it will return
     * an empty collection; or if this TriggerType has previously
     * been saved, it will retrieve related Triggers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TriggerType.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrigger[] List of ChildTrigger objects
     */
    public function getTriggersJoinTarget(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTriggerQuery::create(null, $criteria);
        $query->joinWith('Target', $joinBehavior);

        return $this->getTriggers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TriggerType is new, it will return
     * an empty collection; or if this TriggerType has previously
     * been saved, it will retrieve related Triggers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TriggerType.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrigger[] List of ChildTrigger objects
     */
    public function getTriggersJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTriggerQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getTriggers($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aChannel) {
            $this->aChannel->removeTriggerType($this);
        }
        $this->id_trigger_type = null;
        $this->channel_id = null;
        $this->trigger_type_class = null;
        $this->trigger_type_name = null;
        $this->trigger_type_description = null;
        $this->trigger_type_active = null;
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
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTriggers) {
                foreach ($this->collTriggers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTriggers = null;
        $this->aChannel = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'trigger_type_name' column
     */
    public function __toString()
    {
        return (string) $this->getTriggerTypeName();
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTriggerType The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TriggerTypeTableMap::COL_UPDATED_AT] = true;

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
