<?php

namespace Map;

use \Target;
use \TargetQuery;
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
 * This class defines the structure of the '""target' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TargetTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TargetTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""target';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Target';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Target';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID_TARGET field
     */
    const COL_ID_TARGET = '""target.ID_TARGET';

    /**
     * the column name for the TARGET_TYPE_ID field
     */
    const COL_TARGET_TYPE_ID = '""target.TARGET_TYPE_ID';

    /**
     * the column name for the TARGET_GROUP_ID field
     */
    const COL_TARGET_GROUP_ID = '""target.TARGET_GROUP_ID';

    /**
     * the column name for the TARGET_TARGET field
     */
    const COL_TARGET_TARGET = '""target.TARGET_TARGET';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""target.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""target.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTarget', 'TargetTypeId', 'TargetGroupId', 'TargetTarget', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTarget', 'targetTypeId', 'targetGroupId', 'targetTarget', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TargetTableMap::COL_ID_TARGET, TargetTableMap::COL_TARGET_TYPE_ID, TargetTableMap::COL_TARGET_GROUP_ID, TargetTableMap::COL_TARGET_TARGET, TargetTableMap::COL_CREATED_AT, TargetTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET', 'COL_TARGET_TYPE_ID', 'COL_TARGET_GROUP_ID', 'COL_TARGET_TARGET', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_target', 'target_type_id', 'target_group_id', 'target_target', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTarget' => 0, 'TargetTypeId' => 1, 'TargetGroupId' => 2, 'TargetTarget' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('idTarget' => 0, 'targetTypeId' => 1, 'targetGroupId' => 2, 'targetTarget' => 3, 'createdAt' => 4, 'updatedAt' => 5, ),
        self::TYPE_COLNAME       => array(TargetTableMap::COL_ID_TARGET => 0, TargetTableMap::COL_TARGET_TYPE_ID => 1, TargetTableMap::COL_TARGET_GROUP_ID => 2, TargetTableMap::COL_TARGET_TARGET => 3, TargetTableMap::COL_CREATED_AT => 4, TargetTableMap::COL_UPDATED_AT => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET' => 0, 'COL_TARGET_TYPE_ID' => 1, 'COL_TARGET_GROUP_ID' => 2, 'COL_TARGET_TARGET' => 3, 'COL_CREATED_AT' => 4, 'COL_UPDATED_AT' => 5, ),
        self::TYPE_FIELDNAME     => array('id_target' => 0, 'target_type_id' => 1, 'target_group_id' => 2, 'target_target' => 3, 'created_at' => 4, 'updated_at' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('""target');
        $this->setPhpName('Target');
        $this->setClassName('\\Target');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TARGET', 'IdTarget', 'INTEGER', true, 10, null);
        $this->addForeignKey('TARGET_TYPE_ID', 'TargetTypeId', 'INTEGER', '""target_type', 'ID_TARGET_TYPE', true, 10, null);
        $this->addForeignKey('TARGET_GROUP_ID', 'TargetGroupId', 'INTEGER', '""target_group', 'ID_TARGET_GROUP', true, 10, null);
        $this->addColumn('TARGET_TARGET', 'TargetTarget', 'LONGVARCHAR', true, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TargetType', '\\TargetType', RelationMap::MANY_TO_ONE, array('target_type_id' => 'id_target_type', ), null, null);
        $this->addRelation('TargetGroup', '\\TargetGroup', RelationMap::MANY_TO_ONE, array('target_group_id' => 'id_target_group', ), null, null);
        $this->addRelation('ChannelOut', '\\ChannelOut', RelationMap::ONE_TO_MANY, array('id_target' => 'target_id', ), 'CASCADE', null, 'ChannelOuts');
        $this->addRelation('StackTestResultFailRelatedByTargetId', '\\StackTestResultFail', RelationMap::ONE_TO_MANY, array('id_target' => 'target_id', ), null, null, 'StackTestResultFailsRelatedByTargetId');
        $this->addRelation('StackTestResultFailRelatedByTargetGroupId', '\\StackTestResultFail', RelationMap::ONE_TO_MANY, array('target_group_id' => 'target_group_id', ), null, null, 'StackTestResultFailsRelatedByTargetGroupId');
        $this->addRelation('StackTestResultFailRelatedByTargetTypeId', '\\StackTestResultFail', RelationMap::ONE_TO_MANY, array('target_type_id' => 'target_type_id', ), null, null, 'StackTestResultFailsRelatedByTargetTypeId');
        $this->addRelation('StackTestResultPass', '\\StackTestResultPass', RelationMap::ONE_TO_MANY, array('id_target' => 'target_id', ), null, null, 'StackTestResultPasses');
        $this->addRelation('Trigger', '\\Trigger', RelationMap::ONE_TO_MANY, array('id_target' => 'target_id', ), null, null, 'Triggers');
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
     * Method to invalidate the instance pool of all tables related to ""target     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ChannelOutTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTarget', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTarget', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTarget', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TargetTableMap::CLASS_DEFAULT : TargetTableMap::OM_CLASS;
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
     * @return array (Target object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TargetTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TargetTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TargetTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TargetTableMap::OM_CLASS;
            /** @var Target $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TargetTableMap::addInstanceToPool($obj, $key);
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
            $key = TargetTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TargetTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Target $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TargetTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TargetTableMap::COL_ID_TARGET);
            $criteria->addSelectColumn(TargetTableMap::COL_TARGET_TYPE_ID);
            $criteria->addSelectColumn(TargetTableMap::COL_TARGET_GROUP_ID);
            $criteria->addSelectColumn(TargetTableMap::COL_TARGET_TARGET);
            $criteria->addSelectColumn(TargetTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TargetTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TARGET');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_ID');
            $criteria->addSelectColumn($alias . '.TARGET_GROUP_ID');
            $criteria->addSelectColumn($alias . '.TARGET_TARGET');
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
        return Propel::getServiceContainer()->getDatabaseMap(TargetTableMap::DATABASE_NAME)->getTable(TargetTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TargetTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TargetTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TargetTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Target or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Target object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Target) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TargetTableMap::DATABASE_NAME);
            $criteria->add(TargetTableMap::COL_ID_TARGET, (array) $values, Criteria::IN);
        }

        $query = TargetQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TargetTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TargetTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""target table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TargetQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Target or Criteria object.
     *
     * @param mixed               $criteria Criteria or Target object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Target object
        }

        if ($criteria->containsKey(TargetTableMap::COL_ID_TARGET) && $criteria->keyContainsValue(TargetTableMap::COL_ID_TARGET) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TargetTableMap::COL_ID_TARGET.')');
        }


        // Set the correct dbName
        $query = TargetQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TargetTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TargetTableMap::buildTableMap();
