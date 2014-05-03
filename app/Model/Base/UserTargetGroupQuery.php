<?php

namespace app\Model\Base;

use \Exception;
use App\Model\UserTargetGroup as ChildUserTargetGroup;
use App\Model\UserTargetGroupQuery as ChildUserTargetGroupQuery;
use App\Model\Map\UserTargetGroupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_target_group' table.
 *
 *
 *
 * @method     ChildUserTargetGroupQuery orderByIdTargetGroup($order = Criteria::ASC) Order by the id_target_group column
 * @method     ChildUserTargetGroupQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 * @method     ChildUserTargetGroupQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserTargetGroupQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserTargetGroupQuery groupByIdTargetGroup() Group by the id_target_group column
 * @method     ChildUserTargetGroupQuery groupByIdUser() Group by the id_user column
 * @method     ChildUserTargetGroupQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserTargetGroupQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserTargetGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserTargetGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserTargetGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserTargetGroupQuery leftJoinTargetGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetGroup relation
 * @method     ChildUserTargetGroupQuery rightJoinTargetGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetGroup relation
 * @method     ChildUserTargetGroupQuery innerJoinTargetGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetGroup relation
 *
 * @method     ChildUserTargetGroupQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildUserTargetGroupQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildUserTargetGroupQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     \App\Model\TargetGroupQuery|\App\Model\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserTargetGroup findOne(ConnectionInterface $con = null) Return the first ChildUserTargetGroup matching the query
 * @method     ChildUserTargetGroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserTargetGroup matching the query, or a new ChildUserTargetGroup object populated from the query conditions when no match is found
 *
 * @method     ChildUserTargetGroup findOneByIdTargetGroup(int $id_target_group) Return the first ChildUserTargetGroup filtered by the id_target_group column
 * @method     ChildUserTargetGroup findOneByIdUser(int $id_user) Return the first ChildUserTargetGroup filtered by the id_user column
 * @method     ChildUserTargetGroup findOneByCreatedAt(string $created_at) Return the first ChildUserTargetGroup filtered by the created_at column
 * @method     ChildUserTargetGroup findOneByUpdatedAt(string $updated_at) Return the first ChildUserTargetGroup filtered by the updated_at column
 *
 * @method     ChildUserTargetGroup[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserTargetGroup objects based on current ModelCriteria
 * @method     ChildUserTargetGroup[]|ObjectCollection findByIdTargetGroup(int $id_target_group) Return ChildUserTargetGroup objects filtered by the id_target_group column
 * @method     ChildUserTargetGroup[]|ObjectCollection findByIdUser(int $id_user) Return ChildUserTargetGroup objects filtered by the id_user column
 * @method     ChildUserTargetGroup[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUserTargetGroup objects filtered by the created_at column
 * @method     ChildUserTargetGroup[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildUserTargetGroup objects filtered by the updated_at column
 * @method     ChildUserTargetGroup[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserTargetGroupQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\UserTargetGroupQuery object.
     *
     * @param string $dbName     The database name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\UserTargetGroup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserTargetGroupQuery object.
     *
     * @param string   $modelAlias The alias of a model in the query
     * @param Criteria $criteria   Optional Criteria to build the query from
     *
     * @return ChildUserTargetGroupQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserTargetGroupQuery) {
            return $criteria;
        }
        $query = new ChildUserTargetGroupQuery();
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
     * @param mixed               $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildUserTargetGroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The UserTargetGroup object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param array               $keys Primary keys to use for the query
     * @param ConnectionInterface $con  an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The UserTargetGroup object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param mixed $key Primary key to use for the query
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The UserTargetGroup object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The UserTargetGroup object has no primary key');
    }

    /**
     * Filter the query on the id_target_group column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTargetGroup(1234); // WHERE id_target_group = 1234
     * $query->filterByIdTargetGroup(array(12, 34)); // WHERE id_target_group IN (12, 34)
     * $query->filterByIdTargetGroup(array('min' => 12)); // WHERE id_target_group > 12
     * </code>
     *
     * @see       filterByTargetGroup()
     *
     * @param mixed  $idTargetGroup The value to use as filter.
     *                              Use scalar values for equality.
     *                              Use array values for in_array() equivalent.
     *                              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison    Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByIdTargetGroup($idTargetGroup = null, $comparison = null)
    {
        if (is_array($idTargetGroup)) {
            $useMinMax = false;
            if (isset($idTargetGroup['min'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_ID_TARGET_GROUP, $idTargetGroup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTargetGroup['max'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_ID_TARGET_GROUP, $idTargetGroup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTargetGroupTableMap::COL_ID_TARGET_GROUP, $idTargetGroup, $comparison);
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
     * @see       filterByUser()
     *
     * @param mixed  $idUser     The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTargetGroupTableMap::COL_ID_USER, $idUser, $comparison);
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
     * @param mixed  $createdAt  The value to use as filter.
     *                           Values can be integers (unix timestamps), DateTime objects, or strings.
     *                           Empty strings are treated as NULL.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTargetGroupTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @param mixed  $updatedAt  The value to use as filter.
     *                           Values can be integers (unix timestamps), DateTime objects, or strings.
     *                           Empty strings are treated as NULL.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserTargetGroupTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTargetGroupTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\TargetGroup object
     *
     * @param \App\Model\TargetGroup|ObjectCollection $targetGroup The related object(s) to use as filter
     * @param string                                  $comparison  Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByTargetGroup($targetGroup, $comparison = null)
    {
        if ($targetGroup instanceof \App\Model\TargetGroup) {
            return $this
                ->addUsingAlias(UserTargetGroupTableMap::COL_ID_TARGET_GROUP, $targetGroup->getIdTargetGroup(), $comparison);
        } elseif ($targetGroup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserTargetGroupTableMap::COL_ID_TARGET_GROUP, $targetGroup->toKeyValue('PrimaryKey', 'IdTargetGroup'), $comparison);
        } else {
            throw new PropelException('filterByTargetGroup() only accepts arguments of type \App\Model\TargetGroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetGroup relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function joinTargetGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TargetGroup');

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
            $this->addJoinObject($join, 'TargetGroup');
        }

        return $this;
    }

    /**
     * Use the TargetGroup relation TargetGroup object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TargetGroupQuery A secondary query class using the current class as primary query
     */
    public function useTargetGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTargetGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TargetGroup', '\App\Model\TargetGroupQuery');
    }

    /**
     * Filter the query by a related \App\Model\User object
     *
     * @param \App\Model\User|ObjectCollection $user       The related object(s) to use as filter
     * @param string                           $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \App\Model\User) {
            return $this
                ->addUsingAlias(UserTargetGroupTableMap::COL_ID_USER, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserTargetGroupTableMap::COL_ID_USER, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \App\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\App\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param ChildUserTargetGroup $userTargetGroup Object to remove from the list of results
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function prune($userTargetGroup = null)
    {
        if ($userTargetGroup) {
            throw new LogicException('UserTargetGroup object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the user_target_group table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTargetGroupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTargetGroupTableMap::clearInstancePool();
            UserTargetGroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                                 if supported by native driver or if emulated using Propel.
     * @throws PropelException     Any exceptions caught during processing will be
     *                                 rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTargetGroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTargetGroupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTargetGroupTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTargetGroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTargetGroupTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTargetGroupTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTargetGroupTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTargetGroupTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTargetGroupTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return $this|ChildUserTargetGroupQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTargetGroupTableMap::COL_CREATED_AT);
    }

} // UserTargetGroupQuery
