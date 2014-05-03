<?php

namespace App\Model\Map;

use App\Model\CronTask;
use App\Model\CronTaskQuery;
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
 * This class defines the structure of the 'cron_task' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CronTaskTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.CronTaskTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'cron_task';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\CronTask';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.CronTask';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the ID_CRON_TASK field
     */
    const COL_ID_CRON_TASK = 'cron_task.ID_CRON_TASK';

    /**
     * the column name for the CRON_TASK_CODE field
     */
    const COL_CRON_TASK_CODE = 'cron_task.CRON_TASK_CODE';

    /**
     * the column name for the CRON_TASK_INTERVAL field
     */
    const COL_CRON_TASK_INTERVAL = 'cron_task.CRON_TASK_INTERVAL';

    /**
     * the column name for the CRON_TASK_PARAMS field
     */
    const COL_CRON_TASK_PARAMS = 'cron_task.CRON_TASK_PARAMS';

    /**
     * the column name for the CRON_TASK_ACTIVE field
     */
    const COL_CRON_TASK_ACTIVE = 'cron_task.CRON_TASK_ACTIVE';

    /**
     * the column name for the CRON_TASK_STATE field
     */
    const COL_CRON_TASK_STATE = 'cron_task.CRON_TASK_STATE';

    /**
     * the column name for the CRON_TASK_RUN_AT field
     */
    const COL_CRON_TASK_RUN_AT = 'cron_task.CRON_TASK_RUN_AT';

    /**
     * the column name for the CRON_TASK_EXECUTED_AT field
     */
    const COL_CRON_TASK_EXECUTED_AT = 'cron_task.CRON_TASK_EXECUTED_AT';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = 'cron_task.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = 'cron_task.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdCronTask', 'CronTaskCode', 'CronTaskInterval', 'CronTaskParams', 'CronTaskActive', 'CronTaskState', 'CronTaskRunAt', 'CronTaskExecutedAt', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idCronTask', 'cronTaskCode', 'cronTaskInterval', 'cronTaskParams', 'cronTaskActive', 'cronTaskState', 'cronTaskRunAt', 'cronTaskExecutedAt', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(CronTaskTableMap::COL_ID_CRON_TASK, CronTaskTableMap::COL_CRON_TASK_CODE, CronTaskTableMap::COL_CRON_TASK_INTERVAL, CronTaskTableMap::COL_CRON_TASK_PARAMS, CronTaskTableMap::COL_CRON_TASK_ACTIVE, CronTaskTableMap::COL_CRON_TASK_STATE, CronTaskTableMap::COL_CRON_TASK_RUN_AT, CronTaskTableMap::COL_CRON_TASK_EXECUTED_AT, CronTaskTableMap::COL_CREATED_AT, CronTaskTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_CRON_TASK', 'COL_CRON_TASK_CODE', 'COL_CRON_TASK_INTERVAL', 'COL_CRON_TASK_PARAMS', 'COL_CRON_TASK_ACTIVE', 'COL_CRON_TASK_STATE', 'COL_CRON_TASK_RUN_AT', 'COL_CRON_TASK_EXECUTED_AT', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_cron_task', 'cron_task_code', 'cron_task_interval', 'cron_task_params', 'cron_task_active', 'cron_task_state', 'cron_task_run_at', 'cron_task_executed_at', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdCronTask' => 0, 'CronTaskCode' => 1, 'CronTaskInterval' => 2, 'CronTaskParams' => 3, 'CronTaskActive' => 4, 'CronTaskState' => 5, 'CronTaskRunAt' => 6, 'CronTaskExecutedAt' => 7, 'CreatedAt' => 8, 'UpdatedAt' => 9, ),
        self::TYPE_STUDLYPHPNAME => array('idCronTask' => 0, 'cronTaskCode' => 1, 'cronTaskInterval' => 2, 'cronTaskParams' => 3, 'cronTaskActive' => 4, 'cronTaskState' => 5, 'cronTaskRunAt' => 6, 'cronTaskExecutedAt' => 7, 'createdAt' => 8, 'updatedAt' => 9, ),
        self::TYPE_COLNAME       => array(CronTaskTableMap::COL_ID_CRON_TASK => 0, CronTaskTableMap::COL_CRON_TASK_CODE => 1, CronTaskTableMap::COL_CRON_TASK_INTERVAL => 2, CronTaskTableMap::COL_CRON_TASK_PARAMS => 3, CronTaskTableMap::COL_CRON_TASK_ACTIVE => 4, CronTaskTableMap::COL_CRON_TASK_STATE => 5, CronTaskTableMap::COL_CRON_TASK_RUN_AT => 6, CronTaskTableMap::COL_CRON_TASK_EXECUTED_AT => 7, CronTaskTableMap::COL_CREATED_AT => 8, CronTaskTableMap::COL_UPDATED_AT => 9, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_CRON_TASK' => 0, 'COL_CRON_TASK_CODE' => 1, 'COL_CRON_TASK_INTERVAL' => 2, 'COL_CRON_TASK_PARAMS' => 3, 'COL_CRON_TASK_ACTIVE' => 4, 'COL_CRON_TASK_STATE' => 5, 'COL_CRON_TASK_RUN_AT' => 6, 'COL_CRON_TASK_EXECUTED_AT' => 7, 'COL_CREATED_AT' => 8, 'COL_UPDATED_AT' => 9, ),
        self::TYPE_FIELDNAME     => array('id_cron_task' => 0, 'cron_task_code' => 1, 'cron_task_interval' => 2, 'cron_task_params' => 3, 'cron_task_active' => 4, 'cron_task_state' => 5, 'cron_task_run_at' => 6, 'cron_task_executed_at' => 7, 'created_at' => 8, 'updated_at' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('cron_task');
        $this->setPhpName('CronTask');
        $this->setClassName('\\App\\Model\\CronTask');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_CRON_TASK', 'IdCronTask', 'INTEGER', true, 10, null);
        $this->addColumn('CRON_TASK_CODE', 'CronTaskCode', 'VARCHAR', true, 100, null);
        $this->addColumn('CRON_TASK_INTERVAL', 'CronTaskInterval', 'INTEGER', true, 5, 600);
        $this->addColumn('CRON_TASK_PARAMS', 'CronTaskParams', 'LONGVARCHAR', true, null, null);
        $this->addColumn('CRON_TASK_ACTIVE', 'CronTaskActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('CRON_TASK_STATE', 'CronTaskState', 'CHAR', true, null, 'scheduled');
        $this->addColumn('CRON_TASK_RUN_AT', 'CronTaskRunAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('CRON_TASK_EXECUTED_AT', 'CronTaskExecutedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCronTask', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCronTask', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdCronTask', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CronTaskTableMap::CLASS_DEFAULT : CronTaskTableMap::OM_CLASS;
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
     * @return array           (CronTask object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CronTaskTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CronTaskTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CronTaskTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CronTaskTableMap::OM_CLASS;
            /** @var CronTask $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CronTaskTableMap::addInstanceToPool($obj, $key);
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
            $key = CronTaskTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CronTaskTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CronTask $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CronTaskTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CronTaskTableMap::COL_ID_CRON_TASK);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_CODE);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_INTERVAL);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_PARAMS);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_ACTIVE);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_STATE);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_RUN_AT);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CRON_TASK_EXECUTED_AT);
            $criteria->addSelectColumn(CronTaskTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(CronTaskTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_CRON_TASK');
            $criteria->addSelectColumn($alias . '.CRON_TASK_CODE');
            $criteria->addSelectColumn($alias . '.CRON_TASK_INTERVAL');
            $criteria->addSelectColumn($alias . '.CRON_TASK_PARAMS');
            $criteria->addSelectColumn($alias . '.CRON_TASK_ACTIVE');
            $criteria->addSelectColumn($alias . '.CRON_TASK_STATE');
            $criteria->addSelectColumn($alias . '.CRON_TASK_RUN_AT');
            $criteria->addSelectColumn($alias . '.CRON_TASK_EXECUTED_AT');
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
        return Propel::getServiceContainer()->getDatabaseMap(CronTaskTableMap::DATABASE_NAME)->getTable(CronTaskTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CronTaskTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CronTaskTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CronTaskTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CronTask or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CronTask object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CronTaskTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\CronTask) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CronTaskTableMap::DATABASE_NAME);
            $criteria->add(CronTaskTableMap::COL_ID_CRON_TASK, (array) $values, Criteria::IN);
        }

        $query = CronTaskQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CronTaskTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CronTaskTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the cron_task table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CronTaskQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CronTask or Criteria object.
     *
     * @param mixed               $criteria Criteria or CronTask object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronTaskTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CronTask object
        }

        if ($criteria->containsKey(CronTaskTableMap::COL_ID_CRON_TASK) && $criteria->keyContainsValue(CronTaskTableMap::COL_ID_CRON_TASK) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CronTaskTableMap::COL_ID_CRON_TASK.')');
        }


        // Set the correct dbName
        $query = CronTaskQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CronTaskTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CronTaskTableMap::buildTableMap();
