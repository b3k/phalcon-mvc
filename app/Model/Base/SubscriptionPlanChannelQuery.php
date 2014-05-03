<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\SubscriptionPlanChannel as ChildSubscriptionPlanChannel;
use App\Model\SubscriptionPlanChannelQuery as ChildSubscriptionPlanChannelQuery;
use App\Model\Map\SubscriptionPlanChannelTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'subscription_plan_channel' table.
 *
 *
 *
 * @method     ChildSubscriptionPlanChannelQuery orderByIdSubscriptionPlan($order = Criteria::ASC) Order by the id_subscription_plan column
 * @method     ChildSubscriptionPlanChannelQuery orderByIdChannel($order = Criteria::ASC) Order by the id_channel column
 *
 * @method     ChildSubscriptionPlanChannelQuery groupByIdSubscriptionPlan() Group by the id_subscription_plan column
 * @method     ChildSubscriptionPlanChannelQuery groupByIdChannel() Group by the id_channel column
 *
 * @method     ChildSubscriptionPlanChannelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSubscriptionPlanChannelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSubscriptionPlanChannelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSubscriptionPlanChannelQuery leftJoinChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Channel relation
 * @method     ChildSubscriptionPlanChannelQuery rightJoinChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Channel relation
 * @method     ChildSubscriptionPlanChannelQuery innerJoinChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the Channel relation
 *
 * @method     ChildSubscriptionPlanChannelQuery leftJoinSubscriptionPlan($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriptionPlan relation
 * @method     ChildSubscriptionPlanChannelQuery rightJoinSubscriptionPlan($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriptionPlan relation
 * @method     ChildSubscriptionPlanChannelQuery innerJoinSubscriptionPlan($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriptionPlan relation
 *
 * @method     \App\Model\ChannelQuery|\App\Model\SubscriptionPlanQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSubscriptionPlanChannel findOne(ConnectionInterface $con = null) Return the first ChildSubscriptionPlanChannel matching the query
 * @method     ChildSubscriptionPlanChannel findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSubscriptionPlanChannel matching the query, or a new ChildSubscriptionPlanChannel object populated from the query conditions when no match is found
 *
 * @method     ChildSubscriptionPlanChannel findOneByIdSubscriptionPlan(int $id_subscription_plan) Return the first ChildSubscriptionPlanChannel filtered by the id_subscription_plan column
 * @method     ChildSubscriptionPlanChannel findOneByIdChannel(int $id_channel) Return the first ChildSubscriptionPlanChannel filtered by the id_channel column
 *
 * @method     ChildSubscriptionPlanChannel[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSubscriptionPlanChannel objects based on current ModelCriteria
 * @method     ChildSubscriptionPlanChannel[]|ObjectCollection findByIdSubscriptionPlan(int $id_subscription_plan) Return ChildSubscriptionPlanChannel objects filtered by the id_subscription_plan column
 * @method     ChildSubscriptionPlanChannel[]|ObjectCollection findByIdChannel(int $id_channel) Return ChildSubscriptionPlanChannel objects filtered by the id_channel column
 * @method     ChildSubscriptionPlanChannel[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SubscriptionPlanChannelQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\SubscriptionPlanChannelQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\SubscriptionPlanChannel', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSubscriptionPlanChannelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSubscriptionPlanChannelQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSubscriptionPlanChannelQuery) {
            return $criteria;
        }
        $query = new ChildSubscriptionPlanChannelQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id_subscription_plan, $id_channel] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSubscriptionPlanChannel|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SubscriptionPlanChannelTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SubscriptionPlanChannelTableMap::DATABASE_NAME);
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
     * @return ChildSubscriptionPlanChannel A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_SUBSCRIPTION_PLAN, ID_CHANNEL FROM subscription_plan_channel WHERE ID_SUBSCRIPTION_PLAN = :p0 AND ID_CHANNEL = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSubscriptionPlanChannel $obj */
            $obj = new ChildSubscriptionPlanChannel();
            $obj->hydrate($row);
            SubscriptionPlanChannelTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSubscriptionPlanChannel|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id_subscription_plan column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSubscriptionPlan(1234); // WHERE id_subscription_plan = 1234
     * $query->filterByIdSubscriptionPlan(array(12, 34)); // WHERE id_subscription_plan IN (12, 34)
     * $query->filterByIdSubscriptionPlan(array('min' => 12)); // WHERE id_subscription_plan > 12
     * </code>
     *
     * @see       filterBySubscriptionPlan()
     *
     * @param     mixed $idSubscriptionPlan The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function filterByIdSubscriptionPlan($idSubscriptionPlan = null, $comparison = null)
    {
        if (is_array($idSubscriptionPlan)) {
            $useMinMax = false;
            if (isset($idSubscriptionPlan['min'])) {
                $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $idSubscriptionPlan['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSubscriptionPlan['max'])) {
                $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $idSubscriptionPlan['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $idSubscriptionPlan, $comparison);
    }

    /**
     * Filter the query on the id_channel column
     *
     * Example usage:
     * <code>
     * $query->filterByIdChannel(1234); // WHERE id_channel = 1234
     * $query->filterByIdChannel(array(12, 34)); // WHERE id_channel IN (12, 34)
     * $query->filterByIdChannel(array('min' => 12)); // WHERE id_channel > 12
     * </code>
     *
     * @see       filterByChannel()
     *
     * @param     mixed $idChannel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function filterByIdChannel($idChannel = null, $comparison = null)
    {
        if (is_array($idChannel)) {
            $useMinMax = false;
            if (isset($idChannel['min'])) {
                $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $idChannel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idChannel['max'])) {
                $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $idChannel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $idChannel, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Channel object
     *
     * @param \App\Model\Channel|ObjectCollection $channel The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function filterByChannel($channel, $comparison = null)
    {
        if ($channel instanceof \App\Model\Channel) {
            return $this
                ->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $channel->getIdChannel(), $comparison);
        } elseif ($channel instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL, $channel->toKeyValue('PrimaryKey', 'IdChannel'), $comparison);
        } else {
            throw new PropelException('filterByChannel() only accepts arguments of type \App\Model\Channel or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Channel relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function joinChannel($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Channel');

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
            $this->addJoinObject($join, 'Channel');
        }

        return $this;
    }

    /**
     * Use the Channel relation Channel object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\ChannelQuery A secondary query class using the current class as primary query
     */
    public function useChannelQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChannel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Channel', '\App\Model\ChannelQuery');
    }

    /**
     * Filter the query by a related \App\Model\SubscriptionPlan object
     *
     * @param \App\Model\SubscriptionPlan|ObjectCollection $subscriptionPlan The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlan($subscriptionPlan, $comparison = null)
    {
        if ($subscriptionPlan instanceof \App\Model\SubscriptionPlan) {
            return $this
                ->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $subscriptionPlan->getIdSubscriptionPlan(), $comparison);
        } elseif ($subscriptionPlan instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN, $subscriptionPlan->toKeyValue('PrimaryKey', 'IdSubscriptionPlan'), $comparison);
        } else {
            throw new PropelException('filterBySubscriptionPlan() only accepts arguments of type \App\Model\SubscriptionPlan or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SubscriptionPlan relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function joinSubscriptionPlan($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SubscriptionPlan');

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
            $this->addJoinObject($join, 'SubscriptionPlan');
        }

        return $this;
    }

    /**
     * Use the SubscriptionPlan relation SubscriptionPlan object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\SubscriptionPlanQuery A secondary query class using the current class as primary query
     */
    public function useSubscriptionPlanQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSubscriptionPlan($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SubscriptionPlan', '\App\Model\SubscriptionPlanQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSubscriptionPlanChannel $subscriptionPlanChannel Object to remove from the list of results
     *
     * @return $this|ChildSubscriptionPlanChannelQuery The current query, for fluid interface
     */
    public function prune($subscriptionPlanChannel = null)
    {
        if ($subscriptionPlanChannel) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SubscriptionPlanChannelTableMap::COL_ID_SUBSCRIPTION_PLAN), $subscriptionPlanChannel->getIdSubscriptionPlan(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SubscriptionPlanChannelTableMap::COL_ID_CHANNEL), $subscriptionPlanChannel->getIdChannel(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the subscription_plan_channel table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanChannelTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SubscriptionPlanChannelTableMap::clearInstancePool();
            SubscriptionPlanChannelTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanChannelTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SubscriptionPlanChannelTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SubscriptionPlanChannelTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SubscriptionPlanChannelTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SubscriptionPlanChannelQuery
