<?php

namespace app\Model\Base;

use \Exception;
use \PDO;
use App\Model\Target as ChildTarget;
use App\Model\TargetQuery as ChildTargetQuery;
use App\Model\Map\TargetTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'target' table.
 *
 *
 *
 * @method     ChildTargetQuery orderByIdTarget($order = Criteria::ASC) Order by the id_target column
 * @method     ChildTargetQuery orderByTargetTypeId($order = Criteria::ASC) Order by the target_type_id column
 * @method     ChildTargetQuery orderByTargetGroupId($order = Criteria::ASC) Order by the target_group_id column
 * @method     ChildTargetQuery orderByTargetTarget($order = Criteria::ASC) Order by the target_target column
 * @method     ChildTargetQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTargetQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTargetQuery groupByIdTarget() Group by the id_target column
 * @method     ChildTargetQuery groupByTargetTypeId() Group by the target_type_id column
 * @method     ChildTargetQuery groupByTargetGroupId() Group by the target_group_id column
 * @method     ChildTargetQuery groupByTargetTarget() Group by the target_target column
 * @method     ChildTargetQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTargetQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTargetQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTargetQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTargetQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTargetQuery leftJoinTargetType($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetType relation
 * @method     ChildTargetQuery rightJoinTargetType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetType relation
 * @method     ChildTargetQuery innerJoinTargetType($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetType relation
 *
 * @method     ChildTargetQuery leftJoinTargetGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the TargetGroup relation
 * @method     ChildTargetQuery rightJoinTargetGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TargetGroup relation
 * @method     ChildTargetQuery innerJoinTargetGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the TargetGroup relation
 *
 * @method     ChildTargetQuery leftJoinChannelOut($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChannelOut relation
 * @method     ChildTargetQuery rightJoinChannelOut($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChannelOut relation
 * @method     ChildTargetQuery innerJoinChannelOut($relationAlias = null) Adds a INNER JOIN clause to the query using the ChannelOut relation
 *
 * @method     ChildTargetQuery leftJoinStackTestResultFailRelatedByTargetId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StackTestResultFailRelatedByTargetId relation
 * @method     ChildTargetQuery rightJoinStackTestResultFailRelatedByTargetId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StackTestResultFailRelatedByTargetId relation
 * @method     ChildTargetQuery innerJoinStackTestResultFailRelatedByTargetId($relationAlias = null) Adds a INNER JOIN clause to the query using the StackTestResultFailRelatedByTargetId relation
 *
 * @method     ChildTargetQuery leftJoinStackTestResultFailRelatedByTargetGroupId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StackTestResultFailRelatedByTargetGroupId relation
 * @method     ChildTargetQuery rightJoinStackTestResultFailRelatedByTargetGroupId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StackTestResultFailRelatedByTargetGroupId relation
 * @method     ChildTargetQuery innerJoinStackTestResultFailRelatedByTargetGroupId($relationAlias = null) Adds a INNER JOIN clause to the query using the StackTestResultFailRelatedByTargetGroupId relation
 *
 * @method     ChildTargetQuery leftJoinStackTestResultFailRelatedByTargetTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StackTestResultFailRelatedByTargetTypeId relation
 * @method     ChildTargetQuery rightJoinStackTestResultFailRelatedByTargetTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StackTestResultFailRelatedByTargetTypeId relation
 * @method     ChildTargetQuery innerJoinStackTestResultFailRelatedByTargetTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the StackTestResultFailRelatedByTargetTypeId relation
 *
 * @method     ChildTargetQuery leftJoinStackTestResultPass($relationAlias = null) Adds a LEFT JOIN clause to the query using the StackTestResultPass relation
 * @method     ChildTargetQuery rightJoinStackTestResultPass($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StackTestResultPass relation
 * @method     ChildTargetQuery innerJoinStackTestResultPass($relationAlias = null) Adds a INNER JOIN clause to the query using the StackTestResultPass relation
 *
 * @method     ChildTargetQuery leftJoinTrigger($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trigger relation
 * @method     ChildTargetQuery rightJoinTrigger($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trigger relation
 * @method     ChildTargetQuery innerJoinTrigger($relationAlias = null) Adds a INNER JOIN clause to the query using the Trigger relation
 *
 * @method     \App\Model\TargetTypeQuery|\App\Model\TargetGroupQuery|\App\Model\ChannelOutQuery|\App\Model\StackTestResultFailQuery|\App\Model\StackTestResultPassQuery|\App\Model\TriggerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTarget findOne(ConnectionInterface $con = null) Return the first ChildTarget matching the query
 * @method     ChildTarget findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTarget matching the query, or a new ChildTarget object populated from the query conditions when no match is found
 *
 * @method     ChildTarget findOneByIdTarget(int $id_target) Return the first ChildTarget filtered by the id_target column
 * @method     ChildTarget findOneByTargetTypeId(int $target_type_id) Return the first ChildTarget filtered by the target_type_id column
 * @method     ChildTarget findOneByTargetGroupId(int $target_group_id) Return the first ChildTarget filtered by the target_group_id column
 * @method     ChildTarget findOneByTargetTarget(string $target_target) Return the first ChildTarget filtered by the target_target column
 * @method     ChildTarget findOneByCreatedAt(string $created_at) Return the first ChildTarget filtered by the created_at column
 * @method     ChildTarget findOneByUpdatedAt(string $updated_at) Return the first ChildTarget filtered by the updated_at column
 *
 * @method     ChildTarget[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTarget objects based on current ModelCriteria
 * @method     ChildTarget[]|ObjectCollection findByIdTarget(int $id_target) Return ChildTarget objects filtered by the id_target column
 * @method     ChildTarget[]|ObjectCollection findByTargetTypeId(int $target_type_id) Return ChildTarget objects filtered by the target_type_id column
 * @method     ChildTarget[]|ObjectCollection findByTargetGroupId(int $target_group_id) Return ChildTarget objects filtered by the target_group_id column
 * @method     ChildTarget[]|ObjectCollection findByTargetTarget(string $target_target) Return ChildTarget objects filtered by the target_target column
 * @method     ChildTarget[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTarget objects filtered by the created_at column
 * @method     ChildTarget[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTarget objects filtered by the updated_at column
 * @method     ChildTarget[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TargetQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\TargetQuery object.
     *
     * @param string $dbName     The database name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\Target', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTargetQuery object.
     *
     * @param string   $modelAlias The alias of a model in the query
     * @param Criteria $criteria   Optional Criteria to build the query from
     *
     * @return ChildTargetQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTargetQuery) {
            return $criteria;
        }
        $query = new ChildTargetQuery();
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
     * @return ChildTarget|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TargetTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TargetTableMap::DATABASE_NAME);
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
     * @return ChildTarget A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_TARGET, TARGET_TYPE_ID, TARGET_GROUP_ID, TARGET_TARGET, CREATED_AT, UPDATED_AT FROM target WHERE ID_TARGET = :p0';
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
            /** @var ChildTarget $obj */
            $obj = new ChildTarget();
            $obj->hydrate($row);
            TargetTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTarget|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(TargetTableMap::COL_ID_TARGET, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(TargetTableMap::COL_ID_TARGET, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_target column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTarget(1234); // WHERE id_target = 1234
     * $query->filterByIdTarget(array(12, 34)); // WHERE id_target IN (12, 34)
     * $query->filterByIdTarget(array('min' => 12)); // WHERE id_target > 12
     * </code>
     *
     * @param mixed  $idTarget   The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByIdTarget($idTarget = null, $comparison = null)
    {
        if (is_array($idTarget)) {
            $useMinMax = false;
            if (isset($idTarget['min'])) {
                $this->addUsingAlias(TargetTableMap::COL_ID_TARGET, $idTarget['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTarget['max'])) {
                $this->addUsingAlias(TargetTableMap::COL_ID_TARGET, $idTarget['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetTableMap::COL_ID_TARGET, $idTarget, $comparison);
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
     * @param mixed  $targetTypeId The value to use as filter.
     *                             Use scalar values for equality.
     *                             Use array values for in_array() equivalent.
     *                             Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison   Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByTargetTypeId($targetTypeId = null, $comparison = null)
    {
        if (is_array($targetTypeId)) {
            $useMinMax = false;
            if (isset($targetTypeId['min'])) {
                $this->addUsingAlias(TargetTableMap::COL_TARGET_TYPE_ID, $targetTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetTypeId['max'])) {
                $this->addUsingAlias(TargetTableMap::COL_TARGET_TYPE_ID, $targetTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetTableMap::COL_TARGET_TYPE_ID, $targetTypeId, $comparison);
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
     * @param mixed  $targetGroupId The value to use as filter.
     *                              Use scalar values for equality.
     *                              Use array values for in_array() equivalent.
     *                              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison    Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByTargetGroupId($targetGroupId = null, $comparison = null)
    {
        if (is_array($targetGroupId)) {
            $useMinMax = false;
            if (isset($targetGroupId['min'])) {
                $this->addUsingAlias(TargetTableMap::COL_TARGET_GROUP_ID, $targetGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetGroupId['max'])) {
                $this->addUsingAlias(TargetTableMap::COL_TARGET_GROUP_ID, $targetGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetTableMap::COL_TARGET_GROUP_ID, $targetGroupId, $comparison);
    }

    /**
     * Filter the query on the target_target column
     *
     * Example usage:
     * <code>
     * $query->filterByTargetTarget('fooValue');   // WHERE target_target = 'fooValue'
     * $query->filterByTargetTarget('%fooValue%'); // WHERE target_target LIKE '%fooValue%'
     * </code>
     *
     * @param string $targetTarget The value to use as filter.
     *                             Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison   Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByTargetTarget($targetTarget = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($targetTarget)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $targetTarget)) {
                $targetTarget = str_replace('*', '%', $targetTarget);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TargetTableMap::COL_TARGET_TARGET, $targetTarget, $comparison);
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
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TargetTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TargetTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TargetTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TargetTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\TargetType object
     *
     * @param \App\Model\TargetType|ObjectCollection $targetType The related object(s) to use as filter
     * @param string                                 $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByTargetType($targetType, $comparison = null)
    {
        if ($targetType instanceof \App\Model\TargetType) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_TARGET_TYPE_ID, $targetType->getIdTargetType(), $comparison);
        } elseif ($targetType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TargetTableMap::COL_TARGET_TYPE_ID, $targetType->toKeyValue('PrimaryKey', 'IdTargetType'), $comparison);
        } else {
            throw new PropelException('filterByTargetType() only accepts arguments of type \App\Model\TargetType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TargetType relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
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
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Filter the query by a related \App\Model\TargetGroup object
     *
     * @param \App\Model\TargetGroup|ObjectCollection $targetGroup The related object(s) to use as filter
     * @param string                                  $comparison  Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByTargetGroup($targetGroup, $comparison = null)
    {
        if ($targetGroup instanceof \App\Model\TargetGroup) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_TARGET_GROUP_ID, $targetGroup->getIdTargetGroup(), $comparison);
        } elseif ($targetGroup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TargetTableMap::COL_TARGET_GROUP_ID, $targetGroup->toKeyValue('PrimaryKey', 'IdTargetGroup'), $comparison);
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
     * @return $this|ChildTargetQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Model\ChannelOut object
     *
     * @param \App\Model\ChannelOut|ObjectCollection $channelOut the related object to use as filter
     * @param string                                 $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByChannelOut($channelOut, $comparison = null)
    {
        if ($channelOut instanceof \App\Model\ChannelOut) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_ID_TARGET, $channelOut->getTargetId(), $comparison);
        } elseif ($channelOut instanceof ObjectCollection) {
            return $this
                ->useChannelOutQuery()
                ->filterByPrimaryKeys($channelOut->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChannelOut() only accepts arguments of type \App\Model\ChannelOut or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChannelOut relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function joinChannelOut($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChannelOut');

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
            $this->addJoinObject($join, 'ChannelOut');
        }

        return $this;
    }

    /**
     * Use the ChannelOut relation ChannelOut object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\ChannelOutQuery A secondary query class using the current class as primary query
     */
    public function useChannelOutQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChannelOut($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChannelOut', '\App\Model\ChannelOutQuery');
    }

    /**
     * Filter the query by a related \App\Model\StackTestResultFail object
     *
     * @param \App\Model\StackTestResultFail|ObjectCollection $stackTestResultFail the related object to use as filter
     * @param string                                          $comparison          Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByStackTestResultFailRelatedByTargetId($stackTestResultFail, $comparison = null)
    {
        if ($stackTestResultFail instanceof \App\Model\StackTestResultFail) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_ID_TARGET, $stackTestResultFail->getTargetId(), $comparison);
        } elseif ($stackTestResultFail instanceof ObjectCollection) {
            return $this
                ->useStackTestResultFailRelatedByTargetIdQuery()
                ->filterByPrimaryKeys($stackTestResultFail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStackTestResultFailRelatedByTargetId() only accepts arguments of type \App\Model\StackTestResultFail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StackTestResultFailRelatedByTargetId relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function joinStackTestResultFailRelatedByTargetId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StackTestResultFailRelatedByTargetId');

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
            $this->addJoinObject($join, 'StackTestResultFailRelatedByTargetId');
        }

        return $this;
    }

    /**
     * Use the StackTestResultFailRelatedByTargetId relation StackTestResultFail object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\StackTestResultFailQuery A secondary query class using the current class as primary query
     */
    public function useStackTestResultFailRelatedByTargetIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStackTestResultFailRelatedByTargetId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StackTestResultFailRelatedByTargetId', '\App\Model\StackTestResultFailQuery');
    }

    /**
     * Filter the query by a related \App\Model\StackTestResultFail object
     *
     * @param \App\Model\StackTestResultFail|ObjectCollection $stackTestResultFail the related object to use as filter
     * @param string                                          $comparison          Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByStackTestResultFailRelatedByTargetGroupId($stackTestResultFail, $comparison = null)
    {
        if ($stackTestResultFail instanceof \App\Model\StackTestResultFail) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_TARGET_GROUP_ID, $stackTestResultFail->getTargetGroupId(), $comparison);
        } elseif ($stackTestResultFail instanceof ObjectCollection) {
            return $this
                ->useStackTestResultFailRelatedByTargetGroupIdQuery()
                ->filterByPrimaryKeys($stackTestResultFail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStackTestResultFailRelatedByTargetGroupId() only accepts arguments of type \App\Model\StackTestResultFail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StackTestResultFailRelatedByTargetGroupId relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function joinStackTestResultFailRelatedByTargetGroupId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StackTestResultFailRelatedByTargetGroupId');

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
            $this->addJoinObject($join, 'StackTestResultFailRelatedByTargetGroupId');
        }

        return $this;
    }

    /**
     * Use the StackTestResultFailRelatedByTargetGroupId relation StackTestResultFail object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\StackTestResultFailQuery A secondary query class using the current class as primary query
     */
    public function useStackTestResultFailRelatedByTargetGroupIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStackTestResultFailRelatedByTargetGroupId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StackTestResultFailRelatedByTargetGroupId', '\App\Model\StackTestResultFailQuery');
    }

    /**
     * Filter the query by a related \App\Model\StackTestResultFail object
     *
     * @param \App\Model\StackTestResultFail|ObjectCollection $stackTestResultFail the related object to use as filter
     * @param string                                          $comparison          Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByStackTestResultFailRelatedByTargetTypeId($stackTestResultFail, $comparison = null)
    {
        if ($stackTestResultFail instanceof \App\Model\StackTestResultFail) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_TARGET_TYPE_ID, $stackTestResultFail->getTargetTypeId(), $comparison);
        } elseif ($stackTestResultFail instanceof ObjectCollection) {
            return $this
                ->useStackTestResultFailRelatedByTargetTypeIdQuery()
                ->filterByPrimaryKeys($stackTestResultFail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStackTestResultFailRelatedByTargetTypeId() only accepts arguments of type \App\Model\StackTestResultFail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StackTestResultFailRelatedByTargetTypeId relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function joinStackTestResultFailRelatedByTargetTypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StackTestResultFailRelatedByTargetTypeId');

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
            $this->addJoinObject($join, 'StackTestResultFailRelatedByTargetTypeId');
        }

        return $this;
    }

    /**
     * Use the StackTestResultFailRelatedByTargetTypeId relation StackTestResultFail object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\StackTestResultFailQuery A secondary query class using the current class as primary query
     */
    public function useStackTestResultFailRelatedByTargetTypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStackTestResultFailRelatedByTargetTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StackTestResultFailRelatedByTargetTypeId', '\App\Model\StackTestResultFailQuery');
    }

    /**
     * Filter the query by a related \App\Model\StackTestResultPass object
     *
     * @param \App\Model\StackTestResultPass|ObjectCollection $stackTestResultPass the related object to use as filter
     * @param string                                          $comparison          Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByStackTestResultPass($stackTestResultPass, $comparison = null)
    {
        if ($stackTestResultPass instanceof \App\Model\StackTestResultPass) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_ID_TARGET, $stackTestResultPass->getTargetId(), $comparison);
        } elseif ($stackTestResultPass instanceof ObjectCollection) {
            return $this
                ->useStackTestResultPassQuery()
                ->filterByPrimaryKeys($stackTestResultPass->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStackTestResultPass() only accepts arguments of type \App\Model\StackTestResultPass or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StackTestResultPass relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function joinStackTestResultPass($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StackTestResultPass');

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
            $this->addJoinObject($join, 'StackTestResultPass');
        }

        return $this;
    }

    /**
     * Use the StackTestResultPass relation StackTestResultPass object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\StackTestResultPassQuery A secondary query class using the current class as primary query
     */
    public function useStackTestResultPassQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStackTestResultPass($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StackTestResultPass', '\App\Model\StackTestResultPassQuery');
    }

    /**
     * Filter the query by a related \App\Model\Trigger object
     *
     * @param \App\Model\Trigger|ObjectCollection $trigger    the related object to use as filter
     * @param string                              $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTargetQuery The current query, for fluid interface
     */
    public function filterByTrigger($trigger, $comparison = null)
    {
        if ($trigger instanceof \App\Model\Trigger) {
            return $this
                ->addUsingAlias(TargetTableMap::COL_ID_TARGET, $trigger->getTargetId(), $comparison);
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
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
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
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
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
     * @param ChildTarget $target Object to remove from the list of results
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function prune($target = null)
    {
        if ($target) {
            $this->addUsingAlias(TargetTableMap::COL_ID_TARGET, $target->getIdTarget(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the target table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TargetTableMap::clearInstancePool();
            TargetTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TargetTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TargetTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TargetTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TargetTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TargetTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TargetTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TargetTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TargetTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TargetTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return $this|ChildTargetQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TargetTableMap::COL_CREATED_AT);
    }

} // TargetQuery
