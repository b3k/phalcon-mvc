<?php

namespace App\Model\Map;

use App\Model\Trigger;
use App\Model\TriggerQuery;
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
 * This class defines the structure of the 'trigger' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TriggerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.TriggerTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'trigger';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\Trigger';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.Trigger';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID_TRIGGER field
     */
    const COL_ID_TRIGGER = 'trigger.ID_TRIGGER';

    /**
     * the column name for the TARGET_ID field
     */
    const COL_TARGET_ID = 'trigger.TARGET_ID';

    /**
     * the column name for the USER_ID field
     */
    const COL_USER_ID = 'trigger.USER_ID';

    /**
     * the column name for the TRIGGER_TYPE_ID field
     */
    const COL_TRIGGER_TYPE_ID = 'trigger.TRIGGER_TYPE_ID';

    /**
     * the column name for the TRIGGER_PARAMS field
     */
    const COL_TRIGGER_PARAMS = 'trigger.TRIGGER_PARAMS';

    /**
     * the column name for the TRIGGER_INVOKE_ON field
     */
    const COL_TRIGGER_INVOKE_ON = 'trigger.TRIGGER_INVOKE_ON';

    /**
     * the column name for the TRIGGER_NAME field
     */
    const COL_TRIGGER_NAME = 'trigger.TRIGGER_NAME';

    /**
     * the column name for the TRIGGER_ACTIVE field
     */
    const COL_TRIGGER_ACTIVE = 'trigger.TRIGGER_ACTIVE';

    /**
     * the column name for the TRIGGER_LAST_EXECUTED_AT field
     */
    const COL_TRIGGER_LAST_EXECUTED_AT = 'trigger.TRIGGER_LAST_EXECUTED_AT';

    /**
     * the column name for the TRIGGER_LAST_EXECUTED_RESULT field
     */
    const COL_TRIGGER_LAST_EXECUTED_RESULT = 'trigger.TRIGGER_LAST_EXECUTED_RESULT';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = 'trigger.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = 'trigger.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTrigger', 'TargetId', 'UserId', 'TriggerTypeId', 'TriggerParams', 'TriggerInvokeOn', 'TriggerName', 'TriggerActive', 'TriggerLastExecutedAt', 'TriggerLastExecutedResult', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTrigger', 'targetId', 'userId', 'triggerTypeId', 'triggerParams', 'triggerInvokeOn', 'triggerName', 'triggerActive', 'triggerLastExecutedAt', 'triggerLastExecutedResult', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TriggerTableMap::COL_ID_TRIGGER, TriggerTableMap::COL_TARGET_ID, TriggerTableMap::COL_USER_ID, TriggerTableMap::COL_TRIGGER_TYPE_ID, TriggerTableMap::COL_TRIGGER_PARAMS, TriggerTableMap::COL_TRIGGER_INVOKE_ON, TriggerTableMap::COL_TRIGGER_NAME, TriggerTableMap::COL_TRIGGER_ACTIVE, TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT, TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT, TriggerTableMap::COL_CREATED_AT, TriggerTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TRIGGER', 'COL_TARGET_ID', 'COL_USER_ID', 'COL_TRIGGER_TYPE_ID', 'COL_TRIGGER_PARAMS', 'COL_TRIGGER_INVOKE_ON', 'COL_TRIGGER_NAME', 'COL_TRIGGER_ACTIVE', 'COL_TRIGGER_LAST_EXECUTED_AT', 'COL_TRIGGER_LAST_EXECUTED_RESULT', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_trigger', 'target_id', 'user_id', 'trigger_type_id', 'trigger_params', 'trigger_invoke_on', 'trigger_name', 'trigger_active', 'trigger_last_executed_at', 'trigger_last_executed_result', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTrigger' => 0, 'TargetId' => 1, 'UserId' => 2, 'TriggerTypeId' => 3, 'TriggerParams' => 4, 'TriggerInvokeOn' => 5, 'TriggerName' => 6, 'TriggerActive' => 7, 'TriggerLastExecutedAt' => 8, 'TriggerLastExecutedResult' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('idTrigger' => 0, 'targetId' => 1, 'userId' => 2, 'triggerTypeId' => 3, 'triggerParams' => 4, 'triggerInvokeOn' => 5, 'triggerName' => 6, 'triggerActive' => 7, 'triggerLastExecutedAt' => 8, 'triggerLastExecutedResult' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(TriggerTableMap::COL_ID_TRIGGER => 0, TriggerTableMap::COL_TARGET_ID => 1, TriggerTableMap::COL_USER_ID => 2, TriggerTableMap::COL_TRIGGER_TYPE_ID => 3, TriggerTableMap::COL_TRIGGER_PARAMS => 4, TriggerTableMap::COL_TRIGGER_INVOKE_ON => 5, TriggerTableMap::COL_TRIGGER_NAME => 6, TriggerTableMap::COL_TRIGGER_ACTIVE => 7, TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT => 8, TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT => 9, TriggerTableMap::COL_CREATED_AT => 10, TriggerTableMap::COL_UPDATED_AT => 11, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TRIGGER' => 0, 'COL_TARGET_ID' => 1, 'COL_USER_ID' => 2, 'COL_TRIGGER_TYPE_ID' => 3, 'COL_TRIGGER_PARAMS' => 4, 'COL_TRIGGER_INVOKE_ON' => 5, 'COL_TRIGGER_NAME' => 6, 'COL_TRIGGER_ACTIVE' => 7, 'COL_TRIGGER_LAST_EXECUTED_AT' => 8, 'COL_TRIGGER_LAST_EXECUTED_RESULT' => 9, 'COL_CREATED_AT' => 10, 'COL_UPDATED_AT' => 11, ),
        self::TYPE_FIELDNAME     => array('id_trigger' => 0, 'target_id' => 1, 'user_id' => 2, 'trigger_type_id' => 3, 'trigger_params' => 4, 'trigger_invoke_on' => 5, 'trigger_name' => 6, 'trigger_active' => 7, 'trigger_last_executed_at' => 8, 'trigger_last_executed_result' => 9, 'created_at' => 10, 'updated_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('trigger');
        $this->setPhpName('Trigger');
        $this->setClassName('\\App\\Model\\Trigger');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TRIGGER', 'IdTrigger', 'INTEGER', true, 10, null);
        $this->addForeignKey('TARGET_ID', 'TargetId', 'INTEGER', 'target', 'ID_TARGET', true, 10, null);
        $this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID_USER', true, 10, null);
        $this->addForeignKey('TRIGGER_TYPE_ID', 'TriggerTypeId', 'INTEGER', 'trigger_type', 'ID_TRIGGER_TYPE', true, 10, null);
        $this->addColumn('TRIGGER_PARAMS', 'TriggerParams', 'LONGVARCHAR', true, null, null);
        $this->addColumn('TRIGGER_INVOKE_ON', 'TriggerInvokeOn', 'ARRAY', true, null, null);
        $this->addColumn('TRIGGER_NAME', 'TriggerName', 'VARCHAR', true, 100, null);
        $this->getColumn('TRIGGER_NAME', false)->setPrimaryString(true);
        $this->addColumn('TRIGGER_ACTIVE', 'TriggerActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('TRIGGER_LAST_EXECUTED_AT', 'TriggerLastExecutedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('TRIGGER_LAST_EXECUTED_RESULT', 'TriggerLastExecutedResult', 'VARCHAR', false, 50, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Target', '\\App\\Model\\Target', RelationMap::MANY_TO_ONE, array('target_id' => 'id_target', ), null, null);
        $this->addRelation('User', '\\App\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id_user', ), null, null);
        $this->addRelation('TriggerType', '\\App\\Model\\TriggerType', RelationMap::MANY_TO_ONE, array('trigger_type_id' => 'id_trigger_type', ), null, null);
        $this->addRelation('TriggerLog', '\\App\\Model\\TriggerLog', RelationMap::ONE_TO_MANY, array('id_trigger' => 'trigger_id', ), 'CASCADE', null, 'TriggerLogs');
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
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to trigger     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        TriggerLogTableMap::clearInstancePool();
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
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTrigger', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTrigger', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdTrigger', TableMap::TYPE_PHPNAME, $indexType)
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
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TriggerTableMap::CLASS_DEFAULT : TriggerTableMap::OM_CLASS;
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
     * @return array           (Trigger object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TriggerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TriggerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TriggerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TriggerTableMap::OM_CLASS;
            /** @var Trigger $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TriggerTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TriggerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TriggerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Trigger $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TriggerTableMap::addInstanceToPool($obj, $key);
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
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TriggerTableMap::COL_ID_TRIGGER);
            $criteria->addSelectColumn(TriggerTableMap::COL_TARGET_ID);
            $criteria->addSelectColumn(TriggerTableMap::COL_USER_ID);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_TYPE_ID);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_PARAMS);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_INVOKE_ON);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_NAME);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_ACTIVE);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT);
            $criteria->addSelectColumn(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT);
            $criteria->addSelectColumn(TriggerTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TriggerTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TRIGGER');
            $criteria->addSelectColumn($alias . '.TARGET_ID');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.TRIGGER_TYPE_ID');
            $criteria->addSelectColumn($alias . '.TRIGGER_PARAMS');
            $criteria->addSelectColumn($alias . '.TRIGGER_INVOKE_ON');
            $criteria->addSelectColumn($alias . '.TRIGGER_NAME');
            $criteria->addSelectColumn($alias . '.TRIGGER_ACTIVE');
            $criteria->addSelectColumn($alias . '.TRIGGER_LAST_EXECUTED_AT');
            $criteria->addSelectColumn($alias . '.TRIGGER_LAST_EXECUTED_RESULT');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
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
        return Propel::getServiceContainer()->getDatabaseMap(TriggerTableMap::DATABASE_NAME)->getTable(TriggerTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TriggerTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TriggerTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TriggerTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Trigger or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Trigger object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\Trigger) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TriggerTableMap::DATABASE_NAME);
            $criteria->add(TriggerTableMap::COL_ID_TRIGGER, (array) $values, Criteria::IN);
        }

        $query = TriggerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TriggerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TriggerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the trigger table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TriggerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Trigger or Criteria object.
     *
     * @param mixed               $criteria Criteria or Trigger object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Trigger object
        }

        if ($criteria->containsKey(TriggerTableMap::COL_ID_TRIGGER) && $criteria->keyContainsValue(TriggerTableMap::COL_ID_TRIGGER) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TriggerTableMap::COL_ID_TRIGGER.')');
        }


        // Set the correct dbName
        $query = TriggerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TriggerTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TriggerTableMap::buildTableMap();
