<?php

namespace Map;

use \UserTargetGroup;
use \UserTargetGroupQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the '""user_target_group' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTargetGroupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.UserTargetGroupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '""user_target_group';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\UserTargetGroup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'UserTargetGroup';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ID_TARGET_GROUP field
     */
    const COL_ID_TARGET_GROUP = '""user_target_group.ID_TARGET_GROUP';

    /**
     * the column name for the ID_USER field
     */
    const COL_ID_USER = '""user_target_group.ID_USER';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = '""user_target_group.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = '""user_target_group.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdTargetGroup', 'IdUser', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idTargetGroup', 'idUser', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(UserTargetGroupTableMap::COL_ID_TARGET_GROUP, UserTargetGroupTableMap::COL_ID_USER, UserTargetGroupTableMap::COL_CREATED_AT, UserTargetGroupTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET_GROUP', 'COL_ID_USER', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_target_group', 'id_user', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdTargetGroup' => 0, 'IdUser' => 1, 'CreatedAt' => 2, 'UpdatedAt' => 3, ),
        self::TYPE_STUDLYPHPNAME => array('idTargetGroup' => 0, 'idUser' => 1, 'createdAt' => 2, 'updatedAt' => 3, ),
        self::TYPE_COLNAME       => array(UserTargetGroupTableMap::COL_ID_TARGET_GROUP => 0, UserTargetGroupTableMap::COL_ID_USER => 1, UserTargetGroupTableMap::COL_CREATED_AT => 2, UserTargetGroupTableMap::COL_UPDATED_AT => 3, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_TARGET_GROUP' => 0, 'COL_ID_USER' => 1, 'COL_CREATED_AT' => 2, 'COL_UPDATED_AT' => 3, ),
        self::TYPE_FIELDNAME     => array('id_target_group' => 0, 'id_user' => 1, 'created_at' => 2, 'updated_at' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('""user_target_group');
        $this->setPhpName('UserTargetGroup');
        $this->setClassName('\\UserTargetGroup');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignKey('ID_TARGET_GROUP', 'IdTargetGroup', 'INTEGER', '""target_group', 'ID_TARGET_GROUP', true, 10, null);
        $this->addForeignKey('ID_USER', 'IdUser', 'INTEGER', '""user', 'ID_USER', true, 10, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TargetGroup', '\\TargetGroup', RelationMap::MANY_TO_ONE, array('id_target_group' => 'id_target_group', ), 'CASCADE', null);
        $this->addRelation('User', '\\User', RelationMap::MANY_TO_ONE, array('id_user' => 'id_user', ), 'CASCADE', null);
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
        return null;
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
        return '';
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
        return $withPrefix ? UserTargetGroupTableMap::CLASS_DEFAULT : UserTargetGroupTableMap::OM_CLASS;
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
     * @return array (UserTargetGroup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTargetGroupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTargetGroupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTargetGroupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTargetGroupTableMap::OM_CLASS;
            /** @var UserTargetGroup $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTargetGroupTableMap::addInstanceToPool($obj, $key);
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
            $key = UserTargetGroupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTargetGroupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UserTargetGroup $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTargetGroupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UserTargetGroupTableMap::COL_ID_TARGET_GROUP);
            $criteria->addSelectColumn(UserTargetGroupTableMap::COL_ID_USER);
            $criteria->addSelectColumn(UserTargetGroupTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UserTargetGroupTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_TARGET_GROUP');
            $criteria->addSelectColumn($alias . '.ID_USER');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserTargetGroupTableMap::DATABASE_NAME)->getTable(UserTargetGroupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTargetGroupTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTargetGroupTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTargetGroupTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UserTargetGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UserTargetGroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTargetGroupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \UserTargetGroup) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The UserTargetGroup object has no primary key');
        }

        $query = UserTargetGroupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTargetGroupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTargetGroupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ""user_target_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserTargetGroupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UserTargetGroup or Criteria object.
     *
     * @param mixed               $criteria Criteria or UserTargetGroup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTargetGroupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UserTargetGroup object
        }


        // Set the correct dbName
        $query = UserTargetGroupQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTargetGroupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTargetGroupTableMap::buildTableMap();
