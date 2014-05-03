<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\StackTestResultFail as ChildStackTestResultFail;
use App\Model\StackTestResultFailQuery as ChildStackTestResultFailQuery;
use App\Model\Map\StackTestResultFailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'stack_test_result_fail' table.
 *
 *
 *
 * @method     ChildStackTestResultFailQuery orderByIdTestResultFail($order = Criteria::ASC) Order by the id_test_result_fail column
 * @method     ChildStackTestResultFailQuery orderByTargetId($order = Criteria::ASC) Order by the target_id column
 * @method     ChildStackTestResultFailQuery orderByTargetGroupId($order = Criteria::ASC) Order by the target_group_id column
 * @method     ChildStackTestResultFailQuery orderByTargetTypeId($order = Criteria::ASC) Order by the target_type_id column
 * @method     ChildStackTestResultFailQuery orderByStackTestResultFailInfo($order = Criteria::ASC) Order by the stack_test_result_fail_info column
 * @method     ChildStackTestResultFailQuery orderByStackTestResultFailPriority($order = Criteria::ASC) Order by the stack_test_result_fail_priority column
 * @method     ChildStackTestResultFailQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStackTestResultFailQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildStackTestResultFailQuery groupByIdTestResultFail() Group by the id_test_result_fail column
 * @method     ChildStackTestResultFailQuery groupByTargetId() Group by the target_id column
 * @method     ChildStackTestResultFailQuery groupByTargetGroupId() Group by the target_group_id column
 * @method     ChildStackTestResultFailQuery groupByTargetTypeId() Group by the target_type_id column
 * @method     ChildStackTestResultFailQuery groupByStackTestResultFailInfo() Group by the stack_test_result_fail_info column
 * @method     ChildStackTestResultFailQuery groupByStackTestResultFailPriority() Group by the stack_test_result_fail_priority column
 * @method     ChildStackTestResultFailQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStackTestResultFailQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildStackTestResultFailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStackTestResultFailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStackTestResultFailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStackTestResultFailQuery leftJoinTargetRelatedByTargetId($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetRelatedByTargetId relation
 * @method     ChildStackTestResultFailQuery rightJoinTargetRelatedByTargetId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetRelatedByTargetId relation
 * @method     ChildStackTestResultFailQuery innerJoinTargetRelatedByTargetId($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetRelatedByTargetId relation
 *
 * @method     ChildStackTestResultFailQuery leftJoinTargetRelatedByTargetGroupId($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetRelatedByTargetGroupId relation
 * @method     ChildStackTestResultFailQuery rightJoinTargetRelatedByTargetGroupId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetRelatedByTargetGroupId relation
 * @method     ChildStackTestResultFailQuery innerJoinTargetRelatedByTargetGroupId($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetRelatedByTargetGroupId relation
 *
 * @method     ChildStackTestResultFailQuery leftJoinTargetRelatedByTargetTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetRelatedByTargetTypeId relation
 * @method     ChildStackTestResultFailQuery rightJoinTargetRelatedByTargetTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetRelatedByTargetTypeId relation
 * @method     ChildStackTestResultFailQuery innerJoinTargetRelatedByTargetTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetRelatedByTargetTypeId relation
 *
 * @method     \App\Model\TargetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStackTestResultFail findOne(ConnectionInterface $con = null) Return the first ChildStackTestResultFail matching the query
 * @method     ChildStackTestResultFail findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStackTestResultFail matching the query, or a new ChildStackTestResultFail object populated from the query conditions when no match is found
 *
 * @method     ChildStackTestResultFail findOneByIdTestResultFail(int $id_test_result_fail) Return the first ChildStackTestResultFail filtered by the id_test_result_fail column
 * @method     ChildStackTestResultFail findOneByTargetId(int $target_id) Return the first ChildStackTestResultFail filtered by the target_id column
 * @method     ChildStackTestResultFail findOneByTargetGroupId(int $target_group_id) Return the first ChildStackTestResultFail filtered by the target_group_id column
 * @method     ChildStackTestResultFail findOneByTargetTypeId(int $target_type_id) Return the first ChildStackTestResultFail filtered by the target_type_id column
 * @method     ChildStackTestResultFail findOneByStackTestResultFailInfo(string $stack_test_result_fail_info) Return the first ChildStackTestResultFail filtered by the stack_test_result_fail_info column
 * @method     ChildStackTestResultFail findOneByStackTestResultFailPriority(boolean $stack_test_result_fail_priority) Return the first ChildStackTestResultFail filtered by the stack_test_result_fail_priority column
 * @method     ChildStackTestResultFail findOneByCreatedAt(string $created_at) Return the first ChildStackTestResultFail filtered by the created_at column
 * @method     ChildStackTestResultFail findOneByUpdatedAt(string $updated_at) Return the first ChildStackTestResultFail filtered by the updated_at column
 *
 * @method     ChildStackTestResultFail[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStackTestResultFail objects based on current ModelCriteria
 * @method     ChildStackTestResultFail[]|ObjectCollection findByIdTestResultFail(int $id_test_result_fail) Return ChildStackTestResultFail objects filtered by the id_test_result_fail column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByTargetId(int $target_id) Return ChildStackTestResultFail objects filtered by the target_id column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByTargetGroupId(int $target_group_id) Return ChildStackTestResultFail objects filtered by the target_group_id column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByTargetTypeId(int $target_type_id) Return ChildStackTestResultFail objects filtered by the target_type_id column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByStackTestResultFailInfo(string $stack_test_result_fail_info) Return ChildStackTestResultFail objects filtered by the stack_test_result_fail_info column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByStackTestResultFailPriority(boolean $stack_test_result_fail_priority) Return ChildStackTestResultFail objects filtered by the stack_test_result_fail_priority column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildStackTestResultFail objects filtered by the created_at column
 * @method     ChildStackTestResultFail[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildStackTestResultFail objects filtered by the updated_at column
 * @method     ChildStackTestResultFail[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StackTestResultFailQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\StackTestResultFailQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\StackTestResultFail', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStackTestResultFailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStackTestResultFailQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStackTestResultFailQuery) {
            return $criteria;
        }
        $query = new ChildStackTestResultFailQuery();
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
     * @return ChildStackTestResultFail|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StackTestResultFailTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StackTestResultFailTableMap::DATABASE_NAME);
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
     * @return ChildStackTestResultFail A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_TEST_RESULT_FAIL, TARGET_ID, TARGET_GROUP_ID, TARGET_TYPE_ID, STACK_TEST_RESULT_FAIL_INFO, STACK_TEST_RESULT_FAIL_PRIORITY, CREATED_AT, UPDATED_AT FROM stack_test_result_fail WHERE ID_TEST_RESULT_FAIL = :p0';
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
            /** @var ChildStackTestResultFail $obj */
            $obj = new ChildStackTestResultFail();
            $obj->hydrate($row);
            StackTestResultFailTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStackTestResultFail|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_test_result_fail column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTestResultFail(1234); // WHERE id_test_result_fail = 1234
     * $query->filterByIdTestResultFail(array(12, 34)); // WHERE id_test_result_fail IN (12, 34)
     * $query->filterByIdTestResultFail(array('min' => 12)); // WHERE id_test_result_fail > 12
     * </code>
     *
     * @param     mixed $idTestResultFail The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByIdTestResultFail($idTestResultFail = null, $comparison = null)
    {
        if (is_array($idTestResultFail)) {
            $useMinMax = false;
            if (isset($idTestResultFail['min'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $idTestResultFail['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTestResultFail['max'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $idTestResultFail['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $idTestResultFail, $comparison);
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
     * @see       filterByTargetRelatedByTargetId()
     *
     * @param     mixed $targetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByTargetId($targetId = null, $comparison = null)
    {
        if (is_array($targetId)) {
            $useMinMax = false;
            if (isset($targetId['min'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_ID, $targetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetId['max'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_ID, $targetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_ID, $targetId, $comparison);
    }

    /**
     * Filter the query on the target_group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTargetGroupId(1234); // WHERE target_group_id = 1234
     * $query->filterByTargetGroupId(array(12, 34)); // WHERE target_group_id IN (12, 34)
     * $query->filterByTargetGroupId(array('min' => 12)); // WHERE target_group_id > 12
     * </code>
     *
     * @see       filterByTargetRelatedByTargetGroupId()
     *
     * @param     mixed $targetGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByTargetGroupId($targetGroupId = null, $comparison = null)
    {
        if (is_array($targetGroupId)) {
            $useMinMax = false;
            if (isset($targetGroupId['min'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_GROUP_ID, $targetGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetGroupId['max'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_GROUP_ID, $targetGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_GROUP_ID, $targetGroupId, $comparison);
    }

    /**
     * Filter the query on the target_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTargetTypeId(1234); // WHERE target_type_id = 1234
     * $query->filterByTargetTypeId(array(12, 34)); // WHERE target_type_id IN (12, 34)
     * $query->filterByTargetTypeId(array('min' => 12)); // WHERE target_type_id > 12
     * </code>
     *
     * @see       filterByTargetRelatedByTargetTypeId()
     *
     * @param     mixed $targetTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByTargetTypeId($targetTypeId = null, $comparison = null)
    {
        if (is_array($targetTypeId)) {
            $useMinMax = false;
            if (isset($targetTypeId['min'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_TYPE_ID, $targetTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetTypeId['max'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_TYPE_ID, $targetTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_TYPE_ID, $targetTypeId, $comparison);
    }

    /**
     * Filter the query on the stack_test_result_fail_info column
     *
     * Example usage:
     * <code>
     * $query->filterByStackTestResultFailInfo('fooValue');   // WHERE stack_test_result_fail_info = 'fooValue'
     * $query->filterByStackTestResultFailInfo('%fooValue%'); // WHERE stack_test_result_fail_info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stackTestResultFailInfo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByStackTestResultFailInfo($stackTestResultFailInfo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stackTestResultFailInfo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stackTestResultFailInfo)) {
                $stackTestResultFailInfo = str_replace('*', '%', $stackTestResultFailInfo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_INFO, $stackTestResultFailInfo, $comparison);
    }

    /**
     * Filter the query on the stack_test_result_fail_priority column
     *
     * Example usage:
     * <code>
     * $query->filterByStackTestResultFailPriority(true); // WHERE stack_test_result_fail_priority = true
     * $query->filterByStackTestResultFailPriority('yes'); // WHERE stack_test_result_fail_priority = true
     * </code>
     *
     * @param     boolean|string $stackTestResultFailPriority The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByStackTestResultFailPriority($stackTestResultFailPriority = null, $comparison = null)
    {
        if (is_string($stackTestResultFailPriority)) {
            $stackTestResultFailPriority = in_array(strtolower($stackTestResultFailPriority), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_STACK_TEST_RESULT_FAIL_PRIORITY, $stackTestResultFailPriority, $comparison);
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
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StackTestResultFailTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultFailTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Target object
     *
     * @param \App\Model\Target|ObjectCollection $target The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByTargetRelatedByTargetId($target, $comparison = null)
    {
        if ($target instanceof \App\Model\Target) {
            return $this
                ->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_ID, $target->getIdTarget(), $comparison);
        } elseif ($target instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_ID, $target->toKeyValue('PrimaryKey', 'IdTarget'), $comparison);
        } else {
            throw new PropelException('filterByTargetRelatedByTargetId() only accepts arguments of type \App\Model\Target or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetRelatedByTargetId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function joinTargetRelatedByTargetId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TargetRelatedByTargetId');

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
            $this->addJoinObject($join, 'TargetRelatedByTargetId');
        }

        return $this;
    }

    /**
     * Use the TargetRelatedByTargetId relation Target object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TargetQuery A secondary query class using the current class as primary query
     */
    public function useTargetRelatedByTargetIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTargetRelatedByTargetId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TargetRelatedByTargetId', '\App\Model\TargetQuery');
    }

    /**
     * Filter the query by a related \App\Model\Target object
     *
     * @param \App\Model\Target|ObjectCollection $target The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByTargetRelatedByTargetGroupId($target, $comparison = null)
    {
        if ($target instanceof \App\Model\Target) {
            return $this
                ->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_GROUP_ID, $target->getTargetGroupId(), $comparison);
        } elseif ($target instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_GROUP_ID, $target->toKeyValue('PrimaryKey', 'TargetGroupId'), $comparison);
        } else {
            throw new PropelException('filterByTargetRelatedByTargetGroupId() only accepts arguments of type \App\Model\Target or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetRelatedByTargetGroupId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function joinTargetRelatedByTargetGroupId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TargetRelatedByTargetGroupId');

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
            $this->addJoinObject($join, 'TargetRelatedByTargetGroupId');
        }

        return $this;
    }

    /**
     * Use the TargetRelatedByTargetGroupId relation Target object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TargetQuery A secondary query class using the current class as primary query
     */
    public function useTargetRelatedByTargetGroupIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTargetRelatedByTargetGroupId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TargetRelatedByTargetGroupId', '\App\Model\TargetQuery');
    }

    /**
     * Filter the query by a related \App\Model\Target object
     *
     * @param \App\Model\Target|ObjectCollection $target The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function filterByTargetRelatedByTargetTypeId($target, $comparison = null)
    {
        if ($target instanceof \App\Model\Target) {
            return $this
                ->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_TYPE_ID, $target->getTargetTypeId(), $comparison);
        } elseif ($target instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StackTestResultFailTableMap::COL_TARGET_TYPE_ID, $target->toKeyValue('PrimaryKey', 'TargetTypeId'), $comparison);
        } else {
            throw new PropelException('filterByTargetRelatedByTargetTypeId() only accepts arguments of type \App\Model\Target or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetRelatedByTargetTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function joinTargetRelatedByTargetTypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TargetRelatedByTargetTypeId');

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
            $this->addJoinObject($join, 'TargetRelatedByTargetTypeId');
        }

        return $this;
    }

    /**
     * Use the TargetRelatedByTargetTypeId relation Target object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TargetQuery A secondary query class using the current class as primary query
     */
    public function useTargetRelatedByTargetTypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTargetRelatedByTargetTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TargetRelatedByTargetTypeId', '\App\Model\TargetQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStackTestResultFail $stackTestResultFail Object to remove from the list of results
     *
     * @return $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function prune($stackTestResultFail = null)
    {
        if ($stackTestResultFail) {
            $this->addUsingAlias(StackTestResultFailTableMap::COL_ID_TEST_RESULT_FAIL, $stackTestResultFail->getIdTestResultFail(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stack_test_result_fail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StackTestResultFailTableMap::clearInstancePool();
            StackTestResultFailTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultFailTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StackTestResultFailTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StackTestResultFailTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StackTestResultFailTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(StackTestResultFailTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(StackTestResultFailTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(StackTestResultFailTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(StackTestResultFailTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(StackTestResultFailTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildStackTestResultFailQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(StackTestResultFailTableMap::COL_CREATED_AT);
    }

} // StackTestResultFailQuery
