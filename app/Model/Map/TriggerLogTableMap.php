<?php

namespace app\Model\Map;

use App\Model\TriggerLog;
use App\Model\TriggerLogQuery;
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
 * This class defines the structure of the 'trigger_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TriggerLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.TriggerLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'trigger_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\TriggerLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.TriggerLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the ID_TRIGGER_LOG field
     */
    const COL_ID_TRIGGER_LOG = 'trigger_log.ID_TRIGGER_LOG';

    /**
     * the column name for the TRIGGER_ID field
     */
    const COL_TRIGGER_ID = 'trigger_log.TRIGGER_ID';

    /**
     * the column name for the TRIGGER_LOG_EXECUTED_ON field
     */
    const COL_TRIGGER_LOG_EXECUTED_ON = 'trigger_log.TRIGGER_LOG_EXECUTED_ON';

    /**
     * the column name for the TRIGGER_LOG_RESULT field
     */
    const COL_TRIGGER_LOG_RESULT = 'trigger_log.TRIGGER_LOG_RESULT';

    /**
     * the column name for the EXECUTED_AT field
     */
    const COL_EXECUTED_AT = 'trigger_log.EXECUTED_AT';

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
        self::TYPE_PHPNAME       => array('IdTriggerLog', 'TriggerId', 'TriggerLogExecutedOn', 'TriggerLogResult', 'ExecutedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTriggerLog', 'triggerId', 'triggerLogExecutedOn', 'triggerLogResult', 'executedAt', ),
        self::TYPE_COLNAME       => array(TriggerLogTableMap::COL_ID_TRIGGER_LOG, TriggerLogTableMap::COL_TRIGGER_ID, TriggerLogTableMap::COL_TRIGGER_LOG_EXECUTED_ON, TriggerLogTableMap::COL_TRIGGER_LOG_RESULT, TriggerLogTableMap::COL_EXECUTED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TRIGGER_LOG', 'COL_TRIGGER_ID', 'COL_TRIGGER_LOG_EXECUTED_ON', 'COL_TRIGGER_LOG_RESULT', 'COL_EXECUTED_AT', ),
        self::TYPE_FIELDNAME     => array('id_trigger_log', 'trigger_id', 'trigger_log_executed_on', 'trigger_log_result', 'executed_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTriggerLog' => 0, 'TriggerId' => 1, 'TriggerLogExecutedOn' => 2, 'TriggerLogResult' => 3, 'ExecutedAt' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('idTriggerLog' => 0, 'triggerId' => 1, 'triggerLogExecutedOn' => 2, 'triggerLogResult' => 3, 'executedAt' => 4, ),
        self::TYPE_COLNAME       => array(TriggerLogTableMap::COL_ID_TRIGGER_LOG => 0, TriggerLogTableMap::COL_TRIGGER_ID => 1, TriggerLogTableMap::COL_TRIGGER_LOG_EXECUTED_ON => 2, TriggerLogTableMap::COL_TRIGGER_LOG_RESULT => 3, TriggerLogTableMap::COL_EXECUTED_AT => 4, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TRIGGER_LOG' => 0, 'COL_TRIGGER_ID' => 1, 'COL_TRIGGER_LOG_EXECUTED_ON' => 2, 'COL_TRIGGER_LOG_RESULT' => 3, 'COL_EXECUTED_AT' => 4, ),
        self::TYPE_FIELDNAME     => array('id_trigger_log' => 0, 'trigger_id' => 1, 'trigger_log_executed_on' => 2, 'trigger_log_result' => 3, 'executed_at' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('trigger_log');
        $this->setPhpName('TriggerLog');
        $this->setClassName('\\App\\Model\\TriggerLog');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TRIGGER_LOG', 'IdTriggerLog', 'INTEGER', true, 15, null);
        $this->addForeignKey('TRIGGER_ID', 'TriggerId', 'INTEGER', 'trigger', 'ID_TRIGGER', true, 10, null);
        $this->addColumn('TRIGGER_LOG_EXECUTED_ON', 'TriggerLogExecutedOn', 'VARCHAR', true, 30, null);
        $this->addColumn('TRIGGER_LOG_RESULT', 'TriggerLogResult', 'VARCHAR', true, 30, null);
        $this->addColumn('EXECUTED_AT', 'ExecutedAt', 'TIMESTAMP', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Trigger', '\\App\\Model\\Trigger', RelationMap::MANY_TO_ONE, array('trigger_id' => 'id_trigger', ), 'CASCADE', null);
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTriggerLog', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTriggerLog', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTriggerLog', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TriggerLogTableMap::CLASS_DEFAULT : TriggerLogTableMap::OM_CLASS;
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
     * @return array           (TriggerLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TriggerLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TriggerLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TriggerLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TriggerLogTableMap::OM_CLASS;
            /** @var TriggerLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TriggerLogTableMap::addInstanceToPool($obj, $key);
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
            $key = TriggerLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TriggerLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TriggerLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TriggerLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TriggerLogTableMap::COL_ID_TRIGGER_LOG);
            $criteria->addSelectColumn(TriggerLogTableMap::COL_TRIGGER_ID);
            $criteria->addSelectColumn(TriggerLogTableMap::COL_TRIGGER_LOG_EXECUTED_ON);
            $criteria->addSelectColumn(TriggerLogTableMap::COL_TRIGGER_LOG_RESULT);
            $criteria->addSelectColumn(TriggerLogTableMap::COL_EXECUTED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TRIGGER_LOG');
            $criteria->addSelectColumn($alias . '.TRIGGER_ID');
            $criteria->addSelectColumn($alias . '.TRIGGER_LOG_EXECUTED_ON');
            $criteria->addSelectColumn($alias . '.TRIGGER_LOG_RESULT');
            $criteria->addSelectColumn($alias . '.EXECUTED_AT');
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
        return Propel::getServiceContainer()->getDatabaseMap(TriggerLogTableMap::DATABASE_NAME)->getTable(TriggerLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TriggerLogTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TriggerLogTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TriggerLogTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TriggerLog or Criteria object OR a primary key value.
     *
     * @param  mixed               $values Criteria or TriggerLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\TriggerLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TriggerLogTableMap::DATABASE_NAME);
            $criteria->add(TriggerLogTableMap::COL_ID_TRIGGER_LOG, (array) $values, Criteria::IN);
        }

        $query = TriggerLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TriggerLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TriggerLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the trigger_log table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TriggerLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TriggerLog or Criteria object.
     *
     * @param  mixed               $criteria Criteria or TriggerLog object containing data that is used to create the INSERT statement.
     * @param  ConnectionInterface $con      the ConnectionInterface connection to use
     * @return mixed               The new primary key.
     * @throws PropelException     Any exceptions caught during processing will be
     *                                      rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TriggerLog object
        }

        if ($criteria->containsKey(TriggerLogTableMap::COL_ID_TRIGGER_LOG) && $criteria->keyContainsValue(TriggerLogTableMap::COL_ID_TRIGGER_LOG) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TriggerLogTableMap::COL_ID_TRIGGER_LOG.')');
        }

        // Set the correct dbName
        $query = TriggerLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TriggerLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TriggerLogTableMap::buildTableMap();
