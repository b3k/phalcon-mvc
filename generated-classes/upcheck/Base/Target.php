<?php

namespace Base;

use \ChannelOut as ChildChannelOut;
use \ChannelOutQuery as ChildChannelOutQuery;
use \StackTestResultFail as ChildStackTestResultFail;
use \StackTestResultFailQuery as ChildStackTestResultFailQuery;
use \StackTestResultPass as ChildStackTestResultPass;
use \StackTestResultPassQuery as ChildStackTestResultPassQuery;
use \Target as ChildTarget;
use \TargetGroup as ChildTargetGroup;
use \TargetGroupQuery as ChildTargetGroupQuery;
use \TargetQuery as ChildTargetQuery;
use \TargetType as ChildTargetType;
use \TargetTypeQuery as ChildTargetTypeQuery;
use \Trigger as ChildTrigger;
use \TriggerQuery as ChildTriggerQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\TargetTableMap;
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

abstract class Target implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TargetTableMap';


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
     * The value for the id_target field.
     * @var        int
     */
    protected $id_target;

    /**
     * The value for the target_type_id field.
     * @var        int
     */
    protected $target_type_id;

    /**
     * The value for the target_group_id field.
     * @var        int
     */
    protected $target_group_id;

    /**
     * The value for the target_target field.
     * @var        string
     */
    protected $target_target;

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
     * @var        ChildTargetType
     */
    protected $aTargetType;

    /**
     * @var        ChildTargetGroup
     */
    protected $aTargetGroup;

    /**
     * @var        ObjectCollection|ChildChannelOut[] Collection to store aggregation of ChildChannelOut objects.
     */
    protected $collChannelOuts;
    protected $collChannelOutsPartial;

    /**
     * @var        ObjectCollection|ChildStackTestResultFail[] Collection to store aggregation of ChildStackTestResultFail objects.
     */
    protected $collStackTestResultFailsRelatedByTargetId;
    protected $collStackTestResultFailsRelatedByTargetIdPartial;

    /**
     * @var        ObjectCollection|ChildStackTestResultFail[] Collection to store aggregation of ChildStackTestResultFail objects.
     */
    protected $collStackTestResultFailsRelatedByTargetGroupId;
    protected $collStackTestResultFailsRelatedByTargetGroupIdPartial;

    /**
     * @var        ObjectCollection|ChildStackTestResultFail[] Collection to store aggregation of ChildStackTestResultFail objects.
     */
    protected $collStackTestResultFailsRelatedByTargetTypeId;
    protected $collStackTestResultFailsRelatedByTargetTypeIdPartial;

    /**
     * @var        ObjectCollection|ChildStackTestResultPass[] Collection to store aggregation of ChildStackTestResultPass objects.
     */
    protected $collStackTestResultPasses;
    protected $collStackTestResultPassesPartial;

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
     * @var ObjectCollection|ChildChannelOut[]
     */
    protected $channelOutsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStackTestResultFail[]
     */
    protected $stackTestResultFailsRelatedByTargetIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStackTestResultFail[]
     */
    protected $stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStackTestResultFail[]
     */
    protected $stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStackTestResultPass[]
     */
    protected $stackTestResultPassesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrigger[]
     */
    protected $triggersScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Target object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Target</code> instance.  If
     * <code>obj</code> is an instance of <code>Target</code>, delegates to
     * <code>equals(Target)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Target The current object, for fluid interface
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
     * Get the [id_target] column value.
     *
     * @return   int
     */
    public function getIdTarget()
    {
        return $this->id_target;
    }

    /**
     * Get the [target_type_id] column value.
     *
     * @return   int
     */
    public function getTargetTypeId()
    {
        return $this->target_type_id;
    }

    /**
     * Get the [target_group_id] column value.
     *
     * @return   int
     */
    public function getTargetGroupId()
    {
        return $this->target_group_id;
    }

    /**
     * Get the [target_target] column value.
     *
     * @return   string
     */
    public function getTargetTarget()
    {
        return $this->target_target;
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
     * Set the value of [id_target] column.
     *
     * @param      int $v new value
     * @return     $this|\Target The current object (for fluent API support)
     */
    public function setIdTarget($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_target !== $v) {
            $this->id_target = $v;
            $this->modifiedColumns[TargetTableMap::COL_ID_TARGET] = true;
        }

        return $this;
    } // setIdTarget()

    /**
     * Set the value of [target_type_id] column.
     *
     * @param      int $v new value
     * @return     $this|\Target The current object (for fluent API support)
     */
    public function setTargetTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target_type_id !== $v) {
            $this->target_type_id = $v;
            $this->modifiedColumns[TargetTableMap::COL_TARGET_TYPE_ID] = true;
        }

        if ($this->aTargetType !== null && $this->aTargetType->getIdTargetType() !== $v) {
            $this->aTargetType = null;
        }

        return $this;
    } // setTargetTypeId()

    /**
     * Set the value of [target_group_id] column.
     *
     * @param      int $v new value
     * @return     $this|\Target The current object (for fluent API support)
     */
    public function setTargetGroupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target_group_id !== $v) {
            $this->target_group_id = $v;
            $this->modifiedColumns[TargetTableMap::COL_TARGET_GROUP_ID] = true;
        }

        if ($this->aTargetGroup !== null && $this->aTargetGroup->getIdTargetGroup() !== $v) {
            $this->aTargetGroup = null;
        }

        return $this;
    } // setTargetGroupId()

    /**
     * Set the value of [target_target] column.
     *
     * @param      string $v new value
     * @return     $this|\Target The current object (for fluent API support)
     */
    public function setTargetTarget($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->target_target !== $v) {
            $this->target_target = $v;
            $this->modifiedColumns[TargetTableMap::COL_TARGET_TARGET] = true;
        }

        return $this;
    } // setTargetTarget()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\Target The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[TargetTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return     $this|\Target The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[TargetTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TargetTableMap::translateFieldName('IdTarget', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_target = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TargetTableMap::translateFieldName('TargetTypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TargetTableMap::translateFieldName('TargetGroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_group_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TargetTableMap::translateFieldName('TargetTarget', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target_target = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TargetTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TargetTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = TargetTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Target'), 0, $e);
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
        if ($this->aTargetType !== null && $this->target_type_id !== $this->aTargetType->getIdTargetType()) {
            $this->aTargetType = null;
        }
        if ($this->aTargetGroup !== null && $this->target_group_id !== $this->aTargetGroup->getIdTargetGroup()) {
            $this->aTargetGroup = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(TargetTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTargetQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTargetType = null;
            $this->aTargetGroup = null;
            $this->collChannelOuts = null;

            $this->collStackTestResultFailsRelatedByTargetId = null;

            $this->collStackTestResultFailsRelatedByTargetGroupId = null;

            $this->collStackTestResultFailsRelatedByTargetTypeId = null;

            $this->collStackTestResultPasses = null;

            $this->collTriggers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Target::setDeleted()
     * @see Target::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTargetQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(TargetTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(TargetTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TargetTableMap::COL_UPDATED_AT)) {
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
                TargetTableMap::addInstanceToPool($this);
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

            if ($this->aTargetType !== null) {
                if ($this->aTargetType->isModified() || $this->aTargetType->isNew()) {
                    $affectedRows += $this->aTargetType->save($con);
                }
                $this->setTargetType($this->aTargetType);
            }

            if ($this->aTargetGroup !== null) {
                if ($this->aTargetGroup->isModified() || $this->aTargetGroup->isNew()) {
                    $affectedRows += $this->aTargetGroup->save($con);
                }
                $this->setTargetGroup($this->aTargetGroup);
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

            if ($this->channelOutsScheduledForDeletion !== null) {
                if (!$this->channelOutsScheduledForDeletion->isEmpty()) {
                    \ChannelOutQuery::create()
                        ->filterByPrimaryKeys($this->channelOutsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->channelOutsScheduledForDeletion = null;
                }
            }

            if ($this->collChannelOuts !== null) {
                foreach ($this->collChannelOuts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion !== null) {
                if (!$this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion->isEmpty()) {
                    \StackTestResultFailQuery::create()
                        ->filterByPrimaryKeys($this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion = null;
                }
            }

            if ($this->collStackTestResultFailsRelatedByTargetId !== null) {
                foreach ($this->collStackTestResultFailsRelatedByTargetId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion !== null) {
                if (!$this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion->isEmpty()) {
                    \StackTestResultFailQuery::create()
                        ->filterByPrimaryKeys($this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion = null;
                }
            }

            if ($this->collStackTestResultFailsRelatedByTargetGroupId !== null) {
                foreach ($this->collStackTestResultFailsRelatedByTargetGroupId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion !== null) {
                if (!$this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion->isEmpty()) {
                    \StackTestResultFailQuery::create()
                        ->filterByPrimaryKeys($this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collStackTestResultFailsRelatedByTargetTypeId !== null) {
                foreach ($this->collStackTestResultFailsRelatedByTargetTypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stackTestResultPassesScheduledForDeletion !== null) {
                if (!$this->stackTestResultPassesScheduledForDeletion->isEmpty()) {
                    \StackTestResultPassQuery::create()
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

        $this->modifiedColumns[TargetTableMap::COL_ID_TARGET] = true;
        if (null !== $this->id_target) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TargetTableMap::COL_ID_TARGET . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TargetTableMap::COL_ID_TARGET)) {
            $modifiedColumns[':p' . $index++]  = 'ID_TARGET';
        }
        if ($this->isColumnModified(TargetTableMap::COL_TARGET_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TYPE_ID';
        }
        if ($this->isColumnModified(TargetTableMap::COL_TARGET_GROUP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_GROUP_ID';
        }
        if ($this->isColumnModified(TargetTableMap::COL_TARGET_TARGET)) {
            $modifiedColumns[':p' . $index++]  = 'TARGET_TARGET';
        }
        if ($this->isColumnModified(TargetTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(TargetTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO ""target (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_TARGET':
                        $stmt->bindValue($identifier, $this->id_target, PDO::PARAM_INT);
                        break;
                    case 'TARGET_TYPE_ID':
                        $stmt->bindValue($identifier, $this->target_type_id, PDO::PARAM_INT);
                        break;
                    case 'TARGET_GROUP_ID':
                        $stmt->bindValue($identifier, $this->target_group_id, PDO::PARAM_INT);
                        break;
                    case 'TARGET_TARGET':
                        $stmt->bindValue($identifier, $this->target_target, PDO::PARAM_STR);
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
        $this->setIdTarget($pk);

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
        $pos = TargetTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdTarget();
                break;
            case 1:
                return $this->getTargetTypeId();
                break;
            case 2:
                return $this->getTargetGroupId();
                break;
            case 3:
                return $this->getTargetTarget();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
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
        if (isset($alreadyDumpedObjects['Target'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Target'][$this->getPrimaryKey()] = true;
        $keys = TargetTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTarget(),
            $keys[1] => $this->getTargetTypeId(),
            $keys[2] => $this->getTargetGroupId(),
            $keys[3] => $this->getTargetTarget(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTargetType) {
                $result['TargetType'] = $this->aTargetType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTargetGroup) {
                $result['TargetGroup'] = $this->aTargetGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collChannelOuts) {
                $result['ChannelOuts'] = $this->collChannelOuts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStackTestResultFailsRelatedByTargetId) {
                $result['StackTestResultFailsRelatedByTargetId'] = $this->collStackTestResultFailsRelatedByTargetId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStackTestResultFailsRelatedByTargetGroupId) {
                $result['StackTestResultFailsRelatedByTargetGroupId'] = $this->collStackTestResultFailsRelatedByTargetGroupId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStackTestResultFailsRelatedByTargetTypeId) {
                $result['StackTestResultFailsRelatedByTargetTypeId'] = $this->collStackTestResultFailsRelatedByTargetTypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStackTestResultPasses) {
                $result['StackTestResultPasses'] = $this->collStackTestResultPasses->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return     $this|\Target
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TargetTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return     $this|\Target
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTarget($value);
                break;
            case 1:
                $this->setTargetTypeId($value);
                break;
            case 2:
                $this->setTargetGroupId($value);
                break;
            case 3:
                $this->setTargetTarget($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
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
        $keys = TargetTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdTarget($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTargetTypeId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTargetGroupId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTargetTarget($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreatedAt($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUpdatedAt($arr[$keys[5]]);
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
     * @return $this|\Target The current object, for fluid interface
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
        $criteria = new Criteria(TargetTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TargetTableMap::COL_ID_TARGET)) {
            $criteria->add(TargetTableMap::COL_ID_TARGET, $this->id_target);
        }
        if ($this->isColumnModified(TargetTableMap::COL_TARGET_TYPE_ID)) {
            $criteria->add(TargetTableMap::COL_TARGET_TYPE_ID, $this->target_type_id);
        }
        if ($this->isColumnModified(TargetTableMap::COL_TARGET_GROUP_ID)) {
            $criteria->add(TargetTableMap::COL_TARGET_GROUP_ID, $this->target_group_id);
        }
        if ($this->isColumnModified(TargetTableMap::COL_TARGET_TARGET)) {
            $criteria->add(TargetTableMap::COL_TARGET_TARGET, $this->target_target);
        }
        if ($this->isColumnModified(TargetTableMap::COL_CREATED_AT)) {
            $criteria->add(TargetTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TargetTableMap::COL_UPDATED_AT)) {
            $criteria->add(TargetTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = new Criteria(TargetTableMap::DATABASE_NAME);
        $criteria->add(TargetTableMap::COL_ID_TARGET, $this->id_target);

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
        $validPk = null !== $this->getIdTarget();

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
        return $this->getIdTarget();
    }

    /**
     * Generic method to set the primary key (id_target column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTarget($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdTarget();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Target (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTargetTypeId($this->getTargetTypeId());
        $copyObj->setTargetGroupId($this->getTargetGroupId());
        $copyObj->setTargetTarget($this->getTargetTarget());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getChannelOuts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChannelOut($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStackTestResultFailsRelatedByTargetId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStackTestResultFailRelatedByTargetId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStackTestResultFailsRelatedByTargetGroupId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStackTestResultFailRelatedByTargetGroupId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStackTestResultFailsRelatedByTargetTypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStackTestResultFailRelatedByTargetTypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStackTestResultPasses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStackTestResultPass($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTriggers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTrigger($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTarget(NULL); // this is a auto-increment column, so set to default value
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
     * @return                 \Target Clone of current object.
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
     * Declares an association between this object and a ChildTargetType object.
     *
     * @param                  ChildTargetType $v
     * @return                 $this|\Target The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTargetType(ChildTargetType $v = null)
    {
        if ($v === null) {
            $this->setTargetTypeId(NULL);
        } else {
            $this->setTargetTypeId($v->getIdTargetType());
        }

        $this->aTargetType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTargetType object, it will not be re-added.
        if ($v !== null) {
            $v->addTarget($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTargetType object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildTargetType The associated ChildTargetType object.
     * @throws PropelException
     */
    public function getTargetType(ConnectionInterface $con = null)
    {
        if ($this->aTargetType === null && ($this->target_type_id !== null)) {
            $this->aTargetType = ChildTargetTypeQuery::create()->findPk($this->target_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTargetType->addTargets($this);
             */
        }

        return $this->aTargetType;
    }

    /**
     * Declares an association between this object and a ChildTargetGroup object.
     *
     * @param                  ChildTargetGroup $v
     * @return                 $this|\Target The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTargetGroup(ChildTargetGroup $v = null)
    {
        if ($v === null) {
            $this->setTargetGroupId(NULL);
        } else {
            $this->setTargetGroupId($v->getIdTargetGroup());
        }

        $this->aTargetGroup = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTargetGroup object, it will not be re-added.
        if ($v !== null) {
            $v->addTarget($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTargetGroup object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildTargetGroup The associated ChildTargetGroup object.
     * @throws PropelException
     */
    public function getTargetGroup(ConnectionInterface $con = null)
    {
        if ($this->aTargetGroup === null && ($this->target_group_id !== null)) {
            $this->aTargetGroup = ChildTargetGroupQuery::create()->findPk($this->target_group_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTargetGroup->addTargets($this);
             */
        }

        return $this->aTargetGroup;
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
        if ('ChannelOut' == $relationName) {
            return $this->initChannelOuts();
        }
        if ('StackTestResultFailRelatedByTargetId' == $relationName) {
            return $this->initStackTestResultFailsRelatedByTargetId();
        }
        if ('StackTestResultFailRelatedByTargetGroupId' == $relationName) {
            return $this->initStackTestResultFailsRelatedByTargetGroupId();
        }
        if ('StackTestResultFailRelatedByTargetTypeId' == $relationName) {
            return $this->initStackTestResultFailsRelatedByTargetTypeId();
        }
        if ('StackTestResultPass' == $relationName) {
            return $this->initStackTestResultPasses();
        }
        if ('Trigger' == $relationName) {
            return $this->initTriggers();
        }
    }

    /**
     * Clears out the collChannelOuts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addChannelOuts()
     */
    public function clearChannelOuts()
    {
        $this->collChannelOuts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collChannelOuts collection loaded partially.
     */
    public function resetPartialChannelOuts($v = true)
    {
        $this->collChannelOutsPartial = $v;
    }

    /**
     * Initializes the collChannelOuts collection.
     *
     * By default this just sets the collChannelOuts collection to an empty array (like clearcollChannelOuts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChannelOuts($overrideExisting = true)
    {
        if (null !== $this->collChannelOuts && !$overrideExisting) {
            return;
        }
        $this->collChannelOuts = new ObjectCollection();
        $this->collChannelOuts->setModel('\ChannelOut');
    }

    /**
     * Gets an array of ChildChannelOut objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTarget is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildChannelOut[] List of ChildChannelOut objects
     * @throws PropelException
     */
    public function getChannelOuts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collChannelOutsPartial && !$this->isNew();
        if (null === $this->collChannelOuts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChannelOuts) {
                // return empty collection
                $this->initChannelOuts();
            } else {
                $collChannelOuts = ChildChannelOutQuery::create(null, $criteria)
                    ->filterByTarget($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collChannelOutsPartial && count($collChannelOuts)) {
                        $this->initChannelOuts(false);

                        foreach ($collChannelOuts as $obj) {
                            if (false == $this->collChannelOuts->contains($obj)) {
                                $this->collChannelOuts->append($obj);
                            }
                        }

                        $this->collChannelOutsPartial = true;
                    }

                    $collChannelOuts->rewind();

                    return $collChannelOuts;
                }

                if ($partial && $this->collChannelOuts) {
                    foreach ($this->collChannelOuts as $obj) {
                        if ($obj->isNew()) {
                            $collChannelOuts[] = $obj;
                        }
                    }
                }

                $this->collChannelOuts = $collChannelOuts;
                $this->collChannelOutsPartial = false;
            }
        }

        return $this->collChannelOuts;
    }

    /**
     * Sets a collection of ChildChannelOut objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $channelOuts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function setChannelOuts(Collection $channelOuts, ConnectionInterface $con = null)
    {
        /** @var ChildChannelOut[] $channelOutsToDelete */
        $channelOutsToDelete = $this->getChannelOuts(new Criteria(), $con)->diff($channelOuts);


        $this->channelOutsScheduledForDeletion = $channelOutsToDelete;

        foreach ($channelOutsToDelete as $channelOutRemoved) {
            $channelOutRemoved->setTarget(null);
        }

        $this->collChannelOuts = null;
        foreach ($channelOuts as $channelOut) {
            $this->addChannelOut($channelOut);
        }

        $this->collChannelOuts = $channelOuts;
        $this->collChannelOutsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ChannelOut objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ChannelOut objects.
     * @throws PropelException
     */
    public function countChannelOuts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collChannelOutsPartial && !$this->isNew();
        if (null === $this->collChannelOuts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChannelOuts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getChannelOuts());
            }

            $query = ChildChannelOutQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTarget($this)
                ->count($con);
        }

        return count($this->collChannelOuts);
    }

    /**
     * Method called to associate a ChildChannelOut object to this object
     * through the ChildChannelOut foreign key attribute.
     *
     * @param    ChildChannelOut $l ChildChannelOut
     * @return   $this|\Target The current object (for fluent API support)
     */
    public function addChannelOut(ChildChannelOut $l)
    {
        if ($this->collChannelOuts === null) {
            $this->initChannelOuts();
            $this->collChannelOutsPartial = true;
        }

        if (!$this->collChannelOuts->contains($l)) {
            $this->doAddChannelOut($l);
        }

        return $this;
    }

    /**
     * @param ChildChannelOut $channelOut The ChildChannelOut object to add.
     */
    protected function doAddChannelOut(ChildChannelOut $channelOut)
    {
        $this->collChannelOuts[]= $channelOut;
        $channelOut->setTarget($this);
    }

    /**
     * @param  ChildChannelOut $channelOut The ChildChannelOut object to remove.
     * @return $this|ChildTarget The current object (for fluent API support)
     */
    public function removeChannelOut(ChildChannelOut $channelOut)
    {
        if ($this->getChannelOuts()->contains($channelOut)) {
            $pos = $this->collChannelOuts->search($channelOut);
            $this->collChannelOuts->remove($pos);
            if (null === $this->channelOutsScheduledForDeletion) {
                $this->channelOutsScheduledForDeletion = clone $this->collChannelOuts;
                $this->channelOutsScheduledForDeletion->clear();
            }
            $this->channelOutsScheduledForDeletion[]= clone $channelOut;
            $channelOut->setTarget(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Target is new, it will return
     * an empty collection; or if this Target has previously
     * been saved, it will retrieve related ChannelOuts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Target.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildChannelOut[] List of ChildChannelOut objects
     */
    public function getChannelOutsJoinChannel(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildChannelOutQuery::create(null, $criteria);
        $query->joinWith('Channel', $joinBehavior);

        return $this->getChannelOuts($query, $con);
    }

    /**
     * Clears out the collStackTestResultFailsRelatedByTargetId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStackTestResultFailsRelatedByTargetId()
     */
    public function clearStackTestResultFailsRelatedByTargetId()
    {
        $this->collStackTestResultFailsRelatedByTargetId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStackTestResultFailsRelatedByTargetId collection loaded partially.
     */
    public function resetPartialStackTestResultFailsRelatedByTargetId($v = true)
    {
        $this->collStackTestResultFailsRelatedByTargetIdPartial = $v;
    }

    /**
     * Initializes the collStackTestResultFailsRelatedByTargetId collection.
     *
     * By default this just sets the collStackTestResultFailsRelatedByTargetId collection to an empty array (like clearcollStackTestResultFailsRelatedByTargetId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStackTestResultFailsRelatedByTargetId($overrideExisting = true)
    {
        if (null !== $this->collStackTestResultFailsRelatedByTargetId && !$overrideExisting) {
            return;
        }
        $this->collStackTestResultFailsRelatedByTargetId = new ObjectCollection();
        $this->collStackTestResultFailsRelatedByTargetId->setModel('\StackTestResultFail');
    }

    /**
     * Gets an array of ChildStackTestResultFail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTarget is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStackTestResultFail[] List of ChildStackTestResultFail objects
     * @throws PropelException
     */
    public function getStackTestResultFailsRelatedByTargetId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultFailsRelatedByTargetIdPartial && !$this->isNew();
        if (null === $this->collStackTestResultFailsRelatedByTargetId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultFailsRelatedByTargetId) {
                // return empty collection
                $this->initStackTestResultFailsRelatedByTargetId();
            } else {
                $collStackTestResultFailsRelatedByTargetId = ChildStackTestResultFailQuery::create(null, $criteria)
                    ->filterByTargetRelatedByTargetId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStackTestResultFailsRelatedByTargetIdPartial && count($collStackTestResultFailsRelatedByTargetId)) {
                        $this->initStackTestResultFailsRelatedByTargetId(false);

                        foreach ($collStackTestResultFailsRelatedByTargetId as $obj) {
                            if (false == $this->collStackTestResultFailsRelatedByTargetId->contains($obj)) {
                                $this->collStackTestResultFailsRelatedByTargetId->append($obj);
                            }
                        }

                        $this->collStackTestResultFailsRelatedByTargetIdPartial = true;
                    }

                    $collStackTestResultFailsRelatedByTargetId->rewind();

                    return $collStackTestResultFailsRelatedByTargetId;
                }

                if ($partial && $this->collStackTestResultFailsRelatedByTargetId) {
                    foreach ($this->collStackTestResultFailsRelatedByTargetId as $obj) {
                        if ($obj->isNew()) {
                            $collStackTestResultFailsRelatedByTargetId[] = $obj;
                        }
                    }
                }

                $this->collStackTestResultFailsRelatedByTargetId = $collStackTestResultFailsRelatedByTargetId;
                $this->collStackTestResultFailsRelatedByTargetIdPartial = false;
            }
        }

        return $this->collStackTestResultFailsRelatedByTargetId;
    }

    /**
     * Sets a collection of ChildStackTestResultFail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stackTestResultFailsRelatedByTargetId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function setStackTestResultFailsRelatedByTargetId(Collection $stackTestResultFailsRelatedByTargetId, ConnectionInterface $con = null)
    {
        /** @var ChildStackTestResultFail[] $stackTestResultFailsRelatedByTargetIdToDelete */
        $stackTestResultFailsRelatedByTargetIdToDelete = $this->getStackTestResultFailsRelatedByTargetId(new Criteria(), $con)->diff($stackTestResultFailsRelatedByTargetId);


        $this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion = $stackTestResultFailsRelatedByTargetIdToDelete;

        foreach ($stackTestResultFailsRelatedByTargetIdToDelete as $stackTestResultFailRelatedByTargetIdRemoved) {
            $stackTestResultFailRelatedByTargetIdRemoved->setTargetRelatedByTargetId(null);
        }

        $this->collStackTestResultFailsRelatedByTargetId = null;
        foreach ($stackTestResultFailsRelatedByTargetId as $stackTestResultFailRelatedByTargetId) {
            $this->addStackTestResultFailRelatedByTargetId($stackTestResultFailRelatedByTargetId);
        }

        $this->collStackTestResultFailsRelatedByTargetId = $stackTestResultFailsRelatedByTargetId;
        $this->collStackTestResultFailsRelatedByTargetIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StackTestResultFail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StackTestResultFail objects.
     * @throws PropelException
     */
    public function countStackTestResultFailsRelatedByTargetId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultFailsRelatedByTargetIdPartial && !$this->isNew();
        if (null === $this->collStackTestResultFailsRelatedByTargetId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultFailsRelatedByTargetId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStackTestResultFailsRelatedByTargetId());
            }

            $query = ChildStackTestResultFailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTargetRelatedByTargetId($this)
                ->count($con);
        }

        return count($this->collStackTestResultFailsRelatedByTargetId);
    }

    /**
     * Method called to associate a ChildStackTestResultFail object to this object
     * through the ChildStackTestResultFail foreign key attribute.
     *
     * @param    ChildStackTestResultFail $l ChildStackTestResultFail
     * @return   $this|\Target The current object (for fluent API support)
     */
    public function addStackTestResultFailRelatedByTargetId(ChildStackTestResultFail $l)
    {
        if ($this->collStackTestResultFailsRelatedByTargetId === null) {
            $this->initStackTestResultFailsRelatedByTargetId();
            $this->collStackTestResultFailsRelatedByTargetIdPartial = true;
        }

        if (!$this->collStackTestResultFailsRelatedByTargetId->contains($l)) {
            $this->doAddStackTestResultFailRelatedByTargetId($l);
        }

        return $this;
    }

    /**
     * @param ChildStackTestResultFail $stackTestResultFailRelatedByTargetId The ChildStackTestResultFail object to add.
     */
    protected function doAddStackTestResultFailRelatedByTargetId(ChildStackTestResultFail $stackTestResultFailRelatedByTargetId)
    {
        $this->collStackTestResultFailsRelatedByTargetId[]= $stackTestResultFailRelatedByTargetId;
        $stackTestResultFailRelatedByTargetId->setTargetRelatedByTargetId($this);
    }

    /**
     * @param  ChildStackTestResultFail $stackTestResultFailRelatedByTargetId The ChildStackTestResultFail object to remove.
     * @return $this|ChildTarget The current object (for fluent API support)
     */
    public function removeStackTestResultFailRelatedByTargetId(ChildStackTestResultFail $stackTestResultFailRelatedByTargetId)
    {
        if ($this->getStackTestResultFailsRelatedByTargetId()->contains($stackTestResultFailRelatedByTargetId)) {
            $pos = $this->collStackTestResultFailsRelatedByTargetId->search($stackTestResultFailRelatedByTargetId);
            $this->collStackTestResultFailsRelatedByTargetId->remove($pos);
            if (null === $this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion) {
                $this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion = clone $this->collStackTestResultFailsRelatedByTargetId;
                $this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion->clear();
            }
            $this->stackTestResultFailsRelatedByTargetIdScheduledForDeletion[]= clone $stackTestResultFailRelatedByTargetId;
            $stackTestResultFailRelatedByTargetId->setTargetRelatedByTargetId(null);
        }

        return $this;
    }

    /**
     * Clears out the collStackTestResultFailsRelatedByTargetGroupId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStackTestResultFailsRelatedByTargetGroupId()
     */
    public function clearStackTestResultFailsRelatedByTargetGroupId()
    {
        $this->collStackTestResultFailsRelatedByTargetGroupId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStackTestResultFailsRelatedByTargetGroupId collection loaded partially.
     */
    public function resetPartialStackTestResultFailsRelatedByTargetGroupId($v = true)
    {
        $this->collStackTestResultFailsRelatedByTargetGroupIdPartial = $v;
    }

    /**
     * Initializes the collStackTestResultFailsRelatedByTargetGroupId collection.
     *
     * By default this just sets the collStackTestResultFailsRelatedByTargetGroupId collection to an empty array (like clearcollStackTestResultFailsRelatedByTargetGroupId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStackTestResultFailsRelatedByTargetGroupId($overrideExisting = true)
    {
        if (null !== $this->collStackTestResultFailsRelatedByTargetGroupId && !$overrideExisting) {
            return;
        }
        $this->collStackTestResultFailsRelatedByTargetGroupId = new ObjectCollection();
        $this->collStackTestResultFailsRelatedByTargetGroupId->setModel('\StackTestResultFail');
    }

    /**
     * Gets an array of ChildStackTestResultFail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTarget is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStackTestResultFail[] List of ChildStackTestResultFail objects
     * @throws PropelException
     */
    public function getStackTestResultFailsRelatedByTargetGroupId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultFailsRelatedByTargetGroupIdPartial && !$this->isNew();
        if (null === $this->collStackTestResultFailsRelatedByTargetGroupId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultFailsRelatedByTargetGroupId) {
                // return empty collection
                $this->initStackTestResultFailsRelatedByTargetGroupId();
            } else {
                $collStackTestResultFailsRelatedByTargetGroupId = ChildStackTestResultFailQuery::create(null, $criteria)
                    ->filterByTargetRelatedByTargetGroupId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStackTestResultFailsRelatedByTargetGroupIdPartial && count($collStackTestResultFailsRelatedByTargetGroupId)) {
                        $this->initStackTestResultFailsRelatedByTargetGroupId(false);

                        foreach ($collStackTestResultFailsRelatedByTargetGroupId as $obj) {
                            if (false == $this->collStackTestResultFailsRelatedByTargetGroupId->contains($obj)) {
                                $this->collStackTestResultFailsRelatedByTargetGroupId->append($obj);
                            }
                        }

                        $this->collStackTestResultFailsRelatedByTargetGroupIdPartial = true;
                    }

                    $collStackTestResultFailsRelatedByTargetGroupId->rewind();

                    return $collStackTestResultFailsRelatedByTargetGroupId;
                }

                if ($partial && $this->collStackTestResultFailsRelatedByTargetGroupId) {
                    foreach ($this->collStackTestResultFailsRelatedByTargetGroupId as $obj) {
                        if ($obj->isNew()) {
                            $collStackTestResultFailsRelatedByTargetGroupId[] = $obj;
                        }
                    }
                }

                $this->collStackTestResultFailsRelatedByTargetGroupId = $collStackTestResultFailsRelatedByTargetGroupId;
                $this->collStackTestResultFailsRelatedByTargetGroupIdPartial = false;
            }
        }

        return $this->collStackTestResultFailsRelatedByTargetGroupId;
    }

    /**
     * Sets a collection of ChildStackTestResultFail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stackTestResultFailsRelatedByTargetGroupId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function setStackTestResultFailsRelatedByTargetGroupId(Collection $stackTestResultFailsRelatedByTargetGroupId, ConnectionInterface $con = null)
    {
        /** @var ChildStackTestResultFail[] $stackTestResultFailsRelatedByTargetGroupIdToDelete */
        $stackTestResultFailsRelatedByTargetGroupIdToDelete = $this->getStackTestResultFailsRelatedByTargetGroupId(new Criteria(), $con)->diff($stackTestResultFailsRelatedByTargetGroupId);


        $this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion = $stackTestResultFailsRelatedByTargetGroupIdToDelete;

        foreach ($stackTestResultFailsRelatedByTargetGroupIdToDelete as $stackTestResultFailRelatedByTargetGroupIdRemoved) {
            $stackTestResultFailRelatedByTargetGroupIdRemoved->setTargetRelatedByTargetGroupId(null);
        }

        $this->collStackTestResultFailsRelatedByTargetGroupId = null;
        foreach ($stackTestResultFailsRelatedByTargetGroupId as $stackTestResultFailRelatedByTargetGroupId) {
            $this->addStackTestResultFailRelatedByTargetGroupId($stackTestResultFailRelatedByTargetGroupId);
        }

        $this->collStackTestResultFailsRelatedByTargetGroupId = $stackTestResultFailsRelatedByTargetGroupId;
        $this->collStackTestResultFailsRelatedByTargetGroupIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StackTestResultFail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StackTestResultFail objects.
     * @throws PropelException
     */
    public function countStackTestResultFailsRelatedByTargetGroupId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultFailsRelatedByTargetGroupIdPartial && !$this->isNew();
        if (null === $this->collStackTestResultFailsRelatedByTargetGroupId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultFailsRelatedByTargetGroupId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStackTestResultFailsRelatedByTargetGroupId());
            }

            $query = ChildStackTestResultFailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTargetRelatedByTargetGroupId($this)
                ->count($con);
        }

        return count($this->collStackTestResultFailsRelatedByTargetGroupId);
    }

    /**
     * Method called to associate a ChildStackTestResultFail object to this object
     * through the ChildStackTestResultFail foreign key attribute.
     *
     * @param    ChildStackTestResultFail $l ChildStackTestResultFail
     * @return   $this|\Target The current object (for fluent API support)
     */
    public function addStackTestResultFailRelatedByTargetGroupId(ChildStackTestResultFail $l)
    {
        if ($this->collStackTestResultFailsRelatedByTargetGroupId === null) {
            $this->initStackTestResultFailsRelatedByTargetGroupId();
            $this->collStackTestResultFailsRelatedByTargetGroupIdPartial = true;
        }

        if (!$this->collStackTestResultFailsRelatedByTargetGroupId->contains($l)) {
            $this->doAddStackTestResultFailRelatedByTargetGroupId($l);
        }

        return $this;
    }

    /**
     * @param ChildStackTestResultFail $stackTestResultFailRelatedByTargetGroupId The ChildStackTestResultFail object to add.
     */
    protected function doAddStackTestResultFailRelatedByTargetGroupId(ChildStackTestResultFail $stackTestResultFailRelatedByTargetGroupId)
    {
        $this->collStackTestResultFailsRelatedByTargetGroupId[]= $stackTestResultFailRelatedByTargetGroupId;
        $stackTestResultFailRelatedByTargetGroupId->setTargetRelatedByTargetGroupId($this);
    }

    /**
     * @param  ChildStackTestResultFail $stackTestResultFailRelatedByTargetGroupId The ChildStackTestResultFail object to remove.
     * @return $this|ChildTarget The current object (for fluent API support)
     */
    public function removeStackTestResultFailRelatedByTargetGroupId(ChildStackTestResultFail $stackTestResultFailRelatedByTargetGroupId)
    {
        if ($this->getStackTestResultFailsRelatedByTargetGroupId()->contains($stackTestResultFailRelatedByTargetGroupId)) {
            $pos = $this->collStackTestResultFailsRelatedByTargetGroupId->search($stackTestResultFailRelatedByTargetGroupId);
            $this->collStackTestResultFailsRelatedByTargetGroupId->remove($pos);
            if (null === $this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion) {
                $this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion = clone $this->collStackTestResultFailsRelatedByTargetGroupId;
                $this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion->clear();
            }
            $this->stackTestResultFailsRelatedByTargetGroupIdScheduledForDeletion[]= clone $stackTestResultFailRelatedByTargetGroupId;
            $stackTestResultFailRelatedByTargetGroupId->setTargetRelatedByTargetGroupId(null);
        }

        return $this;
    }

    /**
     * Clears out the collStackTestResultFailsRelatedByTargetTypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStackTestResultFailsRelatedByTargetTypeId()
     */
    public function clearStackTestResultFailsRelatedByTargetTypeId()
    {
        $this->collStackTestResultFailsRelatedByTargetTypeId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStackTestResultFailsRelatedByTargetTypeId collection loaded partially.
     */
    public function resetPartialStackTestResultFailsRelatedByTargetTypeId($v = true)
    {
        $this->collStackTestResultFailsRelatedByTargetTypeIdPartial = $v;
    }

    /**
     * Initializes the collStackTestResultFailsRelatedByTargetTypeId collection.
     *
     * By default this just sets the collStackTestResultFailsRelatedByTargetTypeId collection to an empty array (like clearcollStackTestResultFailsRelatedByTargetTypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStackTestResultFailsRelatedByTargetTypeId($overrideExisting = true)
    {
        if (null !== $this->collStackTestResultFailsRelatedByTargetTypeId && !$overrideExisting) {
            return;
        }
        $this->collStackTestResultFailsRelatedByTargetTypeId = new ObjectCollection();
        $this->collStackTestResultFailsRelatedByTargetTypeId->setModel('\StackTestResultFail');
    }

    /**
     * Gets an array of ChildStackTestResultFail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTarget is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStackTestResultFail[] List of ChildStackTestResultFail objects
     * @throws PropelException
     */
    public function getStackTestResultFailsRelatedByTargetTypeId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultFailsRelatedByTargetTypeIdPartial && !$this->isNew();
        if (null === $this->collStackTestResultFailsRelatedByTargetTypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultFailsRelatedByTargetTypeId) {
                // return empty collection
                $this->initStackTestResultFailsRelatedByTargetTypeId();
            } else {
                $collStackTestResultFailsRelatedByTargetTypeId = ChildStackTestResultFailQuery::create(null, $criteria)
                    ->filterByTargetRelatedByTargetTypeId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStackTestResultFailsRelatedByTargetTypeIdPartial && count($collStackTestResultFailsRelatedByTargetTypeId)) {
                        $this->initStackTestResultFailsRelatedByTargetTypeId(false);

                        foreach ($collStackTestResultFailsRelatedByTargetTypeId as $obj) {
                            if (false == $this->collStackTestResultFailsRelatedByTargetTypeId->contains($obj)) {
                                $this->collStackTestResultFailsRelatedByTargetTypeId->append($obj);
                            }
                        }

                        $this->collStackTestResultFailsRelatedByTargetTypeIdPartial = true;
                    }

                    $collStackTestResultFailsRelatedByTargetTypeId->rewind();

                    return $collStackTestResultFailsRelatedByTargetTypeId;
                }

                if ($partial && $this->collStackTestResultFailsRelatedByTargetTypeId) {
                    foreach ($this->collStackTestResultFailsRelatedByTargetTypeId as $obj) {
                        if ($obj->isNew()) {
                            $collStackTestResultFailsRelatedByTargetTypeId[] = $obj;
                        }
                    }
                }

                $this->collStackTestResultFailsRelatedByTargetTypeId = $collStackTestResultFailsRelatedByTargetTypeId;
                $this->collStackTestResultFailsRelatedByTargetTypeIdPartial = false;
            }
        }

        return $this->collStackTestResultFailsRelatedByTargetTypeId;
    }

    /**
     * Sets a collection of ChildStackTestResultFail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stackTestResultFailsRelatedByTargetTypeId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function setStackTestResultFailsRelatedByTargetTypeId(Collection $stackTestResultFailsRelatedByTargetTypeId, ConnectionInterface $con = null)
    {
        /** @var ChildStackTestResultFail[] $stackTestResultFailsRelatedByTargetTypeIdToDelete */
        $stackTestResultFailsRelatedByTargetTypeIdToDelete = $this->getStackTestResultFailsRelatedByTargetTypeId(new Criteria(), $con)->diff($stackTestResultFailsRelatedByTargetTypeId);


        $this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion = $stackTestResultFailsRelatedByTargetTypeIdToDelete;

        foreach ($stackTestResultFailsRelatedByTargetTypeIdToDelete as $stackTestResultFailRelatedByTargetTypeIdRemoved) {
            $stackTestResultFailRelatedByTargetTypeIdRemoved->setTargetRelatedByTargetTypeId(null);
        }

        $this->collStackTestResultFailsRelatedByTargetTypeId = null;
        foreach ($stackTestResultFailsRelatedByTargetTypeId as $stackTestResultFailRelatedByTargetTypeId) {
            $this->addStackTestResultFailRelatedByTargetTypeId($stackTestResultFailRelatedByTargetTypeId);
        }

        $this->collStackTestResultFailsRelatedByTargetTypeId = $stackTestResultFailsRelatedByTargetTypeId;
        $this->collStackTestResultFailsRelatedByTargetTypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StackTestResultFail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StackTestResultFail objects.
     * @throws PropelException
     */
    public function countStackTestResultFailsRelatedByTargetTypeId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStackTestResultFailsRelatedByTargetTypeIdPartial && !$this->isNew();
        if (null === $this->collStackTestResultFailsRelatedByTargetTypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStackTestResultFailsRelatedByTargetTypeId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStackTestResultFailsRelatedByTargetTypeId());
            }

            $query = ChildStackTestResultFailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTargetRelatedByTargetTypeId($this)
                ->count($con);
        }

        return count($this->collStackTestResultFailsRelatedByTargetTypeId);
    }

    /**
     * Method called to associate a ChildStackTestResultFail object to this object
     * through the ChildStackTestResultFail foreign key attribute.
     *
     * @param    ChildStackTestResultFail $l ChildStackTestResultFail
     * @return   $this|\Target The current object (for fluent API support)
     */
    public function addStackTestResultFailRelatedByTargetTypeId(ChildStackTestResultFail $l)
    {
        if ($this->collStackTestResultFailsRelatedByTargetTypeId === null) {
            $this->initStackTestResultFailsRelatedByTargetTypeId();
            $this->collStackTestResultFailsRelatedByTargetTypeIdPartial = true;
        }

        if (!$this->collStackTestResultFailsRelatedByTargetTypeId->contains($l)) {
            $this->doAddStackTestResultFailRelatedByTargetTypeId($l);
        }

        return $this;
    }

    /**
     * @param ChildStackTestResultFail $stackTestResultFailRelatedByTargetTypeId The ChildStackTestResultFail object to add.
     */
    protected function doAddStackTestResultFailRelatedByTargetTypeId(ChildStackTestResultFail $stackTestResultFailRelatedByTargetTypeId)
    {
        $this->collStackTestResultFailsRelatedByTargetTypeId[]= $stackTestResultFailRelatedByTargetTypeId;
        $stackTestResultFailRelatedByTargetTypeId->setTargetRelatedByTargetTypeId($this);
    }

    /**
     * @param  ChildStackTestResultFail $stackTestResultFailRelatedByTargetTypeId The ChildStackTestResultFail object to remove.
     * @return $this|ChildTarget The current object (for fluent API support)
     */
    public function removeStackTestResultFailRelatedByTargetTypeId(ChildStackTestResultFail $stackTestResultFailRelatedByTargetTypeId)
    {
        if ($this->getStackTestResultFailsRelatedByTargetTypeId()->contains($stackTestResultFailRelatedByTargetTypeId)) {
            $pos = $this->collStackTestResultFailsRelatedByTargetTypeId->search($stackTestResultFailRelatedByTargetTypeId);
            $this->collStackTestResultFailsRelatedByTargetTypeId->remove($pos);
            if (null === $this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion) {
                $this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion = clone $this->collStackTestResultFailsRelatedByTargetTypeId;
                $this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion->clear();
            }
            $this->stackTestResultFailsRelatedByTargetTypeIdScheduledForDeletion[]= clone $stackTestResultFailRelatedByTargetTypeId;
            $stackTestResultFailRelatedByTargetTypeId->setTargetRelatedByTargetTypeId(null);
        }

        return $this;
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
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStackTestResultPasses($overrideExisting = true)
    {
        if (null !== $this->collStackTestResultPasses && !$overrideExisting) {
            return;
        }
        $this->collStackTestResultPasses = new ObjectCollection();
        $this->collStackTestResultPasses->setModel('\StackTestResultPass');
    }

    /**
     * Gets an array of ChildStackTestResultPass objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTarget is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
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
                    ->filterByTarget($this)
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

                    $collStackTestResultPasses->rewind();

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
     * @param      Collection $stackTestResultPasses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function setStackTestResultPasses(Collection $stackTestResultPasses, ConnectionInterface $con = null)
    {
        /** @var ChildStackTestResultPass[] $stackTestResultPassesToDelete */
        $stackTestResultPassesToDelete = $this->getStackTestResultPasses(new Criteria(), $con)->diff($stackTestResultPasses);


        $this->stackTestResultPassesScheduledForDeletion = $stackTestResultPassesToDelete;

        foreach ($stackTestResultPassesToDelete as $stackTestResultPassRemoved) {
            $stackTestResultPassRemoved->setTarget(null);
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
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StackTestResultPass objects.
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
                ->filterByTarget($this)
                ->count($con);
        }

        return count($this->collStackTestResultPasses);
    }

    /**
     * Method called to associate a ChildStackTestResultPass object to this object
     * through the ChildStackTestResultPass foreign key attribute.
     *
     * @param    ChildStackTestResultPass $l ChildStackTestResultPass
     * @return   $this|\Target The current object (for fluent API support)
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
        $stackTestResultPass->setTarget($this);
    }

    /**
     * @param  ChildStackTestResultPass $stackTestResultPass The ChildStackTestResultPass object to remove.
     * @return $this|ChildTarget The current object (for fluent API support)
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
            $stackTestResultPass->setTarget(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Target is new, it will return
     * an empty collection; or if this Target has previously
     * been saved, it will retrieve related StackTestResultPasses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Target.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStackTestResultPass[] List of ChildStackTestResultPass objects
     */
    public function getStackTestResultPassesJoinTargetGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStackTestResultPassQuery::create(null, $criteria);
        $query->joinWith('TargetGroup', $joinBehavior);

        return $this->getStackTestResultPasses($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Target is new, it will return
     * an empty collection; or if this Target has previously
     * been saved, it will retrieve related StackTestResultPasses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Target.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStackTestResultPass[] List of ChildStackTestResultPass objects
     */
    public function getStackTestResultPassesJoinTargetType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStackTestResultPassQuery::create(null, $criteria);
        $query->joinWith('TargetType', $joinBehavior);

        return $this->getStackTestResultPasses($query, $con);
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
     * If this ChildTarget is new, it will return
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
                    ->filterByTarget($this)
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
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function setTriggers(Collection $triggers, ConnectionInterface $con = null)
    {
        /** @var ChildTrigger[] $triggersToDelete */
        $triggersToDelete = $this->getTriggers(new Criteria(), $con)->diff($triggers);


        $this->triggersScheduledForDeletion = $triggersToDelete;

        foreach ($triggersToDelete as $triggerRemoved) {
            $triggerRemoved->setTarget(null);
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
                ->filterByTarget($this)
                ->count($con);
        }

        return count($this->collTriggers);
    }

    /**
     * Method called to associate a ChildTrigger object to this object
     * through the ChildTrigger foreign key attribute.
     *
     * @param    ChildTrigger $l ChildTrigger
     * @return   $this|\Target The current object (for fluent API support)
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
        $trigger->setTarget($this);
    }

    /**
     * @param  ChildTrigger $trigger The ChildTrigger object to remove.
     * @return $this|ChildTarget The current object (for fluent API support)
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
            $trigger->setTarget(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Target is new, it will return
     * an empty collection; or if this Target has previously
     * been saved, it will retrieve related Triggers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Target.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Target is new, it will return
     * an empty collection; or if this Target has previously
     * been saved, it will retrieve related Triggers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Target.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrigger[] List of ChildTrigger objects
     */
    public function getTriggersJoinTriggerType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTriggerQuery::create(null, $criteria);
        $query->joinWith('TriggerType', $joinBehavior);

        return $this->getTriggers($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTargetType) {
            $this->aTargetType->removeTarget($this);
        }
        if (null !== $this->aTargetGroup) {
            $this->aTargetGroup->removeTarget($this);
        }
        $this->id_target = null;
        $this->target_type_id = null;
        $this->target_group_id = null;
        $this->target_target = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collChannelOuts) {
                foreach ($this->collChannelOuts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStackTestResultFailsRelatedByTargetId) {
                foreach ($this->collStackTestResultFailsRelatedByTargetId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStackTestResultFailsRelatedByTargetGroupId) {
                foreach ($this->collStackTestResultFailsRelatedByTargetGroupId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStackTestResultFailsRelatedByTargetTypeId) {
                foreach ($this->collStackTestResultFailsRelatedByTargetTypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStackTestResultPasses) {
                foreach ($this->collStackTestResultPasses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTriggers) {
                foreach ($this->collTriggers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collChannelOuts = null;
        $this->collStackTestResultFailsRelatedByTargetId = null;
        $this->collStackTestResultFailsRelatedByTargetGroupId = null;
        $this->collStackTestResultFailsRelatedByTargetTypeId = null;
        $this->collStackTestResultPasses = null;
        $this->collTriggers = null;
        $this->aTargetType = null;
        $this->aTargetGroup = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TargetTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTarget The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TargetTableMap::COL_UPDATED_AT] = true;

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
