<?php

namespace Base;

use \Target as ChildTarget;
use \TargetQuery as ChildTargetQuery;
use \Trigger as ChildTrigger;
use \TriggerLog as ChildTriggerLog;
use \TriggerLogQuery as ChildTriggerLogQuery;
use \TriggerQuery as ChildTriggerQuery;
use \TriggerType as ChildTriggerType;
use \TriggerTypeQuery as ChildTriggerTypeQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\TriggerTableMap;
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

abstract class Trigger implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TriggerTableMap';


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
     * The value for the id_trigger field.
     * @var        int
     */
    protected $id_trigger;

    /**
     * The value for the target_id field.
     * @var        int
     */
    protected $target_id;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the trigger_type_id field.
     * @var        int
     */
    protected $trigger_type_id;

    /**
     * The value for the trigger_params field.
     * @var        string
     */
    protected $trigger_params;

    /**
     * The value for the trigger_invoke_on field.
     * Note: this column has a database default value of: 'TEST_FALSE'
     * @var        string
     */
    protected $trigger_invoke_on;

    /**
     * The value for the trigger_name field.
     * @var        string
     */
    protected $trigger_name;

    /**
     * The value for the trigger_active field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $trigger_active;

    /**
     * The value for the trigger_last_executed_at field.
     * @var        \DateTime
     */
    protected $trigger_last_executed_at;

    /**
     * The value for the trigger_last_executed_result field.
     * @var        string
     */
    protected $trigger_last_executed_result;

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
     * @var        ChildTarget
     */
    protected $aTarget;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildTriggerType
     */
    protected $aTriggerType;

    /**
     * @var        ObjectCollection|ChildTriggerLog[] Collection to store aggregation of ChildTriggerLog objects.
     */
    protected $collTriggerLogs;
    protected $collTriggerLogsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTriggerLog[]
     */
    protected $triggerLogsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->trigger_invoke_on = 'TEST_FALSE';
        $this->trigger_active = false;
    }

    /**
     * Initializes internal state of Base\Trigger object.
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
     * Compares this with another <code>Trigger</code> instance.  If
     * <code>obj</code> is an instance of <code>Trigger</code>, delegates to
     * <code>equals(Trigger)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Trigger The current object, for fluid interface
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
     * Get the [id_trigger] column value.
     *
     * @return   int
     */
    public function getIdTrigger()
    {
        return $this->id_trigger;
    }

    /**
     * Get the [target_id] column value.
     *
     * @return   int
     */
    public function getTargetId()
    {
        return $this->target_id;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return   int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [trigger_type_id] column value.
     *
     * @return   int
     */
    public function getTriggerTypeId()
    {
        return $this->trigger_type_id;
    }

    /**
     * Get the [trigger_params] column value.
     *
     * @return   string
     */
    public function getTriggerParams()
    {
        return $this->trigger_params;
    }

    /**
     * Get the [trigger_invoke_on] column value.
     *
     * @return   string
     */
    public function getTriggerInvokeOn()
    {
        return $this->trigger_invoke_on;
    }

    /**
     * Get the [trigger_name] column value.
     *
     * @return   string
     */
    public function getTriggerName()
    {
        return $this->trigger_name;
    }

    /**
     * Get the [trigger_active] column value.
     *
     * @return   boolean
     */
    public function getTriggerActive()
    {
        return $this->trigger_active;
    }

    /**
     * Get the [trigger_active] column value.
     *
     * @return   boolean
     */
    public function isTriggerActive()
    {
        return $this->getTriggerActive();
    }

    /**
     * Get the [optionally formatted] temporal [trigger_last_executed_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return string|\DateTime Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTriggerLastExecutedAt($format = NULL)
    {
        if ($format === null) {
            return $this->trigger_last_executed_at;
        } else {
            return $this->trigger_last_executed_at instanceof \DateTime ? $this->trigger_last_executed_at->format($format) : null;
        }
    }

    /**
     * Get the [trigger_last_executed_result] column value.
     *
     * @return   string
     */
    public function getTriggerLastExecutedResult()
    {
        return $this->trigger_last_executed_result;
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
     * Set the value of [id_trigger] column.
     *
     * @param      int $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setIdTrigger($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_trigger !== $v) {
            $this->id_trigger = $v;
            $this->modifiedColumns[TriggerTableMap::COL_ID_TRIGGER] = true;
        }

        return $this;
    } // setIdTrigger()

    /**
     * Set the value of [target_id] column.
     *
     * @param      int $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTargetId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target_id !== $v) {
            $this->target_id = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TARGET_ID] = true;
        }

        if ($this->aTarget !== null && $this->aTarget->getIdTarget() !== $v) {
            $this->aTarget = null;
        }

        return $this;
    } // setTargetId()

    /**
     * Set the value of [user_id] column.
     *
     * @param      int $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[TriggerTableMap::COL_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getIdUser() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [trigger_type_id] column.
     *
     * @param      int $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->trigger_type_id !== $v) {
            $this->trigger_type_id = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_TYPE_ID] = true;
        }

        if ($this->aTriggerType !== null && $this->aTriggerType->getIdTriggerType() !== $v) {
            $this->aTriggerType = null;
        }

        return $this;
    } // setTriggerTypeId()

    /**
     * Set the value of [trigger_params] column.
     *
     * @param      string $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerParams($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_params !== $v) {
            $this->trigger_params = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_PARAMS] = true;
        }

        return $this;
    } // setTriggerParams()

    /**
     * Set the value of [trigger_invoke_on] column.
     *
     * @param      string $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerInvokeOn($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_invoke_on !== $v) {
            $this->trigger_invoke_on = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_INVOKE_ON] = true;
        }

        return $this;
    } // setTriggerInvokeOn()

    /**
     * Set the value of [trigger_name] column.
     *
     * @param      string $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_name !== $v) {
            $this->trigger_name = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_NAME] = true;
        }

        return $this;
    } // setTriggerName()

    /**
     * Sets the value of the [trigger_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->trigger_active !== $v) {
            $this->trigger_active = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_ACTIVE] = true;
        }

        return $this;
    } // setTriggerActive()

    /**
     * Sets the value of [trigger_last_executed_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerLastExecutedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->trigger_last_executed_at !== null || $dt !== null) {
            if ($dt !== $this->trigger_last_executed_at) {
                $this->trigger_last_executed_at = $dt;
                $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setTriggerLastExecutedAt()

    /**
     * Set the value of [trigger_last_executed_result] column.
     *
     * @param      string $v new value
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setTriggerLastExecutedResult($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_last_executed_result !== $v) {
            $this->trigger_last_executed_result = $v;
            $this->modifiedColumns[TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT] = true;
        }

        return $this;
    } // setTriggerLastExecutedResult()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[TriggerTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\Trigger The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[TriggerTableMap::COL_UPDATED_AT] = true;
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
            if ($this->trigger_invoke_on !== 'TEST_FALSE') {
                return false;
            }

            if ($this->trigger_active !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TriggerTableMap::translateFieldName('IdTrigger', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_trigger = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TriggerTableMap::translateFieldName('TargetId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TriggerTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TriggerTableMap::translateFieldName('TriggerTypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TriggerTableMap::translateFieldName('TriggerParams', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_params = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TriggerTableMap::translateFieldName('TriggerInvokeOn', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_invoke_on = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TriggerTableMap::translateFieldName('TriggerName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TriggerTableMap::translateFieldName('TriggerActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TriggerTableMap::translateFieldName('TriggerLastExecutedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->trigger_last_executed_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TriggerTableMap::translateFieldName('TriggerLastExecutedResult', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_last_executed_result = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : TriggerTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : TriggerTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = TriggerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Trigger'), 0, $e);
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
        if ($this->aTarget !== null && $this->target_id !== $this->aTarget->getIdTarget()) {
            $this->aTarget = null;
        }
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getIdUser()) {
            $this->aUser = null;
        }
        if ($this->aTriggerType !== null && $this->trigger_type_id !== $this->aTriggerType->getIdTriggerType()) {
            $this->aTriggerType = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(TriggerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTriggerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTarget = null;
            $this->aUser = null;
            $this->aTriggerType = null;
            $this->collTriggerLogs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Trigger::setDeleted()
     * @see Trigger::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTriggerQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(TriggerTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(TriggerTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TriggerTableMap::COL_UPDATED_AT)) {
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
                TriggerTableMap::addInstanceToPool($this);
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

            if ($this->aTarget !== null) {
                if ($this->aTarget->isModified() || $this->aTarget->isNew()) {
                    $affectedRows += $this->aTarget->save($con);
                }
                $this->setTarget($this->aTarget);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aTriggerType !== null) {
                if ($this->aTriggerType->isModified() || $this->aTriggerType->isNew()) {
                    $affectedRows += $this->aTriggerType->save($con);
                }
                $this->setTriggerType($this->aTriggerType);
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

            if ($this->triggerLogsScheduledForDeletion !== null) {
                if (!$this->triggerLogsScheduledForDeletion->isEmpty()) {
                    \TriggerLogQuery::create()
                        ->filterByPrimaryKeys($this->triggerLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->triggerLogsScheduledForDeletion = null;
                }
            }

            if ($this->collTriggerLogs !== null) {
                foreach ($this->collTriggerLogs as $referrerFK) {
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

        $this->modifiedColumns[TriggerTableMap::COL_ID_TRIGGER] = true;
        if (null !== $this->id_trigger) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TriggerTableMap::COL_ID_TRIGGER . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TriggerTableMap::COL_ID_TRIGGER)) {
            $modifiedColumns[':p' . $index++]  = 'ID_TRIGGER';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TARGET_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_ID';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'USER_ID';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_TYPE_ID';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_PARAMS)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_PARAMS';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_INVOKE_ON)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_INVOKE_ON';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_NAME';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_ACTIVE';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_LAST_EXECUTED_AT';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT)) {
            $modifiedColumns[':p' . $index++]  = 'TRIGGER_LAST_EXECUTED_RESULT';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(TriggerTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO ""trigger (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_TRIGGER':
                        $stmt->bindValue($identifier, $this->id_trigger, PDO::PARAM_INT);
                        break;
                    case 'TARGET_ID':
                        $stmt->bindValue($identifier, $this->target_id, PDO::PARAM_INT);
                        break;
                    case 'USER_ID':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'TRIGGER_TYPE_ID':
                        $stmt->bindValue($identifier, $this->trigger_type_id, PDO::PARAM_INT);
                        break;
                    case 'TRIGGER_PARAMS':
                        $stmt->bindValue($identifier, $this->trigger_params, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_INVOKE_ON':
                        $stmt->bindValue($identifier, $this->trigger_invoke_on, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_NAME':
                        $stmt->bindValue($identifier, $this->trigger_name, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_ACTIVE':
                        $stmt->bindValue($identifier, (int) $this->trigger_active, PDO::PARAM_INT);
                        break;
                    case 'TRIGGER_LAST_EXECUTED_AT':
                        $stmt->bindValue($identifier, $this->trigger_last_executed_at ? $this->trigger_last_executed_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'TRIGGER_LAST_EXECUTED_RESULT':
                        $stmt->bindValue($identifier, $this->trigger_last_executed_result, PDO::PARAM_STR);
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
        $this->setIdTrigger($pk);

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
        $pos = TriggerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdTrigger();
                break;
            case 1:
                return $this->getTargetId();
                break;
            case 2:
                return $this->getUserId();
                break;
            case 3:
                return $this->getTriggerTypeId();
                break;
            case 4:
                return $this->getTriggerParams();
                break;
            case 5:
                return $this->getTriggerInvokeOn();
                break;
            case 6:
                return $this->getTriggerName();
                break;
            case 7:
                return $this->getTriggerActive();
                break;
            case 8:
                return $this->getTriggerLastExecutedAt();
                break;
            case 9:
                return $this->getTriggerLastExecutedResult();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
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
        if (isset($alreadyDumpedObjects['Trigger'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Trigger'][$this->getPrimaryKey()] = true;
        $keys = TriggerTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTrigger(),
            $keys[1] => $this->getTargetId(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getTriggerTypeId(),
            $keys[4] => $this->getTriggerParams(),
            $keys[5] => $this->getTriggerInvokeOn(),
            $keys[6] => $this->getTriggerName(),
            $keys[7] => $this->getTriggerActive(),
            $keys[8] => $this->getTriggerLastExecutedAt(),
            $keys[9] => $this->getTriggerLastExecutedResult(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTarget) {
                $result['Target'] = $this->aTarget->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTriggerType) {
                $result['TriggerType'] = $this->aTriggerType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTriggerLogs) {
                $result['TriggerLogs'] = $this->collTriggerLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return     $this|\Trigger
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TriggerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return     $this|\Trigger
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTrigger($value);
                break;
            case 1:
                $this->setTargetId($value);
                break;
            case 2:
                $this->setUserId($value);
                break;
            case 3:
                $this->setTriggerTypeId($value);
                break;
            case 4:
                $this->setTriggerParams($value);
                break;
            case 5:
                $this->setTriggerInvokeOn($value);
                break;
            case 6:
                $this->setTriggerName($value);
                break;
            case 7:
                $this->setTriggerActive($value);
                break;
            case 8:
                $this->setTriggerLastExecutedAt($value);
                break;
            case 9:
                $this->setTriggerLastExecutedResult($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
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
        $keys = TriggerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdTrigger($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTargetId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTriggerTypeId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTriggerParams($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTriggerInvokeOn($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTriggerName($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTriggerActive($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setTriggerLastExecutedAt($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setTriggerLastExecutedResult($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
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
     * @return $this|\Trigger The current object, for fluid interface
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
        $criteria = new Criteria(TriggerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TriggerTableMap::COL_ID_TRIGGER)) {
            $criteria->add(TriggerTableMap::COL_ID_TRIGGER, $this->id_trigger);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TARGET_ID)) {
            $criteria->add(TriggerTableMap::COL_TARGET_ID, $this->target_id);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_USER_ID)) {
            $criteria->add(TriggerTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_TYPE_ID)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_TYPE_ID, $this->trigger_type_id);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_PARAMS)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_PARAMS, $this->trigger_params);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_INVOKE_ON)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_INVOKE_ON, $this->trigger_invoke_on);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_NAME)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_NAME, $this->trigger_name);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_ACTIVE)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_ACTIVE, $this->trigger_active);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT, $this->trigger_last_executed_at);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT)) {
            $criteria->add(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT, $this->trigger_last_executed_result);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_CREATED_AT)) {
            $criteria->add(TriggerTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TriggerTableMap::COL_UPDATED_AT)) {
            $criteria->add(TriggerTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = new Criteria(TriggerTableMap::DATABASE_NAME);
        $criteria->add(TriggerTableMap::COL_ID_TRIGGER, $this->id_trigger);

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
        $validPk = null !== $this->getIdTrigger();

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
        return $this->getIdTrigger();
    }

    /**
     * Generic method to set the primary key (id_trigger column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTrigger($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdTrigger();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Trigger (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTargetId($this->getTargetId());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setTriggerTypeId($this->getTriggerTypeId());
        $copyObj->setTriggerParams($this->getTriggerParams());
        $copyObj->setTriggerInvokeOn($this->getTriggerInvokeOn());
        $copyObj->setTriggerName($this->getTriggerName());
        $copyObj->setTriggerActive($this->getTriggerActive());
        $copyObj->setTriggerLastExecutedAt($this->getTriggerLastExecutedAt());
        $copyObj->setTriggerLastExecutedResult($this->getTriggerLastExecutedResult());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTriggerLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTriggerLog($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTrigger(NULL); // this is a auto-increment column, so set to default value
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
     * @return                 \Trigger Clone of current object.
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
     * Declares an association between this object and a ChildTarget object.
     *
     * @param                  ChildTarget $v
     * @return                 $this|\Trigger The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTarget(ChildTarget $v = null)
    {
        if ($v === null) {
            $this->setTargetId(NULL);
        } else {
            $this->setTargetId($v->getIdTarget());
        }

        $this->aTarget = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTarget object, it will not be re-added.
        if ($v !== null) {
            $v->addTrigger($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTarget object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildTarget The associated ChildTarget object.
     * @throws PropelException
     */
    public function getTarget(ConnectionInterface $con = null)
    {
        if ($this->aTarget === null && ($this->target_id !== null)) {
            $this->aTarget = ChildTargetQuery::create()->findPk($this->target_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTarget->addTriggers($this);
             */
        }

        return $this->aTarget;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param                  ChildUser $v
     * @return                 $this|\Trigger The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getIdUser());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addTrigger($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addTriggers($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildTriggerType object.
     *
     * @param                  ChildTriggerType $v
     * @return                 $this|\Trigger The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTriggerType(ChildTriggerType $v = null)
    {
        if ($v === null) {
            $this->setTriggerTypeId(NULL);
        } else {
            $this->setTriggerTypeId($v->getIdTriggerType());
        }

        $this->aTriggerType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTriggerType object, it will not be re-added.
        if ($v !== null) {
            $v->addTrigger($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTriggerType object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildTriggerType The associated ChildTriggerType object.
     * @throws PropelException
     */
    public function getTriggerType(ConnectionInterface $con = null)
    {
        if ($this->aTriggerType === null && ($this->trigger_type_id !== null)) {
            $this->aTriggerType = ChildTriggerTypeQuery::create()->findPk($this->trigger_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTriggerType->addTriggers($this);
             */
        }

        return $this->aTriggerType;
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
        if ('TriggerLog' == $relationName) {
            return $this->initTriggerLogs();
        }
    }

    /**
     * Clears out the collTriggerLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTriggerLogs()
     */
    public function clearTriggerLogs()
    {
        $this->collTriggerLogs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTriggerLogs collection loaded partially.
     */
    public function resetPartialTriggerLogs($v = true)
    {
        $this->collTriggerLogsPartial = $v;
    }

    /**
     * Initializes the collTriggerLogs collection.
     *
     * By default this just sets the collTriggerLogs collection to an empty array (like clearcollTriggerLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTriggerLogs($overrideExisting = true)
    {
        if (null !== $this->collTriggerLogs && !$overrideExisting) {
            return;
        }
        $this->collTriggerLogs = new ObjectCollection();
        $this->collTriggerLogs->setModel('\TriggerLog');
    }

    /**
     * Gets an array of ChildTriggerLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTrigger is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTriggerLog[] List of ChildTriggerLog objects
     * @throws PropelException
     */
    public function getTriggerLogs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggerLogsPartial && !$this->isNew();
        if (null === $this->collTriggerLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTriggerLogs) {
                // return empty collection
                $this->initTriggerLogs();
            } else {
                $collTriggerLogs = ChildTriggerLogQuery::create(null, $criteria)
                    ->filterByTrigger($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTriggerLogsPartial && count($collTriggerLogs)) {
                        $this->initTriggerLogs(false);

                        foreach ($collTriggerLogs as $obj) {
                            if (false == $this->collTriggerLogs->contains($obj)) {
                                $this->collTriggerLogs->append($obj);
                            }
                        }

                        $this->collTriggerLogsPartial = true;
                    }

                    $collTriggerLogs->rewind();

                    return $collTriggerLogs;
                }

                if ($partial && $this->collTriggerLogs) {
                    foreach ($this->collTriggerLogs as $obj) {
                        if ($obj->isNew()) {
                            $collTriggerLogs[] = $obj;
                        }
                    }
                }

                $this->collTriggerLogs = $collTriggerLogs;
                $this->collTriggerLogsPartial = false;
            }
        }

        return $this->collTriggerLogs;
    }

    /**
     * Sets a collection of ChildTriggerLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $triggerLogs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTrigger The current object (for fluent API support)
     */
    public function setTriggerLogs(Collection $triggerLogs, ConnectionInterface $con = null)
    {
        /** @var ChildTriggerLog[] $triggerLogsToDelete */
        $triggerLogsToDelete = $this->getTriggerLogs(new Criteria(), $con)->diff($triggerLogs);


        $this->triggerLogsScheduledForDeletion = $triggerLogsToDelete;

        foreach ($triggerLogsToDelete as $triggerLogRemoved) {
            $triggerLogRemoved->setTrigger(null);
        }

        $this->collTriggerLogs = null;
        foreach ($triggerLogs as $triggerLog) {
            $this->addTriggerLog($triggerLog);
        }

        $this->collTriggerLogs = $triggerLogs;
        $this->collTriggerLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TriggerLog objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TriggerLog objects.
     * @throws PropelException
     */
    public function countTriggerLogs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggerLogsPartial && !$this->isNew();
        if (null === $this->collTriggerLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTriggerLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTriggerLogs());
            }

            $query = ChildTriggerLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTrigger($this)
                ->count($con);
        }

        return count($this->collTriggerLogs);
    }

    /**
     * Method called to associate a ChildTriggerLog object to this object
     * through the ChildTriggerLog foreign key attribute.
     *
     * @param    ChildTriggerLog $l ChildTriggerLog
     * @return   $this|\Trigger The current object (for fluent API support)
     */
    public function addTriggerLog(ChildTriggerLog $l)
    {
        if ($this->collTriggerLogs === null) {
            $this->initTriggerLogs();
            $this->collTriggerLogsPartial = true;
        }

        if (!$this->collTriggerLogs->contains($l)) {
            $this->doAddTriggerLog($l);
        }

        return $this;
    }

    /**
     * @param ChildTriggerLog $triggerLog The ChildTriggerLog object to add.
     */
    protected function doAddTriggerLog(ChildTriggerLog $triggerLog)
    {
        $this->collTriggerLogs[]= $triggerLog;
        $triggerLog->setTrigger($this);
    }

    /**
     * @param  ChildTriggerLog $triggerLog The ChildTriggerLog object to remove.
     * @return $this|ChildTrigger The current object (for fluent API support)
     */
    public function removeTriggerLog(ChildTriggerLog $triggerLog)
    {
        if ($this->getTriggerLogs()->contains($triggerLog)) {
            $pos = $this->collTriggerLogs->search($triggerLog);
            $this->collTriggerLogs->remove($pos);
            if (null === $this->triggerLogsScheduledForDeletion) {
                $this->triggerLogsScheduledForDeletion = clone $this->collTriggerLogs;
                $this->triggerLogsScheduledForDeletion->clear();
            }
            $this->triggerLogsScheduledForDeletion[]= clone $triggerLog;
            $triggerLog->setTrigger(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTarget) {
            $this->aTarget->removeTrigger($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeTrigger($this);
        }
        if (null !== $this->aTriggerType) {
            $this->aTriggerType->removeTrigger($this);
        }
        $this->id_trigger = null;
        $this->target_id = null;
        $this->user_id = null;
        $this->trigger_type_id = null;
        $this->trigger_params = null;
        $this->trigger_invoke_on = null;
        $this->trigger_name = null;
        $this->trigger_active = null;
        $this->trigger_last_executed_at = null;
        $this->trigger_last_executed_result = null;
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
            if ($this->collTriggerLogs) {
                foreach ($this->collTriggerLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTriggerLogs = null;
        $this->aTarget = null;
        $this->aUser = null;
        $this->aTriggerType = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'trigger_name' column
     */
    public function __toString()
    {
        return (string) $this->getTriggerName();
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTrigger The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TriggerTableMap::COL_UPDATED_AT] = true;

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
