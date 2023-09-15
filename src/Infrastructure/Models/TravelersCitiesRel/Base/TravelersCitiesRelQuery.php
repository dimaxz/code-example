<?php

namespace Traveler\Infrastructure\Models\TravelersCitiesRel\Base;

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
use Traveler\Infrastructure\Models\City\City;
use Traveler\Infrastructure\Models\Traveler\Traveler;
use Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRel as ChildTravelersCitiesRel;
use Traveler\Infrastructure\Models\TravelersCitiesRel\TravelersCitiesRelQuery as ChildTravelersCitiesRelQuery;
use Traveler\Infrastructure\Models\TravelersCitiesRel\Map\TravelersCitiesRelTableMap;

/**
 * Base class that represents a query for the 'travelers_cities' table.
 *
 *
 *
 * @method     ChildTravelersCitiesRelQuery orderByTravelerId($order = Criteria::ASC) Order by the traveler_id column
 * @method     ChildTravelersCitiesRelQuery orderByCityId($order = Criteria::ASC) Order by the city_id column
 *
 * @method     ChildTravelersCitiesRelQuery groupByTravelerId() Group by the traveler_id column
 * @method     ChildTravelersCitiesRelQuery groupByCityId() Group by the city_id column
 *
 * @method     ChildTravelersCitiesRelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTravelersCitiesRelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTravelersCitiesRelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTravelersCitiesRelQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTravelersCitiesRelQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTravelersCitiesRelQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTravelersCitiesRelQuery leftJoinTraveler($relationAlias = null) Adds a LEFT JOIN clause to the query using the Traveler relation
 * @method     ChildTravelersCitiesRelQuery rightJoinTraveler($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Traveler relation
 * @method     ChildTravelersCitiesRelQuery innerJoinTraveler($relationAlias = null) Adds a INNER JOIN clause to the query using the Traveler relation
 *
 * @method     ChildTravelersCitiesRelQuery joinWithTraveler($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Traveler relation
 *
 * @method     ChildTravelersCitiesRelQuery leftJoinWithTraveler() Adds a LEFT JOIN clause and with to the query using the Traveler relation
 * @method     ChildTravelersCitiesRelQuery rightJoinWithTraveler() Adds a RIGHT JOIN clause and with to the query using the Traveler relation
 * @method     ChildTravelersCitiesRelQuery innerJoinWithTraveler() Adds a INNER JOIN clause and with to the query using the Traveler relation
 *
 * @method     ChildTravelersCitiesRelQuery leftJoinCity($relationAlias = null) Adds a LEFT JOIN clause to the query using the City relation
 * @method     ChildTravelersCitiesRelQuery rightJoinCity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the City relation
 * @method     ChildTravelersCitiesRelQuery innerJoinCity($relationAlias = null) Adds a INNER JOIN clause to the query using the City relation
 *
 * @method     ChildTravelersCitiesRelQuery joinWithCity($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the City relation
 *
 * @method     ChildTravelersCitiesRelQuery leftJoinWithCity() Adds a LEFT JOIN clause and with to the query using the City relation
 * @method     ChildTravelersCitiesRelQuery rightJoinWithCity() Adds a RIGHT JOIN clause and with to the query using the City relation
 * @method     ChildTravelersCitiesRelQuery innerJoinWithCity() Adds a INNER JOIN clause and with to the query using the City relation
 *
 * @method     \Traveler\Infrastructure\Models\Traveler\TravelerQuery|\Traveler\Infrastructure\Models\City\CityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTravelersCitiesRel|null findOne(?ConnectionInterface $con = null) Return the first ChildTravelersCitiesRel matching the query
 * @method     ChildTravelersCitiesRel findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildTravelersCitiesRel matching the query, or a new ChildTravelersCitiesRel object populated from the query conditions when no match is found
 *
 * @method     ChildTravelersCitiesRel|null findOneByTravelerId(int $traveler_id) Return the first ChildTravelersCitiesRel filtered by the traveler_id column
 * @method     ChildTravelersCitiesRel|null findOneByCityId(int $city_id) Return the first ChildTravelersCitiesRel filtered by the city_id column *

 * @method     ChildTravelersCitiesRel requirePk($key, ?ConnectionInterface $con = null) Return the ChildTravelersCitiesRel by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTravelersCitiesRel requireOne(?ConnectionInterface $con = null) Return the first ChildTravelersCitiesRel matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTravelersCitiesRel requireOneByTravelerId(int $traveler_id) Return the first ChildTravelersCitiesRel filtered by the traveler_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTravelersCitiesRel requireOneByCityId(int $city_id) Return the first ChildTravelersCitiesRel filtered by the city_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTravelersCitiesRel[]|Collection find(?ConnectionInterface $con = null) Return ChildTravelersCitiesRel objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildTravelersCitiesRel> find(?ConnectionInterface $con = null) Return ChildTravelersCitiesRel objects based on current ModelCriteria
 * @method     ChildTravelersCitiesRel[]|Collection findByTravelerId(int $traveler_id) Return ChildTravelersCitiesRel objects filtered by the traveler_id column
 * @psalm-method Collection&\Traversable<ChildTravelersCitiesRel> findByTravelerId(int $traveler_id) Return ChildTravelersCitiesRel objects filtered by the traveler_id column
 * @method     ChildTravelersCitiesRel[]|Collection findByCityId(int $city_id) Return ChildTravelersCitiesRel objects filtered by the city_id column
 * @psalm-method Collection&\Traversable<ChildTravelersCitiesRel> findByCityId(int $city_id) Return ChildTravelersCitiesRel objects filtered by the city_id column
 * @method     ChildTravelersCitiesRel[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildTravelersCitiesRel> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TravelersCitiesRelQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Traveler\Infrastructure\Models\TravelersCitiesRel\Base\TravelersCitiesRelQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Traveler\\Infrastructure\\Models\\TravelersCitiesRel\\TravelersCitiesRel', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTravelersCitiesRelQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTravelersCitiesRelQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildTravelersCitiesRelQuery) {
            return $criteria;
        }
        $query = new ChildTravelersCitiesRelQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$traveler_id, $city_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTravelersCitiesRel|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TravelersCitiesRelTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TravelersCitiesRelTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildTravelersCitiesRel A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `traveler_id`, `city_id` FROM `travelers_cities` WHERE `traveler_id` = :p0 AND `city_id` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTravelersCitiesRel $obj */
            $obj = new ChildTravelersCitiesRel();
            $obj->hydrate($row);
            TravelersCitiesRelTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildTravelersCitiesRel|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
        $this->addUsingAlias(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(TravelersCitiesRelTableMap::COL_CITY_ID, $key[1], Criteria::EQUAL);

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
        if (empty($keys)) {
            $this->add(null, '1<>1', Criteria::CUSTOM);

            return $this;
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(TravelersCitiesRelTableMap::COL_CITY_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the traveler_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTravelerId(1234); // WHERE traveler_id = 1234
     * $query->filterByTravelerId(array(12, 34)); // WHERE traveler_id IN (12, 34)
     * $query->filterByTravelerId(array('min' => 12)); // WHERE traveler_id > 12
     * </code>
     *
     * @see       filterByTraveler()
     *
     * @param mixed $travelerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTravelerId($travelerId = null, ?string $comparison = null)
    {
        if (is_array($travelerId)) {
            $useMinMax = false;
            if (isset($travelerId['min'])) {
                $this->addUsingAlias(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $travelerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($travelerId['max'])) {
                $this->addUsingAlias(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $travelerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $travelerId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the city_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCityId(1234); // WHERE city_id = 1234
     * $query->filterByCityId(array(12, 34)); // WHERE city_id IN (12, 34)
     * $query->filterByCityId(array('min' => 12)); // WHERE city_id > 12
     * </code>
     *
     * @see       filterByCity()
     *
     * @param mixed $cityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCityId($cityId = null, ?string $comparison = null)
    {
        if (is_array($cityId)) {
            $useMinMax = false;
            if (isset($cityId['min'])) {
                $this->addUsingAlias(TravelersCitiesRelTableMap::COL_CITY_ID, $cityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cityId['max'])) {
                $this->addUsingAlias(TravelersCitiesRelTableMap::COL_CITY_ID, $cityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TravelersCitiesRelTableMap::COL_CITY_ID, $cityId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Traveler\Infrastructure\Models\Traveler\Traveler object
     *
     * @param \Traveler\Infrastructure\Models\Traveler\Traveler|ObjectCollection $traveler The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTraveler($traveler, ?string $comparison = null)
    {
        if ($traveler instanceof \Traveler\Infrastructure\Models\Traveler\Traveler) {
            return $this
                ->addUsingAlias(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $traveler->getId(), $comparison);
        } elseif ($traveler instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(TravelersCitiesRelTableMap::COL_TRAVELER_ID, $traveler->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByTraveler() only accepts arguments of type \Traveler\Infrastructure\Models\Traveler\Traveler or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Traveler relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinTraveler(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Traveler');

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
            $this->addJoinObject($join, 'Traveler');
        }

        return $this;
    }

    /**
     * Use the Traveler relation Traveler object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Traveler\Infrastructure\Models\Traveler\TravelerQuery A secondary query class using the current class as primary query
     */
    public function useTravelerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTraveler($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Traveler', '\Traveler\Infrastructure\Models\Traveler\TravelerQuery');
    }

    /**
     * Use the Traveler relation Traveler object
     *
     * @param callable(\Traveler\Infrastructure\Models\Traveler\TravelerQuery):\Traveler\Infrastructure\Models\Traveler\TravelerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTravelerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useTravelerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Traveler table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Traveler\Infrastructure\Models\Traveler\TravelerQuery The inner query object of the EXISTS statement
     */
    public function useTravelerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Traveler', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Traveler table for a NOT EXISTS query.
     *
     * @see useTravelerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Traveler\Infrastructure\Models\Traveler\TravelerQuery The inner query object of the NOT EXISTS statement
     */
    public function useTravelerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Traveler', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Traveler\Infrastructure\Models\City\City object
     *
     * @param \Traveler\Infrastructure\Models\City\City|ObjectCollection $city The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCity($city, ?string $comparison = null)
    {
        if ($city instanceof \Traveler\Infrastructure\Models\City\City) {
            return $this
                ->addUsingAlias(TravelersCitiesRelTableMap::COL_CITY_ID, $city->getId(), $comparison);
        } elseif ($city instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(TravelersCitiesRelTableMap::COL_CITY_ID, $city->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByCity() only accepts arguments of type \Traveler\Infrastructure\Models\City\City or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the City relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCity(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('City');

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
            $this->addJoinObject($join, 'City');
        }

        return $this;
    }

    /**
     * Use the City relation City object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Traveler\Infrastructure\Models\City\CityQuery A secondary query class using the current class as primary query
     */
    public function useCityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'City', '\Traveler\Infrastructure\Models\City\CityQuery');
    }

    /**
     * Use the City relation City object
     *
     * @param callable(\Traveler\Infrastructure\Models\City\CityQuery):\Traveler\Infrastructure\Models\City\CityQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCityQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCityQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to City table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Traveler\Infrastructure\Models\City\CityQuery The inner query object of the EXISTS statement
     */
    public function useCityExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('City', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to City table for a NOT EXISTS query.
     *
     * @see useCityExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Traveler\Infrastructure\Models\City\CityQuery The inner query object of the NOT EXISTS statement
     */
    public function useCityNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('City', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param ChildTravelersCitiesRel $travelersCitiesRel Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($travelersCitiesRel = null)
    {
        if ($travelersCitiesRel) {
            $this->addCond('pruneCond0', $this->getAliasedColName(TravelersCitiesRelTableMap::COL_TRAVELER_ID), $travelersCitiesRel->getTravelerId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(TravelersCitiesRelTableMap::COL_CITY_ID), $travelersCitiesRel->getCityId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the travelers_cities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TravelersCitiesRelTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TravelersCitiesRelTableMap::clearInstancePool();
            TravelersCitiesRelTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TravelersCitiesRelTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TravelersCitiesRelTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TravelersCitiesRelTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TravelersCitiesRelTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
