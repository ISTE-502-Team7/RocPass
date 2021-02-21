<?php

namespace Classes\Base;

use \Exception;
use Classes\Background as ChildBackground;
use Classes\BackgroundQuery as ChildBackgroundQuery;
use Classes\Map\BackgroundTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'background' table.
 *
 *
 *
 * @method     ChildBackgroundQuery orderByAge($order = Criteria::ASC) Order by the age column
 * @method     ChildBackgroundQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildBackgroundQuery orderByHouseMembers($order = Criteria::ASC) Order by the house_members column
 * @method     ChildBackgroundQuery orderByZipcode($order = Criteria::ASC) Order by the zipcode column
 * @method     ChildBackgroundQuery orderByNationality($order = Criteria::ASC) Order by the nationality column
 * @method     ChildBackgroundQuery orderByDob($order = Criteria::ASC) Order by the dob column
 * @method     ChildBackgroundQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 *
 * @method     ChildBackgroundQuery groupByAge() Group by the age column
 * @method     ChildBackgroundQuery groupByGender() Group by the gender column
 * @method     ChildBackgroundQuery groupByHouseMembers() Group by the house_members column
 * @method     ChildBackgroundQuery groupByZipcode() Group by the zipcode column
 * @method     ChildBackgroundQuery groupByNationality() Group by the nationality column
 * @method     ChildBackgroundQuery groupByDob() Group by the dob column
 * @method     ChildBackgroundQuery groupByUserId() Group by the user_id column
 *
 * @method     ChildBackgroundQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBackgroundQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBackgroundQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBackgroundQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBackgroundQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBackgroundQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBackgroundQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildBackgroundQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildBackgroundQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildBackgroundQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildBackgroundQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildBackgroundQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildBackgroundQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     \Classes\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBackground|null findOne(ConnectionInterface $con = null) Return the first ChildBackground matching the query
 * @method     ChildBackground findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBackground matching the query, or a new ChildBackground object populated from the query conditions when no match is found
 *
 * @method     ChildBackground|null findOneByAge(int $age) Return the first ChildBackground filtered by the age column
 * @method     ChildBackground|null findOneByGender(boolean $gender) Return the first ChildBackground filtered by the gender column
 * @method     ChildBackground|null findOneByHouseMembers(int $house_members) Return the first ChildBackground filtered by the house_members column
 * @method     ChildBackground|null findOneByZipcode(int $zipcode) Return the first ChildBackground filtered by the zipcode column
 * @method     ChildBackground|null findOneByNationality(string $nationality) Return the first ChildBackground filtered by the nationality column
 * @method     ChildBackground|null findOneByDob(string $dob) Return the first ChildBackground filtered by the dob column
 * @method     ChildBackground|null findOneByUserId(int $user_id) Return the first ChildBackground filtered by the user_id column *

 * @method     ChildBackground requirePk($key, ConnectionInterface $con = null) Return the ChildBackground by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOne(ConnectionInterface $con = null) Return the first ChildBackground matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBackground requireOneByAge(int $age) Return the first ChildBackground filtered by the age column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOneByGender(boolean $gender) Return the first ChildBackground filtered by the gender column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOneByHouseMembers(int $house_members) Return the first ChildBackground filtered by the house_members column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOneByZipcode(int $zipcode) Return the first ChildBackground filtered by the zipcode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOneByNationality(string $nationality) Return the first ChildBackground filtered by the nationality column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOneByDob(string $dob) Return the first ChildBackground filtered by the dob column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBackground requireOneByUserId(int $user_id) Return the first ChildBackground filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBackground[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBackground objects based on current ModelCriteria
 * @method     ChildBackground[]|ObjectCollection findByAge(int $age) Return ChildBackground objects filtered by the age column
 * @method     ChildBackground[]|ObjectCollection findByGender(boolean $gender) Return ChildBackground objects filtered by the gender column
 * @method     ChildBackground[]|ObjectCollection findByHouseMembers(int $house_members) Return ChildBackground objects filtered by the house_members column
 * @method     ChildBackground[]|ObjectCollection findByZipcode(int $zipcode) Return ChildBackground objects filtered by the zipcode column
 * @method     ChildBackground[]|ObjectCollection findByNationality(string $nationality) Return ChildBackground objects filtered by the nationality column
 * @method     ChildBackground[]|ObjectCollection findByDob(string $dob) Return ChildBackground objects filtered by the dob column
 * @method     ChildBackground[]|ObjectCollection findByUserId(int $user_id) Return ChildBackground objects filtered by the user_id column
 * @method     ChildBackground[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BackgroundQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Classes\Base\BackgroundQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Classes\\Background', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBackgroundQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBackgroundQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBackgroundQuery) {
            return $criteria;
        }
        $query = new ChildBackgroundQuery();
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
     * @return ChildBackground|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The Background object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The Background object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The Background object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The Background object has no primary key');
    }

    /**
     * Filter the query on the age column
     *
     * Example usage:
     * <code>
     * $query->filterByAge(1234); // WHERE age = 1234
     * $query->filterByAge(array(12, 34)); // WHERE age IN (12, 34)
     * $query->filterByAge(array('min' => 12)); // WHERE age > 12
     * </code>
     *
     * @param     mixed $age The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByAge($age = null, $comparison = null)
    {
        if (is_array($age)) {
            $useMinMax = false;
            if (isset($age['min'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_AGE, $age['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($age['max'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_AGE, $age['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_AGE, $age, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender(true); // WHERE gender = true
     * $query->filterByGender('yes'); // WHERE gender = true
     * </code>
     *
     * @param     boolean|string $gender The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (is_string($gender)) {
            $gender = in_array(strtolower($gender), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_GENDER, $gender, $comparison);
    }

    /**
     * Filter the query on the house_members column
     *
     * Example usage:
     * <code>
     * $query->filterByHouseMembers(1234); // WHERE house_members = 1234
     * $query->filterByHouseMembers(array(12, 34)); // WHERE house_members IN (12, 34)
     * $query->filterByHouseMembers(array('min' => 12)); // WHERE house_members > 12
     * </code>
     *
     * @param     mixed $houseMembers The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByHouseMembers($houseMembers = null, $comparison = null)
    {
        if (is_array($houseMembers)) {
            $useMinMax = false;
            if (isset($houseMembers['min'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_HOUSE_MEMBERS, $houseMembers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($houseMembers['max'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_HOUSE_MEMBERS, $houseMembers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_HOUSE_MEMBERS, $houseMembers, $comparison);
    }

    /**
     * Filter the query on the zipcode column
     *
     * Example usage:
     * <code>
     * $query->filterByZipcode(1234); // WHERE zipcode = 1234
     * $query->filterByZipcode(array(12, 34)); // WHERE zipcode IN (12, 34)
     * $query->filterByZipcode(array('min' => 12)); // WHERE zipcode > 12
     * </code>
     *
     * @param     mixed $zipcode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByZipcode($zipcode = null, $comparison = null)
    {
        if (is_array($zipcode)) {
            $useMinMax = false;
            if (isset($zipcode['min'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_ZIPCODE, $zipcode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($zipcode['max'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_ZIPCODE, $zipcode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_ZIPCODE, $zipcode, $comparison);
    }

    /**
     * Filter the query on the nationality column
     *
     * Example usage:
     * <code>
     * $query->filterByNationality('fooValue');   // WHERE nationality = 'fooValue'
     * $query->filterByNationality('%fooValue%', Criteria::LIKE); // WHERE nationality LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nationality The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByNationality($nationality = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nationality)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_NATIONALITY, $nationality, $comparison);
    }

    /**
     * Filter the query on the dob column
     *
     * Example usage:
     * <code>
     * $query->filterByDob('2011-03-14'); // WHERE dob = '2011-03-14'
     * $query->filterByDob('now'); // WHERE dob = '2011-03-14'
     * $query->filterByDob(array('max' => 'yesterday')); // WHERE dob > '2011-03-13'
     * </code>
     *
     * @param     mixed $dob The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByDob($dob = null, $comparison = null)
    {
        if (is_array($dob)) {
            $useMinMax = false;
            if (isset($dob['min'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_DOB, $dob['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dob['max'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_DOB, $dob['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_DOB, $dob, $comparison);
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
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(BackgroundTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BackgroundTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query by a related \Classes\User object
     *
     * @param \Classes\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBackgroundQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Classes\User) {
            return $this
                ->addUsingAlias(BackgroundTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BackgroundTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildBackground $background Object to remove from the list of results
     *
     * @return $this|ChildBackgroundQuery The current query, for fluid interface
     */
    public function prune($background = null)
    {
        if ($background) {
            throw new LogicException('Background object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the background table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BackgroundTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BackgroundTableMap::clearInstancePool();
            BackgroundTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BackgroundTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BackgroundTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BackgroundTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BackgroundTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BackgroundQuery
