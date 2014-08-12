<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\StackTestResultPass as ChildStackTestResultPass;
use App\Model\StackTestResultPassQuery as ChildStackTestResultPassQuery;
use App\Model\Map\StackTestResultPassTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'stack_test_result_pass' table.
 *
 *
 *
 * @method     ChildStackTestResultPassQuery orderByIdTestResultPass($order = Criteria::ASC) Order by the id_test_result_pass column
 * @method     ChildStackTestResultPassQuery orderByTargetId($order = Criteria::ASC) Order by the target_id column
 * @method     ChildStackTestResultPassQuery orderByTargetGroupId($order = Criteria::ASC) Order by the target_group_id column
 * @method     ChildStackTestResultPassQuery orderByTargetTypeId($order = Criteria::ASC) Order by the target_type_id column
 * @method     ChildStackTestResultPassQuery orderByStackTestResultPassInfo($order = Criteria::ASC) Order by the stack_test_result_pass_info column
 * @method     ChildStackTestResultPassQuery orderByStackTestResultPassPriority($order = Criteria::ASC) Order by the stack_test_result_pass_priority column
 * @method     ChildStackTestResultPassQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStackTestResultPassQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildStackTestResultPassQuery groupByIdTestResultPass() Group by the id_test_result_pass column
 * @method     ChildStackTestResultPassQuery groupByTargetId() Group by the target_id column
 * @method     ChildStackTestResultPassQuery groupByTargetGroupId() Group by the target_group_id column
 * @method     ChildStackTestResultPassQuery groupByTargetTypeId() Group by the target_type_id column
 * @method     ChildStackTestResultPassQuery groupByStackTestResultPassInfo() Group by the stack_test_result_pass_info column
 * @method     ChildStackTestResultPassQuery groupByStackTestResultPassPriority() Group by the stack_test_result_pass_priority column
 * @method     ChildStackTestResultPassQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStackTestResultPassQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildStackTestResultPassQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStackTestResultPassQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStackTestResultPassQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStackTestResultPassQuery leftJoinTarget($relationAlias = null) Adds a LEFT JOIN clause to the query using the Target relation
 * @method     ChildStackTestResultPassQuery rightJoinTarget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Target relation
 * @method     ChildStackTestResultPassQuery innerJoinTarget($relationAlias = null) Adds a INNER JOIN clause to the query using the Target relation
 *
 * @method     ChildStackTestResultPassQuery leftJoinTargetGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetGroup relation
 * @method     ChildStackTestResultPassQuery rightJoinTargetGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetGroup relation
 * @method     ChildStackTestResultPassQuery innerJoinTargetGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetGroup relation
 *
 * @method     ChildStackTestResultPassQuery leftJoinTargetType($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetType relation
 * @method     ChildStackTestResultPassQuery rightJoinTargetType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetType relation
 * @method     ChildStackTestResultPassQuery innerJoinTargetType($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetType relation
 *
 * @method     \App\Model\TargetQuery|\App\Model\TargetGroupQuery|\App\Model\TargetTypeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStackTestResultPass findOne(ConnectionInterface $con = null) Return the first ChildStackTestResultPass matching the query
 * @method     ChildStackTestResultPass findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStackTestResultPass matching the query, or a new ChildStackTestResultPass object populated from the query conditions when no match is found
 *
 * @method     ChildStackTestResultPass findOneByIdTestResultPass(int $id_test_result_pass) Return the first ChildStackTestResultPass filtered by the id_test_result_pass column
 * @method     ChildStackTestResultPass findOneByTargetId(int $target_id) Return the first ChildStackTestResultPass filtered by the target_id column
 * @method     ChildStackTestResultPass findOneByTargetGroupId(int $target_group_id) Return the first ChildStackTestResultPass filtered by the target_group_id column
 * @method     ChildStackTestResultPass findOneByTargetTypeId(int $target_type_id) Return the first ChildStackTestResultPass filtered by the target_type_id column
 * @method     ChildStackTestResultPass findOneByStackTestResultPassInfo(string $stack_test_result_pass_info) Return the first ChildStackTestResultPass filtered by the stack_test_result_pass_info column
 * @method     ChildStackTestResultPass findOneByStackTestResultPassPriority(boolean $stack_test_result_pass_priority) Return the first ChildStackTestResultPass filtered by the stack_test_result_pass_priority column
 * @method     ChildStackTestResultPass findOneByCreatedAt(string $created_at) Return the first ChildStackTestResultPass filtered by the created_at column
 * @method     ChildStackTestResultPass findOneByUpdatedAt(string $updated_at) Return the first ChildStackTestResultPass filtered by the updated_at column
 *
 * @method     ChildStackTestResultPass[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStackTestResultPass objects based on current ModelCriteria
 * @method     ChildStackTestResultPass[]|ObjectCollection findByIdTestResultPass(int $id_test_result_pass) Return ChildStackTestResultPass objects filtered by the id_test_result_pass column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByTargetId(int $target_id) Return ChildStackTestResultPass objects filtered by the target_id column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByTargetGroupId(int $target_group_id) Return ChildStackTestResultPass objects filtered by the target_group_id column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByTargetTypeId(int $target_type_id) Return ChildStackTestResultPass objects filtered by the target_type_id column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByStackTestResultPassInfo(string $stack_test_result_pass_info) Return ChildStackTestResultPass objects filtered by the stack_test_result_pass_info column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByStackTestResultPassPriority(boolean $stack_test_result_pass_priority) Return ChildStackTestResultPass objects filtered by the stack_test_result_pass_priority column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildStackTestResultPass objects filtered by the created_at column
 * @method     ChildStackTestResultPass[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildStackTestResultPass objects filtered by the updated_at column
 * @method     ChildStackTestResultPass[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StackTestResultPassQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\StackTestResultPassQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\StackTestResultPass', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStackTestResultPassQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStackTestResultPassQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStackTestResultPassQuery) {
            return $criteria;
        }
        $query = new ChildStackTestResultPassQuery();
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
     * @return ChildStackTestResultPass|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StackTestResultPassTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StackTestResultPassTableMap::DATABASE_NAME);
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
     * @return ChildStackTestResultPass A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `ID_TEST_RESULT_PASS`, `TARGET_ID`, `TARGET_GROUP_ID`, `TARGET_TYPE_ID`, `STACK_TEST_RESULT_PASS_INFO`, `STACK_TEST_RESULT_PASS_PRIORITY`, `CREATED_AT`, `UPDATED_AT` FROM `stack_test_result_pass` WHERE `ID_TEST_RESULT_PASS` = :p0';
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
            /** @var ChildStackTestResultPass $obj */
            $obj = new ChildStackTestResultPass();
            $obj->hydrate($row);
            StackTestResultPassTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStackTestResultPass|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_test_result_pass column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTestResultPass(1234); // WHERE id_test_result_pass = 1234
     * $query->filterByIdTestResultPass(array(12, 34)); // WHERE id_test_result_pass IN (12, 34)
     * $query->filterByIdTestResultPass(array('min' => 12)); // WHERE id_test_result_pass > 12
     * </code>
     *
     * @param     mixed $idTestResultPass The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByIdTestResultPass($idTestResultPass = null, $comparison = null)
    {
        if (is_array($idTestResultPass)) {
            $useMinMax = false;
            if (isset($idTestResultPass['min'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, $idTestResultPass['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTestResultPass['max'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, $idTestResultPass['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, $idTestResultPass, $comparison);
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
     * @param     mixed $targetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByTargetId($targetId = null, $comparison = null)
    {
        if (is_array($targetId)) {
            $useMinMax = false;
            if (isset($targetId['min'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_ID, $targetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetId['max'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_ID, $targetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_ID, $targetId, $comparison);
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
     * @see       filterByTargetGroup()
     *
     * @param     mixed $targetGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByTargetGroupId($targetGroupId = null, $comparison = null)
    {
        if (is_array($targetGroupId)) {
            $useMinMax = false;
            if (isset($targetGroupId['min'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_GROUP_ID, $targetGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetGroupId['max'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_GROUP_ID, $targetGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_GROUP_ID, $targetGroupId, $comparison);
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
     * @see       filterByTargetType()
     *
     * @param     mixed $targetTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByTargetTypeId($targetTypeId = null, $comparison = null)
    {
        if (is_array($targetTypeId)) {
            $useMinMax = false;
            if (isset($targetTypeId['min'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_TYPE_ID, $targetTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetTypeId['max'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_TYPE_ID, $targetTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_TYPE_ID, $targetTypeId, $comparison);
    }

    /**
     * Filter the query on the stack_test_result_pass_info column
     *
     * Example usage:
     * <code>
     * $query->filterByStackTestResultPassInfo('fooValue');   // WHERE stack_test_result_pass_info = 'fooValue'
     * $query->filterByStackTestResultPassInfo('%fooValue%'); // WHERE stack_test_result_pass_info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stackTestResultPassInfo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByStackTestResultPassInfo($stackTestResultPassInfo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stackTestResultPassInfo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stackTestResultPassInfo)) {
                $stackTestResultPassInfo = str_replace('*', '%', $stackTestResultPassInfo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_INFO, $stackTestResultPassInfo, $comparison);
    }

    /**
     * Filter the query on the stack_test_result_pass_priority column
     *
     * Example usage:
     * <code>
     * $query->filterByStackTestResultPassPriority(true); // WHERE stack_test_result_pass_priority = true
     * $query->filterByStackTestResultPassPriority('yes'); // WHERE stack_test_result_pass_priority = true
     * </code>
     *
     * @param     boolean|string $stackTestResultPassPriority The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByStackTestResultPassPriority($stackTestResultPassPriority = null, $comparison = null)
    {
        if (is_string($stackTestResultPassPriority)) {
            $stackTestResultPassPriority = in_array(strtolower($stackTestResultPassPriority), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_STACK_TEST_RESULT_PASS_PRIORITY, $stackTestResultPassPriority, $comparison);
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
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StackTestResultPassTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StackTestResultPassTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Target object
     *
     * @param \App\Model\Target|ObjectCollection $target The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByTarget($target, $comparison = null)
    {
        if ($target instanceof \App\Model\Target) {
            return $this
                ->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_ID, $target->getIdTarget(), $comparison);
        } elseif ($target instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_ID, $target->toKeyValue('PrimaryKey', 'IdTarget'), $comparison);
        } else {
            throw new PropelException('filterByTarget() only accepts arguments of type \App\Model\Target or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Target relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
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
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Filter the query by a related \App\Model\TargetGroup object
     *
     * @param \App\Model\TargetGroup|ObjectCollection $targetGroup The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByTargetGroup($targetGroup, $comparison = null)
    {
        if ($targetGroup instanceof \App\Model\TargetGroup) {
            return $this
                ->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_GROUP_ID, $targetGroup->getIdTargetGroup(), $comparison);
        } elseif ($targetGroup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_GROUP_ID, $targetGroup->toKeyValue('PrimaryKey', 'IdTargetGroup'), $comparison);
        } else {
            throw new PropelException('filterByTargetGroup() only accepts arguments of type \App\Model\TargetGroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
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
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Filter the query by a related \App\Model\TargetType object
     *
     * @param \App\Model\TargetType|ObjectCollection $targetType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function filterByTargetType($targetType, $comparison = null)
    {
        if ($targetType instanceof \App\Model\TargetType) {
            return $this
                ->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_TYPE_ID, $targetType->getIdTargetType(), $comparison);
        } elseif ($targetType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StackTestResultPassTableMap::COL_TARGET_TYPE_ID, $targetType->toKeyValue('PrimaryKey', 'IdTargetType'), $comparison);
        } else {
            throw new PropelException('filterByTargetType() only accepts arguments of type \App\Model\TargetType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function joinTargetType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TargetType');

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
            $this->addJoinObject($join, 'TargetType');
        }

        return $this;
    }

    /**
     * Use the TargetType relation TargetType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\TargetTypeQuery A secondary query class using the current class as primary query
     */
    public function useTargetTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTargetType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TargetType', '\App\Model\TargetTypeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStackTestResultPass $stackTestResultPass Object to remove from the list of results
     *
     * @return $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function prune($stackTestResultPass = null)
    {
        if ($stackTestResultPass) {
            $this->addUsingAlias(StackTestResultPassTableMap::COL_ID_TEST_RESULT_PASS, $stackTestResultPass->getIdTestResultPass(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stack_test_result_pass table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultPassTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StackTestResultPassTableMap::clearInstancePool();
            StackTestResultPassTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StackTestResultPassTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StackTestResultPassTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StackTestResultPassTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StackTestResultPassTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(StackTestResultPassTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(StackTestResultPassTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(StackTestResultPassTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(StackTestResultPassTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(StackTestResultPassTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildStackTestResultPassQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(StackTestResultPassTableMap::COL_CREATED_AT);
    }

} // StackTestResultPassQuery
