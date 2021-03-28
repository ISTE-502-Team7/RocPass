<?php

namespace Classes\Base;

use \Exception;
use \PDO;
use Classes\Organization as ChildOrganization;
use Classes\OrganizationQuery as ChildOrganizationQuery;
use Classes\Map\OrganizationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'organization' table.
 *
 *
 *
 * @method     ChildOrganizationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrganizationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildOrganizationQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 *
 * @method     ChildOrganizationQuery groupById() Group by the id column
 * @method     ChildOrganizationQuery groupByName() Group by the name column
 * @method     ChildOrganizationQuery groupByUserId() Group by the user_id column
 *
 * @method     ChildOrganizationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrganizationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrganizationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrganizationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOrganizationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOrganizationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOrganizationQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildOrganizationQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildOrganizationQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildOrganizationQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildOrganizationQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildOrganizationQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildOrganizationQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildOrganizationQuery leftJoinVenue($relationAlias = null) Adds a LEFT JOIN clause to the query using the Venue relation
 * @method     ChildOrganizationQuery rightJoinVenue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Venue relation
 * @method     ChildOrganizationQuery innerJoinVenue($relationAlias = null) Adds a INNER JOIN clause to the query using the Venue relation
 *
 * @method     ChildOrganizationQuery joinWithVenue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Venue relation
 *
 * @method     ChildOrganizationQuery leftJoinWithVenue() Adds a LEFT JOIN clause and with to the query using the Venue relation
 * @method     ChildOrganizationQuery rightJoinWithVenue() Adds a RIGHT JOIN clause and with to the query using the Venue relation
 * @method     ChildOrganizationQuery innerJoinWithVenue() Adds a INNER JOIN clause and with to the query using the Venue relation
 *
 * @method     \Classes\UserQuery|\Classes\VenueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOrganization|null findOne(ConnectionInterface $con = null) Return the first ChildOrganization matching the query
 * @method     ChildOrganization findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrganization matching the query, or a new ChildOrganization object populated from the query conditions when no match is found
 *
 * @method     ChildOrganization|null findOneById(int $id) Return the first ChildOrganization filtered by the id column
 * @method     ChildOrganization|null findOneByName(string $name) Return the first ChildOrganization filtered by the name column
 * @method     ChildOrganization|null findOneByUserId(int $user_id) Return the first ChildOrganization filtered by the user_id column *

 * @method     ChildOrganization requirePk($key, ConnectionInterface $con = null) Return the ChildOrganization by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrganization requireOne(ConnectionInterface $con = null) Return the first ChildOrganization matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrganization requireOneById(int $id) Return the first ChildOrganization filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrganization requireOneByName(string $name) Return the first ChildOrganization filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOrganization requireOneByUserId(int $user_id) Return the first ChildOrganization filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOrganization[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOrganization objects based on current ModelCriteria
 * @method     ChildOrganization[]|ObjectCollection findById(int $id) Return ChildOrganization objects filtered by the id column
 * @method     ChildOrganization[]|ObjectCollection findByName(string $name) Return ChildOrganization objects filtered by the name column
 * @method     ChildOrganization[]|ObjectCollection findByUserId(int $user_id) Return ChildOrganization objects filtered by the user_id column
 * @method     ChildOrganization[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OrganizationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Classes\Base\OrganizationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Classes\\Organization', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrganizationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrganizationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOrganizationQuery) {
            return $criteria;
        }
        $query = new ChildOrganizationQuery();
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
     * @return ChildOrganization|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrganizationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OrganizationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildOrganization A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, user_id FROM organization WHERE id = :p0';
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
            /** @var ChildOrganization $obj */
            $obj = new ChildOrganization();
            $obj->hydrate($row);
            OrganizationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOrganization|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrganizationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrganizationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrganizationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrganizationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganizationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganizationTableMap::COL_NAME, $name, $comparison);
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
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(OrganizationTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(OrganizationTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganizationTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query by a related \Classes\User object
     *
     * @param \Classes\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Classes\User) {
            return $this
                ->addUsingAlias(OrganizationTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrganizationTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Classes\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
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
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Classes\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Classes\UserQuery');
    }

    /**
     * Use the User relation User object
     *
     * @param callable(\Classes\UserQuery):\Classes\UserQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useUserQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Filter the query by a related \Classes\Venue object
     *
     * @param \Classes\Venue|ObjectCollection $venue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrganizationQuery The current query, for fluid interface
     */
    public function filterByVenue($venue, $comparison = null)
    {
        if ($venue instanceof \Classes\Venue) {
            return $this
                ->addUsingAlias(OrganizationTableMap::COL_ID, $venue->getOrgId(), $comparison);
        } elseif ($venue instanceof ObjectCollection) {
            return $this
                ->useVenueQuery()
                ->filterByPrimaryKeys($venue->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
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
     * @param   ChildOrganization $organization Object to remove from the list of results
     *
     * @return $this|ChildOrganizationQuery The current query, for fluid interface
     */
    public function prune($organization = null)
    {
        if ($organization) {
            $this->addUsingAlias(OrganizationTableMap::COL_ID, $organization->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the organization table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrganizationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrganizationTableMap::clearInstancePool();
            OrganizationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OrganizationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrganizationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OrganizationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrganizationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OrganizationQuery
