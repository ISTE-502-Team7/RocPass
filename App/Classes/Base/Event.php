<?php

namespace Classes\Base;

use \DateTime;
use \Exception;
use \PDO;
use Classes\Event as ChildEvent;
use Classes\EventImage as ChildEventImage;
use Classes\EventImageQuery as ChildEventImageQuery;
use Classes\EventQuery as ChildEventQuery;
use Classes\SubscribedEvent as ChildSubscribedEvent;
use Classes\SubscribedEventQuery as ChildSubscribedEventQuery;
use Classes\Venue as ChildVenue;
use Classes\VenueQuery as ChildVenueQuery;
use Classes\Map\EventImageTableMap;
use Classes\Map\EventTableMap;
use Classes\Map\SubscribedEventTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'event' table.
 *
 *
 *
 * @package    propel.generator.Classes.Base
 */
abstract class Event implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Classes\\Map\\EventTableMap';


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
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the location field.
     *
     * @var        string
     */
    protected $location;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the start_date field.
     *
     * @var        DateTime
     */
    protected $start_date;

    /**
     * The value for the end_date field.
     *
     * @var        DateTime
     */
    protected $end_date;

    /**
     * The value for the venue_id field.
     *
     * @var        int
     */
    protected $venue_id;

    /**
     * @var        ChildVenue
     */
    protected $aVenue;

    /**
     * @var        ObjectCollection|ChildEventImage[] Collection to store aggregation of ChildEventImage objects.
     */
    protected $collEventImages;
    protected $collEventImagesPartial;

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
     * @var ObjectCollection|ChildEventImage[]
     */
    protected $eventImagesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSubscribedEvent[]
     */
    protected $subscribedEventsScheduledForDeletion = null;

    /**
     * Initializes internal state of Classes\Base\Event object.
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
     * Compares this with another <code>Event</code> instance.  If
     * <code>obj</code> is an instance of <code>Event</code>, delegates to
     * <code>equals(Event)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [location] column value.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [optionally formatted] temporal [start_date] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = null)
    {
        if ($format === null) {
            return $this->start_date;
        } else {
            return $this->start_date instanceof \DateTimeInterface ? $this->start_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_date] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndDate($format = null)
    {
        if ($format === null) {
            return $this->end_date;
        } else {
            return $this->end_date instanceof \DateTimeInterface ? $this->end_date->format($format) : null;
        }
    }

    /**
     * Get the [venue_id] column value.
     *
     * @return int
     */
    public function getVenueId()
    {
        return $this->venue_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EventTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v New value
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[EventTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [location] column.
     *
     * @param string $v New value
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setLocation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->location !== $v) {
            $this->location = $v;
            $this->modifiedColumns[EventTableMap::COL_LOCATION] = true;
        }

        return $this;
    } // setLocation()

    /**
     * Set the value of [description] column.
     *
     * @param string $v New value
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[EventTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->start_date->format("Y-m-d H:i:s.u")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [end_date] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_date !== null || $dt !== null) {
            if ($this->end_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->end_date->format("Y-m-d H:i:s.u")) {
                $this->end_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_END_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEndDate()

    /**
     * Set the value of [venue_id] column.
     *
     * @param int $v New value
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function setVenueId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->venue_id !== $v) {
            $this->venue_id = $v;
            $this->modifiedColumns[EventTableMap::COL_VENUE_ID] = true;
        }

        if ($this->aVenue !== null && $this->aVenue->getId() !== $v) {
            $this->aVenue = null;
        }

        return $this;
    } // setVenueId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EventTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EventTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EventTableMap::translateFieldName('Location', TableMap::TYPE_PHPNAME, $indexType)];
            $this->location = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EventTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EventTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EventTableMap::translateFieldName('EndDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->end_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EventTableMap::translateFieldName('VenueId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->venue_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = EventTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Classes\\Event'), 0, $e);
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
        if ($this->aVenue !== null && $this->venue_id !== $this->aVenue->getId()) {
            $this->aVenue = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aVenue = null;
            $this->collEventImages = null;

            $this->collSubscribedEvents = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Event::setDeleted()
     * @see Event::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
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
                EventTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aVenue !== null) {
                if ($this->aVenue->isModified() || $this->aVenue->isNew()) {
                    $affectedRows += $this->aVenue->save($con);
                }
                $this->setVenue($this->aVenue);
            }

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

            if ($this->eventImagesScheduledForDeletion !== null) {
                if (!$this->eventImagesScheduledForDeletion->isEmpty()) {
                    \Classes\EventImageQuery::create()
                        ->filterByPrimaryKeys($this->eventImagesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->eventImagesScheduledForDeletion = null;
                }
            }

            if ($this->collEventImages !== null) {
                foreach ($this->collEventImages as $referrerFK) {
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

        $this->modifiedColumns[EventTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(EventTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(EventTableMap::COL_LOCATION)) {
            $modifiedColumns[':p' . $index++]  = 'location';
        }
        if ($this->isColumnModified(EventTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(EventTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'start_date';
        }
        if ($this->isColumnModified(EventTableMap::COL_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'end_date';
        }
        if ($this->isColumnModified(EventTableMap::COL_VENUE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'venue_id';
        }

        $sql = sprintf(
            'INSERT INTO event (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'location':
                        $stmt->bindValue($identifier, $this->location, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'start_date':
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'end_date':
                        $stmt->bindValue($identifier, $this->end_date ? $this->end_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'venue_id':
                        $stmt->bindValue($identifier, $this->venue_id, PDO::PARAM_INT);
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
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getLocation();
                break;
            case 3:
                return $this->getDescription();
                break;
            case 4:
                return $this->getStartDate();
                break;
            case 5:
                return $this->getEndDate();
                break;
            case 6:
                return $this->getVenueId();
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

        if (isset($alreadyDumpedObjects['Event'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Event'][$this->hashCode()] = true;
        $keys = EventTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getLocation(),
            $keys[3] => $this->getDescription(),
            $keys[4] => $this->getStartDate(),
            $keys[5] => $this->getEndDate(),
            $keys[6] => $this->getVenueId(),
        );
        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aVenue) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'venue';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'venue';
                        break;
                    default:
                        $key = 'Venue';
                }

                $result[$key] = $this->aVenue->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collEventImages) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'eventImages';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'event_images';
                        break;
                    default:
                        $key = 'EventImages';
                }

                $result[$key] = $this->collEventImages->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Classes\Event
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Classes\Event
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setLocation($value);
                break;
            case 3:
                $this->setDescription($value);
                break;
            case 4:
                $this->setStartDate($value);
                break;
            case 5:
                $this->setEndDate($value);
                break;
            case 6:
                $this->setVenueId($value);
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
        $keys = EventTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLocation($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStartDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEndDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setVenueId($arr[$keys[6]]);
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
     * @return $this|\Classes\Event The current object, for fluid interface
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
        $criteria = new Criteria(EventTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventTableMap::COL_ID)) {
            $criteria->add(EventTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EventTableMap::COL_NAME)) {
            $criteria->add(EventTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(EventTableMap::COL_LOCATION)) {
            $criteria->add(EventTableMap::COL_LOCATION, $this->location);
        }
        if ($this->isColumnModified(EventTableMap::COL_DESCRIPTION)) {
            $criteria->add(EventTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(EventTableMap::COL_START_DATE)) {
            $criteria->add(EventTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(EventTableMap::COL_END_DATE)) {
            $criteria->add(EventTableMap::COL_END_DATE, $this->end_date);
        }
        if ($this->isColumnModified(EventTableMap::COL_VENUE_ID)) {
            $criteria->add(EventTableMap::COL_VENUE_ID, $this->venue_id);
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
        $criteria = ChildEventQuery::create();
        $criteria->add(EventTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Classes\Event (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setLocation($this->getLocation());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setEndDate($this->getEndDate());
        $copyObj->setVenueId($this->getVenueId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEventImages() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEventImage($relObj->copy($deepCopy));
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
     * @return \Classes\Event Clone of current object.
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
     * Declares an association between this object and a ChildVenue object.
     *
     * @param  ChildVenue $v
     * @return $this|\Classes\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVenue(ChildVenue $v = null)
    {
        if ($v === null) {
            $this->setVenueId(NULL);
        } else {
            $this->setVenueId($v->getId());
        }

        $this->aVenue = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVenue object, it will not be re-added.
        if ($v !== null) {
            $v->addEvent($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVenue object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildVenue The associated ChildVenue object.
     * @throws PropelException
     */
    public function getVenue(ConnectionInterface $con = null)
    {
        if ($this->aVenue === null && ($this->venue_id != 0)) {
            $this->aVenue = ChildVenueQuery::create()->findPk($this->venue_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVenue->addEvents($this);
             */
        }

        return $this->aVenue;
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
        if ('EventImage' === $relationName) {
            $this->initEventImages();
            return;
        }
        if ('SubscribedEvent' === $relationName) {
            $this->initSubscribedEvents();
            return;
        }
    }

    /**
     * Clears out the collEventImages collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventImages()
     */
    public function clearEventImages()
    {
        $this->collEventImages = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventImages collection loaded partially.
     */
    public function resetPartialEventImages($v = true)
    {
        $this->collEventImagesPartial = $v;
    }

    /**
     * Initializes the collEventImages collection.
     *
     * By default this just sets the collEventImages collection to an empty array (like clearcollEventImages());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventImages($overrideExisting = true)
    {
        if (null !== $this->collEventImages && !$overrideExisting) {
            return;
        }

        $collectionClassName = EventImageTableMap::getTableMap()->getCollectionClassName();

        $this->collEventImages = new $collectionClassName;
        $this->collEventImages->setModel('\Classes\EventImage');
    }

    /**
     * Gets an array of ChildEventImage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEventImage[] List of ChildEventImage objects
     * @throws PropelException
     */
    public function getEventImages(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventImagesPartial && !$this->isNew();
        if (null === $this->collEventImages || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collEventImages) {
                    $this->initEventImages();
                } else {
                    $collectionClassName = EventImageTableMap::getTableMap()->getCollectionClassName();

                    $collEventImages = new $collectionClassName;
                    $collEventImages->setModel('\Classes\EventImage');

                    return $collEventImages;
                }
            } else {
                $collEventImages = ChildEventImageQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventImagesPartial && count($collEventImages)) {
                        $this->initEventImages(false);

                        foreach ($collEventImages as $obj) {
                            if (false == $this->collEventImages->contains($obj)) {
                                $this->collEventImages->append($obj);
                            }
                        }

                        $this->collEventImagesPartial = true;
                    }

                    return $collEventImages;
                }

                if ($partial && $this->collEventImages) {
                    foreach ($this->collEventImages as $obj) {
                        if ($obj->isNew()) {
                            $collEventImages[] = $obj;
                        }
                    }
                }

                $this->collEventImages = $collEventImages;
                $this->collEventImagesPartial = false;
            }
        }

        return $this->collEventImages;
    }

    /**
     * Sets a collection of ChildEventImage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventImages A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setEventImages(Collection $eventImages, ConnectionInterface $con = null)
    {
        /** @var ChildEventImage[] $eventImagesToDelete */
        $eventImagesToDelete = $this->getEventImages(new Criteria(), $con)->diff($eventImages);


        $this->eventImagesScheduledForDeletion = $eventImagesToDelete;

        foreach ($eventImagesToDelete as $eventImageRemoved) {
            $eventImageRemoved->setEvent(null);
        }

        $this->collEventImages = null;
        foreach ($eventImages as $eventImage) {
            $this->addEventImage($eventImage);
        }

        $this->collEventImages = $eventImages;
        $this->collEventImagesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related EventImage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related EventImage objects.
     * @throws PropelException
     */
    public function countEventImages(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventImagesPartial && !$this->isNew();
        if (null === $this->collEventImages || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventImages) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventImages());
            }

            $query = ChildEventImageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collEventImages);
    }

    /**
     * Method called to associate a ChildEventImage object to this object
     * through the ChildEventImage foreign key attribute.
     *
     * @param  ChildEventImage $l ChildEventImage
     * @return $this|\Classes\Event The current object (for fluent API support)
     */
    public function addEventImage(ChildEventImage $l)
    {
        if ($this->collEventImages === null) {
            $this->initEventImages();
            $this->collEventImagesPartial = true;
        }

        if (!$this->collEventImages->contains($l)) {
            $this->doAddEventImage($l);

            if ($this->eventImagesScheduledForDeletion and $this->eventImagesScheduledForDeletion->contains($l)) {
                $this->eventImagesScheduledForDeletion->remove($this->eventImagesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEventImage $eventImage The ChildEventImage object to add.
     */
    protected function doAddEventImage(ChildEventImage $eventImage)
    {
        $this->collEventImages[]= $eventImage;
        $eventImage->setEvent($this);
    }

    /**
     * @param  ChildEventImage $eventImage The ChildEventImage object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeEventImage(ChildEventImage $eventImage)
    {
        if ($this->getEventImages()->contains($eventImage)) {
            $pos = $this->collEventImages->search($eventImage);
            $this->collEventImages->remove($pos);
            if (null === $this->eventImagesScheduledForDeletion) {
                $this->eventImagesScheduledForDeletion = clone $this->collEventImages;
                $this->eventImagesScheduledForDeletion->clear();
            }
            $this->eventImagesScheduledForDeletion[]= clone $eventImage;
            $eventImage->setEvent(null);
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
     * If this ChildEvent is new, it will return
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
                    ->filterByEvent($this)
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
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setSubscribedEvents(Collection $subscribedEvents, ConnectionInterface $con = null)
    {
        /** @var ChildSubscribedEvent[] $subscribedEventsToDelete */
        $subscribedEventsToDelete = $this->getSubscribedEvents(new Criteria(), $con)->diff($subscribedEvents);


        $this->subscribedEventsScheduledForDeletion = $subscribedEventsToDelete;

        foreach ($subscribedEventsToDelete as $subscribedEventRemoved) {
            $subscribedEventRemoved->setEvent(null);
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
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collSubscribedEvents);
    }

    /**
     * Method called to associate a ChildSubscribedEvent object to this object
     * through the ChildSubscribedEvent foreign key attribute.
     *
     * @param  ChildSubscribedEvent $l ChildSubscribedEvent
     * @return $this|\Classes\Event The current object (for fluent API support)
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
        $subscribedEvent->setEvent($this);
    }

    /**
     * @param  ChildSubscribedEvent $subscribedEvent The ChildSubscribedEvent object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
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
            $subscribedEvent->setEvent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related SubscribedEvents from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSubscribedEvent[] List of ChildSubscribedEvent objects
     */
    public function getSubscribedEventsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubscribedEventQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getSubscribedEvents($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aVenue) {
            $this->aVenue->removeEvent($this);
        }
        $this->id = null;
        $this->name = null;
        $this->location = null;
        $this->description = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->venue_id = null;
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
            if ($this->collEventImages) {
                foreach ($this->collEventImages as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSubscribedEvents) {
                foreach ($this->collSubscribedEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collEventImages = null;
        $this->collSubscribedEvents = null;
        $this->aVenue = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EventTableMap::DEFAULT_STRING_FORMAT);
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
