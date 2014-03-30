<?php

namespace Map;

use \TargetType;
use \TargetTypeQuery;
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
 * This class defines the structure of the '""target_type' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TargetTypeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TargetTypeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""target_type';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\TargetType';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TargetType';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID_TARGET_TYPE field
     */
    const COL_ID_TARGET_TYPE = '""target_type.ID_TARGET_TYPE';

    /**
     * the column name for the TARGET_TYPE_CLASS field
     */
    const COL_TARGET_TYPE_CLASS = '""target_type.TARGET_TYPE_CLASS';

    /**
     * the column name for the TARGET_TYPE_NAME field
     */
    const COL_TARGET_TYPE_NAME = '""target_type.TARGET_TYPE_NAME';

    /**
     * the column name for the TARGET_TYPE_DESCRIPTION field
     */
    const COL_TARGET_TYPE_DESCRIPTION = '""target_type.TARGET_TYPE_DESCRIPTION';

    /**
     * the column name for the TARGET_TYPE_ACTIVE field
     */
    const COL_TARGET_TYPE_ACTIVE = '""target_type.TARGET_TYPE_ACTIVE';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""target_type.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""target_type.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTargetType', 'TargetTypeClass', 'TargetTypeName', 'TargetTypeDescription', 'TargetTypeActive', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTargetType', 'targetTypeClass', 'targetTypeName', 'targetTypeDescription', 'targetTypeActive', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TargetTypeTableMap::COL_ID_TARGET_TYPE, TargetTypeTableMap::COL_TARGET_TYPE_CLASS, TargetTypeTableMap::COL_TARGET_TYPE_NAME, TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION, TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE, TargetTypeTableMap::COL_CREATED_AT, TargetTypeTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET_TYPE', 'COL_TARGET_TYPE_CLASS', 'COL_TARGET_TYPE_NAME', 'COL_TARGET_TYPE_DESCRIPTION', 'COL_TARGET_TYPE_ACTIVE', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_target_type', 'target_type_class', 'target_type_name', 'target_type_description', 'target_type_active', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTargetType' => 0, 'TargetTypeClass' => 1, 'TargetTypeName' => 2, 'TargetTypeDescription' => 3, 'TargetTypeActive' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('idTargetType' => 0, 'targetTypeClass' => 1, 'targetTypeName' => 2, 'targetTypeDescription' => 3, 'targetTypeActive' => 4, 'createdAt' => 5, 'updatedAt' => 6, ),
        self::TYPE_COLNAME       => array(TargetTypeTableMap::COL_ID_TARGET_TYPE => 0, TargetTypeTableMap::COL_TARGET_TYPE_CLASS => 1, TargetTypeTableMap::COL_TARGET_TYPE_NAME => 2, TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION => 3, TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE => 4, TargetTypeTableMap::COL_CREATED_AT => 5, TargetTypeTableMap::COL_UPDATED_AT => 6, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET_TYPE' => 0, 'COL_TARGET_TYPE_CLASS' => 1, 'COL_TARGET_TYPE_NAME' => 2, 'COL_TARGET_TYPE_DESCRIPTION' => 3, 'COL_TARGET_TYPE_ACTIVE' => 4, 'COL_CREATED_AT' => 5, 'COL_UPDATED_AT' => 6, ),
        self::TYPE_FIELDNAME     => array('id_target_type' => 0, 'target_type_class' => 1, 'target_type_name' => 2, 'target_type_description' => 3, 'target_type_active' => 4, 'created_at' => 5, 'updated_at' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('""target_type');
        $this->setPhpName('TargetType');
        $this->setClassName('\\TargetType');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TARGET_TYPE', 'IdTargetType', 'INTEGER', true, 10, null);
        $this->addColumn('TARGET_TYPE_CLASS', 'TargetTypeClass', 'VARCHAR', true, 255, null);
        $this->addColumn('TARGET_TYPE_NAME', 'TargetTypeName', 'VARCHAR', true, 255, null);
        $this->getColumn('TARGET_TYPE_NAME', false)->setPrimaryString(true);
        $this->addColumn('TARGET_TYPE_DESCRIPTION', 'TargetTypeDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('TARGET_TYPE_ACTIVE', 'TargetTypeActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('StackTestResultPass', '\\StackTestResultPass', RelationMap::ONE_TO_MANY, array('id_target_type' => 'target_type_id', ), null, null, 'StackTestResultPasses');
        $this->addRelation('Target', '\\Target', RelationMap::ONE_TO_MANY, array('id_target_type' => 'target_type_id', ), null, null, 'Targets');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTargetType', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTargetType', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTargetType', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TargetTypeTableMap::CLASS_DEFAULT : TargetTypeTableMap::OM_CLASS;
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
     * @return array (TargetType object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TargetTypeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TargetTypeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TargetTypeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TargetTypeTableMap::OM_CLASS;
            /** @var TargetType $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TargetTypeTableMap::addInstanceToPool($obj, $key);
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
            $key = TargetTypeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TargetTypeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TargetType $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TargetTypeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TargetTypeTableMap::COL_ID_TARGET_TYPE);
            $criteria->addSelectColumn(TargetTypeTableMap::COL_TARGET_TYPE_CLASS);
            $criteria->addSelectColumn(TargetTypeTableMap::COL_TARGET_TYPE_NAME);
            $criteria->addSelectColumn(TargetTypeTableMap::COL_TARGET_TYPE_DESCRIPTION);
            $criteria->addSelectColumn(TargetTypeTableMap::COL_TARGET_TYPE_ACTIVE);
            $criteria->addSelectColumn(TargetTypeTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TargetTypeTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TARGET_TYPE');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_CLASS');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_NAME');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.TARGET_TYPE_ACTIVE');
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
        return Propel::getServiceContainer()->getDatabaseMap(TargetTypeTableMap::DATABASE_NAME)->getTable(TargetTypeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TargetTypeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TargetTypeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TargetTypeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TargetType or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TargetType object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTypeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \TargetType) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TargetTypeTableMap::DATABASE_NAME);
            $criteria->add(TargetTypeTableMap::COL_ID_TARGET_TYPE, (array) $values, Criteria::IN);
        }

        $query = TargetTypeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TargetTypeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TargetTypeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""target_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TargetTypeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TargetType or Criteria object.
     *
     * @param mixed               $criteria Criteria or TargetType object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTypeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TargetType object
        }

        if ($criteria->containsKey(TargetTypeTableMap::COL_ID_TARGET_TYPE) && $criteria->keyContainsValue(TargetTypeTableMap::COL_ID_TARGET_TYPE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TargetTypeTableMap::COL_ID_TARGET_TYPE.')');
        }


        // Set the correct dbName
        $query = TargetTypeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TargetTypeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TargetTypeTableMap::buildTableMap();
