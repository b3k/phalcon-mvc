<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\TriggerType as ChildTriggerType;
use App\Model\TriggerTypeQuery as ChildTriggerTypeQuery;
use App\Model\Map\TriggerTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trigger_type' table.
 *
 *
 *
 * @method     ChildTriggerTypeQuery orderByIdTriggerType($order = Criteria::ASC) Order by the id_trigger_type column
 * @method     ChildTriggerTypeQuery orderByChannelId($order = Criteria::ASC) Order by the channel_id column
 * @method     ChildTriggerTypeQuery orderByTriggerTypeClass($order = Criteria::ASC) Order by the trigger_type_class column
 * @method     ChildTriggerTypeQuery orderByTriggerTypeName($order = Criteria::ASC) Order by the trigger_type_name column
 * @method     ChildTriggerTypeQuery orderByTriggerTypeDescription($order = Criteria::ASC) Order by the trigger_type_description column
 * @method     ChildTriggerTypeQuery orderByTriggerTypeActive($order = Criteria::ASC) Order by the trigger_type_active column
 * @method     ChildTriggerTypeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTriggerTypeQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTriggerTypeQuery groupByIdTriggerType() Group by the id_trigger_type column
 * @method     ChildTriggerTypeQuery groupByChannelId() Group by the channel_id column
 * @method     ChildTriggerTypeQuery groupByTriggerTypeClass() Group by the trigger_type_class column
 * @method     ChildTriggerTypeQuery groupByTriggerTypeName() Group by the trigger_type_name column
 * @method     ChildTriggerTypeQuery groupByTriggerTypeDescription() Group by the trigger_type_description column
 * @method     ChildTriggerTypeQuery groupByTriggerTypeActive() Group by the trigger_type_active column
 * @method     ChildTriggerTypeQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTriggerTypeQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTriggerTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTriggerTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTriggerTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTriggerTypeQuery leftJoinChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Channel relation
 * @method     ChildTriggerTypeQuery rightJoinChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Channel relation
 * @method     ChildTriggerTypeQuery innerJoinChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the Channel relation
 *
 * @method     ChildTriggerTypeQuery leftJoinTrigger($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trigger relation
 * @method     ChildTriggerTypeQuery rightJoinTrigger($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trigger relation
 * @method     ChildTriggerTypeQuery innerJoinTrigger($relationAlias = null) Adds a INNER JOIN clause to the query using the Trigger relation
 *
 * @method     \App\Model\ChannelQuery|\App\Model\TriggerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTriggerType findOne(ConnectionInterface $con = null) Return the first ChildTriggerType matching the query
 * @method     ChildTriggerType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTriggerType matching the query, or a new ChildTriggerType object populated from the query conditions when no match is found
 *
 * @method     ChildTriggerType findOneByIdTriggerType(int $id_trigger_type) Return the first ChildTriggerType filtered by the id_trigger_type column
 * @method     ChildTriggerType findOneByChannelId(int $channel_id) Return the first ChildTriggerType filtered by the channel_id column
 * @method     ChildTriggerType findOneByTriggerTypeClass(string $trigger_type_class) Return the first ChildTriggerType filtered by the trigger_type_class column
 * @method     ChildTriggerType findOneByTriggerTypeName(string $trigger_type_name) Return the first ChildTriggerType filtered by the trigger_type_name column
 * @method     ChildTriggerType findOneByTriggerTypeDescription(string $trigger_type_description) Return the first ChildTriggerType filtered by the trigger_type_description column
 * @method     ChildTriggerType findOneByTriggerTypeActive(boolean $trigger_type_active) Return the first ChildTriggerType filtered by the trigger_type_active column
 * @method     ChildTriggerType findOneByCreatedAt(string $created_at) Return the first ChildTriggerType filtered by the created_at column
 * @method     ChildTriggerType findOneByUpdatedAt(string $updated_at) Return the first ChildTriggerType filtered by the updated_at column
 *
 * @method     ChildTriggerType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTriggerType objects based on current ModelCriteria
 * @method     ChildTriggerType[]|ObjectCollection findByIdTriggerType(int $id_trigger_type) Return ChildTriggerType objects filtered by the id_trigger_type column
 * @method     ChildTriggerType[]|ObjectCollection findByChannelId(int $channel_id) Return ChildTriggerType objects filtered by the channel_id column
 * @method     ChildTriggerType[]|ObjectCollection findByTriggerTypeClass(string $trigger_type_class) Return ChildTriggerType objects filtered by the trigger_type_class column
 * @method     ChildTriggerType[]|ObjectCollection findByTriggerTypeName(string $trigger_type_name) Return ChildTriggerType objects filtered by the trigger_type_name column
 * @method     ChildTriggerType[]|ObjectCollection findByTriggerTypeDescription(string $trigger_type_description) Return ChildTriggerType objects filtered by the trigger_type_description column
 * @method     ChildTriggerType[]|ObjectCollection findByTriggerTypeActive(boolean $trigger_type_active) Return ChildTriggerType objects filtered by the trigger_type_active column
 * @method     ChildTriggerType[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTriggerType objects filtered by the created_at column
 * @method     ChildTriggerType[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTriggerType objects filtered by the updated_at column
 * @method     ChildTriggerType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TriggerTypeQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\TriggerTypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\TriggerType', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTriggerTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTriggerTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTriggerTypeQuery) {
            return $criteria;
        }
        $query = new ChildTriggerTypeQuery();
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
     * @return ChildTriggerType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TriggerTypeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TriggerTypeTableMap::DATABASE_NAME);
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
     * @return ChildTriggerType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `ID_TRIGGER_TYPE`, `CHANNEL_ID`, `TRIGGER_TYPE_CLASS`, `TRIGGER_TYPE_NAME`, `TRIGGER_TYPE_DESCRIPTION`, `TRIGGER_TYPE_ACTIVE`, `CREATED_AT`, `UPDATED_AT` FROM `trigger_type` WHERE `ID_TRIGGER_TYPE` = :p0';
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
            /** @var ChildTriggerType $obj */
            $obj = new ChildTriggerType();
            $obj->hydrate($row);
            TriggerTypeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTriggerType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_trigger_type column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTriggerType(1234); // WHERE id_trigger_type = 1234
     * $query->filterByIdTriggerType(array(12, 34)); // WHERE id_trigger_type IN (12, 34)
     * $query->filterByIdTriggerType(array('min' => 12)); // WHERE id_trigger_type > 12
     * </code>
     *
     * @param     mixed $idTriggerType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByIdTriggerType($idTriggerType = null, $comparison = null)
    {
        if (is_array($idTriggerType)) {
            $useMinMax = false;
            if (isset($idTriggerType['min'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $idTriggerType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTriggerType['max'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $idTriggerType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $idTriggerType, $comparison);
    }

    /**
     * Filter the query on the channel_id column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelId(1234); // WHERE channel_id = 1234
     * $query->filterByChannelId(array(12, 34)); // WHERE channel_id IN (12, 34)
     * $query->filterByChannelId(array('min' => 12)); // WHERE channel_id > 12
     * </code>
     *
     * @see       filterByChannel()
     *
     * @param     mixed $channelId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByChannelId($channelId = null, $comparison = null)
    {
        if (is_array($channelId)) {
            $useMinMax = false;
            if (isset($channelId['min'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_CHANNEL_ID, $channelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($channelId['max'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_CHANNEL_ID, $channelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_CHANNEL_ID, $channelId, $comparison);
    }

    /**
     * Filter the query on the trigger_type_class column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerTypeClass('fooValue');   // WHERE trigger_type_class = 'fooValue'
     * $query->filterByTriggerTypeClass('%fooValue%'); // WHERE trigger_type_class LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerTypeClass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByTriggerTypeClass($triggerTypeClass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerTypeClass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerTypeClass)) {
                $triggerTypeClass = str_replace('*', '%', $triggerTypeClass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_TRIGGER_TYPE_CLASS, $triggerTypeClass, $comparison);
    }

    /**
     * Filter the query on the trigger_type_name column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerTypeName('fooValue');   // WHERE trigger_type_name = 'fooValue'
     * $query->filterByTriggerTypeName('%fooValue%'); // WHERE trigger_type_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerTypeName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByTriggerTypeName($triggerTypeName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerTypeName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerTypeName)) {
                $triggerTypeName = str_replace('*', '%', $triggerTypeName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_TRIGGER_TYPE_NAME, $triggerTypeName, $comparison);
    }

    /**
     * Filter the query on the trigger_type_description column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerTypeDescription('fooValue');   // WHERE trigger_type_description = 'fooValue'
     * $query->filterByTriggerTypeDescription('%fooValue%'); // WHERE trigger_type_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerTypeDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByTriggerTypeDescription($triggerTypeDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerTypeDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerTypeDescription)) {
                $triggerTypeDescription = str_replace('*', '%', $triggerTypeDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_TRIGGER_TYPE_DESCRIPTION, $triggerTypeDescription, $comparison);
    }

    /**
     * Filter the query on the trigger_type_active column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerTypeActive(true); // WHERE trigger_type_active = true
     * $query->filterByTriggerTypeActive('yes'); // WHERE trigger_type_active = true
     * </code>
     *
     * @param     boolean|string $triggerTypeActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByTriggerTypeActive($triggerTypeActive = null, $comparison = null)
    {
        if (is_string($triggerTypeActive)) {
            $triggerTypeActive = in_array(strtolower($triggerTypeActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_TRIGGER_TYPE_ACTIVE, $triggerTypeActive, $comparison);
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
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TriggerTypeTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerTypeTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Channel object
     *
     * @param \App\Model\Channel|ObjectCollection $channel The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByChannel($channel, $comparison = null)
    {
        if ($channel instanceof \App\Model\Channel) {
            return $this
                ->addUsingAlias(TriggerTypeTableMap::COL_CHANNEL_ID, $channel->getIdChannel(), $comparison);
        } elseif ($channel instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerTypeTableMap::COL_CHANNEL_ID, $channel->toKeyValue('PrimaryKey', 'IdChannel'), $comparison);
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
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Model\Trigger object
     *
     * @param \App\Model\Trigger|ObjectCollection $trigger  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function filterByTrigger($trigger, $comparison = null)
    {
        if ($trigger instanceof \App\Model\Trigger) {
            return $this
                ->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $trigger->getTriggerTypeId(), $comparison);
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
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
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
     * @param   ChildTriggerType $triggerType Object to remove from the list of results
     *
     * @return $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function prune($triggerType = null)
    {
        if ($triggerType) {
            $this->addUsingAlias(TriggerTypeTableMap::COL_ID_TRIGGER_TYPE, $triggerType->getIdTriggerType(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trigger_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TriggerTypeTableMap::clearInstancePool();
            TriggerTypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TriggerTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TriggerTypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TriggerTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TriggerTypeTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TriggerTypeTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TriggerTypeTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TriggerTypeTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TriggerTypeTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTriggerTypeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TriggerTypeTableMap::COL_CREATED_AT);
    }

} // TriggerTypeQuery
