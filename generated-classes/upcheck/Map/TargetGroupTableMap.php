<?php

namespace Map;

use \TargetGroup;
use \TargetGroupQuery;
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
 * This class defines the structure of the '""target_group' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TargetGroupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'upcheck.Map.TargetGroupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""target_group';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\TargetGroup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'upcheck.TargetGroup';

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
     * the column name for the ID_TARGET_GROUP field
     */
    const COL_ID_TARGET_GROUP = '""target_group.ID_TARGET_GROUP';

    /**
     * the column name for the TARGET_GROUP_NAME field
     */
    const COL_TARGET_GROUP_NAME = '""target_group.TARGET_GROUP_NAME';

    /**
     * the column name for the TARGET_GROUP_ACTIVE field
     */
    const COL_TARGET_GROUP_ACTIVE = '""target_group.TARGET_GROUP_ACTIVE';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""target_group.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""target_group.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTargetGroup', 'TargetGroupName', 'TargetGroupActive', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTargetGroup', 'targetGroupName', 'targetGroupActive', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TargetGroupTableMap::COL_ID_TARGET_GROUP, TargetGroupTableMap::COL_TARGET_GROUP_NAME, TargetGroupTableMap::COL_TARGET_GROUP_ACTIVE, TargetGroupTableMap::COL_CREATED_AT, TargetGroupTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET_GROUP', 'COL_TARGET_GROUP_NAME', 'COL_TARGET_GROUP_ACTIVE', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_target_group', 'target_group_name', 'target_group_active', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTargetGroup' => 0, 'TargetGroupName' => 1, 'TargetGroupActive' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('idTargetGroup' => 0, 'targetGroupName' => 1, 'targetGroupActive' => 2, 'createdAt' => 3, 'updatedAt' => 4, ),
        self::TYPE_COLNAME       => array(TargetGroupTableMap::COL_ID_TARGET_GROUP => 0, TargetGroupTableMap::COL_TARGET_GROUP_NAME => 1, TargetGroupTableMap::COL_TARGET_GROUP_ACTIVE => 2, TargetGroupTableMap::COL_CREATED_AT => 3, TargetGroupTableMap::COL_UPDATED_AT => 4, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET_GROUP' => 0, 'COL_TARGET_GROUP_NAME' => 1, 'COL_TARGET_GROUP_ACTIVE' => 2, 'COL_CREATED_AT' => 3, 'COL_UPDATED_AT' => 4, ),
        self::TYPE_FIELDNAME     => array('id_target_group' => 0, 'target_group_name' => 1, 'target_group_active' => 2, 'created_at' => 3, 'updated_at' => 4, ),
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
        $this->setName('""target_group');
        $this->setPhpName('TargetGroup');
        $this->setClassName('\\TargetGroup');
        $this->setPackage('upcheck');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TARGET_GROUP', 'IdTargetGroup', 'INTEGER', true, 10, null);
        $this->addColumn('TARGET_GROUP_NAME', 'TargetGroupName', 'VARCHAR', true, 100, null);
        $this->getColumn('TARGET_GROUP_NAME', false)->setPrimaryString(true);
        $this->addColumn('TARGET_GROUP_ACTIVE', 'TargetGroupActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('StackTestResultPass', '\\StackTestResultPass', RelationMap::ONE_TO_MANY, array('id_target_group' => 'target_group_id', ), null, null, 'StackTestResultPasses');
        $this->addRelation('Target', '\\Target', RelationMap::ONE_TO_MANY, array('id_target_group' => 'target_group_id', ), null, null, 'Targets');
        $this->addRelation('UserTargetGroup', '\\UserTargetGroup', RelationMap::ONE_TO_MANY, array('id_target_group' => 'id_target_group', ), 'CASCADE', null, 'UserTargetGroups');
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
     * Method to invalidate the instance pool of all tables related to ""target_group     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        UserTargetGroupTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTargetGroup', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTargetGroup', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTargetGroup', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TargetGroupTableMap::CLASS_DEFAULT : TargetGroupTableMap::OM_CLASS;
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
     * @return array (TargetGroup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TargetGroupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TargetGroupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TargetGroupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TargetGroupTableMap::OM_CLASS;
            /** @var TargetGroup $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TargetGroupTableMap::addInstanceToPool($obj, $key);
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
            $key = TargetGroupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TargetGroupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TargetGroup $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TargetGroupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TargetGroupTableMap::COL_ID_TARGET_GROUP);
            $criteria->addSelectColumn(TargetGroupTableMap::COL_TARGET_GROUP_NAME);
            $criteria->addSelectColumn(TargetGroupTableMap::COL_TARGET_GROUP_ACTIVE);
            $criteria->addSelectColumn(TargetGroupTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TargetGroupTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TARGET_GROUP');
            $criteria->addSelectColumn($alias . '.TARGET_GROUP_NAME');
            $criteria->addSelectColumn($alias . '.TARGET_GROUP_ACTIVE');
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
        return Propel::getServiceContainer()->getDatabaseMap(TargetGroupTableMap::DATABASE_NAME)->getTable(TargetGroupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TargetGroupTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TargetGroupTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TargetGroupTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TargetGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TargetGroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TargetGroupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \TargetGroup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TargetGroupTableMap::DATABASE_NAME);
            $criteria->add(TargetGroupTableMap::COL_ID_TARGET_GROUP, (array) $values, Criteria::IN);
        }

        $query = TargetGroupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TargetGroupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TargetGroupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""target_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TargetGroupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TargetGroup or Criteria object.
     *
     * @param mixed               $criteria Criteria or TargetGroup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetGroupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TargetGroup object
        }

        if ($criteria->containsKey(TargetGroupTableMap::COL_ID_TARGET_GROUP) && $criteria->keyContainsValue(TargetGroupTableMap::COL_ID_TARGET_GROUP) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TargetGroupTableMap::COL_ID_TARGET_GROUP.')');
        }


        // Set the correct dbName
        $query = TargetGroupQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TargetGroupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TargetGroupTableMap::buildTableMap();
