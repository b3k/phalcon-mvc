<?php

namespace app\Model\Map;

use App\Model\TriggerType;
use App\Model\TriggerTypeQuery;
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
 * This class defines the structure of the 'trigger_type' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TriggerTypeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.TriggerTypeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'trigger_type';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\TriggerType';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.TriggerType';

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
     * the column name for the ID_TRIGGER_TYPE field
     */
    const COL_ID_TRIGGER_TYPE = 'trigger_type.ID_TRIGGER_TYPE';

    /**
     * the column name for the CHANNEL_ID field
     */
    const COL_CHANNEL_ID = 'trigger_type.CHANNEL_ID';

    /**
     * the column name for the TRIGGER_TYPE_CLASS field
     */
    const COL_TRIGGER_TYPE_CLASS = 'trigger_type.TRIGGER_TYPE_CLASS';

    /**
     * the column name for the TRIGGER_TYPE_NAME field
     */
    const COL_TRIGGER_TYPE_NAME = 'trigger_type.TRIGGER_TYPE_NAME';

    /**
     * the column name for the TRIGGER_TYPE_DESCRIPTION field
     */
    const COL_TRIGGER_TYPE_DESCRIPTION = 'trigger_type.TRIGGER_TYPE_DESCRIPTION';

    /**
     * the column name for the TRIGGER_TYPE_ACTIVE field
     */
    const COL_TRIGGER_TYPE_ACTIVE = 'trigger_type.TRIGGER_TYPE_ACTIVE';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = 'trigger_type.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = 'trigger_type.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTriggerType', 'ChannelId', 'TriggerTypeClass', 'TriggerTypeName', 'TriggerTypeDescription', 'TriggerTypeActive', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTriggerType', 'channelId', 'triggerTypeClass', 'triggerTypeName', 'triggerTypeDescription', 'triggerTypeActive', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, TriggerTypeTableMap::COL_CHANNEL_ID, TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS, TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME, TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION, TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE, TriggerTypeTableMap::COL_CREATED_AT, TriggerTypeTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TRIGGER_TYPE', 'COL_CHANNEL_ID', 'COL_TRIGGER_TYPE_CLASS', 'COL_TRIGGER_TYPE_NAME', 'COL_TRIGGER_TYPE_DESCRIPTION', 'COL_TRIGGER_TYPE_ACTIVE', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_trigger_type', 'channel_id', 'trigger_type_class', 'trigger_type_name', 'trigger_type_description', 'trigger_type_active', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTriggerType' => 0, 'ChannelId' => 1, 'TriggerTypeClass' => 2, 'TriggerTypeName' => 3, 'TriggerTypeDescription' => 4, 'TriggerTypeActive' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('idTriggerType' => 0, 'channelId' => 1, 'triggerTypeClass' => 2, 'triggerTypeName' => 3, 'triggerTypeDescription' => 4, 'triggerTypeActive' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE => 0, TriggerTypeTableMap::COL_CHANNEL_ID => 1, TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS => 2, TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME => 3, TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION => 4, TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE => 5, TriggerTypeTableMap::COL_CREATED_AT => 6, TriggerTypeTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TRIGGER_TYPE' => 0, 'COL_CHANNEL_ID' => 1, 'COL_TRIGGER_TYPE_CLASS' => 2, 'COL_TRIGGER_TYPE_NAME' => 3, 'COL_TRIGGER_TYPE_DESCRIPTION' => 4, 'COL_TRIGGER_TYPE_ACTIVE' => 5, 'COL_CREATED_AT' => 6, 'COL_UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id_trigger_type' => 0, 'channel_id' => 1, 'trigger_type_class' => 2, 'trigger_type_name' => 3, 'trigger_type_description' => 4, 'trigger_type_active' => 5, 'created_at' => 6, 'updated_at' => 7, ),
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
        $this->setName('trigger_type');
        $this->setPhpName('TriggerType');
        $this->setClassName('\\App\\Model\\TriggerType');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_TRIGGER_TYPE', 'IdTriggerType', 'INTEGER', true, 10, null);
        $this->addForeignKey('CHANNEL_ID', 'ChannelId', 'INTEGER', 'channel', 'ID_CHANNEL', true, 10, null);
        $this->addColumn('TRIGGER_TYPE_CLASS', 'TriggerTypeClass', 'VARCHAR', true, 255, null);
        $this->addColumn('TRIGGER_TYPE_NAME', 'TriggerTypeName', 'VARCHAR', true, 255, null);
        $this->getColumn('TRIGGER_TYPE_NAME', false)->setPrimaryString(true);
        $this->addColumn('TRIGGER_TYPE_DESCRIPTION', 'TriggerTypeDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('TRIGGER_TYPE_ACTIVE', 'TriggerTypeActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Channel', '\\App\\Model\\Channel', RelationMap::MANY_TO_ONE, array('channel_id' => 'id_channel', ), null, null);
        $this->addRelation('Trigger', '\\App\\Model\\Trigger', RelationMap::ONE_TO_MANY, array('id_trigger_type' => 'trigger_type_id', ), null, null, 'Triggers');
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
     *                          TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTriggerType', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdTriggerType', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdTriggerType', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TriggerTypeTableMap::CLASS_DEFAULT : TriggerTypeTableMap::OM_CLASS;
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
     * @return array           (TriggerType object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TriggerTypeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TriggerTypeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TriggerTypeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TriggerTypeTableMap::OM_CLASS;
            /** @var TriggerType $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TriggerTypeTableMap::addInstanceToPool($obj, $key);
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
            $key = TriggerTypeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TriggerTypeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TriggerType $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TriggerTypeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_CHANNEL_ID);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TriggerTypeTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TRIGGER_TYPE');
            $criteria->addSelectColumn($alias . '.CHANNEL_ID');
            $criteria->addSelectColumn($alias . '.TRIGGER_TYPE_CLASS');
            $criteria->addSelectColumn($alias . '.TRIGGER_TYPE_NAME');
            $criteria->addSelectColumn($alias . '.TRIGGER_TYPE_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.TRIGGER_TYPE_ACTIVE');
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
        return Propel::getServiceContainer()->getDatabaseMap(TriggerTypeTableMap::DATABASE_NAME)->getTable(TriggerTypeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TriggerTypeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TriggerTypeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TriggerTypeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TriggerType or Criteria object OR a primary key value.
     *
     * @param  mixed               $values Criteria or TriggerType object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\TriggerType) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TriggerTypeTableMap::DATABASE_NAME);
            $criteria->add(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, (array) $values, Criteria::IN);
        }

        $query = TriggerTypeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TriggerTypeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TriggerTypeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the trigger_type table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TriggerTypeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TriggerType or Criteria object.
     *
     * @param  mixed               $criteria Criteria or TriggerType object containing data that is used to create the INSERT statement.
     * @param  ConnectionInterface $con      the ConnectionInterface connection to use
     * @return mixed               The new primary key.
     * @throws PropelException     Any exceptions caught during processing will be
     *                                      rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TriggerType object
        }

        if ($criteria->containsKey(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE) && $criteria->keyContainsValue(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TriggerTypeTableMap::COL_ID_TRIGGER_TYPE.')');
        }

        // Set the correct dbName
        $query = TriggerTypeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TriggerTypeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TriggerTypeTableMap::buildTableMap();
