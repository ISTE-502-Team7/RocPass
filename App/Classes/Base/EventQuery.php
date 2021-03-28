<?php

namespace Classes\Base;

use \Exception;
use \PDO;
use Classes\Event as ChildEvent;
use Classes\EventQuery as ChildEventQuery;
use Classes\Map\EventTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'event' table.
 *
 *
 *
 * @method     ChildEventQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEventQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildEventQuery orderByLocation($order = Criteria::ASC) Order by the location column
 * @method     ChildEventQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildEventQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 * @method     ChildEventQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 * @method     ChildEventQuery orderByVenueId($order = Criteria::ASC) Order by the venue_id column
 *
 * @method     ChildEventQuery groupById() Group by the id column
 * @method     ChildEventQuery groupByName() Group by the name column
 * @method     ChildEventQuery groupByLocation() Group by the location column
 * @method     ChildEventQuery groupByDescription() Group by the description column
 * @method     ChildEventQuery groupByStartDate() Group by the start_date column
 * @method     ChildEventQuery groupByEndDate() Group by the end_date column
 * @method     ChildEventQuery groupByVenueId() Group by the venue_id column
 *
 * @method     ChildEventQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEventQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEventQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEventQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEventQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEventQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEventQuery leftJoinVenue($relationAlias = null) Adds a LEFT JOIN clause to the query using the Venue relation
 * @method     ChildEventQuery rightJoinVenue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Venue relation
 * @method     ChildEventQuery innerJoinVenue($relationAlias = null) Adds a INNER JOIN clause to the query using the Venue relation
 *
 * @method     ChildEventQuery joinWithVenue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Venue relation
 *
 * @method     ChildEventQuery leftJoinWithVenue() Adds a LEFT JOIN clause and with to the query using the Venue relation
 * @method     ChildEventQuery rightJoinWithVenue() Adds a RIGHT JOIN clause and with to the query using the Venue relation
 * @method     ChildEventQuery innerJoinWithVenue() Adds a INNER JOIN clause and with to the query using the Venue relation
 *
 * @method     ChildEventQuery leftJoinEventImage($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventImage relation
 * @method     ChildEventQuery rightJoinEventImage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventImage relation
 * @method     ChildEventQuery innerJoinEventImage($relationAlias = null) Adds a INNER JOIN clause to the query using the EventImage relation
 *
 * @method     ChildEventQuery joinWithEventImage($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EventImage relation
 *
 * @method     ChildEventQuery leftJoinWithEventImage() Adds a LEFT JOIN clause and with to the query using the EventImage relation
 * @method     ChildEventQuery rightJoinWithEventImage() Adds a RIGHT JOIN clause and with to the query using the EventImage relation
 * @method     ChildEventQuery innerJoinWithEventImage() Adds a INNER JOIN clause and with to the query using the EventImage relation
 *
 * @method     ChildEventQuery leftJoinSubscribedEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscribedEvent relation
 * @method     ChildEventQuery rightJoinSubscribedEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscribedEvent relation
 * @method     ChildEventQuery innerJoinSubscribedEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscribedEvent relation
 *
 * @method     ChildEventQuery joinWithSubscribedEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SubscribedEvent relation
 *
 * @method     ChildEventQuery leftJoinWithSubscribedEvent() Adds a LEFT JOIN clause and with to the query using the SubscribedEvent relation
 * @method     ChildEventQuery rightJoinWithSubscribedEvent() Adds a RIGHT JOIN clause and with to the query using the SubscribedEvent relation
 * @method     ChildEventQuery innerJoinWithSubscribedEvent() Adds a INNER JOIN clause and with to the query using the SubscribedEvent relation
 *
 * @method     \Classes\VenueQuery|\Classes\EventImageQuery|\Classes\SubscribedEventQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEvent|null findOne(ConnectionInterface $con = null) Return the first ChildEvent matching the query
 * @method     ChildEvent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEvent matching the query, or a new ChildEvent object populated from the query conditions when no match is found
 *
 * @method     ChildEvent|null findOneById(int $id) Return the first ChildEvent filtered by the id column
 * @method     ChildEvent|null findOneByName(string $name) Return the first ChildEvent filtered by the name column
 * @method     ChildEvent|null findOneByLocation(string $location) Return the first ChildEvent filtered by the location column
 * @method     ChildEvent|null findOneByDescription(string $description) Return the first ChildEvent filtered by the description column
 * @method     ChildEvent|null findOneByStartDate(string $start_date) Return the first ChildEvent filtered by the start_date column
 * @method     ChildEvent|null findOneByEndDate(string $end_date) Return the first ChildEvent filtered by the end_date column
 * @method     ChildEvent|null findOneByVenueId(int $venue_id) Return the first ChildEvent filtered by the venue_id column *

 * @method     ChildEvent requirePk($key, ConnectionInterface $con = null) Return the ChildEvent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOne(ConnectionInterface $con = null) Return the first ChildEvent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvent requireOneById(int $id) Return the first ChildEvent filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOneByName(string $name) Return the first ChildEvent filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOneByLocation(string $location) Return the first ChildEvent filtered by the location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOneByDescription(string $description) Return the first ChildEvent filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOneByStartDate(string $start_date) Return the first ChildEvent filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOneByEndDate(string $end_date) Return the first ChildEvent filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvent requireOneByVenueId(int $venue_id) Return the first ChildEvent filtered by the venue_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvent[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEvent objects based on current ModelCriteria
 * @method     ChildEvent[]|ObjectCollection findById(int $id) Return ChildEvent objects filtered by the id column
 * @method     ChildEvent[]|ObjectCollection findByName(string $name) Return ChildEvent objects filtered by the name column
 * @method     ChildEvent[]|ObjectCollection findByLocation(string $location) Return ChildEvent objects filtered by the location column
 * @method     ChildEvent[]|ObjectCollection findByDescription(string $description) Return ChildEvent objects filtered by the description column
 * @method     ChildEvent[]|ObjectCollection findByStartDate(string $start_date) Return ChildEvent objects filtered by the start_date column
 * @method     ChildEvent[]|ObjectCollection findByEndDate(string $end_date) Return ChildEvent objects filtered by the end_date column
 * @method     ChildEvent[]|ObjectCollection findByVenueId(int $venue_id) Return ChildEvent objects filtered by the venue_id column
 * @method     ChildEvent[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EventQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Classes\Base\EventQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Classes\\Event', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEventQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEventQuery) {
            return $criteria;
        }
        $query = new ChildEventQuery();
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
     * @return ChildEvent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EventTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEvent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, location, description, start_date, end_date, venue_id FROM event WHERE id = :p0';
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
            /** @var ChildEvent $obj */
            $obj = new ChildEvent();
            $obj->hydrate($row);
            EventTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEvent|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EventTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EventTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EventTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EventTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE location = 'fooValue'
     * $query->filterByLocation('%fooValue%', Criteria::LIKE); // WHERE location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $location The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_LOCATION, $location, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the start_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE start_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(EventTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(EventTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE end_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(EventTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(EventTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_END_DATE, $endDate, $comparison);
    }

    /**
     * Filter the query on the venue_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVenueId(1234); // WHERE venue_id = 1234
     * $query->filterByVenueId(array(12, 34)); // WHERE venue_id IN (12, 34)
     * $query->filterByVenueId(array('min' => 12)); // WHERE venue_id > 12
     * </code>
     *
     * @see       filterByVenue()
     *
     * @param     mixed $venueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function filterByVenueId($venueId = null, $comparison = null)
    {
        if (is_array($venueId)) {
            $useMinMax = false;
            if (isset($venueId['min'])) {
                $this->addUsingAlias(EventTableMap::COL_VENUE_ID, $venueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($venueId['max'])) {
                $this->addUsingAlias(EventTableMap::COL_VENUE_ID, $venueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventTableMap::COL_VENUE_ID, $venueId, $comparison);
    }

    /**
     * Filter the query by a related \Classes\Venue object
     *
     * @param \Classes\Venue|ObjectCollection $venue The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEventQuery The current query, for fluid interface
     */
    public function filterByVenue($venue, $comparison = null)
    {
        if ($venue instanceof \Classes\Venue) {
            return $this
                ->addUsingAlias(EventTableMap::COL_VENUE_ID, $venue->getId(), $comparison);
        } elseif ($venue instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EventTableMap::COL_VENUE_ID, $venue->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByVenue() only accepts arguments of type \Classes\Venue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Venue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function joinVenue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Venue');

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
            $this->addJoinObject($join, 'Venue');
        }

        return $this;
    }

    /**
     * Use the Venue relation Venue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Classes\VenueQuery A secondary query class using the current class as primary query
     */
    public function useVenueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVenue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Venue', '\Classes\VenueQuery');
    }

    /**
     * Use the Venue relation Venue object
     *
     * @param callable(\Classes\VenueQuery):\Classes\VenueQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withVenueQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useVenueQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Filter the query by a related \Classes\EventImage object
     *
     * @param \Classes\EventImage|ObjectCollection $eventImage the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventQuery The current query, for fluid interface
     */
    public function filterByEventImage($eventImage, $comparison = null)
    {
        if ($eventImage instanceof \Classes\EventImage) {
            return $this
                ->addUsingAlias(EventTableMap::COL_ID, $eventImage->getEventId(), $comparison);
        } elseif ($eventImage instanceof ObjectCollection) {
            return $this
                ->useEventImageQuery()
                ->filterByPrimaryKeys($eventImage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventImage() only accepts arguments of type \Classes\EventImage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EventImage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function joinEventImage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventImage');

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
            $this->addJoinObject($join, 'EventImage');
        }

        return $this;
    }

    /**
     * Use the EventImage relation EventImage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Classes\EventImageQuery A secondary query class using the current class as primary query
     */
    public function useEventImageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEventImage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EventImage', '\Classes\EventImageQuery');
    }

    /**
     * Use the EventImage relation EventImage object
     *
     * @param callable(\Classes\EventImageQuery):\Classes\EventImageQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEventImageQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useEventImageQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Filter the query by a related \Classes\SubscribedEvent object
     *
     * @param \Classes\SubscribedEvent|ObjectCollection $subscribedEvent the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventQuery The current query, for fluid interface
     */
    public function filterBySubscribedEvent($subscribedEvent, $comparison = null)
    {
        if ($subscribedEvent instanceof \Classes\SubscribedEvent) {
            return $this
                ->addUsingAlias(EventTableMap::COL_ID, $subscribedEvent->getEventId(), $comparison);
        } elseif ($subscribedEvent instanceof ObjectCollection) {
            return $this
                ->useSubscribedEventQuery()
                ->filterByPrimaryKeys($subscribedEvent->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySubscribedEvent() only accepts arguments of type \Classes\SubscribedEvent or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SubscribedEvent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function joinSubscribedEvent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SubscribedEvent');

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
            $this->addJoinObject($join, 'SubscribedEvent');
        }

        return $this;
    }

    /**
     * Use the SubscribedEvent relation SubscribedEvent object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Classes\SubscribedEventQuery A secondary query class using the current class as primary query
     */
    public function useSubscribedEventQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSubscribedEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SubscribedEvent', '\Classes\SubscribedEventQuery');
    }

    /**
     * Use the SubscribedEvent relation SubscribedEvent object
     *
     * @param callable(\Classes\SubscribedEventQuery):\Classes\SubscribedEventQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withSubscribedEventQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useSubscribedEventQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEvent $event Object to remove from the list of results
     *
     * @return $this|ChildEventQuery The current query, for fluid interface
     */
    public function prune($event = null)
    {
        if ($event) {
            $this->addUsingAlias(EventTableMap::COL_ID, $event->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the event table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventTableMap::clearInstancePool();
            EventTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EventTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EventQuery
