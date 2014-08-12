<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\User as ChildUser;
use App\Model\UserQuery as ChildUserQuery;
use App\Model\Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user' table.
 *
 *
 *
 * @method     ChildUserQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 * @method     ChildUserQuery orderByUserUsername($order = Criteria::ASC) Order by the user_username column
 * @method     ChildUserQuery orderByUserPassword($order = Criteria::ASC) Order by the user_password column
 * @method     ChildUserQuery orderByUserSalt($order = Criteria::ASC) Order by the user_salt column
 * @method     ChildUserQuery orderByUserFirstname($order = Criteria::ASC) Order by the user_firstname column
 * @method     ChildUserQuery orderByUserLastname($order = Criteria::ASC) Order by the user_lastname column
 * @method     ChildUserQuery orderByUserEmail($order = Criteria::ASC) Order by the user_email column
 * @method     ChildUserQuery orderByUserActive($order = Criteria::ASC) Order by the user_active column
 * @method     ChildUserQuery orderByUserRoles($order = Criteria::ASC) Order by the user_roles column
 * @method     ChildUserQuery orderByUserExpireAt($order = Criteria::ASC) Order by the user_expire_at column
 * @method     ChildUserQuery orderByUserExpired($order = Criteria::ASC) Order by the user_expired column
 * @method     ChildUserQuery orderByUserRememberToken($order = Criteria::ASC) Order by the user_remember_token column
 * @method     ChildUserQuery orderByUserRememberTokenValidity($order = Criteria::ASC) Order by the user_remember_token_validity column
 * @method     ChildUserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserQuery groupByIdUser() Group by the id_user column
 * @method     ChildUserQuery groupByUserUsername() Group by the user_username column
 * @method     ChildUserQuery groupByUserPassword() Group by the user_password column
 * @method     ChildUserQuery groupByUserSalt() Group by the user_salt column
 * @method     ChildUserQuery groupByUserFirstname() Group by the user_firstname column
 * @method     ChildUserQuery groupByUserLastname() Group by the user_lastname column
 * @method     ChildUserQuery groupByUserEmail() Group by the user_email column
 * @method     ChildUserQuery groupByUserActive() Group by the user_active column
 * @method     ChildUserQuery groupByUserRoles() Group by the user_roles column
 * @method     ChildUserQuery groupByUserExpireAt() Group by the user_expire_at column
 * @method     ChildUserQuery groupByUserExpired() Group by the user_expired column
 * @method     ChildUserQuery groupByUserRememberToken() Group by the user_remember_token column
 * @method     ChildUserQuery groupByUserRememberTokenValidity() Group by the user_remember_token_validity column
 * @method     ChildUserQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinTrigger($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trigger relation
 * @method     ChildUserQuery rightJoinTrigger($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trigger relation
 * @method     ChildUserQuery innerJoinTrigger($relationAlias = null) Adds a INNER JOIN clause to the query using the Trigger relation
 *
 * @method     ChildUserQuery leftJoinUserLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserLog relation
 * @method     ChildUserQuery rightJoinUserLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserLog relation
 * @method     ChildUserQuery innerJoinUserLog($relationAlias = null) Adds a INNER JOIN clause to the query using the UserLog relation
 *
 * @method     ChildUserQuery leftJoinUserTargetGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserTargetGroup relation
 * @method     ChildUserQuery rightJoinUserTargetGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserTargetGroup relation
 * @method     ChildUserQuery innerJoinUserTargetGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the UserTargetGroup relation
 *
 * @method     \App\Model\TriggerQuery|\App\Model\UserLogQuery|\App\Model\UserTargetGroupQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneByIdUser(int $id_user) Return the first ChildUser filtered by the id_user column
 * @method     ChildUser findOneByUserUsername(string $user_username) Return the first ChildUser filtered by the user_username column
 * @method     ChildUser findOneByUserPassword(string $user_password) Return the first ChildUser filtered by the user_password column
 * @method     ChildUser findOneByUserSalt(string $user_salt) Return the first ChildUser filtered by the user_salt column
 * @method     ChildUser findOneByUserFirstname(string $user_firstname) Return the first ChildUser filtered by the user_firstname column
 * @method     ChildUser findOneByUserLastname(string $user_lastname) Return the first ChildUser filtered by the user_lastname column
 * @method     ChildUser findOneByUserEmail(string $user_email) Return the first ChildUser filtered by the user_email column
 * @method     ChildUser findOneByUserActive(boolean $user_active) Return the first ChildUser filtered by the user_active column
 * @method     ChildUser findOneByUserRoles(array $user_roles) Return the first ChildUser filtered by the user_roles column
 * @method     ChildUser findOneByUserExpireAt(string $user_expire_at) Return the first ChildUser filtered by the user_expire_at column
 * @method     ChildUser findOneByUserExpired(boolean $user_expired) Return the first ChildUser filtered by the user_expired column
 * @method     ChildUser findOneByUserRememberToken(string $user_remember_token) Return the first ChildUser filtered by the user_remember_token column
 * @method     ChildUser findOneByUserRememberTokenValidity(string $user_remember_token_validity) Return the first ChildUser filtered by the user_remember_token_validity column
 * @method     ChildUser findOneByCreatedAt(string $created_at) Return the first ChildUser filtered by the created_at column
 * @method     ChildUser findOneByUpdatedAt(string $updated_at) Return the first ChildUser filtered by the updated_at column
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findByIdUser(int $id_user) Return ChildUser objects filtered by the id_user column
 * @method     ChildUser[]|ObjectCollection findByUserUsername(string $user_username) Return ChildUser objects filtered by the user_username column
 * @method     ChildUser[]|ObjectCollection findByUserPassword(string $user_password) Return ChildUser objects filtered by the user_password column
 * @method     ChildUser[]|ObjectCollection findByUserSalt(string $user_salt) Return ChildUser objects filtered by the user_salt column
 * @method     ChildUser[]|ObjectCollection findByUserFirstname(string $user_firstname) Return ChildUser objects filtered by the user_firstname column
 * @method     ChildUser[]|ObjectCollection findByUserLastname(string $user_lastname) Return ChildUser objects filtered by the user_lastname column
 * @method     ChildUser[]|ObjectCollection findByUserEmail(string $user_email) Return ChildUser objects filtered by the user_email column
 * @method     ChildUser[]|ObjectCollection findByUserActive(boolean $user_active) Return ChildUser objects filtered by the user_active column
 * @method     ChildUser[]|ObjectCollection findByUserRoles(array $user_roles) Return ChildUser objects filtered by the user_roles column
 * @method     ChildUser[]|ObjectCollection findByUserExpireAt(string $user_expire_at) Return ChildUser objects filtered by the user_expire_at column
 * @method     ChildUser[]|ObjectCollection findByUserExpired(boolean $user_expired) Return ChildUser objects filtered by the user_expired column
 * @method     ChildUser[]|ObjectCollection findByUserRememberToken(string $user_remember_token) Return ChildUser objects filtered by the user_remember_token column
 * @method     ChildUser[]|ObjectCollection findByUserRememberTokenValidity(string $user_remember_token_validity) Return ChildUser objects filtered by the user_remember_token_validity column
 * @method     ChildUser[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUser objects filtered by the created_at column
 * @method     ChildUser[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildUser objects filtered by the updated_at column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `ID_USER`, `USER_USERNAME`, `USER_PASSWORD`, `USER_SALT`, `USER_FIRSTNAME`, `USER_LASTNAME`, `USER_EMAIL`, `USER_ACTIVE`, `USER_ROLES`, `USER_EXPIRE_AT`, `USER_EXPIRED`, `USER_REMEMBER_TOKEN`, `USER_REMEMBER_TOKEN_VALIDITY`, `CREATED_AT`, `UPDATED_AT` FROM `user` WHERE `ID_USER` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID_USER, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID_USER, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_user column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUser(1234); // WHERE id_user = 1234
     * $query->filterByIdUser(array(12, 34)); // WHERE id_user IN (12, 34)
     * $query->filterByIdUser(array('min' => 12)); // WHERE id_user > 12
     * </code>
     *
     * @param     mixed $idUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ID_USER, $idUser, $comparison);
    }

    /**
     * Filter the query on the user_username column
     *
     * Example usage:
     * <code>
     * $query->filterByUserUsername('fooValue');   // WHERE user_username = 'fooValue'
     * $query->filterByUserUsername('%fooValue%'); // WHERE user_username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userUsername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserUsername($userUsername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userUsername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userUsername)) {
                $userUsername = str_replace('*', '%', $userUsername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_USERNAME, $userUsername, $comparison);
    }

    /**
     * Filter the query on the user_password column
     *
     * Example usage:
     * <code>
     * $query->filterByUserPassword('fooValue');   // WHERE user_password = 'fooValue'
     * $query->filterByUserPassword('%fooValue%'); // WHERE user_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserPassword($userPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userPassword)) {
                $userPassword = str_replace('*', '%', $userPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_PASSWORD, $userPassword, $comparison);
    }

    /**
     * Filter the query on the user_salt column
     *
     * Example usage:
     * <code>
     * $query->filterByUserSalt('fooValue');   // WHERE user_salt = 'fooValue'
     * $query->filterByUserSalt('%fooValue%'); // WHERE user_salt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userSalt The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserSalt($userSalt = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userSalt)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userSalt)) {
                $userSalt = str_replace('*', '%', $userSalt);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_SALT, $userSalt, $comparison);
    }

    /**
     * Filter the query on the user_firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserFirstname('fooValue');   // WHERE user_firstname = 'fooValue'
     * $query->filterByUserFirstname('%fooValue%'); // WHERE user_firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userFirstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserFirstname($userFirstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userFirstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userFirstname)) {
                $userFirstname = str_replace('*', '%', $userFirstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_FIRSTNAME, $userFirstname, $comparison);
    }

    /**
     * Filter the query on the user_lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserLastname('fooValue');   // WHERE user_lastname = 'fooValue'
     * $query->filterByUserLastname('%fooValue%'); // WHERE user_lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userLastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserLastname($userLastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userLastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userLastname)) {
                $userLastname = str_replace('*', '%', $userLastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_LASTNAME, $userLastname, $comparison);
    }

    /**
     * Filter the query on the user_email column
     *
     * Example usage:
     * <code>
     * $query->filterByUserEmail('fooValue');   // WHERE user_email = 'fooValue'
     * $query->filterByUserEmail('%fooValue%'); // WHERE user_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserEmail($userEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userEmail)) {
                $userEmail = str_replace('*', '%', $userEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_EMAIL, $userEmail, $comparison);
    }

    /**
     * Filter the query on the user_active column
     *
     * Example usage:
     * <code>
     * $query->filterByUserActive(true); // WHERE user_active = true
     * $query->filterByUserActive('yes'); // WHERE user_active = true
     * </code>
     *
     * @param     boolean|string $userActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserActive($userActive = null, $comparison = null)
    {
        if (is_string($userActive)) {
            $userActive = in_array(strtolower($userActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_ACTIVE, $userActive, $comparison);
    }

    /**
     * Filter the query on the user_roles column
     *
     * @param     array $userRoles The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserRoles($userRoles = null, $comparison = null)
    {
        $key = $this->getAliasedColName(UserTableMap::COL_USER_ROLES);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($userRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($userRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($userRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_ROLES, $userRoles, $comparison);
    }

    /**
     * Filter the query on the user_roles column
     * @param     mixed $userRoles The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserRole($userRoles = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($userRoles)) {
                $userRoles = '%| ' . $userRoles . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $userRoles = '%| ' . $userRoles . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(UserTableMap::COL_USER_ROLES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $userRoles, $comparison);
            } else {
                $this->addAnd($key, $userRoles, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_ROLES, $userRoles, $comparison);
    }

    /**
     * Filter the query on the user_expire_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUserExpireAt('2011-03-14'); // WHERE user_expire_at = '2011-03-14'
     * $query->filterByUserExpireAt('now'); // WHERE user_expire_at = '2011-03-14'
     * $query->filterByUserExpireAt(array('max' => 'yesterday')); // WHERE user_expire_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $userExpireAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserExpireAt($userExpireAt = null, $comparison = null)
    {
        if (is_array($userExpireAt)) {
            $useMinMax = false;
            if (isset($userExpireAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_EXPIRE_AT, $userExpireAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userExpireAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_EXPIRE_AT, $userExpireAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_EXPIRE_AT, $userExpireAt, $comparison);
    }

    /**
     * Filter the query on the user_expired column
     *
     * Example usage:
     * <code>
     * $query->filterByUserExpired(true); // WHERE user_expired = true
     * $query->filterByUserExpired('yes'); // WHERE user_expired = true
     * </code>
     *
     * @param     boolean|string $userExpired The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserExpired($userExpired = null, $comparison = null)
    {
        if (is_string($userExpired)) {
            $userExpired = in_array(strtolower($userExpired), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_EXPIRED, $userExpired, $comparison);
    }

    /**
     * Filter the query on the user_remember_token column
     *
     * Example usage:
     * <code>
     * $query->filterByUserRememberToken('fooValue');   // WHERE user_remember_token = 'fooValue'
     * $query->filterByUserRememberToken('%fooValue%'); // WHERE user_remember_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userRememberToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserRememberToken($userRememberToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userRememberToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userRememberToken)) {
                $userRememberToken = str_replace('*', '%', $userRememberToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_REMEMBER_TOKEN, $userRememberToken, $comparison);
    }

    /**
     * Filter the query on the user_remember_token_validity column
     *
     * Example usage:
     * <code>
     * $query->filterByUserRememberTokenValidity('2011-03-14'); // WHERE user_remember_token_validity = '2011-03-14'
     * $query->filterByUserRememberTokenValidity('now'); // WHERE user_remember_token_validity = '2011-03-14'
     * $query->filterByUserRememberTokenValidity(array('max' => 'yesterday')); // WHERE user_remember_token_validity > '2011-03-13'
     * </code>
     *
     * @param     mixed $userRememberTokenValidity The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserRememberTokenValidity($userRememberTokenValidity = null, $comparison = null)
    {
        if (is_array($userRememberTokenValidity)) {
            $useMinMax = false;
            if (isset($userRememberTokenValidity['min'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_REMEMBER_TOKEN_VALIDITY, $userRememberTokenValidity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userRememberTokenValidity['max'])) {
                $this->addUsingAlias(UserTableMap::COL_USER_REMEMBER_TOKEN_VALIDITY, $userRememberTokenValidity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USER_REMEMBER_TOKEN_VALIDITY, $userRememberTokenValidity, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Trigger object
     *
     * @param \App\Model\Trigger|ObjectCollection $trigger  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTrigger($trigger, $comparison = null)
    {
        if ($trigger instanceof \App\Model\Trigger) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID_USER, $trigger->getUserId(), $comparison);
        } elseif ($trigger instanceof ObjectCollection) {
            return $this
                ->useTriggerQuery()
                ->filterByPrimaryKeys($trigger->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrigger() only accepts arguments of type \App\Model\Trigger or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Trigger relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTrigger($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Trigger');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Trigger');
        }

        return $this;
    }

    /**
     * Use the Trigger relation Trigger object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TriggerQuery A secondary query class using the current class as primary query
     */
    public function useTriggerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrigger($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trigger', '\App\Model\TriggerQuery');
    }

    /**
     * Filter the query by a related \App\Model\UserLog object
     *
     * @param \App\Model\UserLog|ObjectCollection $userLog  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserLog($userLog, $comparison = null)
    {
        if ($userLog instanceof \App\Model\UserLog) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID_USER, $userLog->getUserId(), $comparison);
        } elseif ($userLog instanceof ObjectCollection) {
            return $this
                ->useUserLogQuery()
                ->filterByPrimaryKeys($userLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserLog() only accepts arguments of type \App\Model\UserLog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinUserLog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserLog');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserLog');
        }

        return $this;
    }

    /**
     * Use the UserLog relation UserLog object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\UserLogQuery A secondary query class using the current class as primary query
     */
    public function useUserLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserLog', '\App\Model\UserLogQuery');
    }

    /**
     * Filter the query by a related \App\Model\UserTargetGroup object
     *
     * @param \App\Model\UserTargetGroup|ObjectCollection $userTargetGroup  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserTargetGroup($userTargetGroup, $comparison = null)
    {
        if ($userTargetGroup instanceof \App\Model\UserTargetGroup) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID_USER, $userTargetGroup->getIdUser(), $comparison);
        } elseif ($userTargetGroup instanceof ObjectCollection) {
            return $this
                ->useUserTargetGroupQuery()
                ->filterByPrimaryKeys($userTargetGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserTargetGroup() only accepts arguments of type \App\Model\UserTargetGroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserTargetGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinUserTargetGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserTargetGroup');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserTargetGroup');
        }

        return $this;
    }

    /**
     * Use the UserTargetGroup relation UserTargetGroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\UserTargetGroupQuery A secondary query class using the current class as primary query
     */
    public function useUserTargetGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserTargetGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserTargetGroup', '\App\Model\UserTargetGroupQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_ID_USER, $user->getIdUser(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTableMap::COL_CREATED_AT);
    }

} // UserQuery
