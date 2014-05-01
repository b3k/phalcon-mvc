<?php

namespace Map;

use \StackTestResultFail;
use \StackTestResultFailQuery;
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
 * This class defines the structure of the '""stack_test_result_fail' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StackTestResultFailTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.StackTestResultFailTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""stack_test_result_fail';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\StackTestResultFail';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'StackTestResultFail';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the ID_TEST_RESULT_FAIL field
     */
    const COL_ID_TEST_RESULT_FAIL = '""stack_test_result_fail.ID_TEST_RESULT_FAIL';

    /**
     * the column name for the TARGET_ID field
     */
    const COL_TARGET_ID = '""stack_test_result_fail.TARGET_ID';

    /**
     * the column name for the TARGET_GROUP_ID field
     */
    const COL_TARGET_GROUP_ID = '""stack_test_result_fail.TARGET_GROUP_ID';

    /**
     * the column name for the TARGET_TYPE_ID field
     */
    const COL_TARGET_TYPE_ID = '""stack_test_result_fail.TARGET_TYPE_ID';

    /**
     * the column name for the STACK_TEST_RESULT_FAIL_INFO field
     */
    const COL_STACK_TEST_RESULT_FAIL_INFO = '""stack_test_result_fail.STACK_TEST_RESULT_FAIL_INFO';

    /**
     * the column name for the STACK_TEST_RESULT_FAIL_PRIORITY field
     */
    const COL_STACK_TEST_RESULT_FAIL_PRIORITY = '""stack_test_result_fail.STACK_TEST_RESULT_FAIL_PRIORITY';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""stack_test_result_fail.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""stack_test_result_fail.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTestResultFail', 'TargetId', 'TargetGroupId', 'TargetTypeId', 'StackTestResultFailInfo', 'StackTestResultFailPriority', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTestResultFail', 'targetId', 'targetGroupId', 'targetTypeId', 'stackTestResultFailInfo', 'stackTestResultFailPriority', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, StackTestResultFailTableMap::COL_TARGET_ID, StackTestResultFailTableMap::COL_TARGET_GROUP_ID, StackTestResultFailTableMap::COL_TARGET_TYPE_ID, StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO, StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY, StackTestResultFailTableMap::COL_CREATED_AT, StackTestResultFailTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TEST_RESULT_FAIL', 'COL_TARGET_ID', 'COL_TARGET_GROUP_ID', 'COL_TARGET_TYPE_ID', 'COL_STACK_TEST_RESULT_FAIL_INFO', 'COL_STACK_TEST_RESULT_FAIL_PRIORITY', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_test_result_fail', 'target_id', 'target_group_id', 'target_type_id', 'stack_test_result_fail_info', 'stack_test_result_fail_priority', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTestResultFail' => 0, 'TargetId' => 1, 'TargetGroupId' => 2, 'TargetTypeId' => 3, 'StackTestResultFailInfo' => 4, 'StackTestResultFailPriority' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('idTestResultFail' => 0, 'targetId' => 1, 'targetGroupId' => 2, 'targetTypeId' => 3, 'stackTestResultFailInfo' => 4, 'stackTestResultFailPriority' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL => 0, StackTestResultFailTableMap::COL_TARGET_ID => 1, StackTestResultFailTableMap::COL_TARGET_GROUP_ID => 2, StackTestResultFailTableMap::COL_TARGET_TYPE_ID => 3, StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO => 4, StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY => 5, StackTestResultFailTableMap::COL_CREATED_AT => 6, StackTestResultFailTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TEST_RESULT_FAIL' => 0, 'COL_TARGET_ID' => 1, 'COL_TARGET_GROUP_ID' => 2, 'COL_TARGET_TYPE_ID' => 3, 'COL_STACK_TEST_RESULT_FAIL_INFO' => 4, 'COL_STACK_TEST_RESULT_FAIL_PRIORITY' => 5, 'COL_CREATED_AT' => 6, 'COL_UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id_test_result_fail' => 0, 'target_id' => 1, 'target_group_id' => 2, 'target_type_id' => 3, 'stack_test_result_fail_info' => 4, 'stack_test_result_fail_priority' => 5, 'created_at' => 6, 'updated_at' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('""stack_test_result_fail');
        $this->setPhpName('StackTestResultFail');
        $this->setClassName('\\StackTestResultFail');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TEST_RESULT_FAIL', 'IdTestResultFail', 'INTEGER', true, 10, null);
        $this->addForeignKey('TARGET_ID', 'TargetId', 'INTEGER', '""target', 'ID_TARGET', true, 10, null);
        $this->addForeignKey('TARGET_GROUP_ID', 'TargetGroupId', 'INTEGER', '""target', 'TARGET_GROUP_ID', true, 10, null);
        $this->addForeignKey('TARGET_TYPE_ID', 'TargetTypeId', 'INTEGER', '""target', 'TARGET_TYPE_ID', true, 10, null);
        $this->addColumn('STACK_TEST_RESULT_FAIL_INFO', 'StackTestResultFailInfo', 'LONGVARCHAR', true, null, null);
        $this->addColumn('STACK_TEST_RESULT_FAIL_PRIORITY', 'StackTestResultFailPriority', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TargetRelatedByTargetId', '\\Target', RelationMap::MANY_TO_ONE, array('target_id' => 'id_target', ), null, null);
        $this->addRelation('TargetRelatedByTargetGroupId', '\\Target', RelationMap::MANY_TO_ONE, array('target_group_id' => 'target_group_id', ), null, null);
        $this->addRelation('TargetRelatedByTargetTypeId', '\\Target', RelationMap::MANY_TO_ONE, array('target_type_id' => 'target_type_id', ), null, null);
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
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTestResultFail', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTestResultFail', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTestResultFail', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? StackTestResultFailTableMap::CLASS_DEFAULT : StackTestResultFailTableMap::OM_CLASS;
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
     *         rethrown wrapped into a PropelException.
     * @return array (StackTestResultFail object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StackTestResultFailTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StackTestResultFailTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StackTestResultFailTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StackTestResultFailTableMap::OM_CLASS;
            /** @var StackTestResultFail $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StackTestResultFailTableMap::addInstanceToPool($obj, $key);
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
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = StackTestResultFailTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StackTestResultFailTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var StackTestResultFail $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StackTestResultFailTableMap::addInstanceToPool($obj, $key);
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
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_TARGET_ID);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_TARGET_GROUP_ID);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_TARGET_TYPE_ID);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(StackTestResultFailTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TEST_RESULT_FAIL');
            $criteria->addSelectColumn($alias . '.TARGET_ID');
            $criteria->addSelectColumn($alias . '.TARGET_GROUP_ID');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_ID');
            $criteria->addSelectColumn($alias . '.STACK_TEST_RESULT_FAIL_INFO');
            $criteria->addSelectColumn($alias . '.STACK_TEST_RESULT_FAIL_PRIORITY');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(StackTestResultFailTableMap::DATABASE_NAME)->getTable(StackTestResultFailTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(StackTestResultFailTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(StackTestResultFailTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new StackTestResultFailTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a StackTestResultFail or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or StackTestResultFail object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \StackTestResultFail) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StackTestResultFailTableMap::DATABASE_NAME);
            $criteria->add(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, (array) $values, Criteria::IN);
        }

        $query = StackTestResultFailQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StackTestResultFailTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StackTestResultFailTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""stack_test_result_fail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StackTestResultFailQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a StackTestResultFail or Criteria object.
     *
     * @param mixed               $criteria Criteria or StackTestResultFail object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from StackTestResultFail object
        }

        if ($criteria->containsKey(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL) && $criteria->keyContainsValue(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL.')');
        }


        // Set the correct dbName
        $query = StackTestResultFailQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // StackTestResultFailTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StackTestResultFailTableMap::buildTableMap();
