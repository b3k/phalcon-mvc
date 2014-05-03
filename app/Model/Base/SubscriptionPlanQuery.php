<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\SubscriptionPlan as ChildSubscriptionPlan;
use App\Model\SubscriptionPlanQuery as ChildSubscriptionPlanQuery;
use App\Model\Map\SubscriptionPlanTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'subscription_plan' table.
 *
 *
 *
 * @method     ChildSubscriptionPlanQuery orderByIdSubscriptionPlan($order = Criteria::ASC) Order by the id_subscription_plan column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanName($order = Criteria::ASC) Order by the subscription_plan_name column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanDescription($order = Criteria::ASC) Order by the subscription_plan_description column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanPrice($order = Criteria::ASC) Order by the subscription_plan_price column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanPeriod($order = Criteria::ASC) Order by the subscription_plan_period column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanCode($order = Criteria::ASC) Order by the subscription_plan_code column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanMaxTarget($order = Criteria::ASC) Order by the subscription_plan_max_target column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanCheckInterval($order = Criteria::ASC) Order by the subscription_plan_check_interval column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanMaxLocalizations($order = Criteria::ASC) Order by the subscription_plan_max_localizations column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanRss($order = Criteria::ASC) Order by the subscription_plan_rss column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanMaxSubAccounts($order = Criteria::ASC) Order by the subscription_plan_max_sub_accounts column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanMaxAlertReceivers($order = Criteria::ASC) Order by the subscription_plan_max_alert_receivers column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanMaxTrigger($order = Criteria::ASC) Order by the subscription_plan_max_trigger column
 * @method     ChildSubscriptionPlanQuery orderBySubscriptionPlanSmsInPeriod($order = Criteria::ASC) Order by the subscription_plan_sms_in_period column
 * @method     ChildSubscriptionPlanQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSubscriptionPlanQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildSubscriptionPlanQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 *
 * @method     ChildSubscriptionPlanQuery groupByIdSubscriptionPlan() Group by the id_subscription_plan column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanName() Group by the subscription_plan_name column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanDescription() Group by the subscription_plan_description column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanPrice() Group by the subscription_plan_price column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanPeriod() Group by the subscription_plan_period column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanCode() Group by the subscription_plan_code column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanMaxTarget() Group by the subscription_plan_max_target column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanCheckInterval() Group by the subscription_plan_check_interval column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanMaxLocalizations() Group by the subscription_plan_max_localizations column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanRss() Group by the subscription_plan_rss column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanMaxSubAccounts() Group by the subscription_plan_max_sub_accounts column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanMaxAlertReceivers() Group by the subscription_plan_max_alert_receivers column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanMaxTrigger() Group by the subscription_plan_max_trigger column
 * @method     ChildSubscriptionPlanQuery groupBySubscriptionPlanSmsInPeriod() Group by the subscription_plan_sms_in_period column
 * @method     ChildSubscriptionPlanQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSubscriptionPlanQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildSubscriptionPlanQuery groupBySlug() Group by the slug column
 *
 * @method     ChildSubscriptionPlanQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSubscriptionPlanQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSubscriptionPlanQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSubscriptionPlanQuery leftJoinSubscriptionPlanChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriptionPlanChannel relation
 * @method     ChildSubscriptionPlanQuery rightJoinSubscriptionPlanChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriptionPlanChannel relation
 * @method     ChildSubscriptionPlanQuery innerJoinSubscriptionPlanChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriptionPlanChannel relation
 *
 * @method     \App\Model\SubscriptionPlanChannelQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSubscriptionPlan findOne(ConnectionInterface $con = null) Return the first ChildSubscriptionPlan matching the query
 * @method     ChildSubscriptionPlan findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSubscriptionPlan matching the query, or a new ChildSubscriptionPlan object populated from the query conditions when no match is found
 *
 * @method     ChildSubscriptionPlan findOneByIdSubscriptionPlan(int $id_subscription_plan) Return the first ChildSubscriptionPlan filtered by the id_subscription_plan column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanName(string $subscription_plan_name) Return the first ChildSubscriptionPlan filtered by the subscription_plan_name column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanDescription(string $subscription_plan_description) Return the first ChildSubscriptionPlan filtered by the subscription_plan_description column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanPrice(string $subscription_plan_price) Return the first ChildSubscriptionPlan filtered by the subscription_plan_price column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanPeriod(int $subscription_plan_period) Return the first ChildSubscriptionPlan filtered by the subscription_plan_period column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanCode(string $subscription_plan_code) Return the first ChildSubscriptionPlan filtered by the subscription_plan_code column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanMaxTarget(int $subscription_plan_max_target) Return the first ChildSubscriptionPlan filtered by the subscription_plan_max_target column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanCheckInterval(int $subscription_plan_check_interval) Return the first ChildSubscriptionPlan filtered by the subscription_plan_check_interval column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanMaxLocalizations(int $subscription_plan_max_localizations) Return the first ChildSubscriptionPlan filtered by the subscription_plan_max_localizations column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanRss(boolean $subscription_plan_rss) Return the first ChildSubscriptionPlan filtered by the subscription_plan_rss column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanMaxSubAccounts(int $subscription_plan_max_sub_accounts) Return the first ChildSubscriptionPlan filtered by the subscription_plan_max_sub_accounts column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanMaxAlertReceivers(int $subscription_plan_max_alert_receivers) Return the first ChildSubscriptionPlan filtered by the subscription_plan_max_alert_receivers column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanMaxTrigger(int $subscription_plan_max_trigger) Return the first ChildSubscriptionPlan filtered by the subscription_plan_max_trigger column
 * @method     ChildSubscriptionPlan findOneBySubscriptionPlanSmsInPeriod(int $subscription_plan_sms_in_period) Return the first ChildSubscriptionPlan filtered by the subscription_plan_sms_in_period column
 * @method     ChildSubscriptionPlan findOneByCreatedAt(string $created_at) Return the first ChildSubscriptionPlan filtered by the created_at column
 * @method     ChildSubscriptionPlan findOneByUpdatedAt(string $updated_at) Return the first ChildSubscriptionPlan filtered by the updated_at column
 * @method     ChildSubscriptionPlan findOneBySlug(string $slug) Return the first ChildSubscriptionPlan filtered by the slug column
 *
 * @method     ChildSubscriptionPlan[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSubscriptionPlan objects based on current ModelCriteria
 * @method     ChildSubscriptionPlan[]|ObjectCollection findByIdSubscriptionPlan(int $id_subscription_plan) Return ChildSubscriptionPlan objects filtered by the id_subscription_plan column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanName(string $subscription_plan_name) Return ChildSubscriptionPlan objects filtered by the subscription_plan_name column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanDescription(string $subscription_plan_description) Return ChildSubscriptionPlan objects filtered by the subscription_plan_description column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanPrice(string $subscription_plan_price) Return ChildSubscriptionPlan objects filtered by the subscription_plan_price column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanPeriod(int $subscription_plan_period) Return ChildSubscriptionPlan objects filtered by the subscription_plan_period column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanCode(string $subscription_plan_code) Return ChildSubscriptionPlan objects filtered by the subscription_plan_code column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanMaxTarget(int $subscription_plan_max_target) Return ChildSubscriptionPlan objects filtered by the subscription_plan_max_target column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanCheckInterval(int $subscription_plan_check_interval) Return ChildSubscriptionPlan objects filtered by the subscription_plan_check_interval column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanMaxLocalizations(int $subscription_plan_max_localizations) Return ChildSubscriptionPlan objects filtered by the subscription_plan_max_localizations column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanRss(boolean $subscription_plan_rss) Return ChildSubscriptionPlan objects filtered by the subscription_plan_rss column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanMaxSubAccounts(int $subscription_plan_max_sub_accounts) Return ChildSubscriptionPlan objects filtered by the subscription_plan_max_sub_accounts column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanMaxAlertReceivers(int $subscription_plan_max_alert_receivers) Return ChildSubscriptionPlan objects filtered by the subscription_plan_max_alert_receivers column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanMaxTrigger(int $subscription_plan_max_trigger) Return ChildSubscriptionPlan objects filtered by the subscription_plan_max_trigger column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySubscriptionPlanSmsInPeriod(int $subscription_plan_sms_in_period) Return ChildSubscriptionPlan objects filtered by the subscription_plan_sms_in_period column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildSubscriptionPlan objects filtered by the created_at column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildSubscriptionPlan objects filtered by the updated_at column
 * @method     ChildSubscriptionPlan[]|ObjectCollection findBySlug(string $slug) Return ChildSubscriptionPlan objects filtered by the slug column
 * @method     ChildSubscriptionPlan[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SubscriptionPlanQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \App\Model\Base\SubscriptionPlanQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\SubscriptionPlan', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSubscriptionPlanQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSubscriptionPlanQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSubscriptionPlanQuery) {
            return $criteria;
        }
        $query = new ChildSubscriptionPlanQuery();
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
     * @return ChildSubscriptionPlan|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SubscriptionPlanTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SubscriptionPlanTableMap::DATABASE_NAME);
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
     * @return ChildSubscriptionPlan A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID_SUBSCRIPTION_PLAN, SUBSCRIPTION_PLAN_NAME, SUBSCRIPTION_PLAN_DESCRIPTION, SUBSCRIPTION_PLAN_PRICE, SUBSCRIPTION_PLAN_PERIOD, SUBSCRIPTION_PLAN_CODE, SUBSCRIPTION_PLAN_MAX_TARGET, SUBSCRIPTION_PLAN_CHECK_INTERVAL, SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS, SUBSCRIPTION_PLAN_RSS, SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS, SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS, SUBSCRIPTION_PLAN_MAX_TRIGGER, SUBSCRIPTION_PLAN_SMS_IN_PERIOD, CREATED_AT, UPDATED_AT, SLUG FROM subscription_plan WHERE ID_SUBSCRIPTION_PLAN = :p0';
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
            /** @var ChildSubscriptionPlan $obj */
            $obj = new ChildSubscriptionPlan();
            $obj->hydrate($row);
            SubscriptionPlanTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSubscriptionPlan|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $keys, Criteria::IN);
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
     * @param     mixed $idSubscriptionPlan The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterByIdSubscriptionPlan($idSubscriptionPlan = null, $comparison = null)
    {
        if (is_array($idSubscriptionPlan)) {
            $useMinMax = false;
            if (isset($idSubscriptionPlan['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $idSubscriptionPlan['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSubscriptionPlan['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $idSubscriptionPlan['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $idSubscriptionPlan, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanName('fooValue');   // WHERE subscription_plan_name = 'fooValue'
     * $query->filterBySubscriptionPlanName('%fooValue%'); // WHERE subscription_plan_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subscriptionPlanName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanName($subscriptionPlanName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subscriptionPlanName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subscriptionPlanName)) {
                $subscriptionPlanName = str_replace('*', '%', $subscriptionPlanName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_NAME, $subscriptionPlanName, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_description column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanDescription('fooValue');   // WHERE subscription_plan_description = 'fooValue'
     * $query->filterBySubscriptionPlanDescription('%fooValue%'); // WHERE subscription_plan_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subscriptionPlanDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanDescription($subscriptionPlanDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subscriptionPlanDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subscriptionPlanDescription)) {
                $subscriptionPlanDescription = str_replace('*', '%', $subscriptionPlanDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_DESCRIPTION, $subscriptionPlanDescription, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_price column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanPrice(1234); // WHERE subscription_plan_price = 1234
     * $query->filterBySubscriptionPlanPrice(array(12, 34)); // WHERE subscription_plan_price IN (12, 34)
     * $query->filterBySubscriptionPlanPrice(array('min' => 12)); // WHERE subscription_plan_price > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanPrice($subscriptionPlanPrice = null, $comparison = null)
    {
        if (is_array($subscriptionPlanPrice)) {
            $useMinMax = false;
            if (isset($subscriptionPlanPrice['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE, $subscriptionPlanPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanPrice['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE, $subscriptionPlanPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PRICE, $subscriptionPlanPrice, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_period column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanPeriod(1234); // WHERE subscription_plan_period = 1234
     * $query->filterBySubscriptionPlanPeriod(array(12, 34)); // WHERE subscription_plan_period IN (12, 34)
     * $query->filterBySubscriptionPlanPeriod(array('min' => 12)); // WHERE subscription_plan_period > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanPeriod The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanPeriod($subscriptionPlanPeriod = null, $comparison = null)
    {
        if (is_array($subscriptionPlanPeriod)) {
            $useMinMax = false;
            if (isset($subscriptionPlanPeriod['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD, $subscriptionPlanPeriod['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanPeriod['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD, $subscriptionPlanPeriod['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_PERIOD, $subscriptionPlanPeriod, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_code column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanCode('fooValue');   // WHERE subscription_plan_code = 'fooValue'
     * $query->filterBySubscriptionPlanCode('%fooValue%'); // WHERE subscription_plan_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subscriptionPlanCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanCode($subscriptionPlanCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subscriptionPlanCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subscriptionPlanCode)) {
                $subscriptionPlanCode = str_replace('*', '%', $subscriptionPlanCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CODE, $subscriptionPlanCode, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_max_target column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanMaxTarget(1234); // WHERE subscription_plan_max_target = 1234
     * $query->filterBySubscriptionPlanMaxTarget(array(12, 34)); // WHERE subscription_plan_max_target IN (12, 34)
     * $query->filterBySubscriptionPlanMaxTarget(array('min' => 12)); // WHERE subscription_plan_max_target > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanMaxTarget The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanMaxTarget($subscriptionPlanMaxTarget = null, $comparison = null)
    {
        if (is_array($subscriptionPlanMaxTarget)) {
            $useMinMax = false;
            if (isset($subscriptionPlanMaxTarget['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET, $subscriptionPlanMaxTarget['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanMaxTarget['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET, $subscriptionPlanMaxTarget['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TARGET, $subscriptionPlanMaxTarget, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_check_interval column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanCheckInterval(1234); // WHERE subscription_plan_check_interval = 1234
     * $query->filterBySubscriptionPlanCheckInterval(array(12, 34)); // WHERE subscription_plan_check_interval IN (12, 34)
     * $query->filterBySubscriptionPlanCheckInterval(array('min' => 12)); // WHERE subscription_plan_check_interval > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanCheckInterval The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanCheckInterval($subscriptionPlanCheckInterval = null, $comparison = null)
    {
        if (is_array($subscriptionPlanCheckInterval)) {
            $useMinMax = false;
            if (isset($subscriptionPlanCheckInterval['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL, $subscriptionPlanCheckInterval['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanCheckInterval['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL, $subscriptionPlanCheckInterval['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_CHECK_INTERVAL, $subscriptionPlanCheckInterval, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_max_localizations column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanMaxLocalizations(1234); // WHERE subscription_plan_max_localizations = 1234
     * $query->filterBySubscriptionPlanMaxLocalizations(array(12, 34)); // WHERE subscription_plan_max_localizations IN (12, 34)
     * $query->filterBySubscriptionPlanMaxLocalizations(array('min' => 12)); // WHERE subscription_plan_max_localizations > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanMaxLocalizations The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanMaxLocalizations($subscriptionPlanMaxLocalizations = null, $comparison = null)
    {
        if (is_array($subscriptionPlanMaxLocalizations)) {
            $useMinMax = false;
            if (isset($subscriptionPlanMaxLocalizations['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS, $subscriptionPlanMaxLocalizations['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanMaxLocalizations['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS, $subscriptionPlanMaxLocalizations['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_LOCALIZATIONS, $subscriptionPlanMaxLocalizations, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_rss column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanRss(true); // WHERE subscription_plan_rss = true
     * $query->filterBySubscriptionPlanRss('yes'); // WHERE subscription_plan_rss = true
     * </code>
     *
     * @param     boolean|string $subscriptionPlanRss The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanRss($subscriptionPlanRss = null, $comparison = null)
    {
        if (is_string($subscriptionPlanRss)) {
            $subscriptionPlanRss = in_array(strtolower($subscriptionPlanRss), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_RSS, $subscriptionPlanRss, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_max_sub_accounts column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanMaxSubAccounts(1234); // WHERE subscription_plan_max_sub_accounts = 1234
     * $query->filterBySubscriptionPlanMaxSubAccounts(array(12, 34)); // WHERE subscription_plan_max_sub_accounts IN (12, 34)
     * $query->filterBySubscriptionPlanMaxSubAccounts(array('min' => 12)); // WHERE subscription_plan_max_sub_accounts > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanMaxSubAccounts The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanMaxSubAccounts($subscriptionPlanMaxSubAccounts = null, $comparison = null)
    {
        if (is_array($subscriptionPlanMaxSubAccounts)) {
            $useMinMax = false;
            if (isset($subscriptionPlanMaxSubAccounts['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS, $subscriptionPlanMaxSubAccounts['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanMaxSubAccounts['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS, $subscriptionPlanMaxSubAccounts['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_SUB_ACCOUNTS, $subscriptionPlanMaxSubAccounts, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_max_alert_receivers column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanMaxAlertReceivers(1234); // WHERE subscription_plan_max_alert_receivers = 1234
     * $query->filterBySubscriptionPlanMaxAlertReceivers(array(12, 34)); // WHERE subscription_plan_max_alert_receivers IN (12, 34)
     * $query->filterBySubscriptionPlanMaxAlertReceivers(array('min' => 12)); // WHERE subscription_plan_max_alert_receivers > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanMaxAlertReceivers The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanMaxAlertReceivers($subscriptionPlanMaxAlertReceivers = null, $comparison = null)
    {
        if (is_array($subscriptionPlanMaxAlertReceivers)) {
            $useMinMax = false;
            if (isset($subscriptionPlanMaxAlertReceivers['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS, $subscriptionPlanMaxAlertReceivers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanMaxAlertReceivers['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS, $subscriptionPlanMaxAlertReceivers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_ALERT_RECEIVERS, $subscriptionPlanMaxAlertReceivers, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_max_trigger column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanMaxTrigger(1234); // WHERE subscription_plan_max_trigger = 1234
     * $query->filterBySubscriptionPlanMaxTrigger(array(12, 34)); // WHERE subscription_plan_max_trigger IN (12, 34)
     * $query->filterBySubscriptionPlanMaxTrigger(array('min' => 12)); // WHERE subscription_plan_max_trigger > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanMaxTrigger The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanMaxTrigger($subscriptionPlanMaxTrigger = null, $comparison = null)
    {
        if (is_array($subscriptionPlanMaxTrigger)) {
            $useMinMax = false;
            if (isset($subscriptionPlanMaxTrigger['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER, $subscriptionPlanMaxTrigger['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanMaxTrigger['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER, $subscriptionPlanMaxTrigger['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_MAX_TRIGGER, $subscriptionPlanMaxTrigger, $comparison);
    }

    /**
     * Filter the query on the subscription_plan_sms_in_period column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionPlanSmsInPeriod(1234); // WHERE subscription_plan_sms_in_period = 1234
     * $query->filterBySubscriptionPlanSmsInPeriod(array(12, 34)); // WHERE subscription_plan_sms_in_period IN (12, 34)
     * $query->filterBySubscriptionPlanSmsInPeriod(array('min' => 12)); // WHERE subscription_plan_sms_in_period > 12
     * </code>
     *
     * @param     mixed $subscriptionPlanSmsInPeriod The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanSmsInPeriod($subscriptionPlanSmsInPeriod = null, $comparison = null)
    {
        if (is_array($subscriptionPlanSmsInPeriod)) {
            $useMinMax = false;
            if (isset($subscriptionPlanSmsInPeriod['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD, $subscriptionPlanSmsInPeriod['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionPlanSmsInPeriod['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD, $subscriptionPlanSmsInPeriod['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SUBSCRIPTION_PLAN_SMS_IN_PERIOD, $subscriptionPlanSmsInPeriod, $comparison);
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
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SubscriptionPlanTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_SLUG, $slug, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\SubscriptionPlanChannel object
     *
     * @param \App\Model\SubscriptionPlanChannel|ObjectCollection $subscriptionPlanChannel  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function filterBySubscriptionPlanChannel($subscriptionPlanChannel, $comparison = null)
    {
        if ($subscriptionPlanChannel instanceof \App\Model\SubscriptionPlanChannel) {
            return $this
                ->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $subscriptionPlanChannel->getIdSubscriptionPlan(), $comparison);
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
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSubscriptionPlan $subscriptionPlan Object to remove from the list of results
     *
     * @return $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function prune($subscriptionPlan = null)
    {
        if ($subscriptionPlan) {
            $this->addUsingAlias(SubscriptionPlanTableMap::COL_ID_SUBSCRIPTION_PLAN, $subscriptionPlan->getIdSubscriptionPlan(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the subscription_plan table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SubscriptionPlanTableMap::clearInstancePool();
            SubscriptionPlanTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionPlanTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SubscriptionPlanTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SubscriptionPlanTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SubscriptionPlanTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SubscriptionPlanTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SubscriptionPlanTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SubscriptionPlanTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SubscriptionPlanTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildSubscriptionPlanQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SubscriptionPlanTableMap::COL_CREATED_AT);
    }

} // SubscriptionPlanQuery
