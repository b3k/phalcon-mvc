<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\CronTask as ChildCronTask;
use App\Model\CronTaskQuery as ChildCronTaskQuery;
use App\Model\Map\CronTaskTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cron_task' table.
 *
 *
 *
 * @method     ChildCronTaskQuery orderByIdCronTask($order = Criteria::ASC) Order by the id_cron_task column
 * @method     ChildCronTaskQuery orderByCronTaskCode($order = Criteria::ASC) Order by the cron_task_code column
 * @method     ChildCronTaskQuery orderByCronTaskInterval($order = Criteria::ASC) Order by the cron_task_interval column
 * @method     ChildCronTaskQuery orderByCronTaskParams($order = Criteria::ASC) Order by the cron_task_params column
 * @method     ChildCronTaskQuery orderByCronTaskActive($order = Criteria::ASC) Order by the cron_task_active column
 * @method     ChildCronTaskQuery orderByCronTaskState($order = Criteria::ASC) Order by the cron_task_state column
 * @method     ChildCronTaskQuery orderByCronTaskRunAt($order = Criteria::ASC) Order by the cron_task_run_at column
 * @method     ChildCronTaskQuery orderByCronTaskExecutedAt($order = Criteria::ASC) Order by the cron_task_executed_at column
 * @method     ChildCronTaskQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCronTaskQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildCronTaskQuery groupByIdCronTask() Group by the id_cron_task column
 * @method     ChildCronTaskQuery groupByCronTaskCode() Group by the cron_task_code column
 * @method     ChildCronTaskQuery groupByCronTaskInterval() Group by the cron_task_interval column
 * @method     ChildCronTaskQuery groupByCronTaskParams() Group by the cron_task_params column
 * @method     ChildCronTaskQuery groupByCronTaskActive() Group by the cron_task_active column
 * @method     ChildCronTaskQuery groupByCronTaskState() Group by the cron_task_state column
 * @method     ChildCronTaskQuery groupByCronTaskRunAt() Group by the cron_task_run_at column
 * @method     ChildCronTaskQuery groupByCronTaskExecutedAt() Group by the cron_task_executed_at column
 * @method     ChildCronTaskQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCronTaskQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildCronTaskQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCronTaskQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCronTaskQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCronTask findOne(ConnectionInterface $con = null) Return the first ChildCronTask matching the query
 * @method     ChildCronTask findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCronTask matching the query, or a new ChildCronTask object populated from the query conditions when no match is found
 *
 * @method     ChildCronTask findOneByIdCronTask(int $id_cron_task) Return the first ChildCronTask filtered by the id_cron_task column
 * @method     ChildCronTask findOneByCronTaskCode(string $cron_task_code) Return the first ChildCronTask filtered by the cron_task_code column
 * @method     ChildCronTask findOneByCronTaskInterval(int $cron_task_interval) Return the first ChildCronTask filtered by the cron_task_interval column
 * @method     ChildCronTask findOneByCronTaskParams(string $cron_task_params) Return the first ChildCronTask filtered by the cron_task_params column
 * @method     ChildCronTask findOneByCronTaskActive(boolean $cron_task_active) Return the first ChildCronTask filtered by the cron_task_active column
 * @method     ChildCronTask findOneByCronTaskState(string $cron_task_state) Return the first ChildCronTask filtered by the cron_task_state column
 * @method     ChildCronTask findOneByCronTaskRunAt(string $cron_task_run_at) Return the first ChildCronTask filtered by the cron_task_run_at column
 * @method     ChildCronTask findOneByCronTaskExecutedAt(string $cron_task_executed_at) Return the first ChildCronTask filtered by the cron_task_executed_at column
 * @method     ChildCronTask findOneByCreatedAt(string $created_at) Return the first ChildCronTask filtered by the created_at column
 * @method     ChildCronTask findOneByUpdatedAt(string $updated_at) Return the first ChildCronTask filtered by the updated_at column
 *
 * @method     ChildCronTask[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCronTask objects based on current ModelCriteria
 * @method     ChildCronTask[]|ObjectCollection findByIdCronTask(int $id_cron_task) Return ChildCronTask objects filtered by the id_cron_task column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskCode(string $cron_task_code) Return ChildCronTask objects filtered by the cron_task_code column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskInterval(int $cron_task_interval) Return ChildCronTask objects filtered by the cron_task_interval column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskParams(string $cron_task_params) Return ChildCronTask objects filtered by the cron_task_params column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskActive(boolean $cron_task_active) Return ChildCronTask objects filtered by the cron_task_active column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskState(string $cron_task_state) Return ChildCronTask objects filtered by the cron_task_state column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskRunAt(string $cron_task_run_at) Return ChildCronTask objects filtered by the cron_task_run_at column
 * @method     ChildCronTask[]|ObjectCollection findByCronTaskExecutedAt(string $cron_task_executed_at) Return ChildCronTask objects filtered by the cron_task_executed_at column
 * @method     ChildCronTask[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildCronTask objects filtered by the created_at column
 * @method     ChildCronTask[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildCronTask objects filtered by the updated_at column
 * @method     ChildCronTask[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CronTaskQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\CronTaskQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\CronTask', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCronTaskQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCronTaskQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCronTaskQuery) {
            return $criteria;
        }
        $query = new ChildCronTaskQuery();
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
     * @return ChildCronTask|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CronTaskTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CronTaskTableMap::DATABASE_NAME);
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
     * @return ChildCronTask A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_CRON_TASK, CRON_TASK_CODE, CRON_TASK_INTERVAL, CRON_TASK_PARAMS, CRON_TASK_ACTIVE, CRON_TASK_STATE, CRON_TASK_RUN_AT, CRON_TASK_EXECUTED_AT, CREATED_AT, UPDATED_AT FROM cron_task WHERE ID_CRON_TASK = :p0';
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
            /** @var ChildCronTask $obj */
            $obj = new ChildCronTask();
            $obj->hydrate($row);
            CronTaskTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCronTask|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CronTaskTableMap::COL_ID_CRON_TASK, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CronTaskTableMap::COL_ID_CRON_TASK, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_cron_task column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCronTask(1234); // WHERE id_cron_task = 1234
     * $query->filterByIdCronTask(array(12, 34)); // WHERE id_cron_task IN (12, 34)
     * $query->filterByIdCronTask(array('min' => 12)); // WHERE id_cron_task > 12
     * </code>
     *
     * @param     mixed $idCronTask The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByIdCronTask($idCronTask = null, $comparison = null)
    {
        if (is_array($idCronTask)) {
            $useMinMax = false;
            if (isset($idCronTask['min'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_ID_CRON_TASK, $idCronTask['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCronTask['max'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_ID_CRON_TASK, $idCronTask['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_ID_CRON_TASK, $idCronTask, $comparison);
    }

    /**
     * Filter the query on the cron_task_code column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskCode('fooValue');   // WHERE cron_task_code = 'fooValue'
     * $query->filterByCronTaskCode('%fooValue%'); // WHERE cron_task_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cronTaskCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskCode($cronTaskCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cronTaskCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cronTaskCode)) {
                $cronTaskCode = str_replace('*', '%', $cronTaskCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_CODE, $cronTaskCode, $comparison);
    }

    /**
     * Filter the query on the cron_task_interval column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskInterval(1234); // WHERE cron_task_interval = 1234
     * $query->filterByCronTaskInterval(array(12, 34)); // WHERE cron_task_interval IN (12, 34)
     * $query->filterByCronTaskInterval(array('min' => 12)); // WHERE cron_task_interval > 12
     * </code>
     *
     * @param     mixed $cronTaskInterval The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskInterval($cronTaskInterval = null, $comparison = null)
    {
        if (is_array($cronTaskInterval)) {
            $useMinMax = false;
            if (isset($cronTaskInterval['min'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_INTERVAL, $cronTaskInterval['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cronTaskInterval['max'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_INTERVAL, $cronTaskInterval['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_INTERVAL, $cronTaskInterval, $comparison);
    }

    /**
     * Filter the query on the cron_task_params column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskParams('fooValue');   // WHERE cron_task_params = 'fooValue'
     * $query->filterByCronTaskParams('%fooValue%'); // WHERE cron_task_params LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cronTaskParams The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskParams($cronTaskParams = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cronTaskParams)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cronTaskParams)) {
                $cronTaskParams = str_replace('*', '%', $cronTaskParams);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_PARAMS, $cronTaskParams, $comparison);
    }

    /**
     * Filter the query on the cron_task_active column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskActive(true); // WHERE cron_task_active = true
     * $query->filterByCronTaskActive('yes'); // WHERE cron_task_active = true
     * </code>
     *
     * @param     boolean|string $cronTaskActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskActive($cronTaskActive = null, $comparison = null)
    {
        if (is_string($cronTaskActive)) {
            $cronTaskActive = in_array(strtolower($cronTaskActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_ACTIVE, $cronTaskActive, $comparison);
    }

    /**
     * Filter the query on the cron_task_state column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskState('fooValue');   // WHERE cron_task_state = 'fooValue'
     * $query->filterByCronTaskState('%fooValue%'); // WHERE cron_task_state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cronTaskState The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskState($cronTaskState = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cronTaskState)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cronTaskState)) {
                $cronTaskState = str_replace('*', '%', $cronTaskState);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_STATE, $cronTaskState, $comparison);
    }

    /**
     * Filter the query on the cron_task_run_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskRunAt('2011-03-14'); // WHERE cron_task_run_at = '2011-03-14'
     * $query->filterByCronTaskRunAt('now'); // WHERE cron_task_run_at = '2011-03-14'
     * $query->filterByCronTaskRunAt(array('max' => 'yesterday')); // WHERE cron_task_run_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $cronTaskRunAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskRunAt($cronTaskRunAt = null, $comparison = null)
    {
        if (is_array($cronTaskRunAt)) {
            $useMinMax = false;
            if (isset($cronTaskRunAt['min'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_RUN_AT, $cronTaskRunAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cronTaskRunAt['max'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_RUN_AT, $cronTaskRunAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_RUN_AT, $cronTaskRunAt, $comparison);
    }

    /**
     * Filter the query on the cron_task_executed_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCronTaskExecutedAt('2011-03-14'); // WHERE cron_task_executed_at = '2011-03-14'
     * $query->filterByCronTaskExecutedAt('now'); // WHERE cron_task_executed_at = '2011-03-14'
     * $query->filterByCronTaskExecutedAt(array('max' => 'yesterday')); // WHERE cron_task_executed_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $cronTaskExecutedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCronTaskExecutedAt($cronTaskExecutedAt = null, $comparison = null)
    {
        if (is_array($cronTaskExecutedAt)) {
            $useMinMax = false;
            if (isset($cronTaskExecutedAt['min'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_EXECUTED_AT, $cronTaskExecutedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cronTaskExecutedAt['max'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_EXECUTED_AT, $cronTaskExecutedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CRON_TASK_EXECUTED_AT, $cronTaskExecutedAt, $comparison);
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
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CronTaskTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CronTaskTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCronTask $cronTask Object to remove from the list of results
     *
     * @return $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function prune($cronTask = null)
    {
        if ($cronTask) {
            $this->addUsingAlias(CronTaskTableMap::COL_ID_CRON_TASK, $cronTask->getIdCronTask(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cron_task table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CronTaskTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CronTaskTableMap::clearInstancePool();
            CronTaskTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CronTaskTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CronTaskTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CronTaskTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CronTaskTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CronTaskTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CronTaskTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CronTaskTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CronTaskTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CronTaskTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildCronTaskQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CronTaskTableMap::COL_CREATED_AT);
    }

} // CronTaskQuery
