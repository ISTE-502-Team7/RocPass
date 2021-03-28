<?php

namespace Classes\Base;

use \Exception;
use \PDO;
use Classes\VenueImage as ChildVenueImage;
use Classes\VenueImageQuery as ChildVenueImageQuery;
use Classes\Map\VenueImageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'venue_image' table.
 *
 *
 *
 * @method     ChildVenueImageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVenueImageQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildVenueImageQuery orderByPath($order = Criteria::ASC) Order by the path column
 * @method     ChildVenueImageQuery orderByVenueId($order = Criteria::ASC) Order by the venue_id column
 *
 * @method     ChildVenueImageQuery groupById() Group by the id column
 * @method     ChildVenueImageQuery groupByName() Group by the name column
 * @method     ChildVenueImageQuery groupByPath() Group by the path column
 * @method     ChildVenueImageQuery groupByVenueId() Group by the venue_id column
 *
 * @method     ChildVenueImageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVenueImageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVenueImageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVenueImageQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVenueImageQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVenueImageQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVenueImageQuery leftJoinVenue($relationAlias = null) Adds a LEFT JOIN clause to the query using the Venue relation
 * @method     ChildVenueImageQuery rightJoinVenue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Venue relation
 * @method     ChildVenueImageQuery innerJoinVenue($relationAlias = null) Adds a INNER JOIN clause to the query using the Venue relation
 *
 * @method     ChildVenueImageQuery joinWithVenue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Venue relation
 *
 * @method     ChildVenueImageQuery leftJoinWithVenue() Adds a LEFT JOIN clause and with to the query using the Venue relation
 * @method     ChildVenueImageQuery rightJoinWithVenue() Adds a RIGHT JOIN clause and with to the query using the Venue relation
 * @method     ChildVenueImageQuery innerJoinWithVenue() Adds a INNER JOIN clause and with to the query using the Venue relation
 *
 * @method     \Classes\VenueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVenueImage|null findOne(ConnectionInterface $con = null) Return the first ChildVenueImage matching the query
 * @method     ChildVenueImage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVenueImage matching the query, or a new ChildVenueImage object populated from the query conditions when no match is found
 *
 * @method     ChildVenueImage|null findOneById(int $id) Return the first ChildVenueImage filtered by the id column
 * @method     ChildVenueImage|null findOneByName(string $name) Return the first ChildVenueImage filtered by the name column
 * @method     ChildVenueImage|null findOneByPath(string $path) Return the first ChildVenueImage filtered by the path column
 * @method     ChildVenueImage|null findOneByVenueId(int $venue_id) Return the first ChildVenueImage filtered by the venue_id column *

 * @method     ChildVenueImage requirePk($key, ConnectionInterface $con = null) Return the ChildVenueImage by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVenueImage requireOne(ConnectionInterface $con = null) Return the first ChildVenueImage matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVenueImage requireOneById(int $id) Return the first ChildVenueImage filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVenueImage requireOneByName(string $name) Return the first ChildVenueImage filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVenueImage requireOneByPath(string $path) Return the first ChildVenueImage filtered by the path column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVenueImage requireOneByVenueId(int $venue_id) Return the first ChildVenueImage filtered by the venue_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVenueImage[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVenueImage objects based on current ModelCriteria
 * @method     ChildVenueImage[]|ObjectCollection findById(int $id) Return ChildVenueImage objects filtered by the id column
 * @method     ChildVenueImage[]|ObjectCollection findByName(string $name) Return ChildVenueImage objects filtered by the name column
 * @method     ChildVenueImage[]|ObjectCollection findByPath(string $path) Return ChildVenueImage objects filtered by the path column
 * @method     ChildVenueImage[]|ObjectCollection findByVenueId(int $venue_id) Return ChildVenueImage objects filtered by the venue_id column
 * @method     ChildVenueImage[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VenueImageQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Classes\Base\VenueImageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Classes\\VenueImage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVenueImageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVenueImageQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVenueImageQuery) {
            return $criteria;
        }
        $query = new ChildVenueImageQuery();
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
     * @return ChildVenueImage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VenueImageTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VenueImageTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildVenueImage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, path, venue_id FROM venue_image WHERE id = :p0';
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
            /** @var ChildVenueImage $obj */
            $obj = new ChildVenueImage();
            $obj->hydrate($row);
            VenueImageTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVenueImage|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VenueImageTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VenueImageTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VenueImageTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VenueImageTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VenueImageTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VenueImageTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the path column
     *
     * Example usage:
     * <code>
     * $query->filterByPath('fooValue');   // WHERE path = 'fooValue'
     * $query->filterByPath('%fooValue%', Criteria::LIKE); // WHERE path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $path The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterByPath($path = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($path)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VenueImageTableMap::COL_PATH, $path, $comparison);
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
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterByVenueId($venueId = null, $comparison = null)
    {
        if (is_array($venueId)) {
            $useMinMax = false;
            if (isset($venueId['min'])) {
                $this->addUsingAlias(VenueImageTableMap::COL_VENUE_ID, $venueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($venueId['max'])) {
                $this->addUsingAlias(VenueImageTableMap::COL_VENUE_ID, $venueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VenueImageTableMap::COL_VENUE_ID, $venueId, $comparison);
    }

    /**
     * Filter the query by a related \Classes\Venue object
     *
     * @param \Classes\Venue|ObjectCollection $venue The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVenueImageQuery The current query, for fluid interface
     */
    public function filterByVenue($venue, $comparison = null)
    {
        if ($venue instanceof \Classes\Venue) {
            return $this
                ->addUsingAlias(VenueImageTableMap::COL_VENUE_ID, $venue->getId(), $comparison);
        } elseif ($venue instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VenueImageTableMap::COL_VENUE_ID, $venue->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildVenueImage $venueImage Object to remove from the list of results
     *
     * @return $this|ChildVenueImageQuery The current query, for fluid interface
     */
    public function prune($venueImage = null)
    {
        if ($venueImage) {
            $this->addUsingAlias(VenueImageTableMap::COL_ID, $venueImage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the venue_image table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VenueImageTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VenueImageTableMap::clearInstancePool();
            VenueImageTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VenueImageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VenueImageTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VenueImageTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VenueImageTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VenueImageQuery
