<?php

namespace Map;

use \ChannelOut;
use \ChannelOutQuery;
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
 * This class defines the structure of the '""channel_out' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ChannelOutTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'upcheck.Map.ChannelOutTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""channel_out';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ChannelOut';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'upcheck.ChannelOut';

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
     * the column name for the ID_ALERT_OUT field
     */
    const COL_ID_ALERT_OUT = '""channel_out.ID_ALERT_OUT';

    /**
     * the column name for the CHANNEL_ID field
     */
    const COL_CHANNEL_ID = '""channel_out.CHANNEL_ID';

    /**
     * the column name for the TARGET_ID field
     */
    const COL_TARGET_ID = '""channel_out.TARGET_ID';

    /**
     * the column name for the CHANNEL_OUT_PARAMS field
     */
    const COL_CHANNEL_OUT_PARAMS = '""channel_out.CHANNEL_OUT_PARAMS';

    /**
     * the column name for the CHANNEL_OUT_STATUS field
     */
    const COL_CHANNEL_OUT_STATUS = '""channel_out.CHANNEL_OUT_STATUS';

    /**
     * the column name for the CHANNEL_OUT_PRIORITY field
     */
    const COL_CHANNEL_OUT_PRIORITY = '""channel_out.CHANNEL_OUT_PRIORITY';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""channel_out.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""channel_out.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdAlertOut', 'ChannelId', 'TargetId', 'ChannelOutParams', 'ChannelOutStatus', 'ChannelOutPriority', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idAlertOut', 'channelId', 'targetId', 'channelOutParams', 'channelOutStatus', 'channelOutPriority', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ChannelOutTableMap::COL_ID_ALERT_OUT, ChannelOutTableMap::COL_CHANNEL_ID, ChannelOutTableMap::COL_TARGET_ID, ChannelOutTableMap::COL_CHANNEL_OUT_PARAMS, ChannelOutTableMap::COL_CHANNEL_OUT_STATUS, ChannelOutTableMap::COL_CHANNEL_OUT_PRIORITY, ChannelOutTableMap::COL_CREATED_AT, ChannelOutTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_ALERT_OUT', 'COL_CHANNEL_ID', 'COL_TARGET_ID', 'COL_CHANNEL_OUT_PARAMS', 'COL_CHANNEL_OUT_STATUS', 'COL_CHANNEL_OUT_PRIORITY', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_alert_out', 'channel_id', 'target_id', 'channel_out_params', 'channel_out_status', 'channel_out_priority', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdAlertOut' => 0, 'ChannelId' => 1, 'TargetId' => 2, 'ChannelOutParams' => 3, 'ChannelOutStatus' => 4, 'ChannelOutPriority' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('idAlertOut' => 0, 'channelId' => 1, 'targetId' => 2, 'channelOutParams' => 3, 'channelOutStatus' => 4, 'channelOutPriority' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(ChannelOutTableMap::COL_ID_ALERT_OUT => 0, ChannelOutTableMap::COL_CHANNEL_ID => 1, ChannelOutTableMap::COL_TARGET_ID => 2, ChannelOutTableMap::COL_CHANNEL_OUT_PARAMS => 3, ChannelOutTableMap::COL_CHANNEL_OUT_STATUS => 4, ChannelOutTableMap::COL_CHANNEL_OUT_PRIORITY => 5, ChannelOutTableMap::COL_CREATED_AT => 6, ChannelOutTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_ALERT_OUT' => 0, 'COL_CHANNEL_ID' => 1, 'COL_TARGET_ID' => 2, 'COL_CHANNEL_OUT_PARAMS' => 3, 'COL_CHANNEL_OUT_STATUS' => 4, 'COL_CHANNEL_OUT_PRIORITY' => 5, 'COL_CREATED_AT' => 6, 'COL_UPDATED_AT' => 7, ),
        self::TYPE_FIELDNAME     => array('id_alert_out' => 0, 'channel_id' => 1, 'target_id' => 2, 'channel_out_params' => 3, 'channel_out_status' => 4, 'channel_out_priority' => 5, 'created_at' => 6, 'updated_at' => 7, ),
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
        $this->setName('""channel_out');
        $this->setPhpName('ChannelOut');
        $this->setClassName('\\ChannelOut');
        $this->setPackage('upcheck');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_ALERT_OUT', 'IdAlertOut', 'INTEGER', true, 10, null);
        $this->addForeignKey('CHANNEL_ID', 'ChannelId', 'INTEGER', '""channel', 'ID_CHANNEL', true, 10, null);
        $this->addForeignKey('TARGET_ID', 'TargetId', 'INTEGER', '""target', 'ID_TARGET', true, 10, null);
        $this->addColumn('CHANNEL_OUT_PARAMS', 'ChannelOutParams', 'LONGVARCHAR', true, null, null);
        $this->addColumn('CHANNEL_OUT_STATUS', 'ChannelOutStatus', 'BOOLEAN', true, 1, false);
        $this->addColumn('CHANNEL_OUT_PRIORITY', 'ChannelOutPriority', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Channel', '\\Channel', RelationMap::MANY_TO_ONE, array('channel_id' => 'id_channel', ), 'CASCADE', null);
        $this->addRelation('Target', '\\Target', RelationMap::MANY_TO_ONE, array('target_id' => 'id_target', ), 'CASCADE', null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlertOut', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAlertOut', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdAlertOut', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ChannelOutTableMap::CLASS_DEFAULT : ChannelOutTableMap::OM_CLASS;
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
     * @return array (ChannelOut object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ChannelOutTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ChannelOutTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ChannelOutTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ChannelOutTableMap::OM_CLASS;
            /** @var ChannelOut $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ChannelOutTableMap::addInstanceToPool($obj, $key);
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
            $key = ChannelOutTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ChannelOutTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ChannelOut $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ChannelOutTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ChannelOutTableMap::COL_ID_ALERT_OUT);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_CHANNEL_ID);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_TARGET_ID);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_CHANNEL_OUT_PARAMS);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_CHANNEL_OUT_STATUS);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_CHANNEL_OUT_PRIORITY);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ChannelOutTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_ALERT_OUT');
            $criteria->addSelectColumn($alias . '.CHANNEL_ID');
            $criteria->addSelectColumn($alias . '.TARGET_ID');
            $criteria->addSelectColumn($alias . '.CHANNEL_OUT_PARAMS');
            $criteria->addSelectColumn($alias . '.CHANNEL_OUT_STATUS');
            $criteria->addSelectColumn($alias . '.CHANNEL_OUT_PRIORITY');
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
        return Propel::getServiceContainer()->getDatabaseMap(ChannelOutTableMap::DATABASE_NAME)->getTable(ChannelOutTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ChannelOutTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ChannelOutTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ChannelOutTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ChannelOut or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChannelOut object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelOutTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ChannelOut) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ChannelOutTableMap::DATABASE_NAME);
            $criteria->add(ChannelOutTableMap::COL_ID_ALERT_OUT, (array) $values, Criteria::IN);
        }

        $query = ChannelOutQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ChannelOutTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ChannelOutTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""channel_out table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ChannelOutQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChannelOut or Criteria object.
     *
     * @param mixed               $criteria Criteria or ChannelOut object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelOutTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChannelOut object
        }

        if ($criteria->containsKey(ChannelOutTableMap::COL_ID_ALERT_OUT) && $criteria->keyContainsValue(ChannelOutTableMap::COL_ID_ALERT_OUT) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ChannelOutTableMap::COL_ID_ALERT_OUT.')');
        }


        // Set the correct dbName
        $query = ChannelOutQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ChannelOutTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ChannelOutTableMap::buildTableMap();
