<?php

namespace app\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Model\StackTestResultFail as ChildStackTestResultFail;
use App\Model\StackTestResultFailQuery as ChildStackTestResultFailQuery;
use App\Model\Target as ChildTarget;
use App\Model\TargetQuery as ChildTargetQuery;
use App\Model\Map\StackTestResultFailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class StackTestResultFail implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Model\\Map\\StackTestResultFailTableMap';

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
     * The value for the id_test_result_fail field.
     * @var        int
     */
    protected $id_test_result_fail;

    /**
     * The value for the target_id field.
     * @var        int
     */
    protected $target_id;

    /**
     * The value for the target_group_id field.
     * @var        int
     */
    protected $target_group_id;

    /**
     * The value for the target_type_id field.
     * @var        int
     */
    protected $target_type_id;

    /**
     * The value for the stack_test_result_fail_info field.
     * @var        string
     */
    protected $stack_test_result_fail_info;

    /**
     * The value for the stack_test_result_fail_priority field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $stack_test_result_fail_priority;

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
    protected $aTargetRelatedByTargetId;

    /**
     * @var        ChildTarget
     */
    protected $aTargetRelatedByTargetGroupId;

    /**
     * @var        ChildTarget
     */
    protected $aTargetRelatedByTargetTypeId;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->stack_test_result_fail_priority = false;
    }

    /**
     * Initializes internal state of App\Model\Base\StackTestResultFail object.
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
     * Compares this with another <code>StackTestResultFail</code> instance.  If
     * <code>obj</code> is an instance of <code>StackTestResultFail</code>, delegates to
     * <code>equals(StackTestResultFail)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|StackTestResultFail The current object, for fluid interface
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
     * Get the [id_test_result_fail] column value.
     *
     * @return int
     */
    public function getIdTestResultFail()
    {
        return $this->id_test_result_fail;
    }

    /**
     * Get the [target_id] column value.
     *
     * @return int
     */
    public function getTargetId()
    {
        return $this->target_id;
    }

    /**
     * Get the [target_group_id] column value.
     *
     * @return int
     */
    public function getTargetGroupId()
    {
        return $this->target_group_id;
    }

    /**
     * Get the [target_type_id] column value.
     *
     * @return int
     */
    public function getTargetTypeId()
    {
        return $this->target_type_id;
    }

    /**
     * Get the [stack_test_result_fail_info] column value.
     *
     * @return string
     */
    public function getStackTestResultFailInfo()
    {
        return $this->stack_test_result_fail_info;
    }

    /**
     * Get the [stack_test_result_fail_priority] column value.
     *
     * @return boolean
     */
    public function getStackTestResultFailPriority()
    {
        return $this->stack_test_result_fail_priority;
    }

    /**
     * Get the [stack_test_result_fail_priority] column value.
     *
     * @return boolean
     */
    public function isStackTestResultFailPriority()
    {
        return $this->getStackTestResultFailPriority();
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
            if ($this->stack_test_result_fail_priority !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StackTestResultFailTableMap::translateFieldName('IdTestResultFail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_test_result_fail = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StackTestResultFailTableMap::translateFieldName('TargetId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StackTestResultFailTableMap::translateFieldName('TargetGroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_group_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StackTestResultFailTableMap::translateFieldName('TargetTypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StackTestResultFailTableMap::translateFieldName('StackTestResultFailInfo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stack_test_result_fail_info = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : StackTestResultFailTableMap::translateFieldName('StackTestResultFailPriority', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stack_test_result_fail_priority = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : StackTestResultFailTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : StackTestResultFailTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = StackTestResultFailTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Model\\StackTestResultFail'), 0, $e);
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
        if ($this->aTargetRelatedByTargetId !== null && $this->target_id !== $this->aTargetRelatedByTargetId->getIdTarget()) {
            $this->aTargetRelatedByTargetId = null;
        }
        if ($this->aTargetRelatedByTargetGroupId !== null && $this->target_group_id !== $this->aTargetRelatedByTargetGroupId->getTargetGroupId()) {
            $this->aTargetRelatedByTargetGroupId = null;
        }
        if ($this->aTargetRelatedByTargetTypeId !== null && $this->target_type_id !== $this->aTargetRelatedByTargetTypeId->getTargetTypeId()) {
            $this->aTargetRelatedByTargetTypeId = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [id_test_result_fail] column.
     *
     * @param  int                                  $v new value
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setIdTestResultFail($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_test_result_fail !== $v) {
            $this->id_test_result_fail = $v;
            $this->modifiedColumns[StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL] = true;
        }

        return $this;
    } // setIdTestResultFail()

    /**
     * Set the value of [target_id] column.
     *
     * @param  int                                  $v new value
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setTargetId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target_id !== $v) {
            $this->target_id = $v;
            $this->modifiedColumns[StackTestResultFailTableMap::COL_TARGET_ID] = true;
        }

        if ($this->aTargetRelatedByTargetId !== null && $this->aTargetRelatedByTargetId->getIdTarget() !== $v) {
            $this->aTargetRelatedByTargetId = null;
        }

        return $this;
    } // setTargetId()

    /**
     * Set the value of [target_group_id] column.
     *
     * @param  int                                  $v new value
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setTargetGroupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target_group_id !== $v) {
            $this->target_group_id = $v;
            $this->modifiedColumns[StackTestResultFailTableMap::COL_TARGET_GROUP_ID] = true;
        }

        if ($this->aTargetRelatedByTargetGroupId !== null && $this->aTargetRelatedByTargetGroupId->getTargetGroupId() !== $v) {
            $this->aTargetRelatedByTargetGroupId = null;
        }

        return $this;
    } // setTargetGroupId()

    /**
     * Set the value of [target_type_id] column.
     *
     * @param  int                                  $v new value
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setTargetTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target_type_id !== $v) {
            $this->target_type_id = $v;
            $this->modifiedColumns[StackTestResultFailTableMap::COL_TARGET_TYPE_ID] = true;
        }

        if ($this->aTargetRelatedByTargetTypeId !== null && $this->aTargetRelatedByTargetTypeId->getTargetTypeId() !== $v) {
            $this->aTargetRelatedByTargetTypeId = null;
        }

        return $this;
    } // setTargetTypeId()

    /**
     * Set the value of [stack_test_result_fail_info] column.
     *
     * @param  string                               $v new value
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setStackTestResultFailInfo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stack_test_result_fail_info !== $v) {
            $this->stack_test_result_fail_info = $v;
            $this->modifiedColumns[StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO] = true;
        }

        return $this;
    } // setStackTestResultFailInfo()

    /**
     * Sets the value of the [stack_test_result_fail_priority] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string               $v The new value
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setStackTestResultFailPriority($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->stack_test_result_fail_priority !== $v) {
            $this->stack_test_result_fail_priority = $v;
            $this->modifiedColumns[StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY] = true;
        }

        return $this;
    } // setStackTestResultFailPriority()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                                $v string, integer (timestamp), or \DateTime value.
     *                                                 Empty strings are treated as NULL.
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[StackTestResultFailTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                                $v string, integer (timestamp), or \DateTime value.
     *                                                 Empty strings are treated as NULL.
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[StackTestResultFailTableMap::COL_UPDATED_AT] = true;
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
            $con = Propel::getServiceContainer()->getReadConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStackTestResultFailQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTargetRelatedByTargetId = null;
            $this->aTargetRelatedByTargetGroupId = null;
            $this->aTargetRelatedByTargetTypeId = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param  ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see StackTestResultFail::setDeleted()
     * @see StackTestResultFail::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildStackTestResultFailQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(StackTestResultFailTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(StackTestResultFailTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(StackTestResultFailTableMap::COL_UPDATED_AT)) {
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
                StackTestResultFailTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTargetRelatedByTargetId !== null) {
                if ($this->aTargetRelatedByTargetId->isModified() || $this->aTargetRelatedByTargetId->isNew()) {
                    $affectedRows += $this->aTargetRelatedByTargetId->save($con);
                }
                $this->setTargetRelatedByTargetId($this->aTargetRelatedByTargetId);
            }

            if ($this->aTargetRelatedByTargetGroupId !== null) {
                if ($this->aTargetRelatedByTargetGroupId->isModified() || $this->aTargetRelatedByTargetGroupId->isNew()) {
                    $affectedRows += $this->aTargetRelatedByTargetGroupId->save($con);
                }
                $this->setTargetRelatedByTargetGroupId($this->aTargetRelatedByTargetGroupId);
            }

            if ($this->aTargetRelatedByTargetTypeId !== null) {
                if ($this->aTargetRelatedByTargetTypeId->isModified() || $this->aTargetRelatedByTargetTypeId->isNew()) {
                    $affectedRows += $this->aTargetRelatedByTargetTypeId->save($con);
                }
                $this->setTargetRelatedByTargetTypeId($this->aTargetRelatedByTargetTypeId);
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

        $this->modifiedColumns[StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL] = true;
        if (null !== $this->id_test_result_fail) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL)) {
            $modifiedColumns[':p' . $index++]  = 'ID_TEST_RESULT_FAIL';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_TARGET_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_ID';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_TARGET_GROUP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_GROUP_ID';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_TARGET_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TYPE_ID';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO)) {
            $modifiedColumns[':p' . $index++]  = 'STACK_TEST_RESULT_FAIL_INFO';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY)) {
            $modifiedColumns[':p' . $index++]  = 'STACK_TEST_RESULT_FAIL_PRIORITY';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO stack_test_result_fail (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_TEST_RESULT_FAIL':
                        $stmt->bindValue($identifier, $this->id_test_result_fail, PDO::PARAM_INT);
                        break;
                    case 'TARGET_ID':
                        $stmt->bindValue($identifier, $this->target_id, PDO::PARAM_INT);
                        break;
                    case 'TARGET_GROUP_ID':
                        $stmt->bindValue($identifier, $this->target_group_id, PDO::PARAM_INT);
                        break;
                    case 'TARGET_TYPE_ID':
                        $stmt->bindValue($identifier, $this->target_type_id, PDO::PARAM_INT);
                        break;
                    case 'STACK_TEST_RESULT_FAIL_INFO':
                        $stmt->bindValue($identifier, $this->stack_test_result_fail_info, PDO::PARAM_STR);
                        break;
                    case 'STACK_TEST_RESULT_FAIL_PRIORITY':
                        $stmt->bindValue($identifier, (int) $this->stack_test_result_fail_priority, PDO::PARAM_INT);
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
        $this->setIdTestResultFail($pk);

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
        $pos = StackTestResultFailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdTestResultFail();
                break;
            case 1:
                return $this->getTargetId();
                break;
            case 2:
                return $this->getTargetGroupId();
                break;
            case 3:
                return $this->getTargetTypeId();
                break;
            case 4:
                return $this->getStackTestResultFailInfo();
                break;
            case 5:
                return $this->getStackTestResultFailPriority();
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
        if (isset($alreadyDumpedObjects['StackTestResultFail'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['StackTestResultFail'][$this->getPrimaryKey()] = true;
        $keys = StackTestResultFailTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTestResultFail(),
            $keys[1] => $this->getTargetId(),
            $keys[2] => $this->getTargetGroupId(),
            $keys[3] => $this->getTargetTypeId(),
            $keys[4] => $this->getStackTestResultFailInfo(),
            $keys[5] => $this->getStackTestResultFailPriority(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTargetRelatedByTargetId) {
                $result['TargetRelatedByTargetId'] = $this->aTargetRelatedByTargetId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTargetRelatedByTargetGroupId) {
                $result['TargetRelatedByTargetGroupId'] = $this->aTargetRelatedByTargetGroupId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTargetRelatedByTargetTypeId) {
                $result['TargetRelatedByTargetTypeId'] = $this->aTargetRelatedByTargetTypeId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string                               $name
     * @param  mixed                                $value field value
     * @param  string                               $type  The type of fieldname the $name is of:
     *                                                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                                                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                                                     Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Model\StackTestResultFail
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StackTestResultFailTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int                                  $pos   position in xml schema
     * @param  mixed                                $value field value
     * @return $this|\App\Model\StackTestResultFail
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTestResultFail($value);
                break;
            case 1:
                $this->setTargetId($value);
                break;
            case 2:
                $this->setTargetGroupId($value);
                break;
            case 3:
                $this->setTargetTypeId($value);
                break;
            case 4:
                $this->setStackTestResultFailInfo($value);
                break;
            case 5:
                $this->setStackTestResultFailPriority($value);
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
     * @param  array  $arr     An array to populate the object from.
     * @param  string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = StackTestResultFailTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdTestResultFail($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTargetId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTargetGroupId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTargetTypeId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStackTestResultFailInfo($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStackTestResultFailPriority($arr[$keys[5]]);
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
     * @param mixed  $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data   The source data to import from
     *
     * @return $this|\App\Model\StackTestResultFail The current object, for fluid interface
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
        $criteria = new Criteria(StackTestResultFailTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL)) {
            $criteria->add(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $this->id_test_result_fail);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_TARGET_ID)) {
            $criteria->add(StackTestResultFailTableMap::COL_TARGET_ID, $this->target_id);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_TARGET_GROUP_ID)) {
            $criteria->add(StackTestResultFailTableMap::COL_TARGET_GROUP_ID, $this->target_group_id);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_TARGET_TYPE_ID)) {
            $criteria->add(StackTestResultFailTableMap::COL_TARGET_TYPE_ID, $this->target_type_id);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO)) {
            $criteria->add(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO, $this->stack_test_result_fail_info);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY)) {
            $criteria->add(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY, $this->stack_test_result_fail_priority);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_CREATED_AT)) {
            $criteria->add(StackTestResultFailTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(StackTestResultFailTableMap::COL_UPDATED_AT)) {
            $criteria->add(StackTestResultFailTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = new Criteria(StackTestResultFailTableMap::DATABASE_NAME);
        $criteria->add(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $this->id_test_result_fail);

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
        $validPk = null !== $this->getIdTestResultFail();

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
        return $this->getIdTestResultFail();
    }

    /**
     * Generic method to set the primary key (id_test_result_fail column).
     *
     * @param  int  $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTestResultFail($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdTestResultFail();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  object          $copyObj  An object of \App\Model\StackTestResultFail (or compatible) type.
     * @param  boolean         $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param  boolean         $makeNew  Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTargetId($this->getTargetId());
        $copyObj->setTargetGroupId($this->getTargetGroupId());
        $copyObj->setTargetTypeId($this->getTargetTypeId());
        $copyObj->setStackTestResultFailInfo($this->getStackTestResultFailInfo());
        $copyObj->setStackTestResultFailPriority($this->getStackTestResultFailPriority());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTestResultFail(NULL); // this is a auto-increment column, so set to default value
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
     * @param  boolean                        $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Model\StackTestResultFail Clone of current object.
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
     * @param  ChildTarget                          $v
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTargetRelatedByTargetId(ChildTarget $v = null)
    {
        if ($v === null) {
            $this->setTargetId(NULL);
        } else {
            $this->setTargetId($v->getIdTarget());
        }

        $this->aTargetRelatedByTargetId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTarget object, it will not be re-added.
        if ($v !== null) {
            $v->addStackTestResultFailRelatedByTargetId($this);
        }

        return $this;
    }

    /**
     * Get the associated ChildTarget object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTarget         The associated ChildTarget object.
     * @throws PropelException
     */
    public function getTargetRelatedByTargetId(ConnectionInterface $con = null)
    {
        if ($this->aTargetRelatedByTargetId === null && ($this->target_id !== null)) {
            $this->aTargetRelatedByTargetId = ChildTargetQuery::create()->findPk($this->target_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTargetRelatedByTargetId->addStackTestResultFailsRelatedByTargetId($this);
             */
        }

        return $this->aTargetRelatedByTargetId;
    }

    /**
     * Declares an association between this object and a ChildTarget object.
     *
     * @param  ChildTarget                          $v
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTargetRelatedByTargetGroupId(ChildTarget $v = null)
    {
        if ($v === null) {
            $this->setTargetGroupId(NULL);
        } else {
            $this->setTargetGroupId($v->getTargetGroupId());
        }

        $this->aTargetRelatedByTargetGroupId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTarget object, it will not be re-added.
        if ($v !== null) {
            $v->addStackTestResultFailRelatedByTargetGroupId($this);
        }

        return $this;
    }

    /**
     * Get the associated ChildTarget object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTarget         The associated ChildTarget object.
     * @throws PropelException
     */
    public function getTargetRelatedByTargetGroupId(ConnectionInterface $con = null)
    {
        if ($this->aTargetRelatedByTargetGroupId === null && ($this->target_group_id !== null)) {
            $this->aTargetRelatedByTargetGroupId = ChildTargetQuery::create()
                ->filterByStackTestResultFailRelatedByTargetGroupId($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTargetRelatedByTargetGroupId->addStackTestResultFailsRelatedByTargetGroupId($this);
             */
        }

        return $this->aTargetRelatedByTargetGroupId;
    }

    /**
     * Declares an association between this object and a ChildTarget object.
     *
     * @param  ChildTarget                          $v
     * @return $this|\App\Model\StackTestResultFail The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTargetRelatedByTargetTypeId(ChildTarget $v = null)
    {
        if ($v === null) {
            $this->setTargetTypeId(NULL);
        } else {
            $this->setTargetTypeId($v->getTargetTypeId());
        }

        $this->aTargetRelatedByTargetTypeId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTarget object, it will not be re-added.
        if ($v !== null) {
            $v->addStackTestResultFailRelatedByTargetTypeId($this);
        }

        return $this;
    }

    /**
     * Get the associated ChildTarget object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTarget         The associated ChildTarget object.
     * @throws PropelException
     */
    public function getTargetRelatedByTargetTypeId(ConnectionInterface $con = null)
    {
        if ($this->aTargetRelatedByTargetTypeId === null && ($this->target_type_id !== null)) {
            $this->aTargetRelatedByTargetTypeId = ChildTargetQuery::create()
                ->filterByStackTestResultFailRelatedByTargetTypeId($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTargetRelatedByTargetTypeId->addStackTestResultFailsRelatedByTargetTypeId($this);
             */
        }

        return $this->aTargetRelatedByTargetTypeId;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTargetRelatedByTargetId) {
            $this->aTargetRelatedByTargetId->removeStackTestResultFailRelatedByTargetId($this);
        }
        if (null !== $this->aTargetRelatedByTargetGroupId) {
            $this->aTargetRelatedByTargetGroupId->removeStackTestResultFailRelatedByTargetGroupId($this);
        }
        if (null !== $this->aTargetRelatedByTargetTypeId) {
            $this->aTargetRelatedByTargetTypeId->removeStackTestResultFailRelatedByTargetTypeId($this);
        }
        $this->id_test_result_fail = null;
        $this->target_id = null;
        $this->target_group_id = null;
        $this->target_type_id = null;
        $this->stack_test_result_fail_info = null;
        $this->stack_test_result_fail_priority = null;
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
        } // if ($deep)

        $this->aTargetRelatedByTargetId = null;
        $this->aTargetRelatedByTargetGroupId = null;
        $this->aTargetRelatedByTargetTypeId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StackTestResultFailTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return $this|ChildStackTestResultFail The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[StackTestResultFailTableMap::COL_UPDATED_AT] = true;

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
