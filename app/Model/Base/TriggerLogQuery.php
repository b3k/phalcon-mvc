<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\TriggerLog as ChildTriggerLog;
use App\Model\TriggerLogQuery as ChildTriggerLogQuery;
use App\Model\Map\TriggerLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trigger_log' table.
 *
 *
 *
 * @method     ChildTriggerLogQuery orderByIdTriggerLog($order = Criteria::ASC) Order by the id_trigger_log column
 * @method     ChildTriggerLogQuery orderByTriggerId($order = Criteria::ASC) Order by the trigger_id column
 * @method     ChildTriggerLogQuery orderByTriggerLogExecutedOn($order = Criteria::ASC) Order by the trigger_log_executed_on column
 * @method     ChildTriggerLogQuery orderByTriggerLogResult($order = Criteria::ASC) Order by the trigger_log_result column
 * @method     ChildTriggerLogQuery orderByExecutedAt($order = Criteria::ASC) Order by the executed_at column
 *
 * @method     ChildTriggerLogQuery groupByIdTriggerLog() Group by the id_trigger_log column
 * @method     ChildTriggerLogQuery groupByTriggerId() Group by the trigger_id column
 * @method     ChildTriggerLogQuery groupByTriggerLogExecutedOn() Group by the trigger_log_executed_on column
 * @method     ChildTriggerLogQuery groupByTriggerLogResult() Group by the trigger_log_result column
 * @method     ChildTriggerLogQuery groupByExecutedAt() Group by the executed_at column
 *
 * @method     ChildTriggerLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTriggerLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTriggerLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTriggerLogQuery leftJoinTrigger($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trigger relation
 * @method     ChildTriggerLogQuery rightJoinTrigger($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trigger relation
 * @method     ChildTriggerLogQuery innerJoinTrigger($relationAlias = null) Adds a INNER JOIN clause to the query using the Trigger relation
 *
 * @method     \App\Model\TriggerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTriggerLog findOne(ConnectionInterface $con = null) Return the first ChildTriggerLog matching the query
 * @method     ChildTriggerLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTriggerLog matching the query, or a new ChildTriggerLog object populated from the query conditions when no match is found
 *
 * @method     ChildTriggerLog findOneByIdTriggerLog(int $id_trigger_log) Return the first ChildTriggerLog filtered by the id_trigger_log column
 * @method     ChildTriggerLog findOneByTriggerId(int $trigger_id) Return the first ChildTriggerLog filtered by the trigger_id column
 * @method     ChildTriggerLog findOneByTriggerLogExecutedOn(string $trigger_log_executed_on) Return the first ChildTriggerLog filtered by the trigger_log_executed_on column
 * @method     ChildTriggerLog findOneByTriggerLogResult(string $trigger_log_result) Return the first ChildTriggerLog filtered by the trigger_log_result column
 * @method     ChildTriggerLog findOneByExecutedAt(string $executed_at) Return the first ChildTriggerLog filtered by the executed_at column
 *
 * @method     ChildTriggerLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTriggerLog objects based on current ModelCriteria
 * @method     ChildTriggerLog[]|ObjectCollection findByIdTriggerLog(int $id_trigger_log) Return ChildTriggerLog objects filtered by the id_trigger_log column
 * @method     ChildTriggerLog[]|ObjectCollection findByTriggerId(int $trigger_id) Return ChildTriggerLog objects filtered by the trigger_id column
 * @method     ChildTriggerLog[]|ObjectCollection findByTriggerLogExecutedOn(string $trigger_log_executed_on) Return ChildTriggerLog objects filtered by the trigger_log_executed_on column
 * @method     ChildTriggerLog[]|ObjectCollection findByTriggerLogResult(string $trigger_log_result) Return ChildTriggerLog objects filtered by the trigger_log_result column
 * @method     ChildTriggerLog[]|ObjectCollection findByExecutedAt(string $executed_at) Return ChildTriggerLog objects filtered by the executed_at column
 * @method     ChildTriggerLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TriggerLogQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\TriggerLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\TriggerLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTriggerLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTriggerLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTriggerLogQuery) {
            return $criteria;
        }
        $query = new ChildTriggerLogQuery();
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
     * @return ChildTriggerLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TriggerLogTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TriggerLogTableMap::DATABASE_NAME);
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
     * @return ChildTriggerLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `ID_TRIGGER_LOG`, `TRIGGER_ID`, `TRIGGER_LOG_EXECUTED_ON`, `TRIGGER_LOG_RESULT`, `EXECUTED_AT` FROM `trigger_log` WHERE `ID_TRIGGER_LOG` = :p0';
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
            /** @var ChildTriggerLog $obj */
            $obj = new ChildTriggerLog();
            $obj->hydrate($row);
            TriggerLogTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTriggerLog|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TriggerLogTableMap::COL_ID_TRIGGER_LOG, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TriggerLogTableMap::COL_ID_TRIGGER_LOG, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_trigger_log column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTriggerLog(1234); // WHERE id_trigger_log = 1234
     * $query->filterByIdTriggerLog(array(12, 34)); // WHERE id_trigger_log IN (12, 34)
     * $query->filterByIdTriggerLog(array('min' => 12)); // WHERE id_trigger_log > 12
     * </code>
     *
     * @param     mixed $idTriggerLog The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByIdTriggerLog($idTriggerLog = null, $comparison = null)
    {
        if (is_array($idTriggerLog)) {
            $useMinMax = false;
            if (isset($idTriggerLog['min'])) {
                $this->addUsingAlias(TriggerLogTableMap::COL_ID_TRIGGER_LOG, $idTriggerLog['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTriggerLog['max'])) {
                $this->addUsingAlias(TriggerLogTableMap::COL_ID_TRIGGER_LOG, $idTriggerLog['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerLogTableMap::COL_ID_TRIGGER_LOG, $idTriggerLog, $comparison);
    }

    /**
     * Filter the query on the trigger_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerId(1234); // WHERE trigger_id = 1234
     * $query->filterByTriggerId(array(12, 34)); // WHERE trigger_id IN (12, 34)
     * $query->filterByTriggerId(array('min' => 12)); // WHERE trigger_id > 12
     * </code>
     *
     * @see       filterByTrigger()
     *
     * @param     mixed $triggerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByTriggerId($triggerId = null, $comparison = null)
    {
        if (is_array($triggerId)) {
            $useMinMax = false;
            if (isset($triggerId['min'])) {
                $this->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_ID, $triggerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($triggerId['max'])) {
                $this->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_ID, $triggerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_ID, $triggerId, $comparison);
    }

    /**
     * Filter the query on the trigger_log_executed_on column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerLogExecutedOn('fooValue');   // WHERE trigger_log_executed_on = 'fooValue'
     * $query->filterByTriggerLogExecutedOn('%fooValue%'); // WHERE trigger_log_executed_on LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerLogExecutedOn The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByTriggerLogExecutedOn($triggerLogExecutedOn = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerLogExecutedOn)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerLogExecutedOn)) {
                $triggerLogExecutedOn = str_replace('*', '%', $triggerLogExecutedOn);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_LOG_EXECUTED_ON, $triggerLogExecutedOn, $comparison);
    }

    /**
     * Filter the query on the trigger_log_result column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerLogResult('fooValue');   // WHERE trigger_log_result = 'fooValue'
     * $query->filterByTriggerLogResult('%fooValue%'); // WHERE trigger_log_result LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerLogResult The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByTriggerLogResult($triggerLogResult = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerLogResult)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerLogResult)) {
                $triggerLogResult = str_replace('*', '%', $triggerLogResult);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_LOG_RESULT, $triggerLogResult, $comparison);
    }

    /**
     * Filter the query on the executed_at column
     *
     * Example usage:
     * <code>
     * $query->filterByExecutedAt('2011-03-14'); // WHERE executed_at = '2011-03-14'
     * $query->filterByExecutedAt('now'); // WHERE executed_at = '2011-03-14'
     * $query->filterByExecutedAt(array('max' => 'yesterday')); // WHERE executed_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $executedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByExecutedAt($executedAt = null, $comparison = null)
    {
        if (is_array($executedAt)) {
            $useMinMax = false;
            if (isset($executedAt['min'])) {
                $this->addUsingAlias(TriggerLogTableMap::COL_EXECUTED_AT, $executedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($executedAt['max'])) {
                $this->addUsingAlias(TriggerLogTableMap::COL_EXECUTED_AT, $executedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerLogTableMap::COL_EXECUTED_AT, $executedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Trigger object
     *
     * @param \App\Model\Trigger|ObjectCollection $trigger The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerLogQuery The current query, for fluid interface
     */
    public function filterByTrigger($trigger, $comparison = null)
    {
        if ($trigger instanceof \App\Model\Trigger) {
            return $this
                ->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_ID, $trigger->getIdTrigger(), $comparison);
        } elseif ($trigger instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerLogTableMap::COL_TRIGGER_ID, $trigger->toKeyValue('PrimaryKey', 'IdTrigger'), $comparison);
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
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildTriggerLog $triggerLog Object to remove from the list of results
     *
     * @return $this|ChildTriggerLogQuery The current query, for fluid interface
     */
    public function prune($triggerLog = null)
    {
        if ($triggerLog) {
            $this->addUsingAlias(TriggerLogTableMap::COL_ID_TRIGGER_LOG, $triggerLog->getIdTriggerLog(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trigger_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TriggerLogTableMap::clearInstancePool();
            TriggerLogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TriggerLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TriggerLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TriggerLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TriggerLogQuery
