<?php

namespace Classes\Base;

use \Exception;
use \PDO;
use Classes\Background as ChildBackground;
use Classes\BackgroundQuery as ChildBackgroundQuery;
use Classes\Organization as ChildOrganization;
use Classes\OrganizationQuery as ChildOrganizationQuery;
use Classes\Pass as ChildPass;
use Classes\PassQuery as ChildPassQuery;
use Classes\SubscribedEvent as ChildSubscribedEvent;
use Classes\SubscribedEventQuery as ChildSubscribedEventQuery;
use Classes\User as ChildUser;
use Classes\UserQuery as ChildUserQuery;
use Classes\Map\BackgroundTableMap;
use Classes\Map\OrganizationTableMap;
use Classes\Map\PassTableMap;
use Classes\Map\SubscribedEventTableMap;
use Classes\Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'user' table.
 *
 *
 *
 * @package    propel.generator.Classes.Base
 */
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Classes\\Map\\UserTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the first_name field.
     *
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the last_name field.
     *
     * @var        string|null
     */
    protected $last_name;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     *
     * @var        string
     */
    protected $password;

    /**
     * The value for the email_addr field.
     *
     * @var        string
     */
    protected $email_addr;

    /**
     * The value for the role field.
     *
     * @var        int
     */
    protected $role;

    /**
     * @var        ObjectCollection|ChildBackground[] Collection to store aggregation of ChildBackground objects.
     */
    protected $collBackgrounds;
    protected $collBackgroundsPartial;

    /**
     * @var        ObjectCollection|ChildOrganization[] Collection to store aggregation of ChildOrganization objects.
     */
    protected $collOrganizations;
    protected $collOrganizationsPartial;

    /**
     * @var        ObjectCollection|ChildPass[] Collection to store aggregation of ChildPass objects.
     */
    protected $collPasses;
    protected $collPassesPartial;

    /**
     * @var        ObjectCollection|ChildSubscribedEvent[] Collection to store aggregation of ChildSubscribedEvent objects.
     */
    protected $collSubscribedEvents;
    protected $collSubscribedEventsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBackground[]
     */
    protected $backgroundsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildOrganization[]
     */
    protected $organizationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPass[]
     */
    protected $passesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSubscribedEvent[]
     */
    protected $subscribedEventsScheduledForDeletion = null;

    /**
     * Initializes internal state of Classes\Base\User object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email_addr] column value.
     *
     * @return string
     */
    public function getEmailAddr()
    {
        return $this->email_addr;
    }

    /**
     * Get the [role] column value.
     *
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[UserTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    } // setFirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param string|null $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[UserTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    } // setLastName()

    /**
     * Set the value of [username] column.
     *
     * @param string $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param string $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [email_addr] column.
     *
     * @param string $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setEmailAddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email_addr !== $v) {
            $this->email_addr = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL_ADDR] = true;
        }

        return $this;
    } // setEmailAddr()

    /**
     * Set the value of [role] column.
     *
     * @param int $v New value
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function setRole($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->role !== $v) {
            $this->role = $v;
            $this->modifiedColumns[UserTableMap::COL_ROLE] = true;
        }

        return $this;
    } // setRole()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('EmailAddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_addr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('Role', TableMap::TYPE_PHPNAME, $indexType)];
            $this->role = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Classes\\User'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBackgrounds = null;

            $this->collOrganizations = null;

            $this->collPasses = null;

            $this->collSubscribedEvents = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->backgroundsScheduledForDeletion !== null) {
                if (!$this->backgroundsScheduledForDeletion->isEmpty()) {
                    \Classes\BackgroundQuery::create()
                        ->filterByPrimaryKeys($this->backgroundsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->backgroundsScheduledForDeletion = null;
                }
            }

            if ($this->collBackgrounds !== null) {
                foreach ($this->collBackgrounds as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->organizationsScheduledForDeletion !== null) {
                if (!$this->organizationsScheduledForDeletion->isEmpty()) {
                    \Classes\OrganizationQuery::create()
                        ->filterByPrimaryKeys($this->organizationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->organizationsScheduledForDeletion = null;
                }
            }

            if ($this->collOrganizations !== null) {
                foreach ($this->collOrganizations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->passesScheduledForDeletion !== null) {
                if (!$this->passesScheduledForDeletion->isEmpty()) {
                    \Classes\PassQuery::create()
                        ->filterByPrimaryKeys($this->passesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->passesScheduledForDeletion = null;
                }
            }

            if ($this->collPasses !== null) {
                foreach ($this->collPasses as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->subscribedEventsScheduledForDeletion !== null) {
                if (!$this->subscribedEventsScheduledForDeletion->isEmpty()) {
                    \Classes\SubscribedEventQuery::create()
                        ->filterByPrimaryKeys($this->subscribedEventsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->subscribedEventsScheduledForDeletion = null;
                }
            }

            if ($this->collSubscribedEvents !== null) {
                foreach ($this->collSubscribedEvents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL_ADDR)) {
            $modifiedColumns[':p' . $index++]  = 'email_addr';
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'role';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'first_name':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);
                        break;
                    case 'last_name':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'email_addr':
                        $stmt->bindValue($identifier, $this->email_addr, PDO::PARAM_STR);
                        break;
                    case 'role':
                        $stmt->bindValue($identifier, $this->role, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFirstName();
                break;
            case 2:
                return $this->getLastName();
                break;
            case 3:
                return $this->getUsername();
                break;
            case 4:
                return $this->getPassword();
                break;
            case 5:
                return $this->getEmailAddr();
                break;
            case 6:
                return $this->getRole();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFirstName(),
            $keys[2] => $this->getLastName(),
            $keys[3] => $this->getUsername(),
            $keys[4] => $this->getPassword(),
            $keys[5] => $this->getEmailAddr(),
            $keys[6] => $this->getRole(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collBackgrounds) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'backgrounds';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'backgrounds';
                        break;
                    default:
                        $key = 'Backgrounds';
                }

                $result[$key] = $this->collBackgrounds->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrganizations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'organizations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'organizations';
                        break;
                    default:
                        $key = 'Organizations';
                }

                $result[$key] = $this->collOrganizations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPasses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'passes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'passes';
                        break;
                    default:
                        $key = 'Passes';
                }

                $result[$key] = $this->collPasses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSubscribedEvents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'subscribedEvents';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'subscribed_events';
                        break;
                    default:
                        $key = 'SubscribedEvents';
                }

                $result[$key] = $this->collSubscribedEvents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Classes\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Classes\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFirstName($value);
                break;
            case 2:
                $this->setLastName($value);
                break;
            case 3:
                $this->setUsername($value);
                break;
            case 4:
                $this->setPassword($value);
                break;
            case 5:
                $this->setEmailAddr($value);
                break;
            case 6:
                $this->setRole($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFirstName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLastName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUsername($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPassword($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEmailAddr($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRole($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Classes\User The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRST_NAME)) {
            $criteria->add(UserTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_NAME)) {
            $criteria->add(UserTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL_ADDR)) {
            $criteria->add(UserTableMap::COL_EMAIL_ADDR, $this->email_addr);
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $criteria->add(UserTableMap::COL_ROLE, $this->role);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Classes\User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmailAddr($this->getEmailAddr());
        $copyObj->setRole($this->getRole());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBackgrounds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBackground($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrganizations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrganization($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPasses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPass($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSubscribedEvents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubscribedEvent($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Classes\User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Background' === $relationName) {
            $this->initBackgrounds();
            return;
        }
        if ('Organization' === $relationName) {
            $this->initOrganizations();
            return;
        }
        if ('Pass' === $relationName) {
            $this->initPasses();
            return;
        }
        if ('SubscribedEvent' === $relationName) {
            $this->initSubscribedEvents();
            return;
        }
    }

    /**
     * Clears out the collBackgrounds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBackgrounds()
     */
    public function clearBackgrounds()
    {
        $this->collBackgrounds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBackgrounds collection loaded partially.
     */
    public function resetPartialBackgrounds($v = true)
    {
        $this->collBackgroundsPartial = $v;
    }

    /**
     * Initializes the collBackgrounds collection.
     *
     * By default this just sets the collBackgrounds collection to an empty array (like clearcollBackgrounds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBackgrounds($overrideExisting = true)
    {
        if (null !== $this->collBackgrounds && !$overrideExisting) {
            return;
        }

        $collectionClassName = BackgroundTableMap::getTableMap()->getCollectionClassName();

        $this->collBackgrounds = new $collectionClassName;
        $this->collBackgrounds->setModel('\Classes\Background');
    }

    /**
     * Gets an array of ChildBackground objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBackground[] List of ChildBackground objects
     * @throws PropelException
     */
    public function getBackgrounds(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBackgroundsPartial && !$this->isNew();
        if (null === $this->collBackgrounds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collBackgrounds) {
                    $this->initBackgrounds();
                } else {
                    $collectionClassName = BackgroundTableMap::getTableMap()->getCollectionClassName();

                    $collBackgrounds = new $collectionClassName;
                    $collBackgrounds->setModel('\Classes\Background');

                    return $collBackgrounds;
                }
            } else {
                $collBackgrounds = ChildBackgroundQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBackgroundsPartial && count($collBackgrounds)) {
                        $this->initBackgrounds(false);

                        foreach ($collBackgrounds as $obj) {
                            if (false == $this->collBackgrounds->contains($obj)) {
                                $this->collBackgrounds->append($obj);
                            }
                        }

                        $this->collBackgroundsPartial = true;
                    }

                    return $collBackgrounds;
                }

                if ($partial && $this->collBackgrounds) {
                    foreach ($this->collBackgrounds as $obj) {
                        if ($obj->isNew()) {
                            $collBackgrounds[] = $obj;
                        }
                    }
                }

                $this->collBackgrounds = $collBackgrounds;
                $this->collBackgroundsPartial = false;
            }
        }

        return $this->collBackgrounds;
    }

    /**
     * Sets a collection of ChildBackground objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $backgrounds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBackgrounds(Collection $backgrounds, ConnectionInterface $con = null)
    {
        /** @var ChildBackground[] $backgroundsToDelete */
        $backgroundsToDelete = $this->getBackgrounds(new Criteria(), $con)->diff($backgrounds);


        $this->backgroundsScheduledForDeletion = $backgroundsToDelete;

        foreach ($backgroundsToDelete as $backgroundRemoved) {
            $backgroundRemoved->setUser(null);
        }

        $this->collBackgrounds = null;
        foreach ($backgrounds as $background) {
            $this->addBackground($background);
        }

        $this->collBackgrounds = $backgrounds;
        $this->collBackgroundsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Background objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Background objects.
     * @throws PropelException
     */
    public function countBackgrounds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBackgroundsPartial && !$this->isNew();
        if (null === $this->collBackgrounds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBackgrounds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBackgrounds());
            }

            $query = ChildBackgroundQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collBackgrounds);
    }

    /**
     * Method called to associate a ChildBackground object to this object
     * through the ChildBackground foreign key attribute.
     *
     * @param  ChildBackground $l ChildBackground
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function addBackground(ChildBackground $l)
    {
        if ($this->collBackgrounds === null) {
            $this->initBackgrounds();
            $this->collBackgroundsPartial = true;
        }

        if (!$this->collBackgrounds->contains($l)) {
            $this->doAddBackground($l);

            if ($this->backgroundsScheduledForDeletion and $this->backgroundsScheduledForDeletion->contains($l)) {
                $this->backgroundsScheduledForDeletion->remove($this->backgroundsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBackground $background The ChildBackground object to add.
     */
    protected function doAddBackground(ChildBackground $background)
    {
        $this->collBackgrounds[]= $background;
        $background->setUser($this);
    }

    /**
     * @param  ChildBackground $background The ChildBackground object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBackground(ChildBackground $background)
    {
        if ($this->getBackgrounds()->contains($background)) {
            $pos = $this->collBackgrounds->search($background);
            $this->collBackgrounds->remove($pos);
            if (null === $this->backgroundsScheduledForDeletion) {
                $this->backgroundsScheduledForDeletion = clone $this->collBackgrounds;
                $this->backgroundsScheduledForDeletion->clear();
            }
            $this->backgroundsScheduledForDeletion[]= clone $background;
            $background->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collOrganizations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOrganizations()
     */
    public function clearOrganizations()
    {
        $this->collOrganizations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOrganizations collection loaded partially.
     */
    public function resetPartialOrganizations($v = true)
    {
        $this->collOrganizationsPartial = $v;
    }

    /**
     * Initializes the collOrganizations collection.
     *
     * By default this just sets the collOrganizations collection to an empty array (like clearcollOrganizations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrganizations($overrideExisting = true)
    {
        if (null !== $this->collOrganizations && !$overrideExisting) {
            return;
        }

        $collectionClassName = OrganizationTableMap::getTableMap()->getCollectionClassName();

        $this->collOrganizations = new $collectionClassName;
        $this->collOrganizations->setModel('\Classes\Organization');
    }

    /**
     * Gets an array of ChildOrganization objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildOrganization[] List of ChildOrganization objects
     * @throws PropelException
     */
    public function getOrganizations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOrganizationsPartial && !$this->isNew();
        if (null === $this->collOrganizations || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collOrganizations) {
                    $this->initOrganizations();
                } else {
                    $collectionClassName = OrganizationTableMap::getTableMap()->getCollectionClassName();

                    $collOrganizations = new $collectionClassName;
                    $collOrganizations->setModel('\Classes\Organization');

                    return $collOrganizations;
                }
            } else {
                $collOrganizations = ChildOrganizationQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrganizationsPartial && count($collOrganizations)) {
                        $this->initOrganizations(false);

                        foreach ($collOrganizations as $obj) {
                            if (false == $this->collOrganizations->contains($obj)) {
                                $this->collOrganizations->append($obj);
                            }
                        }

                        $this->collOrganizationsPartial = true;
                    }

                    return $collOrganizations;
                }

                if ($partial && $this->collOrganizations) {
                    foreach ($this->collOrganizations as $obj) {
                        if ($obj->isNew()) {
                            $collOrganizations[] = $obj;
                        }
                    }
                }

                $this->collOrganizations = $collOrganizations;
                $this->collOrganizationsPartial = false;
            }
        }

        return $this->collOrganizations;
    }

    /**
     * Sets a collection of ChildOrganization objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $organizations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setOrganizations(Collection $organizations, ConnectionInterface $con = null)
    {
        /** @var ChildOrganization[] $organizationsToDelete */
        $organizationsToDelete = $this->getOrganizations(new Criteria(), $con)->diff($organizations);


        $this->organizationsScheduledForDeletion = $organizationsToDelete;

        foreach ($organizationsToDelete as $organizationRemoved) {
            $organizationRemoved->setUser(null);
        }

        $this->collOrganizations = null;
        foreach ($organizations as $organization) {
            $this->addOrganization($organization);
        }

        $this->collOrganizations = $organizations;
        $this->collOrganizationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Organization objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Organization objects.
     * @throws PropelException
     */
    public function countOrganizations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOrganizationsPartial && !$this->isNew();
        if (null === $this->collOrganizations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrganizations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrganizations());
            }

            $query = ChildOrganizationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collOrganizations);
    }

    /**
     * Method called to associate a ChildOrganization object to this object
     * through the ChildOrganization foreign key attribute.
     *
     * @param  ChildOrganization $l ChildOrganization
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function addOrganization(ChildOrganization $l)
    {
        if ($this->collOrganizations === null) {
            $this->initOrganizations();
            $this->collOrganizationsPartial = true;
        }

        if (!$this->collOrganizations->contains($l)) {
            $this->doAddOrganization($l);

            if ($this->organizationsScheduledForDeletion and $this->organizationsScheduledForDeletion->contains($l)) {
                $this->organizationsScheduledForDeletion->remove($this->organizationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildOrganization $organization The ChildOrganization object to add.
     */
    protected function doAddOrganization(ChildOrganization $organization)
    {
        $this->collOrganizations[]= $organization;
        $organization->setUser($this);
    }

    /**
     * @param  ChildOrganization $organization The ChildOrganization object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeOrganization(ChildOrganization $organization)
    {
        if ($this->getOrganizations()->contains($organization)) {
            $pos = $this->collOrganizations->search($organization);
            $this->collOrganizations->remove($pos);
            if (null === $this->organizationsScheduledForDeletion) {
                $this->organizationsScheduledForDeletion = clone $this->collOrganizations;
                $this->organizationsScheduledForDeletion->clear();
            }
            $this->organizationsScheduledForDeletion[]= clone $organization;
            $organization->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collPasses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPasses()
     */
    public function clearPasses()
    {
        $this->collPasses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPasses collection loaded partially.
     */
    public function resetPartialPasses($v = true)
    {
        $this->collPassesPartial = $v;
    }

    /**
     * Initializes the collPasses collection.
     *
     * By default this just sets the collPasses collection to an empty array (like clearcollPasses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPasses($overrideExisting = true)
    {
        if (null !== $this->collPasses && !$overrideExisting) {
            return;
        }

        $collectionClassName = PassTableMap::getTableMap()->getCollectionClassName();

        $this->collPasses = new $collectionClassName;
        $this->collPasses->setModel('\Classes\Pass');
    }

    /**
     * Gets an array of ChildPass objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPass[] List of ChildPass objects
     * @throws PropelException
     */
    public function getPasses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPassesPartial && !$this->isNew();
        if (null === $this->collPasses || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPasses) {
                    $this->initPasses();
                } else {
                    $collectionClassName = PassTableMap::getTableMap()->getCollectionClassName();

                    $collPasses = new $collectionClassName;
                    $collPasses->setModel('\Classes\Pass');

                    return $collPasses;
                }
            } else {
                $collPasses = ChildPassQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPassesPartial && count($collPasses)) {
                        $this->initPasses(false);

                        foreach ($collPasses as $obj) {
                            if (false == $this->collPasses->contains($obj)) {
                                $this->collPasses->append($obj);
                            }
                        }

                        $this->collPassesPartial = true;
                    }

                    return $collPasses;
                }

                if ($partial && $this->collPasses) {
                    foreach ($this->collPasses as $obj) {
                        if ($obj->isNew()) {
                            $collPasses[] = $obj;
                        }
                    }
                }

                $this->collPasses = $collPasses;
                $this->collPassesPartial = false;
            }
        }

        return $this->collPasses;
    }

    /**
     * Sets a collection of ChildPass objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $passes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPasses(Collection $passes, ConnectionInterface $con = null)
    {
        /** @var ChildPass[] $passesToDelete */
        $passesToDelete = $this->getPasses(new Criteria(), $con)->diff($passes);


        $this->passesScheduledForDeletion = $passesToDelete;

        foreach ($passesToDelete as $passRemoved) {
            $passRemoved->setUser(null);
        }

        $this->collPasses = null;
        foreach ($passes as $pass) {
            $this->addPass($pass);
        }

        $this->collPasses = $passes;
        $this->collPassesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pass objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pass objects.
     * @throws PropelException
     */
    public function countPasses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPassesPartial && !$this->isNew();
        if (null === $this->collPasses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPasses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPasses());
            }

            $query = ChildPassQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collPasses);
    }

    /**
     * Method called to associate a ChildPass object to this object
     * through the ChildPass foreign key attribute.
     *
     * @param  ChildPass $l ChildPass
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function addPass(ChildPass $l)
    {
        if ($this->collPasses === null) {
            $this->initPasses();
            $this->collPassesPartial = true;
        }

        if (!$this->collPasses->contains($l)) {
            $this->doAddPass($l);

            if ($this->passesScheduledForDeletion and $this->passesScheduledForDeletion->contains($l)) {
                $this->passesScheduledForDeletion->remove($this->passesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPass $pass The ChildPass object to add.
     */
    protected function doAddPass(ChildPass $pass)
    {
        $this->collPasses[]= $pass;
        $pass->setUser($this);
    }

    /**
     * @param  ChildPass $pass The ChildPass object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePass(ChildPass $pass)
    {
        if ($this->getPasses()->contains($pass)) {
            $pos = $this->collPasses->search($pass);
            $this->collPasses->remove($pos);
            if (null === $this->passesScheduledForDeletion) {
                $this->passesScheduledForDeletion = clone $this->collPasses;
                $this->passesScheduledForDeletion->clear();
            }
            $this->passesScheduledForDeletion[]= clone $pass;
            $pass->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collSubscribedEvents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSubscribedEvents()
     */
    public function clearSubscribedEvents()
    {
        $this->collSubscribedEvents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSubscribedEvents collection loaded partially.
     */
    public function resetPartialSubscribedEvents($v = true)
    {
        $this->collSubscribedEventsPartial = $v;
    }

    /**
     * Initializes the collSubscribedEvents collection.
     *
     * By default this just sets the collSubscribedEvents collection to an empty array (like clearcollSubscribedEvents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSubscribedEvents($overrideExisting = true)
    {
        if (null !== $this->collSubscribedEvents && !$overrideExisting) {
            return;
        }

        $collectionClassName = SubscribedEventTableMap::getTableMap()->getCollectionClassName();

        $this->collSubscribedEvents = new $collectionClassName;
        $this->collSubscribedEvents->setModel('\Classes\SubscribedEvent');
    }

    /**
     * Gets an array of ChildSubscribedEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSubscribedEvent[] List of ChildSubscribedEvent objects
     * @throws PropelException
     */
    public function getSubscribedEvents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSubscribedEventsPartial && !$this->isNew();
        if (null === $this->collSubscribedEvents || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSubscribedEvents) {
                    $this->initSubscribedEvents();
                } else {
                    $collectionClassName = SubscribedEventTableMap::getTableMap()->getCollectionClassName();

                    $collSubscribedEvents = new $collectionClassName;
                    $collSubscribedEvents->setModel('\Classes\SubscribedEvent');

                    return $collSubscribedEvents;
                }
            } else {
                $collSubscribedEvents = ChildSubscribedEventQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSubscribedEventsPartial && count($collSubscribedEvents)) {
                        $this->initSubscribedEvents(false);

                        foreach ($collSubscribedEvents as $obj) {
                            if (false == $this->collSubscribedEvents->contains($obj)) {
                                $this->collSubscribedEvents->append($obj);
                            }
                        }

                        $this->collSubscribedEventsPartial = true;
                    }

                    return $collSubscribedEvents;
                }

                if ($partial && $this->collSubscribedEvents) {
                    foreach ($this->collSubscribedEvents as $obj) {
                        if ($obj->isNew()) {
                            $collSubscribedEvents[] = $obj;
                        }
                    }
                }

                $this->collSubscribedEvents = $collSubscribedEvents;
                $this->collSubscribedEventsPartial = false;
            }
        }

        return $this->collSubscribedEvents;
    }

    /**
     * Sets a collection of ChildSubscribedEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $subscribedEvents A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setSubscribedEvents(Collection $subscribedEvents, ConnectionInterface $con = null)
    {
        /** @var ChildSubscribedEvent[] $subscribedEventsToDelete */
        $subscribedEventsToDelete = $this->getSubscribedEvents(new Criteria(), $con)->diff($subscribedEvents);


        $this->subscribedEventsScheduledForDeletion = $subscribedEventsToDelete;

        foreach ($subscribedEventsToDelete as $subscribedEventRemoved) {
            $subscribedEventRemoved->setUser(null);
        }

        $this->collSubscribedEvents = null;
        foreach ($subscribedEvents as $subscribedEvent) {
            $this->addSubscribedEvent($subscribedEvent);
        }

        $this->collSubscribedEvents = $subscribedEvents;
        $this->collSubscribedEventsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SubscribedEvent objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SubscribedEvent objects.
     * @throws PropelException
     */
    public function countSubscribedEvents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSubscribedEventsPartial && !$this->isNew();
        if (null === $this->collSubscribedEvents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSubscribedEvents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSubscribedEvents());
            }

            $query = ChildSubscribedEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collSubscribedEvents);
    }

    /**
     * Method called to associate a ChildSubscribedEvent object to this object
     * through the ChildSubscribedEvent foreign key attribute.
     *
     * @param  ChildSubscribedEvent $l ChildSubscribedEvent
     * @return $this|\Classes\User The current object (for fluent API support)
     */
    public function addSubscribedEvent(ChildSubscribedEvent $l)
    {
        if ($this->collSubscribedEvents === null) {
            $this->initSubscribedEvents();
            $this->collSubscribedEventsPartial = true;
        }

        if (!$this->collSubscribedEvents->contains($l)) {
            $this->doAddSubscribedEvent($l);

            if ($this->subscribedEventsScheduledForDeletion and $this->subscribedEventsScheduledForDeletion->contains($l)) {
                $this->subscribedEventsScheduledForDeletion->remove($this->subscribedEventsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSubscribedEvent $subscribedEvent The ChildSubscribedEvent object to add.
     */
    protected function doAddSubscribedEvent(ChildSubscribedEvent $subscribedEvent)
    {
        $this->collSubscribedEvents[]= $subscribedEvent;
        $subscribedEvent->setUser($this);
    }

    /**
     * @param  ChildSubscribedEvent $subscribedEvent The ChildSubscribedEvent object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeSubscribedEvent(ChildSubscribedEvent $subscribedEvent)
    {
        if ($this->getSubscribedEvents()->contains($subscribedEvent)) {
            $pos = $this->collSubscribedEvents->search($subscribedEvent);
            $this->collSubscribedEvents->remove($pos);
            if (null === $this->subscribedEventsScheduledForDeletion) {
                $this->subscribedEventsScheduledForDeletion = clone $this->collSubscribedEvents;
                $this->subscribedEventsScheduledForDeletion->clear();
            }
            $this->subscribedEventsScheduledForDeletion[]= clone $subscribedEvent;
            $subscribedEvent->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related SubscribedEvents from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSubscribedEvent[] List of ChildSubscribedEvent objects
     */
    public function getSubscribedEventsJoinEvent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubscribedEventQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getSubscribedEvents($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->username = null;
        $this->password = null;
        $this->email_addr = null;
        $this->role = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collBackgrounds) {
                foreach ($this->collBackgrounds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrganizations) {
                foreach ($this->collOrganizations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPasses) {
                foreach ($this->collPasses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSubscribedEvents) {
                foreach ($this->collSubscribedEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBackgrounds = null;
        $this->collOrganizations = null;
        $this->collPasses = null;
        $this->collSubscribedEvents = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
