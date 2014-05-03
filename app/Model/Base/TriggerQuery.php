<?php

namespace app\Model\Base;

use \Exception;
use \PDO;
use App\Model\Trigger as ChildTrigger;
use App\Model\TriggerQuery as ChildTriggerQuery;
use App\Model\Map\TriggerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trigger' table.
 *
 *
 *
 * @method     ChildTriggerQuery orderByIdTrigger($order = Criteria::ASC) Order by the id_trigger column
 * @method     ChildTriggerQuery orderByTargetId($order = Criteria::ASC) Order by the target_id column
 * @method     ChildTriggerQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildTriggerQuery orderByTriggerTypeId($order = Criteria::ASC) Order by the trigger_type_id column
 * @method     ChildTriggerQuery orderByTriggerParams($order = Criteria::ASC) Order by the trigger_params column
 * @method     ChildTriggerQuery orderByTriggerInvokeOn($order = Criteria::ASC) Order by the trigger_invoke_on column
 * @method     ChildTriggerQuery orderByTriggerName($order = Criteria::ASC) Order by the trigger_name column
 * @method     ChildTriggerQuery orderByTriggerActive($order = Criteria::ASC) Order by the trigger_active column
 * @method     ChildTriggerQuery orderByTriggerLastExecutedAt($order = Criteria::ASC) Order by the trigger_last_executed_at column
 * @method     ChildTriggerQuery orderByTriggerLastExecutedResult($order = Criteria::ASC) Order by the trigger_last_executed_result column
 * @method     ChildTriggerQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTriggerQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTriggerQuery groupByIdTrigger() Group by the id_trigger column
 * @method     ChildTriggerQuery groupByTargetId() Group by the target_id column
 * @method     ChildTriggerQuery groupByUserId() Group by the user_id column
 * @method     ChildTriggerQuery groupByTriggerTypeId() Group by the trigger_type_id column
 * @method     ChildTriggerQuery groupByTriggerParams() Group by the trigger_params column
 * @method     ChildTriggerQuery groupByTriggerInvokeOn() Group by the trigger_invoke_on column
 * @method     ChildTriggerQuery groupByTriggerName() Group by the trigger_name column
 * @method     ChildTriggerQuery groupByTriggerActive() Group by the trigger_active column
 * @method     ChildTriggerQuery groupByTriggerLastExecutedAt() Group by the trigger_last_executed_at column
 * @method     ChildTriggerQuery groupByTriggerLastExecutedResult() Group by the trigger_last_executed_result column
 * @method     ChildTriggerQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTriggerQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTriggerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTriggerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTriggerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTriggerQuery leftJoinTarget($relationAlias = null) Adds a LEFT JOIN clause to the query using the Target relation
 * @method     ChildTriggerQuery rightJoinTarget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Target relation
 * @method     ChildTriggerQuery innerJoinTarget($relationAlias = null) Adds a INNER JOIN clause to the query using the Target relation
 *
 * @method     ChildTriggerQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildTriggerQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildTriggerQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildTriggerQuery leftJoinTriggerType($relationAlias = null) Adds a LEFT JOIN clause to the query using the TriggerType relation
 * @method     ChildTriggerQuery rightJoinTriggerType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TriggerType relation
 * @method     ChildTriggerQuery innerJoinTriggerType($relationAlias = null) Adds a INNER JOIN clause to the query using the TriggerType relation
 *
 * @method     ChildTriggerQuery leftJoinTriggerLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the TriggerLog relation
 * @method     ChildTriggerQuery rightJoinTriggerLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TriggerLog relation
 * @method     ChildTriggerQuery innerJoinTriggerLog($relationAlias = null) Adds a INNER JOIN clause to the query using the TriggerLog relation
 *
 * @method     \App\Model\TargetQuery|\App\Model\UserQuery|\App\Model\TriggerTypeQuery|\App\Model\TriggerLogQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTrigger findOne(ConnectionInterface $con = null) Return the first ChildTrigger matching the query
 * @method     ChildTrigger findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTrigger matching the query, or a new ChildTrigger object populated from the query conditions when no match is found
 *
 * @method     ChildTrigger findOneByIdTrigger(int $id_trigger) Return the first ChildTrigger filtered by the id_trigger column
 * @method     ChildTrigger findOneByTargetId(int $target_id) Return the first ChildTrigger filtered by the target_id column
 * @method     ChildTrigger findOneByUserId(int $user_id) Return the first ChildTrigger filtered by the user_id column
 * @method     ChildTrigger findOneByTriggerTypeId(int $trigger_type_id) Return the first ChildTrigger filtered by the trigger_type_id column
 * @method     ChildTrigger findOneByTriggerParams(string $trigger_params) Return the first ChildTrigger filtered by the trigger_params column
 * @method     ChildTrigger findOneByTriggerInvokeOn(array $trigger_invoke_on) Return the first ChildTrigger filtered by the trigger_invoke_on column
 * @method     ChildTrigger findOneByTriggerName(string $trigger_name) Return the first ChildTrigger filtered by the trigger_name column
 * @method     ChildTrigger findOneByTriggerActive(boolean $trigger_active) Return the first ChildTrigger filtered by the trigger_active column
 * @method     ChildTrigger findOneByTriggerLastExecutedAt(string $trigger_last_executed_at) Return the first ChildTrigger filtered by the trigger_last_executed_at column
 * @method     ChildTrigger findOneByTriggerLastExecutedResult(string $trigger_last_executed_result) Return the first ChildTrigger filtered by the trigger_last_executed_result column
 * @method     ChildTrigger findOneByCreatedAt(string $created_at) Return the first ChildTrigger filtered by the created_at column
 * @method     ChildTrigger findOneByUpdatedAt(string $updated_at) Return the first ChildTrigger filtered by the updated_at column
 *
 * @method     ChildTrigger[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTrigger objects based on current ModelCriteria
 * @method     ChildTrigger[]|ObjectCollection findByIdTrigger(int $id_trigger) Return ChildTrigger objects filtered by the id_trigger column
 * @method     ChildTrigger[]|ObjectCollection findByTargetId(int $target_id) Return ChildTrigger objects filtered by the target_id column
 * @method     ChildTrigger[]|ObjectCollection findByUserId(int $user_id) Return ChildTrigger objects filtered by the user_id column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerTypeId(int $trigger_type_id) Return ChildTrigger objects filtered by the trigger_type_id column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerParams(string $trigger_params) Return ChildTrigger objects filtered by the trigger_params column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerInvokeOn(array $trigger_invoke_on) Return ChildTrigger objects filtered by the trigger_invoke_on column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerName(string $trigger_name) Return ChildTrigger objects filtered by the trigger_name column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerActive(boolean $trigger_active) Return ChildTrigger objects filtered by the trigger_active column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerLastExecutedAt(string $trigger_last_executed_at) Return ChildTrigger objects filtered by the trigger_last_executed_at column
 * @method     ChildTrigger[]|ObjectCollection findByTriggerLastExecutedResult(string $trigger_last_executed_result) Return ChildTrigger objects filtered by the trigger_last_executed_result column
 * @method     ChildTrigger[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTrigger objects filtered by the created_at column
 * @method     ChildTrigger[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTrigger objects filtered by the updated_at column
 * @method     ChildTrigger[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TriggerQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\TriggerQuery object.
     *
     * @param string $dbName     The database name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\Trigger', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTriggerQuery object.
     *
     * @param string   $modelAlias The alias of a model in the query
     * @param Criteria $criteria   Optional Criteria to build the query from
     *
     * @return ChildTriggerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTriggerQuery) {
            return $criteria;
        }
        $query = new ChildTriggerQuery();
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
     * @return ChildTrigger|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TriggerTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TriggerTableMap::DATABASE_NAME);
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
     * @param mixed               $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildTrigger A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_TRIGGER, TARGET_ID, USER_ID, TRIGGER_TYPE_ID, TRIGGER_PARAMS, TRIGGER_INVOKE_ON, TRIGGER_NAME, TRIGGER_ACTIVE, TRIGGER_LAST_EXECUTED_AT, TRIGGER_LAST_EXECUTED_RESULT, CREATED_AT, UPDATED_AT FROM trigger WHERE ID_TRIGGER = :p0';
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
            /** @var ChildTrigger $obj */
            $obj = new ChildTrigger();
            $obj->hydrate($row);
            TriggerTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed               $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildTrigger|array|mixed the result, formatted by the current formatter
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
     * @param array               $keys Primary keys to use for the query
     * @param ConnectionInterface $con  an optional connection object
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_trigger column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTrigger(1234); // WHERE id_trigger = 1234
     * $query->filterByIdTrigger(array(12, 34)); // WHERE id_trigger IN (12, 34)
     * $query->filterByIdTrigger(array('min' => 12)); // WHERE id_trigger > 12
     * </code>
     *
     * @param mixed  $idTrigger  The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByIdTrigger($idTrigger = null, $comparison = null)
    {
        if (is_array($idTrigger)) {
            $useMinMax = false;
            if (isset($idTrigger['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $idTrigger['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTrigger['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $idTrigger['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $idTrigger, $comparison);
    }

    /**
     * Filter the query on the target_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTargetId(1234); // WHERE target_id = 1234
     * $query->filterByTargetId(array(12, 34)); // WHERE target_id IN (12, 34)
     * $query->filterByTargetId(array('min' => 12)); // WHERE target_id > 12
     * </code>
     *
     * @see       filterByTarget()
     *
     * @param mixed  $targetId   The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTargetId($targetId = null, $comparison = null)
    {
        if (is_array($targetId)) {
            $useMinMax = false;
            if (isset($targetId['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_TARGET_ID, $targetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetId['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_TARGET_ID, $targetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TARGET_ID, $targetId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param mixed  $userId     The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the trigger_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerTypeId(1234); // WHERE trigger_type_id = 1234
     * $query->filterByTriggerTypeId(array(12, 34)); // WHERE trigger_type_id IN (12, 34)
     * $query->filterByTriggerTypeId(array('min' => 12)); // WHERE trigger_type_id > 12
     * </code>
     *
     * @see       filterByTriggerType()
     *
     * @param mixed  $triggerTypeId The value to use as filter.
     *                              Use scalar values for equality.
     *                              Use array values for in_array() equivalent.
     *                              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison    Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerTypeId($triggerTypeId = null, $comparison = null)
    {
        if (is_array($triggerTypeId)) {
            $useMinMax = false;
            if (isset($triggerTypeId['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_TYPE_ID, $triggerTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($triggerTypeId['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_TYPE_ID, $triggerTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_TYPE_ID, $triggerTypeId, $comparison);
    }

    /**
     * Filter the query on the trigger_params column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerParams('fooValue');   // WHERE trigger_params = 'fooValue'
     * $query->filterByTriggerParams('%fooValue%'); // WHERE trigger_params LIKE '%fooValue%'
     * </code>
     *
     * @param string $triggerParams The value to use as filter.
     *                              Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison    Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerParams($triggerParams = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerParams)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerParams)) {
                $triggerParams = str_replace('*', '%', $triggerParams);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_PARAMS, $triggerParams, $comparison);
    }

    /**
     * Filter the query on the trigger_invoke_on column
     *
     * @param array  $triggerInvokeOn The values to use as filter.
     * @param string $comparison      Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerInvokeOn($triggerInvokeOn = null, $comparison = null)
    {
        $key = $this->getAliasedColName(TriggerTableMap::COL_TRIGGER_INVOKE_ON);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($triggerInvokeOn as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($triggerInvokeOn as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($triggerInvokeOn as $value) {
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

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_INVOKE_ON, $triggerInvokeOn, $comparison);
    }

    /**
     * Filter the query on the trigger_name column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerName('fooValue');   // WHERE trigger_name = 'fooValue'
     * $query->filterByTriggerName('%fooValue%'); // WHERE trigger_name LIKE '%fooValue%'
     * </code>
     *
     * @param string $triggerName The value to use as filter.
     *                            Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison  Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerName($triggerName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerName)) {
                $triggerName = str_replace('*', '%', $triggerName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_NAME, $triggerName, $comparison);
    }

    /**
     * Filter the query on the trigger_active column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerActive(true); // WHERE trigger_active = true
     * $query->filterByTriggerActive('yes'); // WHERE trigger_active = true
     * </code>
     *
     * @param boolean|string $triggerActive The value to use as filter.
     *                                      Non-boolean arguments are converted using the following rules:
     *                                      * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                                      * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *                                      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string         $comparison    Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerActive($triggerActive = null, $comparison = null)
    {
        if (is_string($triggerActive)) {
            $triggerActive = in_array(strtolower($triggerActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_ACTIVE, $triggerActive, $comparison);
    }

    /**
     * Filter the query on the trigger_last_executed_at column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerLastExecutedAt('2011-03-14'); // WHERE trigger_last_executed_at = '2011-03-14'
     * $query->filterByTriggerLastExecutedAt('now'); // WHERE trigger_last_executed_at = '2011-03-14'
     * $query->filterByTriggerLastExecutedAt(array('max' => 'yesterday')); // WHERE trigger_last_executed_at > '2011-03-13'
     * </code>
     *
     * @param mixed  $triggerLastExecutedAt The value to use as filter.
     *                                      Values can be integers (unix timestamps), DateTime objects, or strings.
     *                                      Empty strings are treated as NULL.
     *                                      Use scalar values for equality.
     *                                      Use array values for in_array() equivalent.
     *                                      Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison            Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerLastExecutedAt($triggerLastExecutedAt = null, $comparison = null)
    {
        if (is_array($triggerLastExecutedAt)) {
            $useMinMax = false;
            if (isset($triggerLastExecutedAt['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT, $triggerLastExecutedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($triggerLastExecutedAt['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT, $triggerLastExecutedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_AT, $triggerLastExecutedAt, $comparison);
    }

    /**
     * Filter the query on the trigger_last_executed_result column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerLastExecutedResult('fooValue');   // WHERE trigger_last_executed_result = 'fooValue'
     * $query->filterByTriggerLastExecutedResult('%fooValue%'); // WHERE trigger_last_executed_result LIKE '%fooValue%'
     * </code>
     *
     * @param string $triggerLastExecutedResult The value to use as filter.
     *                                          Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison                Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerLastExecutedResult($triggerLastExecutedResult = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerLastExecutedResult)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerLastExecutedResult)) {
                $triggerLastExecutedResult = str_replace('*', '%', $triggerLastExecutedResult);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_TRIGGER_LAST_EXECUTED_RESULT, $triggerLastExecutedResult, $comparison);
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
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TriggerTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TriggerTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Target object
     *
     * @param \App\Model\Target|ObjectCollection $target     The related object(s) to use as filter
     * @param string                             $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTarget($target, $comparison = null)
    {
        if ($target instanceof \App\Model\Target) {
            return $this
                ->addUsingAlias(TriggerTableMap::COL_TARGET_ID, $target->getIdTarget(), $comparison);
        } elseif ($target instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerTableMap::COL_TARGET_ID, $target->toKeyValue('PrimaryKey', 'IdTarget'), $comparison);
        } else {
            throw new PropelException('filterByTarget() only accepts arguments of type \App\Model\Target or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Target relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function joinTarget($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Target');

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
            $this->addJoinObject($join, 'Target');
        }

        return $this;
    }

    /**
     * Use the Target relation Target object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TargetQuery A secondary query class using the current class as primary query
     */
    public function useTargetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTarget($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Target', '\App\Model\TargetQuery');
    }

    /**
     * Filter the query by a related \App\Model\User object
     *
     * @param \App\Model\User|ObjectCollection $user       The related object(s) to use as filter
     * @param string                           $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \App\Model\User) {
            return $this
                ->addUsingAlias(TriggerTableMap::COL_USER_ID, $user->getIdUser(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
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
     * @return $this|ChildTriggerQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Model\TriggerType object
     *
     * @param \App\Model\TriggerType|ObjectCollection $triggerType The related object(s) to use as filter
     * @param string                                  $comparison  Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerType($triggerType, $comparison = null)
    {
        if ($triggerType instanceof \App\Model\TriggerType) {
            return $this
                ->addUsingAlias(TriggerTableMap::COL_TRIGGER_TYPE_ID, $triggerType->getIdTriggerType(), $comparison);
        } elseif ($triggerType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerTableMap::COL_TRIGGER_TYPE_ID, $triggerType->toKeyValue('PrimaryKey', 'IdTriggerType'), $comparison);
        } else {
            throw new PropelException('filterByTriggerType() only accepts arguments of type \App\Model\TriggerType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TriggerType relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function joinTriggerType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TriggerType');

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
            $this->addJoinObject($join, 'TriggerType');
        }

        return $this;
    }

    /**
     * Use the TriggerType relation TriggerType object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TriggerTypeQuery A secondary query class using the current class as primary query
     */
    public function useTriggerTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTriggerType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TriggerType', '\App\Model\TriggerTypeQuery');
    }

    /**
     * Filter the query by a related \App\Model\TriggerLog object
     *
     * @param \App\Model\TriggerLog|ObjectCollection $triggerLog the related object to use as filter
     * @param string                                 $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerQuery The current query, for fluid interface
     */
    public function filterByTriggerLog($triggerLog, $comparison = null)
    {
        if ($triggerLog instanceof \App\Model\TriggerLog) {
            return $this
                ->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $triggerLog->getTriggerId(), $comparison);
        } elseif ($triggerLog instanceof ObjectCollection) {
            return $this
                ->useTriggerLogQuery()
                ->filterByPrimaryKeys($triggerLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTriggerLog() only accepts arguments of type \App\Model\TriggerLog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TriggerLog relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function joinTriggerLog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TriggerLog');

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
            $this->addJoinObject($join, 'TriggerLog');
        }

        return $this;
    }

    /**
     * Use the TriggerLog relation TriggerLog object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TriggerLogQuery A secondary query class using the current class as primary query
     */
    public function useTriggerLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTriggerLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TriggerLog', '\App\Model\TriggerLogQuery');
    }

    /**
     * Exclude object from result
     *
     * @param ChildTrigger $trigger Object to remove from the list of results
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function prune($trigger = null)
    {
        if ($trigger) {
            $this->addUsingAlias(TriggerTableMap::COL_ID_TRIGGER, $trigger->getIdTrigger(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trigger table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TriggerTableMap::clearInstancePool();
            TriggerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TriggerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TriggerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TriggerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TriggerTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TriggerTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TriggerTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TriggerTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TriggerTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return $this|ChildTriggerQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TriggerTableMap::COL_CREATED_AT);
    }

} // TriggerQuery
