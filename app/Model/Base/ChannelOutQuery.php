<?php

namespace app\Model\Base;

use \Exception;
use \PDO;
use App\Model\ChannelOut as ChildChannelOut;
use App\Model\ChannelOutQuery as ChildChannelOutQuery;
use App\Model\Map\ChannelOutTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'channel_out' table.
 *
 *
 *
 * @method     ChildChannelOutQuery orderByIdAlertOut($order = Criteria::ASC) Order by the id_alert_out column
 * @method     ChildChannelOutQuery orderByChannelId($order = Criteria::ASC) Order by the channel_id column
 * @method     ChildChannelOutQuery orderByTargetId($order = Criteria::ASC) Order by the target_id column
 * @method     ChildChannelOutQuery orderByChannelOutParams($order = Criteria::ASC) Order by the channel_out_params column
 * @method     ChildChannelOutQuery orderByChannelOutStatus($order = Criteria::ASC) Order by the channel_out_status column
 * @method     ChildChannelOutQuery orderByChannelOutPriority($order = Criteria::ASC) Order by the channel_out_priority column
 * @method     ChildChannelOutQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildChannelOutQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildChannelOutQuery groupByIdAlertOut() Group by the id_alert_out column
 * @method     ChildChannelOutQuery groupByChannelId() Group by the channel_id column
 * @method     ChildChannelOutQuery groupByTargetId() Group by the target_id column
 * @method     ChildChannelOutQuery groupByChannelOutParams() Group by the channel_out_params column
 * @method     ChildChannelOutQuery groupByChannelOutStatus() Group by the channel_out_status column
 * @method     ChildChannelOutQuery groupByChannelOutPriority() Group by the channel_out_priority column
 * @method     ChildChannelOutQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildChannelOutQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildChannelOutQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildChannelOutQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildChannelOutQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildChannelOutQuery leftJoinChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Channel relation
 * @method     ChildChannelOutQuery rightJoinChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Channel relation
 * @method     ChildChannelOutQuery innerJoinChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the Channel relation
 *
 * @method     ChildChannelOutQuery leftJoinTarget($relationAlias = null) Adds a LEFT JOIN clause to the query using the Target relation
 * @method     ChildChannelOutQuery rightJoinTarget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Target relation
 * @method     ChildChannelOutQuery innerJoinTarget($relationAlias = null) Adds a INNER JOIN clause to the query using the Target relation
 *
 * @method     \App\Model\ChannelQuery|\App\Model\TargetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildChannelOut findOne(ConnectionInterface $con = null) Return the first ChildChannelOut matching the query
 * @method     ChildChannelOut findOneOrCreate(ConnectionInterface $con = null) Return the first ChildChannelOut matching the query, or a new ChildChannelOut object populated from the query conditions when no match is found
 *
 * @method     ChildChannelOut findOneByIdAlertOut(int $id_alert_out) Return the first ChildChannelOut filtered by the id_alert_out column
 * @method     ChildChannelOut findOneByChannelId(int $channel_id) Return the first ChildChannelOut filtered by the channel_id column
 * @method     ChildChannelOut findOneByTargetId(int $target_id) Return the first ChildChannelOut filtered by the target_id column
 * @method     ChildChannelOut findOneByChannelOutParams(string $channel_out_params) Return the first ChildChannelOut filtered by the channel_out_params column
 * @method     ChildChannelOut findOneByChannelOutStatus(boolean $channel_out_status) Return the first ChildChannelOut filtered by the channel_out_status column
 * @method     ChildChannelOut findOneByChannelOutPriority(boolean $channel_out_priority) Return the first ChildChannelOut filtered by the channel_out_priority column
 * @method     ChildChannelOut findOneByCreatedAt(string $created_at) Return the first ChildChannelOut filtered by the created_at column
 * @method     ChildChannelOut findOneByUpdatedAt(string $updated_at) Return the first ChildChannelOut filtered by the updated_at column
 *
 * @method     ChildChannelOut[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildChannelOut objects based on current ModelCriteria
 * @method     ChildChannelOut[]|ObjectCollection findByIdAlertOut(int $id_alert_out) Return ChildChannelOut objects filtered by the id_alert_out column
 * @method     ChildChannelOut[]|ObjectCollection findByChannelId(int $channel_id) Return ChildChannelOut objects filtered by the channel_id column
 * @method     ChildChannelOut[]|ObjectCollection findByTargetId(int $target_id) Return ChildChannelOut objects filtered by the target_id column
 * @method     ChildChannelOut[]|ObjectCollection findByChannelOutParams(string $channel_out_params) Return ChildChannelOut objects filtered by the channel_out_params column
 * @method     ChildChannelOut[]|ObjectCollection findByChannelOutStatus(boolean $channel_out_status) Return ChildChannelOut objects filtered by the channel_out_status column
 * @method     ChildChannelOut[]|ObjectCollection findByChannelOutPriority(boolean $channel_out_priority) Return ChildChannelOut objects filtered by the channel_out_priority column
 * @method     ChildChannelOut[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildChannelOut objects filtered by the created_at column
 * @method     ChildChannelOut[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildChannelOut objects filtered by the updated_at column
 * @method     ChildChannelOut[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ChannelOutQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\ChannelOutQuery object.
     *
     * @param string $dbName     The database name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\ChannelOut', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildChannelOutQuery object.
     *
     * @param string   $modelAlias The alias of a model in the query
     * @param Criteria $criteria   Optional Criteria to build the query from
     *
     * @return ChildChannelOutQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildChannelOutQuery) {
            return $criteria;
        }
        $query = new ChildChannelOutQuery();
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
     * @return ChildChannelOut|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ChannelOutTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ChannelOutTableMap::DATABASE_NAME);
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
     * @return ChildChannelOut A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_ALERT_OUT, CHANNEL_ID, TARGET_ID, CHANNEL_OUT_PARAMS, CHANNEL_OUT_STATUS, CHANNEL_OUT_PRIORITY, CREATED_AT, UPDATED_AT FROM channel_out WHERE ID_ALERT_OUT = :p0';
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
            /** @var ChildChannelOut $obj */
            $obj = new ChildChannelOut();
            $obj->hydrate($row);
            ChannelOutTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildChannelOut|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(ChannelOutTableMap::COL_ID_ALERT_OUT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(ChannelOutTableMap::COL_ID_ALERT_OUT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_alert_out column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAlertOut(1234); // WHERE id_alert_out = 1234
     * $query->filterByIdAlertOut(array(12, 34)); // WHERE id_alert_out IN (12, 34)
     * $query->filterByIdAlertOut(array('min' => 12)); // WHERE id_alert_out > 12
     * </code>
     *
     * @param mixed  $idAlertOut The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByIdAlertOut($idAlertOut = null, $comparison = null)
    {
        if (is_array($idAlertOut)) {
            $useMinMax = false;
            if (isset($idAlertOut['min'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_ID_ALERT_OUT, $idAlertOut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAlertOut['max'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_ID_ALERT_OUT, $idAlertOut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_ID_ALERT_OUT, $idAlertOut, $comparison);
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
     * @param mixed  $channelId  The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByChannelId($channelId = null, $comparison = null)
    {
        if (is_array($channelId)) {
            $useMinMax = false;
            if (isset($channelId['min'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_ID, $channelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($channelId['max'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_ID, $channelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_ID, $channelId, $comparison);
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
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByTargetId($targetId = null, $comparison = null)
    {
        if (is_array($targetId)) {
            $useMinMax = false;
            if (isset($targetId['min'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_TARGET_ID, $targetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetId['max'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_TARGET_ID, $targetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_TARGET_ID, $targetId, $comparison);
    }

    /**
     * Filter the query on the channel_out_params column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelOutParams('fooValue');   // WHERE channel_out_params = 'fooValue'
     * $query->filterByChannelOutParams('%fooValue%'); // WHERE channel_out_params LIKE '%fooValue%'
     * </code>
     *
     * @param string $channelOutParams The value to use as filter.
     *                                 Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison       Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByChannelOutParams($channelOutParams = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($channelOutParams)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $channelOutParams)) {
                $channelOutParams = str_replace('*', '%', $channelOutParams);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_OUT_PARAMS, $channelOutParams, $comparison);
    }

    /**
     * Filter the query on the channel_out_status column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelOutStatus(true); // WHERE channel_out_status = true
     * $query->filterByChannelOutStatus('yes'); // WHERE channel_out_status = true
     * </code>
     *
     * @param boolean|string $channelOutStatus The value to use as filter.
     *                                         Non-boolean arguments are converted using the following rules:
     *                                         * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                                         * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *                                         Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string         $comparison       Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByChannelOutStatus($channelOutStatus = null, $comparison = null)
    {
        if (is_string($channelOutStatus)) {
            $channelOutStatus = in_array(strtolower($channelOutStatus), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_OUT_STATUS, $channelOutStatus, $comparison);
    }

    /**
     * Filter the query on the channel_out_priority column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelOutPriority(true); // WHERE channel_out_priority = true
     * $query->filterByChannelOutPriority('yes'); // WHERE channel_out_priority = true
     * </code>
     *
     * @param boolean|string $channelOutPriority The value to use as filter.
     *                                           Non-boolean arguments are converted using the following rules:
     *                                           * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                                           * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *                                           Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string         $comparison         Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByChannelOutPriority($channelOutPriority = null, $comparison = null)
    {
        if (is_string($channelOutPriority)) {
            $channelOutPriority = in_array(strtolower($channelOutPriority), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_OUT_PRIORITY, $channelOutPriority, $comparison);
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
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ChannelOutTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelOutTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Channel object
     *
     * @param \App\Model\Channel|ObjectCollection $channel    The related object(s) to use as filter
     * @param string                              $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByChannel($channel, $comparison = null)
    {
        if ($channel instanceof \App\Model\Channel) {
            return $this
                ->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_ID, $channel->getIdChannel(), $comparison);
        } elseif ($channel instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ChannelOutTableMap::COL_CHANNEL_ID, $channel->toKeyValue('PrimaryKey', 'IdChannel'), $comparison);
        } else {
            throw new PropelException('filterByChannel() only accepts arguments of type \App\Model\Channel or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Channel relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
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
     * @param string $relationAlias optional alias for the relation,
     *                              to be used as main alias in the secondary query
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Filter the query by a related \App\Model\Target object
     *
     * @param \App\Model\Target|ObjectCollection $target     The related object(s) to use as filter
     * @param string                             $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChannelOutQuery The current query, for fluid interface
     */
    public function filterByTarget($target, $comparison = null)
    {
        if ($target instanceof \App\Model\Target) {
            return $this
                ->addUsingAlias(ChannelOutTableMap::COL_TARGET_ID, $target->getIdTarget(), $comparison);
        } elseif ($target instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ChannelOutTableMap::COL_TARGET_ID, $target->toKeyValue('PrimaryKey', 'IdTarget'), $comparison);
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
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param ChildChannelOut $channelOut Object to remove from the list of results
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function prune($channelOut = null)
    {
        if ($channelOut) {
            $this->addUsingAlias(ChannelOutTableMap::COL_ID_ALERT_OUT, $channelOut->getIdAlertOut(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the channel_out table.
     *
     * @param  ConnectionInterface $con the connection to use
     * @return int                 The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelOutTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ChannelOutTableMap::clearInstancePool();
            ChannelOutTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelOutTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ChannelOutTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ChannelOutTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ChannelOutTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ChannelOutTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ChannelOutTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ChannelOutTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ChannelOutTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ChannelOutTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return $this|ChildChannelOutQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ChannelOutTableMap::COL_CREATED_AT);
    }

} // ChannelOutQuery
