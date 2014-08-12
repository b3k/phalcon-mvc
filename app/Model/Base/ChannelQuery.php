<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\Channel as ChildChannel;
use App\Model\ChannelQuery as ChildChannelQuery;
use App\Model\Map\ChannelTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'channel' table.
 *
 *
 *
 * @method     ChildChannelQuery orderByIdChannel($order = Criteria::ASC) Order by the id_channel column
 * @method     ChildChannelQuery orderByChannelClass($order = Criteria::ASC) Order by the channel_class column
 * @method     ChildChannelQuery orderByChannelName($order = Criteria::ASC) Order by the channel_name column
 * @method     ChildChannelQuery orderByChannelDescription($order = Criteria::ASC) Order by the channel_description column
 * @method     ChildChannelQuery orderByChannelActive($order = Criteria::ASC) Order by the channel_active column
 * @method     ChildChannelQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildChannelQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildChannelQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 *
 * @method     ChildChannelQuery groupByIdChannel() Group by the id_channel column
 * @method     ChildChannelQuery groupByChannelClass() Group by the channel_class column
 * @method     ChildChannelQuery groupByChannelName() Group by the channel_name column
 * @method     ChildChannelQuery groupByChannelDescription() Group by the channel_description column
 * @method     ChildChannelQuery groupByChannelActive() Group by the channel_active column
 * @method     ChildChannelQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildChannelQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildChannelQuery groupBySlug() Group by the slug column
 *
 * @method     ChildChannelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildChannelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildChannelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildChannelQuery leftJoinChannelOut($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChannelOut relation
 * @method     ChildChannelQuery rightJoinChannelOut($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChannelOut relation
 * @method     ChildChannelQuery innerJoinChannelOut($relationAlias = null) Adds a INNER JOIN clause to the query using the ChannelOut relation
 *
 * @method     ChildChannelQuery leftJoinSubscriptionPlanChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriptionPlanChannel relation
 * @method     ChildChannelQuery rightJoinSubscriptionPlanChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriptionPlanChannel relation
 * @method     ChildChannelQuery innerJoinSubscriptionPlanChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriptionPlanChannel relation
 *
 * @method     ChildChannelQuery leftJoinTriggerType($relationAlias = null) Adds a LEFT JOIN clause to the query using the TriggerType relation
 * @method     ChildChannelQuery rightJoinTriggerType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TriggerType relation
 * @method     ChildChannelQuery innerJoinTriggerType($relationAlias = null) Adds a INNER JOIN clause to the query using the TriggerType relation
 *
 * @method     \App\Model\ChannelOutQuery|\App\Model\SubscriptionPlanChannelQuery|\App\Model\TriggerTypeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildChannel findOne(ConnectionInterface $con = null) Return the first ChildChannel matching the query
 * @method     ChildChannel findOneOrCreate(ConnectionInterface $con = null) Return the first ChildChannel matching the query, or a new ChildChannel object populated from the query conditions when no match is found
 *
 * @method     ChildChannel findOneByIdChannel(int $id_channel) Return the first ChildChannel filtered by the id_channel column
 * @method     ChildChannel findOneByChannelClass(string $channel_class) Return the first ChildChannel filtered by the channel_class column
 * @method     ChildChannel findOneByChannelName(string $channel_name) Return the first ChildChannel filtered by the channel_name column
 * @method     ChildChannel findOneByChannelDescription(string $channel_description) Return the first ChildChannel filtered by the channel_description column
 * @method     ChildChannel findOneByChannelActive(boolean $channel_active) Return the first ChildChannel filtered by the channel_active column
 * @method     ChildChannel findOneByCreatedAt(string $created_at) Return the first ChildChannel filtered by the created_at column
 * @method     ChildChannel findOneByUpdatedAt(string $updated_at) Return the first ChildChannel filtered by the updated_at column
 * @method     ChildChannel findOneBySlug(string $slug) Return the first ChildChannel filtered by the slug column
 *
 * @method     ChildChannel[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildChannel objects based on current ModelCriteria
 * @method     ChildChannel[]|ObjectCollection findByIdChannel(int $id_channel) Return ChildChannel objects filtered by the id_channel column
 * @method     ChildChannel[]|ObjectCollection findByChannelClass(string $channel_class) Return ChildChannel objects filtered by the channel_class column
 * @method     ChildChannel[]|ObjectCollection findByChannelName(string $channel_name) Return ChildChannel objects filtered by the channel_name column
 * @method     ChildChannel[]|ObjectCollection findByChannelDescription(string $channel_description) Return ChildChannel objects filtered by the channel_description column
 * @method     ChildChannel[]|ObjectCollection findByChannelActive(boolean $channel_active) Return ChildChannel objects filtered by the channel_active column
 * @method     ChildChannel[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildChannel objects filtered by the created_at column
 * @method     ChildChannel[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildChannel objects filtered by the updated_at column
 * @method     ChildChannel[]|ObjectCollection findBySlug(string $slug) Return ChildChannel objects filtered by the slug column
 * @method     ChildChannel[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ChannelQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\ChannelQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\Channel', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildChannelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildChannelQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildChannelQuery) {
            return $criteria;
        }
        $query = new ChildChannelQuery();
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
     * @return ChildChannel|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ChannelTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ChannelTableMap::DATABASE_NAME);
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
     * @return ChildChannel A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `ID_CHANNEL`, `CHANNEL_CLASS`, `CHANNEL_NAME`, `CHANNEL_DESCRIPTION`, `CHANNEL_ACTIVE`, `CREATED_AT`, `UPDATED_AT`, `SLUG` FROM `channel` WHERE `ID_CHANNEL` = :p0';
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
            /** @var ChildChannel $obj */
            $obj = new ChildChannel();
            $obj->hydrate($row);
            ChannelTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildChannel|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $keys, Criteria::IN);
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
     * @param     mixed $idChannel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByIdChannel($idChannel = null, $comparison = null)
    {
        if (is_array($idChannel)) {
            $useMinMax = false;
            if (isset($idChannel['min'])) {
                $this->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $idChannel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idChannel['max'])) {
                $this->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $idChannel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $idChannel, $comparison);
    }

    /**
     * Filter the query on the channel_class column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelClass('fooValue');   // WHERE channel_class = 'fooValue'
     * $query->filterByChannelClass('%fooValue%'); // WHERE channel_class LIKE '%fooValue%'
     * </code>
     *
     * @param     string $channelClass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByChannelClass($channelClass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($channelClass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $channelClass)) {
                $channelClass = str_replace('*', '%', $channelClass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_CHANNEL_CLASS, $channelClass, $comparison);
    }

    /**
     * Filter the query on the channel_name column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelName('fooValue');   // WHERE channel_name = 'fooValue'
     * $query->filterByChannelName('%fooValue%'); // WHERE channel_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $channelName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByChannelName($channelName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($channelName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $channelName)) {
                $channelName = str_replace('*', '%', $channelName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_CHANNEL_NAME, $channelName, $comparison);
    }

    /**
     * Filter the query on the channel_description column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelDescription('fooValue');   // WHERE channel_description = 'fooValue'
     * $query->filterByChannelDescription('%fooValue%'); // WHERE channel_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $channelDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByChannelDescription($channelDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($channelDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $channelDescription)) {
                $channelDescription = str_replace('*', '%', $channelDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_CHANNEL_DESCRIPTION, $channelDescription, $comparison);
    }

    /**
     * Filter the query on the channel_active column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelActive(true); // WHERE channel_active = true
     * $query->filterByChannelActive('yes'); // WHERE channel_active = true
     * </code>
     *
     * @param     boolean|string $channelActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByChannelActive($channelActive = null, $comparison = null)
    {
        if (is_string($channelActive)) {
            $channelActive = in_array(strtolower($channelActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ChannelTableMap::COL_CHANNEL_ACTIVE, $channelActive, $comparison);
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
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ChannelTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ChannelTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ChannelTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ChannelTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the slug column
     *
     * Example usage:
     * <code>
     * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
     * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slug The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function filterBySlug($slug = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slug)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slug)) {
                $slug = str_replace('*', '%', $slug);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChannelTableMap::COL_SLUG, $slug, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\ChannelOut object
     *
     * @param \App\Model\ChannelOut|ObjectCollection $channelOut  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChannelQuery The current query, for fluid interface
     */
    public function filterByChannelOut($channelOut, $comparison = null)
    {
        if ($channelOut instanceof \App\Model\ChannelOut) {
            return $this
                ->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $channelOut->getChannelId(), $comparison);
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
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
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
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Filter the query by a related \App\Model\SubscriptionPlanChannel object
     *
     * @param \App\Model\SubscriptionPlanChannel|ObjectCollection $subscriptionPlanChannel  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChannelQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanChannel($subscriptionPlanChannel, $comparison = null)
    {
        if ($subscriptionPlanChannel instanceof \App\Model\SubscriptionPlanChannel) {
            return $this
                ->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $subscriptionPlanChannel->getIdChannel(), $comparison);
        } elseif ($subscriptionPlanChannel instanceof ObjectCollection) {
            return $this
                ->useSubscriptionPlanChannelQuery()
                ->filterByPrimaryKeys($subscriptionPlanChannel->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySubscriptionPlanChannel() only accepts arguments of type \App\Model\SubscriptionPlanChannel or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SubscriptionPlanChannel relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function joinSubscriptionPlanChannel($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SubscriptionPlanChannel');

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
            $this->addJoinObject($join, 'SubscriptionPlanChannel');
        }

        return $this;
    }

    /**
     * Use the SubscriptionPlanChannel relation SubscriptionPlanChannel object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\SubscriptionPlanChannelQuery A secondary query class using the current class as primary query
     */
    public function useSubscriptionPlanChannelQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSubscriptionPlanChannel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SubscriptionPlanChannel', '\App\Model\SubscriptionPlanChannelQuery');
    }

    /**
     * Filter the query by a related \App\Model\TriggerType object
     *
     * @param \App\Model\TriggerType|ObjectCollection $triggerType  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChannelQuery The current query, for fluid interface
     */
    public function filterByTriggerType($triggerType, $comparison = null)
    {
        if ($triggerType instanceof \App\Model\TriggerType) {
            return $this
                ->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $triggerType->getChannelId(), $comparison);
        } elseif ($triggerType instanceof ObjectCollection) {
            return $this
                ->useTriggerTypeQuery()
                ->filterByPrimaryKeys($triggerType->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTriggerType() only accepts arguments of type \App\Model\TriggerType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TriggerType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
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
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
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
     * Exclude object from result
     *
     * @param   ChildChannel $channel Object to remove from the list of results
     *
     * @return $this|ChildChannelQuery The current query, for fluid interface
     */
    public function prune($channel = null)
    {
        if ($channel) {
            $this->addUsingAlias(ChannelTableMap::COL_ID_CHANNEL, $channel->getIdChannel(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the channel table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ChannelTableMap::clearInstancePool();
            ChannelTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ChannelTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ChannelTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ChannelTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ChannelTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildChannelQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ChannelTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildChannelQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ChannelTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildChannelQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ChannelTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildChannelQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ChannelTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildChannelQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ChannelTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildChannelQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ChannelTableMap::COL_CREATED_AT);
    }

} // ChannelQuery
