<?php

namespace Classes\Map;

use Classes\Background;
use Classes\BackgroundQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'background' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class BackgroundTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Classes.Map.BackgroundTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'background';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Classes\\Background';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Classes.Background';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the age field
     */
    const COL_AGE = 'background.age';

    /**
     * the column name for the gender field
     */
    const COL_GENDER = 'background.gender';

    /**
     * the column name for the house_members field
     */
    const COL_HOUSE_MEMBERS = 'background.house_members';

    /**
     * the column name for the zipcode field
     */
    const COL_ZIPCODE = 'background.zipcode';

    /**
     * the column name for the nationality field
     */
    const COL_NATIONALITY = 'background.nationality';

    /**
     * the column name for the dob field
     */
    const COL_DOB = 'background.dob';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'background.user_id';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Age', 'Gender', 'HouseMembers', 'Zipcode', 'Nationality', 'Dob', 'UserId', ),
        self::TYPE_CAMELNAME     => array('age', 'gender', 'houseMembers', 'zipcode', 'nationality', 'dob', 'userId', ),
        self::TYPE_COLNAME       => array(BackgroundTableMap::COL_AGE, BackgroundTableMap::COL_GENDER, BackgroundTableMap::COL_HOUSE_MEMBERS, BackgroundTableMap::COL_ZIPCODE, BackgroundTableMap::COL_NATIONALITY, BackgroundTableMap::COL_DOB, BackgroundTableMap::COL_USER_ID, ),
        self::TYPE_FIELDNAME     => array('age', 'gender', 'house_members', 'zipcode', 'nationality', 'dob', 'user_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Age' => 0, 'Gender' => 1, 'HouseMembers' => 2, 'Zipcode' => 3, 'Nationality' => 4, 'Dob' => 5, 'UserId' => 6, ),
        self::TYPE_CAMELNAME     => array('age' => 0, 'gender' => 1, 'houseMembers' => 2, 'zipcode' => 3, 'nationality' => 4, 'dob' => 5, 'userId' => 6, ),
        self::TYPE_COLNAME       => array(BackgroundTableMap::COL_AGE => 0, BackgroundTableMap::COL_GENDER => 1, BackgroundTableMap::COL_HOUSE_MEMBERS => 2, BackgroundTableMap::COL_ZIPCODE => 3, BackgroundTableMap::COL_NATIONALITY => 4, BackgroundTableMap::COL_DOB => 5, BackgroundTableMap::COL_USER_ID => 6, ),
        self::TYPE_FIELDNAME     => array('age' => 0, 'gender' => 1, 'house_members' => 2, 'zipcode' => 3, 'nationality' => 4, 'dob' => 5, 'user_id' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'Age' => 'AGE',
        'Background.Age' => 'AGE',
        'age' => 'AGE',
        'background.age' => 'AGE',
        'BackgroundTableMap::COL_AGE' => 'AGE',
        'COL_AGE' => 'AGE',
        'age' => 'AGE',
        'background.age' => 'AGE',
        'Gender' => 'GENDER',
        'Background.Gender' => 'GENDER',
        'gender' => 'GENDER',
        'background.gender' => 'GENDER',
        'BackgroundTableMap::COL_GENDER' => 'GENDER',
        'COL_GENDER' => 'GENDER',
        'gender' => 'GENDER',
        'background.gender' => 'GENDER',
        'HouseMembers' => 'HOUSE_MEMBERS',
        'Background.HouseMembers' => 'HOUSE_MEMBERS',
        'houseMembers' => 'HOUSE_MEMBERS',
        'background.houseMembers' => 'HOUSE_MEMBERS',
        'BackgroundTableMap::COL_HOUSE_MEMBERS' => 'HOUSE_MEMBERS',
        'COL_HOUSE_MEMBERS' => 'HOUSE_MEMBERS',
        'house_members' => 'HOUSE_MEMBERS',
        'background.house_members' => 'HOUSE_MEMBERS',
        'Zipcode' => 'ZIPCODE',
        'Background.Zipcode' => 'ZIPCODE',
        'zipcode' => 'ZIPCODE',
        'background.zipcode' => 'ZIPCODE',
        'BackgroundTableMap::COL_ZIPCODE' => 'ZIPCODE',
        'COL_ZIPCODE' => 'ZIPCODE',
        'zipcode' => 'ZIPCODE',
        'background.zipcode' => 'ZIPCODE',
        'Nationality' => 'NATIONALITY',
        'Background.Nationality' => 'NATIONALITY',
        'nationality' => 'NATIONALITY',
        'background.nationality' => 'NATIONALITY',
        'BackgroundTableMap::COL_NATIONALITY' => 'NATIONALITY',
        'COL_NATIONALITY' => 'NATIONALITY',
        'nationality' => 'NATIONALITY',
        'background.nationality' => 'NATIONALITY',
        'Dob' => 'DOB',
        'Background.Dob' => 'DOB',
        'dob' => 'DOB',
        'background.dob' => 'DOB',
        'BackgroundTableMap::COL_DOB' => 'DOB',
        'COL_DOB' => 'DOB',
        'dob' => 'DOB',
        'background.dob' => 'DOB',
        'UserId' => 'USER_ID',
        'Background.UserId' => 'USER_ID',
        'userId' => 'USER_ID',
        'background.userId' => 'USER_ID',
        'BackgroundTableMap::COL_USER_ID' => 'USER_ID',
        'COL_USER_ID' => 'USER_ID',
        'user_id' => 'USER_ID',
        'background.user_id' => 'USER_ID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('background');
        $this->setPhpName('Background');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Classes\\Background');
        $this->setPackage('Classes');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('age', 'Age', 'INTEGER', true, null, null);
        $this->addColumn('gender', 'Gender', 'BOOLEAN', true, 1, null);
        $this->addColumn('house_members', 'HouseMembers', 'INTEGER', true, null, null);
        $this->addColumn('zipcode', 'Zipcode', 'INTEGER', true, null, null);
        $this->addColumn('nationality', 'Nationality', 'VARCHAR', true, 50, null);
        $this->addColumn('dob', 'Dob', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\Classes\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return null;
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return '';
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? BackgroundTableMap::CLASS_DEFAULT : BackgroundTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Background object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BackgroundTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BackgroundTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BackgroundTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BackgroundTableMap::OM_CLASS;
            /** @var Background $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BackgroundTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = BackgroundTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BackgroundTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Background $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BackgroundTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(BackgroundTableMap::COL_AGE);
            $criteria->addSelectColumn(BackgroundTableMap::COL_GENDER);
            $criteria->addSelectColumn(BackgroundTableMap::COL_HOUSE_MEMBERS);
            $criteria->addSelectColumn(BackgroundTableMap::COL_ZIPCODE);
            $criteria->addSelectColumn(BackgroundTableMap::COL_NATIONALITY);
            $criteria->addSelectColumn(BackgroundTableMap::COL_DOB);
            $criteria->addSelectColumn(BackgroundTableMap::COL_USER_ID);
        } else {
            $criteria->addSelectColumn($alias . '.age');
            $criteria->addSelectColumn($alias . '.gender');
            $criteria->addSelectColumn($alias . '.house_members');
            $criteria->addSelectColumn($alias . '.zipcode');
            $criteria->addSelectColumn($alias . '.nationality');
            $criteria->addSelectColumn($alias . '.dob');
            $criteria->addSelectColumn($alias . '.user_id');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(BackgroundTableMap::COL_AGE);
            $criteria->removeSelectColumn(BackgroundTableMap::COL_GENDER);
            $criteria->removeSelectColumn(BackgroundTableMap::COL_HOUSE_MEMBERS);
            $criteria->removeSelectColumn(BackgroundTableMap::COL_ZIPCODE);
            $criteria->removeSelectColumn(BackgroundTableMap::COL_NATIONALITY);
            $criteria->removeSelectColumn(BackgroundTableMap::COL_DOB);
            $criteria->removeSelectColumn(BackgroundTableMap::COL_USER_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.age');
            $criteria->removeSelectColumn($alias . '.gender');
            $criteria->removeSelectColumn($alias . '.house_members');
            $criteria->removeSelectColumn($alias . '.zipcode');
            $criteria->removeSelectColumn($alias . '.nationality');
            $criteria->removeSelectColumn($alias . '.dob');
            $criteria->removeSelectColumn($alias . '.user_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(BackgroundTableMap::DATABASE_NAME)->getTable(BackgroundTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BackgroundTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BackgroundTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BackgroundTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Background or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Background object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BackgroundTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Classes\Background) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The Background object has no primary key');
        }

        $query = BackgroundQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BackgroundTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BackgroundTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the background table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BackgroundQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Background or Criteria object.
     *
     * @param mixed               $criteria Criteria or Background object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BackgroundTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Background object
        }


        // Set the correct dbName
        $query = BackgroundQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BackgroundTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BackgroundTableMap::buildTableMap();
