<?php

namespace Map;

use \Channel;
use \ChannelQuery;
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
 * This class defines the structure of the '""channel' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ChannelTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ChannelTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""channel';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Channel';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Channel';

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
     * the column name for the ID_CHANNEL field
     */
    const COL_ID_CHANNEL = '""channel.ID_CHANNEL';

    /**
     * the column name for the CHANNEL_CLASS field
     */
    const COL_CHANNEL_CLASS = '""channel.CHANNEL_CLASS';

    /**
     * the column name for the CHANNEL_NAME field
     */
    const COL_CHANNEL_NAME = '""channel.CHANNEL_NAME';

    /**
     * the column name for the CHANNEL_DESCRIPTION field
     */
    const COL_CHANNEL_DESCRIPTION = '""channel.CHANNEL_DESCRIPTION';

    /**
     * the column name for the CHANNEL_ACTIVE field
     */
    const COL_CHANNEL_ACTIVE = '""channel.CHANNEL_ACTIVE';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""channel.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""channel.UPDATED_AT';

    /**
     * the column name for the SLUG field
     */
    const COL_SLUG = '""channel.SLUG';

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
        self::TYPE_PHPNAME       => array('IdChannel', 'ChannelClass', 'ChannelName', 'ChannelDescription', 'ChannelActive', 'CreatedAt', 'UpdatedAt', 'Slug', ),
        self::TYPE_STUDLYPHPNAME => array('idChannel', 'channelClass', 'channelName', 'channelDescription', 'channelActive', 'createdAt', 'updatedAt', 'slug', ),
        self::TYPE_COLNAME       => array(ChannelTableMap::COL_ID_CHANNEL, ChannelTableMap::COL_CHANNEL_CLASS, ChannelTableMap::COL_CHANNEL_NAME, ChannelTableMap::COL_CHANNEL_DESCRIPTION, ChannelTableMap::COL_CHANNEL_ACTIVE, ChannelTableMap::COL_CREATED_AT, ChannelTableMap::COL_UPDATED_AT, ChannelTableMap::COL_SLUG, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_CHANNEL', 'COL_CHANNEL_CLASS', 'COL_CHANNEL_NAME', 'COL_CHANNEL_DESCRIPTION', 'COL_CHANNEL_ACTIVE', 'COL_CREATED_AT', 'COL_UPDATED_AT', 'COL_SLUG', ),
        self::TYPE_FIELDNAME     => array('id_channel', 'channel_class', 'channel_name', 'channel_description', 'channel_active', 'created_at', 'updated_at', 'slug', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdChannel' => 0, 'ChannelClass' => 1, 'ChannelName' => 2, 'ChannelDescription' => 3, 'ChannelActive' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, 'Slug' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('idChannel' => 0, 'channelClass' => 1, 'channelName' => 2, 'channelDescription' => 3, 'channelActive' => 4, 'createdAt' => 5, 'updatedAt' => 6, 'slug' => 7, ),
        self::TYPE_COLNAME       => array(ChannelTableMap::COL_ID_CHANNEL => 0, ChannelTableMap::COL_CHANNEL_CLASS => 1, ChannelTableMap::COL_CHANNEL_NAME => 2, ChannelTableMap::COL_CHANNEL_DESCRIPTION => 3, ChannelTableMap::COL_CHANNEL_ACTIVE => 4, ChannelTableMap::COL_CREATED_AT => 5, ChannelTableMap::COL_UPDATED_AT => 6, ChannelTableMap::COL_SLUG => 7, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_CHANNEL' => 0, 'COL_CHANNEL_CLASS' => 1, 'COL_CHANNEL_NAME' => 2, 'COL_CHANNEL_DESCRIPTION' => 3, 'COL_CHANNEL_ACTIVE' => 4, 'COL_CREATED_AT' => 5, 'COL_UPDATED_AT' => 6, 'COL_SLUG' => 7, ),
        self::TYPE_FIELDNAME     => array('id_channel' => 0, 'channel_class' => 1, 'channel_name' => 2, 'channel_description' => 3, 'channel_active' => 4, 'created_at' => 5, 'updated_at' => 6, 'slug' => 7, ),
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
        $this->setName('""channel');
        $this->setPhpName('Channel');
        $this->setClassName('\\Channel');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_CHANNEL', 'IdChannel', 'INTEGER', true, 10, null);
        $this->addColumn('CHANNEL_CLASS', 'ChannelClass', 'VARCHAR', true, 50, null);
        $this->addColumn('CHANNEL_NAME', 'ChannelName', 'VARCHAR', true, 100, null);
        $this->getColumn('CHANNEL_NAME', false)->setPrimaryString(true);
        $this->addColumn('CHANNEL_DESCRIPTION', 'ChannelDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('CHANNEL_ACTIVE', 'ChannelActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('SLUG', 'Slug', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ChannelOut', '\\ChannelOut', RelationMap::ONE_TO_MANY, array('id_channel' => 'channel_id', ), 'CASCADE', null, 'ChannelOuts');
        $this->addRelation('SubscriptionPlanChannel', '\\SubscriptionPlanChannel', RelationMap::ONE_TO_MANY, array('id_channel' => 'id_channel', ), 'CASCADE', null, 'SubscriptionPlanChannels');
        $this->addRelation('TriggerType', '\\TriggerType', RelationMap::ONE_TO_MANY, array('id_channel' => 'channel_id', ), null, null, 'TriggerTypes');
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
            'sluggable' => array('slug_column' => 'slug', 'slug_pattern' => '', 'replace_pattern' => '/\W+/', 'replacement' => '-', 'separator' => '-', 'permanent' => 'false', 'scope_column' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to ""channel     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ChannelOutTableMap::clearInstancePool();
        SubscriptionPlanChannelTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdChannel', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdChannel', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdChannel', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ChannelTableMap::CLASS_DEFAULT : ChannelTableMap::OM_CLASS;
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
     * @return array (Channel object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ChannelTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ChannelTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ChannelTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ChannelTableMap::OM_CLASS;
            /** @var Channel $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ChannelTableMap::addInstanceToPool($obj, $key);
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
            $key = ChannelTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ChannelTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Channel $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ChannelTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ChannelTableMap::COL_ID_CHANNEL);
            $criteria->addSelectColumn(ChannelTableMap::COL_CHANNEL_CLASS);
            $criteria->addSelectColumn(ChannelTableMap::COL_CHANNEL_NAME);
            $criteria->addSelectColumn(ChannelTableMap::COL_CHANNEL_DESCRIPTION);
            $criteria->addSelectColumn(ChannelTableMap::COL_CHANNEL_ACTIVE);
            $criteria->addSelectColumn(ChannelTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ChannelTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(ChannelTableMap::COL_SLUG);
        } else {
            $criteria->addSelectColumn($alias . '.ID_CHANNEL');
            $criteria->addSelectColumn($alias . '.CHANNEL_CLASS');
            $criteria->addSelectColumn($alias . '.CHANNEL_NAME');
            $criteria->addSelectColumn($alias . '.CHANNEL_DESCRIPTION');
            $criteria->addSelectColumn($alias . '.CHANNEL_ACTIVE');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.SLUG');
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
        return Propel::getServiceContainer()->getDatabaseMap(ChannelTableMap::DATABASE_NAME)->getTable(ChannelTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ChannelTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ChannelTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ChannelTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Channel or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Channel object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Channel) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ChannelTableMap::DATABASE_NAME);
            $criteria->add(ChannelTableMap::COL_ID_CHANNEL, (array) $values, Criteria::IN);
        }

        $query = ChannelQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ChannelTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ChannelTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""channel table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ChannelQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Channel or Criteria object.
     *
     * @param mixed               $criteria Criteria or Channel object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Channel object
        }

        if ($criteria->containsKey(ChannelTableMap::COL_ID_CHANNEL) && $criteria->keyContainsValue(ChannelTableMap::COL_ID_CHANNEL) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ChannelTableMap::COL_ID_CHANNEL.')');
        }


        // Set the correct dbName
        $query = ChannelQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ChannelTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ChannelTableMap::buildTableMap();
