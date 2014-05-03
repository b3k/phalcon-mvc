<?php

namespace app\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Model\SubscriptionPlan as ChildSubscriptionPlan;
use App\Model\SubscriptionPlanChannel as ChildSubscriptionPlanChannel;
use App\Model\SubscriptionPlanChannelQuery as ChildSubscriptionPlanChannelQuery;
use App\Model\SubscriptionPlanQuery as ChildSubscriptionPlanQuery;
use App\Model\Map\SubscriptionPlanTableMap;
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

abstract class SubscriptionPlan implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Model\\Map\\SubscriptionPlanTableMap';

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
     * The value for the id_subscription_plan field.
     * @var        int
     */
    protected $id_subscription_plan;

    /**
     * The value for the subscription_plan_name field.
     * @var        string
     */
    protected $subscription_plan_name;

    /**
     * The value for the subscription_plan_description field.
     * @var        string
     */
    protected $subscription_plan_description;

    /**
     * The value for the subscription_plan_price field.
     * @var        string
     */
    protected $subscription_plan_price;

    /**
     * The value for the subscription_plan_period field.
     * @var        int
     */
    protected $subscription_plan_period;

    /**
     * The value for the subscription_plan_code field.
     * @var        string
     */
    protected $subscription_plan_code;

    /**
     * The value for the subscription_plan_max_target field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $subscription_plan_max_target;

    /**
     * The value for the subscription_plan_check_interval field.
     * Note: this column has a database default value of: 600
     * @var        int
     */
    protected $subscription_plan_check_interval;

    /**
     * The value for the subscription_plan_max_localizations field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $subscription_plan_max_localizations;

    /**
     * The value for the subscription_plan_rss field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $subscription_plan_rss;

    /**
     * The value for the subscription_plan_max_sub_accounts field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $subscription_plan_max_sub_accounts;

    /**
     * The value for the subscription_plan_max_alert_receivers field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $subscription_plan_max_alert_receivers;

    /**
     * The value for the subscription_plan_max_trigger field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $subscription_plan_max_trigger;

    /**
     * The value for the subscription_plan_sms_in_period field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $subscription_plan_sms_in_period;

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
     * @var        ObjectCollection|ChildSubscriptionPlanChannel[] Collection to store aggregation of ChildSubscriptionPlanChannel objects.
     */
    protected $collSubscriptionPlanChannels;
    protected $collSubscriptionPlanChannelsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSubscriptionPlanChannel[]
     */
    protected $subscriptionPlanChannelsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->subscription_plan_max_target = 1;
        $this->subscription_plan_check_interval = 600;
        $this->subscription_plan_max_localizations = 1;
        $this->subscription_plan_rss = false;
        $this->subscription_plan_max_sub_accounts = 1;
        $this->subscription_plan_max_alert_receivers = 1;
        $this->subscription_plan_max_trigger = 1;
        $this->subscription_plan_sms_in_period = 0;
    }

    /**
     * Initializes internal state of App\Model\Base\SubscriptionPlan object.
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
     * Compares this with another <code>SubscriptionPlan</code> instance.  If
     * <code>obj</code> is an instance of <code>SubscriptionPlan</code>, delegates to
     * <code>equals(SubscriptionPlan)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SubscriptionPlan The current object, for fluid interface
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
     * Get the [id_subscription_plan] column value.
     *
     * @return int
     */
    public function getIdSubscriptionPlan()
    {
        return $this->id_subscription_plan;
    }

    /**
     * Get the [subscription_plan_name] column value.
     *
     * @return string
     */
    public function getSubscriptionPlanName()
    {
        return $this->subscription_plan_name;
    }

    /**
     * Get the [subscription_plan_description] column value.
     *
     * @return string
     */
    public function getSubscriptionPlanDescription()
    {
        return $this->subscription_plan_description;
    }

    /**
     * Get the [subscription_plan_price] column value.
     *
     * @return string
     */
    public function getSubscriptionPlanPrice()
    {
        return $this->subscription_plan_price;
    }

    /**
     * Get the [subscription_plan_period] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanPeriod()
    {
        return $this->subscription_plan_period;
    }

    /**
     * Get the [subscription_plan_code] column value.
     *
     * @return string
     */
    public function getSubscriptionPlanCode()
    {
        return $this->subscription_plan_code;
    }

    /**
     * Get the [subscription_plan_max_target] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanMaxTarget()
    {
        return $this->subscription_plan_max_target;
    }

    /**
     * Get the [subscription_plan_check_interval] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanCheckInterval()
    {
        return $this->subscription_plan_check_interval;
    }

    /**
     * Get the [subscription_plan_max_localizations] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanMaxLocalizations()
    {
        return $this->subscription_plan_max_localizations;
    }

    /**
     * Get the [subscription_plan_rss] column value.
     *
     * @return boolean
     */
    public function getSubscriptionPlanRss()
    {
        return $this->subscription_plan_rss;
    }

    /**
     * Get the [subscription_plan_rss] column value.
     *
     * @return boolean
     */
    public function isSubscriptionPlanRss()
    {
        return $this->getSubscriptionPlanRss();
    }

    /**
     * Get the [subscription_plan_max_sub_accounts] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanMaxSubAccounts()
    {
        return $this->subscription_plan_max_sub_accounts;
    }

    /**
     * Get the [subscription_plan_max_alert_receivers] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanMaxAlertReceivers()
    {
        return $this->subscription_plan_max_alert_receivers;
    }

    /**
     * Get the [subscription_plan_max_trigger] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanMaxTrigger()
    {
        return $this->subscription_plan_max_trigger;
    }

    /**
     * Get the [subscription_plan_sms_in_period] column value.
     *
     * @return int
     */
    public function getSubscriptionPlanSmsInPeriod()
    {
        return $this->subscription_plan_sms_in_period;
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
            if ($this->subscription_plan_max_target !== 1) {
                return false;
            }

            if ($this->subscription_plan_check_interval !== 600) {
                return false;
            }

            if ($this->subscription_plan_max_localizations !== 1) {
                return false;
            }

            if ($this->subscription_plan_rss !== false) {
                return false;
            }

            if ($this->subscription_plan_max_sub_accounts !== 1) {
                return false;
            }

            if ($this->subscription_plan_max_alert_receivers !== 1) {
                return false;
            }

            if ($this->subscription_plan_max_trigger !== 1) {
                return false;
            }

            if ($this->subscription_plan_sms_in_period !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SubscriptionPlanTableMap::translateFieldName('IdSubscriptionPlan', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_subscription_plan = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_price = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanPeriod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_period = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanMaxTarget', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_max_target = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanCheckInterval', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_check_interval = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanMaxLocalizations', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_max_localizations = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanRss', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_rss = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanMaxSubAccounts', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_max_sub_accounts = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanMaxAlertReceivers', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_max_alert_receivers = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanMaxTrigger', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_max_trigger = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SubscriptionPlanTableMap::translateFieldName('SubscriptionPlanSmsInPeriod', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subscription_plan_sms_in_period = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SubscriptionPlanTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : SubscriptionPlanTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : SubscriptionPlanTableMap::translateFieldName('Slug', TableMap::TYPE_PHPNAME, $indexType)];
            $this->slug = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = SubscriptionPlanTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Model\\SubscriptionPlan'), 0, $e);
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
     * Set the value of [id_subscription_plan] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setIdSubscriptionPlan($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_subscription_plan !== $v) {
            $this->id_subscription_plan = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN] = true;
        }

        return $this;
    } // setIdSubscriptionPlan()

    /**
     * Set the value of [subscription_plan_name] column.
     *
     * @param  string                            $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subscription_plan_name !== $v) {
            $this->subscription_plan_name = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME] = true;
        }

        return $this;
    } // setSubscriptionPlanName()

    /**
     * Set the value of [subscription_plan_description] column.
     *
     * @param  string                            $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subscription_plan_description !== $v) {
            $this->subscription_plan_description = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION] = true;
        }

        return $this;
    } // setSubscriptionPlanDescription()

    /**
     * Set the value of [subscription_plan_price] column.
     *
     * @param  string                            $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subscription_plan_price !== $v) {
            $this->subscription_plan_price = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE] = true;
        }

        return $this;
    } // setSubscriptionPlanPrice()

    /**
     * Set the value of [subscription_plan_period] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanPeriod($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_period !== $v) {
            $this->subscription_plan_period = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD] = true;
        }

        return $this;
    } // setSubscriptionPlanPeriod()

    /**
     * Set the value of [subscription_plan_code] column.
     *
     * @param  string                            $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subscription_plan_code !== $v) {
            $this->subscription_plan_code = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE] = true;
        }

        return $this;
    } // setSubscriptionPlanCode()

    /**
     * Set the value of [subscription_plan_max_target] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanMaxTarget($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_max_target !== $v) {
            $this->subscription_plan_max_target = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET] = true;
        }

        return $this;
    } // setSubscriptionPlanMaxTarget()

    /**
     * Set the value of [subscription_plan_check_interval] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanCheckInterval($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_check_interval !== $v) {
            $this->subscription_plan_check_interval = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL] = true;
        }

        return $this;
    } // setSubscriptionPlanCheckInterval()

    /**
     * Set the value of [subscription_plan_max_localizations] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanMaxLocalizations($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_max_localizations !== $v) {
            $this->subscription_plan_max_localizations = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS] = true;
        }

        return $this;
    } // setSubscriptionPlanMaxLocalizations()

    /**
     * Sets the value of the [subscription_plan_rss] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string            $v The new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanRss($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->subscription_plan_rss !== $v) {
            $this->subscription_plan_rss = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS] = true;
        }

        return $this;
    } // setSubscriptionPlanRss()

    /**
     * Set the value of [subscription_plan_max_sub_accounts] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanMaxSubAccounts($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_max_sub_accounts !== $v) {
            $this->subscription_plan_max_sub_accounts = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS] = true;
        }

        return $this;
    } // setSubscriptionPlanMaxSubAccounts()

    /**
     * Set the value of [subscription_plan_max_alert_receivers] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanMaxAlertReceivers($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_max_alert_receivers !== $v) {
            $this->subscription_plan_max_alert_receivers = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS] = true;
        }

        return $this;
    } // setSubscriptionPlanMaxAlertReceivers()

    /**
     * Set the value of [subscription_plan_max_trigger] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanMaxTrigger($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_max_trigger !== $v) {
            $this->subscription_plan_max_trigger = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER] = true;
        }

        return $this;
    } // setSubscriptionPlanMaxTrigger()

    /**
     * Set the value of [subscription_plan_sms_in_period] column.
     *
     * @param  int                               $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSubscriptionPlanSmsInPeriod($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subscription_plan_sms_in_period !== $v) {
            $this->subscription_plan_sms_in_period = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD] = true;
        }

        return $this;
    } // setSubscriptionPlanSmsInPeriod()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                             $v string, integer (timestamp), or \DateTime value.
     *                                              Empty strings are treated as NULL.
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[SubscriptionPlanTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed                             $v string, integer (timestamp), or \DateTime value.
     *                                              Empty strings are treated as NULL.
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[SubscriptionPlanTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [slug] column.
     *
     * @param  string                            $v new value
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[SubscriptionPlanTableMap::COL_SLUG] = true;
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
            $con = Propel::getServiceContainer()->getReadConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSubscriptionPlanQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSubscriptionPlanChannels = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param  ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SubscriptionPlan::setDeleted()
     * @see SubscriptionPlan::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSubscriptionPlanQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            // sluggable behavior

            if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SLUG) && $this->getSlug()) {
                $this->setSlug($this->makeSlugUnique($this->getSlug()));
            } else {
                $this->setSlug($this->createSlug());
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(SubscriptionPlanTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(SubscriptionPlanTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(SubscriptionPlanTableMap::COL_UPDATED_AT)) {
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
                SubscriptionPlanTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN] = true;
        if (null !== $this->id_subscription_plan) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN)) {
            $modifiedColumns[':p' . $index++]  = 'ID_SUBSCRIPTION_PLAN';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_NAME';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_DESCRIPTION';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_PRICE';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_PERIOD';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_CODE';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_MAX_TARGET';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_CHECK_INTERVAL';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_RSS';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_MAX_TRIGGER';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD)) {
            $modifiedColumns[':p' . $index++]  = 'SUBSCRIPTION_PLAN_SMS_IN_PERIOD';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SLUG)) {
            $modifiedColumns[':p' . $index++]  = 'SLUG';
        }

        $sql = sprintf(
            'INSERT INTO subscription_plan (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_SUBSCRIPTION_PLAN':
                        $stmt->bindValue($identifier, $this->id_subscription_plan, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_NAME':
                        $stmt->bindValue($identifier, $this->subscription_plan_name, PDO::PARAM_STR);
                        break;
                    case 'SUBSCRIPTION_PLAN_DESCRIPTION':
                        $stmt->bindValue($identifier, $this->subscription_plan_description, PDO::PARAM_STR);
                        break;
                    case 'SUBSCRIPTION_PLAN_PRICE':
                        $stmt->bindValue($identifier, $this->subscription_plan_price, PDO::PARAM_STR);
                        break;
                    case 'SUBSCRIPTION_PLAN_PERIOD':
                        $stmt->bindValue($identifier, $this->subscription_plan_period, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_CODE':
                        $stmt->bindValue($identifier, $this->subscription_plan_code, PDO::PARAM_STR);
                        break;
                    case 'SUBSCRIPTION_PLAN_MAX_TARGET':
                        $stmt->bindValue($identifier, $this->subscription_plan_max_target, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_CHECK_INTERVAL':
                        $stmt->bindValue($identifier, $this->subscription_plan_check_interval, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS':
                        $stmt->bindValue($identifier, $this->subscription_plan_max_localizations, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_RSS':
                        $stmt->bindValue($identifier, (int) $this->subscription_plan_rss, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS':
                        $stmt->bindValue($identifier, $this->subscription_plan_max_sub_accounts, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS':
                        $stmt->bindValue($identifier, $this->subscription_plan_max_alert_receivers, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_MAX_TRIGGER':
                        $stmt->bindValue($identifier, $this->subscription_plan_max_trigger, PDO::PARAM_INT);
                        break;
                    case 'SUBSCRIPTION_PLAN_SMS_IN_PERIOD':
                        $stmt->bindValue($identifier, $this->subscription_plan_sms_in_period, PDO::PARAM_INT);
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
        $this->setIdSubscriptionPlan($pk);

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
        $pos = SubscriptionPlanTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdSubscriptionPlan();
                break;
            case 1:
                return $this->getSubscriptionPlanName();
                break;
            case 2:
                return $this->getSubscriptionPlanDescription();
                break;
            case 3:
                return $this->getSubscriptionPlanPrice();
                break;
            case 4:
                return $this->getSubscriptionPlanPeriod();
                break;
            case 5:
                return $this->getSubscriptionPlanCode();
                break;
            case 6:
                return $this->getSubscriptionPlanMaxTarget();
                break;
            case 7:
                return $this->getSubscriptionPlanCheckInterval();
                break;
            case 8:
                return $this->getSubscriptionPlanMaxLocalizations();
                break;
            case 9:
                return $this->getSubscriptionPlanRss();
                break;
            case 10:
                return $this->getSubscriptionPlanMaxSubAccounts();
                break;
            case 11:
                return $this->getSubscriptionPlanMaxAlertReceivers();
                break;
            case 12:
                return $this->getSubscriptionPlanMaxTrigger();
                break;
            case 13:
                return $this->getSubscriptionPlanSmsInPeriod();
                break;
            case 14:
                return $this->getCreatedAt();
                break;
            case 15:
                return $this->getUpdatedAt();
                break;
            case 16:
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
        if (isset($alreadyDumpedObjects['SubscriptionPlan'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SubscriptionPlan'][$this->getPrimaryKey()] = true;
        $keys = SubscriptionPlanTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdSubscriptionPlan(),
            $keys[1] => $this->getSubscriptionPlanName(),
            $keys[2] => $this->getSubscriptionPlanDescription(),
            $keys[3] => $this->getSubscriptionPlanPrice(),
            $keys[4] => $this->getSubscriptionPlanPeriod(),
            $keys[5] => $this->getSubscriptionPlanCode(),
            $keys[6] => $this->getSubscriptionPlanMaxTarget(),
            $keys[7] => $this->getSubscriptionPlanCheckInterval(),
            $keys[8] => $this->getSubscriptionPlanMaxLocalizations(),
            $keys[9] => $this->getSubscriptionPlanRss(),
            $keys[10] => $this->getSubscriptionPlanMaxSubAccounts(),
            $keys[11] => $this->getSubscriptionPlanMaxAlertReceivers(),
            $keys[12] => $this->getSubscriptionPlanMaxTrigger(),
            $keys[13] => $this->getSubscriptionPlanSmsInPeriod(),
            $keys[14] => $this->getCreatedAt(),
            $keys[15] => $this->getUpdatedAt(),
            $keys[16] => $this->getSlug(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSubscriptionPlanChannels) {
                $result['SubscriptionPlanChannels'] = $this->collSubscriptionPlanChannels->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string                            $name
     * @param  mixed                             $value field value
     * @param  string                            $type  The type of fieldname the $name is of:
     *                                                  one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                                                  TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                                                  Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Model\SubscriptionPlan
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SubscriptionPlanTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int                               $pos   position in xml schema
     * @param  mixed                             $value field value
     * @return $this|\App\Model\SubscriptionPlan
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdSubscriptionPlan($value);
                break;
            case 1:
                $this->setSubscriptionPlanName($value);
                break;
            case 2:
                $this->setSubscriptionPlanDescription($value);
                break;
            case 3:
                $this->setSubscriptionPlanPrice($value);
                break;
            case 4:
                $this->setSubscriptionPlanPeriod($value);
                break;
            case 5:
                $this->setSubscriptionPlanCode($value);
                break;
            case 6:
                $this->setSubscriptionPlanMaxTarget($value);
                break;
            case 7:
                $this->setSubscriptionPlanCheckInterval($value);
                break;
            case 8:
                $this->setSubscriptionPlanMaxLocalizations($value);
                break;
            case 9:
                $this->setSubscriptionPlanRss($value);
                break;
            case 10:
                $this->setSubscriptionPlanMaxSubAccounts($value);
                break;
            case 11:
                $this->setSubscriptionPlanMaxAlertReceivers($value);
                break;
            case 12:
                $this->setSubscriptionPlanMaxTrigger($value);
                break;
            case 13:
                $this->setSubscriptionPlanSmsInPeriod($value);
                break;
            case 14:
                $this->setCreatedAt($value);
                break;
            case 15:
                $this->setUpdatedAt($value);
                break;
            case 16:
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
        $keys = SubscriptionPlanTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdSubscriptionPlan($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSubscriptionPlanName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSubscriptionPlanDescription($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSubscriptionPlanPrice($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSubscriptionPlanPeriod($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSubscriptionPlanCode($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSubscriptionPlanMaxTarget($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSubscriptionPlanCheckInterval($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSubscriptionPlanMaxLocalizations($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSubscriptionPlanRss($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSubscriptionPlanMaxSubAccounts($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setSubscriptionPlanMaxAlertReceivers($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setSubscriptionPlanMaxTrigger($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setSubscriptionPlanSmsInPeriod($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setCreatedAt($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setUpdatedAt($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setSlug($arr[$keys[16]]);
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
     * @return $this|\App\Model\SubscriptionPlan The current object, for fluid interface
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
        $criteria = new Criteria(SubscriptionPlanTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN)) {
            $criteria->add(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $this->id_subscription_plan);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME, $this->subscription_plan_name);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION, $this->subscription_plan_description);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE, $this->subscription_plan_price);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD, $this->subscription_plan_period);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE, $this->subscription_plan_code);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET, $this->subscription_plan_max_target);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL, $this->subscription_plan_check_interval);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS, $this->subscription_plan_max_localizations);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS, $this->subscription_plan_rss);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS, $this->subscription_plan_max_sub_accounts);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS, $this->subscription_plan_max_alert_receivers);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER, $this->subscription_plan_max_trigger);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD, $this->subscription_plan_sms_in_period);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_CREATED_AT)) {
            $criteria->add(SubscriptionPlanTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_UPDATED_AT)) {
            $criteria->add(SubscriptionPlanTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(SubscriptionPlanTableMap::COL_SLUG)) {
            $criteria->add(SubscriptionPlanTableMap::COL_SLUG, $this->slug);
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
        $criteria = new Criteria(SubscriptionPlanTableMap::DATABASE_NAME);
        $criteria->add(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $this->id_subscription_plan);

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
        $validPk = null !== $this->getIdSubscriptionPlan();

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
        return $this->getIdSubscriptionPlan();
    }

    /**
     * Generic method to set the primary key (id_subscription_plan column).
     *
     * @param  int  $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdSubscriptionPlan($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdSubscriptionPlan();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  object          $copyObj  An object of \App\Model\SubscriptionPlan (or compatible) type.
     * @param  boolean         $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param  boolean         $makeNew  Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSubscriptionPlanName($this->getSubscriptionPlanName());
        $copyObj->setSubscriptionPlanDescription($this->getSubscriptionPlanDescription());
        $copyObj->setSubscriptionPlanPrice($this->getSubscriptionPlanPrice());
        $copyObj->setSubscriptionPlanPeriod($this->getSubscriptionPlanPeriod());
        $copyObj->setSubscriptionPlanCode($this->getSubscriptionPlanCode());
        $copyObj->setSubscriptionPlanMaxTarget($this->getSubscriptionPlanMaxTarget());
        $copyObj->setSubscriptionPlanCheckInterval($this->getSubscriptionPlanCheckInterval());
        $copyObj->setSubscriptionPlanMaxLocalizations($this->getSubscriptionPlanMaxLocalizations());
        $copyObj->setSubscriptionPlanRss($this->getSubscriptionPlanRss());
        $copyObj->setSubscriptionPlanMaxSubAccounts($this->getSubscriptionPlanMaxSubAccounts());
        $copyObj->setSubscriptionPlanMaxAlertReceivers($this->getSubscriptionPlanMaxAlertReceivers());
        $copyObj->setSubscriptionPlanMaxTrigger($this->getSubscriptionPlanMaxTrigger());
        $copyObj->setSubscriptionPlanSmsInPeriod($this->getSubscriptionPlanSmsInPeriod());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setSlug($this->getSlug());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSubscriptionPlanChannels() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubscriptionPlanChannel($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdSubscriptionPlan(NULL); // this is a auto-increment column, so set to default value
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
     * @param  boolean                     $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Model\SubscriptionPlan Clone of current object.
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
        if ('SubscriptionPlanChannel' == $relationName) {
            return $this->initSubscriptionPlanChannels();
        }
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
     * If this ChildSubscriptionPlan is new, it will return
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
                    ->filterBySubscriptionPlan($this)
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
     * @param  Collection                  $subscriptionPlanChannels A Propel collection.
     * @param  ConnectionInterface         $con                      Optional connection object
     * @return $this|ChildSubscriptionPlan The current object (for fluent API support)
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
            $subscriptionPlanChannelRemoved->setSubscriptionPlan(null);
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
                ->filterBySubscriptionPlan($this)
                ->count($con);
        }

        return count($this->collSubscriptionPlanChannels);
    }

    /**
     * Method called to associate a ChildSubscriptionPlanChannel object to this object
     * through the ChildSubscriptionPlanChannel foreign key attribute.
     *
     * @param  ChildSubscriptionPlanChannel      $l ChildSubscriptionPlanChannel
     * @return $this|\App\Model\SubscriptionPlan The current object (for fluent API support)
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
        $subscriptionPlanChannel->setSubscriptionPlan($this);
    }

    /**
     * @param  ChildSubscriptionPlanChannel $subscriptionPlanChannel The ChildSubscriptionPlanChannel object to remove.
     * @return $this|ChildSubscriptionPlan  The current object (for fluent API support)
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
            $subscriptionPlanChannel->setSubscriptionPlan(null);
        }

        return $this;
    }

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SubscriptionPlan is new, it will return
     * an empty collection; or if this SubscriptionPlan has previously
     * been saved, it will retrieve related SubscriptionPlanChannels from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SubscriptionPlan.
     *
     * @param  Criteria                                        $criteria     optional Criteria object to narrow the query
     * @param  ConnectionInterface                             $con          optional connection object
     * @param  string                                          $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSubscriptionPlanChannel[] List of ChildSubscriptionPlanChannel objects
     */
    public function getSubscriptionPlanChannelsJoinChannel(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubscriptionPlanChannelQuery::create(null, $criteria);
        $query->joinWith('Channel', $joinBehavior);

        return $this->getSubscriptionPlanChannels($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_subscription_plan = null;
        $this->subscription_plan_name = null;
        $this->subscription_plan_description = null;
        $this->subscription_plan_price = null;
        $this->subscription_plan_period = null;
        $this->subscription_plan_code = null;
        $this->subscription_plan_max_target = null;
        $this->subscription_plan_check_interval = null;
        $this->subscription_plan_max_localizations = null;
        $this->subscription_plan_rss = null;
        $this->subscription_plan_max_sub_accounts = null;
        $this->subscription_plan_max_alert_receivers = null;
        $this->subscription_plan_max_trigger = null;
        $this->subscription_plan_sms_in_period = null;
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
            if ($this->collSubscriptionPlanChannels) {
                foreach ($this->collSubscriptionPlanChannels as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSubscriptionPlanChannels = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'subscription_plan_name' column
     */
    public function __toString()
    {
        return (string) $this->getSubscriptionPlanName();
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return $this|ChildSubscriptionPlan The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[SubscriptionPlanTableMap::COL_UPDATED_AT] = true;

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

            $count = \App\Model\SubscriptionPlanQuery::create()
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

        $query = \App\Model\SubscriptionPlanQuery::create('q')
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
