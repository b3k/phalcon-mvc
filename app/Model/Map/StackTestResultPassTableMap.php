<?php

namespace App\Model\Map;

use App\Model\StackTestResultPass;
use App\Model\StackTestResultPassQuery;
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
 * This class defines the structure of the 'stack_test_result_pass' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StackTestResultPassTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.StackTestResultPassTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'stack_test_result_pass';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\StackTestResultPass';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.StackTestResultPass';

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
     * the column name for the ID_TEST_RESULT_PASS field
     */
    const COL_ID_TEST_RESULT_PASS = 'stack_test_result_pass.ID_TEST_RESULT_PASS';

    /**
     * the column name for the TARGET_ID field
     */
    const COL_TARGET_ID = 'stack_test_result_pass.TARGET_ID';

    /**
     * the column name for the TARGET_GROUP_ID field
     */
    const COL_TARGET_GROUP_ID = 'stack_test_result_pass.TARGET_GROUP_ID';

    /**
     * the column name for the TARGET_TYPE_ID field
     */
    const COL_TARGET_TYPE_ID = 'stack_test_result_pass.TARGET_TYPE_ID';

    /**
     * the column name for the STACK_TEST_RESULT_PASS_INFO field
     */
    const COL_STACK_TEST_RESULT_PASS_INFO = 'stack_test_result_pass.STACK_TEST_RESULT_PASS_INFO';

    /**
     * the column name for the STACK_TEST_RESULT_PASS_PRIORITY field
     */
    const COL_STACK_TEST_RESULT_PASS_PRIORITY = 'stack_test_result_pass.STACK_TEST_RESULT_PASS_PRIORITY';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = 'stack_test_result_pass.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = 'stack_test_result_pass.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTestResultPass', 'TargetId', 'TargetGroupId', 'TargetTypeId', 'StackTestResultPassInfo', 'StackTestResultPassPriority', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTestResultPass', 'targetId', 'targetGroupId', 'targetTypeId', 'stackTestResultPassInfo', 'stackTestResultPassPriority', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, StackTestResultPassTableMap::COL_TARGET_ID, StackTestResultPassTableMap::COL_TARGET_GROUP_ID, StackTestResultPassTableMap::COL_TARGET_TYPE_ID, StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_INFO, StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_PRIORITY, StackTestResultPassTableMap::COL_CREATED_AT, StackTestResultPassTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TEST_RESULT_PASS', 'COL_TARGET_ID', 'COL_TARGET_GROUP_ID', 'COL_TARGET_TYPE_ID', 'COL_STACK_TEST_RESULT_PASS_INFO', 'COL_STACK_TEST_RESULT_PASS_PRIORITY', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_test_result_pass', 'target_id', 'target_group_id', 'target_type_id', 'stack_test_result_pass_info', 'stack_test_result_pass_priority', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTestResultPass' => 0, 'TargetId' => 1, 'TargetGroupId' => 2, 'TargetTypeId' => 3, 'StackTestResultPassInfo' => 4, 'StackTestResultPassPriority' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('idTestResultPass' => 0, 'targetId' => 1, 'targetGroupId' => 2, 'targetTypeId' => 3, 'stackTestResultPassInfo' => 4, 'stackTestResultPassPriority' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS => 0, StackTestResultPassTableMap::COL_TARGET_ID => 1, StackTestResultPassTableMap::COL_TARGET_GROUP_ID => 2, StackTestResultPassTableMap::COL_TARGET_TYPE_ID => 3, StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_INFO => 4, StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_PRIORITY => 5, StackTestResultPassTableMap::COL_CREATED_AT => 6, StackTestResultPassTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TEST_RESULT_PASS' => 0, 'COL_TARGET_ID' => 1, 'COL_TARGET_GROUP_ID' => 2, 'COL_TARGET_TYPE_ID' => 3, 'COL_STACK_TEST_RESULT_PASS_INFO' => 4, 'COL_STACK_TEST_RESULT_PASS_PRIORITY' => 5, 'COL_CREATED_AT' => 6, 'COL_UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id_test_result_pass' => 0, 'target_id' => 1, 'target_group_id' => 2, 'target_type_id' => 3, 'stack_test_result_pass_info' => 4, 'stack_test_result_pass_priority' => 5, 'created_at' => 6, 'updated_at' => 7, ),
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
        $this->setName('stack_test_result_pass');
        $this->setPhpName('StackTestResultPass');
        $this->setClassName('\\App\\Model\\StackTestResultPass');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TEST_RESULT_PASS', 'IdTestResultPass', 'INTEGER', true, 10, null);
        $this->addForeignKey('TARGET_ID', 'TargetId', 'INTEGER', 'target', 'ID_TARGET', true, 10, null);
        $this->addForeignKey('TARGET_GROUP_ID', 'TargetGroupId', 'INTEGER', 'target_group', 'ID_TARGET_GROUP', true, 10, null);
        $this->addForeignKey('TARGET_TYPE_ID', 'TargetTypeId', 'INTEGER', 'target_type', 'ID_TARGET_TYPE', true, 10, null);
        $this->addColumn('STACK_TEST_RESULT_PASS_INFO', 'StackTestResultPassInfo', 'LONGVARCHAR', true, null, null);
        $this->addColumn('STACK_TEST_RESULT_PASS_PRIORITY', 'StackTestResultPassPriority', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Target', '\\App\\Model\\Target', RelationMap::MANY_TO_ONE, array('target_id' => 'id_target', ), null, null);
        $this->addRelation('TargetGroup', '\\App\\Model\\TargetGroup', RelationMap::MANY_TO_ONE, array('target_group_id' => 'id_target_group', ), null, null);
        $this->addRelation('TargetType', '\\App\\Model\\TargetType', RelationMap::MANY_TO_ONE, array('target_type_id' => 'id_target_type', ), null, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTestResultPass', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTestResultPass', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTestResultPass', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? StackTestResultPassTableMap::CLASS_DEFAULT : StackTestResultPassTableMap::OM_CLASS;
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
     * @return array           (StackTestResultPass object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StackTestResultPassTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StackTestResultPassTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StackTestResultPassTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StackTestResultPassTableMap::OM_CLASS;
            /** @var StackTestResultPass $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StackTestResultPassTableMap::addInstanceToPool($obj, $key);
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
            $key = StackTestResultPassTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StackTestResultPassTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var StackTestResultPass $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StackTestResultPassTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_TARGET_ID);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_TARGET_GROUP_ID);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_TARGET_TYPE_ID);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_INFO);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_PRIORITY);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(StackTestResultPassTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TEST_RESULT_PASS');
            $criteria->addSelectColumn($alias . '.TARGET_ID');
            $criteria->addSelectColumn($alias . '.TARGET_GROUP_ID');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_ID');
            $criteria->addSelectColumn($alias . '.STACK_TEST_RESULT_PASS_INFO');
            $criteria->addSelectColumn($alias . '.STACK_TEST_RESULT_PASS_PRIORITY');
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
        return Propel::getServiceContainer()->getDatabaseMap(StackTestResultPassTableMap::DATABASE_NAME)->getTable(StackTestResultPassTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(StackTestResultPassTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(StackTestResultPassTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new StackTestResultPassTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a StackTestResultPass or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or StackTestResultPass object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultPassTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\StackTestResultPass) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StackTestResultPassTableMap::DATABASE_NAME);
            $criteria->add(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, (array) $values, Criteria::IN);
        }

        $query = StackTestResultPassQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StackTestResultPassTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StackTestResultPassTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the stack_test_result_pass table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StackTestResultPassQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a StackTestResultPass or Criteria object.
     *
     * @param mixed               $criteria Criteria or StackTestResultPass object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultPassTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from StackTestResultPass object
        }

        if ($criteria->containsKey(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS) && $criteria->keyContainsValue(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS.')');
        }


        // Set the correct dbName
        $query = StackTestResultPassQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // StackTestResultPassTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StackTestResultPassTableMap::buildTableMap();
