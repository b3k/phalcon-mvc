<?php

namespace app\Model\Map;

use App\Model\SubscriptionPlan;
use App\Model\SubscriptionPlanQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;

/**
 * This class defines the structure of the 'subscription_plan' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SubscriptionPlanTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.SubscriptionPlanTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'subscription_plan';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\SubscriptionPlan';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.SubscriptionPlan';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 17;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 17;

    /**
     * the column name for the ID_SUBSCRIPTION_PLAN field
     */
    const COL_ID_SUBSCRIPTION_PLAN = 'subscription_plan.ID_SUBSCRIPTION_PLAN';

    /**
     * the column name for the SUBSCRIPTION_PLAN_NAME field
     */
    const COL_SUBSCRIPTION_PLAN_NAME = 'subscription_plan.SUBSCRIPTION_PLAN_NAME';

    /**
     * the column name for the SUBSCRIPTION_PLAN_DESCRIPTION field
     */
    const COL_SUBSCRIPTION_PLAN_DESCRIPTION = 'subscription_plan.SUBSCRIPTION_PLAN_DESCRIPTION';

    /**
     * the column name for the SUBSCRIPTION_PLAN_PRICE field
     */
    const COL_SUBSCRIPTION_PLAN_PRICE = 'subscription_plan.SUBSCRIPTION_PLAN_PRICE';

    /**
     * the column name for the SUBSCRIPTION_PLAN_PERIOD field
     */
    const COL_SUBSCRIPTION_PLAN_PERIOD = 'subscription_plan.SUBSCRIPTION_PLAN_PERIOD';

    /**
     * the column name for the SUBSCRIPTION_PLAN_CODE field
     */
    const COL_SUBSCRIPTION_PLAN_CODE = 'subscription_plan.SUBSCRIPTION_PLAN_CODE';

    /**
     * the column name for the SUBSCRIPTION_PLAN_MAX_TARGET field
     */
    const COL_SUBSCRIPTION_PLAN_MAX_TARGET = 'subscription_plan.SUBSCRIPTION_PLAN_MAX_TARGET';

    /**
     * the column name for the SUBSCRIPTION_PLAN_CHECK_INTERVAL field
     */
    const COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL = 'subscription_plan.SUBSCRIPTION_PLAN_CHECK_INTERVAL';

    /**
     * the column name for the SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS field
     */
    const COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS = 'subscription_plan.SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS';

    /**
     * the column name for the SUBSCRIPTION_PLAN_RSS field
     */
    const COL_SUBSCRIPTION_PLAN_RSS = 'subscription_plan.SUBSCRIPTION_PLAN_RSS';

    /**
     * the column name for the SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS field
     */
    const COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS = 'subscription_plan.SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS';

    /**
     * the column name for the SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS field
     */
    const COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS = 'subscription_plan.SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS';

    /**
     * the column name for the SUBSCRIPTION_PLAN_MAX_TRIGGER field
     */
    const COL_SUBSCRIPTION_PLAN_MAX_TRIGGER = 'subscription_plan.SUBSCRIPTION_PLAN_MAX_TRIGGER';

    /**
     * the column name for the SUBSCRIPTION_PLAN_SMS_IN_PERIOD field
     */
    const COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD = 'subscription_plan.SUBSCRIPTION_PLAN_SMS_IN_PERIOD';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = 'subscription_plan.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = 'subscription_plan.UPDATED_AT';

    /**
     * the column name for the SLUG field
     */
    const COL_SLUG = 'subscription_plan.SLUG';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('IdSubscriptionPlan', 'SubscriptionPlanName', 'SubscriptionPlanDescription', 'SubscriptionPlanPrice', 'SubscriptionPlanPeriod', 'SubscriptionPlanCode', 'SubscriptionPlanMaxTarget', 'SubscriptionPlanCheckInterval', 'SubscriptionPlanMaxLocalizations', 'SubscriptionPlanRss', 'SubscriptionPlanMaxSubAccounts', 'SubscriptionPlanMaxAlertReceivers', 'SubscriptionPlanMaxTrigger', 'SubscriptionPlanSmsInPeriod', 'CreatedAt', 'UpdatedAt', 'Slug', ),
        self::TYPE_STUDLYPHPNAME => array('idSubscriptionPlan', 'subscriptionPlanName', 'subscriptionPlanDescription', 'subscriptionPlanPrice', 'subscriptionPlanPeriod', 'subscriptionPlanCode', 'subscriptionPlanMaxTarget', 'subscriptionPlanCheckInterval', 'subscriptionPlanMaxLocalizations', 'subscriptionPlanRss', 'subscriptionPlanMaxSubAccounts', 'subscriptionPlanMaxAlertReceivers', 'subscriptionPlanMaxTrigger', 'subscriptionPlanSmsInPeriod', 'createdAt', 'updatedAt', 'slug', ),
        self::TYPE_COLNAME       => array(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD, SubscriptionPlanTableMap::COL_CREATED_AT, SubscriptionPlanTableMap::COL_UPDATED_AT, SubscriptionPlanTableMap::COL_SLUG, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_SUBSCRIPTION_PLAN', 'COL_SUBSCRIPTION_PLAN_NAME', 'COL_SUBSCRIPTION_PLAN_DESCRIPTION', 'COL_SUBSCRIPTION_PLAN_PRICE', 'COL_SUBSCRIPTION_PLAN_PERIOD', 'COL_SUBSCRIPTION_PLAN_CODE', 'COL_SUBSCRIPTION_PLAN_MAX_TARGET', 'COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL', 'COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS', 'COL_SUBSCRIPTION_PLAN_RSS', 'COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS', 'COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS', 'COL_SUBSCRIPTION_PLAN_MAX_TRIGGER', 'COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD', 'COL_CREATED_AT', 'COL_UPDATED_AT', 'COL_SLUG', ),
        self::TYPE_FIELDNAME     => array('id_subscription_plan', 'subscription_plan_name', 'subscription_plan_description', 'subscription_plan_price', 'subscription_plan_period', 'subscription_plan_code', 'subscription_plan_max_target', 'subscription_plan_check_interval', 'subscription_plan_max_localizations', 'subscription_plan_rss', 'subscription_plan_max_sub_accounts', 'subscription_plan_max_alert_receivers', 'subscription_plan_max_trigger', 'subscription_plan_sms_in_period', 'created_at', 'updated_at', 'slug', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdSubscriptionPlan' => 0, 'SubscriptionPlanName' => 1, 'SubscriptionPlanDescription' => 2, 'SubscriptionPlanPrice' => 3, 'SubscriptionPlanPeriod' => 4, 'SubscriptionPlanCode' => 5, 'SubscriptionPlanMaxTarget' => 6, 'SubscriptionPlanCheckInterval' => 7, 'SubscriptionPlanMaxLocalizations' => 8, 'SubscriptionPlanRss' => 9, 'SubscriptionPlanMaxSubAccounts' => 10, 'SubscriptionPlanMaxAlertReceivers' => 11, 'SubscriptionPlanMaxTrigger' => 12, 'SubscriptionPlanSmsInPeriod' => 13, 'CreatedAt' => 14, 'UpdatedAt' => 15, 'Slug' => 16, ),
        self::TYPE_STUDLYPHPNAME => array('idSubscriptionPlan' => 0, 'subscriptionPlanName' => 1, 'subscriptionPlanDescription' => 2, 'subscriptionPlanPrice' => 3, 'subscriptionPlanPeriod' => 4, 'subscriptionPlanCode' => 5, 'subscriptionPlanMaxTarget' => 6, 'subscriptionPlanCheckInterval' => 7, 'subscriptionPlanMaxLocalizations' => 8, 'subscriptionPlanRss' => 9, 'subscriptionPlanMaxSubAccounts' => 10, 'subscriptionPlanMaxAlertReceivers' => 11, 'subscriptionPlanMaxTrigger' => 12, 'subscriptionPlanSmsInPeriod' => 13, 'createdAt' => 14, 'updatedAt' => 15, 'slug' => 16, ),
        self::TYPE_COLNAME       => array(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN => 0, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME => 1, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION => 2, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE => 3, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD => 4, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE => 5, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET => 6, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL => 7, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS => 8, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS => 9, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS => 10, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS => 11, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER => 12, SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD => 13, SubscriptionPlanTableMap::COL_CREATED_AT => 14, SubscriptionPlanTableMap::COL_UPDATED_AT => 15, SubscriptionPlanTableMap::COL_SLUG => 16, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_SUBSCRIPTION_PLAN' => 0, 'COL_SUBSCRIPTION_PLAN_NAME' => 1, 'COL_SUBSCRIPTION_PLAN_DESCRIPTION' => 2, 'COL_SUBSCRIPTION_PLAN_PRICE' => 3, 'COL_SUBSCRIPTION_PLAN_PERIOD' => 4, 'COL_SUBSCRIPTION_PLAN_CODE' => 5, 'COL_SUBSCRIPTION_PLAN_MAX_TARGET' => 6, 'COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL' => 7, 'COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS' => 8, 'COL_SUBSCRIPTION_PLAN_RSS' => 9, 'COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS' => 10, 'COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS' => 11, 'COL_SUBSCRIPTION_PLAN_MAX_TRIGGER' => 12, 'COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD' => 13, 'COL_CREATED_AT' => 14, 'COL_UPDATED_AT' => 15, 'COL_SLUG' => 16, ),
        self::TYPE_FIELDNAME     => array('id_subscription_plan' => 0, 'subscription_plan_name' => 1, 'subscription_plan_description' => 2, 'subscription_plan_price' => 3, 'subscription_plan_period' => 4, 'subscription_plan_code' => 5, 'subscription_plan_max_target' => 6, 'subscription_plan_check_interval' => 7, 'subscription_plan_max_localizations' => 8, 'subscription_plan_rss' => 9, 'subscription_plan_max_sub_accounts' => 10, 'subscription_plan_max_alert_receivers' => 11, 'subscription_plan_max_trigger' => 12, 'subscription_plan_sms_in_period' => 13, 'created_at' => 14, 'updated_at' => 15, 'slug' => 16, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('subscription_plan');
        $this->setPhpName('SubscriptionPlan');
        $this->setClassName('\\App\\Model\\SubscriptionPlan');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_SUBSCRIPTION_PLAN', 'IdSubscriptionPlan', 'INTEGER', true, 10, null);
        $this->addColumn('SUBSCRIPTION_PLAN_NAME', 'SubscriptionPlanName', 'VARCHAR', true, 50, null);
        $this->getColumn('SUBSCRIPTION_PLAN_NAME', false)->setPrimaryString(true);
        $this->addColumn('SUBSCRIPTION_PLAN_DESCRIPTION', 'SubscriptionPlanDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('SUBSCRIPTION_PLAN_PRICE', 'SubscriptionPlanPrice', 'DECIMAL', false, 7, null);
        $this->addColumn('SUBSCRIPTION_PLAN_PERIOD', 'SubscriptionPlanPeriod', 'INTEGER', false, 12, null);
        $this->addColumn('SUBSCRIPTION_PLAN_CODE', 'SubscriptionPlanCode', 'VARCHAR', true, 10, null);
        $this->addColumn('SUBSCRIPTION_PLAN_MAX_TARGET', 'SubscriptionPlanMaxTarget', 'INTEGER', true, 5, 1);
        $this->addColumn('SUBSCRIPTION_PLAN_CHECK_INTERVAL', 'SubscriptionPlanCheckInterval', 'INTEGER', true, 10, 600);
        $this->addColumn('SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS', 'SubscriptionPlanMaxLocalizations', 'INTEGER', true, 5, 1);
        $this->addColumn('SUBSCRIPTION_PLAN_RSS', 'SubscriptionPlanRss', 'BOOLEAN', true, 1, false);
        $this->addColumn('SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS', 'SubscriptionPlanMaxSubAccounts', 'INTEGER', true, 5, 1);
        $this->addColumn('SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS', 'SubscriptionPlanMaxAlertReceivers', 'INTEGER', true, 5, 1);
        $this->addColumn('SUBSCRIPTION_PLAN_MAX_TRIGGER', 'SubscriptionPlanMaxTrigger', 'INTEGER', true, 5, 1);
        $this->addColumn('SUBSCRIPTION_PLAN_SMS_IN_PERIOD', 'SubscriptionPlanSmsInPeriod', 'INTEGER', true, 5, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('SLUG', 'Slug', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SubscriptionPlanChannel', '\\App\\Model\\SubscriptionPlanChannel', RelationMap::ONE_TO_MANY, array('id_subscription_plan' => 'id_subscription_plan', ), 'CASCADE', null, 'SubscriptionPlanChannels');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
            'sluggable' => array('slug_column' => 'slug', 'slug_pattern' => '', 'replace_pattern' => '/\W+/', 'replacement' => '-', 'separator' => '-', 'permanent' => 'false', 'scope_column' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to subscription_plan     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SubscriptionPlanChannelTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                          TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdSubscriptionPlan', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdSubscriptionPlan', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                          TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdSubscriptionPlan', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param  boolean $withPrefix Whether or not to return the path with the class name
     * @return string  path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SubscriptionPlanTableMap::CLASS_DEFAULT : SubscriptionPlanTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (SubscriptionPlan object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SubscriptionPlanTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SubscriptionPlanTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SubscriptionPlanTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SubscriptionPlanTableMap::OM_CLASS;
            /** @var SubscriptionPlan $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SubscriptionPlanTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param  DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException      Any exceptions caught during processing will be
     *                                          rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SubscriptionPlanTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SubscriptionPlanTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SubscriptionPlan $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SubscriptionPlanTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param  Criteria        $criteria object containing the columns to add.
     * @param  string          $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                                  rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(SubscriptionPlanTableMap::COL_SLUG);
        } else {
            $criteria->addSelectColumn($alias . '.ID_SUBSCRIPTION_PLAN');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_NAME');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_PRICE');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_PERIOD');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_CODE');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_MAX_TARGET');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_CHECK_INTERVAL');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_RSS');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_MAX_TRIGGER');
            $criteria->addSelectColumn($alias . '.SUBSCRIPTION_PLAN_SMS_IN_PERIOD');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.SLUG');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SubscriptionPlanTableMap::DATABASE_NAME)->getTable(SubscriptionPlanTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SubscriptionPlanTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SubscriptionPlanTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SubscriptionPlanTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SubscriptionPlan or Criteria object OR a primary key value.
     *
     * @param  mixed               $values Criteria or SubscriptionPlan object or primary key or array of primary keys
     *                                     which is used to create the DELETE statement
     * @param  ConnectionInterface $con    the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                                    if supported by native driver or if emulated using Propel.
     * @throws PropelException     Any exceptions caught during processing will be
     *                                    rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\SubscriptionPlan) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SubscriptionPlanTableMap::DATABASE_NAME);
            $criteria->add(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, (array) $values, Criteria::IN);
        }

        $query = SubscriptionPlanQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SubscriptionPlanTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SubscriptionPlanTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the subscription_plan table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SubscriptionPlanQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SubscriptionPlan or Criteria object.
     *
     * @param  mixed               $criteria Criteria or SubscriptionPlan object containing data that is used to create the INSERT statement.
     * @param  ConnectionInterface $con      the ConnectionInterface connection to use
     * @return mixed               The new primary key.
     * @throws PropelException     Any exceptions caught during processing will be
     *                                      rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SubscriptionPlan object
        }

        if ($criteria->containsKey(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN) && $criteria->keyContainsValue(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN.')');
        }

        // Set the correct dbName
        $query = SubscriptionPlanQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SubscriptionPlanTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SubscriptionPlanTableMap::buildTableMap();
