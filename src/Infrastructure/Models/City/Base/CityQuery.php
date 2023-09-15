<?php

namespace Traveler\Infrastructure\Models\City\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Traveler\Infrastructure\Models\City\City as ChildCity;
use Traveler\Infrastructure\Models\City\CityQuery as ChildCityQuery;
use Traveler\Infrastructure\Models\City\Map\CityTableMap;
use Traveler\Infrastructure\Models\Sight\Sight;
use Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel;

/**
 * Base class that represents a query for the 'cities' table.
 *
 *
 *
 * @method     ChildCityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCityQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildCityQuery groupById() Group by the id column
 * @method     ChildCityQuery groupByName() Group by the name column
 *
 * @method     ChildCityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCityQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCityQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCityQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCityQuery leftJoinSight($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sight relation
 * @method     ChildCityQuery rightJoinSight($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sight relation
 * @method     ChildCityQuery innerJoinSight($relationAlias = null) Adds a INNER JOIN clause to the query using the Sight relation
 *
 * @method     ChildCityQuery joinWithSight($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sight relation
 *
 * @method     ChildCityQuery leftJoinWithSight() Adds a LEFT JOIN clause and with to the query using the Sight relation
 * @method     ChildCityQuery rightJoinWithSight() Adds a RIGHT JOIN clause and with to the query using the Sight relation
 * @method     ChildCityQuery innerJoinWithSight() Adds a INNER JOIN clause and with to the query using the Sight relation
 *
 * @method     ChildCityQuery leftJoinTravelersCitiesRel($relationAlias = null) Adds a LEFT JOIN clause to the query using the TravelersCitiesRel relation
 * @method     ChildCityQuery rightJoinTravelersCitiesRel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TravelersCitiesRel relation
 * @method     ChildCityQuery innerJoinTravelersCitiesRel($relationAlias = null) Adds a INNER JOIN clause to the query using the TravelersCitiesRel relation
 *
 * @method     ChildCityQuery joinWithTravelersCitiesRel($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TravelersCitiesRel relation
 *
 * @method     ChildCityQuery leftJoinWithTravelersCitiesRel() Adds a LEFT JOIN clause and with to the query using the TravelersCitiesRel relation
 * @method     ChildCityQuery rightJoinWithTravelersCitiesRel() Adds a RIGHT JOIN clause and with to the query using the TravelersCitiesRel relation
 * @method     ChildCityQuery innerJoinWithTravelersCitiesRel() Adds a INNER JOIN clause and with to the query using the TravelersCitiesRel relation
 *
 * @method     \Traveler\Infrastructure\Models\Sight\SightQuery|\Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCity|null findOne(?ConnectionInterface $con = null) Return the first ChildCity matching the query
 * @method     ChildCity findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildCity matching the query, or a new ChildCity object populated from the query conditions when no match is found
 *
 * @method     ChildCity|null findOneById(int $id) Return the first ChildCity filtered by the id column
 * @method     ChildCity|null findOneByName(string $name) Return the first ChildCity filtered by the name column *

 * @method     ChildCity requirePk($key, ?ConnectionInterface $con = null) Return the ChildCity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCity requireOne(?ConnectionInterface $con = null) Return the first ChildCity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCity requireOneById(int $id) Return the first ChildCity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCity requireOneByName(string $name) Return the first ChildCity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCity[]|Collection find(?ConnectionInterface $con = null) Return ChildCity objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildCity> find(?ConnectionInterface $con = null) Return ChildCity objects based on current ModelCriteria
 * @method     ChildCity[]|Collection findById(int $id) Return ChildCity objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildCity> findById(int $id) Return ChildCity objects filtered by the id column
 * @method     ChildCity[]|Collection findByName(string $name) Return ChildCity objects filtered by the name column
 * @psalm-method Collection&\Traversable<ChildCity> findByName(string $name) Return ChildCity objects filtered by the name column
 * @method     ChildCity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildCity> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Traveler\Infrastructure\Models\City\Base\CityQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Traveler\\Infrastructure\\Models\\City\\City', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCityQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCityQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCityQuery) {
            return $criteria;
        }
        $query = new ChildCityQuery();
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
     * @return ChildCity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CityTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CityTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `name` FROM `cities` WHERE `id` = :p0';
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
            /** @var ChildCity $obj */
            $obj = new ChildCity();
            $obj->hydrate($row);
            CityTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildCity|array|mixed the result, formatted by the current formatter
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
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(CityTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(CityTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
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
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CityTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CityTableMap::COL_NAME, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Traveler\Infrastructure\Models\Sight\Sight object
     *
     * @param \Traveler\Infrastructure\Models\Sight\Sight|ObjectCollection $sight the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySight($sight, ?string $comparison = null)
    {
        if ($sight instanceof \Traveler\Infrastructure\Models\Sight\Sight) {
            $this
                ->addUsingAlias(CityTableMap::COL_ID, $sight->getcityId(), $comparison);

            return $this;
        } elseif ($sight instanceof ObjectCollection) {
            $this
                ->useSightQuery()
                ->filterByPrimaryKeys($sight->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterBySight() only accepts arguments of type \Traveler\Infrastructure\Models\Sight\Sight or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sight relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinSight(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sight');

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
            $this->addJoinObject($join, 'Sight');
        }

        return $this;
    }

    /**
     * Use the Sight relation Sight object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Traveler\Infrastructure\Models\Sight\SightQuery A secondary query class using the current class as primary query
     */
    public function useSightQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSight($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sight', '\Traveler\Infrastructure\Models\Sight\SightQuery');
    }

    /**
     * Use the Sight relation Sight object
     *
     * @param callable(\Traveler\Infrastructure\Models\Sight\SightQuery):\Traveler\Infrastructure\Models\Sight\SightQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withSightQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useSightQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Sight table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Traveler\Infrastructure\Models\Sight\SightQuery The inner query object of the EXISTS statement
     */
    public function useSightExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Sight', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Sight table for a NOT EXISTS query.
     *
     * @see useSightExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Traveler\Infrastructure\Models\Sight\SightQuery The inner query object of the NOT EXISTS statement
     */
    public function useSightNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Sight', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel object
     *
     * @param \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel|ObjectCollection $travelersCitiesRel the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTravelersCitiesRel($travelersCitiesRel, ?string $comparison = null)
    {
        if ($travelersCitiesRel instanceof \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel) {
            $this
                ->addUsingAlias(CityTableMap::COL_ID, $travelersCitiesRel->getCityId(), $comparison);

            return $this;
        } elseif ($travelersCitiesRel instanceof ObjectCollection) {
            $this
                ->useTravelersCitiesRelQuery()
                ->filterByPrimaryKeys($travelersCitiesRel->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByTravelersCitiesRel() only accepts arguments of type \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TravelersCitiesRel relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinTravelersCitiesRel(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TravelersCitiesRel');

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
            $this->addJoinObject($join, 'TravelersCitiesRel');
        }

        return $this;
    }

    /**
     * Use the TravelersCitiesRel relation TravelersCitiesRel object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery A secondary query class using the current class as primary query
     */
    public function useTravelersCitiesRelQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTravelersCitiesRel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TravelersCitiesRel', '\Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery');
    }

    /**
     * Use the TravelersCitiesRel relation TravelersCitiesRel object
     *
     * @param callable(\Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery):\Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTravelersCitiesRelQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useTravelersCitiesRelQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to TravelersCitiesRel table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery The inner query object of the EXISTS statement
     */
    public function useTravelersCitiesRelExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('TravelersCitiesRel', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to TravelersCitiesRel table for a NOT EXISTS query.
     *
     * @see useTravelersCitiesRelExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery The inner query object of the NOT EXISTS statement
     */
    public function useTravelersCitiesRelNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('TravelersCitiesRel', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related Traveler object
     * using the travelers_cities table as cross reference
     *
     * @param Traveler $traveler the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTraveler($traveler, string $comparison = Criteria::EQUAL)
    {
        $this
            ->useTravelersCitiesRelQuery()
            ->filterByTraveler($traveler, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildCity $city Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($city = null)
    {
        if ($city) {
            $this->addUsingAlias(CityTableMap::COL_ID, $city->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CityTableMap::clearInstancePool();
            CityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CityTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
