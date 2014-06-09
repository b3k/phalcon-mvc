<?php

namespace App\Model\Map;

use App\Model\User;
use App\Model\UserQuery;
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
 * This class defines the structure of the 'user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'App.Model.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\User';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'App.Model.User';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the ID_USER field
     */
    const COL_ID_USER = 'user.ID_USER';

    /**
     * the column name for the USER_USERNAME field
     */
    const COL_USER_USERNAME = 'user.USER_USERNAME';

    /**
     * the column name for the USER_PASSWORD field
     */
    const COL_USER_PASSWORD = 'user.USER_PASSWORD';

    /**
     * the column name for the USER_SALT field
     */
    const COL_USER_SALT = 'user.USER_SALT';

    /**
     * the column name for the USER_FIRSTNAME field
     */
    const COL_USER_FIRSTNAME = 'user.USER_FIRSTNAME';

    /**
     * the column name for the USER_LASTNAME field
     */
    const COL_USER_LASTNAME = 'user.USER_LASTNAME';

    /**
     * the column name for the USER_EMAIL field
     */
    const COL_USER_EMAIL = 'user.USER_EMAIL';

    /**
     * the column name for the USER_ACTIVE field
     */
    const COL_USER_ACTIVE = 'user.USER_ACTIVE';

    /**
     * the column name for the USER_ROLES field
     */
    const COL_USER_ROLES = 'user.USER_ROLES';

    /**
     * the column name for the USER_EXPIRE_AT field
     */
    const COL_USER_EXPIRE_AT = 'user.USER_EXPIRE_AT';

    /**
     * the column name for the USER_EXPIRED field
     */
    const COL_USER_EXPIRED = 'user.USER_EXPIRED';

    /**
     * the column name for the USER_REMEMBER_TOKEN field
     */
    const COL_USER_REMEMBER_TOKEN = 'user.USER_REMEMBER_TOKEN';

    /**
     * the column name for the USER_REMEMBER_TOKEN_VALIDITY field
     */
    const COL_USER_REMEMBER_TOKEN_VALIDITY = 'user.USER_REMEMBER_TOKEN_VALIDITY';

    /**
     * the column name for the CREATED_AT field
     */
    const COL_CREATED_AT = 'user.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const COL_UPDATED_AT = 'user.UPDATED_AT';

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
        self::TYPE_PHPNAME       => array('IdUser', 'UserUsername', 'UserPassword', 'UserSalt', 'UserFirstname', 'UserLastname', 'UserEmail', 'UserActive', 'UserRoles', 'UserExpireAt', 'UserExpired', 'UserRememberToken', 'UserRememberTokenValidity', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('idUser', 'userUsername', 'userPassword', 'userSalt', 'userFirstname', 'userLastname', 'userEmail', 'userActive', 'userRoles', 'userExpireAt', 'userExpired', 'userRememberToken', 'userRememberTokenValidity', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID_USER, UserTableMap::COL_USER_USERNAME, UserTableMap::COL_USER_PASSWORD, UserTableMap::COL_USER_SALT, UserTableMap::COL_USER_FIRSTNAME, UserTableMap::COL_USER_LASTNAME, UserTableMap::COL_USER_EMAIL, UserTableMap::COL_USER_ACTIVE, UserTableMap::COL_USER_ROLES, UserTableMap::COL_USER_EXPIRE_AT, UserTableMap::COL_USER_EXPIRED, UserTableMap::COL_USER_REMEMBER_TOKEN, UserTableMap::COL_USER_REMEMBER_TOKEN_VALIDITY, UserTableMap::COL_CREATED_AT, UserTableMap::COL_UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_USER', 'COL_USER_USERNAME', 'COL_USER_PASSWORD', 'COL_USER_SALT', 'COL_USER_FIRSTNAME', 'COL_USER_LASTNAME', 'COL_USER_EMAIL', 'COL_USER_ACTIVE', 'COL_USER_ROLES', 'COL_USER_EXPIRE_AT', 'COL_USER_EXPIRED', 'COL_USER_REMEMBER_TOKEN', 'COL_USER_REMEMBER_TOKEN_VALIDITY', 'COL_CREATED_AT', 'COL_UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id_user', 'user_username', 'user_password', 'user_salt', 'user_firstname', 'user_lastname', 'user_email', 'user_active', 'user_roles', 'user_expire_at', 'user_expired', 'user_remember_token', 'user_remember_token_validity', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdUser' => 0, 'UserUsername' => 1, 'UserPassword' => 2, 'UserSalt' => 3, 'UserFirstname' => 4, 'UserLastname' => 5, 'UserEmail' => 6, 'UserActive' => 7, 'UserRoles' => 8, 'UserExpireAt' => 9, 'UserExpired' => 10, 'UserRememberToken' => 11, 'UserRememberTokenValidity' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, ),
        self::TYPE_STUDLYPHPNAME => array('idUser' => 0, 'userUsername' => 1, 'userPassword' => 2, 'userSalt' => 3, 'userFirstname' => 4, 'userLastname' => 5, 'userEmail' => 6, 'userActive' => 7, 'userRoles' => 8, 'userExpireAt' => 9, 'userExpired' => 10, 'userRememberToken' => 11, 'userRememberTokenValidity' => 12, 'createdAt' => 13, 'updatedAt' => 14, ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID_USER => 0, UserTableMap::COL_USER_USERNAME => 1, UserTableMap::COL_USER_PASSWORD => 2, UserTableMap::COL_USER_SALT => 3, UserTableMap::COL_USER_FIRSTNAME => 4, UserTableMap::COL_USER_LASTNAME => 5, UserTableMap::COL_USER_EMAIL => 6, UserTableMap::COL_USER_ACTIVE => 7, UserTableMap::COL_USER_ROLES => 8, UserTableMap::COL_USER_EXPIRE_AT => 9, UserTableMap::COL_USER_EXPIRED => 10, UserTableMap::COL_USER_REMEMBER_TOKEN => 11, UserTableMap::COL_USER_REMEMBER_TOKEN_VALIDITY => 12, UserTableMap::COL_CREATED_AT => 13, UserTableMap::COL_UPDATED_AT => 14, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID_USER' => 0, 'COL_USER_USERNAME' => 1, 'COL_USER_PASSWORD' => 2, 'COL_USER_SALT' => 3, 'COL_USER_FIRSTNAME' => 4, 'COL_USER_LASTNAME' => 5, 'COL_USER_EMAIL' => 6, 'COL_USER_ACTIVE' => 7, 'COL_USER_ROLES' => 8, 'COL_USER_EXPIRE_AT' => 9, 'COL_USER_EXPIRED' => 10, 'COL_USER_REMEMBER_TOKEN' => 11, 'COL_USER_REMEMBER_TOKEN_VALIDITY' => 12, 'COL_CREATED_AT' => 13, 'COL_UPDATED_AT' => 14, ),
        self::TYPE_FIELDNAME     => array('id_user' => 0, 'user_username' => 1, 'user_password' => 2, 'user_salt' => 3, 'user_firstname' => 4, 'user_lastname' => 5, 'user_email' => 6, 'user_active' => 7, 'user_roles' => 8, 'user_expire_at' => 9, 'user_expired' => 10, 'user_remember_token' => 11, 'user_remember_token_validity' => 12, 'created_at' => 13, 'updated_at' => 14, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
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
        $this->setName('user');
        $this->setPhpName('User');
        $this->setClassName('\\App\\Model\\User');
        $this->setPackage('App.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_USER', 'IdUser', 'INTEGER', true, 10, null);
        $this->addColumn('USER_USERNAME', 'UserUsername', 'VARCHAR', true, 32, null);
        $this->getColumn('USER_USERNAME', false)->setPrimaryString(true);
        $this->addColumn('USER_PASSWORD', 'UserPassword', 'CHAR', true, 64, null);
        $this->addColumn('USER_SALT', 'UserSalt', 'CHAR', true, 15, null);
        $this->addColumn('USER_FIRSTNAME', 'UserFirstname', 'VARCHAR', false, 100, null);
        $this->addColumn('USER_LASTNAME', 'UserLastname', 'VARCHAR', false, 100, null);
        $this->addColumn('USER_EMAIL', 'UserEmail', 'VARCHAR', true, 70, null);
        $this->addColumn('USER_ACTIVE', 'UserActive', 'BOOLEAN', true, 1, false);
        $this->addColumn('USER_ROLES', 'UserRoles', 'ARRAY', true, null, null);
        $this->addColumn('USER_EXPIRE_AT', 'UserExpireAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('USER_EXPIRED', 'UserExpired', 'BOOLEAN', true, 1, false);
        $this->addColumn('USER_REMEMBER_TOKEN', 'UserRememberToken', 'VARCHAR', false, 40, null);
        $this->addColumn('USER_REMEMBER_TOKEN_VALIDITY', 'UserRememberTokenValidity', 'TIMESTAMP', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Trigger', '\\App\\Model\\Trigger', RelationMap::ONE_TO_MANY, array('id_user' => 'user_id', ), null, null, 'Triggers');
        $this->addRelation('UserLog', '\\App\\Model\\UserLog', RelationMap::ONE_TO_MANY, array('id_user' => 'user_id', ), 'CASCADE', null, 'UserLogs');
        $this->addRelation('UserTargetGroup', '\\App\\Model\\UserTargetGroup', RelationMap::ONE_TO_MANY, array('id_user' => 'id_user', ), 'CASCADE', null, 'UserTargetGroups');
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
     * Method to invalidate the instance pool of all tables related to user     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        UserLogTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
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
     * @return array           (User object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
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
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var User $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UserTableMap::COL_ID_USER);
            $criteria->addSelectColumn(UserTableMap::COL_USER_USERNAME);
            $criteria->addSelectColumn(UserTableMap::COL_USER_PASSWORD);
            $criteria->addSelectColumn(UserTableMap::COL_USER_SALT);
            $criteria->addSelectColumn(UserTableMap::COL_USER_FIRSTNAME);
            $criteria->addSelectColumn(UserTableMap::COL_USER_LASTNAME);
            $criteria->addSelectColumn(UserTableMap::COL_USER_EMAIL);
            $criteria->addSelectColumn(UserTableMap::COL_USER_ACTIVE);
            $criteria->addSelectColumn(UserTableMap::COL_USER_ROLES);
            $criteria->addSelectColumn(UserTableMap::COL_USER_EXPIRE_AT);
            $criteria->addSelectColumn(UserTableMap::COL_USER_EXPIRED);
            $criteria->addSelectColumn(UserTableMap::COL_USER_REMEMBER_TOKEN);
            $criteria->addSelectColumn(UserTableMap::COL_USER_REMEMBER_TOKEN_VALIDITY);
            $criteria->addSelectColumn(UserTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UserTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID_USER');
            $criteria->addSelectColumn($alias . '.USER_USERNAME');
            $criteria->addSelectColumn($alias . '.USER_PASSWORD');
            $criteria->addSelectColumn($alias . '.USER_SALT');
            $criteria->addSelectColumn($alias . '.USER_FIRSTNAME');
            $criteria->addSelectColumn($alias . '.USER_LASTNAME');
            $criteria->addSelectColumn($alias . '.USER_EMAIL');
            $criteria->addSelectColumn($alias . '.USER_ACTIVE');
            $criteria->addSelectColumn($alias . '.USER_ROLES');
            $criteria->addSelectColumn($alias . '.USER_EXPIRE_AT');
            $criteria->addSelectColumn($alias . '.USER_EXPIRED');
            $criteria->addSelectColumn($alias . '.USER_REMEMBER_TOKEN');
            $criteria->addSelectColumn($alias . '.USER_REMEMBER_TOKEN_VALIDITY');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or User object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\User) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->add(UserTableMap::COL_ID_USER, (array) $values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param mixed               $criteria Criteria or User object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        if ($criteria->containsKey(UserTableMap::COL_ID_USER) && $criteria->keyContainsValue(UserTableMap::COL_ID_USER) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserTableMap::COL_ID_USER.')');
        }


        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTableMap::buildTableMap();
