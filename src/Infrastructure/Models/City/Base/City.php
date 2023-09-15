<?php

namespace Traveler\Infrastructure\Models\City\Base;

use \Exception;
use \PDO;
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
use Traveler\Infrastructure\Models\City\City as ChildCity;
use Traveler\Infrastructure\Models\City\CityQuery as ChildCityQuery;
use Traveler\Infrastructure\Models\City\Map\CityTableMap;
use Traveler\Infrastructure\Models\Sight\Sight;
use Traveler\Infrastructure\Models\Sight\SightQuery;
use Traveler\Infrastructure\Models\Sight\Base\Sight as BaseSight;
use Traveler\Infrastructure\Models\Sight\Map\SightTableMap;
use Traveler\Infrastructure\Models\Traveler\Traveler;
use Traveler\Infrastructure\Models\Traveler\TravelerQuery;
use Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel;
use Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery;
use Traveler\Infrastructure\Models\TravelersCitiesRel\Base\TravelersCitiesRel as BaseTravelersCitiesRel;
use Traveler\Infrastructure\Models\TravelersCitiesRel\Map\TravelersCitiesRelTableMap;

/**
 * Base class that represents a row from the 'cities' table.
 *
 *
 *
 * @package    propel.generator.City.Base
 */
abstract class City implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Traveler\\Infrastructure\\Models\\City\\Map\\CityTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string|null
     */
    protected $name;

    /**
     * @var        ObjectCollection|Sight[] Collection to store aggregation of Sight objects.
     * @phpstan-var ObjectCollection&\Traversable<Sight> Collection to store aggregation of Sight objects.
     */
    protected $collSights;
    protected $collSightsPartial;

    /**
     * @var        ObjectCollection|TravelersCitiesRel[] Collection to store aggregation of TravelersCitiesRel objects.
     * @phpstan-var ObjectCollection&\Traversable<TravelersCitiesRel> Collection to store aggregation of TravelersCitiesRel objects.
     */
    protected $collTravelersCitiesRels;
    protected $collTravelersCitiesRelsPartial;

    /**
     * @var        ObjectCollection|Traveler[] Cross Collection to store aggregation of Traveler objects.
     * @phpstan-var ObjectCollection&\Traversable<Traveler> Cross Collection to store aggregation of Traveler objects.
     */
    protected $collTravelers;

    /**
     * @var bool
     */
    protected $collTravelersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Traveler[]
     * @phpstan-var ObjectCollection&\Traversable<Traveler>
     */
    protected $travelersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Sight[]
     * @phpstan-var ObjectCollection&\Traversable<Sight>
     */
    protected $sightsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|TravelersCitiesRel[]
     * @phpstan-var ObjectCollection&\Traversable<TravelersCitiesRel>
     */
    protected $travelersCitiesRelsScheduledForDeletion = null;

    /**
     * Initializes internal state of Traveler\Infrastructure\Models\City\Base\City object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>City</code> instance.  If
     * <code>obj</code> is an instance of <code>City</code>, delegates to
     * <code>equals(City)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
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
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
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
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
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
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CityTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [name] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CityTableMap::COL_NAME] = true;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CityTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = CityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Traveler\\Infrastructure\\Models\\City\\City'), 0, $e);
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
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSights = null;

            $this->collTravelersCitiesRels = null;

            $this->collTravelers = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see City::setDeleted()
     * @see City::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCityQuery::create()
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
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityTableMap::DATABASE_NAME);
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
                CityTableMap::addInstanceToPool($this);
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
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
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

            if ($this->travelersScheduledForDeletion !== null) {
                if (!$this->travelersScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->travelersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->travelersScheduledForDeletion = null;
                }

            }

            if ($this->collTravelers) {
                foreach ($this->collTravelers as $traveler) {
                    if (!$traveler->isDeleted() && ($traveler->isNew() || $traveler->isModified())) {
                        $traveler->save($con);
                    }
                }
            }


            if ($this->sightsScheduledForDeletion !== null) {
                if (!$this->sightsScheduledForDeletion->isEmpty()) {
                    \Traveler\Infrastructure\Models\Sight\SightQuery::create()
                        ->filterByPrimaryKeys($this->sightsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sightsScheduledForDeletion = null;
                }
            }

            if ($this->collSights !== null) {
                foreach ($this->collSights as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->travelersCitiesRelsScheduledForDeletion !== null) {
                if (!$this->travelersCitiesRelsScheduledForDeletion->isEmpty()) {
                    \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery::create()
                        ->filterByPrimaryKeys($this->travelersCitiesRelsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->travelersCitiesRelsScheduledForDeletion = null;
                }
            }

            if ($this->collTravelersCitiesRels !== null) {
                foreach ($this->collTravelersCitiesRels as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[CityTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CityTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CityTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }

        $sql = sprintf(
            'INSERT INTO `cities` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
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
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();

            case 1:
                return $this->getName();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['City'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['City'][$this->hashCode()] = true;
        $keys = CityTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSights) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sights';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sightss';
                        break;
                    default:
                        $key = 'Sights';
                }

                $result[$key] = $this->collSights->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTravelersCitiesRels) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'travelersCitiesRels';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'travelers_citiess';
                        break;
                    default:
                        $key = 'TravelersCitiesRels';
                }

                $result[$key] = $this->collTravelersCitiesRels->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
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
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CityTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }

        return $this;
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
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
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
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(CityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CityTableMap::COL_ID)) {
            $criteria->add(CityTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CityTableMap::COL_NAME)) {
            $criteria->add(CityTableMap::COL_NAME, $this->name);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildCityQuery::create();
        $criteria->add(CityTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
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
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Traveler\Infrastructure\Models\City\City (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSights() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSight($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTravelersCitiesRels() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTravelersCitiesRel($relObj->copy($deepCopy));
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
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Traveler\Infrastructure\Models\City\City Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
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
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('Sight' === $relationName) {
            $this->initSights();
            return;
        }
        if ('TravelersCitiesRel' === $relationName) {
            $this->initTravelersCitiesRels();
            return;
        }
    }

    /**
     * Clears out the collSights collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addSights()
     */
    public function clearSights()
    {
        $this->collSights = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collSights collection loaded partially.
     *
     * @return void
     */
    public function resetPartialSights($v = true): void
    {
        $this->collSightsPartial = $v;
    }

    /**
     * Initializes the collSights collection.
     *
     * By default this just sets the collSights collection to an empty array (like clearcollSights());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSights(bool $overrideExisting = true): void
    {
        if (null !== $this->collSights && !$overrideExisting) {
            return;
        }

        $collectionClassName = SightTableMap::getTableMap()->getCollectionClassName();

        $this->collSights = new $collectionClassName;
        $this->collSights->setModel('\Traveler\Infrastructure\Models\Sight\Sight');
    }

    /**
     * Gets an array of Sight objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|Sight[] List of Sight objects
     * @phpstan-return ObjectCollection&\Traversable<Sight> List of Sight objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getSights(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collSightsPartial && !$this->isNew();
        if (null === $this->collSights || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSights) {
                    $this->initSights();
                } else {
                    $collectionClassName = SightTableMap::getTableMap()->getCollectionClassName();

                    $collSights = new $collectionClassName;
                    $collSights->setModel('\Traveler\Infrastructure\Models\Sight\Sight');

                    return $collSights;
                }
            } else {
                $collSights = SightQuery::create(null, $criteria)
                    ->filterByCity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSightsPartial && count($collSights)) {
                        $this->initSights(false);

                        foreach ($collSights as $obj) {
                            if (false == $this->collSights->contains($obj)) {
                                $this->collSights->append($obj);
                            }
                        }

                        $this->collSightsPartial = true;
                    }

                    return $collSights;
                }

                if ($partial && $this->collSights) {
                    foreach ($this->collSights as $obj) {
                        if ($obj->isNew()) {
                            $collSights[] = $obj;
                        }
                    }
                }

                $this->collSights = $collSights;
                $this->collSightsPartial = false;
            }
        }

        return $this->collSights;
    }

    /**
     * Sets a collection of Sight objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $sights A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setSights(Collection $sights, ?ConnectionInterface $con = null)
    {
        /** @var Sight[] $sightsToDelete */
        $sightsToDelete = $this->getSights(new Criteria(), $con)->diff($sights);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sightsScheduledForDeletion = clone $sightsToDelete;

        foreach ($sightsToDelete as $sightRemoved) {
            $sightRemoved->setCity(null);
        }

        $this->collSights = null;
        foreach ($sights as $sight) {
            $this->addSight($sight);
        }

        $this->collSights = $sights;
        $this->collSightsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseSight objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related BaseSight objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countSights(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collSightsPartial && !$this->isNew();
        if (null === $this->collSights || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSights) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSights());
            }

            $query = SightQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCity($this)
                ->count($con);
        }

        return count($this->collSights);
    }

    /**
     * Method called to associate a Sight object to this object
     * through the Sight foreign key attribute.
     *
     * @param Sight $l Sight
     * @return $this The current object (for fluent API support)
     */
    public function addSight(Sight $l)
    {
        if ($this->collSights === null) {
            $this->initSights();
            $this->collSightsPartial = true;
        }

        if (!$this->collSights->contains($l)) {
            $this->doAddSight($l);

            if ($this->sightsScheduledForDeletion and $this->sightsScheduledForDeletion->contains($l)) {
                $this->sightsScheduledForDeletion->remove($this->sightsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param Sight $sight The Sight object to add.
     */
    protected function doAddSight(Sight $sight): void
    {
        $this->collSights[]= $sight;
        $sight->setCity($this);
    }

    /**
     * @param Sight $sight The Sight object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeSight(Sight $sight)
    {
        if ($this->getSights()->contains($sight)) {
            $pos = $this->collSights->search($sight);
            $this->collSights->remove($pos);
            if (null === $this->sightsScheduledForDeletion) {
                $this->sightsScheduledForDeletion = clone $this->collSights;
                $this->sightsScheduledForDeletion->clear();
            }
            $this->sightsScheduledForDeletion[]= clone $sight;
            $sight->setCity(null);
        }

        return $this;
    }

    /**
     * Clears out the collTravelersCitiesRels collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addTravelersCitiesRels()
     */
    public function clearTravelersCitiesRels()
    {
        $this->collTravelersCitiesRels = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collTravelersCitiesRels collection loaded partially.
     *
     * @return void
     */
    public function resetPartialTravelersCitiesRels($v = true): void
    {
        $this->collTravelersCitiesRelsPartial = $v;
    }

    /**
     * Initializes the collTravelersCitiesRels collection.
     *
     * By default this just sets the collTravelersCitiesRels collection to an empty array (like clearcollTravelersCitiesRels());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTravelersCitiesRels(bool $overrideExisting = true): void
    {
        if (null !== $this->collTravelersCitiesRels && !$overrideExisting) {
            return;
        }

        $collectionClassName = TravelersCitiesRelTableMap::getTableMap()->getCollectionClassName();

        $this->collTravelersCitiesRels = new $collectionClassName;
        $this->collTravelersCitiesRels->setModel('\Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel');
    }

    /**
     * Gets an array of TravelersCitiesRel objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|TravelersCitiesRel[] List of TravelersCitiesRel objects
     * @phpstan-return ObjectCollection&\Traversable<TravelersCitiesRel> List of TravelersCitiesRel objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getTravelersCitiesRels(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collTravelersCitiesRelsPartial && !$this->isNew();
        if (null === $this->collTravelersCitiesRels || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTravelersCitiesRels) {
                    $this->initTravelersCitiesRels();
                } else {
                    $collectionClassName = TravelersCitiesRelTableMap::getTableMap()->getCollectionClassName();

                    $collTravelersCitiesRels = new $collectionClassName;
                    $collTravelersCitiesRels->setModel('\Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel');

                    return $collTravelersCitiesRels;
                }
            } else {
                $collTravelersCitiesRels = TravelersCitiesRelQuery::create(null, $criteria)
                    ->filterByCity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTravelersCitiesRelsPartial && count($collTravelersCitiesRels)) {
                        $this->initTravelersCitiesRels(false);

                        foreach ($collTravelersCitiesRels as $obj) {
                            if (false == $this->collTravelersCitiesRels->contains($obj)) {
                                $this->collTravelersCitiesRels->append($obj);
                            }
                        }

                        $this->collTravelersCitiesRelsPartial = true;
                    }

                    return $collTravelersCitiesRels;
                }

                if ($partial && $this->collTravelersCitiesRels) {
                    foreach ($this->collTravelersCitiesRels as $obj) {
                        if ($obj->isNew()) {
                            $collTravelersCitiesRels[] = $obj;
                        }
                    }
                }

                $this->collTravelersCitiesRels = $collTravelersCitiesRels;
                $this->collTravelersCitiesRelsPartial = false;
            }
        }

        return $this->collTravelersCitiesRels;
    }

    /**
     * Sets a collection of TravelersCitiesRel objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $travelersCitiesRels A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setTravelersCitiesRels(Collection $travelersCitiesRels, ?ConnectionInterface $con = null)
    {
        /** @var TravelersCitiesRel[] $travelersCitiesRelsToDelete */
        $travelersCitiesRelsToDelete = $this->getTravelersCitiesRels(new Criteria(), $con)->diff($travelersCitiesRels);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->travelersCitiesRelsScheduledForDeletion = clone $travelersCitiesRelsToDelete;

        foreach ($travelersCitiesRelsToDelete as $travelersCitiesRelRemoved) {
            $travelersCitiesRelRemoved->setCity(null);
        }

        $this->collTravelersCitiesRels = null;
        foreach ($travelersCitiesRels as $travelersCitiesRel) {
            $this->addTravelersCitiesRel($travelersCitiesRel);
        }

        $this->collTravelersCitiesRels = $travelersCitiesRels;
        $this->collTravelersCitiesRelsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseTravelersCitiesRel objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related BaseTravelersCitiesRel objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countTravelersCitiesRels(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collTravelersCitiesRelsPartial && !$this->isNew();
        if (null === $this->collTravelersCitiesRels || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTravelersCitiesRels) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTravelersCitiesRels());
            }

            $query = TravelersCitiesRelQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCity($this)
                ->count($con);
        }

        return count($this->collTravelersCitiesRels);
    }

    /**
     * Method called to associate a TravelersCitiesRel object to this object
     * through the TravelersCitiesRel foreign key attribute.
     *
     * @param TravelersCitiesRel $l TravelersCitiesRel
     * @return $this The current object (for fluent API support)
     */
    public function addTravelersCitiesRel(TravelersCitiesRel $l)
    {
        if ($this->collTravelersCitiesRels === null) {
            $this->initTravelersCitiesRels();
            $this->collTravelersCitiesRelsPartial = true;
        }

        if (!$this->collTravelersCitiesRels->contains($l)) {
            $this->doAddTravelersCitiesRel($l);

            if ($this->travelersCitiesRelsScheduledForDeletion and $this->travelersCitiesRelsScheduledForDeletion->contains($l)) {
                $this->travelersCitiesRelsScheduledForDeletion->remove($this->travelersCitiesRelsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param TravelersCitiesRel $travelersCitiesRel The TravelersCitiesRel object to add.
     */
    protected function doAddTravelersCitiesRel(TravelersCitiesRel $travelersCitiesRel): void
    {
        $this->collTravelersCitiesRels[]= $travelersCitiesRel;
        $travelersCitiesRel->setCity($this);
    }

    /**
     * @param TravelersCitiesRel $travelersCitiesRel The TravelersCitiesRel object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeTravelersCitiesRel(TravelersCitiesRel $travelersCitiesRel)
    {
        if ($this->getTravelersCitiesRels()->contains($travelersCitiesRel)) {
            $pos = $this->collTravelersCitiesRels->search($travelersCitiesRel);
            $this->collTravelersCitiesRels->remove($pos);
            if (null === $this->travelersCitiesRelsScheduledForDeletion) {
                $this->travelersCitiesRelsScheduledForDeletion = clone $this->collTravelersCitiesRels;
                $this->travelersCitiesRelsScheduledForDeletion->clear();
            }
            $this->travelersCitiesRelsScheduledForDeletion[]= clone $travelersCitiesRel;
            $travelersCitiesRel->setCity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this City is new, it will return
     * an empty collection; or if this City has previously
     * been saved, it will retrieve related TravelersCitiesRels from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in City.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|TravelersCitiesRel[] List of TravelersCitiesRel objects
     * @phpstan-return ObjectCollection&\Traversable<TravelersCitiesRel}> List of TravelersCitiesRel objects
     */
    public function getTravelersCitiesRelsJoinTraveler(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = TravelersCitiesRelQuery::create(null, $criteria);
        $query->joinWith('Traveler', $joinBehavior);

        return $this->getTravelersCitiesRels($query, $con);
    }

    /**
     * Clears out the collTravelers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTravelers()
     */
    public function clearTravelers()
    {
        $this->collTravelers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTravelers crossRef collection.
     *
     * By default this just sets the collTravelers collection to an empty collection (like clearTravelers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTravelers()
    {
        $collectionClassName = TravelersCitiesRelTableMap::getTableMap()->getCollectionClassName();

        $this->collTravelers = new $collectionClassName;
        $this->collTravelersPartial = true;
        $this->collTravelers->setModel('\Traveler\Infrastructure\Models\Traveler\Traveler');
    }

    /**
     * Checks if the collTravelers collection is loaded.
     *
     * @return bool
     */
    public function isTravelersLoaded(): bool
    {
        return null !== $this->collTravelers;
    }

    /**
     * Gets a collection of Traveler objects related by a many-to-many relationship
     * to the current object by way of the travelers_cities cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|Traveler[] List of Traveler objects
     * @phpstan-return ObjectCollection&\Traversable<Traveler> List of Traveler objects
     */
    public function getTravelers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collTravelersPartial && !$this->isNew();
        if (null === $this->collTravelers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTravelers) {
                    $this->initTravelers();
                }
            } else {

                $query = TravelerQuery::create(null, $criteria)
                    ->filterByCity($this);
                $collTravelers = $query->find($con);
                if (null !== $criteria) {
                    return $collTravelers;
                }

                if ($partial && $this->collTravelers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTravelers as $obj) {
                        if (!$collTravelers->contains($obj)) {
                            $collTravelers[] = $obj;
                        }
                    }
                }

                $this->collTravelers = $collTravelers;
                $this->collTravelersPartial = false;
            }
        }

        return $this->collTravelers;
    }

    /**
     * Sets a collection of Traveler objects related by a many-to-many relationship
     * to the current object by way of the travelers_cities cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $travelers A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setTravelers(Collection $travelers, ?ConnectionInterface $con = null)
    {
        $this->clearTravelers();
        $currentTravelers = $this->getTravelers();

        $travelersScheduledForDeletion = $currentTravelers->diff($travelers);

        foreach ($travelersScheduledForDeletion as $toDelete) {
            $this->removeTraveler($toDelete);
        }

        foreach ($travelers as $traveler) {
            if (!$currentTravelers->contains($traveler)) {
                $this->doAddTraveler($traveler);
            }
        }

        $this->collTravelersPartial = false;
        $this->collTravelers = $travelers;

        return $this;
    }

    /**
     * Gets the number of Traveler objects related by a many-to-many relationship
     * to the current object by way of the travelers_cities cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Traveler objects
     */
    public function countTravelers(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collTravelersPartial && !$this->isNew();
        if (null === $this->collTravelers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTravelers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTravelers());
                }

                $query = TravelerQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByCity($this)
                    ->count($con);
            }
        } else {
            return count($this->collTravelers);
        }
    }

    /**
     * Associate a Traveler to this object
     * through the travelers_cities cross reference table.
     *
     * @param Traveler $traveler
     * @return ChildCity The current object (for fluent API support)
     */
    public function addTraveler(Traveler $traveler)
    {
        if ($this->collTravelers === null) {
            $this->initTravelers();
        }

        if (!$this->getTravelers()->contains($traveler)) {
            // only add it if the **same** object is not already associated
            $this->collTravelers->push($traveler);
            $this->doAddTraveler($traveler);
        }

        return $this;
    }

    /**
     *
     * @param Traveler $traveler
     */
    protected function doAddTraveler(Traveler $traveler)
    {
        $travelersCitiesRel = new TravelersCitiesRel();

        $travelersCitiesRel->setTraveler($traveler);

        $travelersCitiesRel->setCity($this);

        $this->addTravelersCitiesRel($travelersCitiesRel);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$traveler->isCitiesLoaded()) {
            $traveler->initCities();
            $traveler->getCities()->push($this);
        } elseif (!$traveler->getCities()->contains($this)) {
            $traveler->getCities()->push($this);
        }

    }

    /**
     * Remove traveler of this object
     * through the travelers_cities cross reference table.
     *
     * @param Traveler $traveler
     * @return ChildCity The current object (for fluent API support)
     */
    public function removeTraveler(Traveler $traveler)
    {
        if ($this->getTravelers()->contains($traveler)) {
            $travelersCitiesRel = new TravelersCitiesRel();
            $travelersCitiesRel->setTraveler($traveler);
            if ($traveler->isCitiesLoaded()) {
                //remove the back reference if available
                $traveler->getCities()->removeObject($this);
            }

            $travelersCitiesRel->setCity($this);
            $this->removeTravelersCitiesRel(clone $travelersCitiesRel);
            $travelersCitiesRel->clear();

            $this->collTravelers->remove($this->collTravelers->search($traveler));

            if (null === $this->travelersScheduledForDeletion) {
                $this->travelersScheduledForDeletion = clone $this->collTravelers;
                $this->travelersScheduledForDeletion->clear();
            }

            $this->travelersScheduledForDeletion->push($traveler);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collSights) {
                foreach ($this->collSights as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTravelersCitiesRels) {
                foreach ($this->collTravelersCitiesRels as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTravelers) {
                foreach ($this->collTravelers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSights = null;
        $this->collTravelersCitiesRels = null;
        $this->collTravelers = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CityTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
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
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
