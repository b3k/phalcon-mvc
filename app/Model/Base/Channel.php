<?php

namespace app\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Model\Channel as ChildChannel;
use App\Model\ChannelOut as ChildChannelOut;
use App\Model\ChannelOutQuery as ChildChannelOutQuery;
use App\Model\ChannelQuery as ChildChannelQuery;
use App\Model\SubscriptionPlanChannel as ChildSubscriptionPlanChannel;
use App\Model\SubscriptionPlanChannelQuery as ChildSubscriptionPlanChannelQuery;
use App\Model\TriggerType as ChildTriggerType;
use App\Model\TriggerTypeQuery as ChildTriggerTypeQuery;
use App\Model\Map\ChannelTableMap;
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

abstract class Channel implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Model\\Map\\ChannelTableMap';

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
     * The value for the id_channel field.
     * @var        int
     */
    protected $id_channel;

    /**
     * The value for the channel_class field.
     * @var        string
     */
    protected $channel_class;

    /**
     * The value for the channel_name field.
     * @var        string
     */
    protected $channel_name;

    /**
     * The value for the channel_description field.
     * @var        string
     */
    protected $channel_description;

    /**
     * The value for the channel_active field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $channel_active;

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
     * The value for the slug field.
     * @var        string
     */
    protected $slug;

    /**
     * @var        ObjectCollection|ChildChannelOut[] Collection to store aggregation of ChildChannelOut objects.
     */
    protected $collChannelOuts;
    protected $collChannelOutsPartial;

    /**
     * @var        ObjectCollection|ChildSubscriptionPlanChannel[] Collection to store aggregation of ChildSubscriptionPlanChannel objects.
     */
    protected $collSubscriptionPlanChannels;
    protected $collSubscriptionPlanChannelsPartial;

    /**
     * @var        ObjectCollection|ChildTriggerType[] Collection to store aggregation of ChildTriggerType objects.
     */
    protected $collTriggerTypes;
    protected $collTriggerTypesPartial;

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
     * @var ObjectCollection|ChildSubscriptionPlanChannel[]
     */
    protected $subscriptionPlanChannelsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTriggerType[]
     */
    protected $triggerTypesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->channel_active = false;
    }

    /**
     * Initializes internal state of App\Model\Base\Channel object.
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
     * Compares this with another <code>Channel</code> instance.  If
     * <code>obj</code> is an instance of <code>Channel</code>, delegates to
     * <code>equals(Channel)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Channel The current object, for fluid interface
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
     * Get the [id_channel] column value.
     *
     * @return int
     */
    public function getIdChannel()
    {
        return $this->id_channel;
    }

    /**
     * Get the [channel_class] column value.
     *
     * @return string
     */
    public function getChannelClass()
    {
        return $this->channel_class;
    }

    /**
     * Get the [channel_name] column value.
     *
     * @return string
     */
    public function getChannelName()
    {
        return $this->channel_name;
    }

    /**
     * Get the [channel_description] column value.
     *
     * @return string
     */
    public function getChannelDescription()
    {
        return $this->channel_description;
    }

    /**
     * Get the [channel_active] column value.
     *
     * @return boolean
     */
    public function getChannelActive()
    {
        return $this->channel_active;
    }

    /**
     * Get the [channel_active] column value.
     *
     * @return boolean
     */
    public function isChannelActive()
    {
        return $this->getChannelActive();
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
     * Get the [slug] column value.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
            if ($this->channel_active !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ChannelTableMap::translateFieldName('IdChannel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_channel = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ChannelTableMap::translateFieldName('ChannelClass', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel_class = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ChannelTableMap::translateFieldName('ChannelName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ChannelTableMap::translateFieldName('ChannelDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ChannelTableMap::translateFieldName('ChannelActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ChannelTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ChannelTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ChannelTableMap::translateFieldName('Slug', TableMap::TYPE_PHPNAME, $indexType)];
            $this->slug = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = ChannelTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Model\\Channel'), 0, $e);
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
     * Set the value of [id_channel] column.
     *
     * @param  int                      $v new value
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setIdChannel($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_channel !== $v) {
            $this->id_channel = $v;
            $this->modifiedColumns[ChannelTableMap::COL_ID_CHANNEL] = true;
        }

        return $this;
    } // setIdChannel()

    /**
     * Set the value of [channel_class] column.
     *
     * @param  string                   $v new value
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setChannelClass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->channel_class !== $v) {
            $this->channel_class = $v;
            $this->modifiedColumns[ChannelTableMap::COL_CHANNEL_CLASS] = true;
        }

        return $this;
    } // setChannelClass()

    /**
     * Set the value of [channel_name] column.
     *
     * @param  string                   $v new value
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setChannelName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->channel_name !== $v) {
            $this->channel_name = $v;
            $this->modifiedColumns[ChannelTableMap::COL_CHANNEL_NAME] = true;
        }

        return $this;
    } // setChannelName()

    /**
     * Set the value of [channel_description] column.
     *
     * @param  string                   $v new value
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setChannelDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->channel_description !== $v) {
            $this->channel_description = $v;
            $this->modifiedColumns[ChannelTableMap::COL_CHANNEL_DESCRIPTION] = true;
        }

        return $this;
    } // setChannelDescription()

    /**
     * Sets the value of the [channel_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string   $v The new value
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setChannelActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->channel_active !== $v) {
            $this->channel_active = $v;
            $this->modifiedColumns[ChannelTableMap::COL_CHANNEL_ACTIVE] = true;
        }

        return $this;
    } // setChannelActive()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                    $v string, integer (timestamp), or \DateTime value.
     *                                     Empty strings are treated as NULL.
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[ChannelTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                    $v string, integer (timestamp), or \DateTime value.
     *                                     Empty strings are treated as NULL.
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[ChannelTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [slug] column.
     *
     * @param  string                   $v new value
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[ChannelTableMap::COL_SLUG] = true;
        }

        return $this;
    } // setSlug()

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
            $con = Propel::getServiceContainer()->getReadConnection(ChannelTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildChannelQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collChannelOuts = null;

            $this->collSubscriptionPlanChannels = null;

            $this->collTriggerTypes = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param  ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Channel::setDeleted()
     * @see Channel::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildChannelQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            // sluggable behavior

            if ($this->isColumnModified(ChannelTableMap::COL_SLUG) && $this->getSlug()) {
                $this->setSlug($this->makeSlugUnique($this->getSlug()));
            } else {
                $this->setSlug($this->createSlug());
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ChannelTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ChannelTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ChannelTableMap::COL_UPDATED_AT)) {
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
                ChannelTableMap::addInstanceToPool($this);
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

            if ($this->channelOutsScheduledForDeletion !== null) {
                if (!$this->channelOutsScheduledForDeletion->isEmpty()) {
                    \App\Model\ChannelOutQuery::create()
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

            if ($this->subscriptionPlanChannelsScheduledForDeletion !== null) {
                if (!$this->subscriptionPlanChannelsScheduledForDeletion->isEmpty()) {
                    \App\Model\SubscriptionPlanChannelQuery::create()
                        ->filterByPrimaryKeys($this->subscriptionPlanChannelsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->subscriptionPlanChannelsScheduledForDeletion = null;
                }
            }

            if ($this->collSubscriptionPlanChannels !== null) {
                foreach ($this->collSubscriptionPlanChannels as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->triggerTypesScheduledForDeletion !== null) {
                if (!$this->triggerTypesScheduledForDeletion->isEmpty()) {
                    \App\Model\TriggerTypeQuery::create()
                        ->filterByPrimaryKeys($this->triggerTypesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->triggerTypesScheduledForDeletion = null;
                }
            }

            if ($this->collTriggerTypes !== null) {
                foreach ($this->collTriggerTypes as $referrerFK) {
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

        $this->modifiedColumns[ChannelTableMap::COL_ID_CHANNEL] = true;
        if (null !== $this->id_channel) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ChannelTableMap::COL_ID_CHANNEL . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ChannelTableMap::COL_ID_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = 'ID_CHANNEL';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'CHANNEL_CLASS';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'CHANNEL_NAME';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'CHANNEL_DESCRIPTION';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'CHANNEL_ACTIVE';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(ChannelTableMap::COL_SLUG)) {
            $modifiedColumns[':p' . $index++]  = 'SLUG';
        }

        $sql = sprintf(
            'INSERT INTO channel (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_CHANNEL':
                        $stmt->bindValue($identifier, $this->id_channel, PDO::PARAM_INT);
                        break;
                    case 'CHANNEL_CLASS':
                        $stmt->bindValue($identifier, $this->channel_class, PDO::PARAM_STR);
                        break;
                    case 'CHANNEL_NAME':
                        $stmt->bindValue($identifier, $this->channel_name, PDO::PARAM_STR);
                        break;
                    case 'CHANNEL_DESCRIPTION':
                        $stmt->bindValue($identifier, $this->channel_description, PDO::PARAM_STR);
                        break;
                    case 'CHANNEL_ACTIVE':
                        $stmt->bindValue($identifier, (int) $this->channel_active, PDO::PARAM_INT);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'SLUG':
                        $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
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
        $this->setIdChannel($pk);

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
        $pos = ChannelTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdChannel();
                break;
            case 1:
                return $this->getChannelClass();
                break;
            case 2:
                return $this->getChannelName();
                break;
            case 3:
                return $this->getChannelDescription();
                break;
            case 4:
                return $this->getChannelActive();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
                break;
            case 7:
                return $this->getSlug();
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
        if (isset($alreadyDumpedObjects['Channel'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Channel'][$this->getPrimaryKey()] = true;
        $keys = ChannelTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdChannel(),
            $keys[1] => $this->getChannelClass(),
            $keys[2] => $this->getChannelName(),
            $keys[3] => $this->getChannelDescription(),
            $keys[4] => $this->getChannelActive(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
            $keys[7] => $this->getSlug(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collChannelOuts) {
                $result['ChannelOuts'] = $this->collChannelOuts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSubscriptionPlanChannels) {
                $result['SubscriptionPlanChannels'] = $this->collSubscriptionPlanChannels->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTriggerTypes) {
                $result['TriggerTypes'] = $this->collTriggerTypes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string                   $name
     * @param  mixed                    $value field value
     * @param  string                   $type  The type of fieldname the $name is of:
     *                                         one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                                         TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                                         Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Model\Channel
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ChannelTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int                      $pos   position in xml schema
     * @param  mixed                    $value field value
     * @return $this|\App\Model\Channel
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdChannel($value);
                break;
            case 1:
                $this->setChannelClass($value);
                break;
            case 2:
                $this->setChannelName($value);
                break;
            case 3:
                $this->setChannelDescription($value);
                break;
            case 4:
                $this->setChannelActive($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
            case 7:
                $this->setSlug($value);
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
        $keys = ChannelTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdChannel($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setChannelClass($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setChannelName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setChannelDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setChannelActive($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSlug($arr[$keys[7]]);
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
     * @return $this|\App\Model\Channel The current object, for fluid interface
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
        $criteria = new Criteria(ChannelTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ChannelTableMap::COL_ID_CHANNEL)) {
            $criteria->add(ChannelTableMap::COL_ID_CHANNEL, $this->id_channel);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_CLASS)) {
            $criteria->add(ChannelTableMap::COL_CHANNEL_CLASS, $this->channel_class);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_NAME)) {
            $criteria->add(ChannelTableMap::COL_CHANNEL_NAME, $this->channel_name);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_DESCRIPTION)) {
            $criteria->add(ChannelTableMap::COL_CHANNEL_DESCRIPTION, $this->channel_description);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CHANNEL_ACTIVE)) {
            $criteria->add(ChannelTableMap::COL_CHANNEL_ACTIVE, $this->channel_active);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_CREATED_AT)) {
            $criteria->add(ChannelTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_UPDATED_AT)) {
            $criteria->add(ChannelTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(ChannelTableMap::COL_SLUG)) {
            $criteria->add(ChannelTableMap::COL_SLUG, $this->slug);
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
        $criteria = new Criteria(ChannelTableMap::DATABASE_NAME);
        $criteria->add(ChannelTableMap::COL_ID_CHANNEL, $this->id_channel);

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
        $validPk = null !== $this->getIdChannel();

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
        return $this->getIdChannel();
    }

    /**
     * Generic method to set the primary key (id_channel column).
     *
     * @param  int  $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdChannel($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdChannel();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  object          $copyObj  An object of \App\Model\Channel (or compatible) type.
     * @param  boolean         $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param  boolean         $makeNew  Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setChannelClass($this->getChannelClass());
        $copyObj->setChannelName($this->getChannelName());
        $copyObj->setChannelDescription($this->getChannelDescription());
        $copyObj->setChannelActive($this->getChannelActive());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setSlug($this->getSlug());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getChannelOuts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChannelOut($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSubscriptionPlanChannels() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubscriptionPlanChannel($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTriggerTypes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTriggerType($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdChannel(NULL); // this is a auto-increment column, so set to default value
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
     * @param  boolean            $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Model\Channel Clone of current object.
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
        if ('ChannelOut' == $relationName) {
            return $this->initChannelOuts();
        }
        if ('SubscriptionPlanChannel' == $relationName) {
            return $this->initSubscriptionPlanChannels();
        }
        if ('TriggerType' == $relationName) {
            return $this->initTriggerTypes();
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
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                  the collection even if it is not empty
     *
     * @return void
     */
    public function initChannelOuts($overrideExisting = true)
    {
        if (null !== $this->collChannelOuts && !$overrideExisting) {
            return;
        }
        $this->collChannelOuts = new ObjectCollection();
        $this->collChannelOuts->setModel('\App\Model\ChannelOut');
    }

    /**
     * Gets an array of ChildChannelOut objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChannel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param  Criteria                           $criteria optional Criteria object to narrow the query
     * @param  ConnectionInterface                $con      optional connection object
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
                    ->filterByChannel($this)
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
     * @param  Collection          $channelOuts A Propel collection.
     * @param  ConnectionInterface $con         Optional connection object
     * @return $this|ChildChannel  The current object (for fluent API support)
     */
    public function setChannelOuts(Collection $channelOuts, ConnectionInterface $con = null)
    {
        /** @var ChildChannelOut[] $channelOutsToDelete */
        $channelOutsToDelete = $this->getChannelOuts(new Criteria(), $con)->diff($channelOuts);

        $this->channelOutsScheduledForDeletion = $channelOutsToDelete;

        foreach ($channelOutsToDelete as $channelOutRemoved) {
            $channelOutRemoved->setChannel(null);
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
     * @param  Criteria            $criteria
     * @param  boolean             $distinct
     * @param  ConnectionInterface $con
     * @return int                 Count of related ChannelOut objects.
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
                ->filterByChannel($this)
                ->count($con);
        }

        return count($this->collChannelOuts);
    }

    /**
     * Method called to associate a ChildChannelOut object to this object
     * through the ChildChannelOut foreign key attribute.
     *
     * @param  ChildChannelOut          $l ChildChannelOut
     * @return $this|\App\Model\Channel The current object (for fluent API support)
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
        $channelOut->setChannel($this);
    }

    /**
     * @param  ChildChannelOut    $channelOut The ChildChannelOut object to remove.
     * @return $this|ChildChannel The current object (for fluent API support)
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
            $channelOut->setChannel(null);
        }

        return $this;
    }

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Channel is new, it will return
     * an empty collection; or if this Channel has previously
     * been saved, it will retrieve related ChannelOuts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Channel.
     *
     * @param  Criteria                           $criteria     optional Criteria object to narrow the query
     * @param  ConnectionInterface                $con          optional connection object
     * @param  string                             $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildChannelOut[] List of ChildChannelOut objects
     */
    public function getChannelOutsJoinTarget(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildChannelOutQuery::create(null, $criteria);
        $query->joinWith('Target', $joinBehavior);

        return $this->getChannelOuts($query, $con);
    }

    /**
     * Clears out the collSubscriptionPlanChannels collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSubscriptionPlanChannels()
     */
    public function clearSubscriptionPlanChannels()
    {
        $this->collSubscriptionPlanChannels = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSubscriptionPlanChannels collection loaded partially.
     */
    public function resetPartialSubscriptionPlanChannels($v = true)
    {
        $this->collSubscriptionPlanChannelsPartial = $v;
    }

    /**
     * Initializes the collSubscriptionPlanChannels collection.
     *
     * By default this just sets the collSubscriptionPlanChannels collection to an empty array (like clearcollSubscriptionPlanChannels());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                  the collection even if it is not empty
     *
     * @return void
     */
    public function initSubscriptionPlanChannels($overrideExisting = true)
    {
        if (null !== $this->collSubscriptionPlanChannels && !$overrideExisting) {
            return;
        }
        $this->collSubscriptionPlanChannels = new ObjectCollection();
        $this->collSubscriptionPlanChannels->setModel('\App\Model\SubscriptionPlanChannel');
    }

    /**
     * Gets an array of ChildSubscriptionPlanChannel objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChannel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param  Criteria                                        $criteria optional Criteria object to narrow the query
     * @param  ConnectionInterface                             $con      optional connection object
     * @return ObjectCollection|ChildSubscriptionPlanChannel[] List of ChildSubscriptionPlanChannel objects
     * @throws PropelException
     */
    public function getSubscriptionPlanChannels(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSubscriptionPlanChannelsPartial && !$this->isNew();
        if (null === $this->collSubscriptionPlanChannels || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSubscriptionPlanChannels) {
                // return empty collection
                $this->initSubscriptionPlanChannels();
            } else {
                $collSubscriptionPlanChannels = ChildSubscriptionPlanChannelQuery::create(null, $criteria)
                    ->filterByChannel($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSubscriptionPlanChannelsPartial && count($collSubscriptionPlanChannels)) {
                        $this->initSubscriptionPlanChannels(false);

                        foreach ($collSubscriptionPlanChannels as $obj) {
                            if (false == $this->collSubscriptionPlanChannels->contains($obj)) {
                                $this->collSubscriptionPlanChannels->append($obj);
                            }
                        }

                        $this->collSubscriptionPlanChannelsPartial = true;
                    }

                    return $collSubscriptionPlanChannels;
                }

                if ($partial && $this->collSubscriptionPlanChannels) {
                    foreach ($this->collSubscriptionPlanChannels as $obj) {
                        if ($obj->isNew()) {
                            $collSubscriptionPlanChannels[] = $obj;
                        }
                    }
                }

                $this->collSubscriptionPlanChannels = $collSubscriptionPlanChannels;
                $this->collSubscriptionPlanChannelsPartial = false;
            }
        }

        return $this->collSubscriptionPlanChannels;
    }

    /**
     * Sets a collection of ChildSubscriptionPlanChannel objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection          $subscriptionPlanChannels A Propel collection.
     * @param  ConnectionInterface $con                      Optional connection object
     * @return $this|ChildChannel  The current object (for fluent API support)
     */
    public function setSubscriptionPlanChannels(Collection $subscriptionPlanChannels, ConnectionInterface $con = null)
    {
        /** @var ChildSubscriptionPlanChannel[] $subscriptionPlanChannelsToDelete */
        $subscriptionPlanChannelsToDelete = $this->getSubscriptionPlanChannels(new Criteria(), $con)->diff($subscriptionPlanChannels);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->subscriptionPlanChannelsScheduledForDeletion = clone $subscriptionPlanChannelsToDelete;

        foreach ($subscriptionPlanChannelsToDelete as $subscriptionPlanChannelRemoved) {
            $subscriptionPlanChannelRemoved->setChannel(null);
        }

        $this->collSubscriptionPlanChannels = null;
        foreach ($subscriptionPlanChannels as $subscriptionPlanChannel) {
            $this->addSubscriptionPlanChannel($subscriptionPlanChannel);
        }

        $this->collSubscriptionPlanChannels = $subscriptionPlanChannels;
        $this->collSubscriptionPlanChannelsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SubscriptionPlanChannel objects.
     *
     * @param  Criteria            $criteria
     * @param  boolean             $distinct
     * @param  ConnectionInterface $con
     * @return int                 Count of related SubscriptionPlanChannel objects.
     * @throws PropelException
     */
    public function countSubscriptionPlanChannels(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSubscriptionPlanChannelsPartial && !$this->isNew();
        if (null === $this->collSubscriptionPlanChannels || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSubscriptionPlanChannels) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSubscriptionPlanChannels());
            }

            $query = ChildSubscriptionPlanChannelQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChannel($this)
                ->count($con);
        }

        return count($this->collSubscriptionPlanChannels);
    }

    /**
     * Method called to associate a ChildSubscriptionPlanChannel object to this object
     * through the ChildSubscriptionPlanChannel foreign key attribute.
     *
     * @param  ChildSubscriptionPlanChannel $l ChildSubscriptionPlanChannel
     * @return $this|\App\Model\Channel     The current object (for fluent API support)
     */
    public function addSubscriptionPlanChannel(ChildSubscriptionPlanChannel $l)
    {
        if ($this->collSubscriptionPlanChannels === null) {
            $this->initSubscriptionPlanChannels();
            $this->collSubscriptionPlanChannelsPartial = true;
        }

        if (!$this->collSubscriptionPlanChannels->contains($l)) {
            $this->doAddSubscriptionPlanChannel($l);
        }

        return $this;
    }

    /**
     * @param ChildSubscriptionPlanChannel $subscriptionPlanChannel The ChildSubscriptionPlanChannel object to add.
     */
    protected function doAddSubscriptionPlanChannel(ChildSubscriptionPlanChannel $subscriptionPlanChannel)
    {
        $this->collSubscriptionPlanChannels[]= $subscriptionPlanChannel;
        $subscriptionPlanChannel->setChannel($this);
    }

    /**
     * @param  ChildSubscriptionPlanChannel $subscriptionPlanChannel The ChildSubscriptionPlanChannel object to remove.
     * @return $this|ChildChannel           The current object (for fluent API support)
     */
    public function removeSubscriptionPlanChannel(ChildSubscriptionPlanChannel $subscriptionPlanChannel)
    {
        if ($this->getSubscriptionPlanChannels()->contains($subscriptionPlanChannel)) {
            $pos = $this->collSubscriptionPlanChannels->search($subscriptionPlanChannel);
            $this->collSubscriptionPlanChannels->remove($pos);
            if (null === $this->subscriptionPlanChannelsScheduledForDeletion) {
                $this->subscriptionPlanChannelsScheduledForDeletion = clone $this->collSubscriptionPlanChannels;
                $this->subscriptionPlanChannelsScheduledForDeletion->clear();
            }
            $this->subscriptionPlanChannelsScheduledForDeletion[]= clone $subscriptionPlanChannel;
            $subscriptionPlanChannel->setChannel(null);
        }

        return $this;
    }

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Channel is new, it will return
     * an empty collection; or if this Channel has previously
     * been saved, it will retrieve related SubscriptionPlanChannels from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Channel.
     *
     * @param  Criteria                                        $criteria     optional Criteria object to narrow the query
     * @param  ConnectionInterface                             $con          optional connection object
     * @param  string                                          $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSubscriptionPlanChannel[] List of ChildSubscriptionPlanChannel objects
     */
    public function getSubscriptionPlanChannelsJoinSubscriptionPlan(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubscriptionPlanChannelQuery::create(null, $criteria);
        $query->joinWith('SubscriptionPlan', $joinBehavior);

        return $this->getSubscriptionPlanChannels($query, $con);
    }

    /**
     * Clears out the collTriggerTypes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTriggerTypes()
     */
    public function clearTriggerTypes()
    {
        $this->collTriggerTypes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTriggerTypes collection loaded partially.
     */
    public function resetPartialTriggerTypes($v = true)
    {
        $this->collTriggerTypesPartial = $v;
    }

    /**
     * Initializes the collTriggerTypes collection.
     *
     * By default this just sets the collTriggerTypes collection to an empty array (like clearcollTriggerTypes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                  the collection even if it is not empty
     *
     * @return void
     */
    public function initTriggerTypes($overrideExisting = true)
    {
        if (null !== $this->collTriggerTypes && !$overrideExisting) {
            return;
        }
        $this->collTriggerTypes = new ObjectCollection();
        $this->collTriggerTypes->setModel('\App\Model\TriggerType');
    }

    /**
     * Gets an array of ChildTriggerType objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChannel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param  Criteria                            $criteria optional Criteria object to narrow the query
     * @param  ConnectionInterface                 $con      optional connection object
     * @return ObjectCollection|ChildTriggerType[] List of ChildTriggerType objects
     * @throws PropelException
     */
    public function getTriggerTypes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggerTypesPartial && !$this->isNew();
        if (null === $this->collTriggerTypes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTriggerTypes) {
                // return empty collection
                $this->initTriggerTypes();
            } else {
                $collTriggerTypes = ChildTriggerTypeQuery::create(null, $criteria)
                    ->filterByChannel($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTriggerTypesPartial && count($collTriggerTypes)) {
                        $this->initTriggerTypes(false);

                        foreach ($collTriggerTypes as $obj) {
                            if (false == $this->collTriggerTypes->contains($obj)) {
                                $this->collTriggerTypes->append($obj);
                            }
                        }

                        $this->collTriggerTypesPartial = true;
                    }

                    return $collTriggerTypes;
                }

                if ($partial && $this->collTriggerTypes) {
                    foreach ($this->collTriggerTypes as $obj) {
                        if ($obj->isNew()) {
                            $collTriggerTypes[] = $obj;
                        }
                    }
                }

                $this->collTriggerTypes = $collTriggerTypes;
                $this->collTriggerTypesPartial = false;
            }
        }

        return $this->collTriggerTypes;
    }

    /**
     * Sets a collection of ChildTriggerType objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection          $triggerTypes A Propel collection.
     * @param  ConnectionInterface $con          Optional connection object
     * @return $this|ChildChannel  The current object (for fluent API support)
     */
    public function setTriggerTypes(Collection $triggerTypes, ConnectionInterface $con = null)
    {
        /** @var ChildTriggerType[] $triggerTypesToDelete */
        $triggerTypesToDelete = $this->getTriggerTypes(new Criteria(), $con)->diff($triggerTypes);

        $this->triggerTypesScheduledForDeletion = $triggerTypesToDelete;

        foreach ($triggerTypesToDelete as $triggerTypeRemoved) {
            $triggerTypeRemoved->setChannel(null);
        }

        $this->collTriggerTypes = null;
        foreach ($triggerTypes as $triggerType) {
            $this->addTriggerType($triggerType);
        }

        $this->collTriggerTypes = $triggerTypes;
        $this->collTriggerTypesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TriggerType objects.
     *
     * @param  Criteria            $criteria
     * @param  boolean             $distinct
     * @param  ConnectionInterface $con
     * @return int                 Count of related TriggerType objects.
     * @throws PropelException
     */
    public function countTriggerTypes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggerTypesPartial && !$this->isNew();
        if (null === $this->collTriggerTypes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTriggerTypes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTriggerTypes());
            }

            $query = ChildTriggerTypeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChannel($this)
                ->count($con);
        }

        return count($this->collTriggerTypes);
    }

    /**
     * Method called to associate a ChildTriggerType object to this object
     * through the ChildTriggerType foreign key attribute.
     *
     * @param  ChildTriggerType         $l ChildTriggerType
     * @return $this|\App\Model\Channel The current object (for fluent API support)
     */
    public function addTriggerType(ChildTriggerType $l)
    {
        if ($this->collTriggerTypes === null) {
            $this->initTriggerTypes();
            $this->collTriggerTypesPartial = true;
        }

        if (!$this->collTriggerTypes->contains($l)) {
            $this->doAddTriggerType($l);
        }

        return $this;
    }

    /**
     * @param ChildTriggerType $triggerType The ChildTriggerType object to add.
     */
    protected function doAddTriggerType(ChildTriggerType $triggerType)
    {
        $this->collTriggerTypes[]= $triggerType;
        $triggerType->setChannel($this);
    }

    /**
     * @param  ChildTriggerType   $triggerType The ChildTriggerType object to remove.
     * @return $this|ChildChannel The current object (for fluent API support)
     */
    public function removeTriggerType(ChildTriggerType $triggerType)
    {
        if ($this->getTriggerTypes()->contains($triggerType)) {
            $pos = $this->collTriggerTypes->search($triggerType);
            $this->collTriggerTypes->remove($pos);
            if (null === $this->triggerTypesScheduledForDeletion) {
                $this->triggerTypesScheduledForDeletion = clone $this->collTriggerTypes;
                $this->triggerTypesScheduledForDeletion->clear();
            }
            $this->triggerTypesScheduledForDeletion[]= clone $triggerType;
            $triggerType->setChannel(null);
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
        $this->id_channel = null;
        $this->channel_class = null;
        $this->channel_name = null;
        $this->channel_description = null;
        $this->channel_active = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->slug = null;
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
            if ($this->collChannelOuts) {
                foreach ($this->collChannelOuts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSubscriptionPlanChannels) {
                foreach ($this->collSubscriptionPlanChannels as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTriggerTypes) {
                foreach ($this->collTriggerTypes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collChannelOuts = null;
        $this->collSubscriptionPlanChannels = null;
        $this->collTriggerTypes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'channel_name' column
     */
    public function __toString()
    {
        return (string) $this->getChannelName();
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return $this|ChildChannel The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ChannelTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // sluggable behavior

    /**
     * Create a unique slug based on the object
     *
     * @return string The object slug
     */
    protected function createSlug()
    {
        $slug = $this->createRawSlug();
        $slug = $this->limitSlugSize($slug);
        $slug = $this->makeSlugUnique($slug);

        return $slug;
    }

    /**
     * Create the slug from the appropriate columns
     *
     * @return string
     */
    protected function createRawSlug()
    {
        return $this->cleanupSlugPart($this->__toString());
    }

    /**
     * Cleanup a string to make a slug of it
     * Removes special characters, replaces blanks with a separator, and trim it
     *
     * @param  string $slug        the text to slugify
     * @param  string $replacement the separator used by slug
     * @return string the slugified text
     */
    protected static function cleanupSlugPart($slug, $replacement = '-')
    {
        // transliterate
        if (function_exists('iconv')) {
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        }

        // lowercase
        if (function_exists('mb_strtolower')) {
            $slug = mb_strtolower($slug);
        } else {
            $slug = strtolower($slug);
        }

        // remove accents resulting from OSX's iconv
        $slug = str_replace(array('\'', '`', '^'), '', $slug);

        // replace non letter or digits with separator
        $slug = preg_replace('/\W+/', $replacement, $slug);

        // trim
        $slug = trim($slug, $replacement);

        if (empty($slug)) {
            return 'n-a';
        }

        return $slug;
    }

    /**
     * Make sure the slug is short enough to accommodate the column size
     *
     * @param string $slug the slug to check
     *
     * @return string the truncated slug
     */
    protected static function limitSlugSize($slug, $incrementReservedSpace = 3)
    {
        // check length, as suffix could put it over maximum
        if (strlen($slug) > (255 - $incrementReservedSpace)) {
            $slug = substr($slug, 0, 255 - $incrementReservedSpace);
        }

        return $slug;
    }

    /**
     * Get the slug, ensuring its uniqueness
     *
     * @param  string $slug          the slug to check
     * @param  string $separator     the separator used by slug
     * @param  int    $alreadyExists false for the first try, true for the second, and take the high count + 1
     * @return string the unique slug
     */
    protected function makeSlugUnique($slug, $separator = '-', $alreadyExists = false)
    {
        if (!$alreadyExists) {
            $slug2 = $slug;
        } else {
            $slug2 = $slug . $separator;

            $count = \App\Model\ChannelQuery::create()
                ->filterBySlug($this->getSlug())
                ->filterByPrimaryKey($this->getPrimaryKey())
            ->count();

            if (1 == $count) {
                return $this->getSlug();
            }
        }

        $adapter = \Propel\Runtime\Propel::getServiceContainer()->getAdapter('default');
        $col = 'q.Slug';
        $compare = $alreadyExists ? $adapter->compareRegex($col, '?') : sprintf('%s = ?', $col);

        $query = \App\Model\ChannelQuery::create('q')
            ->where($compare, $alreadyExists ? '^' . $slug2 . '[0-9]+$' : $slug2)
            ->prune($this)
        ;

        if (!$alreadyExists) {
            $count = $query->count();
            if ($count > 0) {
                return $this->makeSlugUnique($slug, $separator, true);
            }

            return $slug2;
        }

        $adapter = \Propel\Runtime\Propel::getServiceContainer()->getAdapter('default');
        // Already exists
        $object = $query
            ->addDescendingOrderByColumn($adapter->strLength('slug'))
            ->addDescendingOrderByColumn('slug')
        ->findOne();

        // First duplicate slug
        if (null == $object) {
            return $slug2 . '1';
        }

        $slugNum = substr($object->getSlug(), strlen($slug) + 1);
        if (0 == $slugNum[0]) {
            $slugNum[0] = 1;
        }

        return $slug2 . ($slugNum + 1);
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
